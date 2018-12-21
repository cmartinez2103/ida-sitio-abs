<?php
/*
* Template Name: Single Sede
* Template Post Type: Sede
*/
get_header();
the_post();
global $post;
$nombre_sede=$post->post_name;
?>
<main>
<?php get_template_part('partials/breadcrumb'); ?>
<?php get_template_part('partials/header/header', 'portada'); ?>

<!---NOTICIAS--->
<?php
if (get_field('habilitar_noticias_sede'))
   get_template_part('partials/sede/sede', 'noticia');

if (get_field('habilitar_galerias_sede'))
   get_template_part('partials/sede/sede', 'galeria');

if (get_field('habilitar_videos_sede'))
   get_template_part('partials/sede/sede', 'video');

if (get_field('habilitar_horarios_departamentos_sede'))
   get_template_part('partials/sede/sede', 'horario-departamento');

if (get_field('habilitar_seccion_profesores_sede'))
   get_template_part('partials/sede/sede', 'profesores');

   get_template_part('partials/sede/sede', 'contacto');

?>

</main>

<?php get_footer(); ?>
