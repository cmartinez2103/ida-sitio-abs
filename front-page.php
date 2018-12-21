<?php
get_header();
global $pid, $current_lang;
?>
<main class="feature">
<?php
   get_template_part('partials/home/main', 'slider');

   if(get_field('habilitar_nuestra_comunidad'))
     get_template_part('partials/home/main', 'comunidad');

   if(get_field('habilitar_seccion_sedes'))
     get_template_part('partials/home/main', 'sedes' );

   if(get_field('habilitar_nuestra_proyecto'))
    get_template_part('partials/home/main', 'proyecto' );

   if (get_field('habilitar_actividades'))
    get_template_part('partials/home/main', 'actividades' );

   if(get_field('habilitar_vidaescolar'))
      get_template_part('partials/home/main', 'vida-escolar' );

   if(get_field('habilitar_horarios_departamentos'))
      get_template_part('partials/content/seccion', 'horarios-departamentos' );
?>
</main>
<?php get_footer(); ?>
