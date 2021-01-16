<?php

/**
 * Beaver Builder: Helpers Class
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
 * 10) Is page builder active?
 */
class NanoSpace_Beaver_Builder_Helpers {
	/**
	 * 0) Init
	 */

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	private function __construct() {
	}
	/**
	 * 10) Is page builder enabled?
	 */

	/**
	 * Is page builder enabled on single post?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function is_builder_enabled() {
		if (
			! NanoSpace_Post::is_singular()
			|| ! is_callable( 'FLBuilderModel::is_builder_enabled' )
		) {
			return false;
		}


		return FLBuilderModel::is_builder_enabled();

	} // /is_builder_enabled
} // /NanoSpace_Beaver_Builder_Helpers
