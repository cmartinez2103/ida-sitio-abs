<?php


//////////////////////
//////GENERAL
///////////////////

//remove bar for periodista


// add_action('admin_init', 'my_remove_menu_pages');
// function my_remove_menu_pages() {
//     $current_user = wp_get_current_user();
//     if ( $current_user->roles[0] == 'downloader') {
//         remove_menu_page('ms-delete-site.php');
//         remove_menu_page('tools.php');
//     }
// }

add_action('after_setup_theme', 'remove_editor_bar');
function remove_editor_bar() {
    show_admin_bar(false);
}

add_filter( 'admin_post_thumbnail_html', 'featured_image_message');
function featured_image_message($content) {

    if(get_post_type() == 'personal'){
        $content .= '<p>Ratio de imagen recomendado: 1:1</p><p>Medida Optima: 480x480</p><p>Medida mínima: 250x250</p>';
    }elseif(get_post_type() == 'sede'){
        $content .= '<p>Medida imagen: 710x515 pixeles</p>';
    }elseif(get_page_template_slug() == 'template-indice-general.php' || get_page_template_slug() == 'template-indice-general-actividades.php' || get_page_template_slug() == 'template-indice-sedes.php'){
       $content .= '<p>Medida imagen: 1136x300 pixeles</p>';
    }else {
       $content .= '<p>Medida imagen: 752x515 pixeles</p>';;
    }
    return $content;
}


//Options pages
if( function_exists('acf_set_options_page_title') ){
    acf_set_options_page_title('Opciones del sitio');
}

if( function_exists('acf_set_options_page_menu') ){
    acf_set_options_page_menu('Opciones del sitio');
}

if( function_exists('acf_add_options_sub_page') ){
    // configuracion de generales
    acf_add_options_sub_page(array(
        'title' => 'Contenido',
        'capability' => 'list_users'
    ));

    // configuracion de Globales
    acf_add_options_sub_page(array(
        'title' => 'Globales',
        'capability' => 'list_users'
    ));

    // configuracion de Formularios
    acf_add_options_sub_page(array(
        'title' => 'Formularios',
        'capability' => 'list_users'
    ));
}

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );



//incrustar Scripts
add_action( 'wp_enqueue_scripts', 'incrustar_scripts', 20);
function incrustar_scripts(){
   wp_register_script('main_script', get_template_directory_uri(). '/dist/js/main.min.js', array(), '1.1', true);
   wp_enqueue_script( 'main_script' );

   wp_localize_script('main_script','data',[
     'base_url' => rest_url('/api/v1/')
   ]);
}


//incrustar css
add_action('wp_print_styles', 'incrustar_estilos');
function incrustar_estilos(){
    wp_register_style('main_style', get_bloginfo('template_directory') . '/dist/css/main.css' );
    wp_enqueue_style( 'main_style' );

    wp_register_style('fontMerri', 'https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i' );
    wp_register_style('fontPoppins', 'https://fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,600i,700,700i,800,900' );
    wp_enqueue_style('fontMerri');
    wp_enqueue_style('fontPoppins');
}


// First, make sure Jetpack doesn't concatenate all its CSS
add_filter( 'jetpack_implode_frontend_css', '__return_false' );
add_action('wp_print_styles', 'sacar_estilos_extra');
function sacar_estilos_extra(){
    if( !is_admin() ){
        // Saco los estilos de jetpack en el front
        wp_deregister_style( 'AtD_style' ); // After the Deadline
        wp_deregister_style( 'jetpack_likes' ); // Likes
        wp_deregister_style( 'jetpack_related-posts' ); //Related Posts
        wp_deregister_style( 'jetpack-carousel' ); // Carousel
        wp_deregister_style( 'grunion.css' ); // Grunion contact form
        wp_deregister_style( 'the-neverending-homepage' ); // Infinite Scroll
        wp_deregister_style( 'infinity-twentyten' ); // Infinite Scroll - Twentyten Theme
        wp_deregister_style( 'infinity-twentyeleven' ); // Infinite Scroll - Twentyeleven Theme
        wp_deregister_style( 'infinity-twentytwelve' ); // Infinite Scroll - Twentytwelve Theme
        wp_deregister_style( 'noticons' ); // Notes
        wp_deregister_style( 'post-by-email' ); // Post by Email
        wp_deregister_style( 'publicize' ); // Publicize
        wp_deregister_style( 'sharedaddy' ); // Sharedaddy
        wp_deregister_style( 'sharing' ); // Sharedaddy Sharing
        wp_deregister_style( 'stats_reports_css' ); // Stats
        wp_deregister_style( 'jetpack-widgets' ); // Widgets
        wp_deregister_style( 'jetpack-slideshow' ); // Slideshows
        wp_deregister_style( 'presentations' ); // Presentation shortcode
        wp_deregister_style( 'jetpack-subscriptions' ); // Subscriptions
        wp_deregister_style( 'tiled-gallery' ); // Tiled Galleries
        wp_deregister_style( 'widget-conditions' ); // Widget Visibility
        wp_deregister_style( 'jetpack_display_posts_widget' ); // Display Posts Widget
        wp_deregister_style( 'gravatar-profile-widget' ); // Gravatar Widget
        wp_deregister_style( 'widget-grid-and-list' ); // Top Posts widget
        wp_deregister_style( 'jetpack-widgets' ); // Widgets
    }
}

