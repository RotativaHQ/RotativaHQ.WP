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
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rotativa-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rotativa-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the settings page for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function register_settings_page() {

		add_submenu_page(
			'tools.php',
			__( 'Rotativa', 'rotativa' ),
			__( 'Rotativa', 'rotativa' ),
			'manage_options',
			'rotativa',
			[ $this, 'display_settings_page' ]
		);

	}

	/**
	 * Display the settings page for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function display_settings_page() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/rotativa-admin-display.php';

	}

	/**
	 * Register settings for our settings page.
	 *
	 * @since 1.0.0
	 */
	public function register_settings() {

		register_setting(
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings',
			[ $this, 'sandbox_register_settings' ]
		);

		add_settings_section(
			$this->plugin_name . '-settings-section',
			__( 'Rotativa Settings', 'rotativa' ),
			[ $this, 'sandbox_add_settings_section' ],
			$this->plugin_name . '-settings'
		);

		add_settings_field(
			'post-types',
			__( 'Post Types', 'rotativa' ),
			[ $this, 'sandbox_add_settings_field_multiple_checkbox' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			[
				'label_for'   => 'post-types',
				'description' => __( 'Check post types were you want to show Rotativa Interface for Converting HTML to PDF.', 'rotativa' )
			]
		);

		add_settings_field(
			'api-key',
			__( 'API Key', 'rotativa' ),
			[ $this, 'sandbox_add_settings_field_input_general' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			[
				'label_for'   => 'api-key',
				'description' => __( 'Please enter your API Key. You can get it from <a href="https://rotativahq.com/" target="_blank">here</a>.', 'rotativa' ),
				'type'        => 'password'
			]
		);

		add_settings_field(
			'end-point-location',
			__( 'Endpoint Location', 'rotativa' ),
			[ $this, 'sandbox_add_settings_field_select' ],
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			[
				'label_for'   => 'end-point-location',
				'description' => __( 'Choose the location that is nearest to your location.', 'rotativa' ),
				'options'     => [
					'eu-north-ireland' => [
						'name' => __( 'EU North - Ireland', 'rotativa' ),
						'url'  => '//eunorth.rotativahq.com/'
					],
					'us-west-california' => [
						'name' => __( 'US West - California', 'rotativa' ),
						'url'  => '//uswest.rotativahq.com/'
					],
					'us-east-virginia' => [
						'name' => __( 'US East - Virginia', 'rotativa' ),
						'url'  => '//useast.rotativahq.com/'
					],
					'southeast-asia-singapore' => [
						'name' => __( 'Southeast Asia - Singapore', 'rotativa' ),
						'url'  => '//asiase.rotativahq.com/'
					],
					'australia-east-sydney' => [
						'name' => __( 'Australia East - Sydney', 'rotativa' ),
						'url'  => '//ausea.rotativahq.com/'
					]
				]
			]
		);

	}

	/**
	 * Sandbox our settings.
	 *
	 * @since 1.0.0
	 */
	public function sandbox_register_setting( $input ) {

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
	public function sandbox_add_settings_section() {

		return;

	}

	/**
	 * Sandbox our single checkboxes.
	 *
	 * @param $args
	 *
	 * @since 1.0.0
	 */
	public function sandbox_add_settings_field_single_checkbox( $args ) {

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
	public function sandbox_add_settings_field_multiple_checkbox( $args ) {

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
	public function sandbox_add_settings_field_input_general( $args ) {

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
	public function sandbox_add_settings_field_select( $args ) {

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

}