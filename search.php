<?php
get_header();
global $wp_query;
$search_term = sanitize_text_field(get_query_var('s'));
?>
	<main>
		<?php get_template_part('partials/breadcrumb'); ?>
		<section class="horizon horizon--inner">
			<div class="container">
            <div class="row">
               <div class="gr-8 gr-12@medium">
                  <div class="horizon__intro search">
         				<h2 class="horizon__title horizon__title--inner">Resultado de búsqueda</h2>
                     <div class="horizon__excerpt">
                        <p><?php if( !$wp_query->found_posts ) : echo 'Lo sentimos, no se han encontrado resultados para el término <strong>"' .$search_term.'"</strong>'; else: echo 'Se han encontrado <strong>' . $wp_query->found_posts . ' resultados</strong> para la búsqueda de <strong>"' . $search_term . '"</strong>'; endif;?> </p>
                     </div>
         			</div>
                  <?php
                     if( have_posts() ) :
                        while( have_posts() ) :
                           the_post();
                           echo get_searched_article($post);
                        endwhile;
                     endif;

                     echo get_pagination($wp_query);
                  ?>
               </div>
               <aside class="gr-4 gr-12@medium">
                  <?php get_template_part('partials/sidebar/sidebar', 'contacto-sedes'); ?>
               </aside>
            </div>
			</div>
		</section>
	</main>
<?php
get_footer();
?>
