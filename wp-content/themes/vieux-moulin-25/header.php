<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= wp_title('·', false, 'right') . get_bloginfo('name') ?></title>
</head>
<body>
<header>
    <h1><?= get_bloginfo('name') ?></h1>
</header>
<?php $slider_rows = have_rows('slider');
if ($slider_rows): ?>
<div class="slider__container">
    <?php while($slider_rows): the_row() ?>
    <article class="slider__item slider__item--mutiple">
        <?= var_dump($image = get_sub_field('image')) ?>
        <img src="<?= $image['url'] ?>" alt="<?= $image['alt'] ?>" class="slider__img">
        <div class="slider__subcontainer">
            <h2 class="slider__title"><?= get_sub_field('title') ?></h2>
            <p class="slider__text"><?= get_sub_field('text_content') ?></p>
        </div>
    </article>
    <?php endwhile; ?>
</div>
<?php else:
    //TODO faire le single machin copié collé du précédent plus haut ?>

<?php endif; ?>
<main>
