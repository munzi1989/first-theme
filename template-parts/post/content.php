<article <?php post_class('c-post u-margin-bottom-20'); ?>>
    <h2 class="c-post__title">
        <!-- post title -->
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>
    <div class="c-post__meta">
        <!-- post details -->
        <?php _themename_post_meta(); ?>
    </div>
    <div class="c-post__excerpt">
        <!-- post summary -->
        <?php the_excerpt(); ?>
    </div>
    <!-- post readmore link -->
    <?php _themename_readmore_link(); ?>
</article>