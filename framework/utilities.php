<?php
/////////////////////
////////////utilities
////////////////////

/**
* Anade o mezcla un array de tax_query existente con otro devolviendo el resultado
* @param  mixed - $old_tax_query - tax_query actual, puede estar vacio
* @param  array - $aditional_tax_query - tax_query que agregar
* @param  string $relation = relation del tax_query, default: "AND"
* @return array - tax_query formateado y mesclado
*/
function merge_tax_query( $old_tax_query, $aditional_tax_query, $relation = 'AND' ){
    if( !$old_tax_query || !is_array( $old_tax_query ) ){
        return array( $aditional_tax_query );
    }
    if( !isset($old_tax_query['relation']) || !$old_tax_query['relation'] ){
        $old_tax_query['relation'] = $relation;
    }
    $old_tax_query[] = $aditional_tax_query;
    return $old_tax_query;
}

/**
* Agrega clase font-size-medium al 1º <p> en el the_content para las páginas :
*/
function first_paragraph($content){
    if(is_page()) {
        return preg_replace('/<p([^>]+)?>/', '<p$1 class="first-paragraph">', $content, 1);
    }else{
        return $content;
    }
}
add_filter('the_content', 'first_paragraph');


/**
* cut_string_to
* @param  [string] $string     [Texto a cortar]
* @param  [int] $charnum       [Numero de caracteres máximo para el texto]
* @param  string $sufix        [Sufijo para el texto cortado]
* @return [string]             [Texto cortado]
*/
function cut_string_to( $string, $charnum, $sufix = ' ...' ){
    $string = strip_tags( $string );
    if( strlen($string) > $charnum ){
        $string = substr($string, 0, ($charnum - strlen( $sufix )) ) . $sufix;
    }
    return mb_convert_encoding($string, "UTF-8");
}

/**
* [printMe]
* Imprime en pantalla cualquier cosa entre <pre>
* @param  [mixed] $thing [description]
* @return void
*/
function printMe( $thing ){
    echo '<pre>';
    print_r( $thing );
    echo '</pre>';
}

/**
* [ensure_url]
* Convierte un string con forma de url en una URL valida, si ya es una URL valida entonces se devuelve tal cual
* @param  [type] $proto_url [description]
* @return [type]            [description]
*/
function ensure_url( $proto_url, $protocol = 'http' ){
    // se revisa si es un link interno primero
    if( substr($proto_url, 0, 1) === '/' ){
        return $proto_url;
    }
    if (filter_var($proto_url, FILTER_VALIDATE_URL)) {
        return $proto_url;
    }
    elseif( substr($proto_url, 0, 7) !== 'http://' || substr($proto_url, 0, 7) !== 'https:/' ){
        $url = $protocol . '://' . $proto_url;
    }
    // doble chequeo de validacion de URL
    if ( ! filter_var($url, FILTER_VALIDATE_URL) ) {
        return '';
    }
    return $url;
}

/**
 * Permite la subida y utilización de archivos SVG
*/
add_filter( 'upload_mimes', 'custom_upload_mimes' );
function custom_upload_mimes( $existing_mimes = array() ) {
    // Add the file extension to the array
    $existing_mimes['svg'] = 'image/svg+xml';
    return $existing_mimes;
}

/**
* Devuelve la URL de un attachment o false si no se encuentra el attachment
* @param  [int] $id   ID del attachment
* @param  [string] $size Nombre del tamano a sacar
* @return [string] URL de la imagen en el tamano solicitado (false si es que falla)
*/
function get_image_src( $id, $size ){
    $img_data = wp_get_attachment_image_src( $id, $size );
    if( empty($img_data) ){ return false; }
    return $img_data[0];
}

/**
* Revisa si el script dado ya se encuentra en la cola de impresion
* si no es asi lo mete en la cola
* @param  [string] $script_name [nombre del script a incluir]
* @return void
*/
function needs_script( $script_name ){
    if( !wp_script_is( $script_name ) ){
        wp_enqueue_script( $script_name );
    }
}

/**
* Devuelve el nombre del rol de un usuario
* @param  [object] $user Objeto de usuario de wordpress
* @return [string]
*/
function get_user_role( $user ) {
    $user_roles = $user->roles;
    $user_role = array_shift($user_roles);
    return $user_role;
}


/**
* [object_to_array]
* Devuelve el nombre del rol de un usuario
* @param  [object] recibe un objeto o un array con obejtos y lo transforma recursivamente en solo array
* @return [array]
*/
function object_to_array($obj) {
    if(is_object($obj)) $obj = (array) $obj;
    if(is_array($obj)) {
        $new = array();
        foreach($obj as $key => $val) {
        $new[$key] = object_to_array($val);
        }
    }
    else $new = $obj;
    return $new;
}


