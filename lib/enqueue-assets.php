<?php 

// function to add styles, scripts other assets to WP queue
function _themename_assets() {
    wp_enqueue_style('_themename-stylesheet', get_template_directory_uri() . '/dist/assets/css/bundle.css', array(), '1.0.0', 'all');
    // last prop "true" is to put script in footer : false = header
    wp_enqueue_script('_themename-scripts', get_template_directory_uri().'/dist/assets/js/bundle.js', array('jquery'), '1.0.0', true);
    // can also just use 'wp_enqueue_script('jquery')' to include core scripts/depends
}

// add action hook will add a fucntion to the script queue
add_action('wp_enqueue_scripts', '_themename_assets');

// same as above for admin
function _themename_admin_assets()
{
    wp_enqueue_style('_themename-admin-stylesheet', get_template_directory_uri() . '/dist/assets/css/admin.css', array(), '1.0.0', 'all');

    wp_enqueue_script('_themename-admin-scripts', get_template_directory_uri() . '/dist/assets/js/admin.js', array(), '1.0.0', true);
}

add_action('admin_enqueue_scripts', '_themename_admin_assets');
