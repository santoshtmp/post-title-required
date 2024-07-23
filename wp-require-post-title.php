<?php

/*
Plugin Name: WP Require Post Title
Plugin URI: https://github.com/santoshtmp/wp-require-post-title
Description: WP Require Post Title Plugin make the post title required field, also let the titl character limit. 
Version: 1.0.0
Author: santoshtmp
Author URI: https://github.com/santoshtmp
Requires WP: 6.5
Requires PHP: 7.4
Domain Path: languages
Text Domain: wp-require-post-title
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// include file
require_once dirname(__FILE__) . '/include/enqueue_scripts.php';
require_once dirname(__FILE__) . '/include/setting_page.php';
