<?php
/**
 * Single source of truth for every editable value in the theme.
 *
 * Customizer controls, defaults and front-end output are all generated from
 * these arrays, so adding a field here is enough to make it editable.
 *
 * Field types:
 *  - text      single line
 *  - repeater  list of rows; 4th element maps sub-field => [label, text|textarea]
 *  - textarea  multi-line; line breaks become <br>, <em>/<strong> allowed
 *  - image     Media Library attachment, default is a file in assets/images
 *  - url|email|number
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

/**
 * Colour tokens, output as CSS custom properties on :root.
 */
function anmoc_colors() {
	return array(
		'ink'           => array( 'Màu chữ chính', '#3d563d', 'Chữ, tiêu đề, viền và nền nút chính.' ),
		'forest'        => array( 'Nền xanh đậm', '#3d563d', 'Thanh trên cùng, đầu trang con, thẻ giờ mở cửa, khối Cảm nhận, Nguyên tắc điều trị, Hội đồng chuyên môn.' ),
		'forest-2'      => array( 'Nút khi rê chuột', '#3d563d', 'Nền nút chính khi rê chuột, chữ nghiêng ở trang Đặt lịch.' ),
		'footer'        => array( 'Nền footer', '#3d563d', 'Chân trang.' ),
		'sage'          => array( 'Xanh lá xô thơm', '#809864', 'Viền ô nhập khi chọn, gạch dưới link trong thẻ giờ, nền thẻ dịch vụ.' ),
		'moss'          => array( 'Xanh rêu nhạt', '#9fa590', 'Pha nền thẻ dịch vụ.' ),
		'cream'         => array( 'Nền kem', '#ede0c7', 'Khối Triết lý, Quy trình, Con số, khối Đặt lịch cuối trang, nút sáng.' ),
		'paper'         => array( 'Nền trang', '#f6f3e9', 'Nền chính của website.' ),
		'white'         => array( 'Nền bề mặt (form, nhãn ảnh)', '#f6f3e9', 'Form đặt lịch, nhãn trên ảnh bài viết, chữ trên nút đậm.' ),
		'line'          => array( 'Đường kẻ', '#d1d2c4', 'Đường phân cách, viền thẻ và ô nhập.' ),
		'accent'        => array( 'Màu nhấn (chữ lớn)', '#657e54', 'Dòng tiêu đề in nghiêng, dấu ngoặc kép, biểu tượng liên hệ, gạch dưới link.' ),
		'accent-text'   => array( 'Màu nhấn (chữ nhỏ)', '#4a6345', 'Số thứ tự, gạch eyebrow, chữ "Từ gốc.", dấu + của FAQ.' ),
		'sun'           => array( 'Màu con dấu', '#cec8b1', 'Vòng tròn "Gìn giữ tinh hoa" ở banner đầu, dấu ngoặc kép trên nền đậm.' ),
		'muted'         => array( 'Chữ phụ', '#495f47', 'Mô tả, đoạn văn phụ.' ),
		'meta'          => array( 'Chữ nhãn phụ', '#495f47', 'Ngày đăng, chức vụ bác sĩ, thời lượng dịch vụ.' ),
		'on-dark'       => array( 'Chữ trên nền đậm', '#f6f3e9', 'Đoạn văn trong đầu trang con và các khối nền đậm.' ),
		'on-dark-muted' => array( 'Chữ phụ trên nền đậm', '#ede0c7', 'Thanh trên cùng, footer.' ),
		'dark-line'     => array( 'Đường kẻ trên nền đậm', '#9eaf85', 'Đường phân cách trên nền đậm, chữ chìm "AM".' ),
		'focus'         => array( 'Viền khi dùng bàn phím (focus)', '#809864', 'Vòng viền khi bấm Tab qua các link, nút.' ),
	);
}

/**
 * Font choices (Google Fonts with Vietnamese subsets).
 */
function anmoc_fonts() {
	return array(
		'sans'  => array(
			'Be Vietnam Pro' => 'Be+Vietnam+Pro:wght@300;400;500;600',
			'Inter'          => 'Inter:wght@300;400;500;600',
			'Montserrat'     => 'Montserrat:wght@300;400;500;600',
			'Nunito Sans'    => 'Nunito+Sans:wght@300;400;500;600',
			'Roboto'         => 'Roboto:wght@300;400;500;700',
		),
		'serif' => array(
			'Lora'               => 'Lora:ital,wght@1,400;1,500',
			'Playfair Display'   => 'Playfair+Display:ital,wght@1,400;1,500',
			'Cormorant Garamond' => 'Cormorant+Garamond:ital,wght@1,400;1,500',
			'Noto Serif'         => 'Noto+Serif:ital,wght@1,400;1,500',
		),
	);
}

/**
 * Fonts one heading can use instead of the global scheme. All have Vietnamese.
 * name => [ Google Fonts family spec, fallback, kind shown in the list ].
 */
