<?php
/**
 * Featured image of one post as a Customizer setting: "anmoc_thumb[123]".
 *
 * The new picture is only shown in the preview; the post's real featured
 * image changes when the changeset is published.
 *
 * Loaded on demand by the customize_dynamic_setting_class filter, so the
 * Customizer classes always exist here.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

class Anmoc_Thumb_Setting extends WP_Customize_Setting {

	public $type = 'anmoc_thumb';

	/** @var int */
	public $post_id = 0;

	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		if ( preg_match( '/^anmoc_thumb\[(\d+)\]$/', $this->id, $m ) ) {
			$this->post_id = (int) $m[1];
		}
		// Anyone who may edit that post may change its picture (see anmoc_thumb_{ID} in customizer-images.php).
		$this->capability = 'anmoc_thumb_' . $this->post_id;
	}

	public function value() {
		return (int) get_post_meta( $this->post_id, '_thumbnail_id', true );
	}

	public function sanitize( $value ) {
		return absint( $value );
	}

	public function validate( $value ) {
		$value = absint( $value );
		if ( $value && ! wp_attachment_is_image( $value ) ) {
			return new WP_Error( 'anmoc_not_image', 'Tệp đã chọn không phải là ảnh.' );
		}
		return parent::validate( $value );
	}

	public function preview() {
		if ( $this->is_previewed ) {
			return true;
		}
		$this->is_previewed = true;
		add_filter( 'post_thumbnail_id', array( $this, 'filter_thumbnail_id' ), 10, 2 );
		return true;
	}

	public function filter_thumbnail_id( $thumbnail_id, $post ) {
		if ( ! $post || (int) $post->ID !== $this->post_id ) {
			return $thumbnail_id;
		}
		$value = $this->post_value( null );
		return null === $value ? $thumbnail_id : (int) $value;
	}

	protected function update( $value ) {
		$value = absint( $value );
		if ( ! $value ) {
			return delete_post_thumbnail( $this->post_id );
		}
		return $value === $this->value() || (bool) set_post_thumbnail( $this->post_id, $value );
	}
}
