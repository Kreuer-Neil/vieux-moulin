<?php
if (have_rows('main-content')): while (have_rows('main-content')):
    the_row();
    $rowType = get_sub_field('content_type'); ?>

    <?= '<' . ($sectionType = (($rowType === 'article' || $rowType === 'site') ? 'section' : 'article')) . ' ' . (get_sub_field('section_id') ?? '') . ' class="content__container">' ?>

    <h2 class="content__title"><?= get_sub_field('title') ?></h2>
    <p class="content__text"><?= get_sub_field('text_content') ?></p>


    <?php if ($rowType === 'site'): ?>
    <div class="content__subcontainer content__subcontainer--site">

        <?php $sites = new WP_Query([
            'post_type' => 'site',
            'post_status' => 'publish',
//        'posts_per_page' => 6,
            'orderby' => 'date',
        ]);
        if ($sites->have_posts()): while ($sites->have_posts()): $sites->the_post(); ?>
            <a href="<?= get_page_link() ?>" class="content__site__link">
                <article class="content__site">
                    <h3 class="content__site__title"><?= get_the_title() ?></h3>
                    <?= get_the_post_thumbnail(size: 'medium', attr: ['width' => '450', 'height' => '500', 'class' => 'content__site__img']) ?>
                </article>
            </a>
        <?php endwhile; endif; wp_reset_postdata(); ?>
    </div>


<?php elseif ($rowType === 'article'):

    if ($article_type = get_sub_field('article_type')) {
//            $articleTypes = get_the_terms(get_the_ID(), 'news_type');
        $articles = new WP_Query([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => '3',
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => [
                'relation' => 'AND',
                [
                    'taxonomy' => 'news_type',
                    'field' => 'slug',
                    'terms' => [
                        $article_type
                    ],
                    'include_children' => true,
                    'operator' => 'IN'
                ]
            ],
        ]);
    } else {
        $articles = new WP_Query([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => '3',
            'orderby' => 'date',
            'order' => 'DESC',

        ]);
    }

    if ($articles->have_posts()): ?>
        <div class="content__subcontainer content__subcontainer--article">

            <?php while ($articles->have_posts()): $articles->the_post(); ?>
                <a href="<?= get_page_link() ?>" class="content__article__link">
                    <article class="content__article">
                        <div class="content__article__subcontainer">
                            <h3 class="content__article__title"><?= get_the_title() ?></h3>
                            <p class="content__article__text"><?= get_field('article_thumbnail_text') ?></p>
                        </div>
                        <?= get_the_post_thumbnail(size: 'medium', attr: ['width' => '450', 'height' => '300', 'class' => 'content__article__img']) ?>
                    </article>
                </a>
            <?php endwhile; ?>

        </div>
        <a href="<?= '/articles' ?>" class="content__navlink" title="Vers la page des articles">Toutes les nouveautés</a>
    <?php else: ?>
        <p>Pas d’articles associés.</p>
    <?php endif; wp_reset_postdata(); ?>


<?php elseif ($rowType === 'cta_donation'): ?>
    <div class="content__subcontainer content__subcontainer--cta">
        <a title="À propos des dons" href="<?= get_permalink(68) . '#about' ?>"
           class="cta cta--about">En savoir plus</a>
        <a title="Aller vers la page de dons" href="<?= get_permalink('donate') . '#donate' ?>" class="cta">Donner</a>
    </div>
<?php elseif($rowType === 'image'):
    $rowImage = get_sub_field('img') ?>

    <img src="<?= $rowImage['url'] ?>" alt="<?= $rowImage['alt'] ?>" class="content__image">

<?php //TODO add container div + multiple img support maybe ?
endif; ?>

    <?= '</' . $sectionType . '>' ?>
<?php endwhile; endif; ?>
