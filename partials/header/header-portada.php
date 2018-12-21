<?php
$titulo_portada = get_field('titulo_portada');
$sub_titulo_portada = get_field('sub_titulo_portada');
$bajada_portada = get_field('bajada_portada');
?>

<div class="header header__portada">
   <div class="container">
      <div class="gr-12@small gr-12@tablet showb@tablet" data-area-name="mobile-excerpt"></div>

      <figure class="header__image">
         <?php
         if(has_post_thumbnail()){
   			echo get_the_post_thumbnail( '', 'portada', array('class' => 'cover-img', 'alt' => get_the_title()) );
   		}else {
            echo wp_get_attachment_image(get_field('placeholder_imagen', 'options'), 'portada', '', array('class' => 'cover-img', 'alt' => get_the_title()) );
         }
         ?>
      </figure>
      <div class="header__body">
         <div data-area-name="desktop-excerpt">
            <div class="box header__box" data-desktop-area="desktop-excerpt" data-mobile-area="mobile-excerpt" data-mutable="tablet-down">

               <h1 class="header__title">
                  <?php
                  if ($titulo_portada):
                     echo $titulo_portada;
                  else:
                     the_title();
                  endif;
                  ?>
               </h1>
               <?php if ($sub_titulo_portada): ?>
                  <span class="header__meta"><?php echo $sub_titulo_portada ?></span>
               <?php endif; ?>

            </div>
         </div>
         <?php if ($bajada_portada): ?>
            <div class="header__excerpt">
               <p><?php echo $bajada_portada ?></p>
            </div>
         <?php endif; ?>
      </div>
   </div>
</div>
