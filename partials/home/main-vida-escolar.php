<?php
$noticias_args = array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 3,
   'post_parent' => 0,
	'order' => 'DESC',
	'category_name' => 'noticias,videos,galerias'

);
$noticias_query = new WP_Query($noticias_args);
?>

<section class="horizon bg bg-light">
   <div class="container">
      <div class="horizon__intro horizon__intro--center">
         <?php
         $habilitar = get_field('activar_link_vidaescolar');
         $link = get_field('link_titulo_vidaescolar');
         $titulo = get_field('titulo_seccion_vidaescolar');
         ?>
         <?php
            $intro_seccion = '';
            $intro_seccion .= '<h2 class="horizon__title">';
            if ($habilitar):
               $intro_seccion .= '<a href="'.$link.'" title="Ir a '.$titulo.'">'.$titulo.'</a>';
            else:
               $intro_seccion .= $titulo;
            endif;
            $intro_seccion .= '</h2>';

            if ($habilitar):
            $intro_seccion .= '<a href="'.$link.'" title="Ir a '.$titulo.'" class="link link--more rigth big hide@tablet">ver más</a>';
            endif;

            echo $intro_seccion;
         ?>
      </div>
      <div class="row">
         <?php
            if($noticias_query->have_posts()):
               while($noticias_query->have_posts()):
                  $noticias_query->the_post();
                  echo get_simple_post($post, 'gr-4 gr-6@tablet gr-12@phablet');
               endwhile;
            endif;
            wp_reset_query();
         ?>
      </div>
   </div>
</section>
