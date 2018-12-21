<?php
/*Template name: Plantilla del Personal*/
get_header();
$current_slug = $post->post_name;
the_post();

if( isset($_GET['tipo_sede']) && $_GET['tipo_sede']){
   $filtros['tipo_sedes'] = $filtro_sede = $_GET['tipo_sede'];
}

if(empty($filtros)) $filtros = [];

if(empty($filtros)){
    $tax_query = array();
}else{
    foreach( $filtros as $tax => $term_slug ){
        $tax_filtro = array( 'taxonomy' => $tax,'field' => 'slug','terms' => $term_slug );
    }
    $tax_query = $tax_filtro;
}

$sedes = get_field('sedes', 'options');
foreach($sedes as $sede){
   $selected = '';
   $filtro_sede == $sede['value'] ? $selected = 'selected' : $selected = '';
   $option_sedes.= '<option value="'. $sede['value'] .'" '.$selected.'>'. $sede['label'] .'</option>';
}

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

            <div class="gr-9 gr-10@large gr-12@tablet prefix-1 prefix-0@large">
               <div class="horizon__intro horizon__form">
      				<h2 class="horizon__title horizon__title--page"><?php the_title() ?></h2>
                  <div class="form-filtro">
                     <form action="<?php get_permalink() ?>" method="get">
                        <label for="filtro-sede" class="form-control__label">Filtrar por:</label>
                        <select id="tipo_sede" name="tipo_sede" data-onchange class="form-control__field form-control__field--select">
                           <option value="">Todas las sedes</option>
                           <?php echo $option_sedes; ?>
                        </select>
                     </form>
                  </div>
      			</div>
               <?php if (the_content()): ?>
                  <div class="single__content">
                     <?php the_content(); ?>
                  </div>
               <?php endif; ?>


               <?php
                  $profesores_args = array(
                     'post_type' => 'personal',
                     'post_status' => 'publish',
                     'posts_per_page' => -1,
                     'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'tipo_personal',
                            'field' => 'slug',
                            'terms' => $current_slug,
                        ),
                        $tax_filtro
                     ),

                  );
                  //printme($tax_filtro);

                  $profesores_query = new WP_Query($profesores_args);
                  if($profesores_query->have_posts()) {
                     echo '<div class="wrapper">';
                     echo '<div class="row">';
                     while($profesores_query->have_posts()) : $profesores_query->the_post();
                        echo  get_simple_profesores($post,'gr-3 gr-6@tablet');
                     endwhile;
                     echo '</div>';
                     echo '</div>';
                  }
                  else {
                     echo '<h3 class="horizon__title--subtitle">'.$terms_nivel->name.'</h3>';
                     echo '<p>No se encontraron resultados.</p>';
                  }
                  wp_reset_query();

               ?>

            </div>

            <div class="gr-12@small gr-12@tablet showb@tablet" data-area-name="mobile-sidebar"></div>

         </div>
      </div>
   </section>
</main>
<?php get_footer(); ?>
