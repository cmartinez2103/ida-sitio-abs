<?php
/*
 * Template name: Plantillas Lecturas
 */
get_header();
$current_slug = $post->post_name;
the_post();
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
      <div class="container">
         <div class="row">
				<div class="gr-2 gr-6@tablet gr-12@phablet hide@tablet" data-area-name="desktop-sidebar">
               <div data-desktop-area="desktop-sidebar" data-mobile-area="mobile-sidebar" data-mutable="tablet-down">
                  <?php get_template_part('sidebar'); ?>
               </div>
            </div>

            <div class="gr-8 gr-9@large gr-12@tablet prefix-1 prefix-0@large single__container">
               <div class="horizon__intro">
      				<h1 class="horizon__title horizon__title--page"><?php the_title() ?></h1>
      			</div>
               <?php the_post_thumbnail( 'slider_single' , array('class' => 'cover-img', 'alt' => get_the_title($pid)) );?>
   				<div class="single__content">
                  <?php the_content(); ?>

                  <?php
                     $paginas_hijas_args = array(
                  	'post_type' => 'lectura',
                  	'post_status' => 'publish',
                  	'posts_per_page' => -1,
                  	'orderby' => 'menu_order',
                  	'order' => 'ASC',
                     'tax_query' => array(
                         array (
                              'taxonomy' => 'tipo_niveles',
                              'field' => 'slug',
                              'terms' => $current_slug,
                        )
                     )
                  );
                  //printme($paginas_hijas_args);
                  $paginas_hijas_query = new WP_Query($paginas_hijas_args);
                  //printme($paginas_hijas_query);
                  if($paginas_hijas_query->have_posts()):
                     while ( $paginas_hijas_query->have_posts() ) :
                        $paginas_hijas_query->the_post();
                        $contenido_lectura = get_field('lectura');
                        echo get_lectura($contenido_lectura);
                     endwhile;
                  else:
                     echo '<p>No hay lecturas para mostrar.</p>';
                  endif;
                  wp_reset_query();
                  ?>


   				</div>
            </div>
            <div class="gr-12@small gr-12@tablet showb@tablet" data-area-name="mobile-sidebar"></div>
         </div>
      </div>
   </section>

</main>

<?php get_footer(); ?>
