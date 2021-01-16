<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Nanospace
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================================
 * Global template functions
 * ====================================================
 */

if ( ! function_exists( 'nanospace_unassigned_menu' ) ) :
	/**
	 * Fallback HTML if there is no nav menu assigned to a navigation location.
	 */
	function nanospace_unassigned_menu() {
		$labels = get_registered_nav_menus();

		if ( ! is_user_logged_in() || ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}
		?>
		<nav class="nanospace-header-menu-blank nanospace-header-menu site-navigation" id="header-menu-1">
			<ul class="menu">
				<li class="menu-item">
					<a href="<?php echo esc_attr( add_query_arg( 'action', 'locations', admin_url( 'nav-menus.php' ) ) ); ?>"
					   class="nanospace-menu-item-link">
						<?php esc_html_e( 'Assign menu to this location', 'nanospace' ); ?>
					</a>
				</li>
			</ul>
		</nav>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_inline_svg' ) ) :
	/**
	 * Print / return inline SVG HTML tags.
	 */
	function nanospace_inline_svg( $svg_file, $echo = true ) {
		// Return empty if no SVG file path is provided.
		if ( empty( $svg_file ) ) {
			return;
		}

		// Get SVG markup.
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$html = $wp_filesystem->get_contents( $svg_file );

		// Remove XML encoding tag.
		// This should not be printed on inline SVG.
		$html = preg_replace( '/<\?xml(?:.*?)\?>/', '', $html );

		// Add width attribute if not found in the SVG markup.
		// Width value is extracted from viewBox attribute.
		if ( ! preg_match( '/<svg.*?width.*?>/', $html ) ) {
			if ( preg_match( '/<svg.*?viewBox="0 0 ([0-9.]+) ([0-9.]+)".*?>/', $html, $matches ) ) {
				$html = preg_replace( '/<svg (.*?)>/', '<svg $1 width="' . $matches[1] . '" height="' . $matches[2] . '">', $html );
			}
		}

		// Remove <title> from SVG markup.
		// Site name would be added as a screen reader text to represent the logo.
		$html = preg_replace( '/<title>.*?<\/title>/', '', $html );

		if ( $echo ) {
			echo $html; // WPCS: XSS OK
		} else {
			return $html;
		}
	}
endif;

if ( ! function_exists( 'nanospace_logo' ) ) :
	/**
	 * Print HTML markup for specified site logo.
	 *
	 * @param integer $logo_image_id
	 */
	function nanospace_logo( $logo_image_id = null ) {
		// Default to site name.
		$html = get_bloginfo( 'name', 'display' );

		// Try to get logo image.
		if ( ! empty( $logo_image_id ) ) {
			$mime = get_post_mime_type( $logo_image_id );

			switch ( $mime ) {
				case 'image/svg+xml':
					$svg_file = get_attached_file( $logo_image_id );

					$logo_image = nanospace_inline_svg( $svg_file, false );
					break;

				default:
					$logo_image = wp_get_attachment_image( $logo_image_id, 'full', 0, array() );
					break;
			}

			// Replace logo HTML if logo image is found.
			if ( ! empty( $logo_image ) ) {
				$html = '<span class="nanospace-logo-image">' . $logo_image . '</span><span class="screen-reader-text">' . get_bloginfo( 'name', 'display' ) . '</span>';
			}
		}

		echo $html; // WPCS: XSS OK
	}
endif;
if ( ! function_exists( 'nanospace_default_mobile_logo' ) ) :
	/**
	 * Print / return HTML markup for default mobile logo.
	 */
	function nanospace_default_mobile_logo() {
		?>

		<?php
	}
endif;

if ( ! function_exists( 'nanospace_icon' ) ) :
	/**
	 * Print / return HTML markup for specified icon type in SVG format.
	 *
	 * @param string $key
	 * @param array $args
	 * @param boolean $echo
	 */
	function nanospace_icon( $key, $args = array(), $echo = true ) {
		$args = wp_parse_args( $args, array(
			'title' => '',
			'class' => '',
		) );

		$classes = implode( ' ', array( $args['class'], 'nanospace-icon' ) );

		// Get SVG path.
		$path = get_template_directory() . '/assets/icons/' . $key . '.svg';

		// Allow modification via filter.
		$path = apply_filters( 'nanospace_frontend_svg_icon_path', $path, $key );
		$path = apply_filters( 'nanospace_frontend_svg_icon_path_' . $key, $path );

		// Get SVG markup.
		if ( file_exists( $path ) ) {
			$svg = nanospace_inline_svg( $path, false );
		} else {
			$svg = nanospace_inline_svg( get_template_directory() . '/assets/icons/_fallback.svg', false ); // fallback
		}

		// Allow modification via filter.
		$svg = apply_filters( 'nanospace_frontend_svg_icon', $svg, $key );
		$svg = apply_filters( 'nanospace_frontend_svg_icon_' . $key, $svg );

		// Wrap the icon with "nanospace-icon" span tag.
		$html = '<span class="' . esc_attr( $classes ) . '" title="' . esc_attr( $args['title'] ) . '">' . $svg . '</span>';

		if ( $echo ) {
			echo $html; // WPCS: XSS OK
		} else {
			return $html;
		}
	}
endif;

if ( ! function_exists( 'nanospace_social_links' ) ) :
	/**
	 * Print / return HTML markup for specified set of social media links.
	 *
	 * @param array $links
	 * @param array $args
	 * @param boolean $echo
	 */
	function nanospace_social_links( $links = array(), $args = array(), $echo = true ) {
		$labels = nanospace_get_social_media_types();

		$args = wp_parse_args( $args, array(
			'before_link' => '',
			'after_link'  => '',
			'link_class'  => '',
		) );

		ob_start();
		foreach ( $links as $link ) :
			echo $args['before_link'];

			?><a href="<?php echo esc_url( $link['url'] ); ?>"
				 class="nanospace-social-link" <?php echo '_blank' === nanospace_array_value( $link, 'target', '_self' ) ? ' target="_blank" rel="noopener"' : '';
			?>>
			<?php nanospace_icon( $link['type'], array(
			'title' => $labels[ $link['type'] ],
			'class' => $args['link_class']
		) ); 
			if ( nanospace_array_value( $link, 'target', '_self' ) === '_blank') {
				echo '<span class="screen-reader-text">' . esc_html__( '(Opens in a new window)', 'nanospace' ) . ' </span>';
			}
			?>
			</a><?php

			echo $args['after_link'];
		endforeach;
		$html = ob_get_clean();

		if ( $echo ) {
			echo $html;
		} else {
			return $html;
		}
	}
endif;

/**
 * ====================================================
 * Header template functions
 * ====================================================
 */

if ( ! function_exists( 'nanospace_mobile_vertical_header' ) ) :
	/**
	 * Render mobile vertical header.
	 */
	function nanospace_mobile_vertical_header() {
		if ( intval( nanospace_get_current_page_setting( 'disable_mobile_header' ) ) ) {
			return;
		}

		$elements = nanospace_get_theme_mod( 'header_mobile_elements_vertical_top', array() );
		$count    = count( $elements );

		if ( 0 < $count ) : ?>
			<div id="mobile-vertical-header"
				 class="nanospace-header-mobile-vertical <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_header_mobile_vertical_classes', array() ) ) ); ?> nanospace-header nanospace-popup"
				 itemtype="https://schema.org/WPHeader" itemscope>
				<div class="nanospace-popup-background nanospace-popup-close">
					<button id="btn_close" class="nanospace-popup-close-icon nanospace-popup-close nanospace-popup-toggle nanospace-toggle" data-set-focus=".nanospace-popup-toggle"><?php nanospace_icon( 'close' ); ?></button>
				</div>

				<div class="nanospace-header-mobile-vertical-bar nanospace-header-section-vertical nanospace-popup-content">
					<div class="nanospace-header-mobile-vertical-bar-inner nanospace-header-section-vertical-inner">
						<div class="nanospace-header-section-vertical-column">
							<div class="nanospace-header-mobile-vertical-bar-top nanospace-header-section-vertical-row nanospace-flex-align-left">
								<?php foreach ( $elements as $element ) {
									nanospace_header_element( $element );
								} ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif;
	}
endif;


if ( ! function_exists( 'nanospace_full_screen_vertical_header' ) ) :
	/**
	 * Render mobile vertical header.
	 */
	function nanospace_full_screen_vertical_header() {
		?>
		<div id="full-screen-vertical-header" class="nanospace-header-full-vertical nanospace-header nanospace-popup"
			 itemtype="https://schema.org/WPHeader" itemscope>
			<div class="nanospace-popup-background nanospace-popup-close">
				<button class="nanospace-popup-close-icon nanospace-popup-close nanospace-toggle" data-set-focus=".nanospace-popup-toggle"><?php nanospace_icon( 'close' ); ?></button>
			</div>

			<div id="full-screen-header">
				<div class="nanospace-header-full-vertical-bar-inner">
					<div class="nanospace-header-section-vertical-column">
						<div class="nanospace-header-full-vertical-bar-top nanospace-header-section-vertical-row nanospace-flex-align-left">
							<?php nanospace_header_element( 'menu' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_header' ) ) :
	/**
	 * Render horizontal header.
	 */
	function nanospace_header() {
		?>
		<header id="masthead" class="site-header" role="banner" itemtype="https://schema.org/WPHeader" itemscope>
			<?php
			/**
			 * Hook: nanospace_frontend_header
			 *
			 * @hooked nanospace_main_header - 10
			 * @hooked nanospace_mobile_header - 10
			 */
			do_action( 'nanospace_frontend_header' );
			?>
		</header>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_main_header' ) ) :
	/**
	 * Render main header.
	 */
	function nanospace_main_header() {
		$layout = nanospace_get_theme_mod( 'nanospace_section_header_layout_select', true );
		if ( $layout == 'standard-header' ) {

			?>
			<div id="header"
				 class="nanospace-header-main nanospace-header <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_header_classes', array() ) ) ); ?>">
				<?php
				// Top Bar (if not merged)
				if ( ! intval( nanospace_get_theme_mod( 'header_top_bar_merged' ) ) ) {
					nanospace_main_header__bar( 'top' );
				}

				// Main Bar
				nanospace_main_header__bar( 'main' );

				// Bottom Bar (if not merged)
				if ( ! intval( nanospace_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
					nanospace_main_header__bar( 'bottom' );
				}
				?>
			</div>
			<?php
		}
	}
endif;
if ( ! function_exists( 'nanospace_left_header' ) ) :
	/**
	 * Render main header.
	 */
	function nanospace_left_header() {
		$layout = nanospace_get_theme_mod( 'nanospace_section_header_layout_select', true );
		if ( $layout == 'left-header' ) {
			?>
			<div id="header"
				 class="nanospace-header-main nanospace-header nanospace-header-vertical-color nanospace-left-header <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_header_classes', array() ) ) ); ?>">
				<?php
				nanospace_right_header__bar( 'top' );
				nanospace_right_header__bar( 'main' );
				nanospace_right_header__bar( 'bottom' );
				?>
			</div>
			<?php
		}
	}
endif;
if ( ! function_exists( 'nanospace_right_header' ) ) :
	/**
	 * Render main header.
	 */
	function nanospace_right_header() {
		$layout = nanospace_get_theme_mod( 'nanospace_section_header_layout_select', true );
		if ( $layout == 'right-header' ) {
			?>
			<div id="header"
				 class="nanospace-header-main nanospace-header nanospace-header-vertical-color nanospace-right-header <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_header_classes', array() ) ) ); ?>">
				<?php
				nanospace_right_header__bar( 'top' );
				nanospace_right_header__bar( 'main' );
				nanospace_right_header__bar( 'bottom' );
				?>
			</div>
			<?php
		}
	}
endif;

if ( ! function_exists( 'nanospace_main_header__bar' ) ) :
	/**
	 * Render main header bar.
	 *
	 * @param string $bar
	 */
	function nanospace_main_header__bar( $bar ) {
		$elements = array();
		$count    = 0;
		$cols     = array( 'left', 'center', 'right' );

		foreach ( $cols as $col ) {
			$elements[ $col ] = nanospace_get_theme_mod( 'header_elements_' . $bar . '_' . $col, array() );
			$count            += count( $elements[ $col ] );
		}

		if ( 1 > $count ) {
			return;
		}

		$attrs_array = apply_filters( 'nanospace_frontend_header_' . $bar . '_bar_attrs', array(
			'data-height' => intval( nanospace_get_theme_mod( 'header_' . $bar . '_bar_height' ) ),
		) );
		$attrs       = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		?>
		<div id="nanospace-header-<?php echo esc_attr( $bar ); ?>-bar"
			 class="nanospace-header-<?php echo esc_attr( $bar ); ?>-bar nanospace-header-section nanospace-section <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_header_' . $bar . '_bar_classes', array() ) ) ); ?>" <?php echo $attrs; ?>>
			<div class="nanospace-header-<?php echo esc_attr( $bar ); ?>-bar-inner nanospace-section-inner">
				<div class="nanospace-wrapper">

					<?php
					// Top Bar (if merged).
					if ( 'main' === $bar && intval( nanospace_get_theme_mod( 'header_top_bar_merged' ) ) ) {
						nanospace_main_header__bar( 'top' );
					}
					?>

					<div class="nanospace-header-<?php echo esc_attr( $bar ); ?>-bar-row nanospace-header-row">
						<?php foreach ( $cols as $col ) : ?>
							<div class="<?php echo esc_attr( 'nanospace-header-' . $bar . '-bar-' . $col ); ?> nanospace-header-column <?php echo esc_attr( 'nanospace-flex-align-' . $col ); ?>"><?php foreach ( $elements[ $col ] as $element ) { nanospace_header_element( $element );	} ?></div>
						<?php endforeach; ?>
					</div>

					<?php
					// Bottom Bar (if merged).
					if ( 'main' === $bar && intval( nanospace_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
						nanospace_main_header__bar( 'bottom' );
					}
					?>

				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_right_header__bar' ) ) :
	/**
	 * Render main header bar.
	 *
	 * @param string $bar
	 */
	function nanospace_right_header__bar( $bar ) {
		$elements = array();
		$count    = 0;
		$cols     = array( 'left', 'center', 'right' );

		foreach ( $cols as $col ) {
			$elements[ $col ] = nanospace_get_theme_mod( 'header_vertical_elements_' . $bar . '_' . $col, array() );
			$count            += count( $elements[ $col ] );
		}

		if ( 1 > $count ) {
			return;
		}

		$attrs_array = apply_filters( 'nanospace_frontend_header_' . $bar . '_bar_attrs', array(
			'data-height' => intval( nanospace_get_theme_mod( 'header_' . $bar . '_bar_height' ) ),
		) );
		$attrs       = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		?>
		<div id="nanospace-header-vertical-<?php echo esc_attr( $bar ); ?>-bar"
			 class="nanospace-header-vertical-<?php echo esc_attr( $bar ); ?>-bar nanospace-header-section nanospace-section <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_header_' . $bar . '_bar_classes', array() ) ) ); ?>" <?php echo $attrs; ?>>
			<div class="nanospace-header-<?php echo esc_attr( $bar ); ?>-bar-inner nanospace-section-inner">
				<div class="nanospace-wrapper">

					<div class="nanospace-header-<?php echo esc_attr( $bar ); ?>-bar-row nanospace-header-row">
						<?php foreach ( $cols as $col ) : ?>
							<div class="<?php echo esc_attr( 'nanospace-header-' . $bar . '-bar-' . $col ); ?> nanospace-header-column <?php echo esc_attr( 'nanospace-flex-align-' . $col ); ?>">
								<?php foreach ( $elements[ $col ] as $element ) {
									nanospace_header_element( $element );
								} ?>
							</div>
						<?php endforeach; ?>
					</div>

				</div>
			</div>
		</div>
		<?php
	}
endif;
if ( ! function_exists( 'nanospace_left_header__bar' ) ) :
	/**
	 * Render main header bar.
	 *
	 * @param string $bar
	 */
	function nanospace_left_header__bar( $bar ) {
		$elements = array();
		$count    = 0;
		$cols     = array( 'left', 'center', 'right' );

		foreach ( $cols as $col ) {
			$elements[ $col ] = nanospace_get_theme_mod( 'header_vertical_elements_' . $bar . '_' . $col, array() );
			$count            += count( $elements[ $col ] );
		}

		if ( 1 > $count ) {
			return;
		}

		$attrs_array = apply_filters( 'nanospace_frontend_header_' . $bar . '_bar_attrs', array(
			'data-height' => intval( nanospace_get_theme_mod( 'header_' . $bar . '_bar_height' ) ),
		) );
		$attrs       = '';
		foreach ( $attrs_array as $key => $value ) {
			$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		?>
		<div id="nanospace-header-vertical-<?php echo esc_attr( $bar ); ?>-bar"
			 class="nanospace-header-vertical-<?php echo esc_attr( $bar ); ?>-bar nanospace-header-section nanospace-section <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_header_' . $bar . '_bar_classes', array() ) ) ); ?>" <?php echo $attrs; ?>>
			<div class="nanospace-header-<?php echo esc_attr( $bar ); ?>-bar-inner nanospace-section-inner">
				<div class="nanospace-wrapper">

					<div class="nanospace-header-<?php echo esc_attr( $bar ); ?>-bar-row nanospace-header-row">
						<?php foreach ( $cols as $col ) : ?>
							<div class="<?php echo esc_attr( 'nanospace-header-' . $bar . '-bar-' . $col ); ?> nanospace-header-column <?php echo esc_attr( 'nanospace-flex-align-' . $col ); ?>">
								<?php foreach ( $elements[ $col ] as $element ) {
									nanospace_header_element( $element );
								} ?>
							</div>
						<?php endforeach; ?>
					</div>

				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_mobile_header' ) ) :
	/**
	 * Render mobile header.
	 */
	function nanospace_mobile_header() {
		if ( intval( nanospace_get_current_page_setting( 'disable_mobile_header' ) ) ) {
			return;
		}

		?>
		<div id="mobile-header"
			 class="nanospace-header-mobile nanospace-header <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_header_mobile_classes', array() ) ) ); ?>">
			<?php
			$elements = array();
			$count    = 0;
			$cols     = array( 'left', 'center', 'right' );

			foreach ( $cols as $col ) {
				$elements[ $col ] = nanospace_get_theme_mod( 'header_mobile_elements_main_' . $col, array() );
				$count            += count( $elements[ $col ] );
			}

			if ( 1 > $count ) {
				return;
			}

			$attrs_array = apply_filters( 'nanospace_frontend_header_mobile_main_bar_attrs', array(
				'data-height' => intval( nanospace_get_theme_mod( 'header_mobile_main_bar_height' ) ),
			) );
			$attrs       = '';
			foreach ( $attrs_array as $key => $value ) {
				$attrs .= ' ' . $key . '="' . esc_attr( $value ) . '"';
			}

			?>
			<div id="nanospace-header-mobile-main-bar"
				 class="nanospace-header-mobile-main-bar nanospace-header-section nanospace-section nanospace-section-default <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_header_mobile_main_bar_classes', array() ) ) ); ?>" <?php echo $attrs; ?>>
				<div class="nanospace-header-mobile-main-bar-inner nanospace-section-inner">
					<div class="nanospace-wrapper">
						<div class="nanospace-header-mobile-main-bar-row nanospace-header-row">
							<?php foreach ( $cols as $col ) : ?>
								<div class="<?php echo esc_attr( 'nanospace-header-mobile-main-bar-' . $col ); ?> nanospace-header-column <?php echo esc_attr( 'nanospace-flex-align-' . $col ); ?>"><?php foreach ( $elements[ $col ] as $element ) { nanospace_header_element( $element ); } ?></div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_header_element' ) ) :
	/**
	 * Wrapper function to print HTML markup for all header element.
	 *
	 * @param string $element
	 */
	function nanospace_header_element( $element ) {
		if ( empty( $element ) ) {
			return;
		}

		// Classify element into its type.
		$type = preg_replace( '/-\d$/', '', $element );

		// Convert element slug into key format.
		$key             = str_replace( '-', '_', $element );

		ob_start();
		switch ( $type ) {
			case 'logo':
				?>
			<div class="<?php echo esc_attr( 'nanospace-header-' . $element ); ?> site-branding menu">
				<div class="site-title menu-item h1">
				<a href="<?php echo esc_url( apply_filters( 'nanospace_frontend_logo_url', home_url( '/' ) ) ); ?>" rel="home" class="nanospace-menu-item-link">
				<span class="nanospace-default-logo nanospace-logo"><?php nanospace_logo( nanospace_get_theme_mod( 'custom_logo' ) ); ?></span>
				</a>
				</div>
				</div>
				<?php
				break;

			case 'vertical-logo':
				?>
			<div class="<?php echo esc_attr( 'nanospace-header-' . $element ); ?> site-branding menu">
				<<?php echo is_front_page() && is_home() ? 'h1' : 'div'; ?> class="site-title menu-item h1">
				<a href="<?php echo esc_url( apply_filters( 'nanospace_frontend_logo_url', home_url( '/' ) ) ); ?>"
				   rel="home" class="nanospace-menu-item-link">
					<span class="nanospace-default-logo nanospace-logo"><?php nanospace_logo( nanospace_get_theme_mod( 'custom_logo' ) ); ?></span>
				</a>
				</<?php echo is_front_page() && is_home() ? 'h1' : 'div'; ?>>
				</div>
				<?php
				break;

			case 'mobile-logo':
				?>
				<div class="<?php echo esc_attr( 'nanospace-header-' . $element ); ?> site-branding menu">
					<div class="site-title menu-item h1">
						<a href="<?php echo esc_url( apply_filters( 'nanospace_frontend_logo_url', home_url( '/' ) ) ); ?>"
						   rel="home" class="nanospace-menu-item-link">
							<span class="nanospace-default-logo nanospace-logo"><?php nanospace_logo( nanospace_get_theme_mod( 'custom_logo_mobile' ) ); ?></span>
						</a>
					</div>
				</div>
				<?php
				break;

			case 'menu':
				if ( has_nav_menu( 'header-' . $element ) ) {
					/* translators: %s: header menu number. */
					$aria_label = sprintf( esc_html__( 'Header Menu %s', 'nanospace' ), str_replace( 'menu-', '', $element ) );
					$id         = 'header-' . $element;
					?>
					<nav class="<?php echo esc_attr( 'nanospace-header-' . $element ); ?> nanospace-header-menu site-navigation"
						 id="<?php echo esc_attr( $id ); ?>"
						 itemtype="https://schema.org/SiteNavigationElement" itemscope role="navigation"
						 aria-label="<?php echo esc_attr( $aria_label ); ?>">
						<?php wp_nav_menu( array(
							'theme_location' => 'header-' . $element,
							'menu_class'     => 'menu nav-menu nanospace-hover-menu', /** was menu nanospace-hover-menu */
							'container'      => false,
						) ); ?>
					</nav>
					<?php
				} else {
					nanospace_unassigned_menu();
				}
				break;

			case 'mobile-menu':
				if ( has_nav_menu( 'header-' . $element ) ) {
					?>
					<nav class="mobile-nav nanospace-header-menu site-navigation"
						 itemtype="https://schema.org/SiteNavigationElement" itemscope role="navigation"
						 aria-label="<?php esc_attr_e( 'Mobile Header Menu', 'nanospace' ); ?>">
						<?php wp_nav_menu( array(
							'theme_location' => 'header-' . $element,
							'menu_id'        => 'nanospace_mobile_menu',
							'menu_class'     => 'menu nav-menu nanospace-hover-menu',
							'container'      => false,
						) ); ?>
					</nav>
					<?php
				} else {
					nanospace_unassigned_menu();
				}
				break;

			case 'html':
				$content = nanospace_get_theme_mod( 'header_' . $key . '_content' );
				?>
				<div class="<?php echo esc_attr( 'nanospace-header-' . $element ); ?> nanospace-bar-html-item">
					<div><?php echo do_shortcode( $content ); ?></div>
				</div>
				<?php
				break;

			case 'button':
				$id = nanospace_get_theme_mod( 'header_' . $key . '_id' );
				$link    = nanospace_get_theme_mod( 'header_' . $key . '_link' );
				$text    = nanospace_get_theme_mod( 'header_' . $key . '_text' );
				$class   = nanospace_get_theme_mod( 'header_' . $key . '_class' );
				$target  = '_' . nanospace_get_theme_mod( 'header_' . $key . '_target' );
				?>
				<div class="<?php echo esc_attr( 'nanospace-header-' . $element ); ?>">
					<div class="<?php echo esc_attr( 'nanospace-' . $element ); ?>">
						<a href="<?php echo ! empty( $link ) ? $link : '#'; ?>"
						    class="btn btn-default <?php echo ! empty( $class ) ? $class : ''; ?>"
						    id="<?php echo ! empty( $id ) ? $id : ''; ?>"
						    target="<?php echo ! empty( $target ) ? $target : '#' ?>"
						    <?php
						    if ( $target === '_blank' ) {
								echo 'aria-label="' . esc_attr__( '(Opens in a new window)', 'nanospace' ) . '"';
							}
							?>
						>
						<?php echo ! empty( $text ) ? $text : 'Button'; ?>
						</a>
					</div>
				</div>
				<?php
				break;

			case 'search-bar':
				?>
				<div class="<?php echo esc_attr( 'nanospace-header-' . $element ); ?> nanospace-header-search">
					<?php get_search_form(); ?>
				</div>
				<?php
				break;

			case 'shopping-cart-dropdown':
				if ( class_exists( 'WooCommerce' ) ) {
					$cart = WC()->cart;

					if ( ! empty( $cart ) ) {
						$count = $cart->get_cart_contents_count();
						?>
						<nav class="site-navigation <?php echo esc_attr( 'nanospace-header-' . $element ); ?> nanospace-header-shopping-cart">
							<ul class="menu nav-menu nanospace-hover-menu">
								<li class="menu-item menu-item-has-children">
									<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="nanospace-menu-item-link nanospace-toggle">
									<?php nanospace_icon( 'shopping-cart', array( 'class' => 'nanospace-menu-icon' ) ); ?>
									<span class="screen-reader-text"><?php esc_html_e( 'Shopping Cart', 'nanospace' ); ?></span>
									<span class="shopping-cart-count" data-count="<?php echo esc_attr( $count ); ?>"><?php echo $count; // WPCS: XSS OK ?></span>
									</a>
									<ul class="sub-menu">
										<li class="nanospace-minicart">
										<?php woocommerce_mini_cart(); ?>
										</li>
									</ul>
								</li>
							</ul>
						</nav>
						<?php
					}
				}
				break;

			case 'shopping-cart-link':
				if ( class_exists( 'WooCommerce' ) ) {
					$cart = WC()->cart;

					if ( ! empty( $cart ) ) {
						$count = $cart->get_cart_contents_count();
						?>
						<div class="<?php echo esc_attr( 'nanospace-header-' . $element ); ?> nanospace-header-shopping-cart menu">
							<div class="menu-item">
								<a aria-label="shopping cart" href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="shopping-cart-link">
									<?php nanospace_icon( 'shopping-cart', array( 'class' => 'nanospace-menu-icon' ) ); ?>
									<span class="shopping-cart-count" data-count="<?php echo esc_attr( $count ); ?>"><?php echo $count; // WPCS: XSS OK ?></span>
								</a>
							</div>
						</div>
						<?php
					}
				}
				break;

			case 'social':
				$types = nanospace_get_theme_mod( 'header_social_links', array() );

				if ( ! empty( $types ) ) {
					$target = '_' . nanospace_get_theme_mod( 'header_social_links_target' );
					$links  = array();

					foreach ( $types as $type ) {
						$url     = nanospace_get_theme_mod( 'social_' . $type );
						$links[] = array(
							'type'   => $type,
							'url'    => ! empty( $url ) ? $url : '#',
							'target' => $target,
						);
					}
					?>
					<nav class="nanospace-social-links-menu" aria-label="<?php esc_attr_e( 'Social media links', 'nanospace' ); ?>">
					<ul class="<?php echo esc_attr( 'nanospace-header-' . $element ); ?> menu nanospace-menu-icon">
						<?php nanospace_social_links( $links, array(
							'before_link' => '<li class="menu-item">',
							'after_link'  => '</li>',
							'link_class'  => 'nanospace-menu-icon',
						) ); ?>
					</ul>
					</nav>
					<?php
				}
				break;

			case 'mobile-vertical-toggle':
				?>
				<div class="<?php echo esc_attr( 'nanospace-header-' . $element ); ?>">
					<button class="nanospace-popup-toggle nanospace-toggle" data-target="mobile-vertical-header" data-set-focus=".nanospace-popup-close">
						<?php nanospace_icon( 'menu', array( 'class' => 'nanospace-menu-icon' ) ); ?>
						<span class="screen-reader-text"><?php esc_html_e( 'Mobile Menu', 'nanospace' ); ?></span>
					</button>
				</div>
				<?php
				break;

			default:
				// Print nothing.
				// Other elements can be modified via filters.
				break;
		}
		$html = ob_get_clean();

		// Filters to modify the final HTML tag.
		$html = apply_filters( 'nanospace_frontend_header_element', $html, $element );
		$html = apply_filters( 'nanospace_frontend_header_element_' . $element, $html );

		echo $html; // WPCS: XSS OK
	}
endif;

if ( ! function_exists( 'nanospace_breadcrumb' ) ) :
	/**
	 * Render breadcrumb via 3rd party plugin.
	 */
	function nanospace_breadcrumb() {
		if ( ! intval( nanospace_get_theme_mod( 'page_header_breadcrumb' ) ) ) {
			return;
		}

		ob_start();
		switch ( nanospace_get_theme_mod( 'breadcrumb_plugin', '' ) ) {
			case 'breadcrumb-trail':
				if ( function_exists( 'breadcrumb_trail' ) ) {
					breadcrumb_trail( array(
						'show_browse' => false,
					) );
				}
				break;

			case 'breadcrumb-navxt':
				if ( function_exists( 'bcn_display' ) ) {
					bcn_display();
				}
				break;

			case 'yoast-seo':
				if ( function_exists( 'yoast_breadcrumb' ) ) {
					yoast_breadcrumb();
				}
				break;
		}
		$breadcrumb = ob_get_clean();

		if ( ! empty( $breadcrumb ) ) {
			echo '<div class="nanospace-page-header-breadcrumb nanospace-breadcrumb">' . $breadcrumb . '</div>'; // WPCS: XSS OK
		}
	}
endif;

/**
 * ====================================================
 * Content section template functions
 * ====================================================
 */

if ( ! function_exists( 'nanospace_content_open' ) ) :
	/**
	 * Render content section opening tags.
	 */
	function nanospace_content_open() {
		?>
		<div id="content" class="site-content nanospace-section <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_content_classes', array() ) ) ); ?>">
		<div class="nanospace-content-inner nanospace-section-inner">
		<div class="nanospace-wrapper">
		<div class="nanospace-content-row">
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_content_close' ) ) :
	/**
	 * Render content section closing tags.
	 */
	function nanospace_content_close() {
		?>
		</div>
		</div>
		</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_primary_open' ) ) :
	/**
	 * Render main content opening tags.
	 */
	function nanospace_primary_open() {
		?>
		<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_primary_close' ) ) :
	/**
	 * Render main content closing tags.
	 */
	function nanospace_primary_close() {
		?>
		</main>
		</div>
		<?php
	}
endif;

/**
 * ====================================================
 * Footer template functions
 * ====================================================
 */

if ( ! function_exists( 'nanospace_footer' ) ) :
	/**
	 * Render footer section.
	 */
	function nanospace_footer() {
		?>
		<footer id="colophon" class="site-footer nanospace-footer" role="contentinfo"
				itemtype="https://schema.org/WPFooter" itemscope>
			<?php
			nanospace_footer_widgets();

			// Bottom Bar (if not merged)
			if ( ! intval( nanospace_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
				nanospace_footer_top();
			}

			if ( ! intval( nanospace_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
				nanospace_footer_bottom();
			}
			?>
		</footer>
		<?php
	}
endif;
if ( ! function_exists( 'nanospace_footer_widgets' ) ) :
	/**
	 * Render footer widgets area.
	 */
	function nanospace_footer_widgets() {
		if ( intval( nanospace_get_current_page_setting( 'disable_footer_widgets' ) ) ) {
			return;
		}

		$columns = intval( nanospace_get_theme_mod( 'footer_widgets_bar' ) );

		if ( 1 > $columns ) {
			return;
		}

		$print_row = 0;
		for ( $i = 1; $i <= $columns; $i ++ ) {
			if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
				$print_row = true;
				break;
			}
		}
		?>
		<div id="nanospace-footer-widgets-bar"
			 class="nanospace-footer-widgets-bar nanospace-footer-section nanospace-section <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_footer_widgets_bar_classes', array() ) ) ); ?>">
			<div class="nanospace-footer-widgets-bar-inner nanospace-section-inner">
				<div class="nanospace-wrapper">
					<?php if ( $print_row ) : ?>
						<div class="nanospace-footer-widgets-bar-row <?php echo esc_attr( 'nanospace-footer-widgets-bar-columns-' . nanospace_get_theme_mod( 'footer_widgets_bar' ) ); ?>">
							<?php for ( $i = 1; $i <= $columns; $i ++ ) : ?>
								<div class="nanospace-footer-widgets-bar-column-<?php echo esc_attr( $i ); ?> nanospace-footer-widgets-bar-column">
									<?php if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
										dynamic_sidebar( 'footer-widgets-' . $i );
									} ?>
								</div>
							<?php endfor; ?>
						</div>
					<?php endif; ?>

					<?php
					// Bottom Bar (if merged)
					if ( intval( nanospace_get_theme_mod( 'footer_top_bar_merged' ) ) ) {
						nanospace_footer_top();
					}
					?>

				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_footer_bottom' ) ) :
	/**
	 * Render footer bottom bar.
	 */
	function nanospace_footer_bottom() {
		if ( intval( nanospace_get_current_page_setting( 'disable_footer_bottom' ) ) ) {
			return;
		}

		$cols = array( 'left', 'center', 'right' );

		$elements = array();
		$count    = 0;

		foreach ( $cols as $col ) {
			$elements[ $col ] = nanospace_get_theme_mod( 'footer_elements_bottom_' . $col, array() );
			$count            += empty( $elements[ $col ] ) ? 0 : count( $elements[ $col ] );
		}

		if ( 1 > $count ) {
			return;
		}

		?>
		<div id="nanospace-footer-bottom-bar"
			 class="nanospace-footer-bottom-bar site-info nanospace-footer-section nanospace-section <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_footer_bottom_bar_classes', array() ) ) ); ?>">
			<div class="nanospace-footer-bottom-bar-inner nanospace-section-inner">
				<div class="nanospace-wrapper">
					<div class="nanospace-footer-bottom-bar-row nanospace-footer-row">
						<?php foreach ( $cols as $col ) : ?>
							<div class="nanospace-footer-bottom-bar-<?php echo esc_attr( $col ); ?> nanospace-footer-bottom-bar-column"><?php foreach ( $elements[ $col ] as $element ) { nanospace_footer_element( $element ); } ?></div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_footer_top' ) ) :
	/**
	 * Render footer top bar.
	 */
	function nanospace_footer_top() {
		if ( intval( nanospace_get_current_page_setting( 'disable_footer_top' ) ) ) {
			return;
		}

		$cols = array( 'left', 'center', 'right' );

		$elements = array();
		$count    = 0;

		foreach ( $cols as $col ) {
			$elements[ $col ] = nanospace_get_theme_mod( 'footer_elements_top_' . $col, array() );
			$count            += empty( $elements[ $col ] ) ? 0 : count( $elements[ $col ] );
		}

		if ( 1 > $count ) {
			return;
		}

		?>
		<div id="nanospace-footer-top-bar"
			 class="nanospace-footer-top-bar site-info nanospace-footer-section nanospace-section <?php echo esc_attr( implode( ' ', apply_filters( 'nanospace_frontend_footer_top_bar_classes', array() ) ) ); ?>">
			<div class="nanospace-footer-top-bar-inner nanospace-section-inner">
				<div class="nanospace-wrapper">
					<div class="nanospace-footer-top-bar-row nanospace-footer-row">
						<?php foreach ( $cols as $col ) : ?>
							<div class="nanospace-footer-top-bar-<?php echo esc_attr( $col ); ?> nanospace-footer-top-bar-column"><?php foreach ( $elements[ $col ] as $element ) { nanospace_footer_element( $element ); } ?></div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_footer_element' ) ) :
	/**
	 * Render each footer element.
	 *
	 * @param string $element
	 */
	function nanospace_footer_element( $element ) {
		if ( empty( $element ) ) {
			return;
		}

		// Classify element into its type.
		$type = preg_replace( '/-\d$/', '', $element );

		// Convert element slug into key format.
		$key               = str_replace( '-', '_', $element );

		ob_start();
		switch ( $type ) {
			case 'menu':
				if ( has_nav_menu( 'footer-' . $element ) ) {
					?>
					<nav class="<?php echo esc_attr( 'nanospace-footer-' . $element ); ?> nanospace-footer-menu"
						 itemtype="https://schema.org/SiteNavigationElement" itemscope role="navigation">
						<?php wp_nav_menu( array(
							'theme_location' => 'footer-' . $element,
							'menu_class'     => 'menu',
							'container'      => false,
							'depth'          => - 1,
						) ); ?>
					</nav>
					<?php
				} else {
					nanospace_unassigned_menu();
				}
				break;

			case 'copyright':
				$theme_info = wp_get_themes()['nanospace'];
				$copyright = nanospace_get_theme_mod( 'footer_' . $key . '_content' );
				$copyright = str_replace( '{{year}}', date( 'Y' ), $copyright );
				$copyright = str_replace( '{{sitename}}', '<a href="' . esc_url( home_url() ) . '">' . strtoupper( get_bloginfo( 'name' ) ) . '</a>', $copyright );
				$copyright = str_replace( '{{theme}}', '<a href="' . $theme_info->get('ThemeURI') . '">' . $theme_info->get('Name') . '</a>', $copyright );
				$copyright = str_replace( '{{themeauthor}}', '<a href="' . $theme_info->get('AuthorURI') . '">' . $theme_info->get('Author') . '</a>', $copyright );
				?>
				<div class="<?php echo esc_attr( 'nanospace-footer-' . $element ); ?>">
					<div class="nanospace-footer-copyright-content"><?php echo do_shortcode( $copyright ); ?></div>
				</div>
				<?php
				break;

			case 'social':
				$types = nanospace_get_theme_mod( 'footer_social_links', array() );

				if ( ! empty( $types ) ) {
					$target = '_' . nanospace_get_theme_mod( 'footer_social_links_target' );
					$links  = array();

					foreach ( $types as $type ) {
						$url     = nanospace_get_theme_mod( 'social_' . $type );
						$links[] = array(
							'type'   => $type,
							'url'    => ! empty( $url ) ? $url : '#',
							'target' => $target,
						);
					}
					?>
					<ul class="<?php echo esc_attr( 'nanospace-footer-' . $element ); ?> menu">
						<?php nanospace_social_links( $links, array(
							'before_link' => '<li class="menu-item">',
							'after_link'  => '</li>',
							'link_class'  => 'nanospace-menu-icon',
						) ); ?>
					</ul>
					<?php
				}
				break;

			case 'html':
				$content = nanospace_get_theme_mod( 'footer_' . $key . '_content' );
				?>
				<div class="<?php echo esc_attr( 'nanospace-footer-' . $element ); ?> nanospace-bar-html-item">
					<div><?php echo do_shortcode( $content ); ?></div>
				</div>
				<?php
				break;

			case 'widget':
				$content = nanospace_get_theme_mod( 'footer_' . $key . '_content' );
				?>
				<div class="<?php echo esc_attr( 'nanospace-footer-' . $element ); ?>">
					<div><?php echo do_shortcode( $content ); ?></div>
				</div>
				<?php
				break;
		}
		$html = ob_get_clean();

		// Filters to modify the final HTML tag.
		$html = apply_filters( 'nanospace_frontend_footer_element', $html, $element );
		$html = apply_filters( 'nanospace_frontend_footer_element_' . $element, $html );

		echo $html; // WPCS: XSS OK
	}
endif;

/**
 * ====================================================
 * All index pages template functions
 * ====================================================
 */

if ( ! function_exists( 'nanospace_loop_navigation' ) ) :
	/**
	 * Render posts loop navigation.
	 */
	function nanospace_loop_navigation() {
		if ( ! is_archive() && ! is_home() && ! is_search() ) {
			return;
		}

		// Render posts navigation.
		switch ( nanospace_get_theme_mod( 'blog_index_navigation_mode' ) ) {
			case 'pagination':
				the_posts_pagination( array(
					'mid_size'  => 3,
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
				) );
				break;

			default:
				the_posts_navigation( array(
					'prev_text' => esc_html__( 'Older Posts', 'nanospace' ) . ' &raquo;',
					'next_text' => '&laquo; ' . esc_html__( 'Newer Posts', 'nanospace' ),
				) );
				break;
		}
	}
endif;

/**
 * ====================================================
 * Single post template functions
 * ====================================================
 */

if ( ! function_exists( 'nanospace_single_post_author_bio' ) ) :
	/**
	 * Render author bio block in single post page.
	 */
	function nanospace_single_post_author_bio() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		?>
		<div class="entry-author">
			<div class="entry-author-body">
				<div class="entry-author-name vcard">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'nanospace_frontend_entry_author_bio_avatar_size', 80 ), '', get_the_author_meta( 'display_name' ) ); ?>
					<b class="fn"><?php the_author_posts_link(); ?></b>
				</div>
				<div class="entry-author-content">
					<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_single_post_navigation' ) ) :
	/**
	 * Render prev / next post navigation in single post page.
	 */
	function nanospace_single_post_navigation() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		the_post_navigation( array(
			'prev_text' => esc_html__( '%title &raquo;', 'nanospace' ),
			'next_text' => esc_html__( '&laquo; %title', 'nanospace' ),
		) );
	}
endif;

if ( ! function_exists( 'nanospace_comments_title' ) ) :
	/**
	 * Render comments title.
	 */
	function nanospace_comments_title() {
		?>
		<h2 class="comments-title">
			<?php
			$comments_count = get_comments_number();
			if ( '1' === $comments_count ) {
				printf(
				/* translators: %1$s: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'nanospace' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf(
				/* translators: %1$s: comment count number, %2$s: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comments_count, 'comments title', 'nanospace' ) ),
					number_format_i18n( $comments_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h2>
		<?php
	}
endif;

if ( ! function_exists( 'nanospace_comments_closed' ) ) :
	/**
	 * Render comments closed message.
	 */
	function nanospace_comments_closed() {
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'nanospace' ); ?></p>
		<?php endif;
	}
endif;

/**
 * ====================================================
 * Customizer's partial refresh callback aliases
 * ====================================================
 */

function nanospace_header_element__html_1() {
	nanospace_header_element( 'html-1' );
}

function nanospace_header_element__html_2() {
	nanospace_header_element( 'html-2' );
}

function nanospace_header_element__html_3() {
	nanospace_header_element( 'html-3' );
}

function nanospace_header_element__html_4() {
	nanospace_header_element( 'html-4' );
}

function nanospace_header_element__html_5() {
	nanospace_header_element( 'html-5' );
}

function nanospace_header_element__html_6() {
	nanospace_header_element( 'html-6' );
}

function nanospace_header_element__html_7() {
	nanospace_header_element( 'html-7' );
}

function nanospace_header_element__button_1() {
	nanospace_header_element( 'button-1' );
}

function nanospace_header_element__button_2() {
	nanospace_header_element( 'button-2' );
}

function nanospace_header_element__button_3() {
	nanospace_header_element( 'button-3' );
}

function nanospace_header_element__button_4() {
	nanospace_header_element( 'button-4' );
}

function nanospace_header_element__button_5() {
	nanospace_header_element( 'button-5' );
}

function nanospace_header_element__button_6() {
	nanospace_header_element( 'button-6' );
}

function nanospace_header_element__button_7() {
	nanospace_header_element( 'button-7' );
}

function nanospace_header_element__social() {
	nanospace_header_element( 'social' );
}

function nanospace_footer_element__logo() {
	nanospace_footer_element( 'logo' );
}

function nanospace_footer_element__copyright() {
	nanospace_footer_element( 'copyright' );
}

function nanospace_footer_element__social() {
	nanospace_footer_element( 'social' );
}

/*-------*/

function nanospace_footer_element__html_1() {
	nanospace_footer_element( 'html-1' );
}

function nanospace_footer_element__html_2() {
	nanospace_footer_element( 'html-2' );
}

function nanospace_footer_element__html_3() {
	nanospace_footer_element( 'html-3' );
}

function nanospace_footer_element__html_4() {
	nanospace_footer_element( 'html-4' );
}

function nanospace_footer_element__html_5() {
	nanospace_footer_element( 'html-5' );
}

function nanospace_footer_element__html_6() {
	nanospace_footer_element( 'html-6' );
}

function nanospace_footer_element__html_7() {
	nanospace_footer_element( 'html-7' );
}

function nanospace_footer_element__html_8() {
	nanospace_footer_element( 'html-8' );
}

function nanospace_footer_element__html_9() {
	nanospace_footer_element( 'html-9' );
}

function nanospace_footer_element__widget_1() {
	nanospace_footer_element( 'widget-1' );
}

function nanospace_footer_element__widget_2() {
	nanospace_footer_element( 'widget-2' );
}

function nanospace_footer_element__widget_3() {
	nanospace_footer_element( 'widget-3' );
}

function nanospace_footer_element__widget_4() {
	nanospace_footer_element( 'widget-4' );
}

function nanospace_footer_element__widget_5() {
	nanospace_footer_element( 'widget-5' );
}

function nanospace_footer_element__widget_6() {
	nanospace_footer_element( 'widget-6' );
}

function nanospace_footer_element__widget_7() {
	nanospace_footer_element( 'widget-7' );
}

function nanospace_footer_element__widget_8() {
	nanospace_footer_element( 'widget-8' );
}

function nanospace_footer_element__widget_9() {
	nanospace_footer_element( 'widget-9' );
}

