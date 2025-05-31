<?php get_header();

if (have_posts()): while (have_posts()): the_post(); ?>

<article class="content__container">
    <h2 class="content__title"><?= get_field('single_site_title') ?></h2>
    <p class="content__text content__text--center"><?= get_field('single_site_text_content') ?></p>
</article>

<?php if (have_rows('site_images')): ?>
        <div class="siteimg">
            <?php while (have_rows('site_images')): the_row();
                $img = get_sub_field('img'); ?>

                <article class="siteimg__container">
                    <h2 class="sro"><?= $title = get_sub_field('title') ?></h2>
                    <div class="siteimg__subcontainer">
                        <img src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>" class="siteimg__img"
                             width="650" height="360" title="<?= $title ?>">
                    </div>
                    <p class="siteimg__text"><?= get_sub_field('text_content') ?></p>
                </article>

            <?php endwhile; ?>
        </div>
    <?php endif; ?>

<?php endwhile; endif;
get_footer(); ?>
