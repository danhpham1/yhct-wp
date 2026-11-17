<?php
/**
 * Edit the text of services, doctors, testimonials and FAQ from the
 * Customizer preview, like the theme's own fields.
 *
 * Each field is printed through anmoc_post_text_e(): in the preview it gets
 * a pencil (a selective-refresh partial "anmoc_post[ID][field]") and the
 * page lists the editable fields in window.anmocPostSchema, from which the
 * controls pane builds a section for that item when a pencil is clicked.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

/**
 * Editable text fields per post type: key => [ label, text|textarea ].
 */
function anmoc_post_text_fields( $type = null ) {
	static $all = null;
	if ( null === $all ) {
		$titles   = array(
			'anmoc_service'     => 'Tên dịch vụ',
			'anmoc_doctor'      => 'Họ tên & học hàm',
			'anmoc_testimonial' => 'Tên khách hàng',
			'anmoc_faq'         => 'Câu hỏi',
		);
		$contents = array(
			'anmoc_testimonial' => 'Lời cảm nhận',
			'anmoc_faq'         => 'Câu trả lời',
		);
		$meta     = anmoc_meta_fields();
		$all      = array();
		foreach ( $titles as $post_type => $label ) {
			$fields = array();
			if ( isset( $contents[ $post_type ] ) ) {
				$fields['content'] = array( $contents[ $post_type ], 'textarea' );
			}
			$fields = array( 'title' => array( $label, 'text' ) ) + $fields;
			foreach ( isset( $meta[ $post_type ] ) ? $meta[ $post_type ] : array() as $key => $field ) {
				if ( in_array( $field[1], array( 'text', 'textarea' ), true ) ) {
					$fields[ $key ] = array( $field[0], $field[1] );
				}
			}
			$all[ $post_type ] = $fields;
		}
	}
	if ( null === $type ) {
		return $all;
	}
	return isset( $all[ $type ] ) ? $all[ $type ] : array();
}

function anmoc_post_setting_id( $post_id, $field ) {
	return 'anmoc_post[' . (int) $post_id . '][' . $field . ']';
}

/**
 * Stored value (what the editor box shows).
 */
function anmoc_post_text_raw( $post, $field ) {
	if ( isset( $GLOBALS['anmoc_post_preview'][ $post->ID ][ $field ] ) ) {
		return (string) $GLOBALS['anmoc_post_preview'][ $post->ID ][ $field ];
	}
	if ( 'title' === $field ) {
		return $post->post_title;
	}
	if ( 'content' === $field ) {
		return trim( wp_strip_all_tags( $post->post_content ) );
	}
	return anmoc_meta( $post, $field );
}

/**
 * Display value (not escaped). Titles keep WordPress' formatting outside the preview.
 */
function anmoc_post_text( $post, $field ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return '';
	}
	if ( 'title' === $field && ! isset( $GLOBALS['anmoc_post_preview'][ $post->ID ]['title'] ) ) {
		return get_the_title( $post );
	}
	return anmoc_post_text_raw( $post, $field );
}

/**
 * Echo a field, with a pencil in the Customizer preview.
 */
function anmoc_post_text_e( $post, $field ) {
	$post = get_post( $post );
	$html = esc_html( anmoc_post_text( $post, $field ) );
	if ( $post && is_customize_preview() && current_user_can( 'edit_post', $post->ID ) ) {
		$fields = anmoc_post_text_fields( $post->post_type );
		if ( isset( $fields[ $field ] ) ) {
			anmoc_post_schema_add( $post );
			$id   = anmoc_post_setting_id( $post->ID, $field );
			$opts = array(
				'settings'           => array( $id ),
				'primarySetting'     => $id,
				'containerInclusive' => false,
				'fallbackRefresh'    => false,
			);
			$html = '<am-field data-customize-partial-id="' . esc_attr( $id ) . '" data-customize-partial-type="anmoc_post" data-customize-partial-options="' . esc_attr( wp_json_encode( $opts ) ) . '">' . $html . '</am-field>';
		}
	}
	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above.
}

/**
 * Remember an item shown on this page so the controls pane can build its section.
 */
function anmoc_post_schema_add( $post ) {
	if ( isset( $GLOBALS['anmoc_post_schema'][ $post->ID ] ) ) {
		return;
	}
	$type   = get_post_type_object( $post->post_type );
	$fields = array();
	$order  = 0;
	foreach ( anmoc_post_text_fields( $post->post_type ) as $key => $field ) {
		$fields[ $key ] = array(
			'label' => $field[0],
			'type'  => $field[1],
			'value' => anmoc_post_text_raw( $post, $key ),
			'order' => ++$order,
		);
	}
	$GLOBALS['anmoc_post_schema'][ $post->ID ] = array(
		'title'  => ( $type ? $type->labels->singular_name . ': ' : '' ) . anmoc_post_text_raw( $post, 'title' ),
		'note'   => sprintf( 'Nội dung này nằm trong menu %s. Sửa ở đây là sửa luôn ở đó, và chỉ lưu khi bấm Xuất bản.', $type ? $type->labels->name : '' ),
		'fields' => $fields,
	);
}

add_action(
	'wp_footer',
	function () {
		if ( is_customize_preview() && ! empty( $GLOBALS['anmoc_post_schema'] ) ) {
			echo '<script>window.anmocPostSchema=' . wp_json_encode( $GLOBALS['anmoc_post_schema'], JSON_HEX_TAG | JSON_HEX_AMP ) . ';</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput
		}
	},
	5
);

/* ---------- Dynamic settings and partials ---------- */

function anmoc_post_setting_parts( $id ) {
	if ( ! preg_match( '/^anmoc_post\[(\d+)\]\[([a-z_]+)\]$/', $id, $m ) ) {
		return null;
	}
	$post = get_post( (int) $m[1] );
	if ( ! $post || ! isset( anmoc_post_text_fields( $post->post_type )[ $m[2] ] ) ) {
		return null;
	}
	return array( $post, $m[2] );
}

add_filter(
	'customize_dynamic_setting_args',
	function ( $args, $id ) {
		if ( anmoc_post_setting_parts( $id ) ) {
			$args = array(
				'type'      => 'anmoc_post',
				'transport' => 'postMessage',
				'default'   => '',
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
		if ( isset( $args['type'] ) && 'anmoc_post' === $args['type'] ) {
			require_once ANMOC_DIR . '/inc/class-anmoc-post-field-setting.php';
			$class = 'Anmoc_Post_Field_Setting';
		}
		return $class;
	},
	10,
	3
);

add_filter(
	'customize_dynamic_partial_args',
	function ( $args, $id ) {
		$parts = anmoc_post_setting_parts( $id );
		if ( $parts ) {
			list( $post, $field ) = $parts;
			$args = array(
				'type'                => 'anmoc_post',
				'settings'            => array( $id ),
				'primary_setting'     => $id,
				'container_inclusive' => false,
				'fallback_refresh'    => false,
				'render_callback'     => function () use ( $post, $field ) {
					return esc_html( anmoc_post_text( $post, $field ) );
				},
			);
		}
		return $args;
	},
	10,
	2
);
