<?php
/**
 * Template helpers.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

/**
 * Raw value of an editable field (falls back to its registered default).
 */
function anmoc_get( $id ) {
	$fields = anmoc_fields();
	if ( ! isset( $fields[ $id ] ) ) {
		return '';
	}
	$field   = $fields[ $id ];
	$default = 'image' === $field['type'] ? '' : $field['default'];
	if ( 'repeater' === $field['type'] ) {
		$default = wp_json_encode( $default );
	}
	$value = get_theme_mod( $id, $default );
	return is_scalar( $value ) ? (string) $value : $default;
}

/**
 * Multi-line text: keeps line breaks and a few inline tags.
 */
function anmoc_rich( $text ) {
	$text = wp_kses(
		(string) $text,
		array(
			'em'     => array(),
			'strong' => array(),
			'br'     => array(),
			'a'      => array( 'href' => array() ),
		)
	);
	return nl2br( trim( $text ), false );
}

/**
 * Escaped HTML of a field value, without the preview wrapper.
 */
function anmoc_field_html( $id ) {
	$fields = anmoc_fields();
	$type   = isset( $fields[ $id ] ) ? $fields[ $id ]['type'] : 'text';
	$html   = 'textarea' === $type ? anmoc_rich( anmoc_get( $id ) ) : esc_html( anmoc_get( $id ) );
	return false === strpos( $html, '{' ) ? $html : strtr( $html, anmoc_field_tokens() );
}

/**
 * Placeholders allowed inside text fields, e.g. "© {year} An Mộc".
 * Values are escaped HTML.
 */
function anmoc_field_tokens() {
	$phone   = anmoc_get( 'phone' );
	$privacy = anmoc_privacy_url();
	$label   = esc_html( anmoc_get( 'privacy_label' ) );
	return array(
		'{year}'    => esc_html( wp_date( 'Y' ) ),
		'{phone}'   => '<a href="' . esc_url( anmoc_tel( $phone ) ) . '">' . esc_html( $phone ) . '</a>',
		'{privacy}' => $privacy ? '<a href="' . esc_url( $privacy ) . '">' . $label . '</a>' : $label,
	);
}

/**
 * Echo a field. In the Customizer preview it is wrapped so the pencil
 * shortcut and instant (selective) refresh can find it; the live site
 * gets the bare text.
 */
function anmoc_e( $id ) {
	$html = anmoc_field_html( $id );
	if ( is_customize_preview() ) {
		$html = '<am-field data-anmoc-field="' . esc_attr( $id ) . '">' . $html . '</am-field>';
	}
	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in anmoc_field_html().
}

/**
 * Attribute marking a container whose content is a field (repeaters).
 */
function anmoc_field_attr( $id ) {
	if ( is_customize_preview() ) {
		echo ' data-anmoc-field="' . esc_attr( $id ) . '"';
	}
}

/**
 * Rows of a repeater field, each row limited to the declared sub-fields.
 */
function anmoc_rows( $id ) {
	$fields = anmoc_fields();
	if ( ! isset( $fields[ $id ] ) || 'repeater' !== $fields[ $id ]['type'] ) {
		return array();
	}
	$rows = json_decode( anmoc_get( $id ), true );
	if ( ! is_array( $rows ) ) {
		$rows = $fields[ $id ]['default'];
	}
	$clean = array();
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$item = array();
		foreach ( array_keys( $fields[ $id ]['sub'] ) as $key ) {
			$item[ $key ] = isset( $row[ $key ] ) ? (string) $row[ $key ] : '';
		}
		if ( implode( '', $item ) !== '' ) {
			$clean[] = $item;
		}
	}
	return $clean;
}

/**
 * Inner markup of each repeater (shared by templates and selective refresh).
 */
