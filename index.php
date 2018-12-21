<?php
get_header();
$tax = get_queried_object();
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
      <div class="container">
         <div class="horizon__intro">
            <h2 class="horizon__title horizon__title--inner">Noticias</h2>
         </div>
         <div class="row">
         <?php
         $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
         $noticias_sede_args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 12,
            'paged' => $paged,
            'order' => 'DESC',
         );
         $noticias_query = new WP_Query($noticias_sede_args);
         if ($noticias_query->have_posts()):
            while ($noticias_query->have_posts()):
               $noticias_query->the_post();
            echo get_simple_post($post, 'gr-4 gr-6@tablet gr-12@phablet');
            endwhile;
         else:?>

            <div class="content-box">
               <p>No hay posts para mostrar.</p>
            </div>

         <?php
         endif;
         wp_reset_query();
         ?>

         </div>

         <?php echo get_pagination($noticias_query); ?>

      </div>
   </section>
</main>

   <?php get_footer(); ?>
