<?php
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5' );
add_theme_support( 'menus' );
add_post_type_support( 'page', 'excerpt' );


/**
 * Quita los menus por defecto de la barra superior
 * 	- Nuevo Post
 * 	- Nueva Página
 * 	- Nuevo Link
 */
add_action( 'admin_bar_menu', 'renex_remove_top_nodes', 999 );
function renex_remove_top_nodes(){
	global $wp_admin_bar;
    $wp_admin_bar->remove_node( 'new-link' );
}

/**
 *
 * @author  Joe Sexton <joe@webtipblog.com>
 */
// function update_search_content($query) {
// 	if (!$query->is_admin && $query->is_search) {
// 		$query->set('post_type', array('page', 'sede', 'actividad', 'post'));
// 	}
// 	return $query;
// }
// add_filter('pre_get_posts', 'update_search_content');


add_action( 'after_setup_theme', 'renex_setup' );
if( ! function_exists( 'renex_setup' ) ) {
	function renex_setup() {
		add_theme_support('post-thumbnails');
		add_theme_support('custom-header');
		add_theme_support('automatic-feed-links');
		register_nav_menus(array(
		"menu_top" => "Menú top del tema",
		"menu_primary" => "Menú principal del tema",
		"menu_footer" => "Menú footer",
		"menu_footer_secundario" => "Menú footer secundario",
		"menu_sedes" => "Menú sedes",
		"menu_extra" => "Menú links de interés",
		"mapasitio" => "Mapa del sitio"
		));

		//  Hooks
		add_image_size('slider', 1280, 627, true); //main bg
		add_image_size('indice-general', 1136, 300, true);
		add_image_size('portada', 710, 515, true);
		add_image_size('sede_box', 566, 326, true); // utilizado para la imagen destaca de las sedes
		add_image_size('page_destacada', 712, 486, true); // utilizado en la página destacada en el home
		add_image_size('avatar_person', 480, 480, true); // utilizado para la imagen del personal y imagenes en la página historia
		add_image_size('acceso_simple', 552, 300, true); // utilizado para el acceso para las páginas de un indice general y las noticias
		add_image_size('acceso_sede_small', 90, 90, true);
		add_image_size('block', 420, 420, true); // utilizado en simple_box, es la imagen de acceso para las páginas de una portada
		add_image_size('slider_single', 752, 423, true); // utilizado en slider, imagen destacada dentro de entradas y páginas
		add_image_size('slider_thumbnail', 279, 157, true);
	}
}



function add_first_and_last($items) {
    $items[1]->classes[] = 'first';
    $items[count($items)]->classes[] = 'last';
    return $items;
}
add_filter('wp_nav_menu_objects', 'add_first_and_last');

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'current ';
    }
    return $classes;
}

//Eliminar comentariios
// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if(post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'df_disable_comments_post_types_support');
// Close comments on the front-end
function df_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);
// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);
// Remove comments page in menu
function df_disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');
// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url()); exit;
	}
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');
// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');
// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'df_disable_comments_admin_bar');



////Menus Walker
class custom_sub_walker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\" submenu\">\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /*grab the default wp nav classes*/
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

        /*if the current item has children, append the dropdown class*/
        if ( $args->has_children )
			$class_names .= ' menu-item--has-submenu';

        /*if there aren't any class names, don't show class attribute*/
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';



        $output .= $indent . '<li' . $id . $value . $class_names .' data-role="touch-submenu">';

        $atts = array();
        $atts['target'] = ! empty( $item->target )  ? $item->target : '';
        $atts['title']  = ! empty( $item->title )   ? $item->title  : '';
        $atts['rel']    = ! empty( $item->xfn )     ? $item->xfn    : '';


        /*if the current menu item has children and it's the parent, set the dropdown attributes*/
        if ( $args->has_children && $depth === 0 ) {
            $atts['href']           = $item->url;
        } else {
            $atts['href'] = ! empty( $item->url ) ? $item->url : '';
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;

        $item_output .= '<a'. $attributes .'>';

        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

    /*  if the current menu item has children and it's the parent item, append the fa-angle-down icon*/
        $item_output .= ( $args->has_children && $depth === 0 ) ? ' </a><span class="click-handler" data-role="touch-submenu-deployer"></span>' : '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

    }


    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        if ( is_object( $args[0] ) )
            $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}

class custom_sub_walker_footer_col1 extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 1, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\" submenu\">\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';
        // $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes = '';
        $classes[] = 'footer-bar__link ';

        /*grab the default wp nav classes*/
        $class_names = join( ' ', apply_filters( '', array_filter( $classes ), $item, $args ) );

        /*if the current item has children, append the dropdown class*/
        // if ( $args->has_children )
		// 	$class_names .= ' menu-item--has-submenu';

        /*if there aren't any class names, don't show class attribute*/
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';



        $output .= $indent . '<li' . $id . $value . $class_names .' data-role="touch-submenu">';

        $atts = array();
        $atts['target'] = ! empty( $item->target )  ? $item->target : '';
        $atts['title']  = ! empty( $item->title )   ? $item->title  : '';
        $atts['rel']    = ! empty( $item->xfn )     ? $item->xfn    : '';


        /*if the current menu item has children and it's the parent, set the dropdown attributes*/
        if ( $args->has_children && $depth === 0 ) {
            $atts['href']           = $item->url;
        } else {
            $atts['href'] = ! empty( $item->url ) ? $item->url : '';
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;

        $item_output .= '<a'. $attributes .'>';

        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

    /*  if the current menu item has children and it's the parent item, append the fa-angle-down icon*/
        $item_output .= ( $args->has_children && $depth === 0 ) ? ' </a>' : '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

    }


    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        if ( is_object( $args[0] ) )
            $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}
?>
