<?php
// Function to schedule the cron job
function greenwich_wp_schedule_cron()
{
    if (!wp_next_scheduled('greenwich_wp_daily_sync')) {
        wp_schedule_event(strtotime('today midnight'), 'daily', 'greenwich_wp_daily_sync');
    }
}

// Function to handle the cron job
function greenwich_wp_cron_sync()
{
    $result = greenwich_wp_sync_site_data();
    if (!$result['success']) {
        error_log('greenwich_wp Cron Sync Failed: ' . $result['message']);
    }
}

// Hook the cron handler to the cron event
add_action('greenwich_wp_daily_sync', 'greenwich_wp_cron_sync');

// Function to remove the cron job
function greenwich_wp_unschedule_cron()
{
    $timestamp = wp_next_scheduled('greenwich_wp_daily_sync');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'greenwich_wp_daily_sync');
    }
}

// Reschedule cron if it's missing (e.g., after manual wp-cron.php run)
add_action('wp', 'greenwich_wp_schedule_cron');

// Optional: Add a function to manually trigger the cron job (for testing)
function greenwich_wp_manual_cron_sync()
{
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    greenwich_wp_cron_sync();
    echo 'Cron sync completed.';
}
