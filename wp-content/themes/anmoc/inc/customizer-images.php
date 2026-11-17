<?php
/**
 * Click-to-change images in the Customizer preview.
 *
 * Every editable picture carries data-anmoc-img in the preview:
 *   "mod:hero_image"  – a Customizer image field (or the logo), opens its control;
 *   "thumb:123"       – the featured image of post 123, edited through the
 *                       dynamic setting anmoc_thumb[123] (see class-anmoc-thumb-setting.php).
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

/**
 * Preview-only attributes for a clickable image.
 */
function anmoc_image_attrs( $key, $label, $current = 0 ) {
	if ( ! is_customize_preview() ) {
		return array();
	}
	return array(
		'data-anmoc-img'         => $key,
		'data-anmoc-img-label'   => $label,
		'data-anmoc-img-current' => (int) $current,
	);
}

/**
 * Attributes for a post's featured image (only for users who may edit it).
 */
function anmoc_thumb_attrs( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || ! is_customize_preview() || ! current_user_can( 'edit_post', $post->ID ) ) {
		return array();
	}
	return anmoc_image_attrs( 'thumb:' . $post->ID, get_the_title( $post ), get_post_thumbnail_id( $post ) );
}

function anmoc_attrs_html( $attrs ) {
	$html = '';
	foreach ( $attrs as $name => $value ) {
		$html .= ' ' . $name . '="' . esc_attr( $value ) . '"';
	}
	return $html;
}

add_filter(
	'customize_dynamic_setting_args',
	function ( $args, $id ) {
		if ( preg_match( '/^anmoc_thumb\[\d+\]$/', $id ) ) {
			$args = array(
				'type'      => 'anmoc_thumb',
				'transport' => 'refresh',
				'default'   => 0,
			);
		}
		return $args;
	},
	10,
	2
);

add_filter(
	'customize_dynamic_setting_class',
	function ( $class, $id, $args ) {
		if ( isset( $args['type'] ) && 'anmoc_thumb' === $args['type'] ) {
			require_once ANMOC_DIR . '/inc/class-anmoc-thumb-setting.php';
			$class = 'Anmoc_Thumb_Setting';
		}
		return $class;
	},
	10,
	3
);

/* "anmoc_thumb_{ID}" / "anmoc_edit_{ID}" = may edit post ID (capability of the dynamic settings). */
add_filter(
	'map_meta_cap',
	function ( $caps, $cap, $user_id ) {
		if ( preg_match( '/^anmoc_(?:thumb|edit)_(\d+)$/', $cap, $m ) ) {
			$post = get_post( (int) $m[1] );
			$caps = $post ? map_meta_cap( 'edit_post', $user_id, $post->ID ) : array( 'do_not_allow' );
		}
		return $caps;
	},
	10,
	3
);
