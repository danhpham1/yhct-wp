<?php
/**
 * One text field of a service, doctor, testimonial or FAQ as a Customizer
 * setting: "anmoc_post[123][title]", "anmoc_post[123][desc]"…
 *
 * The new text is only shown in the preview; the post itself is updated
 * when the changeset is published.
 *
 * Loaded on demand by the customize_dynamic_setting_class filter.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

class Anmoc_Post_Field_Setting extends WP_Customize_Setting {

	public $type = 'anmoc_post';

	/** @var int */
	public $post_id = 0;

	/** @var string title | content | a meta key from anmoc_meta_fields() */
	public $field = '';

	/** @var string text | textarea */
	public $field_type = 'text';

	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		if ( preg_match( '/^anmoc_post\[(\d+)\]\[([a-z_]+)\]$/', $this->id, $m ) ) {
			$this->post_id = (int) $m[1];
			$this->field   = $m[2];
			$post          = get_post( $this->post_id );
			$fields        = $post ? anmoc_post_text_fields( $post->post_type ) : array();
			if ( isset( $fields[ $this->field ] ) ) {
				$this->field_type = $fields[ $this->field ][1];
			}
		}
		// Anyone who may edit that post may edit its text (see map_meta_cap in customizer-images.php).
		$this->capability = 'anmoc_edit_' . $this->post_id;
	}

	public function value() {
		$post = get_post( $this->post_id );
		return $post ? anmoc_post_text_raw( $post, $this->field ) : '';
	}

	public function sanitize( $value ) {
		$value = (string) $value;
		return 'textarea' === $this->field_type ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );
	}

	public function preview() {
		if ( $this->is_previewed ) {
			return true;
		}
		$this->is_previewed = true;
		$value              = $this->post_value( null );
		if ( null !== $value ) {
			$GLOBALS['anmoc_post_preview'][ $this->post_id ][ $this->field ] = $value;
		}
		return true;
	}

	protected function update( $value ) {
		if ( 'title' === $this->field || 'content' === $this->field ) {
			$result = wp_update_post(
				wp_slash(
					array(
						'ID'                   => $this->post_id,
						'post_' . $this->field => $value,
					)
				),
				true
			);
			return ! is_wp_error( $result );
		}
		update_post_meta( $this->post_id, '_anmoc_' . $this->field, wp_slash( $value ) );
		return true;
	}
}
