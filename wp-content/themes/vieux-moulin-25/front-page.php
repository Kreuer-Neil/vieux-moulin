<?php get_header();
if (have_posts()): while (have_posts()): the_post();

    get_template_part('components/content');
    ?>


    <aside class="partnership content__container">
        <h2 class="partnership__title content__title"><?= get_field('partnerships_title') ?></h2>

        <?php if (have_rows('partnership_rows')) : ?>

            <ul class="partnership__container">
                <?php while (have_rows('partnership_rows')): the_row(); ?>
                    <li class="partnership__item">
                        <img title="<?= get_sub_field('name') ?>" src="<?= ($img = get_sub_field('image'))['url'] ?>"
                             alt="<?= $img['alt'] ?>" class="partnership__logo">
                    </li>

                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </aside>

<?php endwhile; endif;
get_footer(); ?>
