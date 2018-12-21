<?php
$actividades_args = array(
	'post_type' => 'actividad',
	'post_status' => 'publish',
	'posts_per_page' => 4,
   'post_parent' => 0,
	'orderby' => 'menu_order',
	'order' => 'ASC'
);
$actividades_query = new WP_Query($actividades_args);
?>


<section class="horizon">
   <div class="container">
      <div class="horizon__intro horizon__intro--center">
			<?php
			$habilitar = get_field('activar_link_actividades');
			$link = get_field('link_titulo_actividades');
			$titulo = get_field('titulo_seccion_actividades');
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

      <div class="row box--row">
         <?php
            if($actividades_query->have_posts()):

               while($actividades_query->have_posts()):
                  $actividades_query->the_post();
                  echo get_simple_feature($post, 'gr-3 gr-6@tablet gr-12@phablet no-gutter', true);

               endwhile;
            endif;
            wp_reset_query();
         ?>
      </div>
   </div>
</section>
