<?php

$options = [
	blocksy_rand_md5() => [
		'title' => __( 'General', 'blc' ),
		'type' => 'tab',
		'options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'Login State', 'blocksy' ),
			],

			'login_style' => [
				'label' => false,
				'type' => 'ct-checkboxes',
				'design' => 'block',
				'view' => 'text',
				'disableRevertButton' => true,
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'icon' => true,
					'label' => false,
				],

				'choices' => blocksy_ordered_keys([
					'icon' => __( 'Icon', 'blocksy' ),
					'label' => __( 'Label', 'blocksy' ),
				]),
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'login_style/icon' => true ],
				'options' => [

					'accountHeaderIconSize' => [
						'label' => __( 'Icon Size', 'blc' ),
						'type' => 'ct-slider',
						'min' => 5,
						'max' => 50,
						'value' => 15,
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'login_style/label' => true ],
				'options' => [

					'login_label' => [
						'label' => __('Label', 'blc'),
						'type' => 'text',
						'design' => 'inline',
						'disableRevertButton' => true,
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => __('Login', 'blc')
					],

				],
			],


			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'Logged In State', 'blocksy' ),
			],

			'loggedin_style' => [
				'label' => false,
				'type' => 'ct-checkboxes',
				'design' => 'block',
				'view' => 'text',
				'disableRevertButton' => true,
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'avatar' => true,
					'label' => false,
				],

				'choices' => blocksy_ordered_keys([
					'avatar' => __( 'Avatar', 'blocksy' ),
					'label' => __( 'Label', 'blocksy' ),
				]),
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'loggedin_style/avatar' => true ],
				'options' => [

					'accountHeaderAvatarSize' => [
						'label' => __( 'Avatar Size', 'blc' ),
						'type' => 'ct-slider',
						'min' => 10,
						'max' => 40,
						'value' => 18,
						'responsive' => true,
						'setting' => [ 'transport' => 'postMessage' ],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'loggedin_style/label' => true ],
				'options' => [

					'loggedin_label' => [
						'label' => __('Label'),
						'type' => 'text',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => __('My Account', 'blc')
					],

				],
			],

			'account_link' => [
				'label' => __( 'Action', 'blc' ),
				'type' => 'ct-select',
				'value' => 'profile',
				'view' => 'text',
				'design' => 'inline',
				'desc' => __( 'Set the action you want to make when clicking on the element whyile you are logged in.', 'blc' ),
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => blocksy_ordered_keys(
					[
						'profile' => __( 'Profile Page', 'blc' ),
						'dashboard' => __( 'Dashboard Page', 'blc' ),
						'logout' => __( 'Logout', 'blc' ),
						'custom' => __( 'Custom Page', 'blc' ),
					]
				),
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'account_link' => 'custom' ],
				'options' => [

					'account_custom_page' => [
						'label' => __( 'Custom Page Link', 'blc' ),
						'type' => 'text',
						'design' => 'inline',
						'disableRevertButton' => true,
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => ''
					],

				],
			],

		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blc' ),
		'type' => 'tab',
		'options' => [

			'accountHeaderColor' => [
				'label' => __( 'Content Color', 'blc' ),
				'type'  => 'ct-color-picker',
				'design' => 'block:right',
				'divider' => 'bottom',
				'responsive' => true,
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--color)',
					],

					'hover' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blc' ),
						'id' => 'default',
					],

					[
						'title' => __( 'Hover', 'blc' ),
						'id' => 'hover',
						'inherit' => 'var(--linkHoverColor)'
					],
				],
			],

			'accountHeaderMargin' => [
				'label' => __( 'Item Margin', 'blc' ),
				'type' => 'ct-spacing',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_spacing_value([
					'linked' => true,
				]),
				'responsive' => true
			],

			'accountHeaderBackground' => [
				'label' => __( 'Background', 'blc' ),
				'type'  => 'ct-background',
				'design' => 'inline',
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_background_default_value([
					'backgroundColor' => [
						'default' => [
							'color' => 'rgba(18, 21, 25, 0.7)'
						],
					],
				])
			],

		],
	],
];

