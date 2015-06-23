<?php
/**
 * Hook into the Customify's fields and settings
 * @param $options array - Contains the plugin's options array right before they are used, so edit with care
 *
 * @return mixed
 */
if ( ! function_exists( 'timber_add_customify_options' ) ) :
	function timber_add_customify_options( $options ) {

		$options['opt-name'] = 'timber_options';

		// @TODO for the momment keep it empty
		$options['sections'] = array();

		$options['panels'] = array(

			'style' => array(
				'title'    => __( 'Style', 'timber' ),
				'sections' => array(
					'presets_section' => array(
						'title'    => __( 'Style Presets', 'timber' ),
						'options' => array(
							'theme_style'   => array(
								'type'      => 'preset',
								'label'     => __( 'Select a style:', 'timber' ),
								'desc' => __( 'Conveniently change the design of your site with built-in style presets. Easy as pie.', 'timber' ),
								'default'   => 'timber',
								'choices_type' => 'awesome',
								'choices'  => array(
									'timber' => array(
										'label' => __( 'Patch', 'timber' ),
										'preview' => array(
											'color-text' => '#ffffff',
											'background-card' => '#121012',
											'background-label' => '#fee900',
											'font-main' => 'Oswald',
											'font-alt' => 'Roboto',
										),
										'options' => array(
											'accent_color' => '#ffeb00',
											'headings_color' => '#171617',
											'body_color' => '#3d3e40',
											'headings_font' => 'Oswald',
											'headings_caps' => true,
											'body_font' => 'Roboto',
										)
									),


									'adler' => array(
										'label' => __( 'Adler', 'timber' ),
										'preview' => array(
											'color-text' => '#fff',
											'background-card' => '#0e364f',
											'background-label' => '#000000',
											'font-main' => 'Permanent Marker',
											'font-alt' => 'Droid Sans Mono',
										),
										'options' => array(
											'accent_color' => '#68f3c8',
											'headings_color' => '#0e364f',
											'body_color' => '#45525a',
											'headings_font' => 'Permanent Marker',
											'headings_caps' => true,
											'body_font' => 'Droid Sans Mono'
										)
									),

									'royal' => array(
										'label' => __( 'Royal', 'timber' ),
										'preview' => array(
											'color-text' => '#ffffff',
											'background-card' => '#615375',
											'background-label' => '#46414c',
											'font-main' => 'Abril Fatface',
											'font-alt' => 'PT Serif',
										),
										'options' => array(
											'accent_color' => '#8eb2c5',
											'headings_color' => '#725c92',
											'body_color' => '#6f8089',
											'headings_font' => 'Abril Fatface',
											'headings_caps' => false,
											'body_font' => 'PT Serif',
										)
									),

									'queen' => array(
										'label' => __( 'Queen', 'timber' ),
										'preview' => array(
											'color-text' => '#fbedec',
											'background-card' => '#a33b61',
											'background-label' => '#41212a',
											'font-main' => 'Playfair Display',
											'font-alt' => 'Merriweather',
										),
										'options' => array(
											'accent_color' => '#c17390',
											'headings_color' => '#a33b61',
											'body_color' => '#403b3c',
											'headings_font' => 'Playfair Display',
											'headings_caps' => false,
											'body_font' => 'Merriweather',
										)
									),
									'carrot' => array(
										'label' => __( 'Carrot', 'timber' ),
										'preview' => array(
											'color-text' => '#ffffff',
											'background-card' => '#df421d',
											'background-label' => '#85210a',
											'font-main' => 'Oswald',
											'font-alt' => 'PT Sans Narrow',
										),
										'options' => array(
											'accent_color' => '#df421d',
											'headings_color' => '#df421d',
											'body_color' => '#7e7e7e',
											'headings_font' => 'Oswald',
											'headings_caps' => false,
											'body_font' => 'PT Sans Narrow',
										)
									),
									'velvet' => array(
										'label' => __( 'Velvet', 'timber' ),
										'preview' => array(
											'color-text' => '#ffffff',
											'background-card' => '#282828',
											'background-label' => '#000000',
											'font-main' => 'Pinyon Script',
											'font-alt' => 'Josefin Sans',
										),
										'options' => array(
											'accent_color' => '#000000',
											'headings_color' => '#000000',
											'body_color' => '#000000',
											'headings_font' => 'Pinyon Script',
											'headings_caps' => false,
											'body_font' => 'Josefin Sans',
										)
									),

								)
							),
						)
					),
					/**
					 * COLORS - This section will handle different elements colors (eg. links, headings)
					 */
					'colors_section' => array(
						'title'    => __( 'Colors', 'timber' ),
						'options' => array(
							'accent_color'   => array(
								'type'      => 'color',
								'label'     => __( 'Accent Color', 'timber' ),
								'live' => true,
								'default'   => '#ffeb00',
								'css'  => array(
									array(
										'property' => 'background-color',
										'selector' => 'h1.test',
									)
								),
							),
							'headings_color' => array(
								'type'      => 'color',
								'label'     => __( 'Headings Color', 'timber' ),
								'live' => true,
								'default'   => '#171617',
								'css'  => array(
									array(
										'property' => 'color',
										'selector' => 'h1.site-titletest',
									)
								)
							),
							'body_color'     => array(
								'type'      => 'color',
								'label'     => __( 'Body Color', 'timber' ),
								'live' => true,
								'default'   => '#3d3e40',
								'css'  => array(
									array(
										'selector' => 'body.testest',
										'property' => 'color'
									)
								)
							),
						)
					),
					/**
					 * FONTS - This section will handle different elements fonts (eg. headings, body)
					 */
					'typography_section' => array(
						'title'    => __( 'Fonts', 'timber' ),
						'options' => array(
							'headings_font' => array(
								'type'     => 'typography',
								'label'    => __( 'Headings', 'timber' ),
								'default'  => 'Oswald", sans-serif',
								'selector' => 'h1.testentry-meta',
								'font_weight' => false,
								'load_all_weights' => true,
								'subsets' => true,
								'recommended' => array(
									'Oswald',
									'Lato',
									'Open Sans',
									'Exo',
									'PT Sans',
									'Ubuntu',
									'Vollkorn',
									'Lora',
									'Arvo',
									'Josefin Slab',
									'Crete Round',
									'Kreon',
									'Bubblegum Sans',
									'The Girl Next Door',
									'Pacifico',
									'Handlee',
									'Satify',
									'Pompiere'
								)
							),
							'body_font'     => array(
								'type'    => 'typography',
								'label'   => __( 'Body Text', 'timber' ),
								'default' => 'Roboto, sans-serif',
								'selector' => 'body.testtest',
								'load_all_weights' => true,
								'recommended' => array(
									'Roboto',
									'Lato',
									'Open Sans',
									'PT Sans',
									'Cabin',
									'Gentium Book Basic',
									'PT Serif'
								)
							)
						)
					)
				)
			),

			'layout' => array(
				'title'    => __( 'Layout', 'timber' ),
				'sections' => array(
					'sizes' => array(
						'title'    => __( 'Sizes', 'timber' ),
						'options' => array(
							'test' => array(
								'title' => 'test',
								'type' => 'text'
							)
						)
					),
					'spaces' => array(
						'title'    => __( 'Spaces', 'timber' ),
						'options' => array(
							'test2' => array(
								'title' => 'test2',
								'type' => 'text'
							)
						)
					)
				)
			),

			'theme_options' => array(
				'title'    => __( 'Theme Options', 'timber' ),
				'sections' => array(
					'general' => array (
						'title'    => __( 'General', 'timber' ),
						'options' => array(
							'use_smooth_scroll' => array(
								'type'     => 'checkbox',
								'label'    => __( 'Smooth Scrolling', 'timber' ),
								'desc' => __( 'Enable / Disable smooth scrolling.', 'timber' ),
								'default'  => true
							),
							'use_ajax_loading' => array(
								'type'     => 'checkbox',
								'label'    => __( 'AJAX Loading', 'timber' ),
								'desc' => __( 'Enable / Disable dynamic page content loading using AJAX.', 'timber' ),
								'default'  => true
							),
							'enable_copyright_overlay' => array(
								'type'     => 'checkbox',
								'label'    => __( 'Right-Click Protected ?', 'timber' ),
								'desc' => __( 'Prevent right-click saving for images.', 'timber' ),
								'default'  => true,
							),
						)
					),

					'branding' => array (
						'title'    => __( 'Branding', 'timber' ),
						'options' => array(
							'main_logo_light' => array(
								'type'     => 'image',
								'label'    => __( 'Main Logo (Dark)', 'timber' ),
								'subtitle' => __( 'If there is no image uploaded, plain text will be used instead (generated from the site\'s name).', 'timber' ),
							),
							'main_logo_dark' => array(
								'type'  => 'image',
								'label' => __( 'Logo Inversed (Light)', 'timber' ),
								'desc' => __( 'Upload an inverted color logo.', 'timber' )
							),
							'retina_main_logo_light' => array(
								'type'     => 'image',
								'label'    => __( '[Retina] Main Logo', 'timber' )
							),
							'retina_main_logo_dark' => array(
								'type'     => 'image',
								'label'    => __( '[Retina] Logo Inversed', 'timber' )
							),
							'favicon' => array(
								'type'     => 'image',
								'label'    => __( 'Favicon', 'timber' ),
								'desc' => __( 'Upload a 16 x 16px image that will be used as a favicon.', 'timber' ),
							),
						)
					),

					'share_settings' => array(
						'title'    => __( 'Share Settings', 'timber' ),
						'options' => array(
							'show_share_links' => array(
								'type'	=> 'checkbox',
								'default' => false,
								'label' => __( 'Show Share Links', 'timber' ),
							),
							'share_buttons_settings' => array(
								'type'	=> 'text',
								'default' => 'preferred,preferred,preferred,preferred,more',
								'label' => __( 'Share Services', 'timber' ),
								'desc' => __( 'Add here the share services you want to use, single comma delimited (no spaces). You can find the full list of services here: http://www.addthis.com/services/list. Also you can use the more tag to show the plus sign and the counter tag to show a global share counter.', 'timber' ),
							),
							'share_buttons_addthis_username' => array(
								'type'     => 'text',
								'label'    => __( 'AddThis Username', 'timber' ),
								'desc' => __( 'Enter here your AddThis username so you will receive analytics data.', 'timber' ),
								'default'  => '',
							),
							'share_buttons_ga_id' => array(
								'type'     => 'text',
								'label'    => __( 'GA Property ID', 'timber' ),
								'desc' => __( 'Enter here your GA property ID (generally a serial number of the form UA-xxxxxx-x).', 'timber' ),
								'default'  => '',
								'required' => array( 'share_buttons_enable_ga_tracking', '=', 1 ),
							),
							'share_buttons_enable_ga_social_tracking' => array(
								'type'     => 'checkbox',
								'label'    => __( 'GA Social Tracking', 'timber' ),
								'desc' => __( 'If you are using the latest version of GA code, you can take advantage of Google\'s new <a href="http://bit.ly/1iVvkbk">social interaction analytics</a>.', 'timber' ),
								'default'  => false,
							),
						)
					)
				)
			),
		);

		return $options;
	}
