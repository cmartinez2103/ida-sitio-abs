<?php
function get_slider_thumbs(){
 global $post;
    $slides = get_field('galeria_thumbs');
    $print_slider = $print_slides = $print_thumbs = $print_foots = '';
    $count = 0;
    if($slides){
        $print_slides  = '<div class="slider__items" data-role="slider-list">';
        $print_thumbs  = '<div class="slider__thumbnails">';
        $print_foots  = '<div class="slider__footers">';
        foreach($slides as $slide){
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
            $print_slides .=        wp_get_attachment_image( $slide['ID'], 'big_16x9', false, array('class'=>'cover-img', 'alt'=>$alt_img));
            $print_slides .=    '</div>';
            $print_thumbs .=    '<button class="slider__thumbnail '.$class_thumbs.'" data-role="slider-thumbnail" data-target="'.$count.'">';
            $print_thumbs .=        wp_get_attachment_image( $slide['ID'], 'small_16x9');
            $print_thumbs .=    '</button>';
            $print_foots  .=    '<p class="slider__foot '.$class_foots.'" data-role="slider-footing" data-target="'.$count.'">'.$slide['caption'].'</p>';
            $count ++;
        }
        $print_foots .=  '</div>';
        $print_thumbs .=  '</div>';
        $print_slides .=  '</div>';
        $print_arrows .=    '<div class="slider__arrows"><button class="slider__arrow slider__arrow--prev" data-role="slider-arrow" data-direction="prev"></button><button class="slider__arrow slider__arrow--next" data-role="slider-arrow" data-direction="next"></button></div>';

        $print_slider  = '<div class="wrapper">';
        $print_slider .=   '<div class="slider single__slider" data-module="slider">';
        $print_slider .=       $print_slides;
        $print_slider .=       $print_arrows;
        $print_slider .=       $print_thumbs;
        $print_slider .=       $print_foots;
        $print_slider .=   '</div>';
        $print_slider .= '</div>';
    }
    return $print_slider;
}

function get_video($iframe){
    $printer = '';

    if($iframe):
      $printer .= '<div class="wrapper">';
      $printer .= '<figure class="single__frame">';
      $printer .=     $iframe;
      $printer .= '</figure>';
      $printer .= '</div>';
    endif;
    return $printer;
}


?>
