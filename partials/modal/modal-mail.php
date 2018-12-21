<div class="form-parent">
	<section id="section-form-shared-email" class="modal-box" data-role="modal-content">
		<h5 class="modal-box__title text-upper">Compartir página por e-mail</h5>
		<form action="" id="form-shared-email" method="post" class="" novalidate autocomplete="off">
	        <div class="form-control" data-error-message="Ingrese sólo valores alfabéticos">
	            <label for="enviar-correo-nombre" class="form-control__label">Tu nombre*:</label>
	            <input type="text" class="form-control__field" name="nombre" placeholder="Ingresa tu nombre" data-custom-validation="onlyString"  required>
	            <span class="form-control__text">Debe contener solo valores alfabéticos. Ejemplo: Francisco</span>
	        </div>
	        <div class="form-control" data-error-message="Ingresa sólo correos válidos">
	            <label for="enviar-correo-para" class="form-control__label">Para*:</label>
	            <input type="email" class="form-control__field" name="emails" placeholder="nombre1@email.com, nombre2@email.com" required>
	            <span class="form-control__text">Ingresa sólo correos válidos. Ejemplo: nombre@email.com</span>
	        </div>
	        <div class="form-control" data-error-message="Este es un campo requerido">
	            <label for="enviar-correo-nombre" class="form-control__label">Agregar nota*:</label>
	            <textarea name="nota" rows="5" class="form-control__field" placeholder="Escribe aquí un mensaje personal" required></textarea>
	            <span class="form-control__text">Debe contener solo valores alfabéticos</span>
	        </div>
	        <div class="form-control font-centered">
					<button type="submit" class="button button-input button--main">Enviar</button>
	        </div>
	    </form>
	</section>
	<section id="section-shared-email-exito" class="modal-box form-response" data-role="modal-content" style="display:none;">
		<div class="form-response__respuesta">
			<figure class="form-response__figure">
			</figure>
			<h2 class="form-response__title">¡Página compartida exitosamente!</h2>
			<p class="form-response__excerpt">
				Hemos enviado tu mensaje a el (los) destinatario(s) que ingresaste.
			</p>
		</div>
	</section>
</div>
