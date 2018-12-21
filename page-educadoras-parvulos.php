<?php
/*Template name: Página Educadoras de Parvulos*/
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

            <div class="gr-9 gr-10@large gr-12@tablet prefix-1 prefix-0@large">
               <div class="horizon__intro horizon__form">
      				<h2 class="horizon__title horizon__title--page"><?php the_title() ?></h2>
      			</div>
               <?php if (the_content()): ?>
                  <div class="single__content">
                     <?php the_content(); ?>
                  </div>
               <?php endif; ?>

               <?php

                   $profesores_args = array(
                       'post_type' => 'personal',
                       'post_status' => 'publish',
                       'posts_per_page' => -1,
                       'tax_query' => array(
                          'relation' => 'AND',
                           array(
                               'taxonomy' => 'tipo_personal',
                               'field' => 'slug',
                               'terms' => 'educadoras-de-parvulos',
                           ),
                           array(
                               'taxonomy' => 'tipo_sedes',
                               'field' => 'slug',
                               'terms' => 'first',
                           ),
                       ),
                    );

                    $profesores_query = new WP_Query($profesores_args);
                    //printme($profesores_query);
                    if($profesores_query->have_posts()) {
                       echo '<div class="wrapper">';
                       echo '<h3 class="horizon__title--subtitle">'.$terms_nivel->name.'</h3>';
                       echo '<div class="row">';
                       while($profesores_query->have_posts()) : $profesores_query->the_post();
                           echo  get_simple_profesores($post,'gr-3 gr-6@tablet');
                       endwhile;
                       echo '</div>';
                       echo '</div>';
                    }else {
                       echo '<p>No se han encontrado resultados.</p>';
                    }

               ?>

            </div>

            <div class="gr-12@small gr-12@tablet showb@tablet" data-area-name="mobile-sidebar"></div>

         </div>
      </div>
   </section>
</main>
<?php get_footer(); ?>
