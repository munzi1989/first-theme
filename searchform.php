<!-- NEED NAME AS 'S' FOR INPUT FOR WP TO USE TO FILTER RESULTS -->

<!-- BASIC SEARCH FORM -->
<!-- <form action="" role="search" method="GET">
    <input type="search" name="s" placeholder="" value="">
    <button type="submit">Search</button>
</form> -->


<form role="search" method="get" class="c-search-form" action="<?php echo esc_url(home_url('/')) ?>">
    <label class="c-search-form__label">
        <span class="screen-reader-text"><?php esc_html_x('Search for:', 'label', '_themename') ?></span>
            <input class="c-search-form__field" type="search" placeholder="<?php esc_attr_x('Search &hellip;', 'placeholder', '_themename') ?>" name='s' value="<?php echo esc_attr(get_search_query()) ?>" />
    </label>
    <button type="submit" class="c-search-form__button"> <i class="fas fa-search" aria-hidden="true"></i>
        <span class="u-screen-reader-text"><?php echo esc_html_x('Search', 'submit button', '_themename') ?></span>
    </button>
</form>

