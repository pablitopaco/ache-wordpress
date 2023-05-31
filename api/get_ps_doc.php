<?php 


// Rotas da API de Mural
add_action(
    'rest_api_init',
    function () { register_rest_route('api', 'lpdoc', [ 'methods' => 'GET', 'callback' => 'endpoint_lpdoc',]); }
);

// Mural
function endpoint_lpdoc(WP_REST_Request $request) {

    // Variáveis
    $response = array();
    $data = $request->get_params();
    
    $the_user = wp_get_current_user();

    $args = array(
      'name'        => $data['slug'],
      'post_type'   => 'lp_doc',
      'post_status' => 'publish',
      'numberposts' => 1
    );

    $query = new WP_Query( $args );
    if( $query->have_posts() ) :
        while( $query->have_posts() ) : $query->the_post();
            $item = [];

            $page = get_post(get_the_ID()); 
            
            $item['id'] = $page->ID;
            $item['title'] = $page->post_title;
            $item['slug'] = $page->post_name;            
            $item['data'] = $page->post_date;
            $item['data_modified'] = $page->post_modified;            
            
            $item['header'] = array(                
                'menu_options_visible' => get_field( 'exibir_menu', $page->ID ),
                'menu_header' => get_field( 'menu_header', $page->ID )
            );

            //$item['conteudo'] = count(get_field('conteudos', $page->ID));

            $banner = [];
            if (get_field('exibir_banner', $page->ID)) {     
                $banner['is_visible'] = get_field('exibir_banner', $page->ID);    
                $banner['titulo'] = get_field( 'titulo_banner', $page->ID );
                $banner['imagem_banner'] = get_field( 'imagem_banner', $page->ID );

                $item['section_banner'] = $banner;
            }
            
            $item['is_filter'] = get_field('exibir_pesquisa', $page->ID);    
            
            $post = [];
            foreach (get_field('conteudos', $page->ID) as $propriedade => $valor) {
                
                $args = array(
                    'post_type'      => 'achedoc',
                    'p'              => $valor->ID,
                    'posts_per_page' => 1
                );                
                
                $query_post = new WP_Query($args);                
                if ($query_post->have_posts()) {
                    while ($query_post->have_posts()) {

                        $item_post = [];
                        $query_post->the_post();
                                        
                        $item_post['id'] = $valor->ID;
                        $item_post['title'] = $valor->post_title;
                        $item_post['slug'] = $valor->post_name;
                        $item_post['data'] = $valor->post_date;
                        $item_post['data_modified'] = $valor->post_modified;            

                        $item_post['titulo'] = get_field( 'titulo', $valor->ID );
                        $item_post['image_destaque'] = get_field( 'imagem_destaque', $valor->ID );
                        $item_post['imagem_thumb'] = get_field('imagem_thumb', $valor->ID);
                        $item_post['autor'] = get_field('autor', $valor->ID);
                        $item_post['conteudo'] = get_field('conteudo', $valor->ID);

                        $post[$propriedade] = $item_post;
                        wp_reset_postdata();

                    }
                }
                wp_reset_query();

            }
            $item['conteudos'] = $post;

            $outros_conteudos = [];
            if (get_field('exibir_secao_outros', $page->ID)) {
                $outros_conteudos['is_visible'] = get_field('exibir_secao_outros', $page->ID);
                $outros_conteudos['titulo'] = get_field( 'nome_secao_outros', $page->ID );

                $post = [];
                foreach (get_field('outros_conteudos', $page->ID) as $propriedade => $valor) {
                    
                    $args = array(
                        'post_type'      => 'achedoc',
                        'p'              => $valor->ID,
                        'posts_per_page' => 1
                    );                
                    
                    $query_post_outros = new WP_Query($args);                
                    if ($query_post_outros->have_posts()) {
                        while ($query_post_outros->have_posts()) {

                            $item_post = [];
                            $query_post_outros->the_post();
                                            
                            $item_post['id'] = $valor->ID;
                            $item_post['title'] = $valor->post_title;
                            $item_post['slug'] = $valor->post_name;
                            $item_post['data'] = $valor->post_date;
                            $item_post['data_modified'] = $valor->post_modified;            

                            $item_post['titulo'] = get_field( 'titulo', $valor->ID );
                            $item_post['image_destaque'] = get_field( 'imagem_destaque', $valor->ID );
                            $item_post['imagem_thumb'] = get_field('imagem_thumb', $valor->ID);
                            $item_post['autor'] = get_field('autor', $valor->ID);
                            $item_post['conteudo'] = get_field('conteudo', $valor->ID);

                            $post[$propriedade] = $item_post;
                            wp_reset_postdata();

                        }
                    }
                    wp_reset_query();

                }
                $outros_conteudos['posts'] = $post;

                $item['section_outros'] = $outros_conteudos;
            }

            $descubra = [];
            if (get_field('exibir_secao_mais', $page->ID)) {        
                $descubra['is_visible'] = get_field('exibir_secao_mais', $page->ID);
                $descubra['nome_section'] = get_field('nome_da_secao_mais', $page->ID);        
                $descubra['conteudo'] = get_field('conteudo_descubra', $page->ID);
                $item['section_descubra'] = $descubra;
            }

            $especialidade = [];
            if (get_field('exibir_secao_outras', $page->ID)) {        
                $especialidade['is_visible'] = get_field('exibir_secao_outras', $page->ID);
                $especialidade['nome_section'] = get_field('nome_secao_outras', $page->ID);        
                $especialidade['conteudo'] = get_field('conteudo_especialidades', $page->ID);
                $item['section_especialidade'] = $especialidade;
            }

            if($page->ID != null) :
                // Atribuindo Itens
                $response[] = $item;
            endif;


        endwhile;
    endif;    

    return  $response;

}

