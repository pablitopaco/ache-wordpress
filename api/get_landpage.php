<?php 

// Rotas da API de Mural
add_action(
    'rest_api_init',
    function () { register_rest_route('api', 'landpage', [ 'methods' => 'GET', 'callback' => 'endpoint_mural',]); }
);

// Mural
function endpoint_mural(WP_REST_Request $request) {

    // Variáveis
    $response = array();
    $data = $request->get_params();
    
    $the_user = wp_get_current_user();

    $args = array(
      'name'        => $data['slug'],
      'post_type'   => 'squad_saude',
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

            //$item['title_banner'] = get_field( 'titulo', $page->ID );

            $item['header'] = array(
                'access_button_visible' => get_field( 'access_button_visible', $page->ID ),
                'menu_options_visible' => get_field( 'menu_options_visible', $page->ID ),
                'link_menu_options' => get_field( 'link_botao_acessar', $page->ID ),
                'link_externo' => get_field( 'link_externo', $page->ID ),
                'authentication' => get_field( 'autenticacao', $page->ID ),
                'success_message' => get_field( 'mensagem_de_sucesso', $page->ID )
            );

            $item['slides'] = get_field( 'sliders', $page->ID );

            $faca_parte = [];
            if (get_field('ativo_faca', $page->ID)) {                
                $faca_parte['titulo'] = get_field( 'titulo_faca_parte', $page->ID );
                $faca_parte['cta'] = get_field( 'cta_faca_parte', $page->ID );
                $faca_parte['is_visible'] = get_field('ativo_faca', $page->ID);
                $faca_parte['nome_section'] = get_field('nome_section_parte', $page->ID);
                $faca_parte['has_subtitle'] = get_field('has_subtitle_faca', $page->ID);
                $faca_parte['subtitulo'] = get_field('subtitulo_sessao_parte', $page->ID);
                $item['section_faca_parte'] = $faca_parte;
            }

            $conteudos = [];
            if (get_field('ativo_conteudo', $page->ID)) {                
                $conteudos['titulo'] = get_field( 'titulo_conteudo', $page->ID );
                $conteudos['cta'] = get_field( 'cta_conteudo', $page->ID );
                
                $conteudos['is_visible'] = get_field('ativo_conteudo', $page->ID);
                $conteudos['nome_section'] = get_field('nome_sessao_conteudo', $page->ID);
                $conteudos['has_subtitle'] = get_field('has_subtitle_conteudo', $page->ID);
                $conteudos['subtitulo'] = get_field('subtitulo_sessao_conteudo', $page->ID);
                
                $conteudos['tipos_conteudos'] = get_field( 'tipos_de_conteudos', $page->ID );
                $item['section_conteudos'] = $conteudos;
            }

            $produtos = [];
            if (get_field('ativo_produtos', $page->ID)) {                
                $produtos['titulo'] = get_field( 'titulo_produtos', $page->ID );
                $produtos['sub_titulo'] = get_field( 'sub_titulo_produtos', $page->ID );
                $produtos['descricao'] = get_field( 'descricao_produtos', $page->ID );
                $produtos['cta'] = get_field( 'cta_produtos', $page->ID );

                $produtos['is_visible'] = get_field('ativo_produtos', $page->ID);
                $produtos['nome_section'] = get_field('nome_sessao_produtos', $page->ID);
                $produtos['has_subtitle'] = get_field('has_subtitle_produtos', $page->ID);
                $produtos['subtitulo'] = get_field('subtitulo_sessao_produtos', $page->ID);

                $produtos['produtos'] = get_field( 'produtos', $page->ID );

                $item['section_produtos'] = $produtos;
            }

            $newsletter = [];
            if (get_field('ativo_newsletter', $page->ID)) {
                $newsletter['imagem'] = get_field( 'imagem_destaque_newsletter', $page->ID );
                $newsletter['titulo'] = get_field( 'titulo_newsletter', $page->ID );
                $newsletter['sub_titulo'] = get_field( 'sub_titulo_newsletter', $page->ID );
                $newsletter['cta'] = get_field( 'cta_newsletter', $page->ID );

                $newsletter['is_visible'] = get_field('ativo_newsletter', $page->ID);
                $newsletter['nome_section'] = get_field('nome_sessao_newsletter', $page->ID);
                $newsletter['has_subtitle'] = get_field('has_subtitle_newsletter', $page->ID);
                $newsletter['subtitulo'] = get_field('subtitulo_sessao_newsletter', $page->ID);

                $item['section_newsletter'] = $newsletter;
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