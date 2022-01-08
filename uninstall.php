<?php
/**
 * Plugin Uninstall
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
new Category_Hierarchy_Uninstall();

class Category_Hierarchy_Uninstall {

	/**
	 * Constructor Define.
	 *
	 * @since   1.0.0
	 * @version 1.0.3
	 */
	public function __construct () {
		$this->drop_table();
		delete_option( 'widget_category_hierarchy_widget' );
	}

	/**
	 * Drop Table.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private function drop_table () {
		global $wpdb;
		$table_name = $wpdb->prefix . "category_hierarchy";
		$wpdb->query( "DROP TABLE IF EXISTS " . $table_name );
	}
}