<section class="horizon horizon--absolute">
   <div class="container">
      <div class="horizon__intro horizon__intro--center">
         <?php
         $habilitar = get_field('activar_link_comunidad');
         $link = get_field('link_titulo_comunidad');
         $titulo = get_field('titulo_seccion_comunidad');
         ?>
         <?php
            $intro_seccion = '';
            $intro_seccion .= '<h2 class="horizon__title">';
            if ($habilitar):
               $intro_seccion .= '<a href="'.$link.'" title="Ir a '.$titulo.'">'.$titulo.'</a>';
            else:
               $intro_seccion .= $titulo;
            endif;
            $intro_seccion .= '</h2>';

            if ($habilitar):
            $intro_seccion .= '<a href="'.$link.'" title="Ir a '.$titulo.'" class="link link--more rigth big hide@tablet">ver más</a>';
            //printme($link);
            endif;

            echo $intro_seccion;
         ?>
      </div>

      <div class="row" data-equalize="target" data-mq="tablet-down" data-eq-target="[data-eq]">
         <?php $pagina_destacada = get_field('pagina_destacada_comunidad');?>
         <?php if ($pagina_destacada): ?>
            <div class="gr-8 gr-12@medium no-gutter gutter-horizontal@tablet">
               <article class="box box--absolute left" data-eq>
                  <figure class="box__figure" data-objectFit>
                     <?php
                     if(has_post_thumbnail($pagina_destacada['destacada'][0]->ID)):
                        echo get_the_post_thumbnail( $pagina_destacada['destacada'][0]->ID, 'page_destacada', array('class' => 'cover-img', 'alt' => $pagina_destacada['destacada'][0]->post_title) );
                     else:
                        echo wp_get_attachment_image(get_field('placeholder_imagen', 'options'), 'page_destacada', '', array('class' => 'cover-img', 'alt' => $pagina_destacada['destacada'][0]->post_title) );
                     endif;
                      ?>
                  </figure>
                  <div class="box__body">
                     <h4 class="box__title">
                        <a href="<?php echo get_permalink($pagina_destacada['destacada'][0]->ID) ?>" title="Ir a <?php echo $pagina_destacada['destacada'][0]->post_title ?>"><?php echo $pagina_destacada['destacada'][0]->post_title ?></a>
                     </h4>
                     <div class="box__excerpt">
                        <?php echo $pagina_destacada['bajada_pagina'] ?>
                     </div>
                     <div class="box__action">
                        <a href="<?php echo get_permalink($pagina_destacada['destacada'][0]->ID) ?>" class="button button--main button--more" title="Ir a leer más">Leer más</a>
                     </div>
                  </div>
               </article>
            </div>
         <?php endif; ?>

         <?php $paginas_relacionadas = get_field('paginas_relacionadas_comunidad');?>
         <?php if ($paginas_relacionadas['relacionadas']): ?>
            <div class="gr-4 gr-12@medium no-gutter gutter-horizontal@tablet" data-eq>
               <?php foreach ($paginas_relacionadas['relacionadas'] as $pagina_relacionada): ?>
                  <article class="box box--card">
                     <figure class="box__icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/dist/img/iconos/icon-<?php echo $pagina_relacionada['icono_pagina'] ?>.svg" alt="Icono de <?php echo $pagina_relacionada['icono_pagina'] ?>" class="icon-img">
                     </figure>
                     <div class="box__body">
                        <h4 class="box__title"><a href="<?php echo $pagina_relacionada['link_pagina'] ?>" title="Ir a <?php echo $pagina_relacionada['titulo_pagina'] ?>"><?php echo $pagina_relacionada['titulo_pagina'] ?></a></h4>
                        <div class="box__excerpt">
                           <?php echo $pagina_relacionada['bajada_pagina'] ?>
                        </div>
                        <div class="box__action flex-right">
                           <a href="<?php echo $pagina_relacionada['link_pagina'] ?>" class="link link--more" title="Ir a <?php echo $pagina_relacionada['texto_boton'] ?>"><?php echo $pagina_relacionada['texto_boton'] ?></a>
                        </div>
                     </div>
                  </article>
               <?php endforeach; ?>
            </div>
         <?php endif; ?>
      </div>
   </div>
</section>
