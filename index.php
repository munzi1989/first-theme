<?php get_header();?>
        <!-- MAIN -->
<div class="o-container u-margin-bottom-40">
    <div class="o-row">
        <!-- resize based on sidebar active -->
        <div class="o-row__column o-row__column--span-12 o-row__column--span-<?php echo is_active_sidebar('primary-sidebar') ? '8' : '12'; ?>@medium">
        <!-- loop through posts -->
            <main role="main">
                <!-- return posts matching wp_query -->
                <?php get_template_part('loop');?>
            </main>
        </div>
             <!-- SIDEBAR -->
        <?php if (is_active_sidebar('primary-sidebar')) {?>
        <!-- if sidebar active, resize layout -->
            <div
            class="o-row__column o-row__column--span-12 o-row__column--span-4@medium"
            role="sidebar">
            <?php get_sidebar();?>
        </div>
        <?php }?>
    </div>
</div>
<!-- FOOTER -->
<?php get_footer();?>
