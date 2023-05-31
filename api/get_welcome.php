<?php 

// Rotas da API de Mural
add_action(
    'rest_api_init',
    function () { register_rest_route('api', 'welcome', [ 'methods' => 'GET', 'callback' => 'endpoint_welcome',]); }
);

// Mural
function endpoint_welcome(WP_REST_Request $request) {

    // Variáveis
    $response = array();
    $data = $request->get_params();
    
    $the_user = wp_get_current_user();

    $args = array(
      'name'        => $data['slug'],
      'post_type'   => 'welcome',
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
                'display_menu' => get_field( 'exibir_menu', $page->ID ),
                'menu_header' => get_field( 'menu_header', $page->ID ),
            );

            //$item['banner'] = get_field( 'sliders', $page->ID );

            $banner = [];
            if (get_field('mostrar_banner', $page->ID)) {                            
                $banner['is_visible'] = get_field('mostrar_banner', $page->ID);
                $banner['video_ou_imagem'] = get_field( 'video_ou_imagem', $page->ID );
                $banner['titulo'] = get_field( 'titulo_banner', $page->ID );                
                $banner['subtitulo_banner'] = get_field('subtitulo_banner', $page->ID);
                $banner['has_button'] = get_field('botao_banner', $page->ID);
                $banner['link_botao_banner'] = get_field('link_botao_banner', $page->ID);
                $item['secao_banner'] = $banner;
            }

            $conteudos = [];
            if (get_field('exibir_secao_conteudo', $page->ID)) {                
                $conteudos['is_visible'] = get_field('exibir_secao_conteudo', $page->ID);
                $conteudos['nome_section'] = get_field('nome_da_secao_conteudo', $page->ID);
                $conteudos['titulo'] = get_field( 'titulo_conteudo', $page->ID );                
                                                
                $conteudos['has_subtitle'] = get_field('exibir_subtitulo_conteudo', $page->ID);
                $conteudos['subtitulo'] = get_field('subtitulo_conteudo', $page->ID);

                $conteudos['has_time'] = get_field('exibir_tempo_de_leitura', $page->ID);
                $conteudos['time'] = get_field('tempo_de_leitura_conteudo', $page->ID);
                
                $conteudos['conteudos'] = get_field( 'conteudos', $page->ID );
                $item['section_conteudos'] = $conteudos;
            }

            $eventos = [];
            if (get_field('exibir_secao_eventos', $page->ID)) {   
                $eventos['is_visible'] = get_field('exibir_secao_eventos', $page->ID);            
                $eventos['nome_section'] = get_field('nome_secao_eventos', $page->ID);
                $eventos['eventos'] = get_field( 'conteudos_eventos', $page->ID );

                $item['section_eventos'] = $eventos;
            }

            $descontos = [];
            if (get_field('exibir_secao_descontos', $page->ID)) {   
                $descontos['is_visible'] = get_field('exibir_secao_descontos', $page->ID);            
                $descontos['nome_section'] = get_field('nome_secao_descontos', $page->ID);
                $descontos['campanhas_descontos'] = get_field( 'campanhas_de_descontos', $page->ID );

                $item['section_descontos'] = $descontos;
            }

            $descubra = [];
            if (get_field('exibir_secao_descubra', $page->ID)) {   
                $descubra['is_visible'] = get_field('exibir_secao_descubra', $page->ID);            
                $descubra['nome_section'] = get_field('nome_secao_descubra', $page->ID);
                $descubra['descubra_mais'] = get_field( 'descubra_mais', $page->ID );

                $item['section_descubra'] = $descubra;
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