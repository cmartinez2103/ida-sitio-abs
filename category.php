<?php
get_header();
$tax = get_queried_object();
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
      <div class="container">
         <div class="horizon__intro">
            <h2 class="horizon__title horizon__title--inner"><?php echo $tax->name ?></h2>
         </div>
         <div class="row">
         <?php
         if (have_posts()):
            while (have_posts()): the_post();
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

         <?php echo get_pagination(); ?>

      </div>
   </section>
</main>

   <?php get_footer(); ?>