function anmoc_custom_fonts() {
	return array(
		'Be Vietnam Pro'     => array( 'Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;1,300;1,400', 'sans-serif', 'không chân' ),
		'Inter'              => array( 'Inter:ital,wght@0,300;0,400;0,500;1,300;1,400', 'sans-serif', 'không chân' ),
		'Montserrat'         => array( 'Montserrat:ital,wght@0,300;0,400;0,500;1,300;1,400', 'sans-serif', 'không chân' ),
		'Nunito Sans'        => array( 'Nunito+Sans:ital,wght@0,300;0,400;0,500;1,300;1,400', 'sans-serif', 'không chân' ),
		'Roboto'             => array( 'Roboto:ital,wght@0,300;0,400;0,500;1,300;1,400', 'sans-serif', 'không chân' ),
		'Lexend'             => array( 'Lexend:wght@300;400;500', 'sans-serif', 'không chân' ),
		'Quicksand'          => array( 'Quicksand:wght@300;400;500', 'sans-serif', 'không chân, bo tròn' ),
		'Lora'               => array( 'Lora:ital,wght@0,400;0,500;1,400;1,500', 'serif', 'có chân' ),
		'Playfair Display'   => array( 'Playfair+Display:ital,wght@0,400;0,500;1,400;1,500', 'serif', 'có chân' ),
		'Cormorant Garamond' => array( 'Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400', 'serif', 'có chân' ),
		'Noto Serif'         => array( 'Noto+Serif:ital,wght@0,300;0,400;0,500;1,300;1,400', 'serif', 'có chân' ),
		'Noto Serif Display' => array( 'Noto+Serif+Display:ital,wght@0,200;0,300;0,400;1,200;1,300;1,400', 'serif', 'có chân' ),
		'Merriweather'       => array( 'Merriweather:ital,wght@0,300;0,400;1,300;1,400', 'serif', 'có chân' ),
		'Literata'           => array( 'Literata:ital,wght@0,300;0,400;0,500;1,300;1,400', 'serif', 'có chân' ),
		'Fraunces'           => array( 'Fraunces:ital,wght@0,300;0,400;0,500;1,300;1,400', 'serif', 'có chân' ),
		'Prata'              => array( 'Prata', 'serif', 'có chân' ),
		'Dancing Script'     => array( 'Dancing+Script:wght@400;500', 'cursive', 'viết tay' ),
	);
}

/**
 * Font fields (type "font") => the element they restyle. Empty value = global font.
 */
function anmoc_font_targets() {
	return array(
		'hero_title_font'    => '.hero-copy h1',
		'hero_title_em_font' => '.hero-copy h1 em',
	);
}

/**
 * Font schemes from the approved reference (A = current site fonts).
 * Rules per scheme live in main.css under html[data-font].
 */
function anmoc_font_schemes() {
	return array(
		'A' => array( 'Hiện tại', 'Be Vietnam Pro + Lora' ),
		'B' => array( 'Cổ điển', 'Cormorant Garamond + Be Vietnam Pro' ),
		'C' => array( 'Sang trọng', 'Noto Serif Display + Be Vietnam Pro' ),
		'D' => array( 'Tối giản', 'Be Vietnam Pro mảnh + Cormorant' ),
	);
}

/**
 * Content sections grouped into Customizer panels.
 *
 * 'preview' is the page key (see anmoc_page_templates()) opened in the
 * Customizer preview when the section is expanded.
 */
