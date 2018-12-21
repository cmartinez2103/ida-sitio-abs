<?php
global $pid;
$current_slug = $post->post_name;
$current_id = get_post($post->ID);
$page_parent = get_post($current_id->post_parent);


$siblings = get_pages(array(
  'sort_column' => 'menu_order',
  'sort_order' => 'ASC',
  'post_status' => 'publish',
  'post_type' => 'actividad',
  'parent' => 0
));
?>

<div class="sidebar" data-sticky data-offset_top="15">
  <h3 class="sidebar__title"><?php echo get_the_title($page_parent->ID); ?></h3>
  <ul class="child-list">
     <?php
      $print = '';
      if($siblings):
         $print .= '<ul class="child-list">';
         foreach($siblings as $sibling):
            $print .= '<li class="child-list__item">';
            $print .= 	'<a href="'.get_permalink($sibling).'" title="Ir a '. get_the_title($sibling) .'">' . get_the_title($sibling) . '</a>';

            if ($sibling->ID == $page_parent->ID):
               $siblings_2 = get_pages(array(
                  'sort_column' => 'menu_order',
                  'sort_order' => 'ASC',
                  'post_status' => 'publish',
                  'post_type' => 'actividad',
                  'parent' => $page_parent->ID
               ));

               $print .= '<ul class="child-list__sub">';
               foreach($siblings_2 as $sibling_2):
                  $sibling_2->post_name == $current_slug ? $current = 'current' : $current = '';
                  $print .= '<li class="child-list__item '. $current .'">';

                  $print .= 	'<a href="'.get_permalink($sibling_2).'" title="Ir a '. get_the_title($siblings_2) .'">' . get_the_title($sibling_2) . '</a>';
                  $print .= '</li>';
               endforeach;

               $print .= '</ul>';

            endif;

            $print .= '</li>';
         endforeach;
         $print .= '</ul>';
     endif;
     ?>
     <?php echo $print ?>
  </ul>
</div>
