<div class="sidebar space-left-small">
   <div class="bg bg-light">
      <h3 class="sidebar__title"><?php echo get_field('titulo_sidebar_action', 'options'); ?></h3>
      <div class="sidebar__excerpt">
         <?php echo get_field('bajada_sidebar_action', 'options'); ?>
      </div>
      <a href="<?php echo get_field('link_boton_sidebar_action', 'options') ?>" class="button button--main inversed button--more"><?php echo get_field('texto_boton_sidebar_action' , 'options'); ?></a>
   </div>
</div>
