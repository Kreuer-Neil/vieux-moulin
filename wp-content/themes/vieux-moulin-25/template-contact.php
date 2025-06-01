<?php /* Template Name: Page "Contact" */ ?>

<?php get_header();

if (have_posts()): while (have_posts()): the_post();

get_template_part('components/content'); ?>

<?php //TODO faire le contact form ?>

<?php endwhile; endif; get_footer(); ?>
