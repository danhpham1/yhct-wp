<?php
/**
 * Customizer: colours, fonts, design options, page layouts and every content
 * field from inc/fields.php.
 *
 * Text, textarea, image and list fields use selective refresh, so the
 * preview updates in place and shows a pencil to jump to the field.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

function anmoc_sanitize_rich( $value ) {
	return wp_kses(
		(string) $value,
		array(
			'em'     => array(),
			'strong' => array(),
			'br'     => array(),
			'a'      => array( 'href' => array() ),
		)
	);
}

function anmoc_sanitize_choice( $value, $setting ) {
	$control = $setting->manager->get_control( $setting->id );
	return ( $control && isset( $control->choices[ $value ] ) ) ? $value : $setting->default;
}

function anmoc_sanitize_font( $value ) {
	return isset( anmoc_custom_fonts()[ $value ] ) ? $value : '';
}

function anmoc_sanitize_checkbox( $value ) {
	return ! empty( $value ) && 'false' !== $value;
}

/**
 * Repeater JSON: keep declared sub-fields only, max 20 rows.
 */
function anmoc_sanitize_repeater( $value, $setting ) {
	$fields = anmoc_fields();
	$sub    = isset( $fields[ $setting->id ]['sub'] ) ? $fields[ $setting->id ]['sub'] : array();
	$rows   = json_decode( (string) $value, true );
	if ( ! is_array( $rows ) ) {
		return $setting->default;
	}
	$clean = array();
	foreach ( array_slice( $rows, 0, 20 ) as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$item = array();
		foreach ( $sub as $key => $def ) {
			$raw          = isset( $row[ $key ] ) ? (string) $row[ $key ] : '';
			$item[ $key ] = 'textarea' === $def[1] ? anmoc_sanitize_rich( $raw ) : sanitize_text_field( $raw );
		}
		$clean[] = $item;
	}
	return wp_json_encode( $clean );
}

/**
 * Layout string: known keys only, optional "!" prefix for hidden.
 */
function anmoc_sanitize_layout( $value, $setting ) {
	$page  = substr( $setting->id, strlen( 'layout_' ) );
	$known = anmoc_layouts();
	$out   = array();
	foreach ( explode( ',', (string) $value ) as $token ) {
		$token = trim( $token );
		$key   = ltrim( $token, '!' );
		if ( isset( $known[ $page ][ $key ] ) ) {
			$out[] = ( '!' === substr( $token, 0, 1 ) ? '!' : '' ) . $key;
		}
	}
	return implode( ',', array_unique( $out ) );
}

/**
 * Customizer section each page's layout control lives in.
 */
function anmoc_layout_sections() {
	return array(
		'home'      => 'anmoc_home_layout',
		'about'     => 'anmoc_about',
		'services'  => 'anmoc_services',
		'doctors'   => 'anmoc_doctors',
		'journal'   => 'anmoc_journal',
		'community' => 'anmoc_community',
	);
}

