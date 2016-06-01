<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://inside.sas.com
 * @since      1.0.0
 *
 * @package    Sww_Ux
 * @subpackage Sww_Ux/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sww_Ux
 * @subpackage Sww_Ux/admin
 * @author     Sarah Ovenall, the SWW Team <sarah.ovenall@sas.com>
 */
class Sww_Ux_Admin {

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
	 * used by cmb2
	 */

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'sww-ux-testing';
	/**
	 * Options page metabox id
	 * @var string
	 */
	private $metabox_id = 'sww_ux_option_metabox';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sww_ux       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sww_ux, $version ) {

		$this->sww_ux = $sww_ux;
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
		 * defined in Sww_Ux_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sww_Ux_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->sww_ux, plugin_dir_url( __FILE__ ) . 'css/sww-ux-admin.css', array(), $this->version, 'all' );

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
		 * defined in Sww_Ux_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sww_Ux_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->sww_ux, plugin_dir_url( __FILE__ ) . 'js/sww-ux-admin.js', array( 'jquery' ), $this->version, false );

	}


	function sww_ux_admin_side_register() {

		$prefix = '_sww_ux_';

		$cmb = new_cmb2_box( array(
			'id'           => 'front-end-post-form',
			'title' => 'Feedback Responses',
			'object_types' => array( 'ux-reporting' ),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			'closed' => false, // true to keep the metabox closed by default
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

	public function register_results_page() {
		add_menu_page(
			'UX Testing',
			'UX Testing',
			'manage_options',
			'sww-ux-testing',
			array( $this, 'sww_ux_menu_page' ),
			'dashicons-edit',
			20
		);

		add_submenu_page(
			'sww-ux-testing',
			'UX Testing Results',
			'UX Test Results',
			'manage_options',
			'ux-results',
			array( $this, 'display_results_page' )
		);
	}

	/**
	 * display table of all results
	 */
	public function display_results_page() {
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/sww-ux-admin-display.php';
	}

	/**
	 * display options page where user can enter tasks
	 */
	public function sww_ux_menu_page() {
		if ( !current_user_can('manage_options') ) {
			wp_die( 'You do not have sufficient permissions to access this page.' );
		}

		?>
		<h2>UX Testing Options</h2>
		<p>Enter tasks below, one task in each box. You can use the up-down arrows to reorder tasks. When your task list is complete, create a page or post and use the shortcode [uxtest] to display a form with the task list.</p>
		<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>

	<?php
	}

	function add_options_page_metabox() {
		// hook in our save notices
		add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );

		$prefix = '_ux_test_';

		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => true,
			'show_on'    => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
		// repeating field group for flexible # of tasks
		$ux_field_group = $cmb->add_field( array(
			'id'          => $prefix . 'group',
			'type'        => 'group',
			//'description' => __( 'Task list for usability test', 'cmb2' ),
			'options'     => array(
				'group_title'   => __( 'Task {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
				'add_button'    => __( 'Add Another Task', 'cmb2' ),
				'remove_button' => __( 'Remove Task', 'cmb2' ),
				'sortable'      => true, // beta
				'closed'     => true, // true to have the groups closed by default
			),
		) );
		$cmb->add_group_field( $ux_field_group, array(
			'name' => 'Task',
			'id'   => 'task',
			'type' => 'textarea',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );


	}


	/**
	 * Register settings notices for display
	 *
	 * @since  0.1.0
	 * @param  int   $object_id Option key
	 * @param  array $updated   Array of updated fields
	 * @return void
	 */
	public function settings_notices( $object_id, $updated ) {
		if ( $object_id !== $this->key || empty( $updated ) ) {
			return;
		}
		add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'myprefix' ), 'updated' );
		settings_errors( $this->key . '-notices' );
	}

}

