<?php
/*Template name: Página Historia*/
get_header();
$current_slug = $post->post_name;
the_post();
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
               <div class="horizon__intro">
                  <h2 class="horizon__title horizon__title--page">HISTORIA DE AMERICAN BRITISH</h2>
               </div>

               <div class="single__content">
                  <?php the_content(); ?>
               </div>

               <?php
               $contenidos = get_field('contenido_linea_tiempo_historia');
               $count_contenido = count($contenido['acf_fc_layout'] == 'bloque_contenido');
               //printme($contenidos);
               $count_eq = 1;
               foreach ($contenidos as $contenido):


                  if ($contenido['acf_fc_layout'] == 'bloque_contenido'):
                     if ($contenido['anadir_imagen_apoyo_acontecimiento']):
                        $grid = '6';
                     else:
                        $grid = '12';
                     endif;

                     $print_contenido = '';
                     $print_contenido .= '<div class="gr-'.$grid.' gr-'.$grid.'@tablet gr-12@small">';
                     $print_contenido .=   '<article class="box box--data bg-light" data-eq-'.$count_eq.'>';
                     $print_contenido .=      '<div class="box__body">';
                     $print_contenido .=         '<span class="box__year">'.$contenido['ano_acontecimiento'].'</span>';
                     $print_contenido .=         '<h2 class="box__title">'.$contenido['titulo_acontecimiento'].'</h2>';
                     $print_contenido .=         '<div class="box__excerpt tiny">'.$contenido['contenido_acontecimiento'].'</div>';
                     $print_contenido .=      '</div>';
                     $print_contenido .=   '</article>';
                     $print_contenido .= '</div>';

                     $print_imagen = '';
                     $print_imagen .= '<div class="gr-6 gr-6@tablet gr-12@small">';
                     $print_imagen .=   '<figure class="box__figure" data-eq-'.$count_eq.'>';
                     $print_imagen .=      wp_get_attachment_image($contenido['imagen_acontecimiento'], 'avatar_person', '', array('class' => 'cover-img', 'alt' => ''.$contenido['titulo_acontecimiento'].'') );
                     $print_imagen .=   '</figure>';
                     $print_imagen .= '</div>';


                     $con_imagen = $contenido['anadir_imagen_apoyo_acontecimiento'];
                     $contenido_derecha = $contenido['contenido_derecha'];
                     $print_bloque = '';

                     if ($con_imagen):
                        if (!$contenido_derecha):
                           $print_bloque .= $print_grid;
                           $print_bloque .= $print_contenido;
                           $print_bloque .= $print_imagen;
                        else:
                           $print_bloque .= $print_grid;
                           $print_bloque .= $print_imagen;
                           $print_bloque .= $print_contenido;
                        endif;
                     else:
                        $print_bloque .= $print_contenido;
                     endif;

                     echo '<div class="row" data-equalize="target" data-mq="small-down" data-eq-target="[data-eq-'.$count_eq.']">';
                     echo $print_bloque;
                     echo "</div>";

                  endif;


                  if ($contenido['acf_fc_layout'] == 'galeria'):
                     $count = count($contenido['galeria_acontecimiento']);
                     if($count <= 2){
                        $grid_galeria = '6';
                     }
                     if($count > 2){
                        $grid_galeria = '3';
                     }
                     echo  '<div class="row" data-equalize="target" data-mq="small-down" data-eq-target="[data-eq-'.$count_eq.']">';
                     foreach ($contenido['galeria_acontecimiento'] as $imagen) {

                        $print_galeria = '';

                        $print_galeria .= '<div class="gr-'.$grid_galeria.' gr-6@small">';
                        $print_galeria .=   '<figure class="box__figure">';
                        $print_galeria .=      wp_get_attachment_image($imagen['ID'], 'avatar_person', '', array('class' => 'cover-img', 'alt' => ''.$imagen['alt'].'') );
                        $print_galeria .=   '</figure>';
                        $print_galeria .= '</div>';
                        echo $print_galeria;
                     }
                     echo '</div>';
                  endif;
                  $count_eq++;
               endforeach;?>

            </div>

            <div class="gr-12@small gr-12@tablet showb@tablet" data-area-name="mobile-sidebar"></div>

         </div>
      </div>
   </section>
</main>
<?php get_footer(); ?>
