<?php


// Charger les champs ACF exportés
include_once('fields.php');

// Vérifier si la session est active ("started") ?
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Disable Gutenberg on the back end.
add_filter('use_block_editor_for_post', '__return_false');
// Disable Gutenberg for widgets.
add_filter('use_widgets_block_editor', '__return_false');

// Remove WP toolbar
add_filter('show_admin_bar', '__return_false');


add_theme_support('custom-header');
add_theme_support('custom-footer');
add_theme_support('post-thumbnails');

// Remove base widht/height for thumbnail img
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3);

function remove_thumbnail_dimensions($html, $post_id, $post_image_id)
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}



// Enregistrer des menus de navigation :
register_nav_menu('main', 'Navigation principale, en-tête du site');
register_nav_menu('footer', 'Navigation de pied de page');
register_nav_menu('social', 'Liens de réseaux sociaux');

// Disable default front-end styles.
add_action('wp_enqueue_scripts', function () {
    // Remove CSS on the front end.
    wp_dequeue_style('wp-block-library');
    // Remove Gutenberg theme.
    wp_dequeue_style('wp-block-library-theme');
    // Remove inline global CSS on the front end.
    wp_dequeue_style('global-styles');
}, 20);


//importer le CSS et JS
$manifestPath = get_theme_file_path('public/.vite/manifest.json');

if (file_exists($manifestPath)) {
    $manifest = json_decode(file_get_contents($manifestPath), true);

    if (isset($manifest['wp-content/themes/vieux-moulin-25/resources/js/main.js'])) {
        wp_enqueue_script('vieux-moulin', get_theme_file_uri('public/' . $manifest['wp-content/themes/vieux-moulin-25/resources/js/main.js']['file']), [], null, true);
    }

    if (isset($manifest['wp-content/themes/vieux-moulin-25/resources/css/styles.scss'])) {
        wp_enqueue_style('vieux-moulin', get_theme_file_uri('public/' . $manifest['wp-content/themes/vieux-moulin-25/resources/css/styles.scss']['file']));
    }
}

// Activer l'utilisation des vignettes (image de couverture) sur nos post types:

// Enregistrer des menus de navigation :
register_nav_menu('main', 'Navigation principale, en-tête du site');
register_nav_menu('footer', 'Navigation de pied de page');

// Enregistrer de nouveaux "types de contenu", qui seront stockés dans la table
// "wp_posts", avec un identifiant de type spécifique dans la colonne "post_type":

register_post_type('site', [
    'labels' => [
        'name' => 'Sites/Maisons',
        'singular_name' => 'Site/Maison',
        ],
    'description' => 'Les différents sites (maisons) appartenant à la SRG du Vieux Moulin.',
    'public' => true,
    'hierarchical' => false,
    'has-archive' => true,
    'menu_position' => 21,
    'menu_icon' => 'dashicons-admin-home',
    'has_archive' => false,
    'rewrite' => [
        'slug' => 'sites',
    ],
    'supports' => ['title', 'excerpt', 'editor', 'thumbnail'],
]);

// Enregistrement de Taxonomies, afin de filtrer les posts selon leur contenu
register_taxonomy('site', ['post'], [
    'labels' => [
        'name' => 'Sites',
        'singular' => 'Site',
    ],
    'description' => 'L’appartenance d’articles à différents sites (maisons) appartenant à la SRG du Vieux Moulin.',
    'public' => true,
    'hierarchical' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_tagcloud' => false,
    'rewrite' => ['slug' => 'home-site'],
],
);

register_taxonomy('news_type', ['post'], [
    'labels' => [
        'name' => 'Types d’articles',
        'singular' => 'Type d’article'
    ],
    'description' => 'Pour différencier les articles de dons des articles sur les vacances, rénovations, ajouts de matériel, etc.',
    'public' => true,
    'hierarchical' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_tagcloud' => false,
    'rewrite' => ['slug' => 'news-type'],
],
);


// 2. Retrouver les éléments d'un menu pour une location donnée
function vm_get_navigation_links(string $location): array
{
    // Pour $location, retrouver le menu.
    $locations = get_nav_menu_locations();
    $menuId = $locations[$location] ?? null;

    // Au cas où il n'y a pas de menu assignés à $location, renvoyer un tableau de liens vide.
    if (is_null($menuId)) {
        return [];
    }

    // Pour ce menu, récupérer les liens
    $items = wp_get_nav_menu_items($menuId);

    // Formater les liens en objets pour ne garder que "URL" et "label" comme propriétés
    foreach ($items as $key => $item) {
        $items[$key] = new stdClass();
        $items[$key]->url = $item->url;
        $items[$key]->label = $item->title;
    }

    // Retourner le tableau de liens formatés
    return $items;
}



// Contact

// Ajouter un post-type custom pour sauvegarder les messages de contact
register_post_type('contact_message', [
    'label' => 'Messages de contact',
    'description' => 'Les envois de formulaire via la page de contact',
    'menu_position' => 10,
    'menu_icon' => 'dashicons-email',
    'public' => false,
    'show_ui' => true,
    'has_archive' => false,
    'supports' => ['title', 'editor'],
]);

// Ajouter la fonctionnalité "POST" pour un formulaire de contact personnalisé :
add_action('admin_post_vm_submit_contact_form', 'vm_handle_contact_form');
add_action('admin_post_nopriv_vm_submit_contact_form', 'vm_handle_contact_form');

// Get form handling class
require_once(__DIR__ . '/forms/ContactForm.php');

function vm_execute_contact_form()
{
    $config = [
        'nonce_field' => 'contact_nonce',
        'nonce_identifier' => 'vm_contact_form',
    ];
    (new forms\ContactForm($config, $_POST))
        ->sanitize([
            'lastname' => 'text_field',
            'firstname' => 'text_field',
            'email' => 'email',
            'message' => 'textarea_field',
        ])
        ->validate([
            'lastname' => ['required', 'short'],
            'firstname' => ['required', 'short'],
            'email' => ['required', 'email'],
            'message' => ['required'],
        ])->save(
            title: fn($data) => $data['lastname'] . $data['firstname'] . ' <' . $data['email'] . '>',
            content: fn($data) => $data['message'],
        )
        ->send(
            title: fn($data) => 'New message from ' . $data['lastname'] . $data['firstname'],
            content: fn($data
            ) => 'Name: ' . $data['lastname'] . $data['firstname'] . PHP_EOL . 'Email: ' . $data['email'] . PHP_EOL . 'Message:' . PHP_EOL . $data['message'],
        )
        ->feedback();
}

add_action('admin_post_nopriv_vm_contact_form', 'vm_execute_contact_form');
add_action('admin_post_vm_contact_form', 'vm_execute_contact_form');

function vm_session_flash(string $key, mixed $value): void
{
    if (!isset($_SESSION['vm_flash'])) {
        $_SESSION['vm_flash'] = [];
    }

    $_SESSION['vm_flash'][$key] = $value;
}

function vm_session_get(string $key)
{
    if (!(isset($_SESSION['vm_flash']) && array_key_exists($key, $_SESSION['vm_flash']))) {
        return null;
    }

    $value = $_SESSION['vm_flash'][$key];
    unset($_SESSION['vm_flash'][$key]);

    return $value;
}