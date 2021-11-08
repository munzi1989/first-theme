<?php 

function _themename_register_menus(){
    register_nav_menus(array(
        'main-menu' => esc_html__('Main Menu', '_themename'),
        'footer-menu' => esc_html__('Footer Menu', '_themename')
    ));
}

add_action('init', '_themename_register_menus');

// THIS IS USED FOR DROPDOWN MENU FUNCTIONALITY. 
function _themename_dropdown_icon($title, $item, $args, $depth){
    if($args->theme_location == 'main-menu'){
        if(in_array('meni-item-has-children', $item->classes)){
            if($depth == 0){
                $title .= '<i class="fas fa-arrow-down" aria-hidden="true"></i>';
            } else {
                $title .= '<i class="fas fa-arrow-right" aria-hidden="true"></i>';
            }
        }
    }
    return $title;
}

add_filter('nav_menu_item_title', '_themename_dropdown_icon', 10, 4);