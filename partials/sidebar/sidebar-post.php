<?php
$noticias_args = array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 3,
   'post_parent' => 0,
	'orderby' => 'DESC',
	'post__not_in' => array($post->ID)
);
$noticias_query = new WP_Query($noticias_args);
?>

<div class="sidebar space-left">
   <h3 class="sidebar__title">Últimas Noticias</h3>
   <div class="row">
      <?php
         if($noticias_query->have_posts()):
            while($noticias_query->have_posts()):
               $noticias_query->the_post();
               echo get_simple_post($post, 'gr-12 gr-6@tablet gr-12@small');
            endwhile;
         endif;
         wp_reset_query();
      ?>
   </div>
</div>
