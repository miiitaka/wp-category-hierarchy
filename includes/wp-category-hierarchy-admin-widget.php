<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */
class Category_Hierarchy_Widget extends WP_Widget {
	/**
	 * Variable definition.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $text_domain = 'wp-category-hierarchy';

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 */
	public function __construct () {
		$widget_options = array( 'description' => esc_html__( 'Category Hierarchy Widget', $this->text_domain ) );
		parent::__construct( false, esc_html__( 'Category_Hierarchy', $this->text_domain ), $widget_options );
	}

	/**
	 * Widget Form Display.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $instance
	 * @return  string Parent::Default return is 'noform'
	 */
	public function form ( $instance ) {
		/** Title form setting */
		$this->form_input_text( 'title', 'Title', $instance['title'] );
	}

	/**
	 * Widget Form Update.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array Parent::Settings to save or bool false to cancel saving.
	 */
	public function update ( $new_instance, $old_instance ) {
		return (array) $new_instance;
	}

	/**
	 * Widget Display.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $args
	 * @param   array $instance
	 */
	public function widget ( $args, $instance ) {
		/** Display widget header. */
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'] . PHP_EOL;

		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'];
			echo $title;
			echo $args['after_title'] . PHP_EOL;
		}

		/** Display widget body. */
		$categories = get_categories( array(
			'child_of' => get_query_var( 'cat' )
		) );

		if ( !empty( $categories ) ) {
			echo '<form id="form-'   . $this->id . '">' . PHP_EOL;
			echo '<select id="select-' . $this->id . '" onchange="categoryHierarchy(this.id);">' . PHP_EOL;
			foreach ( $categories as $category ) {
				echo '<option value="' . get_category_link( $category->term_id ) . '">' . $category->name . '</option>' . PHP_EOL;
			}
			echo '</select>';
			echo '</form>';
		}

		echo $args['after_widget'];

		/** Build select change event JavaScript. */
		echo '<script>';
		echo 'function categoryHierarchy(id) {';
		echo 'let elem = document.getElementById(id);';
		echo 'location.href = elem.value;';
		echo '};';
		echo '</script>';
	}

	
	/**
	 * Create form text
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   string $field
	 * @param   string $label
	 * @param   string $value
	 */
	private function form_input_text ( $field, $label, $value ) {
		$id   = $this->get_field_id( $field );
		$name = $this->get_field_name( $field );

		printf( '<p><label for="%s">%s:</label><br>', $id, esc_html__( $label, $this->text_domain ) );
		printf( '<input type="text" id="%s" name="%s" value="%s" class="widefat"></p>', $id, $name, esc_attr( $value ) );
	}
}