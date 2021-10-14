<?php get_header(); ?>

<div class="o-container u-margin-bottom-40">
    <div class="o-row">
        <div class="o-row__column o-row__column--span-12 o-row__column--span-<?php echo is_active_sidebar('primary-sidebar')?'8':'12';?>@medium">
            <main role="main">
                <!-- if has posts in WP Query -->
                <?php if (have_posts()) { ?>
                    <?php while (have_posts()) { ?>
                        <!-- !!!! initiate loop w/ the_post function -->
                        <?php the_post(); ?>
                         <article <?php post_class('c-post u-margin-bottom-20'); ?>>
                            <h2 class="c-post__title">
                                <!-- post title -->
                                <a
                                href="<?php the_permalink(); ?>"
                                title="<?php the_title_attribute(); ?>">
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
                    <?php } ?>
                    <h4>Posts Navigation</h4>
                    <?php the_posts_pagination(); ?>
                    <!-- custom hook -->
                    <?php do_action('_themename_after_pagination'); ?>
                <?php } else { ?>
                        <p><?php echo apply_filters(
                            '_themename_no_posts_text',
                            esc_html_e('Sorry, no posts', '_themename')
                        ); ?>
                        </p>
                <?php } ?>
            </main>
        </div>
        
             <!-- SIDEBAR -->
        <?php if(is_active_sidebar('primary-sidebar')){ ?>
        <div
            class="o-row__column o-row__column--span-12 o-row__column--span-4@medium"
            role="sidebar">
            <?php get_sidebar(); ?>
        </div>
        <?php }?>
    </div>
</div>


<?php get_footer(); ?>