function anmoc_sections() {
	$s = array();

	/* ---------- Thông tin chung ---------- */
	$s['general'] = array(
		'panel'   => 'global',
		'title'   => 'Thương hiệu & liên hệ',
		'preview' => 'home',
		'fields'  => array(
			'brand_name'    => array( 'Tên thương hiệu', 'text', 'An Mộc' ),
			'brand_tagline' => array( 'Dòng phụ dưới tên', 'text', 'Y viện cổ truyền' ),
			'topbar_text'   => array( 'Thanh trên cùng – chữ bên trái', 'text', 'Y học bản địa · Chăm sóc có căn cứ' ),
			'city'          => array( 'Thành phố (thanh trên cùng)', 'text', 'TP. Hồ Chí Minh' ),
			'phone'         => array( 'Số điện thoại / Hotline', 'text', '028 7300 6868' ),
			'email'         => array( 'Email', 'email', 'hello@anmoc.vn' ),
			'address'       => array( 'Địa chỉ', 'textarea', "128 Nguyễn Đình Chiểu,\nQuận 3, TP. Hồ Chí Minh" ),
			'hours_weekday' => array( 'Giờ làm việc – ngày thường', 'text', 'Thứ 2 – Thứ 6: 7:30 – 19:30' ),
			'hours_weekend' => array( 'Giờ làm việc – cuối tuần', 'text', 'Cuối tuần: 8:00 – 17:00' ),
			'close_weekday' => array( 'Giờ đóng cửa ngày thường (thẻ "Hôm nay")', 'text', '19:30' ),
			'close_weekend' => array( 'Giờ đóng cửa cuối tuần (thẻ "Hôm nay")', 'text', '17:00' ),
			'header_cta'    => array( 'Nút trên menu', 'text', 'Đặt lịch khám' ),
			'intro_watermark' => array( 'Chữ chìm ở đầu các trang con', 'text', 'AM' ),
		),
	);

	$s['footer'] = array(
		'panel'   => 'global',
		'title'   => 'Chân trang (Footer)',
		'preview' => 'home',
		'fields'  => array(
			'footer_desc'      => array( 'Mô tả dưới logo', 'textarea', 'Thăm khám tận tâm, trị liệu có cơ sở và đồng hành cùng bạn trên hành trình sống khỏe tự nhiên.' ),
			'footer_menu_title' => array( 'Tiêu đề cột menu', 'text', 'Khám phá' ),
			'footer_contact_title' => array( 'Tiêu đề cột liên hệ', 'text', 'Liên hệ' ),
			'footer_cta_text'  => array( 'Câu kêu gọi', 'text', 'Cần tư vấn tình trạng của bạn?' ),
			'footer_cta_label' => array( 'Nút kêu gọi', 'text', 'Đặt lịch cùng bác sĩ' ),
			'copyright'        => array( 'Bản quyền ({year} = năm hiện tại)', 'text', '© {year} An Mộc Y Viện' ),
			'license'          => array( 'Giấy phép', 'text', 'Giấy phép hoạt động số 082/HCM-GPHĐ' ),
			'privacy_label'    => array( 'Chữ link chính sách bảo mật', 'text', 'Chính sách bảo mật' ),
		),
	);

	$s['banner'] = array(
		'panel'   => 'global',
		'title'   => 'Khối "Đặt lịch" cuối trang',
		'preview' => 'home',
		'fields'  => array(
			'banner_eyebrow' => array( 'Dòng nhỏ', 'text', 'Bắt đầu từ một cuộc hẹn' ),
			'banner_title'   => array( 'Tiêu đề', 'textarea', "Lắng nghe cơ thể bạn,\nngay từ hôm nay." ),
			'banner_desc'    => array( 'Mô tả', 'textarea', 'Đặt lịch trước để được sắp xếp bác sĩ phù hợp và không phải chờ đợi.' ),
			'banner_button'  => array( 'Nút', 'text', 'Đặt lịch thăm khám' ),
		),
	);

	/* ---------- Trang chủ ---------- */
	$s['home_hero'] = array(
		'panel'   => 'home',
		'title'   => 'Banner đầu trang',
		'preview' => 'home',
		'fields'  => array(
			'hero_eyebrow'    => array( 'Dòng nhỏ', 'text', 'Một cách khác để trở về cân bằng' ),
			'hero_title'      => array( 'Tiêu đề', 'text', 'Thuận tự nhiên,' ),
			'hero_title_em'   => array( 'Tiêu đề – dòng in nghiêng', 'text', 'an lành từ gốc.' ),
			'hero_title_font'    => array( 'Font riêng – tiêu đề', 'font', '' ),
			'hero_title_em_font' => array( 'Font riêng – dòng in nghiêng', 'font', '' ),
			'hero_desc'       => array( 'Mô tả', 'textarea', 'Không chạy theo triệu chứng. An Mộc đọc những tín hiệu nhỏ nhất của cơ thể để kiến tạo một lộ trình phục hồi vừa vặn với riêng bạn.' ),
			'hero_btn'        => array( 'Nút chính', 'text', 'Bắt đầu hành trình' ),
			'hero_link'       => array( 'Nút phụ', 'text', 'Câu chuyện An Mộc' ),
			'hero_stats'      => array(
				'Các chỉ số',
				'repeater',
				array(
					array( 'value' => '20+', 'label' => 'Năm kinh nghiệm' ),
					array( 'value' => '12.500', 'label' => 'Khách hàng tin chọn' ),
					array( 'value' => '4.9/5', 'label' => 'Mức độ hài lòng' ),
				),
				array(
					'value' => array( 'Số', 'text' ),
					'label' => array( 'Nhãn', 'text' ),
				),
			),
			'hero_trust_source' => array( 'Ghi chú nguồn số liệu', 'textarea', 'Theo dữ liệu khách hàng của An Mộc từ 2006 đến 09/2026; mức hài lòng từ khảo sát sau liệu trình.' ),
			'hero_image'      => array( 'Ảnh banner', 'image', 'hero.jpg' ),
			'hero_image_alt'  => array( 'Mô tả ảnh (alt)', 'text', 'Khu chợ rau và dược liệu tươi' ),
			'hero_stamp'      => array( 'Chữ trong con dấu tròn', 'textarea', "Gìn giữ tinh hoa\ncỏ cây bản địa" ),
			'hero_hours_label' => array( 'Thẻ giờ – tiêu đề', 'text', 'HÔM NAY' ),
			'hero_hours_text' => array( 'Thẻ giờ – nội dung', 'text', 'Đón khách đến' ),
			'hero_hours_link' => array( 'Thẻ giờ – link', 'text', 'Chọn khung giờ' ),
		),
	);

	$s['home_philosophy'] = array(
		'panel'   => 'home',
		'title'   => 'Triết lý',
		'preview' => 'home',
		'fields'  => array(
			'philo_eyebrow' => array( 'Dòng nhỏ', 'text', 'Hệ quy chiếu An Mộc' ),
			'philo_index'   => array( 'Chữ nghiêng lớn', 'text', 'Từ gốc.' ),
			'philo_title'   => array( 'Tiêu đề', 'textarea', 'Cơ thể không phải một cỗ máy cần sửa. Đó là một hệ sinh thái cần được hiểu.' ),
			'philo_desc'    => array( 'Mô tả', 'textarea', 'Chúng tôi nhìn giấc ngủ, vận động, cảm xúc và thể trạng như những mạch nối trong cùng một hệ cân bằng.' ),
			'values'        => array(
				'Các giá trị',
				'repeater',
				array(
					array( 'title' => 'Đọc cơ thể', 'desc' => 'Lắng nghe cả điều bạn kể và điều cơ thể đang âm thầm biểu hiện.' ),
					array( 'title' => 'Khơi khả năng tự phục hồi', 'desc' => 'Can thiệp vừa đủ để cơ thể tìm lại nhịp vận hành vốn có.' ),
					array( 'title' => 'Dưỡng thành thói quen', 'desc' => 'Biến kết quả trị liệu thành một nền sống khỏe lâu dài.' ),
				),
				array(
					'title' => array( 'Tiêu đề', 'text' ),
					'desc'  => array( 'Mô tả', 'textarea' ),
				),
			),
		),
	);

	$s['home_services'] = array(
		'panel'       => 'home',
		'title'       => 'Bản đồ trị liệu',
		'description' => 'Các thẻ dịch vụ lấy từ menu Trị liệu (đánh dấu "Hiện ở trang chủ").',
		'preview'     => 'home',
		'fields'      => array(
			'hs_eyebrow' => array( 'Dòng nhỏ', 'text', 'Bản đồ trị liệu' ),
			'hs_title'   => array( 'Tiêu đề', 'textarea', "Không chọn phương pháp.\nChọn đích đến sức khỏe." ),
			'hs_desc'    => array( 'Mô tả', 'textarea', 'Mỗi người bước vào An Mộc với một câu chuyện khác nhau. Vì vậy, hành trình điều trị luôn bắt đầu từ mục tiêu bạn muốn lấy lại.' ),
			'hs_action'  => array( 'Câu hỏi cuối khối', 'text', 'Chưa biết phương pháp nào phù hợp?' ),
			'hs_button'  => array( 'Nút cuối khối', 'text', 'Nói chuyện với bác sĩ' ),
		),
	);

	$s['home_method'] = array(
		'panel'   => 'home',
		'title'   => 'Quy trình thăm khám',
		'preview' => 'home',
		'fields'  => array(
			'method_image'   => array( 'Ảnh', 'image', 'acupuncture.jpg' ),
			'method_image_alt' => array( 'Mô tả ảnh (alt)', 'text', 'Bác sĩ châm cứu trên vùng lưng của người bệnh' ),
			'method_note'    => array( 'Ghi chú trên ảnh', 'textarea', 'Một cuộc trò chuyện kỹ là bước đầu của trị liệu đúng.' ),
			'method_eyebrow' => array( 'Dòng nhỏ', 'text', 'Quy trình thăm khám' ),
			'method_title'   => array( 'Tiêu đề', 'textarea', 'Rõ ràng từ cuộc hẹn đầu tiên.' ),
			'method_desc'    => array( 'Mô tả', 'textarea', 'Bạn luôn biết mình đang ở đâu trong hành trình điều trị và bước tiếp theo là gì.' ),
			'steps'          => array(
				'Các bước',
				'repeater',
				array(
					array( 'title' => 'Đặt lịch & chia sẻ tình trạng' ),
					array( 'title' => 'Thăm khám chuyên sâu' ),
					array( 'title' => 'Thiết kế phác đồ cá nhân' ),
					array( 'title' => 'Theo dõi & tái đánh giá' ),
				),
				array( 'title' => array( 'Tên bước', 'text' ) ),
			),
		),
	);

	$s['home_journal'] = array(
		'panel'       => 'home',
		'title'       => 'Góc kiến thức',
		'description' => 'Hiển thị 3 bài viết mới nhất trong Bài viết.',
		'preview'     => 'home',
		'fields'      => array(
			'hj_eyebrow' => array( 'Dòng nhỏ', 'text', 'Góc hiểu cơ thể' ),
			'hj_title'   => array( 'Tiêu đề', 'textarea', "Kiến thức để bạn\nchủ động khỏe hơn." ),
			'hj_button'  => array( 'Nút', 'text', 'Xem thư viện kiến thức' ),
		),
	);

	$s['home_testimonials'] = array(
		'panel'       => 'home',
		'title'       => 'Cảm nhận khách hàng',
		'description' => 'Nội dung lấy từ menu Cảm nhận (vị trí "Trang chủ").',
		'preview'     => 'home',
		'fields'      => array(
			'ht_eyebrow' => array( 'Dòng nhỏ', 'text', 'Lời kể từ khách hàng' ),
			'ht_title'   => array( 'Tiêu đề', 'textarea', "Những thay đổi thật,\ntừ những người thật." ),
			'ht_desc'    => array( 'Mô tả', 'textarea', 'Chia sẻ được đăng với sự đồng ý của khách hàng; tên đã được viết tắt. Kết quả ở mỗi người có thể khác nhau.' ),
		),
	);

	/* ---------- Về An Mộc ---------- */
	$s['about'] = array(
		'panel'   => 'pages',
		'title'   => 'Trang Về An Mộc',
		'preview' => 'about',
		'fields'  => array(
			'about_intro_eyebrow' => array( 'Đầu trang – dòng nhỏ', 'text', 'Về An Mộc' ),
			'about_intro_title'   => array( 'Đầu trang – tiêu đề', 'textarea', 'Một y viện tử tế bắt đầu từ sự thấu hiểu.' ),
			'about_intro_desc'    => array( 'Đầu trang – mô tả', 'textarea', 'Chúng tôi gìn giữ giá trị cốt lõi của y học phương Đông, đồng thời chuẩn hóa trải nghiệm chăm sóc theo tiêu chuẩn hiện đại.' ),
			'about_image'         => array( 'Ảnh', 'image', 'herbs.jpg' ),
			'about_image_alt'     => array( 'Mô tả ảnh (alt)', 'text', 'Người gìn giữ dược liệu bản địa' ),
			'about_quote'         => array( 'Trích dẫn', 'textarea', 'Khỏe mạnh không chỉ là hết đau, mà là khi cơ thể tìm lại được nhịp cân bằng tự nhiên.' ),
			'about_quote_author'  => array( 'Tác giả trích dẫn', 'text', '— BS.CKII Nguyễn Minh An, Nhà sáng lập An Mộc' ),
			'numbers_eyebrow'     => array( 'Con số – dòng nhỏ', 'text', 'Những con số biết nói' ),
			'numbers'             => array(
				'Các con số',
				'repeater',
				array(
					array( 'value' => '12.500+', 'label' => 'Khách hàng đã được chăm sóc' ),
					array( 'value' => '48.000+', 'label' => 'Lượt trị liệu từ năm 2006' ),
					array( 'value' => '92%', 'label' => 'Hài lòng sau liệu trình' ),
					array( 'value' => '68%', 'label' => 'Khách mới từ giới thiệu' ),
				),
				array(
					'value' => array( 'Con số', 'text' ),
					'label' => array( 'Nhãn', 'text' ),
				),
			),
			'numbers_source'      => array( 'Ghi chú nguồn số liệu', 'textarea', 'Số liệu nội bộ An Mộc, cập nhật 09/2026. Tỉ lệ hài lòng từ khảo sát sau liệu trình.' ),
			'standards_eyebrow'   => array( 'Cam kết – dòng nhỏ', 'text', 'Cam kết chuyên môn' ),
			'standards_title'     => array( 'Cam kết – tiêu đề', 'textarea', "An toàn không phải lựa chọn.\nĐó là tiêu chuẩn." ),
			'standards'           => array(
				'Danh sách cam kết',
				'repeater',
				array(
					array( 'text' => 'Bác sĩ có chứng chỉ hành nghề' ),
					array( 'text' => 'Dược liệu kiểm nghiệm nguồn gốc' ),
					array( 'text' => 'Kim châm vô khuẩn dùng một lần' ),
					array( 'text' => 'Hồ sơ điều trị minh bạch' ),
				),
				array( 'text' => array( 'Cam kết', 'text' ) ),
			),
		),
	);

	/* ---------- Trị liệu ---------- */
	$s['services'] = array(
		'panel'       => 'pages',
		'title'       => 'Trang Trị liệu',
		'description' => 'Danh sách dịch vụ và câu hỏi thường gặp chỉnh trong menu Trị liệu / Câu hỏi thường gặp ở trang quản trị.',
		'preview'     => 'services',
		'fields'      => array(
			'services_intro_eyebrow' => array( 'Đầu trang – dòng nhỏ', 'text', 'Chuyên khoa & trị liệu' ),
			'services_intro_title'   => array( 'Đầu trang – tiêu đề', 'textarea', 'Phục hồi đúng cách. Sống khỏe dài lâu.' ),
			'services_intro_desc'    => array( 'Đầu trang – mô tả', 'textarea', 'Không áp dụng một công thức cho tất cả. Mỗi phương pháp đều được chỉ định dựa trên chẩn đoán, thể trạng và mục tiêu cụ thể.' ),
			'services_cta_prefix'    => array( 'Chữ link trên thẻ (trước tên dịch vụ)', 'text', 'Tư vấn' ),
			'treat_image'            => array( 'Nguyên tắc – ảnh', 'image', 'herb-sorting.jpg' ),
			'treat_image_alt'        => array( 'Nguyên tắc – mô tả ảnh (alt)', 'text', 'Phân loại dược liệu tươi trên bàn gỗ' ),
			'treat_eyebrow'          => array( 'Nguyên tắc – dòng nhỏ', 'text', 'Nguyên tắc điều trị' ),
			'treat_title'            => array( 'Nguyên tắc – tiêu đề', 'textarea', "Đủ căn cứ để tin.\nĐủ tận tâm để theo." ),
			'treat_desc'             => array( 'Nguyên tắc – mô tả', 'textarea', 'Mọi phác đồ đều có mục tiêu, thời gian đánh giá và tiêu chí tiến triển rõ ràng. Bác sĩ giải thích trước khi thực hiện và chỉ thay đổi khi có căn cứ chuyên môn.' ),
			'treat_button'           => array( 'Nguyên tắc – nút', 'text', 'Trao đổi với bác sĩ' ),
			'faq_eyebrow'            => array( 'FAQ – dòng nhỏ', 'text', 'Câu hỏi thường gặp' ),
			'faq_title'              => array( 'FAQ – tiêu đề', 'textarea', "Điều bạn cần biết\ntrước khi bắt đầu." ),
		),
	);

	/* ---------- Đội ngũ ---------- */
	$s['doctors'] = array(
		'panel'       => 'pages',
		'title'       => 'Trang Đội ngũ',
		'description' => 'Danh sách bác sĩ chỉnh trong menu Bác sĩ ở trang quản trị.',
		'preview'     => 'doctors',
		'fields'      => array(
			'doctors_intro_eyebrow' => array( 'Đầu trang – dòng nhỏ', 'text', 'Đội ngũ chuyên môn' ),
			'doctors_intro_title'   => array( 'Đầu trang – tiêu đề', 'textarea', 'Người thầy thuốc giỏi cũng là người biết lắng nghe.' ),
			'doctors_intro_desc'    => array( 'Đầu trang – mô tả', 'textarea', 'Đội ngũ An Mộc được đào tạo chính quy, có nhiều năm thực hành lâm sàng và cùng theo đuổi một chuẩn mực chăm sóc tận tâm.' ),
			'doctors_cta'           => array( 'Chữ link trên thẻ bác sĩ', 'text', 'Đặt lịch với bác sĩ' ),
			'council_eyebrow'       => array( 'Hội đồng – dòng nhỏ', 'text', 'Hội đồng chuyên môn' ),
			'council_title'         => array( 'Hội đồng – tiêu đề', 'textarea', 'Mỗi ca bệnh là một trách nhiệm chung.' ),
			'council_desc'          => array( 'Hội đồng – mô tả', 'textarea', 'Những trường hợp phức tạp được hội chẩn đa chuyên khoa. Kế hoạch điều trị được rà soát định kỳ để bảo đảm hiệu quả và an toàn.' ),
		),
	);

	/* ---------- Kiến thức ---------- */
	$s['journal'] = array(
		'panel'       => 'pages',
		'title'       => 'Trang Kiến thức',
		'description' => 'Bài viết nổi bật là bài mới nhất được tick "Ghim" (trong khung Trạng thái khi soạn bài). Các nút lọc là Danh mục của bài viết.',
		'preview'     => 'journal',
		'fields'      => array(
			'journal_intro_eyebrow' => array( 'Đầu trang – dòng nhỏ', 'text', 'Thư viện kiến thức' ),
			'journal_intro_title'   => array( 'Đầu trang – tiêu đề', 'textarea', 'Hiểu cơ thể để sống chủ động hơn.' ),
			'journal_intro_desc'    => array( 'Đầu trang – mô tả', 'textarea', 'Nội dung do đội ngũ bác sĩ An Mộc biên soạn và kiểm duyệt, giúp bạn có thông tin đáng tin cậy trước mỗi quyết định chăm sóc sức khỏe.' ),
			'journal_featured_label' => array( 'Nhãn bài nổi bật', 'text', 'Bài viết nổi bật' ),
			'journal_all_label'     => array( 'Nút lọc "Tất cả"', 'text', 'Tất cả' ),
			'journal_read_more'     => array( 'Chữ link "Đọc bài viết"', 'text', 'Đọc bài viết' ),
			'journal_read_time'     => array( 'Đơn vị thời gian đọc', 'text', 'phút đọc' ),
			'journal_empty'         => array( 'Khi chưa có bài viết', 'text', 'Chưa có bài viết trong mục này.' ),
		),
	);

	/* ---------- Hoạt động ---------- */
	$s['community'] = array(
		'panel'       => 'pages',
		'title'       => 'Trang Hoạt động',
		'description' => 'Cảm nhận khách hàng lấy từ menu Cảm nhận (vị trí "Trang Hoạt động").',
		'preview'     => 'community',
		'fields'      => array(
			'community_intro_eyebrow' => array( 'Đầu trang – dòng nhỏ', 'text', 'An Mộc & cộng đồng' ),
			'community_intro_title'   => array( 'Đầu trang – tiêu đề', 'textarea', 'Sức khỏe tốt hơn khi được sẻ chia.' ),
			'community_intro_desc'    => array( 'Đầu trang – mô tả', 'textarea', 'Từ khám bệnh thiện nguyện đến lớp học chăm sóc sức khỏe, chúng tôi mang kiến thức y học đúng đến gần cộng đồng hơn.' ),
			'cf_image'    => array( 'Chương trình – ảnh', 'image', 'community.jpg' ),
			'cf_image_alt' => array( 'Chương trình – mô tả ảnh (alt)', 'text', 'Bác sĩ thăm khám cho người cao tuổi trong chương trình khám thiện nguyện' ),
			'cf_date'     => array( 'Chương trình – ngày', 'text', '14.09.2026' ),
			'cf_eyebrow'  => array( 'Chương trình – dòng nhỏ', 'text', 'Chương trình mới nhất' ),
			'cf_title'    => array( 'Chương trình – tiêu đề', 'textarea', 'Khám và cấp thuốc miễn phí cho 320 người cao tuổi tại Củ Chi' ),
			'cf_desc'     => array( 'Chương trình – mô tả', 'textarea', 'Đội ngũ 6 bác sĩ và 10 kỹ thuật viên đã thăm khám, tư vấn chăm sóc xương khớp và trao tặng thuốc thảo dược cho người dân có hoàn cảnh khó khăn.' ),
			'cf_link'     => array( 'Chương trình – chữ link', 'text', 'Xem câu chuyện' ),
			'cf_url'      => array( 'Chương trình – đường dẫn (để trống = trang Kiến thức)', 'url', '' ),
			'ct_eyebrow'  => array( 'Cảm nhận – dòng nhỏ', 'text', 'Lời kể từ khách hàng' ),
			'ct_title'    => array( 'Cảm nhận – tiêu đề', 'textarea', "Những thay đổi thật,\ntừ những người thật." ),
			'ct_desc'     => array( 'Cảm nhận – mô tả', 'textarea', 'Chia sẻ được đăng với sự đồng ý của khách hàng; tên đã được viết tắt. Kết quả ở mỗi người có thể khác nhau.' ),
		),
	);

	/* ---------- Đặt lịch ---------- */
	$s['contact'] = array(
		'panel'   => 'pages',
		'title'   => 'Trang Đặt lịch & form',
		'preview' => 'contact',
		'fields'  => array(
			'contact_eyebrow'   => array( 'Dòng nhỏ', 'text', 'Đặt lịch & liên hệ' ),
			'contact_title'     => array( 'Tiêu đề', 'text', 'Chủ động đặt lịch,' ),
			'contact_title_em'  => array( 'Tiêu đề – dòng in nghiêng', 'text', 'an tâm thăm khám.' ),
			'contact_desc'      => array( 'Mô tả', 'textarea', 'Điền form đặt lịch, đội ngũ An Mộc sẽ gọi lại xác nhận trong vòng 30 phút làm việc.' ),
			'label_hotline'     => array( 'Nhãn Hotline', 'text', 'Hotline' ),
			'label_address'     => array( 'Nhãn Địa chỉ', 'text', 'Địa chỉ' ),
			'label_hours'       => array( 'Nhãn Giờ làm việc', 'text', 'Giờ làm việc' ),
			'contact_call'      => array( 'Nút gọi điện', 'text', 'Gọi ngay cho lễ tân' ),
			'form_title'        => array( 'Form – tiêu đề', 'text', 'Thông tin đặt lịch' ),
			'form_required'     => array( 'Form – ghi chú bắt buộc (sau dấu *)', 'text', 'là trường bắt buộc' ),
			'form_name'         => array( 'Form – nhãn Họ tên', 'text', 'Họ và tên' ),
			'form_name_ph'      => array( 'Form – gợi ý Họ tên', 'text', 'Nguyễn Văn A' ),
			'form_phone'        => array( 'Form – nhãn Số điện thoại', 'text', 'Số điện thoại' ),
			'form_phone_ph'     => array( 'Form – gợi ý Số điện thoại', 'text', '09xx xxx xxx' ),
			'form_service'      => array( 'Form – nhãn Dịch vụ', 'text', 'Dịch vụ quan tâm' ),
			'form_service_ph'   => array( 'Form – lựa chọn mặc định của Dịch vụ', 'text', 'Cần bác sĩ tư vấn' ),
			'form_date'         => array( 'Form – nhãn Ngày', 'text', 'Ngày mong muốn' ),
			'form_note'         => array( 'Form – nhãn Ghi chú', 'text', 'Triệu chứng hoặc ghi chú' ),
			'form_note_ph'      => array( 'Form – gợi ý Ghi chú', 'text', 'Ví dụ: đau vai gáy khoảng 2 tuần...' ),
			'form_doctor'       => array( 'Form – nhãn bác sĩ đã chọn', 'text', 'Bác sĩ mong muốn' ),
			'form_privacy'      => array( 'Form – cam kết bảo mật ({privacy} = link Chính sách bảo mật)', 'textarea', 'Bằng việc gửi yêu cầu, bạn đồng ý để An Mộc liên hệ và xử lý thông tin theo {privacy}. Thông tin chỉ được dùng để xác nhận lịch hẹn.' ),
			'form_submit'       => array( 'Form – nút gửi', 'text', 'Gửi yêu cầu đặt lịch' ),
			'form_error'        => array( 'Form – thông báo lỗi', 'text', 'Vui lòng kiểm tra lại họ tên, số điện thoại và ngày mong muốn.' ),
			'success_title'     => array( 'Gửi thành công – tiêu đề', 'text', 'Đã nhận yêu cầu' ),
			'success_desc'      => array( 'Gửi thành công – mô tả ({phone} = số hotline)', 'textarea', 'Cảm ơn bạn đã tin chọn An Mộc. Lễ tân sẽ gọi lại xác nhận lịch hẹn trong vòng 30 phút làm việc. Cần gấp, hãy gọi {phone}.' ),
			'success_button'    => array( 'Gửi thành công – nút', 'text', 'Đặt lịch khác' ),
			'booking_email'     => array( 'Email nhận thông báo lịch hẹn (trống = email quản trị)', 'email', '' ),
		),
	);

	/* ---------- Chính sách bảo mật ---------- */
	$s['privacy'] = array(
		'panel'       => 'pages',
		'title'       => 'Trang Chính sách bảo mật',
		'description' => 'Nội dung chi tiết soạn trong trang "Chính sách bảo mật" (Trang → Chính sách bảo mật).',
		'preview'     => 'privacy',
		'fields'      => array(
			'privacy_intro_eyebrow' => array( 'Đầu trang – dòng nhỏ', 'text', 'Chính sách bảo mật' ),
			'privacy_intro_title'   => array( 'Đầu trang – tiêu đề', 'textarea', 'Thông tin của bạn được giữ cẩn trọng.' ),
			'privacy_intro_desc'    => array( 'Đầu trang – mô tả', 'textarea', 'Trang này tóm tắt cách An Mộc thu thập và sử dụng thông tin khi bạn đặt lịch khám.' ),
		),
	);

	return $s;
}

