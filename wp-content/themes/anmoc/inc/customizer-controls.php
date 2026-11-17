<?php
/**
 * Custom Customizer controls. UI is built in assets/js/customize-controls.js.
 *
 * @package anmoc
 */

defined( 'ABSPATH' ) || exit;

/**
 * List of rows (add / remove / move up / move down).
 */
class Anmoc_Repeater_Control extends WP_Customize_Control {
	public $type   = 'anmoc_repeater';
	public $fields = array();

	public function to_json() {
		parent::to_json();
		$this->json['fields'] = array();
		foreach ( $this->fields as $key => $def ) {
			$this->json['fields'][] = array(
				'key'   => $key,
				'label' => $def[0],
				'type'  => $def[1],
			);
		}
	}

	public function content_template() {
		?>
		<# if ( data.label ) { #><span class="customize-control-title">{{ data.label }}</span><# } #>
		<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		<ol class="anmoc-rows"></ol>
		<button type="button" class="button anmoc-add-row">+ Thêm mục</button>
		<?php
	}

	public function render_content() {}
}

/**
 * Page sections with a visibility checkbox and move buttons.
 */
class Anmoc_Layout_Control extends WP_Customize_Control {
	public $type  = 'anmoc_layout';
	public $items = array();

	public function to_json() {
		parent::to_json();
		$this->json['items'] = $this->items;
	}

	public function content_template() {
		?>
		<# if ( data.label ) { #><span class="customize-control-title">{{ data.label }}</span><# } #>
		<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		<ul class="anmoc-layout"></ul>
		<?php
	}

	public function render_content() {}
}