// Rotas da API de Mural
add_action(
    'rest_api_init',
    function () { register_rest_route('api', 'doc', [ 'methods' => 'GET', 'callback' => 'endpoint_achedoc',]); }
);

// Mural
function endpoint_achedoc(WP_REST_Request $request) {

    // Variáveis
    $response = array();
    $data = $request->get_params();
    
    $the_user = wp_get_current_user();
    $args = array(
        'post_type'      => 'achedoc',
        'p'              => $data['id'],
        'posts_per_page' => 1
    );    

    $query = new WP_Query( $args );
    if( $query->have_posts() ) :
        while( $query->have_posts() ) : $query->the_post();
            $item = [];

            $page = get_post(get_the_ID()); 
            
            $item['id'] = $page->ID;
            $item['title'] = $page->post_title;
            $item['slug'] = $page->post_name;            
            $item['data'] = $page->post_date;
            $item['data_modified'] = $page->post_modified;            

            $item['titulo'] = get_field( 'titulo', $page->ID );
            $item['image_destaque'] = get_field( 'imagem_destaque', $page->ID );
            $item['imagem_thumb'] = get_field('imagem_thumb', $page->ID);
            $item['autor'] = get_field('autor', $page->ID);
            $item['conteudo'] = get_field('conteudo', $page->ID);


            $post_relacionados = [];
            if (get_field('exibir_secao_relacionados', $page->ID)) {
                $post_relacionados['is_visible'] = get_field('exibir_secao_relacionados', $page->ID);
                $post_relacionados['titulo'] = get_field( 'nome_secao_relacionados', $page->ID );

                $post = [];
                foreach (get_field('posts', $page->ID) as $propriedade => $valor) {
                    
                    $args = array(
                        'post_type'      => 'achedoc',
                        'p'              => $valor->ID,
                        'posts_per_page' => 1
                    );                
                    
                    $query_post_outros = new WP_Query($args);                
                    if ($query_post_outros->have_posts()) {
                        while ($query_post_outros->have_posts()) {

                            $item_post = [];
                            $query_post_outros->the_post();
                                            
                            $item_post['id'] = $valor->ID;
                            $item_post['title'] = $valor->post_title;
                            $item_post['slug'] = $valor->post_name;
                            $item_post['data'] = $valor->post_date;
                            $item_post['data_modified'] = $valor->post_modified;            

                            $item_post['titulo'] = get_field( 'titulo', $valor->ID );
                            $item_post['image_destaque'] = get_field( 'imagem_destaque', $valor->ID );
                            $item_post['imagem_thumb'] = get_field('imagem_thumb', $valor->ID);
                            $item_post['autor'] = get_field('autor', $valor->ID);
                            $item_post['conteudo'] = get_field('conteudo', $valor->ID);

                            $post[$propriedade] = $item_post;
                            wp_reset_postdata();

                        }
                    }
                    wp_reset_query();

                }
                $post_relacionados['posts'] = $post;

                $item['posts_relacionados'] = $post_relacionados;
            }

            $produtos = [];
            if (get_field('exibir_secao_produtos', $page->ID)) {        
                $produtos['is_visible'] = get_field('exibir_secao_produtos', $page->ID);
                $produtos['nome_section'] = get_field('nome_secao_produtos', $page->ID);        
                $produtos['produtos'] = get_field('produtos', $page->ID);
                $item['section_produtos'] = $produtos;
            }

            

            if($page->ID != null) :
                // Atribuindo Itens
                $response[] = $item;
            endif;


        endwhile;
    endif;    

    return  $response;

}

?>