endif;

add_filter( 'customify_filter_fields', 'timber_add_customify_options' );

/**
 * Get the current PixCodes configuration and check if there is something new
 */
if ( ! function_exists( 'timber_pixcodes_setup' ) ) :
	function timber_pixcodes_setup() {

		$shortcodes = array(
			'Columns',
			'Button',
			'Icon',
			'Tabs',
			'Separator',
			'Slider',
		);

		// create an array with shortcodes which are needed by the
		// current theme
		$current_options = get_option( 'wpgrade_shortcodes_list' );
		if ( $current_options ) {
			$diff_added   = array_diff( $shortcodes, $current_options );
			$diff_removed = array_diff( $current_options, $shortcodes );
			if ( ( ! empty( $diff_added ) || ! empty( $diff_removed ) ) && is_admin() ) {
				update_option( 'wpgrade_shortcodes_list', $shortcodes );
			}
		} else { // there is no current shortcodes list
			update_option( 'wpgrade_shortcodes_list', $shortcodes );
		}

		// we need to remember the prefix of the metaboxes so it can be used
		// by the shortcodes plugin
		$current_prefix = get_option( 'wpgrade_metaboxes_prefix' );
		if ( empty( $current_prefix ) ) {
			update_option( 'wpgrade_metaboxes_prefix', '_timber_' );
		}
	}
endif; // end timber_pixcodes_setup

add_action( 'admin_head', 'timber_pixcodes_setup' );