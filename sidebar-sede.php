<?php
global $pid, $current_slug;

$parent_id = wp_get_post_parent_id($pid);
$siblings = get_pages(array(
  'sort_column' => 'menu_order',
  'sort_order' => 'ASC',
  'post_status' => 'publish',
  'post_type' => 'sede',
  'parent' => $parent_id
));
?>
<div class="sidebar" data-sticky data-offset_top="15">
   <h3 class="sidebar__title"><a href="<?php echo get_permalink($parent_id); ?>"><?php echo get_the_title($parent_id); ?></a></h3>
   <ul class="child-list">
     <?php
     if($siblings):
        foreach($siblings as $sibling):
           //printme($sibling);
           $sibling->post_name == $current_slug ? $current = 'current' : $current = '';
           echo '<li class="child-list__item '. $current .'">';
           echo 	'<a href="'.get_permalink($sibling).'" title="Ir a '. get_the_title($sibling) .'">' . get_the_title($sibling) . '</a>';
           echo '</li>';
        endforeach;
     endif;
     ?>
  </ul>
</div>
