<?php 

function posts_for_current_author($query) {
    global $pagenow;
        
    if( 'edit.php' != $pagenow || !$query->is_admin )
        return $query;
        
    if( !current_user_can( 'edit_others_posts' ) ) {
        global $user_ID;
        $query->set('author', $user_ID );
    }
    
    return $query;    
}
add_filter('pre_get_posts', 'posts_for_current_author');

function create_custom_squads() {
   // SQUAD PACIENTES E CLIENTES
   register_post_type('squad_pacientes',
       array(
           'labels' => array(
               'name' => ('Pacientes e Clientes'),
               'singular_name' => ('Pacientes e Clientes'),
               'add_new_item' => ('Add novo Conteúdo'),
               'not_found' =>  ('Nenhuma conteúdo encontrado')
           ),
           'public' => true,
           'menu_icon' => 'dashicons-admin-users',
           'publicly_queryable' => true,
           'rewrite' => array("slug" => "paciente-clientes"),
           'capability_type'    => 'post',
           'supports' => array('title', 'editor', 'thumbnail'),
           'has_archive' => true,
           'hierarchical' => true,
       )
   );
   register_taxonomy('cat-paciente', array('squad_pacientes'), array(
        'hierarchical' => true,
        'label' => 'Categoria',
        'singular_label' => 'Categoria',
        'rewrite' => array('slug' => 'categoria-paciente', 'with_front' => false)
    ));
    register_taxonomy_for_object_type( 'cat-paciente', 'squad_pacientes');

    // SQUAD PROFISSIONAIS DE SAÚDE
    register_post_type('squad_saude',
        array(
            'labels' => array(
                'name' => ('Profissionais de saúde - LP'),
                'singular_name' => ('Profissionais de saúde - LP'),
                'add_new_item' => ('Add novo Conteúdo'),
                'not_found' =>  ('Nenhuma conteúdo encontrado')
            ),
            'public' => true,
            'menu_icon' => 'dashicons-heart',
            'publicly_queryable' => true,
            'rewrite' => array("slug" => "profissionais-saude"),
            'capability_type'    => 'post',
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
            'hierarchical' => true,
        )
    );
    register_taxonomy('cat-profissional', array('squad_saude'), array(
        'hierarchical' => true,
        'label' => 'Categoria',
        'singular_label' => 'Categoria',
        'rewrite' => array('slug' => 'categoria-profissional', 'with_front' => false)
    ));
    register_taxonomy_for_object_type( 'cat-profissional', 'squad_saude');

    register_post_type('welcome',
        array(
            'labels' => array(
                'name' => ('Profissionais de saúde - Welcome'),
                'singular_name' => ('Profissionais de saúde - Welcome'),
                'add_new_item' => ('Add novo Conteúdo'),
                'not_found' =>  ('Nenhuma conteúdo encontrado')
            ),
            'public' => true,
            'menu_icon' => 'dashicons-heart',
            'publicly_queryable' => true,
            'rewrite' => array("slug" => "welcome"),
            'capability_type'    => 'post',
            'supports' => array('title', 'editor', 'thumbnail'),
            'taxonomies' => array('tag_welcome'),
            'has_archive' => true,
            'hierarchical' => true,
        )
    );
    // register_taxonomy('categoria', array('welcome'), array(
    //     'hierarchical' => true,
    //     'label' => 'Categoria',
    //     'singular_label' => 'Categoria',
    //     'rewrite' => array('slug' => 'categoria', 'with_front' => false)
    // ));
    // register_taxonomy_for_object_type( 'categoria', 'welcome');

    register_post_type('lp_doc',
        array(
            'labels' => array(
                'name' => ('Profissionais de saúde - LP Doc'),
                'singular_name' => ('Profissionais de saúde - LP Doc'),
                'add_new_item' => ('Add novo Conteúdo'),
                'not_found' =>  ('Nenhuma conteúdo encontrado')
            ),
            'public' => true,
            'menu_icon' => 'dashicons-heart',
            'publicly_queryable' => true,
            'rewrite' => array("slug" => "lp_doc"),
            'capability_type'    => 'post',
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
            'hierarchical' => true,
        )
    );

    register_post_type('achedoc',
        array(
            'labels' => array(
                'name' => ('Profissionais de saúde - Doc'),
                'singular_name' => ('Profissionais de saúde - Doc'),
                'add_new_item' => ('Add novo Conteúdo'),
                'not_found' =>  ('Nenhuma conteúdo encontrado')
            ),
            'public' => true,
            'menu_icon' => 'dashicons-heart',
            'publicly_queryable' => true,
            'rewrite' => array("slug" => "achedoc"),
            'capability_type'    => 'post',
            'supports' => array('title', 'editor', 'thumbnail'),
            'taxonomies' => array('tag_doc'),
            'has_archive' => true,
            'hierarchical' => true,
        )
    );
    register_taxonomy('categoria', array('achedoc'), array(
        'hierarchical' => true,
        'label' => 'Categoria',
        'singular_label' => 'Categoria',
        'rewrite' => array('slug' => 'categoria', 'with_front' => false)
    ));
    register_taxonomy_for_object_type( 'categoria', 'achedoc');
 
    register_taxonomy('tagsdoc', array('achedoc'), array(
        'hierarchical' => true,
        'label' => 'Tags',
        'show_ui' => true,
        'show_admin_column' => true,
        'singular_label' => 'Tag',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'meu_custom_post_type_tags' ),
    ));
    register_taxonomy_for_object_type( 'tagsdoc', 'achedoc');

    // SQUAD PONTOS DE VENDAS
    register_post_type('squad_vendas',
        array(
            'labels' => array(
                'name' => ('Pontos de vendas'),
                'singular_name' => ('Pontos de vendas'),
                'add_new_item' => ('Add novo Conteúdo'),
                'not_found' =>  ('Nenhuma conteúdo encontrado')
            ),
            'public' => true,
            'menu_icon' => 'dashicons-cart',
            'publicly_queryable' => true,
            'rewrite' => array("slug" => "pontos-vendas"),
            'capability_type'    => 'post',
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
            'hierarchical' => true,
        )
    );
    register_taxonomy('cat-vendas', array('squad_vendas'), array(
        'hierarchical' => true,
        'label' => 'Categoria',
        'singular_label' => 'Categoria',
        'rewrite' => array('slug' => 'categoria-vendas', 'with_front' => false)
    ));
    register_taxonomy_for_object_type( 'cat-vendas', 'squad_vendas');
}

add_action('init', 'create_custom_squads');


// function create_landpages() {
//    // SQUAD PACIENTES E CLIENTES
//    register_post_type('landpages-saude',
//        array(
//            'labels' => array(
//                'name' => ('LandPages P. Saúde'),
//                'singular_name' => ('LandPages'),
//                'add_new_item' => ('Add novo Conteúdo'),
//                'not_found' =>  ('Nenhuma conteúdo encontrado')
//            ),
//            'public' => true,
//            'menu_icon' => 'dashicons-welcome-add-page',
//            'publicly_queryable' => true,
//            'rewrite' => array("slug" => "landpage"),
//            'capability_type'    => 'post',
//            'supports' => array('title', 'editor', 'thumbnail'),
//            'has_archive' => true,
//            'hierarchical' => true,
//        )
//    );
//    register_taxonomy('modelos', array('landpages-saude'), array(
//         'hierarchical' => true,
//         'label' => 'Modelo',
//         'singular_label' => 'Modelo',
//         'rewrite' => array('slug' => 'modelo', 'with_front' => false)
//     ));
//     register_taxonomy_for_object_type( 'modelos', 'landpages-saude');

    
// }

// add_action('init', 'create_landpages');