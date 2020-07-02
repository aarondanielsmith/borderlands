<?php

if (get_theme_mod('emoji_scripts', 'no') !== 'yes') {
	add_filter('tiny_mce_plugins', function ($plugins) {
		if (is_array($plugins)) {
			return array_diff($plugins, array('wpemoji'));
		} else {
			return array();
		}
	});

	add_filter('wp_resource_hints', function ($urls, $relation_type) {
		if ('dns-prefetch' === $relation_type) {
			/** This filter is documented in wp-includes/formatting.php */
			$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

			$urls = array_diff($urls, array($emoji_svg_url));
		}

		return $urls;
	}, 10, 2);
}
