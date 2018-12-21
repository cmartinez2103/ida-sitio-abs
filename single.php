<?php
get_header();
the_post();
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
      <?php get_template_part('partials/share'); ?>
		<div class="container">
         <div class="row">
            <div class="gr-8 gr-12@tablet single__container">
               <div class="horizon__intro">
                  <?php
                  $category = get_the_category();
                  //printme($category);
                  ?>
                  <p class="single__category"><?php echo $category[0]->name ?></p>
      				<h1 class="single__title"><?php the_title() ?></h1>
                  <p class="single__date"><?php echo get_the_date("j")?> de <?php echo get_the_date("F")?> <?php echo get_the_date("Y")?></p>
      			</div>
               <?php if (get_field('habilitar_imagen_destacada')): ?>
               <?php the_post_thumbnail( 'slider_single' , array('class' => 'cover-img', 'alt' => get_the_title($pid)) );?>
               <?php endif; ?>
               <div class="single__content">
                  <?php the_content(); ?>
               </div>
               <?php

               $post_galeria = get_field('galeria_thumbs');
               if ($post_galeria):
                  echo get_slider_thumbs();
               endif; ?>

               <?php $post_video = get_field('video');
               if ($post_video):
                  echo get_video($post_video); ?>
               <?php endif; ?>

            </div>

            <div class="gr-4 gr-12@tablet ">
               <?php get_template_part('partials/sidebar/sidebar', 'post'); ?>
            </div>
         </div>
      </div>
   </section>
</main>
<?php get_footer(); ?>
