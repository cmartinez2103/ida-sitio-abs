<?php
/**
 * Págnia con generador de nonces para saltarse el cache con ESI Varnish
 */
add_action('init', 'esi_nonce');
function esi_nonce(){
    add_rewrite_rule('esi-nonce$', 'index.php?esi=nonce', 'top');
}
/// anade los query vars customizados a la wp_query
add_filter('query_vars', 'esi_query_vars');
function esi_query_vars( $vars ){
    $vars[] = 'esi';
    return $vars;
}

///Funciones de Pumahue

function sendMail($settings) {
	$result = wp_mail($settings['to'], $settings['subject'], $settings['html'], $settings['headers'], $settings['attachment']);

	if($result==true){
		return 1;
	}
	elseif($result==false){
		return 0;
	}
}

function generate_email_template($data = array(), $template = '') {
	$html = load_view("partials/email/".$template,compact('data'));
	return $html;
}


/**
** Guarda formulario de contacto
**/
function save_contact(WP_REST_Request $request){
   //printme($request);
   //printme($request->get_params());
	$_POST = $post = $request->get_params();
	$_POST['errors'] = array();
   $resp = false;

	if( !isset( $post['security'] ))
	return json_encode(['msg'=>'Hubo un problema al guardar el mensaje, por favor intente de nuevo','code' => 500]);

	validate('nombre','nombre','required|between:2,30');
	validate('email','email','required|email|between:5,30');
	validate('sede','sede','required');
   validate('tipo_consulta','consulta','required');
	validate('asunto','asunto','required');
	validate('mensaje','mensaje','required|between:5,2000');

	if(!empty($_POST['errors'])):
		foreach ($_POST['errors'] as $key => $value):
			$data['data'][$key] = $value[0];
		endforeach;
		$data['code'] = 422;
		return json_encode($data);
	endif;

   if (function_exists('add_contact_module')):
		$resp = add_contact_module($post);
	endif;

	//Footer email construct
	$rrss = get_field('redes_sociales', 'option');

	if($rrss){
		$social = "";
		foreach($rrss as $rs){
			$social .= '<a style="width: auto; display: inline; float: left; margin: 0 4px;" href="'.ensure_url($rs['link_red_social']).'" target="_blank" title="Ir a '.$rs['tipo_red_social'].'"><img style="width: 16px; height: auto;" src="'.get_template_directory_uri() . '/dist/img/iconos/icon-'.$rs['tipo_red_social'].'.png'.'"/></a>';
		}
	}

	//Footer email data
	$footer_mail = '';
	$footer_mail .=	'<p style="display: inline-block; margin: 8px 0; text-align: center; overflow: hidden;">'.$social.'</p>';
   $footer_mail .=      get_field('firma_administrador', 'options');

	// datos email ADMINISTADOR
	$email_html = generate_email_template( array(
      'mail_titulo' => get_field("subject_administrador_form_contacto", "option"),
      'mail_html' => get_field("mensaje_administrador_form_contacto", "options"),
      'mail_nombre_firma' => $footer_mail,
      'imagen_encabezado' =>  get_field('logo_header', 'option')), 'form-contacto' );

	foreach ($post as $key => $value) {
		$email_html = str_replace('%recipient.'.$key.'%', $value, $email_html);
	}
   $tipo_consulta = $post['tipo_consulta'];
   $email_admin = array();
   $adminsitradores = get_field("mails_contacto_asuntos", "option");
   if($adminsitradores):
      foreach ($adminsitradores as $admin) {
         if($admin['asunto'] == $tipo_consulta):
            $email_admin[$admin["email"]] = $admin["nombre"];
         endif;
      }
   endif;

	// enviando email ADMINITRADOR
	$mail_admin = sendMail(array(
      'html' => $email_html,
      'subject' => get_field("subject_administrador_form_contacto", "option"),
      'to' => implode(",", array_keys($email_admin)),
      'headers' => ['Content-Type: text/html; charset=UTF-8','From:  '.get_field("from_name_phpmailer", "options").' <'.get_field('username_phpmailer', 'options').'>'],
      'attachment' => false, ));

	// datos email USUARIO
	$user_html = generate_email_template( array(
      'mail_titulo' => get_field("subject_usuario_form_contacto", "option"),
      'mail_html' => get_field("mensaje_usuario_form_contacto", "options"),
      'mail_nombre_firma' => $footer_mail,
      'imagen_encabezado' => get_field('logo_header', 'option')), 'form-contacto' );

	foreach ($post as $key => $value) {
		$user_html = str_replace('%recipient.'.$key.'%', $value, $user_html);
	}

	// enviando email USUARIO
 	$mail_user = sendMail(array(
      'html' => $user_html,
      'subject' => get_field("subject_usuario_form_contacto", "option"),
      'to' => $post['email'],
      'headers' => ['Content-Type: text/html; charset=UTF-8','From:  '.get_field("from_name_phpmailer", "options").' <'.get_field("username_phpmailer", "options").'>'],
      'attachment' => false));

	if($resp):
		return json_encode(['msg'=>'Su mensaje se ha enviado exitosamente. Pronto lo contactaremos','code' => 200]);
	else:
		return json_encode(['msg'=>'Hubo un problema al guardar el mensaje, por favor intente de nuevo','code' => 500]);
	endif;

}


