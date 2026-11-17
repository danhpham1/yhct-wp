<?php
/**
 * Theme supports, assets and front-end filters.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'anmoc', ANMOC_DIR . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 86,
				'width'       => 86,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_image_size( 'anmoc-card', 800, 520, true );
		add_image_size( 'anmoc-portrait', 760, 940, true );

		register_nav_menus(
			array(
				'primary' => 'Menu chính',
				'footer'  => 'Menu chân trang (cột Khám phá)',
			)
		);
	}
);

/**
 * Colour + font tokens as CSS custom properties.
 */
function anmoc_tokens_css() {
	$css = ':root{';
	foreach ( anmoc_colors() as $key => $color ) {
		$value = sanitize_hex_color( get_theme_mod( 'color_' . $key, $color[1] ) );
		$css  .= '--' . $key . ':' . ( $value ? $value : $color[1] ) . ';';
	}
	foreach ( anmoc_design_options() as $id => $opt ) {
		if ( 'number' !== $opt[1] ) {
			continue;
		}
		$n    = min( $opt[3]['max'], max( $opt[3]['min'], (int) get_theme_mod( $id, $opt[2] ) ) );
		$css .= $opt[3]['var'] . ':' . ( '%' === $opt[3]['unit'] ? $n / 100 : $n . $opt[3]['unit'] ) . ';';
	}
	$css .= '--font-sans:"' . esc_attr( anmoc_font( 'sans' ) ) . '",sans-serif;';
	$css .= '--font-serif:"' . esc_attr( anmoc_font( 'serif' ) ) . '",serif;';
	return $css . '}';
}

function anmoc_font( $kind ) {
	$fonts   = anmoc_fonts();
	$default = array_key_first( $fonts[ $kind ] );
	$value   = get_theme_mod( 'font_' . $kind, $default );
	return isset( $fonts[ $kind ][ $value ] ) ? $value : $default;
}

/**
 * Font scheme A–D chosen in Customizer → Font chữ.
 */
function anmoc_font_scheme() {
	$scheme = strtoupper( (string) get_theme_mod( 'font_scheme', 'A' ) );
	return isset( anmoc_font_schemes()[ $scheme ] ) ? $scheme : 'A';
}

/**
 * <html data-font="…"> for schemes B–D. With the review switcher on, a
 * visitor's own pick (localStorage) is applied before first paint.
 */
function anmoc_html_font_attr() {
	$scheme = anmoc_font_scheme();
	if ( 'A' !== $scheme ) {
		echo ' data-font="' . esc_attr( $scheme ) . '"';
	}
}

add_action(
	'wp_head',
	function () {
		if ( ! get_theme_mod( 'font_switcher', true ) || is_customize_preview() ) {
			return;
		}
		echo "<script>try{var f=new URLSearchParams(location.search).get('font');f=f?f.toUpperCase():localStorage.getItem('anmoc-font');if(/^[A-D]$/.test(f)){localStorage.setItem('anmoc-font',f);f==='A'?document.documentElement.removeAttribute('data-font'):document.documentElement.setAttribute('data-font',f);}}catch(e){}</script>\n";
	},
	1
);

function anmoc_fonts_url() {
	$fonts = anmoc_fonts();
	$query = array();
	foreach ( array( 'sans', 'serif' ) as $kind ) {
		$query[] = 'family=' . $fonts[ $kind ][ anmoc_font( $kind ) ];
	}
	// Schemes B–D (and the review switcher) need the reference's extra families.
	if ( 'A' !== anmoc_font_scheme() || get_theme_mod( 'font_switcher', true ) ) {
		$query = array(
			'family=Be+Vietnam+Pro:wght@200;300;400;500;600',
			'family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400',
			'family=Lora:ital,wght@0,400;1,400;1,500',
			'family=Noto+Serif+Display:ital,wght@0,200;0,300;0,400;1,200;1,300;1,400',
		);
		foreach ( array( 'sans', 'serif' ) as $kind ) {
			$name = anmoc_font( $kind );
			if ( ! in_array( $name, array( 'Be Vietnam Pro', 'Lora', 'Cormorant Garamond' ), true ) ) {
				$query[] = 'family=' . $fonts[ $kind ][ $name ];
			}
		}
	}
	return 'https://fonts.googleapis.com/css2?' . implode( '&', array_unique( $query ) ) . '&display=swap';
}

function anmoc_custom_font_url( $spec ) {
	return 'https://fonts.googleapis.com/css2?family=' . $spec . '&display=swap';
}

/**
 * Rule for a font field, e.g. hero title. Matches with or without data-font and
 * comes after main.css, so it beats the scheme rules (html[data-font] …).
 */
function anmoc_font_target_css( $id ) {
	$targets = anmoc_font_targets();
	$fonts   = anmoc_custom_fonts();
	$name    = (string) get_theme_mod( $id, '' );
	if ( ! isset( $targets[ $id ], $fonts[ $name ] ) ) {
		return '';
	}
	return 'html:is([data-font],:not([data-font])) ' . $targets[ $id ] . '{font-family:"' . $name . '",' . $fonts[ $name ][1] . '}';
}