/*Async load scripts*/
// Async load
function st_async_load_scripts($url)
{
    if ( strpos( $url, '#asyncscript') === false ){
        return $url;
    }elseif( is_admin() ){
        return str_replace( '#asyncscript', '', $url );
    }
	return str_replace( '#asyncscript', '', $url )."' async='async" . "' defer='defer";
}
add_filter( 'clean_url', 'st_async_load_scripts', 11, 1 );

/////////////////////// Saca los query strings de los css y js, ayuda al page speed
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) ) { $src = remove_query_arg( 'ver', $src ); }
    return $src;
}

/**
* Genera el HTML de los breadcrumbs
* @return string - HTML de los breadcrumbs
*/
function generate_breadcrumbs(){
    global $post, $wp_query;
    $items = '';
    // link al inicio siempre presente
    $items .= '<li class="breadcrumbs__item"><a href="'. home_url() .'" title="Ir a la página de inicio" rel="index">Inicio</a></li>';
    // en lso singles y singulars siempre va el titulo al final
    if( is_singular() ) {
        if( is_page() ){
            $ancestors = get_post_ancestors( $post );
            //printme($ancestors);
            $ancestors = array_reverse($ancestors);
            if( !empty($ancestors) ){
                foreach( $ancestors as $parent_id ){
                    $items .= '<li class="breadcrumbs__item"><a href="'. get_permalink( $parent_id ) .'" title="Ir a '. get_the_title( $parent_id ) .'" rel="section">'. get_the_title( $parent_id ) .'</a></li>';
                }
            }
        }
        if(is_singular('actividad')){
            //printme($post);
            $items .= '<li class="breadcrumbs__item"><a href="/actividad-extraprogramatica/" title="Ir a Actividad Extraprogramática" rel="section">Actividad Extraprogramática</a></li>';
            if ($post->post_parent != 0) {
               $items .= '<li class="breadcrumbs__item"><a href="'. get_permalink( $post->post_parent) .'" title="Ir a '. get_the_title( $post->post_parent ) .'" rel="section">'. get_the_title( $post->post_parent ) .'</a></li>';
            }
        }
        if(is_singular('sede')){
            //printme($post);
            $items .= '<li class="breadcrumbs__item"><a href="/nuestras-sedes/" title="Ir a Nuestras Sedes" rel="section">Nuestras Sedes</a></li>';
            if ($post->post_parent != 0) {
               $items .= '<li class="breadcrumbs__item"><a href="'. get_permalink( $post->post_parent) .'" title="Ir a Sede '. get_the_title( $post->post_parent ) .'" rel="section">Sede '. get_the_title( $post->post_parent ) .'</a></li>';
            }
        }
        if(is_singular('post')){
           $parent_terms = wp_get_post_terms($post->ID, 'category');
           //printme($parent_terms);
           if($parent_terms):
               $parent_term = $parent_terms[0];
               //printme($parent_term->slug);
               $parent_url = get_term_link($parent_term, 'category');
               if ($parent_term->slug == 'cognita') {
                  $items .= '<li class="breadcrumbs__item"><a href="/blog-cognita/" title="Ir a '.$parent_term->name .'" rel="section">'. $parent_term->name .'</a></li>';

               }elseif ($parent_term->slug == 'galerias' || $parent_term->slug == 'noticias' || $parent_term->slug == 'videos') {
                  $items .= '<li class="breadcrumbs__item"><a href="/vida-escolar/" title="Ir a Vida escolar" rel="section">Vida Escolar</a></li>';
                  $items .= '<li class="breadcrumbs__item"><a href="/vida-escolar/'.$parent_term->slug.'/" title="Ir a '.$parent_term->name .'" rel="section">'. $parent_term->name .'</a></li>';
               }else {
                  $items .= '<li class="breadcrumbs__item"><a href="/vida-escolar/" title="Ir a Vida escolar" rel="section">Vida Escolar</a></li>';
                  $items .= '<li class="breadcrumbs__item"><a href="'.$parent_url.'" title="Ir a '.$parent_term->name .'" rel="section">'. $parent_term->name .'</a></li>';
               }
           endif;
        }

        $items .= '<li class="breadcrumbs__item current">';
        $items .= cut_string_to(get_the_title($post->ID), 40);
        $items .= '</li>';
    }
    elseif(is_home()) {
      //printme($post);
      $items .= '<li class="breadcrumbs__item"><a href="/vida-escolar/" title="Ir a Vida escolar" rel="section">Vida Escolar</a></li>';
      $items .= '<li class="breadcrumbs__item current">Noticias</li>';
    }
    elseif (is_category()) {
      $parent_terms = wp_get_post_terms($post->ID, 'category');
      $parent_term = $parent_terms[0];
      $parent_url = get_term_link($parent_term, 'category');
      $items .= '<li class="breadcrumbs__item"><a href="/vida-escolar/" title="Ir a Vida escolar" rel="section">Vida Escolar</a></li>';
      $items .= '<li class="breadcrumbs__item current">'.$parent_term->name .'</li>';
   }
    elseif( is_search() ){
        $items .= '<li class="breadcrumbs__item current">Resultados de búsqueda</li>';
    }
    elseif (is_404() ) {
       $items .= '<li class="breadcrumbs__item current">Error 404</li>';
    }
    $out  = '<ul class="breadcrumbs">';
    $out .= $items;
    $out .= '</ul>';
    return $out;
}

