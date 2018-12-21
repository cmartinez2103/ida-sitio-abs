<?php
/////////////////////////////////// Admin Overrides
require_once 'overrides.php';
/////////////////////////////////// funciones utilitarias agnósticas que no necesitan modificarse proyecto a proyecto
require_once 'utilities.php';
/////////////////////////////////// cajas de posts
require_once 'boxes.php';
/////////////////////////////////// módulos para páginas
require_once 'singular-modules.php';
/////////////////////////////////// shortcode para páginas y singles
require_once 'singular-shortcode.php';
/////////////////////////////////// formularios
require_once 'forms.php';
/////////////////////////////////// Funciones de api rest
require_once 'api-rest.php';

////////////////////////////////////
//////////////////Filtros y actions
////////////////////////////////////

//desactivar mensajes de actulizacion
// function remove_core_updates(){
//     global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
// }
//
// add_filter('pre_site_transient_update_core','remove_core_updates');
// add_filter('pre_site_transient_update_plugins','remove_core_updates');
// add_filter('pre_site_transient_update_themes','remove_core_updates');
// add_action('admin_head','remove_update_nag');

// function remove_update_nag() {
//     remove_action( 'admin_notices', 'update_nag', 3 );
// }
// setlocale(LC_ALL, 'es_CL');
