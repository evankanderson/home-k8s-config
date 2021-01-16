<?php
/**
 * Customizer default values.
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$nanospace_colors = array(
	'transparent' => 'rgba(0,0,0,0)',
	'white'       => '#ffffff',
	'black'       => '#000000',
	'accent'      => '#213169',
	'bg'          => '#ffffff',
	'text'        => '#18211F',
	'heading'     => '#18211F',
	'meta'        => '#f9f9f9',
	'subtle'      => '#f6f6f6',
	'border'      => '#e5e5e5',
);

$nanospace_add = array();

/**
 * ====================================================
 * Header > Builder
 * ====================================================
 */

$nanospace_add['header_elements_top_left']      = array();
$nanospace_add['header_elements_top_center']    = array();
$nanospace_add['header_elements_top_right']     = array();
$nanospace_add['header_elements_main_left']     = array( 'logo' );
$nanospace_add['header_elements_main_center']   = array();
$nanospace_add['header_elements_main_right']    = array( 'menu-1', 'shopping-cart-dropdown' );
$nanospace_add['header_elements_bottom_left']   = array();
$nanospace_add['header_elements_bottom_center'] = array();
$nanospace_add['header_elements_bottom_right']  = array();

$nanospace_add['header_vertical_elements_top_left']     = array( 'vertical-logo' );
$nanospace_add['header_vertical_elements_main_center']  = array( 'html-1' );
$nanospace_add['header_vertical_elements_bottom_right'] = array( 'button-1' );

$nanospace_add['header_mobile_elements_main_left']    = array( 'mobile-logo' );
$nanospace_add['header_mobile_elements_main_center']  = array();
$nanospace_add['header_mobile_elements_main_right']   = array( 'shopping-cart-link', 'mobile-vertical-toggle' );
$nanospace_add['header_mobile_elements_vertical_top'] = array( 'search-bar', 'mobile-menu' );
/**
 * ====================================================
 * Header > HTML
 * ====================================================
 */

