<?php
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
               <?php if (get_field('habilitar_imagen_destacada')): ?>
                  <?php the_post_thumbnail( 'slider_single' , array('class' => 'cover-img', 'alt' => get_the_title($pid)) );?>
               <?php endif; ?>
   				<div class="single__content">
   					<?php the_content(); ?>
   				</div>
            </div>
            <div class="gr-12@small gr-12@tablet showb@tablet" data-area-name="mobile-sidebar"></div>
         </div>
      </div>
   </section>
</main>
<?php get_footer(); ?>
