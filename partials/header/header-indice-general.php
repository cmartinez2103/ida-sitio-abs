<div class="header header__main">
   <div class="container">
      <figure class="header__image" data-objectFit>
         <?php
         if(has_post_thumbnail()){
   			echo get_the_post_thumbnail( '', 'indice-general', array('class' => '', 'alt' => get_the_title()) );
   		}else{
   			echo wp_get_attachment_image(get_field('placeholder_imagen', 'options'), 'indice-general', '', array('class' => '', 'alt' => get_the_title()) );
   		}
         ?>
      </figure>
      <div class="header__body">
         <div class="box">
            <h1 class="header__title"><?php the_title() ?></h1>
         </div>
      </div>
   </div>
</div>
