<?php

//Include the enqueue header CSS
function crp_mango_wordpress_theme_styles(){
    wp_enqueue_style('styles-reset', get_template_directory_uri() . '/assets/css/reset.css', '', '1.0');
    wp_enqueue_style('styles-fonts', get_template_directory_uri() . '/assets/css/fonts.css', '', '1.0');
    wp_enqueue_style('styles-bootstrap-grid', get_template_directory_uri() . '/assets/css/bootstrap-grid.css', '', '1.0');
    wp_enqueue_style('styles-theme', get_template_directory_uri() . '/style.css', '', '1.0');
    //wp_enqueue_style('styles-common', get_template_directory_uri() . '/assets/css/style-common.css', '', '1.0.0');

    //FRAMEWORKS 
    wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/css/slick.css', array(), '1.0', 'all' );    
	wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/assets/css/slick-theme.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'aos-css', get_template_directory_uri() . '/assets/css/aos.css', array(), '1.0', 'all' );

    //THEME 
    wp_enqueue_style('styles-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap/bootstrap.min.css', '', '1.0.0');
    wp_enqueue_style('theme-css', get_template_directory_uri() . '/assets/css/style-theme.css', '', '1.0.0');    

    //THEME CMS
    wp_enqueue_style('cms-theme', get_template_directory_uri() . '/assets/css/style.css', '', '1.0.0');    
    wp_enqueue_style('bootstrap-icons', get_template_directory_uri() . '/assets/vendor/bootstrap-icons/bootstrap-icons.css', '', '1.0.0');    
    wp_enqueue_style('boxicons-css', get_template_directory_uri() . '/assets/vendor/boxicons/css/boxicons.min.css', '', '1.0.0');    
    wp_enqueue_style('quill-css', get_template_directory_uri() . '/assets/vendor/quill/quill.snow.css', '', '1.0.0');    
    wp_enqueue_style('quill-css', get_template_directory_uri() . '/assets/vendor/quill/quill.bubble.css', '', '1.0.0');    
    wp_enqueue_style('remixicon-css', get_template_directory_uri() . '/assets/vendor/remixicon/remixicon.css', '', '1.0.0');    
    wp_enqueue_style('datatables-css', get_template_directory_uri() . '/assets/vendor/simple-datatables/style.css', '', '1.0.0');    

    //conditional styles
    if (is_page() || is_404() || is_search()) {
        // wp_enqueue_style('styles-page', get_template_directory_uri() . '/assets/css/style-page.css', '', '1.1.1');
    }
    if(is_front_page()){
    //   wp_enqueue_style( 'styles-home',  get_template_directory_uri() . '/assets/css/style-home.css', '','1.0');
    }
    if(is_single()){
    //   wp_enqueue_style( 'styles-product-single',  get_template_directory_uri() . '/assets/css/style-single.css', '','1.0');
    }
}
add_action( 'wp_enqueue_scripts', 'crp_mango_wordpress_theme_styles' );

//Include the enqueue footer SCRIPTS
function crp_mango_wordpress_theme_scripts(){
    wp_enqueue_script('jquery');
    
    //FRAMEWORKS 
    wp_enqueue_script('slick', get_template_directory_uri() . '/assets/js/slick.js', '', '1.0',true);
    wp_enqueue_script('aos-js', get_template_directory_uri() . '/assets/js/aos.js', '', '1.0',true);

    //THEME 
    wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', '', '1.0',true);
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap/bootstrap.min.js', '', '1.0',true);
    wp_enqueue_script('theme-js', get_template_directory_uri() . '/assets/js/script-theme.js', '', '1.0',true);

    //THEME CMS
    wp_enqueue_script('apexcharts', get_template_directory_uri() . '/assets/vendor/apexcharts/apexcharts.min.js', '', '1.0',true);
    wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', '', '1.0',true);
    wp_enqueue_script('chart', get_template_directory_uri() . '/assets/vendor/chart.js/chart.umd.js', '', '1.0',true);
    wp_enqueue_script('echarts', get_template_directory_uri() . '/assets/vendor/echarts/echarts.min.js', '', '1.0',true);
    wp_enqueue_script('quill', get_template_directory_uri() . '/assets/vendor/quill/quill.min.js', '', '1.0',true);
    wp_enqueue_script('datatables', get_template_directory_uri() . '/assets/vendor/simple-datatables/simple-datatables.js', '', '1.0',true);
    wp_enqueue_script('tinymce', get_template_directory_uri() . '/assets/vendor/tinymce/tinymce.min.js', '', '1.0',true);
    wp_enqueue_script('validate', get_template_directory_uri() . '/assets/vendor/php-email-form/validate.js', '', '1.0',true);
}
add_action( 'wp_enqueue_scripts', 'crp_mango_wordpress_theme_scripts' );
