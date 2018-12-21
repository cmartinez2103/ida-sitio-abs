<?php
function get_simple_sede($article, $grid = ''){
	$printer = $out = $pid = '';
	if($article):
		if(!is_numeric($article)): $pid = $article->ID;
		else: $pid = $article; $article = get_post( $pid, OBJECT );
		endif;

		$printer .= '<article class="box box--fancy">';
		$printer .=		'<figure class="box__figure">';
		$printer .=			'<a href="'. get_permalink($pid) .'" title="Ir a '.$titulo.'">';
		if(has_post_thumbnail($article)):
			$printer .=			get_the_post_thumbnail( $pid, 'sede_box', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		else:
			$printer .=			wp_get_attachment_image(get_field('placeholder_imagen', 'options'), 'sede_box', '', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		endif;
		$printer .=			'</a>';
		$printer .= 	'</figure>';
		$printer .=		'<div class="box__body">';
		$printer .=			'<h4 class="box__title">';
										if (get_field('titulo_portada', $pid)):
		$titulo =						get_field('titulo_portada', $pid);
										else:
		$titulo =						get_the_title($pid);
										endif;
		$printer .=				'<a href="'. get_permalink($pid) .'" title="Ir a '.$titulo.'">'.$titulo.'</a>';
		$printer .=			'</h4>';
		$printer .=			'<div class="box__excerpt">';
									if (get_field('sub_titulo_portada', $pid)):
										$bajada =	get_field('sub_titulo_portada', $pid);
									elseif (get_field('bajada_portada', $pid)):
										$bajada = cut_string_to(get_field('bajada_portada', $pid), 50, '. . .');
									elseif (get_field('introduccion_breve', $pid)):
										$bajada = cut_string_to(get_field('introduccion_breve', $pid), 50, '. . .');
									else:
										$bajada = cut_string_to(get_the_content($pid), 50, ' ');
									endif;
		$printer .=				'<p>'.$bajada.'</p>';
		$printer .=			'</div>';
		$printer .=		'</div>';
		$printer .=	'</article>';

		if($grid != ''):
		$out = '<div class="'.$grid.'">' . $printer . '</div>';
		else:
		$out = $printer;
		endif;
	endif;
	return $out;
}

function get_simple_feature($article, $grid = '', $simple = false){
	$printer = $out = $pid = '';
	if($article):
		if(!is_numeric($article)): $pid = $article->ID;
		else: $pid = $article; $article = get_post( $pid, OBJECT );
		endif;
		if($simple == true):
			$body = $align = '';
			$body = 'small';
			$align = 'center';
		endif;

		$printer .= '<article class="box box--featured '.$align.'">';
		$printer .=		'<figure class="box__figure">';
		$printer .=			'<a href="'. get_permalink($pid) .'" title="Ir a '.get_the_title($pid).'">';
		if(has_post_thumbnail($article)):
			$printer .=			get_the_post_thumbnail( $pid, 'acceso_simple', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		else:
			$printer .=			wp_get_attachment_image(get_field('placeholder_imagen', 'options'), 'acceso_simple', '', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		endif;
		$printer .=			'</a>';
		$printer .= 	'</figure>';
		$printer .=		'<div class="box__body '.$body.'">';
		$printer .=			'<h4 class="box__title">';
		$printer .=				'<a href="'. get_permalink($pid) .'" title="Ir a '.get_the_title($pid).'">'.get_the_title($pid).'</a>';
		$printer .=			'</h4>';
		if($simple == false):
			$printer .=			'<div class="box__excerpt">';
			if(get_field('bajada_portada', $pid)):
				$introduccion = cut_string_to(get_field('bajada_portada', $pid),120, '. . .');
			elseif (get_field('introduccion_breve', $pid)):
				$introduccion = get_field('introduccion_breve', $pid);
			else:
				$introduccion = cut_string_to(get_the_content($pid), 120, '. . .');
			endif;
			$printer .=				$introduccion;
			$printer .=			'</div>';
		endif;
		if($simple == false):
			$printer .=			'<div class="box__action flex-right">';
			$printer .=				'<a href="'. get_permalink($pid) .'" class="link link--more" title="Ir a '.get_the_title($pid).'">Ver más</a>';
			$printer .=			'</div>';
		endif;
		$printer .=		'</div>';
		$printer .=	'</article>';

		if($grid != ''):
		$out = '<div class="'.$grid.'">' . $printer . '</div>';
		else:
		$out = $printer;
		endif;
	endif;
	return $out;
}

function get_simple_post($article, $grid = '', $formato = '', $type = ''){
	$printer = $out = $pid = '';
	if($article):
		if(!is_numeric($article)): $pid = $article->ID;
		else: $pid = $article; $article = get_post( $pid, OBJECT );
		endif;

		if($formato == 'inversed'):
			$box_formato = 'box--inversed';
		endif;
		// if($type == 'galerias'):
		// 	$box_type = 'type--gallery';
		// elseif($type == 'videos'):
		// 	$box_type = 'type--video';
		// endif;

		$category = get_the_category();
		$url_category = get_term_link( $category[0]->term_id, 'category');
		$tax = get_the_terms($pid, 'tipo_sedes');
		$url_tax = get_term_link( $tax[0]->term_id, 'tipo_sedes');

		$box_type = '';
		if ($category[0]->slug == 'galerias') {
			$box_type = 'type--gallery';
		}elseif ($category[0]->slug == 'videos') {
			$box_type = 'type--video';
		}else {
			$box_type = '';
		}

		$printer .= '<article class="box box--post '.$box_formato.' '.$box_type.'">';
		$printer .=		'<figure class="box__figure">';
		$printer .=			'<a href="'. get_permalink($pid) .'" title="Ir a '.get_the_title($pid).'">';
		if(has_post_thumbnail($article)):
			$printer .=			get_the_post_thumbnail( $pid, 'acceso_simple', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		else:
			$printer .=			wp_get_attachment_image(get_field('placeholder_imagen', 'options'), 'acceso_simple', '', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		endif;
		$printer .=			'</a>';
		$printer .= 	'</figure>';
		$printer .=		'<div class="box__body">';
		$printer .=			'<div class="box__meta">';
		$printer .=				$tax ? '<p><a href="'.home_url().'/sede/'.$tax[0]->slug.'/noticias/" title="Ir a Sede '.$tax[0]->name.'">Sede '.$tax[0]->name.'</a></p>' :  '' ;

		if ($category[0]->slug == 'cognita') {
			$link_archive = '/blog-cognita/';
		}elseif ($category[0]->slug == 'galerias' || $category[0]->slug == 'noticias' || $category[0]->slug == 'videos') {
			$link_archive = '/vida-escolar/'.$category[0]->slug.'/';
		}else {
			$link_archive = $url_category;
		}

		$printer .=				'<p><a href="'.$link_archive.'" title="Ir a '.$category[0]->name.'">'.$category[0]->name.'</a></p>';
		$printer .=			'</div>';
		$printer .=			'<h4 class="box__title">';
		$printer .=				'<a href="'. get_permalink($pid) .'" title="Ir a '.get_the_title($pid).'">'.get_the_title($pid).'</a>';
		$printer .=			'</h4>';
		$printer .=			'<span class="box__date">'.get_the_date("j")." de ".get_the_date("F")." ".get_the_date("Y").'</span>';
		$printer .=		'</div>';
		$printer .=	'</article>';

		if($grid != ''):
		$out = '<div class="'.$grid.'">' . $printer . '</div>';
		else:
		$out = $printer;
		endif;
	endif;
	return $out;
}

function get_simple_box($article, $grid = ''){
	$printer = $out = $pid = '';
	if($article):
		if(!is_numeric($article)): $pid = $article->ID;
		else: $pid = $article; $article = get_post( $pid, OBJECT );
		endif;


		$printer .= '<article class="box box--fancy center">';
		$printer .=		'<figure class="box__figure">';
		$printer .=			'<a href="'. get_permalink($pid) .'" title="Ir a '.get_the_title($pid).'">';
		if(has_post_thumbnail($article)):
			$printer .=			get_the_post_thumbnail( $pid, 'block', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		else:
			$printer .=			wp_get_attachment_image(get_field('placeholder_imagen', 'options'), 'block', '', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		endif;
		$printer .=			'</a>';
		$printer .= 	'</figure>';
		$printer .=		'<div class="box__body">';
		$printer .=			'<h4 class="box__title">';
		$printer .=				'<a href="'. get_permalink($pid) .'" title="Ir a '.get_the_title($pid).'">'.get_the_title($pid).'</a>';
		$printer .=			'</h4>';
		$printer .=		'</div>';
		$printer .=	'</article>';

		if($grid != ''):
		$out = '<div class="'.$grid.'">' . $printer . '</div>';
		else:
		$out = $printer;
		endif;
	endif;
	return $out;
}

function get_simple_profesores($article, $grid = '' , $formato = ''){
	$printer = $out = $pid = '';
	if($article):
		if(!is_numeric($article)): $pid = $article->ID;
		else: $pid = $article; $article = get_post( $pid, OBJECT );
		endif;

		if($formato == 'horizontal'):
			$box_formato = 'box--horizontal';
		endif;

		$printer .= '<article class="box box--person '.$box_formato.'">';
		$printer .=		'<figure class="box__figure">';
		if(has_post_thumbnail($article)):
			$printer .=			get_the_post_thumbnail( $pid, 'avatar_person', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		else:
			$printer .=			wp_get_attachment_image(get_field('placeholder_imagen', 'options'), 'avatar_person', '', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		endif;
		$printer .= 	'</figure>';
		$printer .=		'<div class="box__body">';
		$printer .=			'<h6 class="box__title">'.get_the_title($pid).'</h6>';
		if (get_field('email_personal', $pid)):
			$printer .=		'<p class="box__email"><a href="mailto:'.get_field('email_personal', $pid).'">'.get_field('email_personal', $pid).'</a></p>';
		endif;
		if (get_field('curso_a_cargo_personal', $pid)):
			$printer .=		'<p class="box__excerpt">'.get_field('curso_a_cargo_personal', $pid).'</p>';
		endif;

		if (get_field('dato_extra_personal', $pid)):
			$printer .=		'<p class="box__excerpt">'.get_field('dato_extra_personal', $pid).'</p>';
		endif;
		$printer .=		'</div>';
		$printer .=	'</article>';

		if($grid != ''):
		$out = '<div class="'.$grid.'">' . $printer . '</div>';
		else:
		$out = $printer;
		endif;
	endif;
	return $out;
}

function get_simple_contacto_sede($article, $grid = ''){
	$printer = $out = $pid = '';
	if($article):
		if(!is_numeric($article)): $pid = $article->ID;
		else: $pid = $article; $article = get_post( $pid, OBJECT );
		endif;

		$printer .= '<div class="box box--simple box--horizontal">';
		$printer .=		'<div class="box__figure">';
		$printer .=			'<a href="'. get_permalink($pid) .'" title="Ir a '.get_the_title($pid).'">';
		if(has_post_thumbnail($article)):
			$printer .=			get_the_post_thumbnail( $pid, 'acceso_sede_small', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		else:
			$printer .=			wp_get_attachment_image(get_field('placeholder_imagen', 'options'), 'acceso_sede_small', '', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		endif;
		$printer .=			'</a>';
		$printer .= 	'</div>';
		$printer .=		'<div class="box__body">';
		$printer .=			'<h4 class="box__title tiny text-upper"">'.get_the_title($pid).'</h4>';
		$printer .=			'<p class="box__excerpt ten">'.get_field('sub_titulo_portada', $pid).'</p>';
		$printer .=			'<ul class="list__data small">';
		$printer .=				'<li class="list__icon email"><a href="mailto:'.get_field('email_sede').'">'.get_field('email_sede').'</a></li>';
		$printer .=				'<li class="list__icon phone"><a href="tel:'.get_field('telefono_sede', $pid).'">'.get_field('telefono_sede', $pid).'</a></li>';

		$direccion_link = ensure_url('www.google.com/maps/place/'.urlencode(get_field('direccion_sede', $pid)));

		$printer .=				'<li class="list__icon place"><a href="'.$direccion_link.'">'.get_field('direccion_sede', $pid).'</a></li>';
		$printer .=			'<ul>';
		$printer .=		'</div>';
		$printer .=	'</div>';

		if($grid != ''):
		$out = '<div class="'.$grid.'">' . $printer . '</div>';
		else:
		$out = $printer;
		endif;
	endif;
	return $out;
}


function get_searched_article($article, $grid = ''){
	$printer = $out = $pid = '';
	if($article):
		if(!is_numeric($article)): $pid = $article->ID;
		else: $pid = $article; $article = get_post( $pid);
		endif;
		//printme($article);
		$post_type = get_post_type_object($article->post_type);

		$printer .= '<article class="box box--post box--horizontal">';
		if(has_post_thumbnail($article)):
		$printer .=		'<figure class="box__figure">';
		$printer .=			'<a href="'. get_permalink($pid) .'" title="Ir a '.get_the_title($pid).'">';
		$printer .=				get_the_post_thumbnail( $pid, 'slider_thumbnail', array('class' => 'cover-img', 'alt' => get_the_title($pid)) );
		$printer .=			'</a>';
		$printer .= 	'</figure>';
		endif;
		$printer .=		'<div class="box__body">';
		$printer .=			'<div class="box__meta">';
		//printme($post_type);

		if ($post_type->labels->singular_name == 'Sede') {
			$printer .=				'<p>'.$post_type->labels->singular_name.' '.get_the_title($article->post_parent).'</p>';
		}elseif($post_type->labels->singular_name == 'Entrada'){
			$printer .=				'<p>Noticias</p>';
		} else {
			$printer .=				'<p>'.$post_type->labels->singular_name.'</p>';
		}

		$printer .=			'</div>';
		$printer .=			'<h4 class="box__title">';
		$printer .=				'<a href="'. get_permalink($pid) .'" title="Ir a '.get_the_title($pid).'">'.get_the_title($pid).'</a>';
		$printer .=			'</h4>';
		$printer .=			'<div class="box__excerpt">';
		if(get_field('bajada_portada', $pid)):
			$introduccion = cut_string_to(get_field('bajada_portada', $pid),140, '. . .');
		elseif (get_field('introduccion_breve', $pid)):
			$introduccion = get_field('introduccion_breve', $pid);
		else:
			$introduccion = apply_filters('the_content', cut_string_to($article->post_content, 140, ' ...') );
		endif;
		$printer .=				$introduccion;
		$printer .=			'</div>';
		$printer .=		'</div>';
		$printer .=	'</article>';

		if($grid != ''):
		$out = '<div class="'.$grid.'">' . $printer . '</div>';
		else:
		$out = $printer;
		endif;
	endif;
	return $out;
}

function get_lectura($lectura){
	$printer = '';
	//get_field('lectura');
	if ($lectura) {
		$printer .= '<div class="box box--horizontal box--simple">';
		$habilitar_img = $lectura['habilitar_imagen'];
		$imagen =  $lectura['imagen'];
		$habilitar_lectura = $lectura['anadir_archivo'];
		$url = $lectura['archivo']['url'];

		$file_path = get_attached_file( $lectura['archivo']['id'] );
		$mimetype = strtoupper(parse_mime_type( $file_path ));

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		curl_setopt($ch, CURLOPT_NOBODY, TRUE);
		$data = curl_exec($ch);
		$size = size_format(curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD));
		curl_close($ch);


		if ($habilitar_img){
			$printer .=    '<figure class="box__icon">';

			if ($imagen){
				$printer .=    wp_get_attachment_image($imagen, "acceso_sede_small", false, array('class' => 'cover-img'));
			}
			$printer .=    '</figure>';
		}
		$printer .=    '<div class="box__body">';
		$printer .=       $lectura['dato_etiqueta'] ? '<p class="box__date">'.$lectura['dato_etiqueta'].'</p>' : '';
		$printer .=       '<h4 class="box__title tiny serif">'.$lectura['titulo'].'</h4>';
		$printer .=			'<div class="box__excerpt ten">'.$lectura['bajada'].'</div>';
		$printer .= 		$habilitar_lectura ? '<h4 class="box__title ten serif"><a href="'.$url.'" title="'.$lectura["titulo_descarga"].'" download>'.$lectura["titulo_descarga"].'</a></h4>' : '';
		$printer .=   '</div>';
		$printer .= '</div>';
	}

	return $printer;
}


?>
