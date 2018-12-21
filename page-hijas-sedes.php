<?php
/*
* Template Name: Páginas Hijas de Sedes
 * Template Post Type: Sede
 */
get_header();
$current_slug = $post->post_name;
the_post();
global $post;
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
		<div class="container">
         <div class="row">
				<div class="gr-2 gr-6@tablet gr-12@phablet hide@tablet" data-area-name="desktop-sidebar">
               <div data-desktop-area="desktop-sidebar" data-mobile-area="mobile-sidebar" data-mutable="tablet-down">
                  <?php get_template_part('sidebar', 'sede'); ?>
               </div>
            </div>

            <div class="gr-8 gr-9@large gr-12@tablet prefix-1 prefix-0@large single__container">
               <div class="horizon__intro">
      				<h2 class="horizon__title horizon__title--page"><?php the_title() ?></h2>
      			</div>
               <?php the_post_thumbnail();?>
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
