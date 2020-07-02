<?php

class Blocksy_Manager {
	public static $instance = null;

	public $builder = null;

	public $header_builder = null;
	public $footer_builder = null;

	public $post_types = null;

	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function get_prefix_for_current_screen($args = []) {
		$args = wp_parse_args($args, [
			'allowed_prefixes' => null,
			'default_prefix' => null
		]);

		if (function_exists('is_lifterlms') && is_lifterlms()) {
			return 'lms';
		}

		$actual_prefix = null;

		if (function_exists('is_bbpress') && (
			get_post_type() === 'forum'
			||
			get_post_type() === 'topic'
			||
			get_post_type() === 'reply'
		)) {
			$actual_prefix = 'bbpress_single';
		}

		if (function_exists('is_buddypress') && (
			is_buddypress()
		)) {
			$actual_prefix = 'buddypress_single';
		}

		if (blocksy_is_page([
			'shop_is_page' => false,
			'blog_is_page' => false
		]) || is_single()) {
			if (is_single()) {
				$post_type = blocksy_manager()->post_types->is_supported_post_type();

				if ($post_type) {
					$actual_prefix = $post_type . '_single';
				}
			}

			if (! $actual_prefix) {
				$actual_prefix = blocksy_is_page() ? 'single_page' : 'single_blog_post';
			}
		}

		if (function_exists('is_product_category')) {
			if (is_product_category() || is_product_tag() || is_shop()) {
				$actual_prefix = 'woo_categories';
			}

			if (is_product()) {
				$actual_prefix = 'product';
			}
		}

		if (
			(
				is_category()
				||
				is_tag()
				||
				is_tax()
				||
				is_archive()
				||
				is_post_type_archive()
			) && ! is_author() && ! $actual_prefix
		) {
			$post_type = blocksy_manager()->post_types->is_supported_post_type();

			if ($post_type) {
				$actual_prefix = $post_type . '_archive';
			} else {
				$actual_prefix = 'categories';
			}
		}

		if (is_search()) {
			$actual_prefix = 'search';
		}

		if (is_author()) {
			$actual_prefix = 'author';
		}

		if (is_home()) {
			$actual_prefix = 'blog';
		}

		if (
			! $actual_prefix
			|| (
				$args['allowed_prefixes'] && ! in_array(
					$actual_prefix,
					$args['allowed_prefixes']
				) && strpos($actual_prefix, '_archive') === false
			)
		) {
			$actual_prefix = $args['default_prefix'];
		}

		return $actual_prefix;
	}

	private function __construct() {
		$this->early_init();
	}

	private function early_init() {
		$this->builder = new Blocksy_Customizer_Builder();

		$this->header_builder = new Blocksy_Header_Builder();
		$this->footer_builder = new Blocksy_Footer_Builder();
		$this->post_types = new Blocksy_Custom_Post_Types();

		add_filter('block_parser_class', function () {
			return 'Blocksy_WP_Block_Parser';
		});
	}
}

function blocksy_manager() {
	return Blocksy_Manager::instance();
}
