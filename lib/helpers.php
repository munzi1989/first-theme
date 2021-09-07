<?php

// GET AND DISPLAY AUTHOR, SUMMARY AND DATE OF POST
function firsttheme_post_meta()
{

    printf(
        /*interpretor: %s is a variable for the date */
        esc_html__('Posted on %s', 'first-theme'),
        '<a href="' . esc_url(get_permalink()) . '"><time datetime="' . esc_attr(get_the_date('c')) .
        '">' . esc_html(get_the_date()) . '</time></a>'
    );

    printf(
        esc_html__(' By %s', 'first-theme'),
        '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>'
    );
}

function firsttheme_readmore_link()
{
    echo '<a href="' . esc_url(get_permalink()) . '"title="' . esc_attr(the_title_attribute(['echo' => false])) . '">';
    printf(
        wp_kses(
            __('Read More <span class="u-screen-reader-text">About %s</span>', 'first-theme'),
            [
                'span' => [
                    'class' => [],
                ],
            ]
        ),
        get_the_title()
    );
    echo '</a>';
}
