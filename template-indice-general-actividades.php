<?php
/*Template name: Indice general actividades*/
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
         	'post_type' => 'actividad',
         	'post_status' => 'publish',
            'post_parent' => 0,
         	'posts_per_page' => -1,
         	'orderby' => 'menu_order',
         	'order' => 'ASC'
         );

         $paginas_hijas_query = new WP_Query($paginas_hijas_args);?>
         <div class="row" data-equalize="target" data-mq="phablet-down" data-eq-target=".box">
            <?php
            if ($activar_paginas_hijas_auto):
               if($paginas_hijas_query->have_posts()):
                  while ( $paginas_hijas_query->have_posts() ) :
                     $paginas_hijas_query->the_post();
                     echo get_simple_feature($post, 'gr-'.$grid.' gr-6@tablet gr-12@phablet', false);
                  endwhile;
               endif;
               wp_reset_query();
            endif; ?>

            <?php
            if ($activar_paginas_hijas_manual):
               foreach ($paginas_hijas_manual as $pagina_hija_manual):
                  echo get_simple_feature($pagina_hija_manual->ID, 'gr-'.$grid.' gr-6@tablet gr-12@phablet', false);
               endforeach;
            endif; ?>
         </div>
      </div>
   </section>

</main>


<?php get_footer(); ?>