/**
 * Customizer panels.
 */
function anmoc_panels() {
	return array(
		'global' => array( 'An Mộc · Thông tin chung', 160 ),
		'home'   => array( 'An Mộc · Trang chủ', 161 ),
		'pages'  => array( 'An Mộc · Các trang con', 162 ),
	);
}

/**
 * Flat map of field id => definition, cached.
 */
function anmoc_fields() {
	static $flat = null;
	if ( null === $flat ) {
		$flat = array();
		foreach ( anmoc_sections() as $section ) {
			foreach ( $section['fields'] as $id => $field ) {
				$flat[ $id ] = array(
					'label'   => $field[0],
					'type'    => $field[1],
					'default' => $field[2],
					'sub'     => isset( $field[3] ) ? $field[3] : null,
				);
			}
		}
	}
	return $flat;
}

/**
 * Reorderable sections of each page: key => label.
 * "intro", "banner" and "content" are shared renderers, everything else is
 * template-parts/sections/{page}-{key}.php.
 */
function anmoc_layouts() {
	$intro   = array( 'intro' => 'Đầu trang' );
	$content = array( 'content' => 'Nội dung soạn thêm trong trang' );
	$banner  = array( 'banner' => 'Khối "Đặt lịch" cuối trang' );
	return array(
		'home'      => array(
			'hero'         => 'Banner đầu trang',
			'philosophy'   => 'Triết lý',
			'services'     => 'Bản đồ trị liệu',
			'method'       => 'Quy trình thăm khám',
			'testimonials' => 'Cảm nhận khách hàng',
			'journal'      => 'Góc kiến thức',
		) + $banner,
		'about'     => $intro + array(
			'story'     => 'Ảnh & trích dẫn',
			'numbers'   => 'Những con số',
			'standards' => 'Cam kết chuyên môn',
		) + $content + $banner,
		'services'  => $intro + array(
			'cards'     => 'Danh sách dịch vụ',
			'treatment' => 'Nguyên tắc điều trị',
			'faq'       => 'Câu hỏi thường gặp',
		) + $content + $banner,
		'doctors'   => $intro + array(
			'cards'   => 'Danh sách bác sĩ',
			'council' => 'Hội đồng chuyên môn',
		) + $content + $banner,
		'journal'   => $intro + array(
			'featured' => 'Bài viết nổi bật',
			'posts'    => 'Bộ lọc & danh sách bài viết',
		) + $banner,
		'community' => $intro + array(
			'feature'      => 'Chương trình nổi bật',
			'testimonials' => 'Cảm nhận khách hàng',
		) + $content + $banner,
	);
}

