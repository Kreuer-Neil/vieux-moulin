<?php /* Template Name: Page "Articles" */
get_header();


if ($terms = get_terms('news_type')): // TODO Faire request en AJAX ?
    ?>
    <div class="filters">
        <p class="filters__title">Filtres</p>
        <ul class="filters__container">
            <li class="filters__li"><a href="?" class="filters__item">
                    Tous les articles
                </a></li>
            <?php foreach ($terms as $term): ?>
                <li class="filters__li"><a href="<?= '?type=' . $term->slug ?>" class="filters__item">
                        <?= $term->name ?>
                    </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?php
if ($hasType = isset($_GET['type']) || $hasSite = isset($_GET['site'])) {

    $type = (
    $hasType ? [
        'taxonomy' => 'news_type',
        'field' => 'slug',
        'terms' => [
            $_GET['type']
        ],
        'include_children' => true,
        'operator' => 'IN'
    ]
        : []
    );
    $site = (
    $hasSite ? [
        'taxonomy' => 'site',
        'field' => 'slug',
        'terms' => [
            $_GET['site']
        ],
        'include_children' => true,
        'operator' => 'IN'
    ]
        : []
    );

    $articles = new WP_Query([
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => '3',
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => [
            'relation' => 'AND',
            $type,
            $site,
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
    <div class="articles__container content__subcontainer--article">
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
<?php endif;

get_footer(); ?>
