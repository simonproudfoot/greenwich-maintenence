<?php
// Function to log update time
function greenwich-wp_log_update_time() {
    $current_time = current_time('mysql');
    update_option('greenwich-wp_last_update_time', $current_time);
}

// Hook for plugin updates
add_action('upgrader_process_complete', 'greenwich-wp_plugin_update_listener', 10, 2);

function greenwich-wp_plugin_update_listener($upgrader_object, $options) {
    if ($options['action'] == 'update' && $options['type'] == 'plugin') {
        greenwich-wp_log_update_time();
        greenwich-wp_sync_site_data();
    }
}

// Hook for core updates
add_action('_core_updated_successfully', 'greenwich-wp_core_update_listener');

function greenwich-wp_core_update_listener() {
    greenwich-wp_log_update_time();
    greenwich-wp_sync_site_data();
}

// Function to get the last update time
function get_last_update() {
    $last_update = get_option('greenwich-wp_last_update_time');
    if (!$last_update) {
        // If no update has been logged yet, return the current time
        return current_time('c');
    }
    // Convert the MySQL timestamp to ISO 8601 format
    return date('c', strtotime($last_update));
}