add_action(
	'customize_register',
	function ( WP_Customize_Manager $wp_customize ) {
		require_once ANMOC_DIR . '/inc/customizer-controls.php';
		$wp_customize->register_control_type( 'Anmoc_Repeater_Control' );
		$wp_customize->register_control_type( 'Anmoc_Layout_Control' );

		foreach ( anmoc_panels() as $id => $panel ) {
			$wp_customize->add_panel(
				'anmoc_' . $id,
				array(
					'title'    => $panel[0],
					'priority' => $panel[1],
				)
			);
		}

		/* Colours */
		$wp_customize->add_section(
			'anmoc_colors',
			array(
				'title'       => 'Màu sắc',
				'panel'       => 'anmoc_global',
				'priority'    => 1,
				'description' => 'Đổi màu sẽ áp dụng ngay trên toàn bộ website. Bấm "Mặc định" ở từng ô để quay về màu gốc của thiết kế.',
			)
		);
		foreach ( anmoc_colors() as $key => $color ) {
			$wp_customize->add_setting(
				'color_' . $key,
				array(
					'default'           => $color[1],
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'color_' . $key,
					array(
						'label'       => $color[0],
						'description' => $color[2],
						'section'     => 'anmoc_colors',
					)
				)
			);
		}

		/* Fonts */
		$wp_customize->add_section(
			'anmoc_fonts',
			array(
				'title'    => 'Font chữ',
				'panel'    => 'anmoc_global',
				'priority' => 2,
			)
		);
		$schemes = array();
		foreach ( anmoc_font_schemes() as $id => $scheme ) {
			$schemes[ $id ] = $id . ' · ' . $scheme[0] . ' (' . $scheme[1] . ')';
		}
		$wp_customize->add_setting(
			'font_scheme',
			array(
				'default'           => 'A',
				'sanitize_callback' => 'anmoc_sanitize_choice',
			)
		);
		$wp_customize->add_control(
			'font_scheme',
			array(
				'label'       => 'Phương án font',
				'description' => 'A là font hiện tại. B, C, D đổi font tiêu đề và độ đậm theo 3 phương án khác.',
				'section'     => 'anmoc_fonts',
				'type'        => 'select',
				'choices'     => $schemes,
				'priority'    => 1,
			)
		);
		$wp_customize->add_setting(
			'font_switcher',
			array(
				'default'           => true,
				'sanitize_callback' => 'anmoc_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			'font_switcher',
			array(
				'label'       => 'Hiện nút "Aa Font" trên thanh trên cùng',
				'description' => 'Cho phép người xem bấm thử 4 phương án. NÊN TẮT khi đã chốt font và chính thức ra mắt website.',
				'section'     => 'anmoc_fonts',
				'type'        => 'checkbox',
				'priority'    => 2,
			)
		);
		$labels = array(
			'sans'  => 'Font chính (phương án A)',
			'serif' => 'Font nghiêng nhấn (phương án A)',
		);
		foreach ( anmoc_fonts() as $kind => $choices ) {
			$names = array_keys( $choices );
			$wp_customize->add_setting(
				'font_' . $kind,
				array(
					'default'           => $names[0],
					'sanitize_callback' => 'anmoc_sanitize_choice',
				)
			);
			$wp_customize->add_control(
				'font_' . $kind,
				array(
					'label'   => $labels[ $kind ],
					'section' => 'anmoc_fonts',
					'type'    => 'select',
					'choices' => array_combine( $names, $names ),
				)
			);
		}

		/* Sizes, radius, width, header & photo options */
		$wp_customize->add_section(
			'anmoc_design',
			array(
				'title'       => 'Cỡ chữ, nút & bố cục chung',
				'panel'       => 'anmoc_global',
				'priority'    => 3,
				'description' => 'Thay đổi hiển thị ngay trong khung xem trước.',
			)
		);
		foreach ( anmoc_design_options() as $id => $opt ) {
			list( $label, $type, $default, $extra ) = $opt;
			$wp_customize->add_setting(
				$id,
				array(
					'default'           => $default,
					'sanitize_callback' => 'checkbox' === $type ? 'anmoc_sanitize_checkbox' : 'absint',
					'transport'         => 'postMessage',
				)
			);
			$wp_customize->add_control(
				$id,
				array(
					'label'       => $label,
					'section'     => 'anmoc_design',
					'type'        => $type,
					'description' => trim( ( isset( $extra['help'] ) ? $extra['help'] . ' ' : '' ) . ( 'number' === $type ? 'Mặc định: ' . $default . '.' : '' ) ),
					'input_attrs' => 'number' === $type ? array_intersect_key( $extra, array_flip( array( 'min', 'max', 'step' ) ) ) : array(),
				)
			);
		}

		/* Logo lives with the brand fields. */
		$logo = $wp_customize->get_control( 'custom_logo' );
		if ( $logo ) {
			$logo->section     = 'anmoc_general';
			$logo->priority    = 1;
			$logo->description = 'Để trống để dùng biểu tượng lá mặc định.';
		}

		/* Home layout gets its own section at the top of the home panel. */
		$wp_customize->add_section(
			'anmoc_home_layout',
			array(
				'title'       => 'Bố cục trang chủ',
				'panel'       => 'anmoc_home',
				'priority'    => 1,
				'description' => 'Bật/tắt và sắp xếp thứ tự các khối của trang chủ.',
			)
		);

		/* Content */
		$sanitize = array(
			'text'     => 'sanitize_text_field',
			'textarea' => 'anmoc_sanitize_rich',
			'image'    => 'absint',
			'url'      => 'esc_url_raw',
			'email'    => 'sanitize_email',
			'repeater' => 'anmoc_sanitize_repeater',
			'font'     => 'anmoc_sanitize_font',
		);
		$live     = array( 'text', 'textarea', 'email', 'image', 'repeater' );
		$priority = 10;

		foreach ( anmoc_sections() as $section_id => $section ) {
			$wp_customize->add_section(
				'anmoc_' . $section_id,
				array(
					'title'       => $section['title'],
					'panel'       => 'anmoc_' . $section['panel'],
					'priority'    => $priority++,
					'description' => isset( $section['description'] ) ? $section['description'] : '',
				)
			);

			$control_priority = 20;
			foreach ( $section['fields'] as $id => $field ) {
				list( $label, $type, $default ) = $field;
				$control_priority++;

				$setting_default = $default;
				if ( 'image' === $type ) {
					$setting_default = '';
				} elseif ( 'repeater' === $type ) {
					$setting_default = wp_json_encode( $default );
				}

				$wp_customize->add_setting(
					$id,
					array(
						'default'           => $setting_default,
						'sanitize_callback' => isset( $sanitize[ $type ] ) ? $sanitize[ $type ] : 'sanitize_text_field',
						'transport'         => in_array( $type, $live, true ) || 'font' === $type ? 'postMessage' : 'refresh',
					)
				);

				$base = array(
					'label'    => $label,
					'section'  => 'anmoc_' . $section_id,
					'priority' => $control_priority,
				);

				if ( 'image' === $type ) {
					$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $id, $base + array( 'mime_type' => 'image' ) ) );
				} elseif ( 'repeater' === $type ) {
					$wp_customize->add_control( new Anmoc_Repeater_Control( $wp_customize, $id, $base + array( 'fields' => $field[3] ) ) );
				} elseif ( 'font' === $type ) {
					$choices = array( '' => 'Theo font chung (mặc định)' );
					foreach ( anmoc_custom_fonts() as $name => $font ) {
						$choices[ $name ] = $name . ' – ' . $font[2];
					}
					$wp_customize->add_control(
						$id,
						$base + array(
							'type'        => 'select',
							'choices'     => $choices,
							'description' => 'Để “Theo font chung” thì dòng này dùng font ở An Mộc · Thông tin chung → Font chữ.',
						)
					);
				} else {
					$wp_customize->add_control(
						$id,
						$base + array(
							'type'        => $type,
							'description' => 'textarea' === $type ? 'Xuống dòng sẽ được giữ nguyên. Có thể dùng &lt;em&gt; để in nghiêng.' : '',
						)
					);
				}

				if ( ! in_array( $type, $live, true ) ) {
					continue;
				}

				$wp_customize->selective_refresh->add_partial(
					$id,
					array(
						'selector'            => '[data-anmoc-field="' . $id . '"]',
						'settings'            => array( $id ),
						'container_inclusive' => 'image' === $type,
						'fallback_refresh'    => true,
						'render_callback'     => function ( $partial, $context = array() ) use ( $id, $type ) {
							if ( 'image' === $type ) {
								$size = isset( $context['size'] ) ? sanitize_key( $context['size'] ) : 'large';
								$alt  = isset( $context['alt'] ) ? sanitize_key( $context['alt'] ) : '';
								anmoc_image( $id, $size ? $size : 'large', $alt );
							} elseif ( 'repeater' === $type ) {
								anmoc_render_repeater( $id );
							} else {
								echo anmoc_field_html( $id ); // phpcs:ignore WordPress.Security.EscapeOutput
							}
						},
					)
				);
			}
		}

		/* Section on/off + order per page. */
		$layouts = anmoc_layouts();
		foreach ( anmoc_layout_sections() as $page => $section ) {
			$wp_customize->add_setting(
				'layout_' . $page,
				array(
					'default'           => anmoc_layout_default( $page ),
					'sanitize_callback' => 'anmoc_sanitize_layout',
				)
			);
			$wp_customize->add_control(
				new Anmoc_Layout_Control(
					$wp_customize,
					'layout_' . $page,
					array(
						'label'       => 'home' === $page ? 'Các khối' : 'Bố cục trang',
						'description' => 'home' === $page ? '' : 'Bật/tắt và sắp xếp thứ tự các khối của trang này.',
						'section'     => $section,
						'priority'    => 1,
						'items'       => $layouts[ $page ],
					)
				)
			);
		}
	}
);