/**
* Devuelve la extension del archivo
* @param  string $file_path - PATH al archivo
* @return string - Extension del archivo
*/
function parse_mime_type( $file_path ) {
    $chunks = explode('/', $file_path);
    return substr(strrchr( array_pop($chunks) ,'.'),1);
}

/**
* Devuelve el peso del archivo formateado
* @param  string $attachment_file_path - PATH al archivo
* @return string - Tamano formateado en kb
*/
function get_attachment_size( $attachment_file_path ) {
    return size_format( filesize( $attachment_file_path ) );
}
/**
* Devuelve el un post_meta solicitado de todos los post
* @param  string $key meta_key
* @param  string  $type  post type
* @param  string  $status  status
* @return string HTML de la paginacion
*/
function get_meta_values( $key = '', $type = 'post', $status = 'publish' ) {
	global $wpdb;
	if( empty( $key ) )
	return;
	$r = $wpdb->get_results( $wpdb->prepare( "
	SELECT p.ID, pm.meta_value FROM {$wpdb->postmeta} pm
	LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
	WHERE pm.meta_key = '%s'
	AND p.post_status = '%s'
	AND p.post_type = '%s'
	", $key, $status, $type ));

	foreach ( $r as $my_r )
	$metas[$my_r->ID] = $my_r->meta_value;

	return $metas;
}

add_shortcode('random_text', 'random_text_shortcode');
function random_text_shortcode( $atts, $content = ''){
    $long = $atts["long"];
    $string = 'Originalmente, fue la denominación de una institución educativa de la Atenas clásica: la Academia fundada por Platón, que debía su nombre a un héroe legendario de la mitología griega, Academo. Estaba ubicada en el demo de Kolonos,4 a un kilómetro al noroeste de la ciudad, en unos terrenos adquiridos por Platón alrededor del 384 a. C., donde existía un olivar, un parque y un gimnasio. La instrucción allí impartida incluía el estudio de las matemáticas, la dialéctica y las ciencias naturales. Hubo otras instituciones similares en la antigüedad, como el Liceo aristotélico; aunque ninguna se denominó La escuela de Atenas, título de uno de los frescos de Rafael en las estancias vaticanas donde se representa ucrónicamente a los sabios de la Antigüedad con los rostros de sus contemporáneos (1510-1512). Las instituciones científicas5 de la antigua Alejandría (Museo, Biblioteca) o las reuniones de intelectuales de la antigua Roma (como los del círculo de Mecenas o los de la corte de Augusto, o el Ateneo o "escuela romana" de Adriano), que hasta cierto punto compartían funciones con aquéllas, a veces son denominadas "academias", aunque no es habitual.6 La Academia platónica y las demás instituciones culturales consideradas "paganas" por los cristianos subsistieron hasta el año 529 cuando el emperador bizantino Justiniano I ordenó su clausura.';
    return cut_string_to($string,$long);
}

function random_text($long){
    $string = 'Originalmente, fue la denominación de una institución educativa de la Atenas clásica: la Academia fundada por Platón, que debía su nombre a un héroe legendario de la mitología griega, Academo. Estaba ubicada en el demo de Kolonos,4 a un kilómetro al noroeste de la ciudad, en unos terrenos adquiridos por Platón alrededor del 384 a. C., donde existía un olivar, un parque y un gimnasio. La instrucción allí impartida incluía el estudio de las matemáticas, la dialéctica y las ciencias naturales. Hubo otras instituciones similares en la antigüedad, como el Liceo aristotélico; aunque ninguna se denominó La escuela de Atenas, título de uno de los frescos de Rafael en las estancias vaticanas donde se representa ucrónicamente a los sabios de la Antigüedad con los rostros de sus contemporáneos (1510-1512). Las instituciones científicas5 de la antigua Alejandría (Museo, Biblioteca) o las reuniones de intelectuales de la antigua Roma (como los del círculo de Mecenas o los de la corte de Augusto, o el Ateneo o "escuela romana" de Adriano), que hasta cierto punto compartían funciones con aquéllas, a veces son denominadas "academias", aunque no es habitual.6 La Academia platónica y las demás instituciones culturales consideradas "paganas" por los cristianos subsistieron hasta el año 529 cuando el emperador bizantino Justiniano I ordenó su clausura.';
    return cut_string_to($string,$long);
}

//live preview
// function ci_customizer_live_preview(){
//     wp_enqueue_script( 'ci_themecustomizer', get_template_directory_uri().'/scripts/theme-customizer.js', array( 'jquery','customize-preview' ), '', true );
// }
// add_action( 'customize_preview_init', 'ci_customizer_live_preview' );


/**
* Setea el contenido de un email a html
* se usa en send_custom_email
*/
function set_html_content_type(){
    return 'text/html';
}

//FUNC:
//Load template part, use inside echo
function load_template_part($template_name, $part_name=null) {
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

/**
 * [generate_hs_urls]
 * @param  [object]     $post_object
 * @return [array]      URLs para compartir el post
 */
function generate_share_urls( $post_object, $custom_message = false, $target = false, $content_field = false ){
    $shortlink = wp_get_shortlink( $post_object->ID );
    if( $target ){
        $shortlink = $shortlink . '#' . $target;
    }
    $clean_url = urldecode( $shortlink );
    $title = urlencode( get_the_title( $post_object->ID ) );
    if( $custom_message ){
        $message = urlencode( cut_string_to( $custom_message, 70 ) );
    }
    elseif( $content_field ){
        $message = urlencode( cut_string_to( get_field($content_field, $post_object->ID), 70 ) );
    }
    else {
        $message = urlencode( cut_string_to( $post_object->post_content, 70 ) );
    }
    $image_url = '';
    if( has_post_thumbnail( $post_object->ID ) ){
        $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_object->ID ), 'full' );
        $image_url = $image_url[0];
    }
    $fb_link = 'http://www.facebook.com/sharer.php?u=' . get_permalink( $post_object->ID );
    $twt_link = 'https://twitter.com/intent/tweet?text=' . $title . '+' . get_permalink( $post_object->ID );
    $google_link = 'https://plus.google.com/share?url=' . get_permalink( $post_object->ID );
    $linkedin_link = 'https://www.linkedin.com/cws/share?url=' . get_permalink( $post_object->ID );
    $whatsapp_link = 'whatsapp://send?text==' . get_permalink( $post_object->ID );

    return array(
        'facebook' => $fb_link,
        'twitter' => $twt_link,
        'google' => $google_link,
        'linkedin' => $linkedin_link,
        'shortlink' => $shortlink,
        'whatsapp' => $whatsapp_link,
        'permalink' => get_permalink( $post_object->ID )
    );
}

function gmap_url($address){
    $address = urlencode($address);
    $address = ensure_url('www.google.com/maps/place/' . $address);
    return $address;
}

function clean_string($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function sort_eventos($a, $b) {
    return $a['fecha_inicio'] - $b['fecha_inicio'];
}

function get_embed_video($videourl) {
    $string     = $videourl;
    $search     = '/youtube\.com\/watch\?v=([a-zA-Z0-9]+)/smi';
    $replace    = "youtube.com/embed/$1";
    $url = wp_oembed_get(ensure_url($videourl));
    return $url;
}

function get_json_content( $content ){
    return json_encode($content);
}

function get_placeholder_image($class){
    return '<img src="http://capacitacion.santotomas.dev.ida.cl/wp-content/uploads/sites/11/2018/02/placeholder-color.png" alt="Placeholder Capacitación" class="'.$class.'"/>';
}

function json_metadata($array){
    $printjson = '<script type="application/ld+json">' . json_encode($array, JSON_PRETTY_PRINT) . '</script>';
    return $printjson;
}


/**
* Devuelve o imprime la vista solicitada
*
* @param view_args
* @return html
*/

function load_view($file,$view_args = array(),$print = false){
  if ( file_exists( get_template_directory() . '/' . $file . '.php' ) )
  $file = get_template_directory() . '/' . $file . '.php';
  else
  return false;

  extract($view_args);

  ob_start();
  $return = require( $file );
  $data = ob_get_clean();

  if(!$print)
  if ($return === false)
  return false;
  else
  return $data;
  else
  echo $data;
};

/**
* Realiza las validaciones del campo dado
*
*/
function validate($nombre,$tag = '',$validaciones){
		$input = isset($_POST[$nombre]) ? $_POST[$nombre] : '';
		$val = explode("|",$validaciones);
		$errors = [];
		$tag = empty($tag) ? $nombre : $tag;

		foreach ($val as $key => $value):
				if(strpos($value,':')):
					$exp = explode(':',$value);
					$value = $exp[0];
					$args = $exp[1];
        endif;

        //var_dump($value);
				if($value == 'required'):
					if(empty($input))
					$errors[$nombre][] = 'El campo '.$tag.' es requerido';
        endif;

				if($value == 'numeric'):
					if(!is_numeric($input))
						$errors[$nombre][] = 'El campo '.$tag.' debe ser numerico';
				endif;

				if($value == 'alpha'):
					if(!ctype_alpha($input)):
						$errors[$nombre][] = 'El campo '.$tag.' acepta solo letras';
					endif;
				endif;

        if($value == 'alpha_space'):
          if(!preg_match('/^[A-Z ]+$/i', $input)):
            $errors[$nombre][] = 'El campo '.$tag.' acepta solo letras';
          endif;
        endif;

				if($value == 'email'):
					if(!filter_var($input, FILTER_VALIDATE_EMAIL))
						$errors[$nombre][] = 'El email es invalido';
        endif;

        //func is rut :300
        if($value == 'rut'):
          if(!is_rut($input)):
            $errors[$nombre][] = 'El rut es invalido. Ej: 12345678-9';
          endif;
        endif;

				if($value == 'between'):
					list($num1,$num2) = explode(",",$args);
					if(!(mb_strlen($input) >= intval($num1) && mb_strlen($input) <= intval($num2))):
						$errors[$nombre][] = 'El campo '.$tag.' debe tener un rango entre '.$num1.' a '.$num2.' caracteres';
					endif;
				endif;

        if($value == 'maxlength'):
					if((mb_strlen($input) > intval($args))):
						$errors[$nombre][] = 'El campo '.$tag.' debe ser inferior a '.$args.' caracteres';
					endif;
				endif;

        if($value == 'minlength'):
					if((mb_strlen($input) < intval($args))):
						$errors[$nombre][] = 'El campo '.$tag.' debe ser superior a '.$args.' caracteres';
					endif;
				endif;

        if($value == 'maxdate'):
          $fecha = date('d-m-Y');
          $nuevafecha = strtotime ( '+'.$args.' year' , strtotime ( $fecha ) ) ;

          if(strtotime($input) > $nuevafecha):
            $errors[$nombre][] = 'El campo '.$tag.' debe ser una fecha inferior a '.date('d-m-Y',$nuevafecha).'';
          endif;
				endif;

        if($value == 'mindate'):
          $fecha = date('d-m-Y');
          $nuevafecha = strtotime ( '-'.$args.' year' , strtotime ( $fecha ) ) ;

					if(strtotime($input) < $nuevafecha):
						$errors[$nombre][] = 'El campo '.$tag.' debe ser una fecha superior a '.date('d-m-Y',$nuevafecha).'';
					endif;
				endif;

		endforeach;

    if(isset($_POST['errors']))
      $_POST['errors'] = array_merge($_POST['errors'],$errors);
    else
      return $errors;
}

function is_rut($rut){
    $rut = strtolower($rut);
    if(strrpos($rut, '.') !== false){
      return false;
    }
    if(strrpos($rut, '-') === false){
      return false;
    }
    $rut = preg_replace('/[^k0-9]/i', '', $rut);
    $dv  = substr($rut, -1);
    $numero = substr($rut, 0, strlen($rut)-1);
    $i = 2;
    $suma = 0;
    foreach(array_reverse(str_split($numero)) as $v){
        if($i==8)
            $i = 2;
        $suma += $v * $i;
        ++$i;
    }
    $dvr = 11 - ($suma % 11);

    if($dvr == 11){
      $dvr = 0;
    }
    if($dvr == 10){
      $dvr = 'K';
    }

    if($dvr == strtoupper($dv) && strlen($rut) >= 8){
        return true;
    }else{
        return false;
    }
}

function to_rut($rut_param, $type = 'full') {

  if($rut_param):
  //validaciones varias
    $rut = preg_replace('/[^k0-9]/i', '', $rut_param);
    $length = strlen($rut);

    if($length == 9):
      //....
      $parte1 = substr($rut, 0,2); //12
      $parte2 = substr($rut, 2,3); //345
      $parte3 = substr($rut, 5,3); //456
      $parte4 = substr($rut, 8);   //todo despues del caracter 8
    else:
      $parte1 = substr($rut, 0,1); //1
      $parte2 = substr($rut, 1,3); //123
      $parte3 = substr($rut, 4,3); //456
      $parte4 = substr($rut, 7);   //todo despues del caracter 7
    endif;

    if($type == 'nodot'){
      return $parte1.$parte2.$parte3.'-'.$parte4;
    }elseif($type == 'numeric'){
      return $parte1.$parte2.$parte3.$parte4;
    }else{
      return $parte1.'.'.$parte2.'.'.$parte3.'-'.$parte4;
    }
  else:
    return false;
  endif;
}
?>
