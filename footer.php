<footer class="footer-bar">
	<div class="container">
		<div class="row">
			<div class="gr-3 gr-12@medium margin-bottom@medium">
				<figure class="footer-bar__brand logo_main">
					<a class="app-brand app-brand--inline" href="<?php echo home_url(); ?>" title="Ir al Inicio">
						<img src="<?php echo get_field('logo_footer' , 'options'); ?>" class="elastic-img" alt="Logo <?php bloginfo(name); ?>">
					</a>
				</figure>
				<figure class="footer-bar__brand">
					<a class="app-brand app-brand--inline" href="<?php echo home_url(); ?>">
						<img src="<?php echo get_field('logo_cognita' , 'options'); ?>" class="elastic-img" alt="Logo Cognita">
					</a>
				</figure>
			</div>
			<div class="gr-2 gr-4@medium gr-12@tablet no-padding--vertical gutter@tablet">
				<?php
					$footer_nav .= '<ul id="%1$s" class="%2$s">';
					$footer_nav .= 	'%3$s';
					$footer_nav .= '</ul>';
					wp_nav_menu(array(
						'theme_location' => 'menu_footer',
						'menu_class' => 'footer-list',
						'menu_id' => '',
						'items_wrap' => $footer_nav,
						'walker' => new custom_sub_walker(),
					));
				?>
			</div>
			<div class="gr-3 gr-4@medium gr-12@tablet prefix-1 prefix-0@medium no-padding--vertical gutter@tablet footer-bar__secondary">
				<h4 class="footer-bar__title">
					<a href="#">Nuestras Sedes</a>
				</h4>
				<?php
					$footer_sedes_nav .= '<ul id="%1$s" class="%2$s">';
					$footer_sedes_nav .= 	'%3$s';
					$footer_sedes_nav .= '</ul>';
					wp_nav_menu(array(
						'theme_location' => 'menu_sedes',
						'menu_class' => 'footer-list opacity',
						'menu_id' => '',
						'items_wrap' => $footer_sedes_nav,
						'walker' => new custom_sub_walker(),
					));
				?>
			</div>
			<div class="gr-3 gr-4@medium gr-12@tablet no-padding--vertical gutter@tablet">
				<div class="border">
					<?php
						$footer_nav_dos .= '<ul id="%1$s" class="%2$s">';
						$footer_nav_dos .= 	'%3$s';
						$footer_nav_dos .= '</ul>';
						wp_nav_menu(array(
							'theme_location' => 'menu_footer_secundario',
							'menu_class' => 'footer-list opacity',
							'menu_id' => '',
							'items_wrap' => $footer_nav_dos,
							'walker' => new custom_sub_walker(),
						));
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="gr-12 footer-bar__social flex-center">
			<p class="social-link--title">Síganos en:</p>
			<?php
				$redes_sociales = get_field('redes_sociales', 'options');
				if($redes_sociales):
					foreach($redes_sociales as $rs):
						$rs_print .=		'<a href="'.ensure_url($rs['link_red_social']).'" class="social-link social-link--'.$rs['tipo_red_social'].'" target="_blank" title="Síguenos en '.$rs['tipo_red_social'].'">'.$rs['nombre_cuenta_red_social'].'</a>';
					endforeach;
				endif;

				echo $rs_print;
			?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