/**
** Guarda formulario de contacto
**/
function save_message(WP_REST_Request $request){
	$_POST = $post = $request->get_params();
	$_POST['errors'] = array();
	$resp = false;

	if( !isset( $post['security'] ))
	return json_encode(['msg'=>'Hubo un problema al guardar el mensaje, por favor intente de nuevo','code' => 500]);

	validate('code','codigo','required');
	validate('id','id','required');
	validate('message','mensaje','required|between:5,2000');

	if(!empty($_POST['errors'])):
		foreach ($_POST['errors'] as $key => $value):
			$data['data'][$key] = $value[0];
		endforeach;
		$data['code'] = 422;
		return json_encode($data);
	endif;

	if (function_exists('save_message_module')):
		$resp = save_message_module(['code'=>$post['code'],'type'=>'user','message' => $post['message'],'message_id'=>$post['id']]);
	endif;

	if($resp):
		return json_encode(['msg'=>'Su mensaje se ha enviado exitosamente. Pronto lo contactaremos','code' => 200]);
	else:
		return json_encode(['msg'=>'Hubo un problema al guardar el mensaje, por favor intente de nuevo','code' => 500]);
	endif;

}


/**
**	Guarda formulario de postulacion
**/
function save_postulacion(WP_REST_Request $request){
	$_POST = $post = $request->get_params();
	$_POST['errors'] = array();

	if(isset($post['form'])):

		if($post['form'] == 'alumno' || $post['form'] == 'all'):
			validate('nombres','nombres','required|between:2,15');
			validate('apellido-p','primer apellido','required|alpha|between:2,15');
			validate('apellido-m','segundo apellido','required|alpha|between:2,15');
			validate('nacimiento','fecha de nacimiento','required|between:5,10');
			validate('curso','curso','required');
			validate('ano_postulacion','ano de postulacion','required|maxlength:2');
			//si el campo no entra vacío realiza la validación de rut
			//validate(rut) framework/helpers.php :248

			validate('rut_alumno','rut alumno','required|rut');


			if (preg_match("/([0-9]{2})-([0-9]{2})-([0-9]{4})/", $post['nacimiento'], $matches)):
				if (!checkdate($matches[2], $matches[1], $matches[3])): $errors['nacimiento'][] = 'Fecha de nacimiento con formato invalido'; endif;
			else:
				$_POST['errors']['nacimiento'][] = 'Fecha de nacimiento con formato invalido';
			endif;
		endif;

		if($post['form'] == 'all'):
			validate('apoderado-nombre','nombre del apoderado','required|between:5,30');
			validate('telefono','telefono','required|numeric|between:7,9');
			validate('email','','required|email');
			//validate(rut) framework/helpers.php :248
			validate('rut_apoderado','rut apoderado','required|rut');
		endif;

		//verifico si los form estan validados
		if(!empty($_POST['errors'])):
			foreach ($_POST['errors'] as $key => $value): $data['data'][$key] = $value[0]; endforeach;
			$data['code'] = 422;
			return json_encode($data);
		endif;

		if($post['form'] == 'all'):

			$id = wp_insert_post(array(
				'post_type' => 'postulacion',
				'post_title' => 'Postulacion en '. $post['curso'],
				'ping_status' => 'close',
            'post_status' => 'draft',
				'comment_status' => 'close'
			));

			$post['ano_postulacion'] = $post['ano_postulacion'] + 2000;
			$post['rut_alumno'] = to_rut($post['rut_alumno'], 'nodot');
			$post['rut_apoderado'] = to_rut($post['rut_apoderado'], 'nodot');


			update_field('field_59c2d6d29d88a', $post['nombres'], $id);
			update_field('field_59c2d6dd9d88b', $post['apellido-p'], $id);
			update_field('field_59c2d6fa9d88c', $post['apellido-m'], $id);
			update_field('field_59c2d7059d88d', $post['nacimiento'], $id);
			update_field('field_59c2d7389d88e', $post['curso'], $id);
			update_field('field_59c2d77b9d891', $post['apoderado-nombre'], $id);
			update_field('field_59c2d7919d892', $post['email'], $id);
			update_field('field_59c2d7979d893', $post['telefono'], $id);
			update_field('field_5a5d079bec005', $post['ano_postulacion'], $id);
			update_field('field_5b4527208d3dc', $post['rut_alumno'], $id);
			update_field('field_5b45ffbe08e3b', $post['rut_apoderado'], $id);

			// datos email administrador
			$email_html = generate_email_template([
            'mail_titulo' => get_field("subject_administrador_form_postulacion", "option"),
            'mail_html' => get_field("mensaje_administrador_form_postulacion", "options"),
            'mail_nombre_firma' => get_field("firma_administrador", "options"),
            'imagen_encabezado' => get_field('logo_header', 'option')], 'form-contacto' );

			foreach ($post as $key => $value) {
				$email_html = str_replace('%recipient.'.$key.'%', $value, $email_html);
			}

			$email_admin = array();
			//$email_admin[get_field("mail_reply_principal", "options")] = get_field("nombre_reply_principal", "options");
      	$adminsitradores = get_field("administradores_postulacion", "options");
      	if($adminsitradores):
      		foreach ($adminsitradores as $admin) {
      			$email_admin[$admin["email"]] = $admin["nombre"];
      		}
      	endif;

			// enviando email administrador
			$mail_admin = sendMail([
            'html' => $email_html,
            'subject' => get_field("subject_administrador_form_postulacion", "option"),
            'to' => implode(",", array_keys($email_admin)),
            'headers' => ['Content-Type: text/html; charset=UTF-8','From:  '.get_field("from_name_phpmailer", "options").' <'.get_field("username_phpmailer", "options").'>'],
            'attachment' => false ]);
			// datos email usuario
			$user_html = generate_email_template( [
            'mail_titulo' => get_field("subject_usuario_form_postulacion", "option"),
            'mail_html' => get_field("mensaje_usuario_form_postulacion", "options"),
            'mail_nombre_firma' => get_field("firma_administrador", "options"),
            'imagen_encabezado' => get_field('logo_header', 'option')], 'form-contacto' );

			foreach ($post as $key => $value) {
				$user_html = str_replace('%recipient.'.$key.'%', $value, $user_html);
			}

			// enviando email usuario
			$mail_user = sendMail([
            'html' => $user_html,
            'subject' => get_field("subject_usuario_form_postulacion", "option"),
            'to' => $post['email'],
            'headers' => ['Content-Type: text/html; charset=UTF-8','From:  '.get_field("from_name_phpmailer", "options").' <'.get_field("username_phpmailer", "options").'>'],
            'attachment' => false ]);

   			if($id)
			return json_encode(['msg'=>'La postulación se registró con éxito','code' => 200]);
			else
			return json_encode(['msg'=>'Hubo un problema al guardar la postulación, por favor intente de nuevo','code' => 500]);

		endif;
		return json_encode(['msg'=>'','code' => 200]);
	endif;

	return json_encode(['msg'=>'','code' => 500]);
}

