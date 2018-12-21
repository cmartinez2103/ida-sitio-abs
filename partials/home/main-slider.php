<?php
$slider = get_field('slider');
if($slider):
	$counter = 0;
	$slider_auto = get_field('slider_auto');
	$slider_transition = get_field('slider_transition');
	$slider_auto ? $slider_transition = $slider_transition * 1000 : $slider_transition = 'false';
	//printme($slider_auto);
	//printme($slider_transition);

?>
<section class="horizon horizon--main">
	<div class="container--slider">
		<div class="slider slider--overisland slider--main" data-module="slider" data-transition="<?php echo $slider_transition; ?>">
			<div class="slider__items" data-role="slider-list">
			<?php
				foreach($slider as $slide):
					$img_slider = $slide['slider_imagen'];
					$title_slider = $slide['slider_titulo'];
					$excerpt_slider = $slide['slider_bajada'];
					$enable_button = $slide['slider_habilitar_boton'];
					$text_button = $slide['slider_boton_texto'];
					$url_button = $slide['slider_boton_url'];
					$target_button = $slide['slider_boton_tipo'];
					$img = wp_get_attachment_image( $img_slider, 'slider', '', array('class'=>'cover-img', 'alt' => $title_slider) );
			?>
				<div class="slider__slide" data-role="slider-slide">
					<figure class="slider__figure">
						<?php echo $img; ?>
					</figure>
					<div class="slider__container">

							<div class="slider__body">
								<h1 class="slider__title"><?php echo $title_slider; ?></h1>
								<div class="slider__excerpt">
									<?php echo apply_filters('the_content', $excerpt_slider ); ?>
								</div>
								<?php if($enable_button):?>
								<div class="slider__button">
									<a href="<?php echo ensure_url($url_button); ?>" class="button button--main  button--more" title="Ir a <?php echo $text_button ?>" <?php if($target_button) echo $target_button; ?>><?php echo $text_button; ?></a>
								</div>
								<?php endif; ?>
							</div>

					</div>
				</div>
			<?php
					$counter ++;
				endforeach;
			?>

			</div>
			<?php if($counter > 1): ?>
			<div class="slider__arrows">
				<button class="slider__arrow slider__arrow--prev" data-role="slider-arrow" data-direction="prev"></button>
				<button class="slider__arrow slider__arrow--next" data-role="slider-arrow" data-direction="next"></button>
			</div>
			<div class="slider__bullets">
			<?php for($step = 1; $step <= $counter; $step++): ?>
				<button class="slider__bullet <?php if($step == 1) echo ' slider__bullet--current' ?>" data-role="slider-bullet" data-target="<?php echo $step-1; ?>"></button>
			<?php endfor; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
endif;
?>
