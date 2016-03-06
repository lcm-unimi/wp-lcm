<?php 
// Flickr widget for hemingway WordPress theme
class LCM_Social_Media_Widget extends WP_Widget{

	private $networks;

	function __construct() {
		parent::__construct(
			'LCM_Social_Media_Widget',
			__('LCM social Media', 'hemingway'),
			array(
				'description' => __( 'Connect your social media!', 'hemingway' )
			)
		);

		$this->networks = apply_filters('LCM_Social_Media_Widget', array(
			'facebook' => __('Facebook', 'vantage'),
			'twitter' => __('Twitter', 'vantage'),
			'google-plus' => __('Google Plus', 'vantage'),
			'github' => __('GitHub','vantage'),
			'rss' => __('RSS', 'vantage'),
		));
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		echo $args['before_widget'];

		if(!empty($instance['title'])) {
			echo $args['before_title'].$instance['title'].$args['after_title'];
		}

		foreach($this->networks as $id => $name) {
			if(!empty($instance[$id])) {
				?><a class="social-media-icon social-media-icon-<?php echo $id ?> social-media-icon-<?php echo esc_attr($instance['size']) ?>" href="<?php echo esc_url( $instance[$id], array('http', 'https', 'mailto', 'skype') ) ?>" title="<?php echo esc_html( get_bloginfo('name') . ' ' . $name ) ?>" <?php if(!empty($instance['new_window'])) echo 'target="_blank"'; ?>><?php

				$icon = apply_filters('social_widget_icon_'.$id, '');
				if(!empty($icon)) echo $icon;
				else echo '<span class="fa fa-' . $id . '"></span>';

				?></a><?php
			}
		}

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'size' => 'medium',
			'title' => '',
			'new_window' => false,
		) );

		$sizes = apply_filters('vantage_social_widget_sizes', array(
			'medium' => __('Medium', 'vantage'),
		));

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title', 'vantage') ?></label><br/>
			<input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?>" value="<?php echo esc_attr($instance['title']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('size') ?>"><?php _e('Icon Size', 'vantage') ?></label><br/>
			<select id="<?php echo $this->get_field_id('size') ?>" name="<?php echo $this->get_field_name('size') ?>">
				<?php foreach($sizes as $id => $name) : ?>
					<option value="<?php echo esc_attr($id) ?>" <?php selected($instance['size'], $id) ?>><?php echo esc_html($name) ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php

		foreach($this->networks as $id => $name) {
			?>
			<p>
				<label for="<?php echo $this->get_field_id($id) ?>"><?php echo $name ?></label>
				<input type="text" id="<?php echo $this->get_field_id($id) ?>" name="<?php echo $this->get_field_name($id) ?>" value="<?php echo esc_attr(!empty($instance[$id]) ? $instance[$id] : '') ?>" class="widefat"/>
			</p>
		<?php
		}

		?>
		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name('new_window') ?>" id="<?php echo $this->get_field_id('new_window') ?>" <?php checked($instance['new_window']) ?> />
			<label for="<?php echo $this->get_field_id('new_window') ?>"><?php _e('Open in New Window', 'vantage') ?></label>

		</p>
		<?php

	}

	public function update( $new_instance, $old_instance ) {
		$new_instance['new_window'] = !empty($new_instance['new_window']);
		return $new_instance;
	}

}

register_widget('LCM_Social_Media_Widget'); ?>
