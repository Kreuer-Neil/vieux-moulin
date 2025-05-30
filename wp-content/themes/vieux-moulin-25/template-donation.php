<?php /* Template Name: Page "Dons" */ ?>

<?php get_header(); if (have_posts()): while (have_posts()): the_post(); ?>

<?php // TODO add QR code ici ?>

<?php get_template_part('components/content'); ?>



<section class="form form--donation" id="donate">
    <h2 class="form__title"><?= get_field('donation_title') ?></h2>
    <?php if ($donation_text = get_field('donation_text')): ?>
        <p class="form__text">
            <?= $donation_text ?>
        </p>
    <?php endif; ?>

    <form action="/">
        <fieldset class="form__container">
            <div class="form__items">
                <label for="amount">Montant</label>
                <input type="number" id="amount" placeholder="20"
                       class="form__input form__input--money">
            </div>
            <button type="button">Continuer avec Belfius Mobile</button>
            <button type="button">Payer par QR-Code</button>
            <button type="button">Continuer via paiement bancaire</button>
        </fieldset>
    </form>

</section>

<?php endwhile; endif; get_footer(); ?>
