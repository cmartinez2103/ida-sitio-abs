<?php
/*
* Template Name: Horarios de Curso
* Template Post Type: Sede
*/

get_header();
the_post();
$current_slug = $post->post_name;
global $post;
?>
<main>
   <?php get_template_part('partials/breadcrumb'); ?>
   <section class="horizon--inner">
		<div class="container">
         <div class="row">
            <div class="gr-2 gr-6@tablet gr-12@phablet hide@tablet" data-area-name="desktop-sidebar">
               <div data-desktop-area="desktop-sidebar" data-mobile-area="mobile-sidebar" data-mutable="tablet-down">
                  <?php get_template_part('sidebar', 'sede'); ?>
               </div>
            </div>

            <div class="gr-9 gr-10@large gr-12@tablet prefix-1 prefix-0@large">
               <div class="horizon__intro">
      				<h2 class="horizon__title horizon__title--inner">Horarios de cursos</h2>
                  <div class="horizon__excerpt">
                     <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                  </div>
      			</div>

               <?php $niveles_cursos = get_field('nivel_cursos');
               //printme($niveles_cursos);
               $print = '';
               if ($niveles_cursos):
                  foreach ($niveles_cursos as $key_nivel => $nivel):
                  $print .=    '<h3 class="tab__title">'.$nivel['titulo_nivel'].'</h3>';
                     foreach ($nivel['cursos'] as $key_grupo => $curso_grupo):

                        foreach ($curso_grupo['cursos_grupo'] as $key => $grupo)

                           $print .='<div class="tab__buttons row">';
                              foreach ($grupo as $key_curso => $curso):
                                 $print .=   '<div class="gr-4" data-area-name="desktop-tab-'.$key_nivel.'-'.$key_grupo.'-'.$key_curso.'">';
                                 $print .=      '<div class="tab__button button-test"
                                                   data-nivel="'.$key_nivel.'-'.$key_grupo.'"
                                                   data-target="curso-'.$key_nivel.'-'.$key_grupo.'-'.$key_curso.'"
                                                   data-mutable="tablet-down"
                                                   data-desktop-area="desktop-tab-'.$key_nivel.'-'.$key_grupo.'-'.$key_curso.'"
                                                   data-mobile-area="mobile-tab-'.$key_nivel.'-'.$key_grupo.'-'.$key_curso.'">';
                                 $print .=         '<p>'.$curso['nombre_curso'].'</p>';
                                 $print .=      '</div>';
                                 $print .=   '</div>';
                              endforeach;
                              $print .='<div class="tab__target">';
                              foreach ($grupo as $key_curso => $curso):
                                 $print .=   '<div data-area-name="mobile-tab-'.$key_nivel.'-'.$key_grupo.'-'.$key_curso.'"></div>';
                                 $print .=   '<div class="tab__body bg bg-light" id="curso-'.$key_nivel.'-'.$key_grupo.'-'.$key_curso.'">';
                                 $print .=      $curso['horario_curso'];
                                 $print .=   '</div>';
                              endforeach;
                              $print .='</div>';
                           $print .='</div>';

                        endforeach;

                  endforeach;

               endif;?>

               <?php echo $print ?>

            </div>
            <div class="gr-12@small gr-12@tablet showb@tablet" data-area-name="mobile-sidebar"></div>

         </div>
      </div>
   </section>
</main>

<script type="application/javascript">



</script>

<?php get_footer(); ?>
