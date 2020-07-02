<?php

if (! function_exists('blocksy_is_page_title_default')) {
	function blocksy_is_page_title_default() {
		if (blocksy_is_page() || is_single()) {
			$post_options = blocksy_get_post_options();

			$mode = blocksy_akg('has_hero_section', $post_options, 'default');

			if ($mode !== 'default') {
				return false;
			}
		}

		return true;
	}
}

if (! function_exists('blocksy_get_page_title_source')) {
	function blocksy_get_page_title_source() {
		static $result = null;

		if (! is_null($result)) {
			if (! is_customize_preview()) {
				return $result;
			}
		}

		$prefix = blocksy_manager()->get_prefix_for_current_screen();

		if (strpos($prefix, 'single') !== false || (
			function_exists('is_shop') && is_shop()
		)) {
			$post_options = blocksy_get_post_options();

			$mode = blocksy_akg('has_hero_section', $post_options, 'default');

			if ($mode === 'disabled') {
				$result = false;
				return $result;
			}

			if ($mode === 'enabled')  {
				$result = [
					'strategy' => $post_options
				];
				return $result;
			}
		}

		$default_value = 'yes';

		if ($prefix === 'blog') {
			$default_value = 'no';
		}

		if (get_theme_mod($prefix . '_hero_enabled', $default_value) === 'no') {
			$result = false;
			return $result;
		}

		$result = [
			'strategy' => 'customizer',
			'prefix' => $prefix
		];

		return $result;
	}
}

if (! function_exists('blocksy_hero_get_deep_link')) {
	function blocksy_hero_get_deep_link($source) {
		if (! $source) {
			return null;
		}

		if (! isset($source['prefix'])) {
			return null;
		}

		if ($source['prefix'] === 'blog') {
			return 'blog_posts:blog_page_title_enabled';
		}

		if ($source['prefix'] === 'author') {
			return 'author_page:author_page_title';
		}

		if ($source['prefix'] === 'search') {
			return 'search_page:search_page_title_enabled';
		}

		if ($source['prefix'] === 'woo_categories') {
			return 'woocomerrce_posts_archives:woo_categories_has_page_title';
		}

		if ($source['prefix'] === 'categories') {
			return 'archive_blog_posts_categories:categories_has_page_title';
		}

		if ($source['prefix'] === 'single_page') {
			return 'single_pages:single_page_title_enabled';
		}

		if ($source['prefix'] === 'single_blog_post') {
			return 'single_blog_posts:single_blog_post_title_enabled';
		}

		return null;
	}
}

if (! function_exists('blocksy_output_hero_section')) {
	function blocksy_output_hero_section($type = 'type-1', $source = false) {
		if (! $source) {
			$source = blocksy_get_page_title_source();
		}

		if (! $source) {
			return '';
		}

		$default_type = 'type-1';

		if (
			((
				function_exists('is_woocommerce')
				&&
				(
					is_product_category()
					||
					is_product_tag()
					||
					is_shop()
				)
			) || is_author())
			&&
			blocksy_get_page_title_source()['strategy'] === 'customizer'
		) {
			$default_type = 'type-2';
		}

		$actual_type = blocksy_akg_or_customizer(
			'hero_section',
			blocksy_get_page_title_source(),
			$default_type
		);

		if (! $type) {
			$type = $actual_type;
		}

		if ($type !== $actual_type) {
			return '';
		}

		$elements = blocksy_render_view(
			dirname(__FILE__) . '/hero/elements.php',
			[
				'type' => $type
			]
		);

		if ($type !== 'type-1' && $type !== 'type-2') {
			return '';
		}

		ob_start();

		do_action('blocksy:hero:before');

		$attr = [
			'class' => 'hero-section',
			'data-type' => $type
		];

		if (
			is_customize_preview()
			&&
			blocksy_is_page_title_default()
			&&
			blocksy_hero_get_deep_link(blocksy_get_page_title_source())
		) {
			$attr['data-shortcut'] = 'border';
			$attr['data-location'] = blocksy_hero_get_deep_link(blocksy_get_page_title_source());
		}

		echo blocksy_render_view(
			dirname(__FILE__) . '/hero/' . $type . '.php',
			[
				'type' => $type,
				'elements' => $elements,
				'attr' => $attr
			]
		);

		do_action('blocksy:hero:after');

		return ob_get_clean();
	}
}

