<section class="horizon bg bg-light">
   <div class="container">
      <div class="horizon__intro horizon__intro--center">
         <h2 class="horizon__title">Horarios y departamentos</h2>
      </div>
      <div class="box--row box--flex">
      <?php
      $activar_paginas_hijas_manual = get_field('activar_paginas_hijas_sede_manual');
      $paginas_hijas_manual = get_field('paginas_hijas_sede');

      if ($activar_paginas_hijas_manual):
         foreach ($paginas_hijas_manual as $pagina_hija_manual):
            echo get_simple_box($pagina_hija_manual->ID,'col-box');
         endforeach;
      endif;
      ?>
      </div>
   </div>
</section>
