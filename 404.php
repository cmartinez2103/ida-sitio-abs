<?php
get_header();
the_post();
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
		<div class="container">
         <div class="row">
            <div class="gr-7 gr-12@tablet prefix-1 prefix-0@large ">
               <div class="horizon__intro">
                  <h3 class="text-upper">Error 404</h3>
      				<h1 class="horizon__title horizon__title--page">PÁGINA NO ENCONTRADA</h1>
                  <div class="horizon__excerpt">
                     La página que estás buscando pudo haber sido eliminada, haber cambiado su nombre o se encuentra temporalmente no disponible.
                  </div>
                  <div class="">
                     <a href="<?php echo home_url() ?>" class="button button--main">Ir al home</a>
                     <a href="/contacto" class="button button--main inversed">Contáctanos</a>
                  </div>
      			</div>
            </div>
         </div>
      </div>
   </section>
</main>
<?php get_footer(); ?>
