<?php
if (have_rows('main-content')): while (have_rows('main-content')):
    the_row();
    $rowType = get_sub_field('content_type'); ?>

    <?= '<' . ($sectionType = (($rowType === 'news' || $rowType === 'site') ? 'article' : 'section')) . ' class="content__container">' ?>

    <h2 class="content__title"><?= get_sub_field('title') ?></h2>
    <p class="content__text"><?= get_sub_field('text_content') ?></p>
    <?php if ($rowType === 'site'): ?>
    <div class="content__subcontainer content__subcontainer--site">

        <?php $sites = new WP_Query([
            'post_type' => 'site',
            'post_status' => 'publish',
//        'posts_per_page' => 6,
            'orderby' => 'date',
//        'order' => 'DESC',
        ]);
        if ($sites->have_posts()): while ($sites->have_posts()): $sites->the_post(); ?>
            <a href="<?= get_page_link() ?>" class="content__site__link">
                <article class="content__site">
                    <h3 class="content__site__title"><?= get_the_title() ?></h3>
                    <?= get_the_post_thumbnail(size: 'medium', attr: ['width' => '450px', 'height' => '500px', 'class' => 'content__site__img']) ?>
                </article>
            </a>
        <?php endwhile; endif; ?>
    </div>

<?php elseif ($rowType === 'cta_donation'): ?>
    <div class="content__subcontainer content__subcontainer--cta">
        <a title="À propos des dons" href="<?= '' // donations .'#about' ?>"
           class="cta cta--about">En savoir plus sur les dons</a>
        <a title="Aller vers la page de dons" href="<?= '' // donations .'#donate' ?>" class="cta">Donner</a>
    </div>
<?php endif; ?>

    <?= '</' . $sectionType . '>' ?>
<?php endwhile;
else: ?>
    <p id="empty">La page est vide.</p>
<?php endif; ?>