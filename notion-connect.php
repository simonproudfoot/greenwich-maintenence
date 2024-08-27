<?php

require_once(ABSPATH . 'wp-admin/includes/plugin.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/misc.php');

function greenwich-wp_connect_and_sync()
{
    $api_key = sanitize_text_field($_POST['greenwich-wp_key']);
    $database_id = sanitize_text_field($_POST['greenwich-wp_database_id']);
    $api_version = sanitize_text_field($_POST['greenwich-wp_api_version']);

    update_option('greenwich-wp_key', $api_key);
    update_option('greenwich-wp_database_id', $database_id);
    update_option('greenwich-wp_api_version', $api_version);

    if (empty($api_key) || empty($database_id) || empty($api_version)) {
        echo '<div class="notice notice-error"><p>Please fill in all the required fields.</p></div>';
        return;
    }

    // Test connection
    $connection = greenwich-wp_test_connection();
    if (!$connection['success']) {
        echo '<div class="notice notice-error"><p>' . esc_html($connection) . '</p></div>';
        return;
    }

    // Sync site data
    $sync_result = greenwich-wp_sync_site_data();


    if ($sync_result['success']) {
        echo '<div class="notice notice-success"><p>' . esc_html($sync_result) . '</p></div>';
    } else {
        echo '<div class="notice notice-error"><p>Failed to sync site data. Error details: ' . esc_html($sync_result['message']) . '</p></div>';
    }
}

function greenwich-wp_test_connection()
{
    $api_key = get_option('greenwich-wp_key');
    $database_id = get_option('greenwich-wp_database_id');
    $api_version = get_option('greenwich-wp_api_version');

    $url = "https://api.notion.com/v1/databases/{$database_id}";

    $response = wp_remote_get($url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Notion-Version' => $api_version,
        ),
    ));

    if (is_wp_error($response)) {
        return array('success' => false, 'message' => 'Connection failed: ' . $response->get_error_message());
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['object']) && $data['object'] === 'database') {
        return array('success' => true, 'message' => 'Connection successful');
    } else {
        return array('success' => false, 'message' => 'Connection failed. Please check your credentials.');
    }
}


function greenwich-wp_get_theme_screenshot_url()
{
    $theme = wp_get_theme();
    $screenshot = $theme->get_screenshot();
    return $screenshot ? $screenshot : '';
}


function greenwich-wp_sync_site_data()
{
    $api_key = get_option('greenwich-wp_key');
    $database_id = get_option('greenwich-wp_database_id');
    $api_version = get_option('greenwich-wp_api_version');

    // Ensure database schema is up to date
    $schema_result = greenwich-wp_ensure_database_schema();
    if (!$schema_result['success']) {
        return array('success' => false, 'message' => 'Schema update failed: ' . $schema_result['message'], 'debug' => $schema_result);
    }

    $site_url = get_site_url();
    $site_title = get_bloginfo('name');

    // Check if the site already exists in the database
    $existing_page = greenwich-wp_find_existing_page($site_title);
    $healthData = get_site_health_data();
    $screenshot_url = greenwich-wp_get_theme_screenshot_url();

    // Data to be sent to Notion
    $page_data = array(
        'Name' => array('title' => array(array('text' => array('content' => $site_title)))),
        'Site Health Score' => array('number' => $healthData->calculated->score / 100),
        'Site Health Status' => array('select' => array('name' => $healthData->calculated->status)),
        'Site URL' => array('url' => $site_url),
        'Core Update Available' => array('multi_select' => array(array('name' => greenwich-wp_is_core_update_available() ? 'Yes' : 'No'))),
        'Critical Issues' => array('number' => $healthData->issues->critical->count),
        'Recommended Improvements' => array('number' => $healthData->issues->recommended->count),
        'Plugin Updates' => array('number' => greenwich-wp_get_plugin_updates_count()),
        'Plugins Last Updated' => array('date' => array('start' => get_last_update())),
        'Last Checked' => array('date' => array('start' => current_time('c'))),
        'PHP Version' => array('rich_text' => array(array('text' => array('content' => phpversion())))),
        'Theme Screenshot' => array('files' => array(
            array(
                'name' => 'theme_screenshot.png',
                'type' => 'external',
                'external' => array('url' => $screenshot_url)
            )
        )),
    );

    if ($existing_page) {
        // Update existing page
        $url = "https://api.notion.com/v1/pages/{$existing_page}";
        $method = 'PATCH';
        $body = json_encode(array('properties' => $page_data));
    } else {
        // Create new page
        $url = "https://api.notion.com/v1/pages";
        $method = 'POST';
        $body = json_encode(array(
            'parent' => array('database_id' => $database_id),
            'properties' => $page_data,
        ));
    }

    $response = wp_remote_request($url, array(
        'method' => $method,
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Notion-Version' => $api_version,
            'Content-Type' => 'application/json',
        ),
        'body' => $body,
    ));

    if (is_wp_error($response)) {
        return array('success' => false, 'message' => 'Request failed: ' . $response->get_error_message(), 'debug' => $response);
    }

    $status_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);
    $data = json_decode($response_body, true);

    if ($status_code === 200) {
        if (isset($data['id'])) {
            return array('success' => true, 'message' => "Site data synced successfully. Page ID: " . $data['id']);
        } else {
            return array('success' => false, 'message' => 'Sync succeeded but no page ID returned.', 'debug' => $data);
        }
    } else {
        return array('success' => false, 'message' => 'Failed to sync site data. Status code: ' . $status_code, 'debug' => $data);
    }
}