/**
 * Sections hidden by default (matches the reference: no booking banner on
 * the journal page). Editors can switch them on in the layout control.
 */
function anmoc_layout_hidden_by_default() {
	return array(
		'journal' => array( 'banner' ),
	);
}

/**
 * Default layout string for a page, e.g. "intro,featured,posts,!banner".
 */
function anmoc_layout_default( $page ) {
	$layouts = anmoc_layouts();
	$hidden  = anmoc_layout_hidden_by_default();
	$tokens  = array();
	foreach ( array_keys( $layouts[ $page ] ) as $key ) {
		$tokens[] = ( isset( $hidden[ $page ] ) && in_array( $key, $hidden[ $page ], true ) ? '!' : '' ) . $key;
	}
	return implode( ',', $tokens );
}

/**
 * Global look & feel options: id => [label, type, default, extra].
 * Numbers become CSS variables, checkboxes become body classes.
 */
function anmoc_design_options() {
	return array(
		'size_base'      => array( 'Cỡ chữ nội dung (px)', 'number', 16, array( 'min' => 14, 'max' => 20, 'step' => 1, 'var' => '--text-base', 'unit' => 'px' ) ),
		'size_small'     => array( 'Cỡ chữ nhãn nhỏ in hoa (px)', 'number', 12, array( 'min' => 11, 'max' => 16, 'step' => 1, 'var' => '--text-xs', 'unit' => 'px', 'help' => 'Các dòng nhỏ in hoa (eyebrow, nhãn, chú thích). Khách lớn tuổi nên để 13–14.' ) ),
		'heading_scale'  => array( 'Tỉ lệ cỡ tiêu đề (%)', 'number', 100, array( 'min' => 70, 'max' => 130, 'step' => 5, 'var' => '--heading-scale', 'unit' => '%', 'help' => '100 = đúng thiết kế.' ) ),
		'radius_button'  => array( 'Độ bo góc nút (px)', 'number', 50, array( 'min' => 0, 'max' => 50, 'step' => 1, 'var' => '--radius-button', 'unit' => 'px', 'help' => '0 = vuông, 50 = bo tròn hoàn toàn.' ) ),
		'container'      => array( 'Độ rộng nội dung tối đa (px)', 'number', 1180, array( 'min' => 960, 'max' => 1440, 'step' => 10, 'var' => '--container', 'unit' => 'px' ) ),
		'show_topbar'    => array( 'Hiện thanh thông tin trên cùng', 'checkbox', true, array( 'class_off' => 'no-topbar' ) ),
		'sticky_header'  => array( 'Giữ menu cố định khi cuộn trang', 'checkbox', true, array( 'class_off' => 'no-sticky' ) ),
		'photo_tone'     => array( 'Ảnh tông trầm như thiết kế (giảm độ rực)', 'checkbox', true, array( 'class_off' => 'photo-natural', 'help' => 'Bỏ chọn để hiển thị ảnh màu gốc.' ) ),
	);
}
