<?php
//Register Menu
function register_my_menu() {
	register_nav_menu( 'menu-header', __( 'Menu Header', 'menu-header' ) );
	register_nav_menu( 'menu-footer', __( 'Menu Footer', 'menu-footer' ) );
}
add_action( 'after_setup_theme', 'register_my_menu' );

//Remove Admin Bar in your theme
show_admin_bar(false);

//Add Theme Support Thumbnail
add_theme_support( 'post-thumbnails' );

//Register Widget Default
function wp_developer_theme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'wp-developer-theme' ),
		'id'            => 'sidebar-1',
		'description'   => __( ''),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wp_developer_theme_widgets_init' );

/**************************************************
 * Limite de caracteres para o exerpt só chamar o metodo
 * onde queira com o echo get_excerpt(120); o numero 
 * definq a quantidade de caracteres retornado.
 **************************************************/
function get_excerpt( $count ) {
    $excerpt = get_the_content();
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $count);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = $excerpt.'...';
    return $excerpt;
}

//ID Home ACF
function Home_id(){
    $IDh = get_option('page_on_front');
    return $IDh;
}
add_action('init', 'Home_id');

/**
 * Font Awesome Kit Setup
 */
if (! function_exists('fa_custom_setup_kit') ) {
	function fa_custom_setup_kit($kit_url = '') {
		foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
		add_action(
			$action,
			function () use ( $kit_url ) {
			wp_enqueue_script( 'font-awesome-kit', $kit_url, [], null );
			}
		);
		}
	}
}
fa_custom_setup_kit('https://kit.fontawesome.com/75d7e3da22.js');