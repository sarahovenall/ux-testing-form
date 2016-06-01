<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://inside.sas.com
 * @since      1.0.0
 *
 * @package    Sww_Ux
 * @subpackage Sww_Ux/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sww_Ux
 * @subpackage Sww_Ux/public
 * @author     Sarah Ovenall, the SWW Team <sarah.ovenall@sas.com>
 */
class Sww_Ux_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sww_ux    The ID of this plugin.
	 */
	private $sww_ux;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * option key
	 */
	private $key = 'sww-ux-testing';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sww_ux       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sww_ux, $version ) {

		$this->sww_ux = $sww_ux;
		$this->version = $version;


	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sww_Ux_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sww_Ux_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->sww_ux, plugin_dir_url( __FILE__ ) . 'css/sww-ux-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		//run wp_localize_script here to populate task list in fieldsets
		$tasks = array();
		$meta = get_option( $this->key );
		if ( isset( $meta ) ) {
			$tasklist = $meta['_ux_test_group'];
			$size = count( $tasklist );
			if ( isset( $tasklist ) ) {
				foreach ( $tasklist as $key => $value ) {
					$index = $key + 1;
					if ( $index == $size ) {
						$prefix = 'FINAL TASK: ';
					} else {
						$prefix = 'Task ' . $index . ': ';
					}
					$tasks[] = $prefix . $value['task'];
				}
			}
		$tasks[] = 'User test complete. Thank you!';
		}

		wp_register_script( $this->sww_ux, plugin_dir_url( __FILE__ ) . 'js/sww-ux-public.js', array( 'jquery' ), $this->version, true );

		wp_localize_script( $this->sww_ux, 'tasklist', $tasks );

		wp_enqueue_script( $this->sww_ux );

	}


	public function register_ux_reporting_cpt() {
		$labels = array(
			'name' => __( 'UX Responses', 'sww-ux' ),
			'singular_name' => __( 'UX Response', 'sww-ux' ),
		);
		$args = array(
			'labels' => $labels,
			'description' => __( 'Usability Test Feedback Form', 'sww-ux' ),
			'public' => false,
			'publicly_queryable' => false,
			'show_ui' => true,
			'show_in_menu' => false,
			'supports' => array( 'title', 'author', 'editor' ),
		);
		register_post_type( 'ux-reporting', $args );
	}


	function sww_ux_add_to_menu() {
		add_submenu_page(
			'sww-ux-testing',
			'UX Responses',
			'UX All Responses',
			'manage_options',
			'edit.php?post_type=ux-reporting',
			NULL
		);
	}




	function sww_ux_frontend_form_register() {

		$prefix = '_sww_ux_';

		$cmb = new_cmb2_box( array(
			'id'           => 'front-end-post-form',
			'object_types' => array( 'ux-reporting' ),
			'hookup'       => false,
			'save_fields'  => false,
		) );



		$group_field_id = $cmb->add_field( array(
			'id'          => $prefix . 'repeat_group',
			'type'        => 'group',
			'description' => __( 'Please answer the questions below for each task you complete.', 'cmb2' ),
			// 'repeatable'  => false, // use false if you want non-repeatable group
			'options'     => array(
				'group_title'   => __( 'Task {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
				'add_button'    => __( 'Continue to the next task', 'cmb2' ),
				'remove_button' => __( 'Remove', 'cmb2' ),
				'sortable'      => false, // beta
				'closed'     => false, // true to have the groups closed by default
			),
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => '<div class="displaytask"></div>',
			'description' => '',
			'id'   => 'display_task',
			'type' => 'title',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Where did you find this information?',
			'description' => 'Please provide URL or title of page',
			'id'   => 'submitted_where',
			'type' => 'text_medium',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Was it easy or difficult to find this information?',
			'id'   => 'submitted_easy',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Was the information where you expected it to be? If not, where did you expect to find it?',
			//'description' => 'Write a short description for this entry',
			'id'   => 'submitted_expect',
			'type' => 'textarea_small',
		) );


		$cmb->add_field( array(
			'name'    => __( 'General Comments', 'sww-ux' ),
			'desc' => 'If you have additional comments add them here. (OPTIONAL)',
			'id'      => $prefix . 'submitted_post_content',
			'type'    => 'textarea',
		) );

		$cmb->add_field( array(
			'name' => __( 'Your Name', 'sww-ux' ),
			'desc' => __( 'If you are willing to be contacted regarding your feedback, enter your name here. (OPTIONAL)', 'sww-ux' ),
			'id'   => $prefix . 'submitted_author_name',
			'type' => 'text',
		) );

		$cmb->add_field( array(
			'name' => __( 'Your Email', 'sww-ux' ),
			'desc' => __( 'If you are willing to be contacted regarding your feedback, enter your email address here. (OPTIONAL)', 'sww-ux' ),
			'id'   => $prefix . 'submitted_author_email',
			'type' => 'text_email',
		) );


	}


	public function sww_ux_register_shortcodes() {
		function sww_do_frontend_form_submission_shortcode( $atts = array() ) {

			// Current user
 			$user_id = get_current_user_id();

            // Use ID of metabox in wds_frontend_form_register
            $metabox_id = 'front-end-post-form';

            // since post ID will not exist yet, just need to pass it something
            $object_id  = 'fake-object-id';

            // Get CMB2 metabox object
            $cmb = cmb2_get_metabox( $metabox_id, $object_id );

            // Get $cmb object_types
            //$post_types = $cmb->prop( 'object_types' );

            // Parse attributes. These shortcode attributes can be optionally overridden.
            $atts = shortcode_atts( array(
                'post_author' => $user_id ? $user_id : 1, // Current user, or admin
                'post_status' => 'pending',
                'post_type'   => 'ux-reporting', //reset( $post_types ), // Only use first object_type in array
            ), $atts, 'cmb-frontend-form' );

            // Initiate our output variable
            $output = '';


			// Handle form saving (if form has been submitted)
			$new_id = sww_ux_handle_frontend_new_post_form_submission( $cmb, $atts );

			if ( $new_id ) {

				if ( is_wp_error( $new_id ) ) {

					// If there was an error with the submission, add it to our ouput.
					$output .= '<h3>' . sprintf( __( 'There was an error in the submission: %s', 'wds-post-submit' ), '<strong>'. $new_id->get_error_message() .'</strong>' ) . '</h3>';

				} else {

					// Get submitter's name
					$name = isset( $_POST['_sww_ux_submitted_author_name'] ) && $_POST['_sww_ux_submitted_author_name']
						? ' '. $_POST['_sww_ux_submitted_author_name']
						: '';

					// Add notice of submission
					$output .= '<h3>' . sprintf( __( 'Thank you %s, your new post has been submitted and is pending review by a site administrator.', 'wds-post-submit' ), esc_html( $name ) ) . '</h3>';
				}

			}

			// Get our form
			$output .= cmb2_get_metabox_form( $cmb, $object_id, array( 'save_button' => __( 'Submit Feedback', 'sww-ux' ) ) );

			return $output;
		}
		add_shortcode( 'uxtest', 'sww_do_frontend_form_submission_shortcode' );

		function sww_ux_handle_frontend_new_post_form_submission( $cmb, $post_data = array() ) {

			// If no form submission, bail
			if ( empty( $_POST ) ) {
				return false;
			}

			// check required $_POST variables and security nonce
			if (
				! isset( $_POST['submit-cmb'], $_POST['object_id'], $_POST[ $cmb->nonce() ] )
				|| ! wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() )
			) {
				return new WP_Error( 'security_fail', __( 'Security check failed.' ) );
			}

			// Fetch sanitized values
			$sanitized_values = $cmb->get_sanitized_values( $_POST );

			// Set our post data arguments
			$post_data['post_title'] = $_POST['_sww_ux_submitted_author_name'] . ' Feedback Form';
			unset( $sanitized_values['_sww_ux_submitted_post_title'] );
			$post_data['post_content'] = $sanitized_values['_sww_ux_submitted_post_content'];
			unset( $sanitized_values['_sww_ux_submitted_post_content'] );

			// Create the new post
			$new_submission_id = wp_insert_post( $post_data, true );

			// If we hit a snag, update the user
			if ( is_wp_error( $new_submission_id ) ) {
				return $new_submission_id;
			}

			// Loop through remaining (sanitized) data, and save to post-meta
			foreach ( $sanitized_values as $key => $value ) {
				update_post_meta( $new_submission_id, $key, $value );
			}

			return $new_submission_id;
		}

	}



}

