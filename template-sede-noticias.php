<?php
/*
Template name: Plantilla para noticias Sede
Template Post Type: Sede
*/
get_header();

$post_data = get_post($post->post_parent);
$categoria = get_the_terms($post->ID, 'categorias');
//printMe($tax);
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
      <div class="container">
         <div class="horizon__intro">
            <h2 class="horizon__title horizon__title--inner">Sede <?php echo get_the_title($post_data->ID);?> - <?php the_title() ?></h2>
         </div>
         <div class="row">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $noticias_sede_args = array(
               'post_type' => 'post',
               'post_status' => 'publish',
               'posts_per_page' => 12,
               'paged' => $paged,
               'orderby' => 'date',
               'category_name' => $categoria[0]->slug,
               'order' => 'DESC',
               'tax_query' => array(
                   array (
                        'taxonomy' => 'tipo_sedes',
                        'field' => 'slug',
                        'terms' => $post_data->post_name,
                  )
               )
            );
            //printme($noticias_sede_args);
            $noticias_query = new WP_Query($noticias_sede_args);
            if ($noticias_query->have_posts()):
               while ($noticias_query->have_posts()):
                   $noticias_query->the_post();
                   echo get_simple_post($post, 'gr-4 gr-6@tablet gr-12@phablet','', $categoria[0]->slug);
               endwhile;

               echo get_pagination($noticias_query);

            else:?>

               <div class="content-box">
                  <p>No hay posts para mostrar.</p>
               </div>

            <?php
            endif;
            wp_reset_query();
            ?>

         </div>
         <?php echo get_pagination($noticias_query); ?>
      </div>
   </section>
</main>

   <?php get_footer(); ?>
