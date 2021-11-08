<?php

function _themename_sidebar_widgets()
{
    // register sidebar with attributes in array
    register_sidebar(array(
        'id' => 'primary-sidebar',
        'name' => esc_html__('Primary Sidebar', '_themename'),
        'description' => esc_html__('This sidebar appears in the blog post page only.', '_themename'),
        // %1$s and %2$s are placeholders which will be swapped out with a id upon generation
        'before_widget' => '<section id="%1$s" class="c-sidebar-widget u-margin-bottom-20 $2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h5>',
        'after_title' => '</h5>'
    ));

    $footer_layout = '3,3,3,3';
    $columns = explode(',', $footer_layout);
    $footer_bg = 'dark';
    $widget_theme = '';
    if ($footer_bg == 'light') {
        $widget_theme = 'c-footer-widget--dark';
    } else {
        $widget_theme = 'c-footer-widget-light';
    }

    foreach ($columns as $i => $column) {
        register_sidebar(array(
            'id' => 'footer-sidebar-' . $i + 1,
            'name' => sprintf(esc_html__('Footer Widgets Column %s', '_themename'), $i + 1),
            'description' => esc_html__('Footer Widgets', '_themename'),
            // %1$s and %2$s are placeholders which will be swapped out with a id upon generation
            'before_widget' => '<section id="%1$s" class="c-footer-widget ' . $widget_theme . ' $2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h5>',
            'after_title' => '</h5>'
        ));
    }
}


add_action('widgets_init', '_themename_sidebar_widgets');
