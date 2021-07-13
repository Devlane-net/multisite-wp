<?php
/**
* Plugin Name: Multisite multilang
* Description: Multilanguage features for WP Multisite
* Version: 1.0.0
* Author: Devlane
* GitHub Plugin URI: https://github.com/Devlane-net/multisite-wp
**/

defined('ABSPATH') || exit;

// Metabox for langpack identifier in posts
require_once plugin_dir_path(__FILE__).'inc/langpack-identifier-metabox-for-posts.php';

// Add hreflang in head
require_once plugin_dir_path(__FILE__).'inc/add-hreflang-in-head.php';