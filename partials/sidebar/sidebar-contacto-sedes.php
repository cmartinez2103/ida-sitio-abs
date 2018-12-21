<div class="sidebar acceso_sede space-left-small">
   <h3 class="sidebar__title">¿Tienes dudas? Contáctanos</h3>
   <div class="row">
      <?php $sede_contacto_args = array(
         'post_type' => 'sede',
         'post_status' => 'publish',
         'post_parent' => 0,
         'posts_per_page' => -1,
         'orderby' => 'menu_order',
         'order' => 'ASC'
      );
      $sede_contacto_query = new WP_Query($sede_contacto_args);
      ?>

      <?php
      if($sede_contacto_query->have_posts()):

         while ( $sede_contacto_query->have_posts() ) :
            $sede_contacto_query->the_post();
            echo get_simple_contacto_sede($post,'gr-12 gr-12@small');
         endwhile;
      endif;
      wp_reset_query();
       ?>

   </div>
</div>
