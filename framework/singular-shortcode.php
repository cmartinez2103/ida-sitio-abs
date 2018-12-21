<?php
/**
**  Multimedia shortcode
**/

add_shortcode('elemento', 'shortcode_elementos');
function shortcode_elementos($atts, $content = ''){
   global $post;

   $elements = get_field('elements', $post->ID);

   if(empty($elements)){ return; }

   if(isset($atts["id"]) && $atts["id"] != "all"){
      $colap = $elements[(int) $atts["id"]-1];
      $elements = array();
      $elements[0] = $colap;
   }

   $html = '';

   foreach ($elements as $element) {
      //colapsable
      if($element["acf_fc_layout"]=="colapsable"){
         $html .= '<div class="wrapper">';
         $html .= $element['titulo_horizonte'] ? '<h2 class="horizon__title--subtitle">'.$element['titulo_horizonte'].'</h2>' : '';
            foreach ($element["colapsables"] as $colapsable) {
               $html .= '    <article class="collapse">';
               $html .= '        <button  class="collapse__deployer" data-action="collapse-deploy">'.$colapsable["titulo"].'</button>';
               $html .= '        <div class="collapse__body" data-module="collapse-body">';
               $html .= '            <p>'.$colapsable["texto"].'</p>';
               $html .= '        </div>';
               $html .= '    </article>';
            }
         $html .= '</div>';
      }
      //descargables
      if($element["acf_fc_layout"]=="descargables"){
         $html .= '<div class="wrapper">';
         $html .= $element['titulo_horizonte'] ? '<h2 class="horizon__title--subtitle">'.$element['titulo_horizonte'].'</h2>' : '';

         foreach ($element["archivos"] as $archivo) {

            $titulo = $archivo["titulo"];
            $url = $archivo['archivo']['url'];

            $file_path = get_attached_file( $archivo['archivo']['id'] );
            $mimetype = strtoupper(parse_mime_type( $file_path ));

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_NOBODY, TRUE);
            $data = curl_exec($ch);
            $size = size_format(curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD));
            curl_close($ch);

            $html .= '<div class="box box--horizontal box--simple">';
            $html .= '  <figure class="box__icon">';
            $html .= '   <img src="'.get_template_directory_uri().'/dist/img/iconos/icon-document.svg" alt="Icono de descarga" class="icon-img">';
            $html .= '  </figure>';
            $html .= '  <div class="box__body">';
            $html .= '     <h4 class="box__title tiny serif"><a href="'.$url.'" title="'.$titulo.'" download>'.$titulo.'</a></h4>';
            $html .= '     <p class="box__data">'.$mimetype.' de '. $size. '</p>';
            $html .= '  </div>';
            $html .= '</div>';
         }
         $html .= '</div>';
      }

      //tablas
      // if($element["acf_fc_layout"]=="tabla"){
      //    $html .= '<div class="single__content">';
      //    $html .= '   <div class="scroll-y">';
      //    $html .=          do_shortcode( '[table id="'. $element["tabla"].'"]' );
      //    $html .= '   </div>';
      //    $html .= '</div>';
      // }

      //lista con icono y opcion de redireccionar
      if($element["acf_fc_layout"]=="lista_icono"){
         $html .= '<div class="wrapper">';
         $html .= $element['titulo_horizonte'] ? '<h2 class="horizon__title--subtitle">'.$element['titulo_horizonte'].'</h2>' : '';
         foreach ($element["lista_icono"] as $lista) {
            $html .= '<div class="box box--horizontal box--simple">';
            $habilitar_img = $lista['habilitar_imagen_icono'];
            $icono_imagen =  $lista['icono_o_imagen'];
            if ($habilitar_img){
               $html .=    '<figure class="box__icon">';
               if ($icono_imagen == 'icono'){
                  $html .=    '<img src="'.get_template_directory_uri().'/dist/img/iconos/icon-'.$lista['icono'].'.svg" alt="'.$lista['icono'].'" class="icon-img icon-img-max">';
               }
               if ($icono_imagen == 'imagen'){
                  $html .=    wp_get_attachment_image($lista['imagen'], "acceso_sede_small", false, array('class' => 'cover-img'));
               }
               $html .=    '</figure>';
            }
            $html .=    '</figure>';
            $html .=    '<div class="box__body">';
            $lista['dato_etiqueta'] ? $html .= '<p class="box__date">'.$lista['dato_etiqueta'].'</p>' : $html.= '';

            $con_enlace = $lista['con_enlace'];
            $html .=       '<h4 class="box__title tiny serif">';
            $con_enlace ? $html .= '<a href="'.$lista['link_interno'].'" title="'.$lista['titulo'].'">'.$lista['titulo'].'</a>' : $html .= $lista['titulo'];
            $html .=       '</h4>';
            $lista['bajada'] ? $html .= '<div class="box__excerpt ten">'.$lista['bajada'].'</div>' : $html .= '';

            $html .=   '</div>';
            $html .= '</div>';
         }
         $html .= '</div>';
      }

      //galeria slider normal
      if($element["acf_fc_layout"]=="galeria"){
         $html .= '<div class="wrapper">';
         $html .= $element['titulo_horizonte'] ? '<h2 class="horizon__title--subtitle">'.$element['titulo_horizonte'].'</h2>' : '';
         $count = count($element["galeria"]);
         if($count == 1){
            foreach ($element["galeria"] as $foto) {
               $html .= wp_get_attachment_image($foto["ID"], "slider_single", false, array('class' => 'cover-img', 'alt' => $foto['alt']));
               if ($foto['caption']) {
                  $html .= '    <figcaption class="slider__caption">'.$foto['caption'].'</figcaption>';
               }
            }
         }
         if($count> 1){
            $html .= '<div class="slider" data-module="slider" data-transition="false">';
            $html .=    '<div class="slider__items" data-role="slider-list">';
            $counter = 0;
            foreach ($element["galeria"] as $fotos) {
              $html .=     '<div class="slider__slide" data-role="slider-slide" data-index="'.$counter.'">';
              $html .=     wp_get_attachment_image($fotos["ID"], "slider_single", false, array('class' => 'cover-img', 'alt' => $fotos['alt']));;
              if(!empty($fotos['caption'])):
                 $html .=     '<div class="slider__caption">'.$fotos['caption'].'</div>';
              endif;
              $html .=     '</div>';

              if($counter == 0) $current = 'slider__bullet--current'; else $current = '';
      			  $bullets .= '<button class="slider__bullet '.$current.'" data-role="slider-bullet" data-target="'.$counter.'"></button>';
      			  $counter++;
            }
            $html .=    '</div>';
            $html .=    '<div class="slider__arrows">';
            $html .=       '<button class="slider__arrow slider__arrow--prev" data-role="slider-arrow" data-direction="prev"></button>';
            $html .=       '<button class="slider__arrow slider__arrow--next" data-role="slider-arrow" data-direction="next"></button>';
            $html .=    '</div>';
            $html .=     '<div class="slider__bullets">';
            $html .=       $bullets;
            $html .=     '</div>';
            $html .= '</div>';
         }
         $html .= '</div>';
      }

      //galeria con thumbnail
      if($element["acf_fc_layout"]=="galeria_thumbs"){
         $html .= '<div class="wrapper">';
         $html .= $element['titulo_horizonte'] ? '<h2 class="horizon__title--subtitle">'.$element['titulo_horizonte'].'</h2>' : '';
         $print_slider = $print_slides = $print_thumbs = $print_foots = '';
         $count = 0;
         $print_slides  = '<div class="slider__items" data-role="slider-list">';
         $print_thumbs  = '<div class="slider__thumbnails">';
         $print_foots   = '<div class="slider__footers">';
         foreach($element['galeria_thumbs'] as $slide){
            if($count == 0){
               $class_thumbs  =   'slider__thumbnail--current';
               $class_foots   =    'slider__foot--current"';
            }else{
               $class_thumbs =   '';
               $class_foots  =    '';
            }

            if ($slide['alt']) {
               $alt_img = $slide['alt'];
            }elseif ($slide['caption']) {
               $alt_img = $slide['caption'];
            } else {
               $alt_img = $slide['title'];
            }

            $print_slides .=    '<div class="slider__slide" data-role="slider-slide">';
            $print_slides .=        wp_get_attachment_image( $slide['ID'], 'slider_single', false, array('class'=>'cover-img', 'alt'=>$alt_img));
            $print_slides .=    '</div>';
            $print_thumbs .=    '<button class="slider__thumbnail '.$class_thumbs.'" data-role="slider-thumbnail" data-target="'.$count.'">';
            $print_thumbs .=        wp_get_attachment_image( $slide['ID'], 'slider_thumbnail');
            $print_thumbs .=    '</button>';
            $print_foots  .=    '<p class="slider__foot '.$class_foots.'" data-role="slider-footing" data-target="'.$count.'">'.$slide['caption'].'</p>';
            $count ++;
         }
         $print_foots   .=  '</div>';
         $print_thumbs  .=  '</div>';
         $print_slides  .=  '</div>';
         $print_arrows  .=  '<div class="slider__arrows"><button class="slider__arrow slider__arrow--prev" data-role="slider-arrow" data-direction="prev"></button><button class="slider__arrow slider__arrow--next" data-role="slider-arrow" data-direction="next"></button></div>';


         $html .=   '<div class="slider single__slider" data-module="slider">';
         $html .=       $print_slides;
         $html .=       $print_arrows;
         $html .=       $print_thumbs;
         $html .=       $print_foots;
         $html .=   '</div>';
         $html .= '</div>';
      }

      //módulo de areas
      if($element["acf_fc_layout"]=="areas"){
         $html .= '<div class="wrapper">';
         $html .= $element['titulo_horizonte'] ? '<h2 class="horizon__title--subtitle">'.$element['titulo_horizonte'].'</h2>' : '';
         foreach ($element["areas"] as $area) {
            $html .= '<h3 class="horizon__title--subtitle">'.$area['titulo_horizonte'].'</h3>';
            $html .= '<article class="single__area">';
            $html .=     '<h4 class="horizon__title--small">'.$area['titulo'].'</h4>';
            $html .=    $area['contenido'];
            $html .= '</article>';
         }
         $html .= '</div>';
      }

      //video
      if($element["acf_fc_layout"]=="video"){
         $html .= '<div class="wrapper">';
         $html .= $element['titulo_horizonte'] ? '<h2 class="horizon__title--subtitle">'.$element['titulo_horizonte'].'</h2>' : '';
         $html .= '<figure class="single__frame">';
         $html .= $element["video"];
         $html .= '</figure>';
         $html .= '</div>';
      }
   }
   return $html;
}


add_shortcode('elementos', 'shortcode_elementosAll');
function shortcode_elementosAll($atts, $content = ''){
   $html .= do_shortcode( '[elemento id="all"]' );
   return $html;
}


add_shortcode('profesores', 'profesores_relacionados');
function profesores_relacionados(){
   $profesores_jefes = get_field('profesores_relacionados' ,$post->ID);
   echo '<div class="wrapper">';
   echo '<h3 class="horizon__title--small">'.get_field('titulo_profesores_relacionados').'</h3>';
   echo    '<div class="row">';
   foreach ($profesores_jefes as $profesor_jefe):
      echo  get_simple_profesores($profesor_jefe, 'gr-6 gr-12@small', 'horizontal');
   endforeach;
   echo    '</div>';
   echo '</div>';

}
