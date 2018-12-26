<?php
/**
 * Recent Posts widget for Clean Blogging Theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package clean-blogging
 */

class Clean_Blogging_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname'   => 'clean_blogging_widget_recent_posts',
			'description' => __( 'Displays recent blog entries.', 'clean-blogging' ),
		);
		parent::__construct( 'clean_blogging_widget_recent_posts', __( 'Recent Posts', 'clean-blogging' ), $widget_ops );
	}

	function widget( $args, $instance ) {

		// Outputs the content of the widget.
		extract( $args ); // Make before_widget, etc available.

		$widget_title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'clean-blogging' );

		$number_of_posts = null;

		$widget_title    = apply_filters( 'widget_title', $instance['widget_title'], $this->id_base );
		$number_of_posts = esc_attr( $instance['number_of_posts'] );

		echo $before_widget;

		if ( ! empty( $widget_title ) ) {

			echo $before_title . esc_html( $widget_title ) . $after_title;

		}
		if ( $number_of_posts === 0 ) {
			$number_of_posts = 5;
		}
			global $post;

			$recent_posts = get_posts(
				array(
					'posts_per_page' => $number_of_posts,
					'post_status'    => 'publish',
				)
			);

		if ( $recent_posts ) :
		?>
				<ul class="clean-blogging-widget-list">
					<?php
					foreach ( $recent_posts as $post ) :
						setup_postdata( $post );
						?>
						<li>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<div class="post-icon">
									<?php
									$post_format = get_post_format() ? get_post_format() : 'standard';
									if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'thumbnail' );
									} elseif ( $post_format === 'gallery' ) {
											$attachment_parent = get_the_ID();
											$images            = get_posts(
												array(
													'numberposts' => 1,
													'orderby' => 'menu_order',
													'order'   => 'ASC',
													'post_parent' => $attachment_parent,
													'post_type' => 'attachment',
													'post_status' => null,
													'post_mime_type' => 'image',
												)
											);
										if ( $images ) {
											foreach ( $images as $image ) {
												$attimg = wp_get_attachment_image( $image->ID, 'thumbnail' );
												echo esc_attr( $attimg );
											}
										} else {
											?>
											<div class="icon-doc"></div>
											<?php
										}
									} else {
										?>
										<div class="icon-doc"></div>
									<?php } ?>
								</div>
								<div class="inner">
									<p class="title"><?php the_title(); ?></p>
									<p class="meta"><?php the_time( get_option( 'date_format' ) ); ?></p>
								</div>
								<div class="clear"></div>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		<?php
		echo $after_widget;
	}


	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['widget_title'] = sanitize_text_field( $new_instance['widget_title'] );

		// Make sure we are getting a number.
		$instance['number_of_posts'] = is_int( intval( $new_instance['number_of_posts'] ) ) ? intval( $new_instance['number_of_posts'] ) : 5;

		// Update and save the widget.
		return $instance;

	}

	function form( $instance ) {

		// Set defaults.
		if ( ! isset( $instance['widget_title'] ) ) {
			$instance['widget_title'] = '';
		}
		if ( ! isset( $instance['number_of_posts'] ) ) {
			$instance['number_of_posts'] = 5;
		}

		// Get the options into variables, escaping html characters on the way.
		$widget_title    = $instance['widget_title'];
		$number_of_posts = $instance['number_of_posts'];
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>"><?php _e( 'Title', 'clean-blogging' ); ?>:
			<input id="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'widget_title' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $widget_title ); ?>" /></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>"><?php _e( 'Number of posts to display', 'clean-blogging' ); ?>:
			<input id="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_posts' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $number_of_posts ); ?>" /></label>
			<small>(<?php _e( 'Defaults to 5 if empty', 'clean-blogging' ); ?>)</small>
		</p>
		<?php
	}
}
register_widget( 'Clean_Blogging_Recent_Posts' );
