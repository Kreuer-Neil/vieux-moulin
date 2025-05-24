<?php


//TODO Charger les champs ACF exportés
//include_once('fields.php');

// Disable Gutenberg on the back end.
add_filter('use_block_editor_for_post', '__return_false');
// Disable Gutenberg for widgets.
add_filter('use_widgets_block_editor', '__return_false');

// Remove WP toolbar
add_filter('show_admin_bar', '__return_false');


add_theme_support('custom-header');
add_theme_support('custom-footer');
add_theme_support('post-thumbnails');


// Enregistrer des menus de navigation :
register_nav_menu('main', 'Navigation principale, en-tête du site');
register_nav_menu('footer', 'Navigation de pied de page');

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
        wp_enqueue_script('dw', get_theme_file_uri('public/' . $manifest['wp-content/themes/vieux-moulin-25/resources/js/main.js']['file']), [], null, true);
    }

    if (isset($manifest['wp-content/themes/vieux-moulin-25/resources/css/styles.scss'])) {
        wp_enqueue_style('dw', get_theme_file_uri('public/' . $manifest['wp-content/themes/vieux-moulin-25/resources/css/styles.scss']['file']));
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

function dw_asset(string $file): string
{
    return get_template_directory_uri() . '/public/' . $file;
}

// 2. Retrouver les éléments d'un menu pour une location donnée
function dw_get_navigation_links(string $location): array
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