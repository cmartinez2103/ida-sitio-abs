<?php
/**
**  Template Name: Plantilla Responder Contacto
**/

$code = false;$message=false;$verify=false;
if(isset($_GET) && isset($_GET['code']) && isset($_GET['message'])):
  $code = $_GET['code'];
  $message = $_GET['message'];

  if (function_exists('add_contact_module')):
    $verify = get_message_module(['code' => $code,'id' => $message]);
  endif;

endif;

get_header(); ?>
<main>
  <?php
  while ( have_posts() ) : the_post();

 get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
      <div class="container">
         <div class="row">
            <div class="gr-12 gr-12@tablet">
               <h2 class="horizon__title horizon__title--page">Responder Mensaje</h2>

               <form action="" method="post" id="admision-message" class="gridle-row" novalidate>

                  <div class="gr-12">
                     <div class="form-control" data-error-message="Este campo es obligatorio">
                     <label for="contacto-mensaje" class="form-control__label">Mensaje *</label>
                     <?php wp_editor("","tiny",array("textarea_rows" => 2,"media_buttons"=>false,'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' )));?>
                     <p class="form-control__text">Máximo <strong id="max-dead">2000</strong> caracteres</p>
                     </div>
                  </div>

                  <input type="hidden" name="id" value="<?php echo $message; ?>"/>
                  <input type="hidden" name="code" value="<?php echo $code; ?>"/>

                  <div class="gr-12">
                     <?php echo '<input type="hidden" id="form-ajax-nonce" value="' . wp_create_nonce( 'form-ajax-nonce' ) . '" />' ?>

                     <button id="btn-form-message" type="submit" class="button button-input button--main" <?php if(!$verify):?> disabled <?php endif;?>>Enviar</button>
                  </div>
                  <p class="form-control__text">*Campos obligatorios</p>
               </form>

               <div id="msj_message"> </div>
            </div>
         </div>
      </div>
   </section>
  <?php
endwhile; // End of the loop.
?>
</main><!-- #main -->
<?php
get_footer();