/* Fonts chosen for single headings: their stylesheet + one <style> per field (the preview rewrites it live). */
add_action(
	'wp_enqueue_scripts',
	function () {
		$fonts = anmoc_custom_fonts();
		foreach ( array_keys( anmoc_font_targets() ) as $id ) {
			$name = (string) get_theme_mod( $id, '' );
			if ( isset( $fonts[ $name ] ) ) {
				wp_enqueue_style( 'anmoc-font-' . sanitize_title( $name ), anmoc_custom_font_url( $fonts[ $name ][0] ), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			}
		}
	},
	20
);

add_action(
	'wp_head',
	function () {
		foreach ( array_keys( anmoc_font_targets() ) as $id ) {
			$css = anmoc_font_target_css( $id );
			if ( $css || is_customize_preview() ) {
				echo '<style id="anmoc-font-' . esc_attr( $id ) . '">' . $css . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- font names come from anmoc_custom_fonts().
			}
		}
	},
	20
);

/**
 * Privacy page: WordPress' privacy setting first, then the theme page.
 */
function anmoc_privacy_url() {
	$url = get_privacy_policy_url();
	if ( ! $url && anmoc_page_id( 'privacy' ) ) {
		$url = anmoc_page_url( 'privacy' );
	}
	return $url;
}

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'anmoc-fonts', anmoc_fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_enqueue_style( 'anmoc', anmoc_asset( 'css/main.css' ), array(), ANMOC_VERSION );
		wp_add_inline_style( 'anmoc', anmoc_tokens_css() );
		wp_enqueue_script( 'anmoc', anmoc_asset( 'js/main.js' ), array(), ANMOC_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
	}
);

add_filter(
	'wp_resource_hints',
	function ( $urls, $relation ) {
		if ( 'preconnect' === $relation ) {
			$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		}
		return $urls;
	},
	10,
	2
);

/**
 * Menu links get the design's classes.
 */
add_filter(
	'nav_menu_link_attributes',
	function ( $atts, $item, $args ) {
		if ( 'primary' === $args->theme_location ) {
			$classes       = array( 'nav-link' );
			$current_types = array( 'current-menu-item', 'current-menu-ancestor', 'current_page_parent', 'current-page-ancestor' );
			if ( array_intersect( $current_types, (array) $item->classes ) ) {
				$classes[]            = 'active';
				$atts['aria-current'] = 'page';
			}
			$atts['class'] = implode( ' ', $classes );
		}
		return $atts;
	},
	10,
	3
);

/**
 * Fallback when no menu is assigned: the theme pages in design order.
 */
function anmoc_menu_fallback( $args ) {
	$keys = 'footer' === $args['theme_location'] ? array( 'about', 'services', 'doctors', 'journal', 'community' ) : array( 'about', 'services', 'doctors', 'journal', 'community' );
	foreach ( $keys as $key ) {
		$id = anmoc_page_id( $key );
		if ( ! $id ) {
			continue;
		}
		$active = 'primary' === $args['theme_location'] && ( is_page( $id ) || ( 'journal' === $key && ( is_home() || is_singular( 'post' ) || is_category() ) ) );
		printf(
			'<a class="%s" href="%s"%s>%s</a>',
			'primary' === $args['theme_location'] ? ( $active ? 'nav-link active' : 'nav-link' ) : '',
			esc_url( get_permalink( $id ) ),
			$active ? ' aria-current="page"' : '',
			esc_html( get_the_title( $id ) )
		);
	}
}

/**
 * Header / photo options from Customizer → Cỡ chữ, nút & bố cục chung.
 */
add_filter(
	'body_class',
	function ( $classes ) {
		foreach ( anmoc_design_options() as $id => $opt ) {
			if ( 'checkbox' === $opt[1] && ! get_theme_mod( $id, $opt[2] ) ) {
				$classes[] = $opt[3]['class_off'];
			}
		}
		return $classes;
	}
);

add_filter(
	'excerpt_length',
	function () {
		return 26;
	}
);

add_filter(
	'excerpt_more',
	function () {
		return '…';
	}
);

/**
 * Category archives reuse the journal (posts page) layout.
 */
add_filter(
	'template_include',
	function ( $template ) {
		if ( is_category() || is_tag() ) {
			$home = locate_template( 'home.php' );
			return $home ? $home : $template;
		}
		return $template;
	}
);

/**
 * Journal grid: the featured post sits above it, so keep it out of the grid.
 */
add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() || ! $query->is_main_query() || ! $query->is_home() ) {
			return;
		}
		$query->set( 'ignore_sticky_posts', true );
		$featured = in_array( 'featured', anmoc_layout( 'journal' ), true ) ? anmoc_featured_post_id() : 0;
		if ( $featured ) {
			$query->set( 'post__not_in', array( $featured ) );
		}
	}
);
