<?php
/*
Plugin Name: WUSM Pullquotes
Plugin URI: 
Description: Add pullquotes to WUSM sites
Author: Aaron Graham
Version: 14.02.18.0
Author URI: 
*/

add_action( 'init', 'github_plugin_updater_wusm_pullquote_init' );
function github_plugin_updater_wusm_pullquote_init() {

		if( ! class_exists( 'WP_GitHub_Updater' ) )
			include_once 'updater.php';

		if( ! defined( 'WP_GITHUB_FORCE_UPDATE' ) )
			define( 'WP_GITHUB_FORCE_UPDATE', true );

		if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin

				$config = array(
						'slug' => plugin_basename( __FILE__ ),
						'proper_folder_name' => 'wusm-pullquote',
						'api_url' => 'https://api.github.com/repos/coderaaron/wusm-pullquote',
						'raw_url' => 'https://raw.github.com/coderaaron/wusm-pullquote/master',
						'github_url' => 'https://github.com/coderaaron/wusm-pullquote',
						'zip_url' => 'https://github.com/coderaaron/wusm-pullquote/archive/master.zip',
						'sslverify' => true,
						'requires' => '3.0',
						'tested' => '3.8',
						'readme' => 'README.md',
						'access_token' => '',
				);

				new WP_GitHub_Updater( $config );
		}

}

class wusm_pullquote_plugin {
	private $pullquote_text;

	/**
	 *
	 */
	public function __construct() {
		add_shortcode( 'wusm_pullquote_text', array( $this, 'get_shortcode' ) );
		add_shortcode( 'wusm_pullquote', array( $this, 'put_shortcode' ) );
		add_action( 'init', array( $this, 'output_shortcode_button' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'pullquote_shortcode_styles' ) );
	}

	public function put_shortcode( $atts, $content = null ) {
		return $this->pullquote_text;
	}

	/**
	 *
	 */
	public function get_shortcode( $atts, $content = null ) {
		// The $defaults hold all of the possible options
		$defaults = array(
			'author' => '',
			'credit' => '',
		);
		// The shortcode_atts function will compare and set defaults
		// The 3rd field is new in 3.6 and it is a filter to modify the atts
		// extract will create variables out of the $key = value pairs
		extract( shortcode_atts( $defaults, $atts, 'pullquote' ), EXTR_SKIP );

		$this->pullquote_text = '<div class="pullquote">' . esc_html( $content ) . '<span class="pullquote-author">' . $author . '</span><span class="pullquote-credit">' . $credit . '</span></div>';
		return esc_html( $content );
	}

	/**
	 * Enqueue styles.
	 *
	 * @since 0.1.0
	 */
	function pullquote_shortcode_styles() {
		if ( !is_admin() ) {
			wp_register_style( 'pullquote-styles', plugins_url('css/pullquote.css', __FILE__) );
			wp_enqueue_style( 'pullquote-styles' );
		}
	}

	/**
	 *
	 */
	public function output_shortcode_button() {
		add_filter( 'mce_external_plugins', array( $this, 'add_buttons' ) );
		add_filter( 'mce_buttons', array( $this, 'register_buttons' ) );
	}

	/**
	 *
	 */
	public function add_buttons( $plugin_array ) {
		$plugin_array['wusm_pullquote'] = plugins_url( '/js/wusm-pullquote.js', __FILE__ );
		return $plugin_array;
	}
	/**
	 *
	 */
	public function register_buttons( $buttons ) {
		// The ID value of the button we are creating
		array_push( $buttons, 'wusm_set_pullquote' );
		array_push( $buttons, 'wusm_put_pullquote' );
		return $buttons;
	}
}
new wusm_pullquote_plugin();