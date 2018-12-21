
<?php $nombre_sede=$post->post_name; ?>
<section class="horizon">
   <div class="container">
      <div class="horizon__intro horizon__intro--center">
         <h2 class="horizon__title">Videos <?php the_title(); ?></h2>
         <a href="<?php echo home_url()?>/sede/<?php echo $nombre_sede ?>/videos/" class="link link--more rigth big hide@tablet" title="Ver más Videos">ver más</a>
      </div>
      <div class="row">
         <?php $galeria_sede_args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'category_name' => 'videos',
            'tax_query' => array(
                array (
                     'taxonomy' => 'tipo_sedes',
                     'field' => 'slug',
                     'terms' => $nombre_sede,
               )
            )
         );

         $galeria_sede_query = new WP_Query($galeria_sede_args); ?>

         <?php
            if($galeria_sede_query->have_posts()):

               while ( $galeria_sede_query->have_posts() ) :
                  $galeria_sede_query->the_post();
                  echo get_simple_post($post,'gr-4 gr-6@tablet gr-12@phablet');
               endwhile;
            else:
               echo '<p class="float-center">¡Ups!, no hay artículos.</p>';
            endif;
            wp_reset_query();
         ?>
      </div>
   </div>
</section>
