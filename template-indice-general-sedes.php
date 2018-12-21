<?php
/*Template name: Indice general sedes*/
get_header();
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <?php get_template_part('partials/header/header', 'indice-general'); ?>

   <section class="horizon--inner">
		<div class="container">
         <?php
         $activar_paginas_hijas_auto = get_field('activar_paginas_auto');
         $activar_paginas_hijas_manual = get_field('activar_paginas_manual');
         $paginas_hijas_manual = get_field('enlaces_manual');
         $grid = get_field('columnas');
         if (empty($grid)) {
            $grid = '4';
         }else {
            $grid = $grid;
         }

         $paginas_hijas_args = array(
            'post_type' => 'sede',
            'post_status' => 'publish',
            'post_parent' => 0,
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
         );

         $paginas_hijas_query = new WP_Query($paginas_hijas_args);?>
         <div class="row">
            <?php
            if ($activar_paginas_hijas_auto):
               if($paginas_hijas_query->have_posts()):
                  $count = 1;
                  while ( $paginas_hijas_query->have_posts() ) :
                     $paginas_hijas_query->the_post();
                     if($count == 1 || $count == 2):
                        $grid = 'gr-6 gr-12@tablet';
                     else:
                        $grid = 'gr-4 gr-6@tablet';
                     endif;
                     echo get_simple_sede($post, $grid.' gr-12@small no-gutter-px gutter-horizontal@small', false);
                     $count ++;
                  endwhile;
               endif;
               wp_reset_query();
            endif; ?>

            <?php
            if ($activar_paginas_hijas_manual):
               foreach ($paginas_hijas_manual as $pagina_hija_manual):
                  echo get_simple_sede($pagina_hija_manual->ID, $grid.' gr-12@small no-gutter-px gutter-horizontal@small', false);
               endforeach;
            endif; ?>
         </div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