$nanospace_add['header_html_1_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['header_html_2_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['header_html_3_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['header_html_4_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['header_html_5_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['header_html_6_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['header_html_7_content'] = __( 'Insert HTML text here', 'nanospace' );

/**
 * ====================================================
 * Header > BUTTON
 * ====================================================
 */

$nanospace_add['header_button_1_id']       = '';
$nanospace_add['header_button_1_link']     = '#';
$nanospace_add['header_button_1_text']     = __( 'Button', 'nanospace' );
$nanospace_add['header_button_1_class']    = '';
$nanospace_add['header_button_1_target']   = 'self';
$nanospace_add['header_button_1_alt_text'] = 'button-1';

$nanospace_add['header_button_2_id']       = '';
$nanospace_add['header_button_2_link']     = '#';
$nanospace_add['header_button_2_text']     = __( 'Button', 'nanospace' );
$nanospace_add['header_button_2_class']    = '';
$nanospace_add['header_button_2_target']   = 'self';
$nanospace_add['header_button_2_alt_text'] = 'button-2';

$nanospace_add['header_button_3_id']       = '';
$nanospace_add['header_button_3_link']     = '#';
$nanospace_add['header_button_3_text']     = __( 'Button', 'nanospace' );
$nanospace_add['header_button_3_class']    = '';
$nanospace_add['header_button_3_target']   = 'self';
$nanospace_add['header_button_3_alt_text'] = 'button-3';

$nanospace_add['header_button_4_id']       = '';
$nanospace_add['header_button_4_link']     = '#';
$nanospace_add['header_button_4_text']     = __( 'Button', 'nanospace' );
$nanospace_add['header_button_4_class']    = '';
$nanospace_add['header_button_4_target']   = 'self';
$nanospace_add['header_button_4_alt_text'] = 'button-4';

$nanospace_add['header_button_5_id']       = '';
$nanospace_add['header_button_5_link']     = '#';
$nanospace_add['header_button_5_text']     = __( 'Button', 'nanospace' );
$nanospace_add['header_button_5_class']    = '';
$nanospace_add['header_button_5_target']   = 'self';
$nanospace_add['header_button_5_alt_text'] = 'button-5';

$nanospace_add['header_button_6_id']       = '';
$nanospace_add['header_button_6_link']     = '#';
$nanospace_add['header_button_6_text']     = __( 'Button', 'nanospace' );
$nanospace_add['header_button_6_class']    = '';
$nanospace_add['header_button_6_target']   = 'self';
$nanospace_add['header_button_6_alt_text'] = 'button-6';

$nanospace_add['header_button_7_id']       = '';
$nanospace_add['header_button_7_link']     = '#';
$nanospace_add['header_button_7_text']     = __( 'Button', 'nanospace' );
$nanospace_add['header_button_7_class']    = '';
$nanospace_add['header_button_7_target']   = 'self';
$nanospace_add['header_button_7_alt_text'] = 'button-7';
/**
 * ====================================================
 * Header > Logo
 * ====================================================
 */

$nanospace_add['header_logo_width']        = '100px';
$nanospace_add['header_mobile_logo_width'] = '100px';

/**
 * ====================================================
 * Header > Search
 * ====================================================
 */

$nanospace_add['header_search_bar_width']      = '300px';

/**
 * ====================================================
 * Header > Cart
 * ====================================================
 */

$nanospace_add['header_cart_count_bg_color']   = '';
$nanospace_add['header_cart_count_text_color'] = $nanospace_colors['white'];

/**
 * ====================================================
 * Header > Social
 * ====================================================
 */

$nanospace_add['header_social_links']        = array( 'facebook', 'twitter', 'instagram' );
$nanospace_add['header_social_links_target'] = 'self';

/**
 * ====================================================
 * Header > Header layout
 * ====================================================
 */

$nanospace_add['nanospace_header_enable']                      = 1;
$nanospace_add['nanospace_section_header_layout_select']       = 'standard-header';
$nanospace_add['nanospace_section_header_off_canvas_position'] = 'left';
$nanospace_add['header_mobile_vertical_bar_alignment']         = 'left';
$nanospace_add['vertical_header_bg_color']                     = '';
$nanospace_add['off_canvas_header_bg_color']                   = '';
$nanospace_add['off_canvas_text_color']                        = '';

/**
 * ====================================================
 * Header > Top Bar
 * ====================================================
 */

$nanospace_add['header_top_bar_merged']     = 0;
$nanospace_add['header_top_bar_merged_gap'] = '0px';

$nanospace_add['header_top_bar_container'] = 'default';
$nanospace_add['header_top_bar_height']    = '80px';
$nanospace_add['header_top_bar_padding']   = '0px 20px 0px 20px';
$nanospace_add['header_top_bar_border']    = '0px 0px 1px 0px';

$nanospace_add['header_top_bar_items_gutter'] = '12px';

$nanospace_add['header_top_bar_font_family']    = '';
$nanospace_add['header_top_bar_font_weight']    = '';
$nanospace_add['header_top_bar_font_style']     = '';
$nanospace_add['header_top_bar_text_transform'] = '';
$nanospace_add['header_top_bar_font_size']      = '';
$nanospace_add['header_top_bar_line_height']    = '';
$nanospace_add['header_top_bar_letter_spacing'] = '';

$nanospace_add['header_top_bar_menu_font_family']    = '';
$nanospace_add['header_top_bar_menu_font_weight']    = '';
$nanospace_add['header_top_bar_menu_font_style']     = '';
$nanospace_add['header_top_bar_menu_text_transform'] = '';
$nanospace_add['header_top_bar_menu_font_size']      = '';
$nanospace_add['header_top_bar_menu_line_height']    = '';
$nanospace_add['header_top_bar_menu_letter_spacing'] = '';

$nanospace_add['header_top_bar_menu_highlight'] = 'none';

$nanospace_add['header_top_bar_submenu_font_family']    = '';
$nanospace_add['header_top_bar_submenu_font_weight']    = '';
$nanospace_add['header_top_bar_submenu_font_style']     = '';
$nanospace_add['header_top_bar_submenu_text_transform'] = '';
$nanospace_add['header_top_bar_submenu_font_size']      = '';
$nanospace_add['header_top_bar_submenu_line_height']    = '';
$nanospace_add['header_top_bar_submenu_letter_spacing'] = '';

$nanospace_add['header_top_bar_icon_size'] = '18px';

$nanospace_add['header_top_bar_bg_color']               = '';
$nanospace_add['header_top_bar_border_color']           = '';
$nanospace_add['header_top_bar_text_color']             = '';
$nanospace_add['header_top_bar_link_text_color']        = '';
$nanospace_add['header_top_bar_link_hover_text_color']  = '';
$nanospace_add['header_top_bar_link_active_text_color'] = '';

$nanospace_add['header_top_bar_submenu_bg_color']               = '';
$nanospace_add['header_top_bar_submenu_border_color']           = '';
$nanospace_add['header_top_bar_submenu_text_color']             = '';
$nanospace_add['header_top_bar_submenu_link_text_color']        = '';
$nanospace_add['header_top_bar_submenu_link_hover_text_color']  = '';
$nanospace_add['header_top_bar_submenu_link_active_text_color'] = '';

$nanospace_add['header_top_bar_menu_hover_highlight_color']       = $nanospace_colors['border'];
$nanospace_add['header_top_bar_menu_hover_highlight_text_color']  = '';
$nanospace_add['header_top_bar_menu_active_highlight_color']      = '';
$nanospace_add['header_top_bar_menu_active_highlight_text_color'] = '';

/**
 * ====================================================
 * Header > Main (Logo) Bar
 * ====================================================
 */

$nanospace_add['header_main_bar_container'] = 'full-width';
$nanospace_add['header_main_bar_height']    = '80px';
$nanospace_add['header_main_bar_padding']   = '0px 20px 0px 20px';
$nanospace_add['header_main_bar_border']    = '0px 0px 1px 0px';

$nanospace_add['header_main_bar_items_gutter'] = '12px';

$nanospace_add['header_main_bar_font_family']    = '';
$nanospace_add['header_main_bar_font_weight']    = '';
$nanospace_add['header_main_bar_font_style']     = '';
$nanospace_add['header_main_bar_text_transform'] = '';
$nanospace_add['header_main_bar_font_size']      = '';
$nanospace_add['header_main_bar_line_height']    = '';
$nanospace_add['header_main_bar_letter_spacing'] = '';

$nanospace_add['header_main_bar_menu_font_family']    = '';
$nanospace_add['header_main_bar_menu_font_weight']    = '';
$nanospace_add['header_main_bar_menu_font_style']     = '';
$nanospace_add['header_main_bar_menu_text_transform'] = '';
$nanospace_add['header_main_bar_menu_font_size']      = '';
$nanospace_add['header_main_bar_menu_line_height']    = '';
$nanospace_add['header_main_bar_menu_letter_spacing'] = '';

$nanospace_add['header_main_bar_menu_highlight'] = 'none';

$nanospace_add['header_main_bar_submenu_font_family']    = '';
$nanospace_add['header_main_bar_submenu_font_weight']    = '';
$nanospace_add['header_main_bar_submenu_font_style']     = '';
$nanospace_add['header_main_bar_submenu_text_transform'] = '';
$nanospace_add['header_main_bar_submenu_font_size']      = '';
$nanospace_add['header_main_bar_submenu_line_height']    = '';
$nanospace_add['header_main_bar_submenu_letter_spacing'] = '';

$nanospace_add['header_main_bar_icon_size'] = '18px';

$nanospace_add['header_main_bar_bg_color']               = '';
$nanospace_add['header_main_bar_border_color']           = '';
$nanospace_add['header_main_bar_text_color']             = '';
$nanospace_add['header_main_bar_link_text_color']        = '';
$nanospace_add['header_main_bar_link_hover_text_color']  = '';
$nanospace_add['header_main_bar_link_active_text_color'] = '';

$nanospace_add['header_main_bar_submenu_bg_color']               = '';
$nanospace_add['header_main_bar_submenu_border_color']           = '';
$nanospace_add['header_main_bar_submenu_text_color']             = '';
$nanospace_add['header_main_bar_submenu_link_text_color']        = '';
$nanospace_add['header_main_bar_submenu_link_hover_text_color']  = '';
$nanospace_add['header_main_bar_submenu_link_active_text_color'] = '';

$nanospace_add['header_main_bar_menu_hover_highlight_color']       = $nanospace_colors['transparent'];
$nanospace_add['header_main_bar_menu_hover_highlight_text_color']  = '';
$nanospace_add['header_main_bar_menu_active_highlight_color']      = '';
$nanospace_add['header_main_bar_menu_active_highlight_text_color'] = '';

/**
 * ====================================================
 * Header > Bottom Bar
 * ====================================================
 */

$nanospace_add['header_bottom_bar_merged']     = 0;
$nanospace_add['header_bottom_bar_merged_gap'] = '0px';

$nanospace_add['header_bottom_bar_container'] = 'default';
$nanospace_add['header_bottom_bar_height']    = '60px';
$nanospace_add['header_bottom_bar_padding']   = '0px 20px 0px 20px';
$nanospace_add['header_bottom_bar_border']    = '0px 0px 1px 0px';

$nanospace_add['header_bottom_bar_items_gutter'] = '12px';

$nanospace_add['header_bottom_bar_font_family']    = '';
$nanospace_add['header_bottom_bar_font_weight']    = '';
$nanospace_add['header_bottom_bar_font_style']     = '';
$nanospace_add['header_bottom_bar_text_transform'] = '';
$nanospace_add['header_bottom_bar_font_size']      = '';
$nanospace_add['header_bottom_bar_line_height']    = '';
$nanospace_add['header_bottom_bar_letter_spacing'] = '';

$nanospace_add['header_bottom_bar_menu_font_family']    = '';
$nanospace_add['header_bottom_bar_menu_font_weight']    = '';
$nanospace_add['header_bottom_bar_menu_font_style']     = '';
$nanospace_add['header_bottom_bar_menu_text_transform'] = '';
$nanospace_add['header_bottom_bar_menu_font_size']      = '';
$nanospace_add['header_bottom_bar_menu_line_height']    = '';
$nanospace_add['header_bottom_bar_menu_letter_spacing'] = '';

$nanospace_add['header_bottom_bar_menu_highlight'] = 'none';

$nanospace_add['header_bottom_bar_submenu_font_family']    = '';
$nanospace_add['header_bottom_bar_submenu_font_weight']    = '';
$nanospace_add['header_bottom_bar_submenu_font_style']     = '';
$nanospace_add['header_bottom_bar_submenu_text_transform'] = '';
$nanospace_add['header_bottom_bar_submenu_font_size']      = '';
$nanospace_add['header_bottom_bar_submenu_line_height']    = '';
$nanospace_add['header_bottom_bar_submenu_letter_spacing'] = '';

$nanospace_add['header_bottom_bar_icon_size'] = '18px';

$nanospace_add['header_bottom_bar_bg_color']               = '';
$nanospace_add['header_bottom_bar_border_color']           = '';
$nanospace_add['header_bottom_bar_text_color']             = '';
$nanospace_add['header_bottom_bar_link_text_color']        = '';
$nanospace_add['header_bottom_bar_link_hover_text_color']  = '';
$nanospace_add['header_bottom_bar_link_active_text_color'] = '';

$nanospace_add['header_bottom_bar_submenu_bg_color']               = '';
$nanospace_add['header_bottom_bar_submenu_border_color']           = '';
$nanospace_add['header_bottom_bar_submenu_text_color']             = '';
$nanospace_add['header_bottom_bar_submenu_link_text_color']        = '';
$nanospace_add['header_bottom_bar_submenu_link_hover_text_color']  = '';
$nanospace_add['header_bottom_bar_submenu_link_active_text_color'] = '';

$nanospace_add['header_bottom_bar_menu_hover_highlight_color']       = $nanospace_colors['border'];
$nanospace_add['header_bottom_bar_menu_hover_highlight_text_color']  = '';
$nanospace_add['header_bottom_bar_menu_active_highlight_color']      = '';
$nanospace_add['header_bottom_bar_menu_active_highlight_text_color'] = '';

/**
 * ====================================================
 * Header > Mobile Main Bar
 * ====================================================
 */

$nanospace_add['header_mobile_main_bar_height']          = '60px';
$nanospace_add['header_mobile_main_bar_padding__tablet'] = '0px 20px 0px 20px';
$nanospace_add['header_mobile_main_bar_border']          = '0px 0px 1px 0px';

$nanospace_add['header_mobile_main_bar_items_gutter'] = '12px';

$nanospace_add['header_mobile_main_bar_icon_size'] = '18px';

$nanospace_add['header_mobile_main_bar_bg_color']              = '';
$nanospace_add['header_mobile_main_bar_border_color']          = '';
$nanospace_add['header_mobile_main_bar_link_text_color']       = '';
$nanospace_add['header_mobile_main_bar_link_hover_text_color'] = '';

/**
 * ====================================================
 * Header > Mobile Drawer
 * ====================================================
 */

$nanospace_add['header_mobile_vertical_bar_position']  = 'left';
$nanospace_add['header_mobile_vertical_bar_alignment'] = 'left';
$nanospace_add['header_mobile_vertical_bar_width']     = '300px';
$nanospace_add['header_mobile_vertical_bar_padding']   = '30px 30px 30px 30px';

$nanospace_add['header_mobile_vertical_bar_items_gutter'] = '12px';

$nanospace_add['header_mobile_vertical_bar_font_family']    = '';
$nanospace_add['header_mobile_vertical_bar_font_weight']    = '';
$nanospace_add['header_mobile_vertical_bar_font_style']     = '';
$nanospace_add['header_mobile_vertical_bar_text_transform'] = '';
$nanospace_add['header_mobile_vertical_bar_font_size']      = '';
$nanospace_add['header_mobile_vertical_bar_line_height']    = '';
$nanospace_add['header_mobile_vertical_bar_letter_spacing'] = '';

$nanospace_add['header_mobile_vertical_bar_menu_font_family']    = '';
$nanospace_add['header_mobile_vertical_bar_menu_font_weight']    = '';
$nanospace_add['header_mobile_vertical_bar_menu_font_style']     = '';
$nanospace_add['header_mobile_vertical_bar_menu_text_transform'] = '';
$nanospace_add['header_mobile_vertical_bar_menu_font_size']      = '';
$nanospace_add['header_mobile_vertical_bar_menu_line_height']    = '';
$nanospace_add['header_mobile_vertical_bar_menu_letter_spacing'] = '';

$nanospace_add['header_mobile_vertical_bar_submenu_font_family']    = '';
$nanospace_add['header_mobile_vertical_bar_submenu_font_weight']    = '';
$nanospace_add['header_mobile_vertical_bar_submenu_font_style']     = '';
$nanospace_add['header_mobile_vertical_bar_submenu_text_transform'] = '';
$nanospace_add['header_mobile_vertical_bar_submenu_font_size']      = '';
$nanospace_add['header_mobile_vertical_bar_submenu_line_height']    = '';
$nanospace_add['header_mobile_vertical_bar_submenu_letter_spacing'] = '';

$nanospace_add['header_mobile_vertical_bar_icon_size'] = '18px';

$nanospace_add['header_mobile_vertical_bar_bg_color']               = '';
$nanospace_add['header_mobile_vertical_bar_border_color']           = '';
$nanospace_add['header_mobile_vertical_bar_text_color']             = '';
$nanospace_add['header_mobile_vertical_bar_link_text_color']        = '';
$nanospace_add['header_mobile_vertical_bar_link_hover_text_color']  = '';
$nanospace_add['header_mobile_vertical_bar_link_active_text_color'] = '';

/**
 * ====================================================
 * Footer > Builder
 * ====================================================
 */

$nanospace_add['nanospace_footer_enable']       = 1;
$nanospace_add['footer_widgets_bar'] = 0;

$nanospace_add['footer_elements_top_left']      = array();
$nanospace_add['footer_elements_top_center']    = array();
$nanospace_add['footer_elements_top_right']     = array();
$nanospace_add['footer_elements_bottom_left']   = array();
$nanospace_add['footer_elements_bottom_center'] = array( 'copyright' );
$nanospace_add['footer_elements_bottom_right']  = array();

/**
 * ====================================================
 * Footer > Widgets Bar
 * ====================================================
 */

$nanospace_add['footer_widgets_bar_container'] = 'default';
$nanospace_add['footer_widgets_bar_padding']   = '60px 20px 60px 20px';
$nanospace_add['footer_widgets_bar_border']    = '1px 0px 0px 0px';

$nanospace_add['footer_widgets_bar_columns_gutter'] = '15px';
$nanospace_add['footer_widgets_bar_widgets_gap']    = '40px';

$nanospace_add['footer_widgets_bar_font_family']    = '';
$nanospace_add['footer_widgets_bar_font_weight']    = '';
$nanospace_add['footer_widgets_bar_font_style']     = '';
$nanospace_add['footer_widgets_bar_text_transform'] = '';
$nanospace_add['footer_widgets_bar_font_size']      = '';
$nanospace_add['footer_widgets_bar_line_height']    = '';
$nanospace_add['footer_widgets_bar_letter_spacing'] = '';

$nanospace_add['footer_widgets_bar_widget_title_font_family']    = '';
$nanospace_add['footer_widgets_bar_widget_title_font_weight']    = '';
$nanospace_add['footer_widgets_bar_widget_title_font_style']     = '';
$nanospace_add['footer_widgets_bar_widget_title_text_transform'] = '';
$nanospace_add['footer_widgets_bar_widget_title_font_size']      = '';
$nanospace_add['footer_widgets_bar_widget_title_line_height']    = '';
$nanospace_add['footer_widgets_bar_widget_title_letter_spacing'] = '';

$nanospace_add['footer_widgets_bar_widget_title_alignment']  = 'left';
$nanospace_add['footer_widgets_bar_widget_title_decoration'] = 'border-bottom';

$nanospace_add['footer_widgets_bar_bg_color']                  = $nanospace_colors['subtle'];
$nanospace_add['footer_widgets_bar_border_color']              = '';
$nanospace_add['footer_widgets_bar_text_color']                = '';
$nanospace_add['footer_widgets_bar_link_text_color']           = '';
$nanospace_add['footer_widgets_bar_link_hover_text_color']     = '';
$nanospace_add['footer_widgets_bar_widget_title_text_color']   = '';
$nanospace_add['footer_widgets_bar_widget_title_bg_color']     = '';
$nanospace_add['footer_widgets_bar_widget_title_border_color'] = '';
/**
 * ====================================================
 * Footer > Top Bar
 * ====================================================
 */

$nanospace_add['footer_top_bar_merged']     = 0;
$nanospace_add['footer_top_bar_merged_gap'] = '0px';

$nanospace_add['footer_top_bar_container']    = 'default';
$nanospace_add['footer_top_bar_padding']      = '25px 20px 25px 20px';
$nanospace_add['footer_top_bar_border']       = '1px 0px 0px 0px';
$nanospace_add['footer_top_bar_items_gutter'] = '12px';

$nanospace_add['footer_top_bar_font_family']    = '';
$nanospace_add['footer_top_bar_font_weight']    = '';
$nanospace_add['footer_top_bar_font_style']     = '';
$nanospace_add['footer_top_bar_text_transform'] = '';
$nanospace_add['footer_top_bar_font_size']      = '';
$nanospace_add['footer_top_bar_line_height']    = '';
$nanospace_add['footer_top_bar_letter_spacing'] = '';

$nanospace_add['footer_top_bar_bg_color']              = $nanospace_colors['subtle'];
$nanospace_add['footer_top_bar_border_color']          = '';
$nanospace_add['footer_top_bar_text_color']            = '';
$nanospace_add['footer_top_bar_link_text_color']       = '';
$nanospace_add['footer_top_bar_link_hover_text_color'] = '';

/**
 * ====================================================
 * Footer > Bottom Bar
 * ====================================================
 */

$nanospace_add['footer_bottom_bar_merged']     = 0;
$nanospace_add['footer_bottom_bar_merged_gap'] = '0px';

$nanospace_add['footer_bottom_bar_container']    = 'default';
$nanospace_add['footer_bottom_bar_padding']      = '25px 20px 25px 20px';
$nanospace_add['footer_bottom_bar_border']       = '1px 0px 0px 0px';
$nanospace_add['footer_bottom_bar_items_gutter'] = '12px';

$nanospace_add['footer_bottom_bar_font_family']    = '';
$nanospace_add['footer_bottom_bar_font_weight']    = '';
$nanospace_add['footer_bottom_bar_font_style']     = '';
$nanospace_add['footer_bottom_bar_text_transform'] = '';
$nanospace_add['footer_bottom_bar_font_size']      = '';
$nanospace_add['footer_bottom_bar_line_height']    = '';
$nanospace_add['footer_bottom_bar_letter_spacing'] = '';

$nanospace_add['footer_bottom_bar_bg_color']              = $nanospace_colors['subtle'];
$nanospace_add['footer_bottom_bar_border_color']          = '';
$nanospace_add['footer_bottom_bar_text_color']            = '';
$nanospace_add['footer_bottom_bar_link_text_color']       = '';
$nanospace_add['footer_bottom_bar_link_hover_text_color'] = '';

/**
 * ====================================================
 * Footer > Copyright
 * ====================================================
 */

$nanospace_add['footer_copyright_content'] = 'Copyright &copy; {{year}} {{sitename}} &mdash; Powered by {{theme}}';

/**
 * ====================================================
 * Footer > Social
 * ====================================================
 */

$nanospace_add['footer_social_links']        = array( 'facebook', 'twitter', 'instagram' );
$nanospace_add['footer_social_links_target'] = 'self';

/**
 * ====================================================
 * Footer > Widget
 * ====================================================
 */

$nanospace_add['footer_widget_1_content'] = array();
$nanospace_add['footer_widget_2_content'] = array();
$nanospace_add['footer_widget_3_content'] = array();
$nanospace_add['footer_widget_4_content'] = array();
$nanospace_add['footer_widget_5_content'] = array();
$nanospace_add['footer_widget_6_content'] = array();
$nanospace_add['footer_widget_7_content'] = array();
$nanospace_add['footer_widget_8_content'] = array();
$nanospace_add['footer_widget_9_content'] = array();
/**
 * ====================================================
 * Footer > Html
 * ====================================================
 */

$nanospace_add['footer_html_1_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['footer_html_2_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['footer_html_3_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['footer_html_4_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['footer_html_5_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['footer_html_6_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['footer_html_7_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['footer_html_8_content'] = __( 'Insert HTML text here', 'nanospace' );
$nanospace_add['footer_html_9_content'] = __( 'Insert HTML text here', 'nanospace' );

$nanospace_defaults = array_merge_recursive( $nanospace_defaults, $nanospace_add );
