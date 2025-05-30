<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Kreuer Neil"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= wp_title('·', false, 'right') . get_bloginfo('name') ?></title>

    <?php wp_head() ?>
</head>
<body class="custom-theme">
<header>
    <h1><?= get_the_title() //TODO mettre page title ?></h1>

    <?php //TODO add arrows (a links with style)
    if (have_rows('slider')): ?>
        <section class="slider__container">
            <h2 class="sro"><?= 'Slider de la page ' . get_the_title() ?></h2>
            <article class="slider__item slider__item--mutiple">
                <?= get_the_post_thumbnail(size: 'medium', attr: ['width' => '960', 'height' => '1008', 'class' => 'slider__img']); ?>
                <div class="slider__subcontainer">
                    <h3 class="slider__title"><?= get_field('thumbnail_title') ?></h3>
                    <p class="slider__text"><?= get_field('thumbnail_text_content') ?></p>
                </div>
            </article>

            <?php while (have_rows('slider')): the_row();
                $image = get_sub_field('image') ?>
                <article class="slider__item slider__item--mutiple">
                    <img src="<?= $image['url'] ?>" alt="<?= $image['alt'] //TODO add SRCset  ?>" width="960"
                         height="1008" class="slider__img">
                    <div class="slider__subcontainer">
                        <h3 class="slider__title"><?= get_sub_field('title') ?></h3>
                        <p class="slider__text"><?= get_sub_field('text_content') ?></p>
                    </div>
                </article>
            <?php endwhile; ?>
        </section>

    <?php elseif(get_field('thumbnail_title')): ?>

        <article class="slider__item slider__item--single">
            <?= get_the_post_thumbnail(size: 'medium', attr: ['width' => '960', 'height' => '1008', 'class' => 'slider__img']); ?>
            <div class="slider__subcontainer">
                <h2 class="slider__title"><?= get_field('thumbnail_title') ?></h2>
                <p class="slider__text"><?= get_field('thumbnail_text_content') ?></p>
            </div>
        </article>

    <?php endif; ?>

</header>

<main id="main">
