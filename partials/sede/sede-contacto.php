<?php
   $nombre_sede=$post->post_name;
   $email_sede = get_field('email_sede');
   $telefono_sede = get_field('telefono_sede');
   $direccion_sede = get_field('direccion_sede');
   $titulo_contacto_sede = get_field('titulo_caja_contacto_sede');
   $bajada_contacto_sede = get_field('bajada_caja_contacto_sede');
   $direccion_link = ensure_url('www.google.com/maps/place/'.urlencode($direccion_sede));
?>

<section class="horizon">
   <div class="container--slider">
      <div class="row bg-light" data-equalize="target" data-mq="tablet-down" data-eq-target=".box">
         <div class="gr-6 gr-12@small no-gutter">
            <article class="box box--info bg-light">
               <div class="box__body">
                  <h2 class="box__title big">CONTÁCTANOS</h2>
                  <ul class="list__data">
                     <li class="list__icon email"><a href="mailto:<?php echo $email_sede ?>"><?php echo $email_sede ?></a></li>
                     <li class="list__icon phone"><a href="tel:<?php echo $telefono_sede ?>"><?php echo $telefono_sede ?></a></li>
                     <li class="list__icon place"><a href="<?php echo $direccion_link ?>" target="_blank"><?php echo $direccion_sede ?></a></li>
                  </ul>
               </div>
            </article>
         </div>
         <div class="gr-6 gr-12@small no-gutter">
            <article class="box box--info flex-center bg-gray">
               <div class="box__body">
                  <h2 class="box__title big"><?php echo $titulo_contacto_sede ?></h2>
                  <div class="box__excerpt small">
                     <p><?php echo $bajada_contacto_sede ?></p>
                  </div>
                  <form action="/contacto/" method="get">
                     <button class="button button--main  button--more" type="submit" name="tipo_sede" value="<?php echo $nombre_sede ?>">Ir a información de contacto</button>
                  </form>
               </div>
            </article>
         </div>
      </div>
   </div>
</section>
