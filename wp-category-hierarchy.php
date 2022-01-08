<?php
/*
Plugin Name: WordPress Category Hierarchy
Plugin URI: https://github.com/miiitaka/wp-category-hierarchy
Description: A plugin that adds a widget to display the categories below the current category on the category page.
Version: 1.0.0
Author: Kazuya Takami
Author URI: https://www.terakoya.work/
License: GPLv2 or later
Text Domain: wp-category-hierarchy
Domain Path: /languages
*/

new Category_Hierarchy();

/**
 * Basic Class
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */
class Category_Hierarchy {

	/**
	 * Variable definition.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $text_domain;

	/**
	 * Variable definition.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $version;

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function __construct () {
		$data              = get_file_data( __FILE__, array( 'version' => 'Version', 'text_domain' => 'Text Domain' ) );
		$this->version     = isset( $data['version'] ) ? $data['version'] : '';
		$this->text_domain = isset( $data['text_domain'] ) ? $data['text_domain'] : '';

		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'widgets_init',   array( $this, 'widget_init' ) );
	}

	/**
	 * i18n.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function plugins_loaded () {
		load_plugin_textdomain( $this->text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Widget Register.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function widget_init () {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-category-hierarchy-admin-widget.php' );
		register_widget( 'Category_Hierarchy_Widget' );
	}
}