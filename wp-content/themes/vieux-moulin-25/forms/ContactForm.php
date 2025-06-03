<?php

namespace forms;

class ContactForm
{
    protected array $rules = [];
    protected array $sanitizers = [];

    public function __construct()
    {
    }

    public function rule(string $field, string $rule): static
    {
        if (!array_key_exists($field, $this->rules)) {
            $this->rules[$field] = [];
        }

        $this->rules[$field][] = $rule;

        return $this;
    }

    public function sanitize(string $field, string $callback): static
    {
        $this->sanitizers[$field] = $callback;

        return $this;
    }

    public function handle(array $data): void
    {
        // Valider les données envoyées.
        if (is_array($errors = $this->validate($data))) {
            // Mettre les erreurs de validation en session pour pouvoir les afficher sur la page suivante :
            $_SESSION['contact_form_errors'] = $errors;
            // Retourner à la page précédente pour afficher les erreurs de validation :
            wp_safe_redirect($_SERVER['HTTP_REFERER']);
            exit();
        }

        // Nettoyer les données.
        $data = $this->cleanData($data);

        // Sauvegarder le formulaire envoyé en base de données.
        wp_insert_post([
            'post_type' => 'contact_message',
            'post_title' => $data['firstname'] . ' ' . $data['lastname'],
            'post_content' => $this->generateEmailContent($data),
            'post_status' => 'publish',
        ]);

        // Envoyer un mail de notification.
        wp_mail(
            to: 'neil.kreuer@student.hepl.be',
            subject: 'Nouveau message de contact',
            message: $this->generateEmailContent($data),
        );

        // Retourner à la page précédente pour afficher un message de succès.
        // Mettre un message de succès en session pour pouvoir l'afficher sur la page suivante :
        $_SESSION['contact_form_success'] = 'Merci, ' . $data['firstname'] . ' ' . $data['lastname'] . '&nbsp;! Votre message a bien été envoyé.';
        // Retourner à la page précédente pour afficher les erreurs de validation :
        wp_safe_redirect($_SERVER['HTTP_REFERER']);
        exit();
    }

    protected function validate(array $data): bool|array
    {
        $errors = [];

        foreach ($this->rules as $field => $rules) {
            foreach ($rules as $rule) {
                $method = 'check_' . $rule;
                $validation = $this->$method($field, $data[$field] ?? null);
                if ($validation === true) continue;
                $errors[$field] = $validation;
                break;
            }
        }

        return $errors ?: true;
    }

    protected function check_required(string $field, mixed $value): bool|string
    {
        if ($value || $value == 0) {
            return true;
        }

        return 'Veuillez renseigner ce champ.';
    }

    protected function check_email(string $field, mixed $value): bool|string
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return 'Adresse invalide.';
    }

    protected function check_no_test(string $field, mixed $value): bool|string
    {
        if (!is_string($value)) {
            return true;
        }

        if (strpos($value, 'test') === false) {
            return true;
        }

        return 'Ce champ ne peut pas contenir le mot "test".';
    }

    protected function cleanData(array $data): array
    {
        $cleaned = [];

        foreach ($this->sanitizers as $field => $callback) {
            $cleaned[$field] = call_user_func($callback, $data[$field] ?? null);
        }

        return $cleaned;
    }

    protected function generateEmailContent(array $data): string
    {
        return 'Bonjour,' . PHP_EOL
            . 'Vous avez un nouveau message de ' . $data['firstname'] . ' ' . $data['lastname'] . '&nbsp;:' . PHP_EOL
            . $data['message'] . PHP_EOL . PHP_EOL
            . '----' . PHP_EOL
            . 'Adresse mail de l’expéditeur : ' . $data['email'];
    }

}






