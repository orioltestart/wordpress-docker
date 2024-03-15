<?php
// Desactivar wpemoji
add_action('init', function () {
    // Deshabilitar wpemoji
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    remove_action('wp_head', 'feed_links', 2); // Feed links
    remove_action('wp_head', 'feed_links_extra', 3); // Category feed links
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');

    remove_action('wp_head', 'print_embed_styles');
    remove_action('wp_head', 'print_oembed_styles');
    remove_action('wp_print_styles', 'print_media_styles');
    remove_action('wp_print_styles', 'print_admin_styles');
    remove_action('wp_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_head', 'wp_print_styles');

    // Quitar el enlace al endpoint api.w.org
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    // Quitar el estilo del editor clásico    
    remove_action('wp_head', 'classic_editor_add_customizer_css');

    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

    // Quitar los scripts emoji desde el editor de texto
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');

});

// Quitar los estilos del administrador cuando no se está autenticado
function remove_admin_styles_for_non_logged_users()
{
    if (!is_user_logged_in()) {
        // Desregistrarse de los estilos del administrador
        wp_deregister_style('wp-admin');
        wp_deregister_style('buttons');
        wp_deregister_style('wp-auth-check');
        wp_deregister_style('wp-color-picker');
        wp_deregister_style('admin-bar');
        wp_deregister_style('dashicons');
        wp_deregister_style('editor-buttons');
        wp_deregister_style('media-views');
        wp_deregister_style('wp-jquery-ui-dialog');

        // Desregistrarse de los estilos de los bloques de Gutenberg
        wp_deregister_style('wp-block-library');
        wp_deregister_style('wp-block-library-theme');
        
        wp_dequeue_style('classic-theme-styles');
    }
}
add_action('wp_enqueue_scripts', 'remove_admin_styles_for_non_logged_users', 999);


// Desactivar XML-RPC
add_filter('xmlrpc_enabled', '__return_false');


// Desactivar los feeds RSS2
function disable_rss2_feed()
{
    wp_die('Los feeds RSS2 están desactivados en este sitio.');
}
add_action('do_feed_rss2', 'disable_rss2_feed', 1);


function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}


// Deactivate jQuery
function deactivate_jquery() {
    wp_dequeue_script('jquery');
    wp_deregister_script('jquery');
}
add_action('wp_enqueue_scripts', 'deactivate_jquery');

function remove_customize_menu()
{
    global $submenu;
    unset($submenu['themes.php'][6]); // Remueve la opción del menú Personalizar
}
add_action('admin_menu', 'remove_customize_menu');


function remove_theme_editor_menu()
{
    remove_submenu_page('themes.php', 'theme-editor.php'); // Remueve la opción del menú Editor
}
add_action('admin_menu', 'remove_theme_editor_menu', 999);

function change_appearance_menu_title()
{
    global $menu;
    foreach ($menu as $key => $item) {
        if ($item[0] == 'Apariencia') {
            $menu[$key][0] = 'Temas'; // Cambia el título del menú "Apariencia" por "Temas"
            break;
        }
    }
}
add_action('admin_menu', 'change_appearance_menu_title');
