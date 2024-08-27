<?php
// Add admin menu
function greenwich-wp_add_admin_menu()
{
    add_menu_page(
        'greenwich-wp Settings',
        'greenwich-wp',
        'manage_options',
        'greenwich-wp',
        'greenwich-wp_options_page',
        'dashicons-database'
    );
}
add_action('admin_menu', 'greenwich-wp_add_admin_menu');

// Register settings
function greenwich-wp_register_settings()
{
    register_setting('greenwich-wp_options', 'greenwich-wp_key');
    register_setting('greenwich-wp_options', 'greenwich-wp_database_id');
    register_setting('greenwich-wp_options', 'greenwich-wp_api_version');
}
add_action('admin_init', 'greenwich-wp_register_settings');
// Create options page
function greenwich-wp_options_page()
{
    $plugin_url = plugin_dir_url(dirname(__FILE__));
    $logo_url = $plugin_url . 'notion-wp/assets/logo.svg';
?>
    <div class="wrap greenwich-wp-admin">
        <div class="greenwich-wp-container">
       
            <img src="<?php echo esc_url($logo_url); ?>" alt="greenwich-wp Logo" class="greenwich-wp-logo" />
            <div class="notice notice-info">
                <p><?php _e('<b>Welcome to greenwich-wp!</b> This plugin connects your WordPress site with Notion and syncs site data. Enter your Notion API key, database ID, and API version to get started. For full documentation, please read the setup guide in the Notion template.', 'greenwich-wp'); ?></p>
            </div>
            <?php
            // Display any existing admin notices
            settings_errors('greenwich-wp_messages');
            ?>
            <form id="greenwich-wp-connect-form" method="post" action="">
                <?php
                settings_fields('greenwich-wp_options');
                do_settings_sections('greenwich-wp_options');
                wp_nonce_field('greenwich-wp_connect', 'greenwich-wp_connect_nonce');
                ?>

           


                <div class="form-group">
                    <label for="greenwich-wp_key"><?php _e('Notion API Key', 'greenwich-wp'); ?></label>
                    <input type="text" id="greenwich-wp_key" name="greenwich-wp_key" value="<?php echo esc_attr(get_option('greenwich-wp_key')); ?>" class="regular-text" />
                </div>
                <div class="form-group">
                    <label for="greenwich-wp_database_id"><?php _e('Notion Database ID', 'greenwich-wp'); ?></label>
                    <input type="text" id="greenwich-wp_database_id" name="greenwich-wp_database_id" value="<?php echo esc_attr(get_option('greenwich-wp_database_id')); ?>" class="regular-text" />
                </div>
                <div class="form-group">
                    <label for="greenwich-wp_api_version"><?php _e('Notion API Version', 'greenwich-wp'); ?></label>
                    <input type="text" id="greenwich-wp_api_version" name="greenwich-wp_api_version" value="<?php echo esc_attr(get_option('greenwich-wp_api_version', '2022-06-28')); ?>" class="regular-text" />
                </div>
                <div class="submit-button-container">
                    <?php submit_button(__('Connect and Sync', 'greenwich-wp'), 'primary', 'greenwich-wp_connect', false); ?>
                    <span class="spinner" style="float: none; visibility: hidden;"></span>
                </div>
            </form>
            <div id="greenwich-wp-message" class="notice" style="display: none; margin-top: 20px;"></div>
        </div>
    </div>

    <style>
        .submit-button-container {
            display: flex;
            align-items: center;
        }

        .submit-button-container .spinner {
            margin-left: 10px;
        }
    </style>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#greenwich-wp-connect-form').on('submit', function(e) {
                e.preventDefault();
                var $form = $(this);
                var $submitButton = $form.find(':submit');
                var $spinner = $form.find('.spinner');
                var $message = $('#greenwich-wp-message');

                $submitButton.prop('disabled', true);
                $spinner.css('visibility', 'visible');
                $message.hide().removeClass('notice-success notice-error');

                var data = $form.serialize() + '&action=greenwich-wp_connect_and_sync';

                $.post(ajaxurl, data, function(response) {
                        console.log('AJAX Response:', response);

                        if (response.success) {
                            $message.addClass('notice-success').html('<p>' + response.data.message + '</p>').show();
                        } else {
                            $message.addClass('notice-error').html('<p>' + response.data.message + '</p>').show();
                            if (response.data.debug) {
                                console.error('Debug information:', response.data.debug);
                            }
                        }
                    })
                    .fail(function(xhr, status, error) {
                        console.error('AJAX request failed:', status, error);
                        console.log('XHR:', xhr.responseText);
                        $message.addClass('notice-error').html('<p>An error occurred while processing your request. Please check the console for more details.</p>').show();
                    })
                    .always(function() {
                        $submitButton.prop('disabled', false);
                        $spinner.css('visibility', 'hidden');
                    });
            });
        });
    </script>
<?php
}
// AJAX handler for connect and sync
function greenwich-wp_ajax_connect_and_sync()
{
    check_ajax_referer('greenwich-wp_connect', 'greenwich-wp_connect_nonce');

    $api_key = sanitize_text_field($_POST['greenwich-wp_key']);
    $database_id = sanitize_text_field($_POST['greenwich-wp_database_id']);
    $api_version = sanitize_text_field($_POST['greenwich-wp_api_version']);

    // Save the options
    update_option('greenwich-wp_key', $api_key);
    update_option('greenwich-wp_database_id', $database_id);
    update_option('greenwich-wp_api_version', $api_version);

    // Perform connection test and sync
    $connection_result = greenwich-wp_test_connection();
    if ($connection_result['success']) {
        $sync_result = greenwich-wp_sync_site_data();
        if ($sync_result['success']) {
            wp_send_json_success(array('message' => 'Connected and synced successfully.'));
        } else {
            wp_send_json_error(array('message' => 'Connection successful, but sync failed: ' . $sync_result['message'], 'debug' => $sync_result['debug']));
        }
    } else {
        wp_send_json_error(array('message' => 'Connection failed: ' . $connection_result['message']));
    }
}
add_action('wp_ajax_greenwich-wp_connect_and_sync', 'greenwich-wp_ajax_connect_and_sync');

// Enqueue admin styles
function greenwich-wp_enqueue_admin_styles($hook)
{
    if ('toplevel_page_greenwich-wp' !== $hook) {
        return;
    }
    wp_enqueue_style('greenwich-wp-admin-styles', plugin_dir_url(__FILE__) . 'css/admin-styles.css', array(), '1.0.0');
}
add_action('admin_enqueue_scripts', 'greenwich-wp_enqueue_admin_styles');

// Remove other plugin notices on greenwich-wp pages
function greenwich-wp_remove_notices()
{
    if (isset($_GET['page']) && $_GET['page'] === 'greenwich-wp') {
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
    }
}
add_action('admin_init', 'greenwich-wp_remove_notices');
