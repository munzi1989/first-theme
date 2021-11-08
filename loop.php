<!-- if has posts in WP Query -->
<?php if (have_posts()) { ?>
    <?php while (have_posts()) { ?>
        <!-- !!!! iterate to next post w/ the_post function -->
        <?php the_post(); ?>
        <?php get_template_part('/template-parts/post/content') ?>
    <?php } ?>
    <h4>Posts Navigation</h4>
    <?php the_posts_pagination(); ?>
    <!-- custom hook -->
    <?php do_action('_themename_after_pagination'); ?>
<?php } else { ?>
    <?php get_template_part('/template-parts/post/content-none') ?>
<?php } ?>