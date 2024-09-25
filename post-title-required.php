<?php

/*
Plugin Name: Post Title Required
Description: Post Title Required plugin purpose to make title require field and limit its character.
Contributors: younginnovations
Tags: Title, Required, Charcter Limit
Author: YIPL-santoshtmp
Requires WP: 6.5
Requires at least: 6.5
Tested up to: 6.6.1
Requires PHP: 7.0
Domain Path: languages
Text Domain: post-title-required
Stable tag: 1.0.0
Version: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// include file
require_once dirname(__FILE__) . '/include/enqueue_scripts.php';
require_once dirname(__FILE__) . '/include/setting_page.php';

// Hook into the plugin action links filter
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'ptreq_settings_link');
function ptreq_settings_link($links)
{
    // Create the settings link
    $settings_link = '<a href="options-general.php?page=post-title-required">Settings</a>';
    // Append the link to the existing links array
    array_unshift($links, $settings_link);
    return $links;
}