function anmoc_render_repeater( $id ) {
	$rows = anmoc_rows( $id );
	foreach ( $rows as $i => $row ) {
		switch ( $id ) {
			case 'hero_stats':
			case 'numbers':
				printf( '<div><strong>%s</strong><span>%s</span></div>', esc_html( $row['value'] ), esc_html( $row['label'] ) );
				break;
			case 'values':
				printf(
					'<div><span aria-hidden="true">%s</span><h3>%s</h3><p>%s</p></div>',
					esc_html( sprintf( '%02d', $i + 1 ) ),
					esc_html( $row['title'] ),
					anmoc_rich( $row['desc'] ) // phpcs:ignore WordPress.Security.EscapeOutput
				);
				break;
			case 'steps':
				printf( '<li class="step"><span>%s</span><h3>%s</h3></li>', esc_html( sprintf( '%02d', $i + 1 ) ), esc_html( $row['title'] ) );
				break;
			case 'standards':
				printf( '<li>%s%s</li>', anmoc_icon( 'check' ), esc_html( $row['text'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput
				break;
		}
	}
}

/**
 * Image field: Media Library attachment or bundled fallback.
 *
 * @param string $id     Field id.
 * @param string $size   Image size.
 * @param string $alt_id Field id holding the alt text.
 */
function anmoc_image( $id, $size = 'large', $alt_id = '' ) {
	$alt   = $alt_id ? anmoc_get( $alt_id ) : '';
	$att   = absint( get_theme_mod( $id ) );
	$attrs = array(
		'alt'     => $alt,
		'loading' => 'hero_image' === $id ? 'eager' : 'lazy',
	);
	if ( 'hero_image' === $id ) {
		$attrs['fetchpriority'] = 'high';
	}
	if ( is_customize_preview() ) {
		$fields = anmoc_fields();
		$attrs['data-anmoc-field']                          = $id;
		$attrs['data-customize-partial-placement-context'] = wp_json_encode( array( 'size' => $size, 'alt' => $alt_id ) );
		$attrs += anmoc_image_attrs( 'mod:' . $id, isset( $fields[ $id ] ) ? $fields[ $id ]['label'] : '', $att );
	}
	if ( $att && wp_attachment_is_image( $att ) ) {
		echo wp_get_attachment_image( $att, $size, false, $attrs );
		return;
	}
	$fields = anmoc_fields();
	$file   = isset( $fields[ $id ] ) ? $fields[ $id ]['default'] : '';
	if ( $file ) {
		$attrs['src'] = anmoc_asset( 'images/' . $file );
		$html         = '<img';
		foreach ( $attrs as $name => $value ) {
			$html .= ' ' . $name . '="' . esc_attr( $value ) . '"';
		}
		echo $html . ' />'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

/**
 * Enabled section keys of a page, in the editor's order.
 * Stored as "hero,philosophy,!services" (! = hidden).
 */
function anmoc_layout( $page, $with_hidden = false ) {
	$known = anmoc_layouts();
	if ( ! isset( $known[ $page ] ) ) {
		return array();
	}
	$saved = array_filter( array_map( 'trim', explode( ',', (string) get_theme_mod( 'layout_' . $page, anmoc_layout_default( $page ) ) ) ) );
	$items = array();
	foreach ( $saved as $token ) {
		$key = ltrim( $token, '!' );
		if ( isset( $known[ $page ][ $key ] ) && ! isset( $items[ $key ] ) ) {
			$items[ $key ] = '!' !== $token[0];
		}
	}
	// Sections added in a later theme version show up at the end.
	foreach ( array_keys( $known[ $page ] ) as $key ) {
		if ( ! isset( $items[ $key ] ) ) {
			$items[ $key ] = true;
		}
	}
	return $with_hidden ? $items : array_keys( array_filter( $items ) );
}

/**
 * Render a page's sections in the configured order.
 */
function anmoc_render_sections( $page, $args = array() ) {
	foreach ( anmoc_layout( $page ) as $key ) {
		switch ( $key ) {
			case 'intro':
				get_template_part( 'template-parts/page-intro', null, array_merge( array( 'prefix' => $page ), $args ) );
				break;
			case 'banner':
				get_template_part( 'template-parts/booking-banner' );
				break;
			case 'content':
				anmoc_the_page_content();
				break;
			default:
				get_template_part( 'template-parts/sections/' . $page . '-' . $key, null, $args );
		}
	}
}

/**
 * Featured image of a post, with bundled fallback.
 */
function anmoc_post_image( $post = null, $size = 'anmoc-card', $fallback = 'massage.jpg' ) {
	$post  = get_post( $post );
	$attrs = anmoc_thumb_attrs( $post );
	if ( has_post_thumbnail( $post ) ) {
		echo get_the_post_thumbnail( $post, $size, array( 'loading' => 'lazy' ) + $attrs );
		return;
	}
	printf( '<img src="%s" alt="%s" loading="lazy"%s />', esc_url( anmoc_asset( 'images/' . $fallback ) ), esc_attr( get_the_title( $post ) ), anmoc_attrs_html( $attrs ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in anmoc_attrs_html().
}

function anmoc_asset( $path ) {
	return ANMOC_URI . '/assets/' . ltrim( $path, '/' );
}

/**
 * Inline SVG icons from the design.
 */
function anmoc_icon( $name ) {
	$paths = array(
		'arrow'    => '<path d="M5 12h14M14 7l5 5-5 5" />',
		'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2" /><path d="M16 3v4M8 3v4M3 10h18" />',
		'phone'    => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.78.62 2.63a2 2 0 0 1-.45 2.11L8 9.73a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0 1 22 16.92z" />',
		'pin'      => '<path d="M21 10c0 7-9 12-9 12S3 17 3 10a9 9 0 1 1 18 0z" /><circle cx="12" cy="10" r="3" />',
		'clock'    => '<circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" />',
		'check'    => '<path d="m5 12 4 4L19 6" />',
	);
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	return '<svg class="icon" viewBox="0 0 24 24" aria-hidden="true">' . $paths[ $name ] . '</svg>';
}

/**
 * Logo: uploaded Custom Logo, otherwise the drawn mark + name.
 */
function anmoc_brand( $light = false ) {
	$class = 'brand' . ( $light ? ' brand-light' : '' );
	$logo  = get_theme_mod( 'custom_logo' );
	echo '<div class="' . esc_attr( $class ) . '">';
	if ( $logo ) {
		echo wp_get_attachment_image( $logo, 'medium', false, array( 'class' => 'brand-logo', 'alt' => anmoc_get( 'brand_name' ) ) + anmoc_image_attrs( 'mod:custom_logo', 'Logo', $logo ) );
	} else {
		echo '<svg class="brand-mark" viewBox="0 0 48 48" aria-hidden="true"' . anmoc_attrs_html( anmoc_image_attrs( 'mod:custom_logo', 'Logo' ) ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput
		echo '<circle cx="24" cy="24" r="21" /><path d="M13 29c9 1 17-4 21-14 2 11-3 19-14 20" /><path d="M18 34c2-7 7-12 15-16M14 15c3 0 6 2 7 5" /></svg>';
	}
	echo '<span><strong>';
	anmoc_e( 'brand_name' );
	echo '</strong><small>';
	anmoc_e( 'brand_tagline' );
	echo '</small></span></div>';
}

/**
 * Small uppercase label with a rule. Accepts a field id or plain text.
 */
function anmoc_eyebrow( $text, $light = false ) {
	$fields = anmoc_fields();
	if ( isset( $fields[ $text ] ) ) {
		if ( '' === trim( anmoc_get( $text ) ) ) {
			return;
		}
		ob_start();
		anmoc_e( $text );
		$html = ob_get_clean();
	} else {
		if ( '' === trim( (string) $text ) ) {
			return;
		}
		$html = esc_html( $text );
	}
	printf( '<div class="eyebrow%s"><span></span>%s</div>', $light ? ' eyebrow-light' : '', $html ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Page keys mapped to their page template file.
 */
function anmoc_page_templates() {
	return array(
		'about'     => array( 'templates/about.php', 'Về An Mộc', 've-an-moc' ),
		'services'  => array( 'templates/services.php', 'Trị liệu', 'tri-lieu' ),
		'doctors'   => array( 'templates/doctors.php', 'Đội ngũ', 'doi-ngu' ),
		'community' => array( 'templates/community.php', 'Hoạt động', 'hoat-dong' ),
		'contact'   => array( 'templates/contact.php', 'Đặt lịch khám', 'dat-lich' ),
		'privacy'   => array( 'templates/privacy.php', 'Chính sách bảo mật', 'chinh-sach-bao-mat' ),
	);
}

/**
 * ID of the page using a theme template.
 */
function anmoc_page_id( $key ) {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}
	$id = 0;
	if ( 'journal' === $key ) {
		$id = (int) get_option( 'page_for_posts' );
	} elseif ( 'home' === $key ) {
		$id = (int) get_option( 'page_on_front' );
	} else {
		$templates = anmoc_page_templates();
		if ( isset( $templates[ $key ] ) ) {
			$pages = get_posts(
				array(
					'post_type'      => 'page',
					'post_status'    => 'publish',
					'posts_per_page' => 1,
					'fields'         => 'ids',
					'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
					'meta_value'     => $templates[ $key ][0], // phpcs:ignore WordPress.DB.SlowDBQuery
				)
			);
			$id = $pages ? (int) $pages[0] : 0;
		}
	}
	$cache[ $key ] = $id;
	return $id;
}

function anmoc_page_url( $key, $args = array() ) {
	if ( 'home' === $key ) {
		$url = home_url( '/' );
	} else {
		$id  = anmoc_page_id( $key );
		$url = $id ? get_permalink( $id ) : home_url( '/' );
	}
	return $args ? add_query_arg( $args, $url ) : $url;
}

function anmoc_tel( $phone ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
}

/**
 * Closing time shown in the "Hôm nay" card, by weekday in site timezone.
 */
function anmoc_close_today() {
	$day = (int) wp_date( 'N' );
	return $day >= 6 ? anmoc_get( 'close_weekend' ) : anmoc_get( 'close_weekday' );
}

function anmoc_reading_time( $post = null ) {
	$manual = absint( anmoc_meta( get_post( $post ), 'read' ) );
	if ( $manual ) {
		return $manual;
	}
	// str_word_count() splits on accented letters, so count whitespace-separated words.
	$words = count( preg_split( '/\s+/u', trim( wp_strip_all_tags( get_post_field( 'post_content', $post ) ) ), -1, PREG_SPLIT_NO_EMPTY ) );
	return max( 1, (int) ceil( $words / 200 ) );
}

/**
 * Primary category name of a post (CSS uppercases it on cards).
 */
function anmoc_post_tag( $post = null ) {
	$cats    = get_the_category( $post ? get_post( $post )->ID : 0 );
	$default = (int) get_option( 'default_category' );
	foreach ( $cats as $cat ) {
		// "Chưa phân loại" is WordPress' fallback: not worth a tag on the card.
		if ( $cat->term_id !== $default ) {
			return $cat->name;
		}
	}
	return '';
}

/**
 * Testimonials for a placement ("home" or "community").
 */
function anmoc_testimonials( $placement ) {
	return get_posts(
		array(
			'post_type'      => 'anmoc_testimonial',
			'posts_per_page' => 6,
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery
				array(
					'key'     => '_anmoc_placement',
					'value'   => array( $placement, 'both' ),
					'compare' => 'IN',
				),
			),
		)
	);
}

function anmoc_services( $home_only = false ) {
	$args = array(
		'post_type'      => 'anmoc_service',
		'posts_per_page' => -1,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	);
	if ( $home_only ) {
		$args['meta_key']   = '_anmoc_on_home'; // phpcs:ignore WordPress.DB.SlowDBQuery
		$args['meta_value'] = '1'; // phpcs:ignore WordPress.DB.SlowDBQuery
	}
	return get_posts( $args );
}

function anmoc_meta( $post, $key ) {
	return (string) get_post_meta( is_object( $post ) ? $post->ID : $post, '_anmoc_' . $key, true );
}

/**
 * Extra blocks an editor adds in the page editor, rendered under the
 * designed sections.
 */
function anmoc_the_page_content() {
	if ( ! is_singular() ) {
		return;
	}
	$content = trim( (string) get_post_field( 'post_content', get_queried_object_id() ) );
	if ( '' === $content ) {
		return;
	}
	echo '<section class="section page-extra"><div class="container entry-content">';
	echo apply_filters( 'the_content', $content ); // phpcs:ignore WordPress.Security.EscapeOutput
	echo '</div></section>';
}

/**
 * The featured (newest sticky) post shown at the top of the journal.
 */
function anmoc_featured_post_id() {
	$sticky = array_filter( array_map( 'absint', (array) get_option( 'sticky_posts', array() ) ) );
	if ( ! $sticky ) {
		return 0;
	}
	$ids = get_posts(
		array(
			'post__in'            => $sticky,
			'posts_per_page'      => 1,
			'fields'              => 'ids',
			'ignore_sticky_posts' => true,
		)
	);
	return $ids ? (int) $ids[0] : 0;
}

function anmoc_byline( $post = null ) {
	$byline = anmoc_meta( get_post( $post ), 'byline' );
	return $byline ? $byline : get_the_author_meta( 'display_name', get_post_field( 'post_author', $post ) );
}
