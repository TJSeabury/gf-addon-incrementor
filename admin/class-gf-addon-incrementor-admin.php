<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    gf_addon_incrementor
 * @subpackage gf_addon_incrementor/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    gf_addon_incrementor
 * @subpackage gf_addon_incrementor/admin
 * @author     Your Name <email@example.com>
 */
class gf_addon_incrementor_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $gf_addon_incrementor    The ID of this plugin.
	 */
	private $gf_addon_incrementor;

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
	 * @param      string    $gf_addon_incrementor       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $gf_addon_incrementor, $version ) {

		$this->gf_addon_incrementor = $gf_addon_incrementor;
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
		 * defined in gf_addon_incrementor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The gf_addon_incrementor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->gf_addon_incrementor, plugin_dir_url( __FILE__ ) . 'css/gf-addon-incrementor-admin.css', array(), $this->version, 'all' );

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
		 * defined in gf_addon_incrementor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The gf_addon_incrementor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 
			$this->gf_addon_incrementor, 
			plugin_dir_url( __FILE__ ) . 'js/gf-addon-incrementor-admin.js', 
			array(), 
			$this->version, false 
		);

	}

}
