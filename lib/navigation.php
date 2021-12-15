<?php

// register theme menu locations
function _themename_register_menus()
{
    register_nav_menus(array(
        'main-menu' => esc_html__('Main Menu', '_themename'),
        'footer-menu' => esc_html__('Footer Menu', '_themename'),
    ));
}
// init hook fires after wp finishes loading
add_action('init', '_themename_register_menus');

// if at mainmenu and items have children, add aria classes to use
// when opening menus
function _themename_aria_hasdropdown($atts, $item, $args)
{
    if ($args->theme_location == 'main-menu') {
        if (in_array('menu-item-has-children', $item->classes)) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }
    }
    return $atts;
}
// will filter for all nav-link-atts
add_filter('nav_menu_link_attributes', '_themename_aria_hasdropdown', 10, 3);



// create HTML button function w/ aria atts as needed. Angle icon direction = $dir
function _themename_submenu_button( $title, $dir = 'down')
{
    // add button HTML for screen reader accessibility to menu that has children
    $button = '<button class="menu-button">';
    $button .= '<span class="u-screen-reader-text menu-button-show">' . sprintf(esc_html__('Show %s submenu', '_themename'), $title) . '</span>';
    // aria-hidden removes elmt from accesibility tree
    $button .= '<span aria-hidden="true" class="u-screen-reader-text menu-button-hide">' . sprintf(esc_html__('Hide %s submenu', '_themename'), $title) . '</span>';
    $button .= '<i class="fa fa-angle-' . $dir . '" aria-hidden="true"></i>';
    $button .= '</button>';
    return $button;
}

// add above button to menu items if they have children, icon direction depends on depth
function _themename_dropdown_icon($title, $item, $args, $depth)
{
    if ($args->theme_location == 'main-menu') {
        if (in_array('menu-item-has-children', $item->classes)) {
            if ($depth == 0) {
                $title .= _themename_submenu_button($title, 'down');
            } else {
                $title .= _themename_submenu_button($title, 'right');
            }
        }
    }
    return $title;
}

add_filter('nav_menu_item_title', '_themename_dropdown_icon', 10, 4);
