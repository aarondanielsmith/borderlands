<?php

namespace Blocksy;

class ThemeIntegration {
	public function __construct() {
		add_filter(
			'blocksy_add_menu_page',
			function ($res, $options) {
				add_menu_page(
					$options['title'],
					$options['menu-title'],
					$options['permision'],
					$options['top-level-handle'],
					$options['callback'],
					$options['icon-url'],
					2
				);

				return true;
			},
			10, 2
		);

		add_action('rest_api_init', function () {
			return;

			register_rest_field('post', 'images', [
				'get_callback' => function () {
					return wp_prepare_attachment_for_js($object->id);
				},
				'update_callback' => null,
				'schema' => null,
			]);
		});

		add_filter(
			'user_contactmethods',
			function ( $field ) {
				$fields['facebook'] = __( 'Facebook', 'blc' );
				$fields['twitter'] = __( 'Twitter', 'blc' );
				$fields['linkedin'] = __( 'LinkedIn', 'blc' );
				$fields['dribbble'] = __( 'Dribbble', 'blc' );
				$fields['instagram'] = __( 'Instagram', 'blc' );

				return $fields;
			}
		);

		add_filter(
			'wp_check_filetype_and_ext',
			function ($data=null, $file=null, $filename=null, $mimes=null) {
				if (strpos($filename, '.svg') !== false) {
					$data['type'] = 'image/svg+xml';
					$data['ext'] = 'svg';
				}

				return $data;
			},
			75, 4
		);

		add_filter('upload_mimes', function ($mimes) {
			$mimes['svg'] = 'image/svg+xml';

			return $mimes;
		});

		add_filter('blocksy_changelogs_list', function ($changelogs) {
			$changelog = null;
			$access_type = get_filesystem_method();

			if ($access_type === 'direct') {
				$creds = request_filesystem_credentials(
					site_url() . '/wp-admin/',
					'', false, false,
					[]
				);

				if ( WP_Filesystem($creds) ) {
					global $wp_filesystem;

					$readme = $wp_filesystem->get_contents(
						BLOCKSY_PATH . '/readme.txt'
					);

					if ($readme) {
						$readme = explode('== Changelog ==', $readme);

						if (isset($readme[1])) {
							$changelog = trim($readme[1]);
						}
					}
				}
			}

			$changelogs[] = [
				'title' => __('Companion', 'blc'),
				'changelog' => $changelog
			];

			return $changelogs;
		});

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) return;

			/*
			wp_enqueue_style(
				'blocksy-companion-styles',
				BLOCKSY_URL . 'static/bundle/main.css',
				['ct-main-styles'],
				$data['Version']
			);
			 */

			wp_enqueue_script(
				'blocksy-companion-scripts',
				BLOCKSY_URL . 'static/bundle/main.js',
				['ct-scripts', 'ct-events'],
				$data['Version'],
				true
			);

			$data = [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'public_url' => BLOCKSY_URL . 'framework/extensions/instagram/static/bundle/',
			];

			wp_localize_script(
				'blocksy-ext-instagram-scripts',
				'blocksy_ext_instagram_localization',
				$data
			);
		});

		add_action(
			'customize_preview_init',
			function () {
				$data = get_plugin_data(BLOCKSY__FILE__);

				wp_enqueue_script(
					'blocksy-companion-sync-scripts',
					BLOCKSY_URL . 'static/bundle/sync.js',
					['ct-events'],
					$data['Version'],
					true
				);
			}
		);
	}
}