function ida_replace_accented($string){
	$unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

	return strtr( $string, $unwanted_array );
}

/**
 * Genera la caja de acciones dentro de un articulo
 * esta caja contiene las acciones de
 * compartir, shortlink, enviar por email e imprimir
 * Todas las accioens se hacen a traves del $post
 * @param  object $articulo - $post_object del articulo
 * @return string - HTML de la caja
 */
function generate_sharebox(){
    global $post;
    $share_links = generate_share_urls( $post );

    $out  = '<ul class="simple-socialshare print-hide" data-mutable="smalltablet-down" data-desktop-area="desktop-social" data-mobile-area="mobile-social">';
    $out .=     '<li class="simple-socialshare__null hide-on-smalltablet-down">Compartir:</li>';
    $out .=     '<li class="simple-socialshare__item facebook"><a href="'.$share_links['facebook'].'" class="simple-socialshare__link" title="Compartir en facebook" target="_blank"></a></li>';
    $out .=     '<li class="simple-socialshare__item twitter"><a href="'.$share_links['twitter'].'" class="simple-socialshare__link" title="Compartir en twitter" target="_blank"></a></li>';
    $out .=     '<li class="simple-socialshare__item print hide-on-smalltablet-down"><a href="#" class="simple-socialshare__link" title="Imprimir" data-func="printPage"></a></li>';
    // $out .=     '<li class="simple-socialshare__item sendmail"><a href="mailto:?subject='.$post->post_title.'&body='.get_permalink($post).'" class="simple-socialshare__link" title="Enviar por mail"></a></li>';
    $out .=     '<li class="simple-socialshare__item sendmail"><button class="simple-socialshare__link" title="Enviar por mail" data-func="loadModal" data-method="post" data-query="pid='.$post->ID.'&uri=' . get_template_directory_uri().'" data-target="'.get_template_directory_uri().'/partials/modal/mailshare.php"></button></li>';
    $out .=     '<li class="simple-socialshare__item whatsapp hide-on-smalltablet-up"><a href="'.$share_links['whatsapp'].'" class="simple-socialshare__link" title="Compartir en whatsapp" target="_blank"></a></li>';
    $out .= '</ul>';

    '';

    return $out;
}

/**
 * Devuelve el HTML de la paginacion de una $wp_query
 * @param  object $query $wp_query a la cual paginar
 * @param  string  $prev  Texto para el boton anterior
 * @param  string  $next  Texto para el boton siguiente
 * @return string HTML de la paginacion
 */
