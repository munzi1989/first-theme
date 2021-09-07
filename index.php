<?php get_header();?>

<!-- if has posts in WP Query -->
<?php if (have_posts()) {?>
    <?php while (have_posts()) {?>
        <!-- !!!! initiate loop w/ the_post function -->
        <?php the_post();?>
        <h2>
            <!-- post title -->
            <a
            href="<?php the_permalink();?>"
            title="<?php the_title_attribute();?>">
                <?php the_title();?>
            </a>
        </h2>
        <div>
            <!-- post details -->
            <?php firsttheme_post_meta()?>
        </div>
        <div>
            <!-- post summary -->
            <?php the_excerpt()?>
        </div>
        <!-- post readmore link -->
        <?php firsttheme_readmore_link()?>
    <?php }?>
    <h4>Posts Navigation</h4>
    <?php the_posts_pagination()?>
<?php } else {?>
    <p><?php _e('Sorry, no posts', 'first-theme')?></p>
<?php }?>

<?php
$city = 'london';

echo esc_html__('Your city is ', 'first-theme') . $city;

printf(
    esc_html__('Your city is %s', 'first-theme'),
    $city
);

?>
<br>

<?php get_footer();?>
