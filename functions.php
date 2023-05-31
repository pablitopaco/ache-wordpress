<?php
/**
 * WP Developer Theme
 *
 * @package WordPress
 * @subpackage wp-developer-theme
 * @since Wp developer Theme 1.0
 */

//DEFINE PATH
define( 'PATH', get_template_directory() . '/' );

// Define INC
define( 'INC', PATH . 'inc/' );

// Include the customizer functionality
require_once INC . 'customizer.php';

//Include the enqueues
require_once INC . 'enqueues.php';

//Include the theme_functions
require_once INC . 'theme_functions.php';

//Include the theme_functions
require_once INC . 'theme_actions.php';

//Disable Editor of file for Security
define( 'DISALLOW_FILE_EDIT', true );

//Disable Print Wordpress Version for Security
remove_action('wp_head', 'wp_generator');
//Insert Generic Login and Password for Security
function generic_error_msgs()
{ 
   //insert how many msgs you want as an array item. it will be shown randomly 
	$custom_error_msgs = array(
		'Login e/ou senha inválido',
	);
  //get random array item to show
	return $custom_error_msgs[array_rand($custom_error_msgs)];;
}
add_filter('login_errors', 'generic_error_msgs');

// Removendo a custom-post do painel 
function hide_custom_by_role() {
    

	$current_user = wp_get_current_user();
	$role_user = '';
	if ( ! empty( $current_user->roles ) && is_array( $current_user->roles ) ) {
		foreach ( $current_user->roles as $role )
			$role_user = $role;
	}

	if ($role_user == 'paciente') {
		
		// REMOVE CUSTOM POSTS SAUDE E VENDAS
		$post_saude = 'squad_saude';
		$post_vendas = 'squad_vendas';
		$post_landpage = 'landpages-saude';
		// Substitua "role_name" pelo nome da role que deseja ocultar o post type personalizado do menu
		$role_name = 'paciente';
		$role = get_role($role_name);
		// Verifica se a role existe
		if ($role !== null) {
			global $menu;
			$menu_post = 'edit.php';
			$menu_saude = 'edit.php?post_type=' . $post_saude;
			$menu_vendas = 'edit.php?post_type=' . $post_vendas;
			$menu_landpage = 'edit.php?post_type=' . $post_landpage;
			// Loop através dos itens de menu
			foreach ($menu as $index => $item) {
	
				if ($item[2] == $menu_landpage) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}

				if ($item[2] == $menu_post) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}
				
				if ($item[2] == $menu_saude) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}
	
				if ($item[2] == $menu_vendas) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}
			}
		}
	}

	if ($role_user == 'vendas') {
		
		// REMOVE CUSTOM POSTS SAUDE E PACIENTES
		$post_saude = 'squad_saude';
		$post_pacientes = 'squad_pacientes';
		$post_landpage = 'landpages-saude';
		// Substitua "role_name" pelo nome da role que deseja ocultar o post type personalizado do menu
		$role_name = 'vendas';
		$role = get_role($role_name);
		// Verifica se a role existe
		if ($role !== null) {
			global $menu;
			$menu_post = 'edit.php';
			$menu_saude = 'edit.php?post_type=' . $post_saude;
			$menu_pacientes = 'edit.php?post_type=' . $post_pacientes;
			$menu_landpage = 'edit.php?post_type=' . $post_landpage;
			// Loop através dos itens de menu
			foreach ($menu as $index => $item) {

				if ($item[2] == $menu_landpage) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}
	
				if ($item[2] == $menu_post) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}
				
				if ($item[2] == $menu_saude) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}
	
				if ($item[2] == $menu_pacientes) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}
			}
		}
	}

	if ($role_user == 'saude') {
		
		// REMOVE CUSTOM POSTS VENDAS E PACIENTES
		$post_vendas = 'squad_vendas';
		$post_pacientes = 'squad_pacientes';
		// Substitua "role_name" pelo nome da role que deseja ocultar o post type personalizado do menu
		$role_name = 'vendas';
		$role = get_role($role_name);
		// Verifica se a role existe
		if ($role !== null) {
			global $menu;
			$menu_post = 'edit.php';
			$menu_vendas = 'edit.php?post_type=' . $post_vendas;
			$menu_pacientes = 'edit.php?post_type=' . $post_pacientes;
			// Loop através dos itens de menu
			foreach ($menu as $index => $item) {
	
				if ($item[2] == $menu_post) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}
				
				if ($item[2] == $menu_vendas) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}
	
				if ($item[2] == $menu_pacientes) {
					// Remove o item de menu do post type personalizado para a role especificada
					unset($menu[$index]);
				}
			}
		}
	}

	
}
// Adiciona a função ao hook "admin_init"
add_action('admin_init', 'hide_custom_by_role');


// Adicionar arquivos API
require_once get_theme_file_path( 'api/get_landpage.php' );
require_once get_theme_file_path( 'api/get_ps_doc.php' );
require_once get_theme_file_path( 'api/get_welcome.php' );

//----Funções blog-ache--------

function aalaap_count_view( $data ) {
    pvc_view_post( $data['id'] );
    $count = pvc_get_post_views($data["id"]);
    return new WP_REST_Response($count);
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/countview/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'aalaap_count_view',
    ));
} );

//-------------------------

// This enables the orderby=menu_order for Posts
add_filter( 'rest_post_collection_params', 'filter_add_rest_orderby_params', 10, 1 );

/**
 * Add menu_order to the list of permitted orderby values
 */
function filter_add_rest_orderby_params( $params ) {
    $params['orderby']['enum'][] = 'post_views';
    return $params;
}

add_action( 'rest_api_init', 'add_custom_fields' );
function add_custom_fields() {
    register_rest_field(
    'post', 
    'post_views', //New Field Name in JSON RESPONSEs
    array(
        'get_callback'    => 'get_custom_fields', // custom function name 
        'update_callback' => null,
        'schema'          => null,
        )
    );
}

function get_custom_fields( $object) {
    $count = pvc_get_post_views($object["id"]);
    return $count;
}

//------------------------- Filtragem de post por tipo_de_post-----------------

function filter_posts_by_meta_field( $args, $request ) {
    // Verifica se o filtro por tipo_do_post está presente nos parâmetros da solicitação
    if ( isset( $request['tipo_do_post'] ) ) {
        // Adicione aqui o nome do seu campo personalizado
        $meta_key = 'tipo_do_post';
        
        // Adiciona o meta_query aos argumentos da consulta
        $args['meta_query'] = array(
            array(
                'key'   => $meta_key,
                'value' => $request['tipo_do_post'],
            )
        );
    }
    
    return $args;
}
add_filter( 'rest_post_query', 'filter_posts_by_meta_field', 10, 2 );