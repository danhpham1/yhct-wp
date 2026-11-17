<?php
/**
 * Repeating content: services, doctors, testimonials, FAQs, bookings.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

/**
 * Meta fields per post type: key => [label, type, help].
 */
function anmoc_meta_fields() {
	return array(
		'anmoc_service'     => array(
			'desc'    => array( 'Mô tả ngắn', 'textarea', 'Hiện trên thẻ dịch vụ.' ),
			'tagline' => array( 'Nhãn mục tiêu (trang chủ)', 'text', 'VD: THẤU HIỂU, KHAI THÔNG…' ),
			'short'   => array( 'Tên ngắn (link "Tư vấn …")', 'text', 'VD: châm cứu → link hiện "Tư vấn châm cứu".' ),
			'meta'    => array( 'Thời lượng / ghi chú', 'text', 'VD: 45 phút · Lần đầu' ),
			'on_home' => array( 'Hiện ở trang chủ', 'checkbox', '' ),
		),
		'anmoc_doctor'      => array(
			'role'  => array( 'Chức vụ', 'text', 'VD: Giám đốc chuyên môn' ),
			'focus' => array( 'Chuyên môn', 'text', 'VD: Châm cứu · Nội khoa' ),
			'exp'   => array( 'Kinh nghiệm', 'text', 'VD: 22 năm kinh nghiệm' ),
		),
		'anmoc_testimonial' => array(
			'service'   => array( 'Dịch vụ đã dùng', 'text', 'VD: Cơ xương khớp. Hiện cạnh tên khách.' ),
			'placement' => array(
				'Hiển thị ở',
				'select',
				'',
				array(
					'home'      => 'Trang chủ',
					'community' => 'Trang Hoạt động',
					'both'      => 'Cả hai trang',
				),
			),
		),
		'post'              => array(
			'byline' => array( 'Người biên soạn hiển thị', 'text', 'VD: BS.CKII Nguyễn Minh An. Để trống sẽ dùng tên tác giả.' ),
			'read'   => array( 'Số phút đọc', 'text', 'Để trống để tự tính theo độ dài bài.' ),
		),
		'anmoc_booking'     => array(
			'phone'   => array( 'Số điện thoại', 'text', '' ),
			'service' => array( 'Dịch vụ', 'text', '' ),
			'doctor'  => array( 'Bác sĩ mong muốn', 'text', '' ),
			'date'    => array( 'Ngày mong muốn', 'text', '' ),
			'note'    => array( 'Ghi chú', 'textarea', '' ),
			'status'  => array(
				'Trạng thái',
				'select',
				'',
				array(
					'new'       => 'Mới',
					'confirmed' => 'Đã xác nhận',
					'done'      => 'Đã khám',
					'cancelled' => 'Đã hủy',
				),
			),
		),
	);
}

add_action(
	'init',
	function () {
		$common = array(
			'public'       => false,
			'show_ui'      => true,
			'show_in_rest' => false,
			'rewrite'      => false,
		);

		register_post_type(
			'anmoc_service',
			array_merge(
				$common,
				array(
					'labels'        => anmoc_cpt_labels( 'Trị liệu', 'dịch vụ' ),
					'menu_icon'     => 'dashicons-heart',
					'menu_position' => 21,
					'supports'      => array( 'title', 'page-attributes' ),
				)
			)
		);

		register_post_type(
			'anmoc_doctor',
			array_merge(
				$common,
				array(
					'labels'        => anmoc_cpt_labels( 'Bác sĩ', 'bác sĩ' ),
					'menu_icon'     => 'dashicons-id-alt',
					'menu_position' => 22,
					'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
				)
			)
		);

		register_post_type(
			'anmoc_testimonial',
			array_merge(
				$common,
				array(
					'labels'        => anmoc_cpt_labels( 'Cảm nhận', 'cảm nhận' ),
					'menu_icon'     => 'dashicons-format-quote',
					'menu_position' => 23,
					'supports'      => array( 'title', 'editor', 'page-attributes' ),
				)
			)
		);

		register_post_type(
			'anmoc_faq',
			array_merge(
				$common,
				array(
					'labels'        => anmoc_cpt_labels( 'Câu hỏi thường gặp', 'câu hỏi' ),
					'menu_icon'     => 'dashicons-editor-help',
					'menu_position' => 24,
					'supports'      => array( 'title', 'editor', 'page-attributes' ),
				)
			)
		);

		register_post_type(
			'anmoc_booking',
			array_merge(
				$common,
				array(
					'labels'        => anmoc_cpt_labels( 'Lịch hẹn', 'lịch hẹn' ),
					'menu_icon'     => 'dashicons-calendar-alt',
					'menu_position' => 20,
					'supports'      => array( 'title' ),
					'capabilities'  => array( 'create_posts' => 'do_not_allow' ),
					'map_meta_cap'  => true,
				)
			)
		);
	}
);

