<?php
/**
 * First activation: create pages, menus and demo content from the design so
 * the site looks finished and every item is ready to edit.
 *
 * Runs once (option "anmoc_seeded"); re-run from Giao diện → Dữ liệu mẫu.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_switch_theme', 'anmoc_seed' );

add_action(
	'admin_menu',
	function () {
		add_theme_page( 'Dữ liệu mẫu An Mộc', 'Dữ liệu mẫu', 'manage_options', 'anmoc-seed', 'anmoc_seed_page' );
	}
);

function anmoc_seed_page() {
	if ( isset( $_POST['anmoc_reseed'] ) && check_admin_referer( 'anmoc_reseed' ) ) {
		delete_option( 'anmoc_seeded' );
		anmoc_seed();
		echo '<div class="notice notice-success"><p>Đã nạp dữ liệu mẫu. Các mục đã tồn tại được giữ nguyên.</p></div>';
	}
	echo '<div class="wrap"><h1>Dữ liệu mẫu An Mộc</h1>';
	echo '<p>Tạo các trang, menu, dịch vụ, bác sĩ, cảm nhận, câu hỏi thường gặp và bài viết mẫu theo thiết kế. Mục nào đã có (trùng tiêu đề) sẽ không bị tạo lại hay ghi đè.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'anmoc_reseed' );
	echo '<p><button class="button button-primary" name="anmoc_reseed" value="1">Nạp dữ liệu mẫu</button></p></form></div>';
}

function anmoc_seed() {
	if ( get_option( 'anmoc_seeded' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$img = anmoc_seed_images();

	/* Image fields in the Customizer point at the imported attachments. */
	foreach ( anmoc_fields() as $id => $field ) {
		if ( 'image' === $field['type'] && ! get_theme_mod( $id ) && isset( $img[ $field['default'] ] ) ) {
			set_theme_mod( $id, $img[ $field['default'] ] );
		}
	}

	/* Pages */
	$front = anmoc_seed_post( 'page', 'Trang chủ', array( 'post_name' => 'trang-chu' ) );
	$blog  = anmoc_seed_post( 'page', 'Kiến thức', array( 'post_name' => 'kien-thuc' ) );
	$pages = array();
	foreach ( anmoc_page_templates() as $key => $tpl ) {
		$pages[ $key ] = anmoc_seed_post(
			'page',
			$tpl[1],
			array(
				'post_name'  => $tpl[2],
				'meta_input' => array( '_wp_page_template' => $tpl[0] ),
			)
		);
	}
	if ( ! empty( $pages['privacy'] ) && '' === trim( (string) get_post_field( 'post_content', $pages['privacy'] ) ) ) {
		wp_update_post(
			array(
				'ID'           => $pages['privacy'],
				'post_content' => implode(
					"\n\n",
					array(
						'<!-- wp:heading --><h2>Thông tin chúng tôi thu thập</h2><!-- /wp:heading -->',
						'<!-- wp:paragraph --><p>Họ tên, số điện thoại, dịch vụ quan tâm, ngày mong muốn và ghi chú triệu chứng bạn tự nguyện cung cấp trong form đặt lịch.</p><!-- /wp:paragraph -->',
						'<!-- wp:heading --><h2>Mục đích sử dụng</h2><!-- /wp:heading -->',
						'<!-- wp:paragraph --><p>Liên hệ xác nhận lịch hẹn, sắp xếp bác sĩ phù hợp và chuẩn bị cho buổi thăm khám. Chúng tôi không bán hay chia sẻ thông tin của bạn cho bên thứ ba vì mục đích quảng cáo.</p><!-- /wp:paragraph -->',
						'<!-- wp:heading --><h2>Quyền của bạn</h2><!-- /wp:heading -->',
						'<!-- wp:paragraph --><p>Bạn có thể yêu cầu xem, sửa hoặc xóa thông tin bằng cách gọi <a href="tel:02873006868">028 7300 6868</a> hoặc gửi email tới <a href="mailto:hello@anmoc.vn">hello@anmoc.vn</a>.</p><!-- /wp:paragraph -->',
					)
				),
			)
		);
	}
	if ( ! empty( $pages['privacy'] ) ) {
		update_option( 'wp_page_for_privacy_policy', $pages['privacy'] );
	}
	// WordPress' own placeholder content has no place on a finished site.
	foreach ( array( 'sample-page', 'trang-mau' ) as $slug ) {
		$sample = get_page_by_path( $slug );
		if ( $sample && 'page' === $sample->post_type && $sample->ID !== $front ) {
			wp_delete_post( $sample->ID, true );
		}
	}
	$default_privacy = get_posts(
		array(
			'post_type'   => 'page',
			'post_status' => 'draft',
			'title'       => 'Privacy Policy',
			'numberposts' => 1,
		)
	);
	if ( $default_privacy ) {
		wp_delete_post( $default_privacy[0]->ID, true );
	}
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front );
	update_option( 'page_for_posts', $blog );

	/* Services */
	$services = array(
		array( 'Thăm khám & tư vấn', 'Bác sĩ khai thác căn nguyên, bắt mạch và xây dựng lộ trình chăm sóc riêng cho từng thể trạng.', 'THẤU HIỂU', '45 phút · Lần đầu', 'thăm khám' ),
		array( 'Châm cứu trị liệu', 'Tác động huyệt vị chính xác, hỗ trợ giảm đau, điều hòa khí huyết và cải thiện giấc ngủ.', 'KHAI THÔNG', '30–45 phút · Theo liệu trình', 'châm cứu' ),
		array( 'Cơ xương khớp', 'Kết hợp châm cứu, xoa bóp bấm huyệt và vận động trị liệu cho các vấn đề đau mỏi.', 'PHỤC HỒI', 'Theo phác đồ cá nhân', 'cơ xương khớp' ),
		array( 'Dược liệu cổ truyền', 'Bài thuốc nguồn gốc rõ ràng, gia giảm theo từng giai đoạn và được bác sĩ theo dõi sát.', 'NUÔI DƯỠNG', 'Sắc sẵn · Giao tận nơi', 'dược liệu' ),
		array( 'Cấy chỉ', 'Kích thích huyệt đạo kéo dài, phù hợp người bận rộn hoặc khó tới phòng khám thường xuyên.', 'DUY TRÌ', '2–3 tuần một lần', 'cấy chỉ' ),
		array( 'Phục hồi chức năng', 'Vật lý trị liệu và bài tập cá nhân hóa giúp phục hồi vận động bền vững, an toàn.', 'VẬN ĐỘNG', 'Đánh giá theo tuần', 'phục hồi chức năng' ),
	);
	foreach ( $services as $i => $s ) {
		anmoc_seed_post(
			'anmoc_service',
			$s[0],
			array(
				'menu_order' => $i + 1,
				'meta_input' => array(
					'_anmoc_desc'    => $s[1],
					'_anmoc_tagline' => $s[2],
					'_anmoc_meta'    => $s[3],
					'_anmoc_short'   => $s[4],
					'_anmoc_on_home' => '1',
				),
			)
		);
	}

	/* Doctors */
	$doctors = array(
		array( 'BS.CKII Nguyễn Minh An', 'Giám đốc chuyên môn', 'Châm cứu · Nội khoa', '22 năm kinh nghiệm', 'doctor-an.jpg' ),
		array( 'ThS.BS Trần Thanh Mai', 'Trưởng khoa trị liệu', 'Nội khoa · Phụ khoa', '16 năm kinh nghiệm', 'doctor-mai.jpg' ),
		array( 'BS Lê Hoàng Đức', 'Bác sĩ phục hồi', 'Cơ xương khớp', '12 năm kinh nghiệm', 'doctor-duc.jpg' ),
	);
	foreach ( $doctors as $i => $d ) {
		$id = anmoc_seed_post(
			'anmoc_doctor',
			$d[0],
			array(
				'menu_order' => $i + 1,
				'meta_input' => array(
					'_anmoc_role'  => $d[1],
					'_anmoc_focus' => $d[2],
					'_anmoc_exp'   => $d[3],
				),
			)
		);
		if ( $id && ! has_post_thumbnail( $id ) && isset( $img[ $d[4] ] ) ) {
			set_post_thumbnail( $id, $img[ $d[4] ] );
		}
	}

	/* Testimonials (shown on the home and community pages) */
	$quotes = array(
		array( 'Chị L., 48 tuổi', 'Tôi bị đau thắt lưng hơn hai năm. Sau sáu tuần điều trị, tôi đã ngủ ngon và trở lại sinh hoạt bình thường.', 'Cơ xương khớp' ),
		array( 'Anh M., 36 tuổi', 'Bác sĩ hỏi rất kỹ, giải thích rõ từng bước. Tôi cảm thấy mình được lắng nghe chứ không chỉ được kê đơn.', 'Thăm khám & tư vấn' ),
		array( 'Cô H., 61 tuổi', 'Mất ngủ nhiều năm, tôi ngại dùng thuốc. Châm cứu kết hợp thay đổi thói quen giúp tôi ngủ sâu hơn rõ rệt.', 'Châm cứu trị liệu' ),
	);
	foreach ( $quotes as $i => $q ) {
		anmoc_seed_post(
			'anmoc_testimonial',
			$q[0],
			array(
				'post_content' => $q[1],
				'menu_order'   => $i + 1,
				'meta_input'   => array(
					'_anmoc_service'   => $q[2],
					'_anmoc_placement' => 'both',
				),
			)
		);
	}

	/* FAQ */
	$faqs = array(
		array( 'Tôi cần chuẩn bị gì trước khi đến khám?', 'Bạn nên mang theo kết quả khám gần nhất, danh sách thuốc đang dùng và ghi chú về thời điểm xuất hiện triệu chứng. Hãy ăn nhẹ và mặc trang phục thoải mái.' ),
		array( 'Một liệu trình thường kéo dài bao lâu?', 'Thời gian phụ thuộc vào tình trạng và khả năng đáp ứng. Bác sĩ sẽ nêu rõ mốc đánh giá sau buổi khám đầu tiên, thường từ 4–8 buổi.' ),
		array( 'Châm cứu có đau không?', 'Kim châm rất mảnh. Phần lớn khách hàng chỉ cảm thấy châm chích nhẹ trong vài giây đầu, sau đó là cảm giác thư giãn tại huyệt.' ),
		array( 'Có thể kết hợp với điều trị Tây y không?', 'Có thể trong nhiều trường hợp, nhưng cần thông báo đầy đủ thuốc và phương pháp đang dùng để bác sĩ đánh giá tương tác và đưa chỉ định phù hợp.' ),
	);
	foreach ( $faqs as $i => $f ) {
		anmoc_seed_post(
			'anmoc_faq',
			$f[0],
			array(
				'post_content' => $f[1],
				'menu_order'   => $i + 1,
			)
		);
	}

	/* Journal */
	$cats = array();
	foreach ( array( 'Cơ xương khớp', 'Giấc ngủ', 'Dinh dưỡng', 'Dược liệu' ) as $name ) {
		$term          = term_exists( $name, 'category' );
		$term          = $term ? $term : wp_insert_term( $name, 'category' );
		$cats[ $name ] = is_array( $term ) ? (int) $term['term_id'] : 0;
	}
	$posts = array(
		array( 'Đừng đợi cơn đau lên tiếng mới bắt đầu chăm sóc cơ thể', 'Cơ thể luôn gửi tín hiệu sớm. Học cách nhận ra những thay đổi nhỏ giúp chúng ta can thiệp đúng lúc và tránh điều trị kéo dài.', 'Cơ xương khớp', 'massage.jpg', '2026-07-01 08:00:00', true, 10 ),
		array( 'Đau thắt lưng kéo dài: Khi nào bạn nên đi khám?', '5 dấu hiệu cho thấy cơn đau không còn là mỏi cơ thông thường và cần được đánh giá chuyên sâu.', 'Cơ xương khớp', 'article-cupping.jpg', '2026-09-18 08:00:00', false, 6 ),
		array( 'Mất ngủ kéo dài: Hiểu đúng để không phụ thuộc thuốc', 'Y học cổ truyền đánh giá nguyên nhân mất ngủ từ đâu, và vai trò của châm cứu trong cải thiện giấc ngủ.', 'Giấc ngủ', 'herbal-tea.jpg', '2026-09-02 08:00:00', false, 7 ),
		array( 'Dùng thảo dược thế nào để an toàn và có hiệu quả?', 'Dược liệu tự nhiên vẫn cần đúng người, đúng liều và sự theo dõi chuyên môn.', 'Dược liệu', 'apothecary.jpg', '2026-08-21 08:00:00', false, 5 ),
		array( 'Ăn theo mùa: Bữa cơm Việt cũng là một bài thuốc', 'Cân bằng hàn – nhiệt trong bữa ăn hằng ngày giúp cơ thể thích nghi với thời tiết nóng ẩm.', 'Dinh dưỡng', 'article-meal.jpg', '2026-08-09 08:00:00', false, 6 ),
		array( 'Đau vai gáy ở dân văn phòng: 4 thói quen cần đổi', 'Tư thế ngồi, nhịp nghỉ và vài động tác giãn cơ đơn giản giúp giảm đáng kể cơn đau mỏi.', 'Cơ xương khớp', 'article-neck.jpg', '2026-07-27 08:00:00', false, 5 ),
		array( 'Sắc thuốc tại nhà: Những lỗi thường gặp', 'Nồi sắc, lượng nước và thời gian đun ảnh hưởng trực tiếp tới hiệu quả của thang thuốc.', 'Dược liệu', 'article-mortar.jpg', '2026-07-12 08:00:00', false, 4 ),
	);
	foreach ( $posts as $p ) {
		$id = anmoc_seed_post(
			'post',
			$p[0],
			array(
				'post_excerpt'  => $p[1],
				'post_content'  => anmoc_seed_article( $p[1] ),
				'post_date'     => $p[4],
				'post_category' => array( $cats[ $p[2] ] ),
				'meta_input'    => array(
					'_anmoc_byline' => 'BS.CKII Nguyễn Minh An',
					'_anmoc_read'   => (string) $p[6],
				),
			)
		);
		if ( $id && ! has_post_thumbnail( $id ) && isset( $img[ $p[3] ] ) ) {
			set_post_thumbnail( $id, $img[ $p[3] ] );
		}
		if ( $id && $p[5] ) {
			stick_post( $id );
		}
	}

	/* WordPress' sample post would otherwise show up in the journal. */
	$hello = get_post( 1 );
	if ( $hello && 'post' === $hello->post_type && 'publish' === $hello->post_status && in_array( $hello->post_name, array( 'hello-world', 'chao-moi-nguoi' ), true ) ) {
		wp_trash_post( 1 );
	}

	/* Menus */
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$menus     = array(
		'primary' => array( 'Menu chính', array( $pages['about'], $pages['services'], $pages['doctors'], $blog, $pages['community'] ) ),
		'footer'  => array( 'Menu chân trang', array( $pages['about'], $pages['services'], $pages['doctors'], $blog, $pages['community'] ) ),
	);
	foreach ( $menus as $location => $menu ) {
		if ( ! empty( $locations[ $location ] ) && wp_get_nav_menu_object( $locations[ $location ] ) ) {
			continue;
		}
		$existing = wp_get_nav_menu_object( $menu[0] );
		$menu_id  = $existing ? $existing->term_id : wp_create_nav_menu( $menu[0] );
		if ( is_wp_error( $menu_id ) ) {
			continue;
		}
		if ( ! $existing ) {
			foreach ( array_filter( $menu[1] ) as $page_id ) {
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-object-id' => $page_id,
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					)
				);
			}
		}
		$locations[ $location ] = $menu_id;
	}
	set_theme_mod( 'nav_menu_locations', $locations );

	if ( ! get_option( 'permalink_structure' ) ) {
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
	}
	flush_rewrite_rules();

	update_option( 'anmoc_seeded', ANMOC_VERSION );
}

