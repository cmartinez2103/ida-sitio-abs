<?php
get_header();
$tax = get_queried_object();
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
      <div class="container">
         <div class="horizon__intro">
            <h2 class="horizon__title"><?php echo $tax->name ?> archivo</h2>
         </div>
         <div class="row">
         <?php
         if (have_posts()):
            while (have_posts()): the_post();
            echo get_simple_post($post, 'gr-4 gr-6@tablet gr-12@phablet');
            endwhile;
            echo get_pagination();
         else:?>

            <div class="content-box">
               <p>No hay posts para mostrar.</p>
            </div>

         <?php
         endif;
         wp_reset_query();
         ?>

         </div>

         <!--#include virtual="_paginator.shtml" -->

      </div>
   </section>
</main>

   <?php get_footer(); ?>
