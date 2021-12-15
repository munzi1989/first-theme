import $ from 'jquery';

$('.c-navigation').on('mouseenter', '.menu-item-has-children', (e) => {
    if (!$(e.currentTarget).parents('.sub-menu').length) {
        // if other menus are opened through screen-reader, close on mouse enter on other menus
        $('.menu > .menu-item.open').find('> a > .menu-button').trigger('click');
    }
    $(e.currentTarget).addClass('open');
}).on('mouseleave', '.menu-item-has-children', (e) => {
    $(e.currentTarget).removeClass('open');
})

$('.c-navigation').on('click', '.menu .menu-button', (e) => {
    // prevent default to stop href redirect
    e.preventDefault();
    e.stopPropagation();
    let menu_button = $(e.currentTarget);
    let menu_link = menu_button.parent();
    let menu_item = menu_link.parent();
    // close submenu if open
    if (menu_item.hasClass('open')) {
        // target any elements other than this current element that have open class and remove
        menu_item.add(menu_item.find('.menu-item.open')).removeClass('open');
        // change aria expanded to false
        menu_link.add(menu_item.find('a')).attr('aria-expanded', 'false');
        // switch aria text baed on open/closed menu
        menu_button.find('.menu-button-show').attr('aria-hidden', 'false');
        menu_button.find('.menu-button-hide').attr('aria-hidden', 'true');
    } else {
        // close sibling submenus if open, open current submenu - reverse all done above
        menu_item.siblings('.open').find('>a>.menu-button').trigger('click');
        menu_item.addClass('open');
        menu_link.attr('aria-expanded', 'true');
        menu_button.find('.menu-button-show').attr('aria-hidden', 'true');
        menu_button.find('.menu-button-hide').attr('aria-hidden', 'false');
    }
});

// close menus if clicking on screen
$(document).on('click', (e) => {
    if ($('.menu-item.open').length) {
        $('.menu > .menu-item.open > a > .menu-button').trigger('click');
    }
});