/**
 * Preview: live CSS variables, body classes and full-refresh fallback.
 */
add_action(
	'customize_preview_init',
	function () {
		$vars    = array();
		$classes = array();
		foreach ( anmoc_design_options() as $id => $opt ) {
			if ( 'number' === $opt[1] ) {
				$vars[ $id ] = array( $opt[3]['var'], $opt[3]['unit'] );
			} else {
				$classes[ $id ] = $opt[3]['class_off'];
			}
		}
		$live = array();
		foreach ( anmoc_fields() as $id => $field ) {
			if ( in_array( $field['type'], array( 'text', 'textarea', 'email', 'image', 'repeater' ), true ) ) {
				$live[] = $id;
			}
		}
		wp_enqueue_script( 'anmoc-customize-preview', anmoc_asset( 'js/customize-preview.js' ), array( 'customize-preview', 'customize-selective-refresh' ), ANMOC_VERSION, true );
		wp_localize_script(
			'anmoc-customize-preview',
			'anmocPreview',
			array(
				'colors'  => array_keys( anmoc_colors() ),
				'vars'    => $vars,
				'classes' => $classes,
				'live'    => $live,
				'fonts'    => array_map( 'anmoc_custom_font_url', wp_list_pluck( anmoc_custom_fonts(), 0 ) ),
				'fallback' => wp_list_pluck( anmoc_custom_fonts(), 1 ),
				'targets'  => anmoc_font_targets(),
			)
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		if ( is_customize_preview() ) {
			wp_add_inline_style( 'anmoc', 'am-field{display:inline}' );
		}
	},
	20
);

/**
 * Controls pane: preview follows the section, plus repeater/layout UIs.
 */
add_action(
	'customize_controls_enqueue_scripts',
	function () {
		$urls = array( 'anmoc_home_layout' => anmoc_page_url( 'home' ) );
		foreach ( anmoc_sections() as $section_id => $section ) {
			$urls[ 'anmoc_' . $section_id ] = anmoc_page_url( $section['preview'] );
		}
		wp_enqueue_media();
		wp_enqueue_style( 'anmoc-customize-controls', anmoc_asset( 'css/customize-controls.css' ), array(), ANMOC_VERSION );
		wp_enqueue_script( 'anmoc-customize-controls', anmoc_asset( 'js/customize-controls.js' ), array( 'customize-controls', 'jquery' ), ANMOC_VERSION, true );
		wp_localize_script( 'anmoc-customize-controls', 'anmocSectionUrls', $urls );
	}
);
