<?php
global $pid, $current_slug;
?>

<?php
   $current_id = get_post($post->ID);
   if($current_id->post_parent){
      $page_parent = get_post($current_id->post_parent);
      if($page_parent->post_parent){
         $grand_parent = get_post($page_parent->post_parent);
      }
   }

   $siblings_parent = get_pages(array(
      'sort_column' => 'menu_order',
      'sort_order' => 'ASC',
      'post_status' => 'publish',
      'parent' => $page_parent->ID
   ));
?>

<div class="sidebar" data-sticky data-offset_top="15">
   <?php if($page_parent->post_parent): ?>
      <h3 class="sidebar__title"><a href="<?php echo get_permalink($grand_parent->ID); ?>"><?php echo get_the_title($grand_parent->ID); ?></a></h3>
   <?php else:?>
      <h3 class="sidebar__title"><a href="<?php echo get_permalink($page_parent->ID); ?>"><?php echo get_the_title($page_parent->ID); ?></a></h3>
   <?php endif; ?>


   <?php
   //Menu para las paginas que no tienen página abuelo
   if(!$grand_parent):
      $print = '<ul class="child-list">';
      if($siblings_parent):

         foreach($siblings_parent as $sibling):
            $sibling->post_name == $current_slug ? $current = 'current' : $current = '';
            $print .= '<li class="child-list__item '. $current .'">';
            $print .=   '<a href="'.get_permalink($sibling).'" title="Ir a '. get_the_title($sibling) .'">' . get_the_title($sibling) . '</a>';
            $print .= '</li>';
         endforeach;

      endif;
      $print .= '</ul>';
   endif;

   $siblings_grand_parent = get_pages(array(
      'sort_column' => 'menu_order',
      'sort_order' => 'ASC',
      'post_status' => 'publish',
      'parent' => $grand_parent->ID
   ));

   //Menu para las paginas con abuelo
   if($page_parent):
      if($grand_parent):
           if($siblings_grand_parent):
             $print .= '<ul class="child-list">';

              foreach($siblings_grand_parent as $sibling):
                 $sibling->post_name == $current_slug ? $current = 'current' : $current = '';
                 $print .= '<li class="child-list__item '. $current .'">';
                 $print .=  	'<a href="'.get_permalink($sibling).'" title="Ir a '. get_the_title($sibling) .'">' . get_the_title($sibling) . '</a>';

                 if ($sibling->ID == $page_parent->ID):
                     $siblings_2 = get_pages(array(
                        'sort_column' => 'menu_order',
                        'sort_order' => 'ASC',
                        'post_status' => 'publish',
                        'parent' => $page_parent->ID
                     ));
                      if($siblings_2):
                            $print .= '<ul class="child-list__sub">';

                            foreach($siblings_2 as $sibling_2):
                               $sibling_2->post_name == $current_slug ? $current = 'current' : $current = '';
                               $print .= '<li class="child-list__item '. $current .'">';
                               $print .= 	'<a href="'.get_permalink($sibling_2).'" title="Ir a '. get_the_title($siblings_2) .'">' . get_the_title($sibling_2) . '</a>';
                               $print .= '</li>';
                            endforeach;

                           $print .= '</ul>';
                      endif;
                 endif;

                 $print .= '</li>';
              endforeach;

              $print .= '</ul>';
         endif;
      endif;
   endif;  ?>

   <?php echo $print ?>


</div>
