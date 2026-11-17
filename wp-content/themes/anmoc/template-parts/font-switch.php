<?php
/**
 * Font scheme switcher in the top bar (for the client to review A–D).
 * Turn off in Customizer → Font chữ once a scheme is chosen.
 *
 * @package anmoc
 */

if ( ! get_theme_mod( 'font_switcher', true ) ) {
	return;
}
$current = anmoc_font_scheme();
$schemes = anmoc_font_schemes();
$preview = array(
	'A' => '"Be Vietnam Pro", sans-serif',
	'B' => '"Cormorant Garamond", serif',
	'C' => '"Noto Serif Display", serif',
	'D' => '"Be Vietnam Pro", sans-serif',
);
?>
<div class="font-switch" data-default="<?php echo esc_attr( $current ); ?>">
	<button type="button" class="font-switch-trigger" aria-expanded="false" aria-controls="font-switch-menu" aria-label="<?php echo esc_attr( 'Đổi font chữ, đang chọn ' . $current . ': ' . $schemes[ $current ][0] ); ?>">
		<strong aria-hidden="true">Aa</strong>
		<small class="font-switch-word" aria-hidden="true">Font</small>
		<b aria-hidden="true"><?php echo esc_html( $current ); ?></b>
		<svg viewBox="0 0 10 10" aria-hidden="true"><path d="M2 3.5 5 6.5 8 3.5" fill="none" stroke="currentColor" stroke-width="1.4" /></svg>
	</button>
	<div id="font-switch-menu" class="font-switch-menu" role="group" aria-label="Phương án font" hidden>
		<?php foreach ( $schemes as $id => $scheme ) : ?>
			<button type="button" class="font-switch-option" data-font="<?php echo esc_attr( $id ); ?>" aria-pressed="<?php echo $id === $current ? 'true' : 'false'; ?>">
				<b aria-hidden="true"><?php echo esc_html( $id ); ?></b>
				<div>
					<strong style="font-family: <?php echo esc_attr( $preview[ $id ] ); ?>; font-weight: <?php echo 'D' === $id ? 300 : 400; ?>"><?php echo esc_html( $scheme[0] ); ?></strong>
					<small><?php echo esc_html( $scheme[1] ); ?></small>
				</div>
				<svg viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8.5 6.5 12 13 4.5" fill="none" stroke="currentColor" stroke-width="1.6" /></svg>
			</button>
		<?php endforeach; ?>
	</div>
</div>
