<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rotativahq.com/
 * @since      1.0.0
 *
 * @package    Rotativa
 * @subpackage Rotativa/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rotativa
 * @subpackage Rotativa/admin
 * @author     RotativaHQ <info@rotativahq.com>
 */
class Rotativa_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function rotativa_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rotativa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rotativa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_style( $this->plugin_name . '-sweetalert2', plugin_dir_url( __FILE__ ) . 'css/sweetalert2.min.css', array(), '7.26.11', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rotativa-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function rotativa_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rotativa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rotativa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        $pdf_success = apply_filters( 'rotativa_pdf_success_be', [
            'title'        => esc_html__( 'Success!', 'rotativa' ),
            'description'  => esc_html__( 'We have successfully generated your PDF. You can click the button below to download it.', 'rotativa' ),
            'button_label' => esc_html__( 'Download PDF', 'rotativa' )
        ] );

        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( $this->plugin_name . '-sweetalert2', plugin_dir_url( __FILE__ ) . 'js/sweetalert2.min.js', array( 'jquery' ), '7.26.11', true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rotativa-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
        wp_localize_script(
            $this->plugin_name,
            'rotativa',
            [
            	'ajaxurl'     => admin_url( 'admin-ajax.php' ),
                'pdf_success' => $pdf_success
            ]
        );

	}

	/**
	 * Register the settings page for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function rotativa_register_settings_page() {

		add_submenu_page(
			'tools.php',
			__( 'Rotativa', 'rotativa' ),
			__( 'Rotativa', 'rotativa' ),
			'manage_options',
			'rotativa',
			[ $this, 'rotativa_display_settings_page' ]
		);

	}

	/**
	 * Display the settings page for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function rotativa_display_settings_page() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/rotativa-admin-display.php';

	}

	/**
	 * Register settings for our settings page.
	 *
	 * @since 1.0.0
	 */
	public function rotativa_register_settings() {

		register_setting(
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings',
			[ $this, 'rotativa_sandbox_register_settings' ]
		);

		add_settings_section(
			$this->plugin_name . '-settings-section',
			esc_html__( 'Rotativa Settings', 'rotativa' ),
			[ $this, 'rotativa_sandbox_add_settings_section' ],
			$this->plugin_name . '-settings'
		);

		add_settings_section(
			$this->plugin_name . '-styling-section',
			esc_html__( 'Rotativa Styling', 'rotativa' ),
			[ $this, 'rotativa_sandbox_add_settings_section' ],
			$this->plugin_name . '-settings'
		);

		add_settings_field(
			'post-types',
			esc_html__( 'Post Types', 'rotativa' ),
			[ $this, 'rotativa_sandbox_add_settings_field_multiple_checkbox' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			[
				'label_for'   => 'post-types',
				'description' => esc_html__( 'Check post types were you want to show Rotativa Interface for Converting HTML to PDF.', 'rotativa' )
			]
		);

		add_settings_field(
			'api-key',
			esc_html__( 'API Key', 'rotativa' ),
			[ $this, 'rotativa_sandbox_add_settings_field_input_general' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			[
				'label_for'   => 'api-key',
				'description' => wp_kses( __( 'Please enter your API Key. You can get it from <a href="https://rotativahq.com/" target="_blank">here</a>.', 'rotativa' ), [ 'a' => [ 'href' => [], 'target' => [] ] ] ),
				'type'        => 'password'
			]
		);

		add_settings_field(
			'end-point-location',
			esc_html__( 'Endpoint Location', 'rotativa' ),
			[ $this, 'rotativa_sandbox_add_settings_field_select' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			[
				'label_for'   => 'end-point-location',
				'description' => esc_html__( 'Choose the location that is nearest to your location.', 'rotativa' ),
				'options'     => [
					'eu-north-ireland' => [
						'name' => esc_html__( 'EU North - Ireland', 'rotativa' ),
						'url'  => 'https://eunorth.rotativahq.com/'
					],
					'us-east-virginia' => [
						'name' => esc_html__( 'US East - Virginia', 'rotativa' ),
						'url'  => 'https://useast.rotativahq.com/'
					],
					'australia-east-sydney' => [
						'name' => esc_html__( 'Australia East - Sydney', 'rotativa' ),
						'url'  => 'https://ausea.rotativahq.com/'
					]
				]
			]
		);

		add_settings_field(
			'button-style-background-color',
			esc_html__( 'Button Background Color', 'rotativa' ),
			[ $this, 'rotativa_sandbox_add_settings_field_colorpicker' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-styling-section',
			[
				'label_for' => 'button-style-background-color'
			]
		);

		add_settings_field(
			'button-style-text-color',
			esc_html__( 'Button Text Color', 'rotativa' ),
			[ $this, 'rotativa_sandbox_add_settings_field_colorpicker' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-styling-section',
			[
				'label_for' => 'button-style-text-color'
			]
		);

		add_settings_field(
			'button-style-border',
			esc_html__( 'Button Border', 'rotativa' ),
			[ $this, 'rotativa_sandbox_add_settings_field_border' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-styling-section',
			[
				'label_for' => 'button-style-border'
			]
		);

		add_settings_field(
			'button-style-padding',
			esc_html__( 'Button Padding', 'rotativa' ),
			[ $this, 'rotativa_sandbox_add_settings_field_padding_margin' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-styling-section',
			[
				'label_for' => 'button-style-padding'
			]
		);

		add_settings_field(
			'button-style-margin',
			esc_html__( 'Button Margin', 'rotativa' ),
			[ $this, 'rotativa_sandbox_add_settings_field_padding_margin' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-styling-section',
			[
				'label_for' => 'button-style-margin'
			]
		);

	}

	/**
	 * Sandbox our settings.
	 *
	 * @since 1.0.0
	 */
	public function rotativa_sandbox_register_setting( $input ) {

		$new_input = [];

		if ( isset( $input ) ) {
			// Loop trough each input and sanitize the value if the input id isn't post-types
			foreach ( $input as $key => $value ) {
				if ( $key == 'post-types' ) {
					$new_input[ $key ] = $value;
				} else {
					$new_input[ $key ] = sanitize_text_field( $value );
				}
			}
		}

		return $new_input;

	}

	/**
	 * Sandbox our section for the settings.
	 *
	 * @since 1.0.0
	 */
	public function rotativa_sandbox_add_settings_section() {

		return;

	}

	/**
	 * Sandbox our single checkboxes.
	 *
	 * @param $args
	 *
	 * @since 1.0.0
	 */
	public function rotativa_sandbox_add_settings_field_single_checkbox( $args ) {

		$field_id = $args['label_for'];
		$field_description = $args['description'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = 0;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>

		<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>">
			<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" <?php checked( $option, true, 1 ); ?> value="1" />
			<span class="description"><?php echo esc_html( $field_description ); ?></span>
		</label>

		<?php

	}

	/**
	 * Sandbox our multiple checkboxes
	 *
	 * @param $args
	 *
	 * @since 1.0.0
	 */
	public function rotativa_sandbox_add_settings_field_multiple_checkbox( $args ) {

		$field_id = $args['label_for'];
		$field_description = $args['description'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = [];

		if ( ! empty( $options[ $field_id ] ) ) {
			$option = $options[ $field_id ];
		}

		if ( $field_id == 'post-types' ) {

			$args = [
				'public' => true
			];
			$post_types = get_post_types( $args, 'objects' );

			foreach ( $post_types as $post_type ) {

				if ( $post_type->name != 'attachment' ) {

					if ( in_array( $post_type->name, $option ) ) {
						$checked = 'checked="checked"';
					} else {
						$checked = '';
					}

					?>

					<fieldset>
						<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $post_type->name . ']'; ?>">
							<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $post_type->name . ']'; ?>" value="<?php echo esc_attr( $post_type->name ); ?>" <?php echo $checked; ?> />
							<span class="description"><?php echo esc_html( $post_type->label ); ?></span>
						</label>
					</fieldset>

					<?php

				}

			}

		} else {

			$field_args = $args['options'];

			foreach ( $field_args as $field_arg_key => $field_arg_value ) {

				if ( in_array( $field_arg_key, $option ) ) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}

				?>

				<fieldset>
					<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $field_arg_key . ']'; ?>">
						<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $field_arg_key . ']'; ?>" value="<?php echo esc_attr( $field_arg_key ); ?>" <?php echo $checked; ?> />
						<span class="description"><?php echo esc_html( $field_arg_value ); ?></span>
					</label>
				</fieldset>

				<?php

			}

		}

		?>

		<p class="description"><?php echo esc_html( $field_description ); ?></p>

		<?php

	}

	/**
	 * Sandbox our inputs with text
	 *
	 * @param $args
	 *
	 * @since 1.0.0
	 */
	public function rotativa_sandbox_add_settings_field_input_general( $args ) {

		$field_id = $args['label_for'];
		$field_description = $args['description'];
		$field_type = $args['type'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = '';

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>

		<input type="<?php echo $field_type; ?>" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" value="<?php echo esc_attr( $option ); ?>" class="regular-text" />
		<p class="description"><?php echo $field_description; ?></p>

		<?php

	}

	/**
	 * Sandbox our select fields.
	 *
	 * @param $args
	 *
	 * @since 1.0.0
	 */
	public function rotativa_sandbox_add_settings_field_select( $args ) {

		$field_id = $args['label_for'];
		$field_description = $args['description'];
		$field_options = $args['options'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = '';

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>

		<select name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>">
			<?php foreach ( $field_options as $opt ) : ?>
				<option value="<?php echo esc_url( $opt['url'] ); ?>" <?php selected( $option, $opt['url'] ); ?>><?php echo esc_html( $opt['name'] ); ?></option>
			<?php endforeach; ?>
		</select>
		<p class="description"><?php echo esc_html( $field_description ); ?></p>

		<?php

	}

	public function rotativa_sandbox_add_settings_field_colorpicker( $args ) {

		$field_id = $args['label_for'];
		$field_options = $args['options'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = '';

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>

		<input type="text" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" value="<?php echo esc_attr( $option ); ?>" class="rotativa-colorpicker" />

		<?php

	}

	public function rotativa_sandbox_add_settings_field_border( $args ) {

		$field_id = $args['label_for'];
		$field_options = $args['options'];

		$options = get_option( $this->plugin_name . '-settings' );
		$border_width = 0;
		$border_color = 'transparent';
		$border_radius = 0;

		if ( ! empty( $options[ $field_id ] ) ) {

			if ( isset( $options[ $field_id ]['width'] ) && ! empty( $options[ $field_id ]['width'] ) ) {

				$border_width = $options[ $field_id ]['width'];

			}

			if ( isset( $options[ $field_id ]['color'] ) && ! empty( $options[ $field_id ]['color'] ) ) {

				$border_color = $options[ $field_id ]['color'];

			}

			if ( isset( $options[ $field_id ]['radius'] ) && ! empty( $options[ $field_id ]['radius'] ) ) {

				$border_radius = $options[ $field_id ]['radius'];

			}

		}

		?>

			<p class="rotativa-inline">
				<strong><?php echo esc_html( 'Width:', 'rotativa' ); ?></strong>
				<input type="number" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][width]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][width]'; ?>" value="<?php echo $border_width; ?>">
			</p>
			<p class="rotativa-inline">
				<strong><?php echo esc_html( 'Radius:', 'rotativa' ); ?></strong>
				<input type="number" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][radius]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][radius]'; ?>" value="<?php echo $border_radius; ?>">
			</p>
			<p class="rotativa-inline">
				<strong><?php echo esc_html( 'Color:', 'rotativa' ); ?></strong>
				<input type="text" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][color]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][color]'; ?>" value="<?php echo $border_color; ?>" class="rotativa-colorpicker">
			</p>

		<?php

	}

	public function rotativa_sandbox_add_settings_field_padding_margin( $args ) {

		$field_id = $args['label_for'];
		$field_options = $args['options'];

		$options = get_option( $this->plugin_name . '-settings' );
		$padding_margin_top = 0;
		$padding_margin_right = 0;
		$padding_margin_bottom = 0;
		$padding_margin_left = 0;

		if ( ! empty( $options[ $field_id ] ) ) {

			if ( isset( $options[ $field_id ]['top'] ) && ! empty( $options[ $field_id ]['top'] ) ) {

				$padding_margin_top = $options[ $field_id ]['top'];

			}

			if ( isset( $options[ $field_id ]['right'] ) && ! empty( $options[ $field_id ]['right'] ) ) {

				$padding_margin_right = $options[ $field_id ]['right'];

			}

			if ( isset( $options[ $field_id ]['bottom'] ) && ! empty( $options[ $field_id ]['bottom'] ) ) {

				$padding_margin_bottom = $options[ $field_id ]['bottom'];

			}

			if ( isset( $options[ $field_id ]['left'] ) && ! empty( $options[ $field_id ]['left'] ) ) {

				$padding_margin_left = $options[ $field_id ]['left'];

			}

		}

		?>

			<p class="rotativa-inline">
				<strong><?php echo esc_html( 'Top:', 'rotativa' ); ?></strong>
				<input type="number" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][top]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][top]'; ?>" value="<?php echo $padding_margin_top; ?>">
			</p>
			<p class="rotativa-inline">
				<strong><?php echo esc_html( 'Right:', 'rotativa' ); ?></strong>
				<input type="number" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][right]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][right]'; ?>" value="<?php echo $padding_margin_right; ?>">
			</p>
			<p class="rotativa-inline">
				<strong><?php echo esc_html( 'Bottom:', 'rotativa' ); ?></strong>
				<input type="number" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][bottom]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][bottom]'; ?>" value="<?php echo $padding_margin_bottom; ?>">
			</p>
			<p class="rotativa-inline">
				<strong><?php echo esc_html( 'Left:', 'rotativa' ); ?></strong>
				<input type="number" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][left]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][left]'; ?>" value="<?php echo $padding_margin_left; ?>">
			</p>

		<?php

	}

	/**
	 * Add plugin actions links.
	 *
	 * @since 1.0.0
	 */
	 public function rotativa_action_links( $links ) {

		 $links[] = '<a href="'. esc_url( get_admin_url(null, 'tools.php?page=rotativa') ) .'">' . __( 'Settings', 'rotativa' ) . '</a>';

		 return $links;

	 }

	 public function rotativa_register_metabox() {

		 $options = get_option( $this->plugin_name . '-settings' );
		 $option = $options['post-types'];

		 if ( isset( $option ) && ! empty( $option ) ) {

			 add_meta_box(
				 'rotativa-side-metabox',
				 __( 'RotativaHQ', 'rotativa' ),
				 [ $this, 'rotativa_display_metabox' ],
				 $option,
				 'side'
			 );

		 }

	 }

	 public function rotativa_display_metabox() {

		?>
		 	<div class="rotativa-hq-metabox">
				<button class="button toggle-popup"><?php echo esc_html__( 'Generate a PDF', 'rotativa' ); ?></button>
				<span class="spinner"></span>
			</div>
			<div class="rotativa-hq-popup-settings">
				<div class="inner-scroll">
					<div class="rotativa-hq-popup-settings-overlay"></div>
					<div class="inner">
						<div class="field">
							<label class="label" for="pdf-item-file-name"><?php echo esc_html__( 'File Name:', 'rotativa' ); ?></label>
							<div class="control">
								<input class="input" type="text" id="pdf-item-file-name" name="pdf-item-file-name" value="">
							</div>
						</div>
						<a href="#" class="toggle-additional-pdf-settings"><?php echo esc_html__( 'Additional Settings', 'rotativa' ); ?></a>
						<div class="additional-pdf-settings">
							<div class="columns">
								<div class="column is-half">
									<div class="field">
										<label class="label" for="pdf-item-margin-top"><?php echo esc_html__( 'Page Top Margin:', 'rotativa' ); ?></label>
										<div class="control">
											<input class="input" type="number" id="pdf-item-margin-top" name="pdf-item-margin-top" value="">
										</div>
									</div>
								</div>
								<div class="column is-half">
									<div class="field">
										<label class="label" for="pdf-item-margin-right"><?php echo esc_html__( 'Page Right Margin:', 'rotativa' ); ?></label>
										<div class="control">
											<input class="input" type="number" id="pdf-item-margin-right" name="pdf-item-margin-right" value="">
										</div>
									</div>
								</div>
								<div class="column is-half">
									<div class="field">
										<label class="label" for="pdf-item-margin-bottom"><?php echo esc_html__( 'Page Bottom Margin:', 'rotativa' ); ?></label>
										<div class="control">
											<input class="input" type="number" id="pdf-item-margin-bottom" name="pdf-item-margin-bottom" value="">
										</div>
									</div>
								</div>
								<div class="column is-half">
									<div class="field">
										<label class="label" for="pdf-item-margin-left"><?php echo esc_html__( 'Page Left Margin:', 'rotativa' ); ?></label>
										<div class="control">
											<input class="input" type="number" id="pdf-item-margin-left" name="pdf-item-margin-left" value="">
										</div>
									</div>
								</div>
							</div>
							<div class="field">
							  <div class="control">
							    <label class="checkbox" for="pdf-item-grayscale">
							      <input type="checkbox" id="pdf-item-grayscale" name="pdf-item-grayscale">
							      <?php echo esc_html__( 'Is Grayscale?', 'rotativa' ); ?>
							    </label>
							  </div>
							</div>
						</div>
						<div>
							<button class="button button-primary rotativa-generate-pdf" data-object-id="<?php echo esc_attr( get_the_ID() ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'rotativa_generate_pdf_nonce' ) ); ?>" data-id="<?php echo esc_attr( get_the_ID() ); ?>" data-active-label="<?php echo esc_attr__( 'Generating...', 'rotativa' ); ?>"><?php echo esc_html__( 'Generate a PDF', 'rotativa' ); ?></button>
						</div>
					</div>
				</div>
			</div>
		<?php

	}

	public function rotativa_ajax_generate_pdf() {

		// Check the nonce.
		if ( ! wp_verify_nonce( $_POST['nonce'], 'rotativa_generate_pdf_nonce' ) ) {

			wp_send_json_error( esc_html__( 'Nonce check has failed.', 'rotativa' ) );
			exit;

		}

		$post_id = filter_var( $_POST['id'], FILTER_VALIDATE_INT );
		$post_id = preg_replace( '/[^0-9]/', '', $post_id );

		$options   = get_option( $this->plugin_name . '-settings' );
		$api_key   = $options['api-key'];
		$endpoint  = $options['end-point-location'];
		$permalink = get_permalink( $post_id );

		$file_name     = sanitize_file_name( $_POST['file_name'] );
		$margin_top    = preg_replace( '/[^0-9]/', '', filter_var( $_POST['margin_top'], FILTER_VALIDATE_INT ) );
		$margin_right  = preg_replace( '/[^0-9]/', '', filter_var( $_POST['margin_right'], FILTER_VALIDATE_INT ) );
		$margin_bottom = preg_replace( '/[^0-9]/', '', filter_var( $_POST['margin_bottom'], FILTER_VALIDATE_INT ) );
		$margin_left   = preg_replace( '/[^0-9]/', '', filter_var( $_POST['margin_left'], FILTER_VALIDATE_INT ) );
		$gray          = filter_var( $_POST['gray'], FILTER_VALIDATE_BOOLEAN );

		$remote_args = [
			'headers' => [
				'X-ApiKey' => $api_key
			],
			'body'    => [
				'htmlUrl'    => $permalink,
                'returnLink' => true
			],
            'timeout' => '10'
		];

		if ( isset( $file_name ) && ! empty( $file_name ) ) {

			$remote_args['body']['filename'] = $file_name;

		}

		if ( isset( $margin_top ) && ! empty( $margin_top ) ) {

			$remote_args['body']['pageMargins']['top'] = $margin_top;

		}

		if ( isset( $margin_right ) && ! empty( $margin_right ) ) {

			$remote_args['body']['pageMargins']['right'] = $margin_right;

		}

		if ( isset( $margin_bottom ) && ! empty( $margin_bottom ) ) {

			$remote_args['body']['pageMargins']['bottom'] = $margin_bottom;

		}

		if ( isset( $margin_left ) && ! empty( $margin_left ) ) {

			$remote_args['body']['pageMargins']['left'] = $margin_left;

		}

		if ( isset( $gray ) && ! empty( $gray ) ) {

			$remote_args['body']['isGrayScale'] = $gray;

		}

		$remote_args['body'] = json_encode( $remote_args['body'] );

		$response = wp_remote_post( $endpoint, $remote_args );

		if ( ! is_wp_error( $response ) ) {

		    $body = wp_remote_retrieve_body( $response );

		    wp_send_json_success( $body );

		}

	}

}
