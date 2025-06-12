<?php /* Template Name: Page "Dons" */ ?>

<?php get_header();
if (have_posts()): while (have_posts()): the_post();

    $qr_code = get_field('donation_qr_code') ?>

    <img src="<?= $qr_code['url'] ?>" alt="<?= $qr_code['alt'] ?>" class="donation-qrcode">

    <?php get_template_part('components/content'); ?>

    <section class="donation" id="donate">
        <h2 class="form__title"><?= get_field('donation_title') ?></h2>
        <?php if ($donation_text = get_field('donation_text')): ?>
            <p class="form__text">
                <?= $donation_text ?>
            </p>
        <?php endif; ?>
        <div class="donation__container">
            <img src="<?= $qr_code['url'] ?>" alt="<?= $qr_code['alt'] ?>" class="donation__qrcode">
            <form action="/" class="form">
                <fieldset class="form__container">
                    <div class="field">
                        <label for="amount" class="field__label">Montant</label>
                        <input type="number" id="amount" placeholder="20"
                               class="field__input field__input--money">
                    </div>
                    <div class="form__container">
                        <button type="button" class="form__submit">Continuer avec Belfius Mobile</button>
                        <button type="button" class="form__submit">Payer par QR-Code</button>
                        <button type="button" class="form__submit">Continuer via paiement bancaire</button>
                    </div>
                </fieldset>
            </form>
        </div>

    </section>

<?php endwhile; endif;
get_footer(); ?>
