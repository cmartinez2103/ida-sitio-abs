<?php $nombre_sede=$post->post_name; ?>
<section class="horizon">
   <div class="container">
      <div class="horizon__intro horizon__intro--center">
         <h2 class="horizon__title">Noticias <?php the_title(); ?></h2>
         <a href="<?php echo home_url()?>/sede/<?php echo $nombre_sede ?>/noticias/" class="link link--more rigth big hide@tablet" title="Ver más Noticias">ver más</a>
      </div>

      <div class="row">
         <?php $noticias_sede_args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'category_name' => 'noticias',
            'tax_query' => array(
                array (
                     'taxonomy' => 'tipo_sedes',
                     'field' => 'slug',
                     'terms' => $nombre_sede,
               )
            )
         );

         $noticias_sede_query = new WP_Query($noticias_sede_args); ?>

         <?php
            if($noticias_sede_query->have_posts()):

               while ( $noticias_sede_query->have_posts() ) :
                  $noticias_sede_query->the_post();
                  echo get_simple_post($post,'gr-4 gr-6@tablet gr-12@phablet', '' , '');
               endwhile;
            endif;
            wp_reset_query();
         ?>
      </div>
   </div>
</section>
