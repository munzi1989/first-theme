<?php get_header();?>

<div class="o-container u-margin-bottom-40">
    <div class="o-row__column o-row__column--span-12">
        <header>
            <?php the_archive_title('<h1>', '</h1>') ?>
        </header>
</div>
<!--get_template WILL LOOK FOR FILE IN CHILD THEME FIRST, THEN PARENT THEME. DO NOT USE 'REQUIRE'  -->
<?php get_template_part('loop'); ?>

<?php get_footer();?>