function anmoc_cpt_labels( $plural, $singular ) {
	return array(
		'name'               => $plural,
		'singular_name'      => $plural,
		'menu_name'          => $plural,
		'add_new'            => 'Thêm ' . $singular,
		'add_new_item'       => 'Thêm ' . $singular . ' mới',
		'edit_item'          => 'Sửa ' . $singular,
		'new_item'           => ucfirst( $singular ) . ' mới',
		'view_item'          => 'Xem ' . $singular,
		'search_items'       => 'Tìm ' . $singular,
		'not_found'          => 'Chưa có ' . $singular . ' nào',
		'not_found_in_trash' => 'Thùng rác trống',
		'all_items'          => 'Tất cả ' . $singular,
	);
}

/* Title placeholders that explain what the title is used for. */
add_filter(
	'enter_title_here',
	function ( $text, $post ) {
		$map = array(
			'anmoc_service'     => 'Tên dịch vụ',
			'anmoc_doctor'      => 'Họ tên & học hàm (VD: BS.CKII Nguyễn Minh An)',
			'anmoc_testimonial' => 'Tên khách hàng (VD: CHỊ LAN, 48 TUỔI)',
			'anmoc_faq'         => 'Câu hỏi',
		);
		return isset( $map[ $post->post_type ] ) ? $map[ $post->post_type ] : $text;
	},
	10,
	2
);

add_action(
	'edit_form_after_title',
	function ( $post ) {
		$hints = array(
			'anmoc_testimonial' => 'Nhập lời cảm nhận vào khung soạn thảo bên dưới.',
			'anmoc_faq'         => 'Nhập câu trả lời vào khung soạn thảo bên dưới.',
			'anmoc_doctor'      => 'Ảnh chân dung: dùng khung "Ảnh đại diện" bên phải (tỉ lệ dọc, khoảng 760×940px).',
		);
		if ( isset( $hints[ $post->post_type ] ) ) {
			echo '<p class="description" style="margin:12px 0 0">' . esc_html( $hints[ $post->post_type ] ) . '</p>';
		}
	}
);

/* ---------- Meta boxes ---------- */

add_action(
	'add_meta_boxes',
	function () {
		foreach ( array_keys( anmoc_meta_fields() ) as $type ) {
			add_meta_box( 'anmoc_meta', 'Thông tin hiển thị', 'anmoc_render_meta_box', $type, 'normal', 'high' );
		}
	}
);

