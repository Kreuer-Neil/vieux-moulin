<?php /* Template Name: Page "Contact" */ ?>

<?php get_header();

if (have_posts()): while (have_posts()): the_post();

    get_template_part('components/content');

    // Contact form component
    $errors = vm_session_get('vm_contact_form_errors') ?? [];
    $feedback = vm_session_get('vm_contact_form_feedback') ?? false;
    ?>

    <div class="contact" id="contact-form">
        <?php if ($feedback): ?>
            <p class="contact__success"><?= 'Formulaire envoyé avec succès&nbsp;!' ?></p>
        <?php endif ?>
        <form action="<?= esc_url(admin_url('admin-post.php')); ?>" method="POST" class="form">
            <fieldset class="contact__form form__container">
                <div class="field">
                    <label for="lastname" class="field__label">Nom</label>
                    <input type="text" name="lastname" id="lastname" class="field__input">
                    <?php if (isset($errors['lastname'])): ?>
                        <p class="field__error"><?= $errors['lastname']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="firstname" class="field__label">Prénom</label>
                    <input type="text" name="firstname" id="firstname" class="field__input">
                    <?php if (isset($errors['firstname'])): ?>
                        <p class="field__error"><?= $errors['firstname']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="email" class="field__label">Adresse mail</label>
                    <input type="email" name="email" id="email" class="field__input">
                    <?php if (isset($errors['email'])): ?>
                        <p class="field__error"><?= $errors['email']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="message" class="field__label">Message</label>
                    <textarea name="message" id="message" class="field__input"></textarea>
                    <?php if (isset($errors['message'])): ?>
                        <p class="field__error"><?= $errors['message']; ?></p>
                    <?php endif; ?>
                </div>
            </fieldset>
            <div class="form__container">
                <input type="hidden" name="action" value="vm_contact_form">
                <input type="hidden" name="contact_nonce"
                       value="<?= wp_create_nonce('vm_contact_form') ?>"/>
                <button type="submit" class="form__submit">Envoyer</button>
            </div>
        </form>
    </div>
<?php endwhile; endif;
get_footer(); ?>
