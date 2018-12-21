<?php

$namespace = 'api/v1';

//api rest para el tema
function endpoints() {
  //guardar form contacto
  register_rest_route('api/v1','/contact/',
    [
      'methods'  => 'post',
      'callback' => 'save_contact'
  ]);

  //guardar mensaje
  register_rest_route('api/v1','/message/',
    [
      'methods'  => 'post',
      'callback' => 'save_message'
  ]);

  //guardar form postulacion
  register_rest_route('api/v1','/postulacion/',
    [
      'methods'  => 'post',
      'callback' => 'save_postulacion'
  ]);

  //compartir post por email
  register_rest_route('api/v1','/shared-emails-post/',
    [
      'methods'  => 'post',
      'callback' => 'send_emails_post'
  ]);

  register_rest_route('api/v1','/send_prueba/',
    [
      'methods'  => 'get',
      'callback' => 'send_prueba'
  ]);

}
add_action('rest_api_init', 'endpoints');

//Agregando script
add_action('wp_enqueue_scripts','add_scripts');
function add_scripts(){
  wp_localize_script('main_script','data',[
    'base_url' => rest_url('/api/v1/')
  ]);
}



function send_mail($phpmailer){
   $phpmailer->isSMTP();
         $phpmailer->Host = get_field('host_phpmailer', 'options');
         $phpmailer->SMTPAuth = true; // Force it to use Username and Password to authenticate
         $phpmailer->Port = get_field('port_phpmailer', 'options');
         $phpmailer->Username = get_field('username_phpmailer', 'options');
         $phpmailer->Password = get_field('password_phpmailer', 'options');
         $phpmailer->SMTPSecure = get_field('encryption_phpmailer', 'options'); // Choose SSL or TLS, if necessary for your server
}
add_action('phpmailer_init', 'send_mail');


function send_prueba(){
       $to = 'cami.martinez@ida.cl';
       $subject = "prueba dos";
       $headers = ['Content-Type: text/html; charset=UTF-8','From:  <maria.dougnac@ddee.cl>'];
       $message = "prueba";
       $send = wp_mail($to, $subject, $message, $headers);
       var_dump($send);
}
//add_action( 'after_setup_theme', 'send_respuesta' );
