<?php 
// ADD THEME SUPPORT HELP BROWSER INTERPERET HTML5
function _themename_theme_support(){
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-list', 'comment-form', 'gallery', 'caption'));
}

add_action('after_setup_theme', '_themename_theme_support');