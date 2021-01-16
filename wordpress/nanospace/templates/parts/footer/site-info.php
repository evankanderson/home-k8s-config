<?php
/**
 * Site info / footer credits area.
 *
 * IMPORTANT:
 * Do not remove the HTML comment from `</div><!-- /footer-area-site-info -->`
 * as it is required for customizer partial refresh manipulation.
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

$site_info_text = trim( (string) get_theme_mod( 'texts_site_info' ) );

// Requirements check.
if ( '-' === $site_info_text ) {

	if ( is_customize_preview() ) {
		echo '<style>.footer-area-site-info { display: none; }</style>';
	} else {
		return;
	}
}
?>

<div class="site-footer-area footer-area-site-info">
	<div class="site-footer-area-inner site-info-inner">

		<?php do_action( 'nanospace_site_info_before' ); ?>

		<div class="site-info">
			<?php
			if ( empty( $site_info_text ) ) {
				?>

				&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
				<span class="sep"> | </span>
				<?php
				printf(
					esc_html_x( 'Using %1$s %2$s theme.', '1: theme name, 2: linked "WordPress" word.', 'nanospace' ),
					'<a href="' . esc_url( wp_get_theme( 'nanospace' )->get( 'ThemeURI' ) ) . '"><strong>' . wp_get_theme( 'nanospace' )->get( 'Name' ) . '</strong></a>',
					'<a href="' . esc_url( __( 'https://wordpress.org/', 'nanospace' ) ) . '">' . __( 'WordPress', 'nanospace' ) . '</a>'
				);

				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '<span class="sep"> | </span>' );
				}
			} else {
				echo wp_kses_post( $site_info_text );
			}
			?>
		</div>

		<?php do_action( 'nanospace_site_info_after' ); ?>

	</div>
</div><!-- /footer-area-site-info -->