function anmoc_render_meta_box( $post ) {
	$fields = anmoc_meta_fields()[ $post->post_type ];
	wp_nonce_field( 'anmoc_meta_' . $post->ID, 'anmoc_meta_nonce' );
	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( $fields as $key => $field ) {
		$name  = 'anmoc_meta[' . $key . ']';
		$value = anmoc_meta( $post, $key );
		echo '<tr><th scope="row"><label for="anmoc-' . esc_attr( $key ) . '">' . esc_html( $field[0] ) . '</label></th><td>';
		switch ( $field[1] ) {
			case 'textarea':
				printf( '<textarea id="anmoc-%1$s" name="%2$s" rows="3" class="large-text">%3$s</textarea>', esc_attr( $key ), esc_attr( $name ), esc_textarea( $value ) );
				break;
			case 'checkbox':
				printf( '<label><input id="anmoc-%1$s" type="checkbox" name="%2$s" value="1" %3$s /> Có</label>', esc_attr( $key ), esc_attr( $name ), checked( $value, '1', false ) );
				break;
			case 'select':
				printf( '<select id="anmoc-%1$s" name="%2$s">', esc_attr( $key ), esc_attr( $name ) );
				foreach ( $field[3] as $opt => $label ) {
					printf( '<option value="%s" %s>%s</option>', esc_attr( $opt ), selected( $value, $opt, false ), esc_html( $label ) );
				}
				echo '</select>';
				break;
			default:
				printf( '<input id="anmoc-%1$s" type="text" name="%2$s" value="%3$s" class="regular-text" />', esc_attr( $key ), esc_attr( $name ), esc_attr( $value ) );
		}
		if ( $field[2] ) {
			echo '<p class="description">' . esc_html( $field[2] ) . '</p>';
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

add_action(
	'save_post',
	function ( $post_id, $post ) {
		$all = anmoc_meta_fields();
		if ( ! isset( $all[ $post->post_type ], $_POST['anmoc_meta_nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( sanitize_key( $_POST['anmoc_meta_nonce'] ), 'anmoc_meta_' . $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		$input = isset( $_POST['anmoc_meta'] ) ? wp_unslash( (array) $_POST['anmoc_meta'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitised per field below.
		foreach ( $all[ $post->post_type ] as $key => $field ) {
			$raw = isset( $input[ $key ] ) ? $input[ $key ] : '';
			if ( 'checkbox' === $field[1] ) {
				$value = $raw ? '1' : '';
			} elseif ( 'select' === $field[1] ) {
				$value = isset( $field[3][ $raw ] ) ? $raw : array_key_first( $field[3] );
			} elseif ( 'textarea' === $field[1] ) {
				$value = sanitize_textarea_field( $raw );
			} else {
				$value = sanitize_text_field( $raw );
			}
			update_post_meta( $post_id, '_anmoc_' . $key, $value );
		}
	},
	10,
	2
);

/* ---------- Admin list columns ---------- */

add_filter(
	'manage_anmoc_booking_posts_columns',
	function () {
		return array(
			'cb'      => '<input type="checkbox" />',
			'title'   => 'Khách hàng',
			'phone'   => 'Điện thoại',
			'service' => 'Dịch vụ',
			'pdate'   => 'Ngày mong muốn',
			'status'  => 'Trạng thái',
			'date'    => 'Gửi lúc',
		);
	}
);

add_filter(
	'manage_anmoc_service_posts_columns',
	function ( $cols ) {
		return array_merge( array_slice( $cols, 0, 2 ), array( 'on_home' => 'Trang chủ', 'menu_order' => 'Thứ tự' ), array_slice( $cols, 2 ) );
	}
);

add_filter(
	'manage_anmoc_doctor_posts_columns',
	function ( $cols ) {
		return array_merge( array( 'cb' => $cols['cb'], 'photo' => 'Ảnh' ), array_slice( $cols, 1, 1 ), array( 'role' => 'Chức vụ', 'menu_order' => 'Thứ tự' ), array_slice( $cols, 2 ) );
	}
);

add_filter(
	'manage_anmoc_testimonial_posts_columns',
	function ( $cols ) {
		return array_merge( array_slice( $cols, 0, 2 ), array( 'placement' => 'Hiển thị ở', 'menu_order' => 'Thứ tự' ), array_slice( $cols, 2 ) );
	}
);

add_filter(
	'manage_anmoc_faq_posts_columns',
	function ( $cols ) {
		return array_merge( array_slice( $cols, 0, 2 ), array( 'menu_order' => 'Thứ tự' ), array_slice( $cols, 2 ) );
	}
);

add_action(
	'manage_posts_custom_column',
	function ( $col, $post_id ) {
		$post   = get_post( $post_id );
		$fields = anmoc_meta_fields();
		switch ( $col ) {
			case 'phone':
				$phone = anmoc_meta( $post_id, 'phone' );
				printf( '<a href="%s">%s</a>', esc_url( anmoc_tel( $phone ) ), esc_html( $phone ) );
				break;
			case 'service':
			case 'role':
				echo esc_html( anmoc_meta( $post_id, $col ) );
				break;
			case 'pdate':
				echo esc_html( anmoc_meta( $post_id, 'date' ) );
				break;
			case 'status':
			case 'placement':
				$value = anmoc_meta( $post_id, $col );
				$opts  = $fields[ $post->post_type ][ $col ][3];
				echo esc_html( isset( $opts[ $value ] ) ? $opts[ $value ] : reset( $opts ) );
				break;
			case 'on_home':
				echo anmoc_meta( $post_id, 'on_home' ) ? '✓' : '—';
				break;
			case 'menu_order':
				echo (int) $post->menu_order;
				break;
			case 'photo':
				echo get_the_post_thumbnail( $post_id, array( 48, 48 ), array( 'style' => 'width:48px;height:48px;object-fit:cover;border-radius:4px' ) );
				break;
		}
	},
	10,
	2
);

/* Order admin lists like the front end. */
add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() || $query->get( 'orderby' ) ) {
			return;
		}
		if ( in_array( $query->get( 'post_type' ), array( 'anmoc_service', 'anmoc_doctor', 'anmoc_testimonial', 'anmoc_faq' ), true ) ) {
			$query->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'ASC' ) );
		}
	}
);
