<?php
/**
 * Menu Class
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Register
 * 20) Primary & Secondary
 * 30) Others
 */
class NanoSpace_Menu {
	/**
	 * 0) Init
	 */

	private static $instance;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	private function __construct() {

		self::register();
		// Actions
		add_action( 'nanospace_menu_footer_after', __CLASS__ . '::footer_search' );
		// Filters
		add_filter( 'walker_nav_menu_start_el', __CLASS__ . '::nav_menu_item_description', 20, 4 );
		add_filter( 'nav_menu_css_class', __CLASS__ . '::nav_menu_item_classes', 10, 4 );

	} // /__construct

	/**
	 * Register custom menus
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function register() {
		register_nav_menus( array(
			'header-menu-1'      => esc_html_x( 'Primary - (Customize ➤ Header Builder)', 'Navigational menu location', 'nanospace' ),
			'header-menu-2'      => esc_html_x( 'Secondary - (Customize ➤ Header Builder)', 'Navigational menu location', 'nanospace' ),
			'header-mobile-menu' => esc_html_x( 'Mobile Header Menu - (Customize ➤ Header Builder ➤ Tablet/Mobile)', 'Navigational menu location', 'nanospace' ),
			'footer-menu-1'      => esc_html_x( 'Footer - (Customize ➤ Footer Builder)', 'Navigational menu location', 'nanospace' ),

		) );

	} // /init
	/**
	 * 10) Register
	 */

	/**
	 * Initialization (get instance)
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	} // /register
	/**
	 * 20) Primary & Secondary
	 */

	/**
	 * Menu item modification: item description
	 *
	 * Primary and Secondary menu only.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $item_output Menu item output HTML (without closing `</li>`).
	 * @param  object $item The current menu item.
	 * @param  int $depth Depth of menu item. Used for padding. Since WordPress 4.1.
	 * @param  array $args An array of wp_nav_menu() arguments.
	 */
	public static function nav_menu_item_description( $item_output, $item, $depth, $args ) {
		if ( 'header-menu-1' === $args->theme_location && trim( $item->description ) ) {

			$item_output = str_replace(
				$args->link_after . '</a>',
				'<span class="menu-item-description">' . trim( $item->description ) . '</span>' . $args->link_after . '</a>',
				$item_output
			);

		}

		return $item_output;

	} // /nav_menu_item_description

	/**
	 * Navigation item classes
	 *
	 * Applies `has-description` classes on menu items.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $classes The CSS classes that are applied to the menu item's `<li>` element.
	 * @param  object $item The current menu item.
	 * @param  array $args An array of wp_nav_menu() arguments.
	 * @param  int $depth Depth of menu item. Used for padding. Since WordPress 4.1.
	 */
	public static function nav_menu_item_classes( $classes, $item, $args, $depth = 0 ) {

		if ( 'header-menu-1' === $args->theme_location && ! empty( $item->description ) ) {
			$classes[] = 'has-description';
		}

		return $classes;

	} // /nav_menu_item_classes

	/**
	 * 30) Others
	 */

	/**
	 * Footer
	 */

	/**
	 * Footer menu search form
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function footer_search() {

		get_search_form( true );

	} // /footer_search

} // /NanoSpace_Menu

add_action( 'after_setup_theme', 'NanoSpace_Menu::init' );