/**
 * Insert a post unless one with the same title and type exists.
 */
function anmoc_seed_post( $type, $title, $args = array() ) {
	$found = get_posts(
		array(
			'post_type'      => $type,
			'title'          => $title,
			'post_status'    => array( 'publish', 'draft', 'private', 'future' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $found ) {
		return (int) $found[0];
	}
	$id = wp_insert_post(
		array_merge(
			array(
				'post_type'   => $type,
				'post_title'  => $title,
				'post_status' => 'publish',
			),
			$args
		)
	);
	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Copy bundled images into the Media Library (once). Returns file => ID.
 */
function anmoc_seed_images() {
	$map = (array) get_option( 'anmoc_seed_images', array() );
	require_once ABSPATH . 'wp-admin/includes/image.php';

	foreach ( glob( ANMOC_DIR . '/assets/images/*.jpg' ) as $path ) {
		$file = basename( $path );
		if ( ! empty( $map[ $file ] ) && wp_attachment_is_image( $map[ $file ] ) ) {
			continue;
		}
		$upload = wp_upload_bits( 'anmoc-' . $file, null, file_get_contents( $path ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		if ( ! empty( $upload['error'] ) ) {
			continue;
		}
		$id = wp_insert_attachment(
			array(
				'post_title'     => 'An Mộc – ' . str_replace( array( '-', '.jpg' ), array( ' ', '' ), $file ),
				'post_mime_type' => 'image/jpeg',
				'post_status'    => 'inherit',
			),
			$upload['file']
		);
		if ( $id && ! is_wp_error( $id ) ) {
			wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
			$map[ $file ] = $id;
			/* Save as we go so a hosting timeout never imports an image twice. */
			update_option( 'anmoc_seed_images', $map, false );
		}
	}
	update_option( 'anmoc_seed_images', $map, false );
	return $map;
}

function anmoc_seed_article( $lead ) {
	return implode(
		"\n\n",
		array(
			'<!-- wp:paragraph {"className":"lead"} --><p class="lead">' . esc_html( $lead ) . '</p><!-- /wp:paragraph -->',
			'<!-- wp:heading --><h2>Lắng nghe tín hiệu sớm của cơ thể</h2><!-- /wp:heading -->',
			'<!-- wp:paragraph --><p>Theo y học cổ truyền, mọi biểu hiện khó chịu đều là kết quả của sự mất cân bằng kéo dài giữa khí huyết, âm dương và tạng phủ. Khi nhận ra sớm, việc điều chỉnh thường nhẹ nhàng hơn và cơ thể phục hồi nhanh hơn.</p><!-- /wp:paragraph -->',
			'<!-- wp:list --><ul><li>Theo dõi giấc ngủ, ăn uống và mức năng lượng trong ngày.</li><li>Ghi lại thời điểm triệu chứng xuất hiện và yếu tố làm nặng hơn.</li><li>Không tự ý dùng thuốc hay thảo dược kéo dài khi chưa được thăm khám.</li></ul><!-- /wp:list -->',
			'<!-- wp:heading --><h2>Khi nào nên gặp bác sĩ?</h2><!-- /wp:heading -->',
			'<!-- wp:paragraph --><p>Nếu triệu chứng kéo dài hơn hai tuần, ảnh hưởng đến sinh hoạt hoặc tái đi tái lại, hãy đặt lịch để bác sĩ đánh giá nguyên nhân và xây dựng lộ trình chăm sóc phù hợp với thể trạng của bạn.</p><!-- /wp:paragraph -->',
		)
	);
}
