<?php
/*
* Template Name: Single actividad
* Template Post Type: actividad
*/
get_header();
the_post();
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
		<div class="container">
         <div class="row">
				<div class="gr-2 gr-6@tablet gr-12@phablet hide@tablet" data-area-name="desktop-sidebar">
               <div data-desktop-area="desktop-sidebar" data-mobile-area="mobile-sidebar" data-mutable="tablet-down">
                  <?php get_template_part('partials/sidebar/sidebar', 'actividades'); ?>
               </div>
            </div>

            <div class="gr-8 gr-9@large gr-12@tablet prefix-1 prefix-0@large single__container">
               <div class="horizon__intro">
      				<h2 class="horizon__title horizon__title--page"><?php the_title() ?></h2>
      			</div>
               <?php if (get_field('habilitar_imagen_destacada')): ?>
               <?php the_post_thumbnail();?>
               <?php endif; ?>
               <div class="single__content">
   					<?php the_content(); ?>
   				</div>
            </div>
            <div class="gr-12@small gr-12@tablet showb@tablet" data-area-name="mobile-sidebar"></div>
         </div>
      </div>
   </section>
   <?php
   $padre = $post->post_parent;
   $page_parent = get_post($padre);
   $noticias_sede_args = array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => 3,
      'orderby' => 'date',
      'category_name' => $page_parent->post_name,
      'order' => 'DESC',
   );
   //printme($noticias_sede_args);
   $noticias_query = new WP_Query($noticias_sede_args);
   if ($noticias_query->have_posts()):
      echo '<section class="horizon bg bg-light">';
      echo     '<div class="container">';
      echo        '<h2 class="horizon__title">Sigue la actividad de '.get_the_title($padre).'</h2>';
      echo        '<br>';
      echo        '<div class="row">';
      while ($noticias_query->have_posts()):
          $noticias_query->the_post();
          echo get_simple_post($post, 'gr-4 gr-6@tablet gr-12@phablet');
      endwhile;
      echo        '</div>';
      echo     '</div>';
      echo '<section>';
   endif;
   wp_reset_query();
   ?>
</main>
   <?php get_footer(); ?>