function get_pagination( $query = false, $prev = 'Anterior', $next = 'Siguiente' ) {
    global $wp_query, $wp_rewrite, $paged;
    if ( !$query ) { $query = $wp_query; }
    $paged = $query->query_vars['paged'] > 1 ? $current = $query->query_vars['paged'] : $current = 1;
    // opciones generales para los links de paginacion, la opcion "format" puede esar en español7
    // solo si es que esta activo el filtro para cambiar esto
    $pagination = array(
        'base' => @add_query_arg('paged', '%#%'),
        'format' => '/pagina/%#%',
        'total' => $query->max_num_pages,
        'current' => $current,
        'prev_text' => __($prev),
        'next_text' => __($next),
        'mid_size' => 2,
        'type' => 'array',
    );
    $items = "";
    $pageLinksArray = paginate_links($pagination);

    if( !empty( $pageLinksArray ) ){
        // reviso si es que existe un link "anterior", lo saco del array y lo guardo en variable
        $prevLink = '';
        if( preg_match('/'. $prev .'/i', $pageLinksArray[0]) ){
            $prevLink = preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' title="Página anterior" rel="prev" ', array_shift($pageLinksArray));
            $prevLink = preg_replace('/(?<=\"\>)(.*?)(?=\<\/)/', '', $prevLink);
        }
        // lo mismo para el link "siguiente"
        $nextLink = '';
        if( preg_match('/'. $next .'/i', end($pageLinksArray)) ){
            $nextLink = preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' title="Página siguiente" rel="next" ', array_pop($pageLinksArray));
            $nextLink = preg_replace('/(?<=\"\>)(.*?)(?=\<\/)/', '', $nextLink);
        }
        // se ponen los links "anterior" y "siguiente" dentro del html deseado
        $items .= '<li class="paginator__item prev">' . $prevLink . '</li>';
        //se itera sobre los links de paginas
        foreach( (array)$pageLinksArray as $pageLink ){
            // se itera sobre el resto de los links con el fin de cambiar y/o agregar clases personalizadas
            // si estoy en la pagina
            if( preg_match('/current/i', $pageLink) ){
                $items .= '<li class="paginator__item current">';
                $items .=   preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' rel="nofollow" ', $pageLink);
                $items .= '</li>';
            }
            else {
                $items .= '<li class="paginator__item">';
                $items .=   preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', ' rel="nofollow" ', $pageLink);
                $items .= '</li>';
            }
        }
        $items .= '<li class="paginator__item next">' . $nextLink . '</li>';
    }


    $out .=     '<div class="flex-center">';
    $out .=       '<ul class="paginator">';
    $out .=         $items;
    $out .=       '</ul>';
    $out .=     '</div>';

    return $out;
}

function get_sedes(){
    $sedes_args = array('taxonomy' => 'tipo_sedes', 'hide_empty' => false, 'orderby' => 'term_id');
    $sedes = get_terms($sedes_args);
    return $sedes;
}
function get_niveles(){
    $niveles_args = array('taxonomy' => 'tipo_niveles', 'hide_empty' => false, 'orderby' => 'term_id');
    $nivel = get_terms($niveles_args);
    return $nivel;
}

function get_tipo_consulta(){
    $tipo_consulta_args = array('taxonomy' => 'tipo_consulta', 'hide_empty' => false, 'orderby' => 'term_id');
    $consulta = get_terms($tipo_consulta_args);
    return $consulta;
}

add_shortcode( 'mapadelsitio', 'generate_sitemap' );
function generate_sitemap( $atts ){
    return wp_nav_menu(array(
        'theme_location' => 'mapasitio',
        'echo' => false,
        'menu_class' => 'sitemap'
    ));
}

/**
**	Agregar post status en lista del admin
*/
add_action('admin_footer-post.php', 'append_post_status_list');
function append_post_status_list(){
   global $post;
   $complete1 = '';
   $complete2 = '';
   $label = '';
   if($post->post_type == 'form_contacto' || $post->post_type == 'postulacion'){
      if($post->post_status == 'unread'){
         $complete1 = ' selected="selected"';
         $label = '<span id="post-status-display"> No visto</span>';
      }else if($post->post_status == 'readd'){
         $complete2 = ' selected="selected"';
         $label = '<span id="post-status-display">Visto</span>';
      }
      ?>
      <script>
      jQuery(document).ready(function($){
         $("select#post_status").append('<option value="unread" <?php echo $complete1; ?>>No visto</option> <option value="readd" <?php echo $complete2; ?>>Visto</option>');
         $(".misc-pub-section label").append('<?php echo $label; ?>');
         $(".misc-pub-section #post-status-display").append('<?php echo $label; ?>');
      });
      </script>
      <?php
   }
}

require_once 'framework/admin.php';
?>
