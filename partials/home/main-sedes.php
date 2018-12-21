<?php
$sedes_args = array(
	'post_type' => 'sede',
	'post_status' => 'publish',
	'posts_per_page' => -1,
   'post_parent' => 0,
	'orderby' => 'menu_order',
	'order' => 'ASC'
);
$sedes_query = new WP_Query($sedes_args);
?>

<section class="horizon">
   <div class="container">
      <div class="horizon__intro horizon__intro--center">
			<?php
         $habilitar = get_field('activar_link_sedes');
         $link = get_field('link_titulo_sedes');
         $titulo = get_field('titulo_seccion_sedes');
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
            if($sedes_query->have_posts()):
               $count = 1;
               while($sedes_query->have_posts()):
                  $sedes_query->the_post();
                  if($count == 1 || $count == 2):
                     $grid = 'gr-6 gr-12@tablet';
                  else:
                     $grid = 'gr-4 gr-6@tablet';
                  endif;
                  echo get_simple_sede($post, $grid .' gr-12@small no-gutter-px gutter-horizontal@small');
                  $count ++;
               endwhile;
            endif;
            wp_reset_query();
         ?>
      </div>
   </div>
</section>
