<?php
$nombre_sede=$post->post_name;
$profesores_args = array(
   'post_type' => 'personal',
   'post_status' => 'publish',
   'posts_per_page' => -1,
   'orderby' => 'rand',
   'order' => 'DESC',
   'tax_query' => array(
          'relation' => 'AND',
      array(
         'taxonomy' => 'tipo_sedes',
         'field'    => 'slug',
         'terms'    => $nombre_sede,
      ),
      array(
         'taxonomy' => 'tipo_personal',
         'field'    => 'slug',
         'terms'    => 'profesores-jefes',
      ),
   ),
);
$profesores_query = new WP_Query($profesores_args);?>
<section class="horizon">
   <div class="container">
      <div class="horizon__intro horizon__intro--center">
         <h2 class="horizon__title">Profesores <?php the_title(); ?></h2>
         <form action="/quienes-somos/equipo-del-colegio/profesores-jefes/" method="get">
            <button class="link link--more rigth big hide@tablet" type="submit" name="tipo_sede" value="<?php echo $nombre_sede ?>" title="Ver más Profesores">ver más</button>
         </form>
      </div>
      <div class="carousel carousel--index" data-module="carousel" data-maxitems="5" data-mqitems="1024px,5|800px,3|640px,1" data-slide="true">
         <?php $count = count($profesores_query->posts);?>
         <div class="carousel__items-holder">
            <div class="carousel__items" data-role="carousel-list">
               <?php
               $activar_seleccion_manual_profes = get_field('seleccionar_profesores_sede');
               $profesores_seleccion_manual = get_field('profesores_sede');

               if (!$activar_seleccion_manual_profes) {
                  if($profesores_query->have_posts()):
                     while ( $profesores_query->have_posts() ) :
                        $profesores_query->the_post();

                        echo '<div class="carousel__slide" data-role="carousel-slide">';
                        echo  get_simple_profesores($post,'');
                        echo  '</div>';

                     endwhile;
                  endif;
                  wp_reset_query();
               }
               if ($activar_seleccion_manual_profes) {
                  foreach ($profesores_seleccion_manual as $profesor):
                     echo '<div class="carousel__slide" data-role="carousel-slide">';
                     echo get_simple_profesores($profesor->ID,'');
                     echo  '</div>';
                  endforeach;
               }
               ?>
            </div>
         </div>

         <?php
         $mostrar_arrow = '';
         if ($count <= 5){
            $mostrar_arrow = 'showb@medium';
         }
         if ($count <= 3) {
            $mostrar_arrow = 'showb@small';
         }
          ?>
         <div class="carousel__arrows <?php echo $mostrar_arrow ?>">
            <button class="carousel__arrow carousel__arrow--prev" data-role="carousel-arrow" data-direction="prev"></button>
            <button class="carousel__arrow carousel__arrow--next" data-role="carousel-arrow" data-direction="next"></button>
         </div>


      </div>
   </div>
