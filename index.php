<?php
// index.php
/**
 * Plugin Name: Greenwich Maintenance
 * Plugin URI: https://www.greenwich_design.co.uk/
 * Description: Let Greenwich keep an eye on your site health and important updates. Please do not deactivate unless it is causing issues.
 * Version: 1
 * Author: Greenwich design
 * Author URI:https://www.greenwich_design.co.uk/
 */


// Schedule cron on plugin activation
register_activation_hook(__FILE__, 'greenwich_wp_schedule_cron');

// Unschedule cron on plugin deactivation
register_deactivation_hook(__FILE__, 'greenwich_wp_unschedule_cron');

$pluginpath = plugin_dir_path(__FILE__);
define('PLUGIN_PATH', $pluginpath);
include($pluginpath . '/user-auth.php');
include($pluginpath . '/health.php');
include($pluginpath . '/notion-connect.php');
include($pluginpath . '/admin-page.php');
include($pluginpath . '/updates.php');
include($pluginpath . '/cron.php');






