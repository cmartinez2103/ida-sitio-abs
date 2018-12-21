<?php
/*Template name: Página Postulación*/
get_header();
the_post();
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
		<div class="container">
         <div class="row">
            <div class="gr-8 gr-12@medium">
               <div class="horizon__intro">
      				<h2 class="horizon__title horizon__title--inner"><?php the_title() ?></h2>
                  <div class="horizon__excerpt">
                     <?php the_content(); ?>
                  </div>
      			</div>
               <?php get_template_part('partials/forms/formulario', 'postulacion'); ?>
            </div>
            <aside class="gr-4 gr-12@medium ">
               <?php get_template_part('partials/sidebar/sidebar', 'contacto-sedes'); ?>
            </aside>
         </div>
      </div>
   </section>
</main>

<?php get_footer(); ?>