function greenwich-wp_ensure_database_schema()
{
    $current_schema = greenwich-wp_get_database_schema();
    if ($current_schema === false) {
        return array('success' => false, 'message' => 'Failed to fetch current database schema');
    }

    $required_properties = array(
        'Site Health Status' => array('select' => array('options' => array(
            array('name' => 'Good', 'color' => 'green'),
            array('name' => 'Should be improved', 'color' => 'yellow'),
            array('name' => 'Needs improvement', 'color' => 'red')
        ))),
        'Site Health Score' => array('number' => array('format' => 'percent')),

        'Core Update Available' => array('multi_select' => array('options' => array(
            array('name' => 'Yes', 'color' => 'red'),
            array('name' => 'No', 'color' => 'green')
        ))),

        'Critical Issues' => (object) array('number' => (object) array()),
        'Recommended Improvements' => (object) array('number' => (object) array()),
        'Plugin Updates' => (object) array('number' => (object) array()),
        'Last Checked' => (object) array('date' => (object) array()),
        'Plugins Last Updated' => (object) array('date' => (object) array()),
        'Site URL' => (object) array('url' => (object) array()),
        'PHP Version' => array('rich_text' => (object) array()),
        'Theme Screenshot' => array('files' => (object) array()), // This is the correct way to define a files property
    );

    $properties_to_add = array();
    foreach ($required_properties as $name => $config) {
        if (!isset($current_schema[$name])) {
            $properties_to_add[$name] = $config;
        }
    }

    if (!empty($properties_to_add)) {
        return greenwich-wp_update_database_schema($properties_to_add);
    }

    return array('success' => true, 'message' => 'Database schema is up to date');
}




function greenwich-wp_get_database_schema()
{
    $api_key = get_option('greenwich-wp_key');
    $database_id = get_option('greenwich-wp_database_id');
    $api_version = get_option('greenwich-wp_api_version');

    $url = "https://api.notion.com/v1/databases/{$database_id}";

    $response = wp_remote_request($url, array(
        'method'  => 'GET',
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Notion-Version' => $api_version,
        ),
    ));

    if (is_wp_error($response)) {
        error_log('greenwich-wp Error: Failed to fetch database schema - ' . $response->get_error_message());
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['properties'])) {
        return $data['properties'];
    } else {
        error_log('greenwich-wp Error: Database schema not found in response - ' . print_r($data, true));
        return false;
    }
}
function greenwich-wp_update_database_schema($properties_to_add)
{
    $api_key = get_option('greenwich-wp_key');
    $database_id = get_option('greenwich-wp_database_id');
    $api_version = get_option('greenwich-wp_api_version');

    $url = "https://api.notion.com/v1/databases/{$database_id}";

    $response = wp_remote_request($url, array(
        'method' => 'PATCH',
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Notion-Version' => $api_version,
            'Content-Type' => 'application/json',
        ),
        'body' => json_encode(array('properties' => $properties_to_add)),
    ));

    if (is_wp_error($response)) {
        error_log('greenwich-wp Error: ' . $response->get_error_message());
        return array('success' => false, 'message' => 'Failed to update schema: ' . $response->get_error_message());
    }

    $status_code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    error_log('greenwich-wp Response: ' . print_r($data, true));

    if ($status_code === 200) {
        return array('success' => true, 'message' => 'Schema updated successfully.');
    } else {
        return array('success' => false, 'message' => 'Failed to update schema. Status code: ' . $status_code . '. Response: ' . print_r($data, true));
    }
}

function greenwich-wp_find_existing_page($domain)
{
    $api_key = get_option('greenwich-wp_key');
    $database_id = get_option('greenwich-wp_database_id');
    $api_version = get_option('greenwich-wp_api_version');

    $url = "https://api.notion.com/v1/databases/{$database_id}/query";

    $response = wp_remote_post($url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Notion-Version' => $api_version,
            'Content-Type' => 'application/json',
        ),
        'body' => json_encode(array(
            'filter' => array(
                'property' => 'Name',
                'title' => array(
                    'equals' => $domain,
                ),
            ),
        )),
    ));

    if (is_wp_error($response)) {
        return null;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['results']) && !empty($data['results'])) {
        return $data['results'][0]['id'];
    }

    return null;
}

function greenwich-wp_get_plugin_updates_count()
{
    if (!function_exists('get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    if (!function_exists('get_plugin_updates')) {
        require_once ABSPATH . 'wp-admin/includes/update.php';
    }
    $updates = get_plugin_updates();
    return count($updates);
}


function greenwich-wp_is_core_update_available()
{
    if (!function_exists('get_core_updates')) {
        require_once ABSPATH . 'wp-admin/includes/update.php';
    }
    $core_updates = get_core_updates();
    return !empty($core_updates) && $core_updates[0]->response == 'upgrade';
}



// Modify the greenwich-wp_manual_sync_handler function
function greenwich-wp_manual_sync_handler()
{
    check_ajax_referer('greenwich-wp_manual_sync', 'security');

    if (!current_user_can('manage_options')) {
        wp_send_json_error('You do not have permission to perform this action.');
    }

    // Log the manual sync as an update
    greenwich-wp_log_update_time();

    $result = greenwich-wp_sync_site_data();

    if ($result['success']) {
        wp_send_json_success($result['message']);
    } else {
        wp_send_json_error($result['message']);
    }
}
