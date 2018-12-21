<?php
if( isset($_GET['tipo_sede']) && $_GET['tipo_sede']){
   $filtro_sede = $_GET['tipo_sede'];
}

$sedes = get_field('sedes', 'options');
foreach($sedes as $sede){
   $selected = '';
   $filtro_sede == $sede['value'] ? $selected = 'selected' : $selected = '';
   $option_sedes.= '<option value="'. $sede['value'] .'" '.$selected.'>'. $sede['label'] .'</option>';
}

 ?>

<div class="form-parent form-parent--contacto">
   <form action="#" class="row" method="post" id="admision-contacto">
      <div class="form-control gr-6 gr-12@small" data-error-message="">
         <label for="contacto-nombre" class="form-control__label">Nombre</label>
         <input type="text" class="form-control__field"  name="nombre" placeholder="Ingrese su nombre nombre" required data-custom-validation="onlyString">
         <p class="form-control__text">Sólo caracteres alfabéticos</p>
      </div>
      <div class="form-control gr-6 gr-12@small" data-error-message="">
         <label for="contacto-email" class="form-control__label">Email</label>
         <input type="email" class="form-control__field" name="email" placeholder="Ingrese su email" required>
         <p class="form-control__text">Debe contener el valor “@“ Ej: mimail@empresa.com</p>
      </div>
      <div class="form-control gr-6 gr-12@small" data-error-message="">
         <label for="contacto-consulta" class="form-control__label">Tipo de consulta</label>
         <select class="form-control__field form-control__field--select" name="tipo_consulta" required>
            <option value="">Seleccione un motivo de consulta</option>
            <?php
            $terms_consulta = get_tipo_consulta();
            $option_consulta = '';
            foreach($terms_consulta as $consulta){
               $option_consulta .= '<option value="'. $consulta->slug.'" >'. $consulta->name .'</option>';
            }
            ?>

            <?php echo $option_consulta ?>
         </select>
      </div>
      <div class="form-control gr-6 gr-12@small" data-error-message="">
         <label for="contacto-asunto" class="form-control__label">Asunto</label>
         <input type="text" class="form-control__field" name="asunto" placeholder="Ingrese su asunto" required>
         <p class="form-control__text">Sólo caracteres alfabéticos</p>
      </div>
      <div class="form-control gr-6 gr-12@small" data-error-message="">
         <label for="contacto-sede" class="form-control__label">Sede a contactar</label>
         <select class="form-control__field form-control__field--select" id="sede" name="sede" required>
            <option value="">Seleccione una sede</option>
            <?php echo $option_sedes; ?>
         </select>
      </div>
      <div class="form-control gr-12 gr-12@small" data-error-message="">
         <label for="contacto-mensaje" class="form-control__label">Mensaje</label>
         <textarea name="mensaje" rows="8" data-textcounter data-role="textcounter" maxlength="2000" class="form-control__field" placeholder="Ingrese su mensaje" data-autoresize></textarea>
         <p class="form-control__text">Máximo <strong data-role="countdown">2000</strong> caracteres</p>
      </div>
      <div class="form-control gr-12 gr-12@small form-control__action">
          <?php echo '<input type="hidden" id="form-ajax-nonce" value="' . wp_create_nonce( 'form-ajax-nonce' ) . '" />'; ?>
         <button id="btn-form-contact" type="submit" class="button button-input button--main ">Enviar</button>
      </div>
   </form>
   <div class="form-response" style="display: none;">
      <div class="form-response__respuesta">
         <figure class="form-response__figure"></figure>
         <h2 class="form-response__title"></h2>
         <p class="form-response__excerpt"></p>
         <a href="/" class="button button-input button--main">Volver a la Home</a>
      </div>
   </div>
</div>
