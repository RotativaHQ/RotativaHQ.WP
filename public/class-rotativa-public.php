<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://rotativahq.com/
 * @since      1.0.0
 *
 * @package    Rotativa
 * @subpackage Rotativa/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rotativa
 * @subpackage Rotativa/public
 * @author     RotativaHQ <info@rotativahq.com>
 */
class Rotativa_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		$pdf_success = apply_filters( 'rotativa_pdf_success_fe', [
            'title'        => esc_html__( 'Success!', 'rotativa' ),
            'description'  => esc_html__( 'We have successfully generated your PDF. You can click the button below to download it.', 'rotativa' ),
            'button_label' => esc_html__( 'Download PDF', 'rotativa' )
        ] );

        wp_enqueue_script( $this->plugin_name . '-sweetalert2', plugin_dir_url( __FILE__ ) . 'js/sweetalert2.min.js', array( 'jquery' ), '7.26.11', true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rotativa-public.js', array( 'jquery' ), $this->version, true );
		wp_localize_script(
		    $this->plugin_name,
            'rotativa',
            [
                'ajaxurl'        => admin_url( 'admin-ajax.php' ),
                'generate_pdf'   => esc_html__( 'Generate PDF', 'rotativa' ),
                'generating_pdf' => esc_html__( 'Generating...', 'rotativa' ),
                'pdf_success' => $pdf_success
            ]
        );

	}

	/**
     * Create a shortcode.
     *
     * @since    1.1.0
     */
	public function rotativa_generate_pdf_shortcode( $atts ) {

	    // Attributes
        $atts = shortcode_atts(
            [
                'ID' => '',
                'label' => ''
            ],
            $atts,
            'rotativa-generate-pdf'
        );

        if ( isset( $atts['ID'] ) && ! empty( $atts['ID'] ) && $atts['ID'] !== 0 ) {

            $ID = $atts['ID'];

        } else {

            $ID = get_queried_object_id();

        }

        if ( isset( $atts['label'] ) && ! empty( $atts['label'] ) ) {

        	$label = $atts['label'];

        } else {

        	$label = esc_html__( 'Generate PDF', 'rotativa' );

        }

        // Button Styling
        $options = get_option( $this->plugin_name . '-settings' );
        $background_color = $options['button-style-background-color'];
        $text_color       = $options['button-style-text-color'];
        $border           = $options['button-style-border'];
        $padding          = $options['button-style-padding'];
        $margin           = $options['button-style-margin'];

        $css_append = '';

        if ( isset( $background_color ) && ! empty( $background_color ) ) {

        	$css_append .= 'background-color: ' . esc_attr( $background_color ) . ';';

        }

        if ( isset( $text_color ) && ! empty( $text_color ) ) {

        	$css_append .= 'color: ' . esc_attr( $text_color ) . ';';

        }

        if ( isset( $border ) && ! empty( $border ) ) {

        	if ( isset( $border['width'] ) && ! empty( $border['width'] ) && $border['width'] != 0 ) {

        		$css_append .= 'border-width: ' . esc_attr( $border['width'] ) . 'px;';
        		$css_append .= 'border-style: solid;';

        	}

        	if ( isset( $border['radius'] ) && ! empty( $border['radius'] ) && $border['radius'] != 0 ) {

        		$css_append .= 'border-radius: ' . esc_attr( $border['radius'] ) . 'px;';

        	}

        	if ( isset( $border['color'] ) && ! empty( $border['color'] ) ) {

        		$css_append .= 'border-color: ' . esc_attr( $border['color'] ) . ';';

        	}

        }

        if ( isset( $padding ) && ! empty( $padding ) ) {

        	if ( isset( $padding['top'] ) && ! empty( $padding['top'] ) && $padding['top'] != 0 ) {

        		$css_append .= 'padding-top: ' . esc_attr( $padding['top'] ) . 'px;';

        	}

        	if ( isset( $padding['right'] ) && ! empty( $padding['right'] ) && $padding['right'] != 0 ) {

        		$css_append .= 'padding-right: ' . esc_attr( $padding['right'] ) . 'px;';

        	}

        	if ( isset( $padding['bottom'] ) && ! empty( $padding['bottom'] ) && $padding['bottom'] != 0 ) {

        		$css_append .= 'padding-bottom: ' . esc_attr( $padding['bottom'] ) . 'px;';

        	}

        	if ( isset( $padding['left'] ) && ! empty( $padding['left'] ) && $padding['left'] != 0 ) {

        		$css_append .= 'padding-left: ' . esc_attr( $padding['left'] ) . 'px;';

        	}

        }

        if ( isset( $margin ) && ! empty( $margin ) ) {

        	if ( isset( $margin['top'] ) && ! empty( $margin['top'] ) && $margin['top'] != 0 ) {

        		$css_append .= 'margin-top: ' . esc_attr( $margin['top'] ) . 'px;';

        	}

        	if ( isset( $margin['right'] ) && ! empty( $margin['right'] ) && $margin['right'] != 0 ) {

        		$css_append .= 'margin-right: ' . esc_attr( $margin['right'] ) . 'px;';

        	}

        	if ( isset( $margin['bottom'] ) && ! empty( $margin['bottom'] ) && $margin['bottom'] != 0 ) {

        		$css_append .= 'margin-bottom: ' . esc_attr( $margin['bottom'] ) . 'px;';

        	}

        	if ( isset( $margin['left'] ) && ! empty( $margin['left'] ) && $margin['left'] != 0 ) {

        		$css_append .= 'margin-left: ' . esc_attr( $margin['left'] ) . 'px;';

        	}

        }

        $css = '<style>
        	button.rotativa-generate-pdf-fe {
        		' . $css_append . '
        	}
        </style>';

	    $html = '<button class="rotativa-generate-pdf-fe" data-nonce="' . wp_create_nonce( 'rotativa_generate_pdf_fe_nonce' ) . '" data-id="' . esc_attr( $ID ) . '">' . esc_html( $label ) . '</button>';

	    $html .= $css;

	    return apply_filters( 'rotativa_generate_pdf_shortcode_html', $html );

    }

    /**
     * AJAX : Generate PDF
     */
    public function rotativa_ajax_generate_pdf_fe() {

        // Check the nonce.
        if ( ! wp_verify_nonce( $_POST['nonce'], 'rotativa_generate_pdf_fe_nonce' ) ) {

            wp_send_json_error( esc_html__( 'Nonce check has failed.', 'rotativa' ) );
            exit;

        }

        $post_id = filter_var( $_POST['id'], FILTER_VALIDATE_INT );
        $post_id = preg_replace( '/[^0-9]/', '', $post_id );

        $options   = get_option( $this->plugin_name . '-settings' );
        $api_key   = $options['api-key'];
        $endpoint  = $options['end-point-location'];
        $permalink = get_permalink( $post_id );
        $title     = get_the_title( $post_id );
        $title     = sanitize_file_name( $title );

        $remote_args = [
            'headers' => [
                'X-ApiKey' => $api_key
            ],
            'body'    => [
                'htmlUrl'    => $permalink,
                'returnLink' => true,
                'filename'   => $title
            ],
            'timeout' => '10'
        ];

        $remote_args['body'] = json_encode( $remote_args['body'] );

        $response = wp_remote_post( $endpoint, $remote_args );

        if ( ! is_wp_error( $response ) ) {

            $body = wp_remote_retrieve_body( $response );

            wp_send_json_success( $body );

        }

    }

}
