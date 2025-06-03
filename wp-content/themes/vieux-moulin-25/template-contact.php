<?php /* Template Name: Page "Contact" */ ?>

<?php get_header();

if (have_posts()): while (have_posts()): the_post();

get_template_part('components/content'); ?>

    <?php
    $errors = $_SESSION['contact_form_errors'] ?? [];
    unset($_SESSION['contact_form_errors']);
    $success = $_SESSION['contact_form_success'] ?? false;
    unset($_SESSION['contact_form_success']);

    if($success): ?>
        <div class="contact__success">
            <p><?= $success; ?></p>
        </div>
    <?php else: ?>
        <form action="<?= admin_url('admin-post.php'); ?>" method="POST" class="form">
            <fieldset class="form__fields">
                <div class="field">
                    <label for="firstname" class="field__label">Prénom</label>
                    <input type="text" name="firstname" id="firstname" class="field__input">
                    <?php if(isset($errors['firstname'])): ?>
                        <p class="field__error"><?= $errors['firstname']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="lastname" class="field__label">Nom</label>
                    <input type="text" name="lastname" id="lastname" class="field__input">
                    <?php if(isset($errors['lastname'])): ?>
                        <p class="field__error"><?= $errors['lastname']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="email" class="field__label">Adresse mail</label>
                    <input type="email" name="email" id="email" class="field__input">
                    <?php if(isset($errors['email'])): ?>
                        <p class="field__error"><?= $errors['email']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="message" class="field__label">Message</label>
                    <textarea name="message" id="message" class="field__input"></textarea>
                    <?php if(isset($errors['message'])): ?>
                        <p class="field__error"><?= $errors['message']; ?></p>
                    <?php endif; ?>
                </div>
            </fieldset>
            <div class="form__submit">
                <?php
                // ce champ "hidden" permet à WP d'identifier la requête et de la transmettre
                // à notre fonction définie dans functions.php via "add_action('admin_post_[nom-action]')"
                ?>
                <input type="hidden" name="action" value="dw_submit_contact_form">
                <button type="submit" class="btn">Envoyer</button>
            </div>
        </form>
    <?php endif; ?>

<?php endwhile; endif; get_footer(); ?>
