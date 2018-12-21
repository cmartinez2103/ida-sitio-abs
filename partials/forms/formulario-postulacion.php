<div class="form-pasos--buttons">
   <button class="form-pasos--button one active" data-func="showTab" data-target="postulacion-alumno">1. Datos del alumno</button>
   <button class="form-pasos--button two" data-func="showTab" data-target="postulacion-apoderado">3. Datos del apoderado</button>
</div>
<div class="form-pasos--targets">
   <div class="form-pasos--target active" data-tabname="postulacion-alumno" data-validate="false">
      <div class="form-parent form-parent--postulacion" data-validate="false" >
         <form action="" method="post" id="postulacion-alumno" class="row">
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-alumno-nombre" class="form-control__label">Nombre del alumno</label>
               <input type="text" class="form-control__field" name="nombres" placeholder="Ingrese del nombre del alumno" required>
               <p class="form-control__text">Sólo caracteres alfabéticos</p>
            </div>
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-alumno-apellido-p" class="form-control__label">Primer apellido del alumno</label>
               <input type="text" class="form-control__field" name="apellido-p" placeholder="Ingrese el primer apellido" required >
               <p class="form-control__text">Sólo caracteres alfabéticos</p>
            </div>
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-alumno-apellido-m" class="form-control__label">Segundo apellido del alumno</label>
               <input type="text" class="form-control__field" name="apellido-m" placeholder="Ingrese el segundo apellido" required >
               <p class="form-control__text">Sólo caracteres alfabéticos</p>
            </div>
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-alumno-rut" class="form-control__label">Rut del alumno</label>
               <input type="text" class="form-control__field" name="rut_alumno" placeholder="Ingrese el rut del alumno" required>
               <p class="form-control__text">Ingrese un RUT válido, sin puntos y con guión</p>
            </div>
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-alumno-nacimiento" class="form-control__label">Fecha de nacimiento del alumno</label>
               <input type="text" class="form-control__field" name="nacimiento"  placeholder="01-01-2000" required>
               <p class="form-control__text">Sólo caracteres numéricos</p>
            </div>
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-alumno-curso" class="form-control__label">Curso</label>
               <select class="form-control__field form-control__field--select" name="curso" required>
                  <option value="">Elija curso al que desea postular</option>
                  <?php
                  $terms_niveles = get_niveles();
                  $option_niveles = '';
               	foreach($terms_niveles as $nivel){
               		$option_niveles .= '<option value="'. $nivel->name.'" >'. $nivel->name .'</option>';
               	}
                  ?>
                  <?php echo $option_niveles ?>

               </select>
               <p class="form-control__text">Selecciona el curso al cual tu hijo desea postular</p>
            </div>
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-alumno-ano" class="form-control__label">Año de postulación</label>
               <div class="form-control__group">
                  <span class="form-control__addon">20</span>
                  <input type="text" class="form-control__field" name="ano_postulacion" placeholder="Ingrese el año" required>
                  <p class="form-control__text">Sólo caracteres numéricos</p>
               </div>


            </div>
            <div class="form-control gr-12 gr-12@small form-control__action">
               <!-- <a href="#" class="button button-input button--main" data-target="postulacion-apoderado">Siguiente</a> -->
               <button class="button button-input button--main ad-event" data-target="postulacion-apoderado">Siguiente</button>
            </div>
         </form>
      </div>
   </div>
   <div class="form-pasos--target" data-tabname="postulacion-apoderado">
      <div class="form-parent form-parent--postulacion"  data-validate="false">
         <form action="" class="row" method="POST" id="postulacion-apoderado" >
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-apoderado-nombre" class="form-control__label">Nombre completo del apoderado</label>
               <input type="text" class="form-control__field" name="apoderado-nombre" placeholder="Ingrese del nombre completo del apoderado" required >
               <p class="form-control__text">Sólo caracteres alfabéticos</p>
            </div>
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-apoderado-email" class="form-control__label">Email</label>
               <input type="email" class="form-control__field" name="email" placeholder="Ingrese el email" required>
               <p class="form-control__text">Debe contener el valor “@“ Ej: mimail@empresa.com</p>
            </div>
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-apoderado-rut" class="form-control__label">Rut del apoderado</label>
               <input type="text" class="form-control__field" name="rut_apoderado" placeholder="Ej: 12345678-9" required>
               <p class="form-control__text">Ingrese un RUT válido, sin puntos y con guión</p>
            </div>
            <div class="form-control gr-6 gr-12@small" data-error-message="">
               <label for="postulacion-apoderado-telefono" class="form-control__label">Teléfono</label>
               <input type="text" class="form-control__field" name="telefono" placeholder="Ingrese el teléfono" required>
               <p class="form-control__text">Sólo caracteres numéricos</p>
            </div>
            <div class="form-control gr-12 gr-12@small form-control__action">
               <button  class="link link--more return sans" data-func="showTab" data-target="postulacion-alumno">Volver</button>
               <button type="submit" class="button button-input button--main ad-event">Enviar</button>
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
   </div>
</div>
