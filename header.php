<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" type="image/x-icon">
  <?php wp_head(); ?>
  <?php echo get_field("tag", "options"); ?>
</head>

<body <?php body_class(); ?>>
	<?php   echo get_field('tag_externo_noscript', 'options'); ?>
	<header class="header-bar">
		<div class="top-bar">
			<div class="container" data-area-name="desktop-top">
				<div class="top-bar__items" data-mutable="tablet-down" data-desktop-area="desktop-top" data-mobile-area="mobile-top">

					<?php
						$top_nav .= '<ul id="%1$s" class="%2$s">';
						$top_nav .= 	'%3$s';
						$top_nav .= '</ul>';
						wp_nav_menu(array(
							'theme_location' => 'menu_top',
							'menu_class' => 'top-bar__menu top-bar__menu--simple',
							'menu_id' => '',
							'items_wrap' => $top_nav,
							'walker' => new custom_sub_walker(),
						));
					?>
					<?php
						$redes_sociales = get_field('redes_sociales', 'options');
						if($redes_sociales):
							$rs_print = '<ul class="top-bar__menu top-bar__menu--social">';
							foreach($redes_sociales as $rs):

								$rs_print .=	'<li class="menu-item menu-item--'.$rs['tipo'].'">';
								$rs_print .=		'<a href="'.ensure_url($rs['link_red_social']).'" class="rs__item '.$rs['tipo_red_social'].'" target="_blank" title="Síguenos en '.$rs['tipo_red_social'].'"><i class="fab fa-'.$rs['tipo_red_social'].'"></i></a>';
								$rs_print .=	'</li>';
							endforeach;
							$rs_print .= '</ul>';
						endif;

						echo $rs_print;
					?>

				</div>
			</div>
		</div>
		<nav class="nav-bar" data-module="nav-bar">
			<div class="container container--nav">
				<div class="nav-bar__holder">

					<div class="nav-bar__mobile-head">
						<button class="nav-bar__mobile-menu" aria-label="Ver menú" data-role="nav-deployer">
							<span></span>
						</button>
						<div class="nav-bar__brand">
							<a class="app-brand app-brand--inline" href="<?php echo home_url(); ?>" title="Ir al Inicio">
								<img class="app-brand__logo" src="<?php echo get_field('logo_cabecera' , 'options'); ?>" alt="Logo <?php bloginfo(name); ?>">
							</a>
						</div>
						<button class="nav-bar__mobile-search" aria-label="Ver búsqueda" data-role="search-deployer">
						</button>
					</div>

					<div class="nav-bar__body" data-role="nav-body">
						<div class="nav-bar__menu-holder">

							<?php
								$search = '<li class="menu-item menu-item--search hide@tablet">';
								$search .= '<button class="nav-bar__search__deployer" data-role="search-deployer"></button>';
								$search .= '<li>';

	   						$main_nav .= '<ul id="%1$s" class="%2$s">';
	   						$main_nav .= 	'%3$s';
								$main_nav .= 	$search;
	   						$main_nav .= '</ul>';
	   						wp_nav_menu(array(
	   							'theme_location' => 'menu_primary',
	   							'menu_class' => 'nav-bar__menu',
	   							'menu_id' => '',
	   							'items_wrap' => $main_nav,
	   							'walker' => new custom_sub_walker(),
	   						));
      					?>

							<div class="mobile-top" data-area-name="mobile-top"></div>
						</div>
					</div>

				</div>
			</div>
			<div class="mobile-search" data-area-name="mobile-search" data-role="search-body"></div>
		</nav>
		<div class="nav-bar__search__holder hide@tablet" data-role="search-body">
			<div class="container" data-area-name="desktop-search">
				<form class="flex-right"  method="get" action="<?php echo home_url()?>" data-mutable="tablet-down"  data-mobile-area="mobile-search" data-desktop-area="desktop-search">
					<div class="nav-bar__search">
						<input type="search" class="nav-bar__search__input" name="s" placeholder="Escribe aquí lo que buscas" required>
						<button type="submit" class="nav-bar__search__submit"></button>
					</div>
				</form>
			</div>
		</div>
	</header>