/**
** Compartir post por emails
**/
function send_emails_post(WP_REST_Request $request){
	$_POST = $post = $request->get_params();
	$_POST['errors'] = array();
	$emails = array();

	validate('nombre','nombre','required|alpha_space|between:5,30');
	validate('emails','emails','required');
	validate('nota','nota','required|between:5,300');

	if(!empty($post['emails'])):
		if(strpos(trim($post['emails']),',')):
			foreach (explode(',',trim($post['emails'])) as $key => $email):
				$emails[] = trim($email);
				if(!filter_var(trim($email), FILTER_VALIDATE_EMAIL)):
					$_POST['errors']['emails'][] = 'El email es invalido';break;
				endif;
			endforeach;
		else:
			$emails[] = trim(trim($post['emails']));
			if(!filter_var(trim($post['emails']), FILTER_VALIDATE_EMAIL))
			$_POST['errors']['emails'][] = 'El email es invalido';
		endif;
	endif;


	if(!empty($_POST['errors'])):
		foreach ($_POST['errors'] as $key => $value):
			$data['data'][$key] = $value[0];
		endforeach;
		$data['code'] = 422;
		return json_encode($data);
	endif;

	// html
	$email_html = generate_email_template(array(
      'mail_titulo' => $post['nombre'].' te quiere compartir una página',
      'nombre' => $post['nombre'],
      'nota' => $post['nota'],
      'url' => $post['url'],
      'title' => $post['title'],
      'imagen_encabezado' => get_field('logo_header', 'option')), 'compartir' );

	// enviando email
	$send = sendMail([
      'html' => $email_html,
      'subject' => $post['nombre'].' te quiere compartir una página',
      'to' => $emails,
      'headers' => ['Content-Type: text/html; charset=UTF-8','From:  '.get_field("from_name_phpmailer", "options").' <'.get_field("username_phpmailer", "options").'>'], 'attachment' => false ]);

	if($send)
	return json_encode(['msg'=>'','code' => 200]);
}

?>
