<?php

// Icon size
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-header-account',
	'variableName' => 'iconSize',
	'value' => blocksy_akg('accountHeaderIconSize', $atts, [
		'mobile' => 15,
		'tablet' => 15,
		'desktop' => 15,
	])
]);

// Avatar size
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-header-account',
	'variableName' => 'avatarSize',
	'value' => blocksy_akg('accountHeaderAvatarSize', $atts, [
		'mobile' => 22,
		'tablet' => 22,
		'desktop' => 22,
	])
]);


// Content color
blocksy_output_colors([
	'value' => blocksy_akg('accountHeaderColor', $atts),
	'default' => [
		'default' => [ 'color' => 'var(--color)' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => '.ct-header-account',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.ct-header-account',
			'variable' => 'linkHoverColor'
		],
	],
	'responsive' => true
]);


// Modal background
blocksy_output_background_css([
	'selector' => '#account-modal',
	'css' => $css,
	'value' => blocksy_akg('accountHeaderBackground', $atts,
		blocksy_background_default_value([
			'backgroundColor' => [
				'default' => [
					'color' => 'rgba(18, 21, 25, 0.7)'
				],
			],
		])
	)
]);


// Item margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-header-account',
	'important' => true,
	'value' => blocksy_default_akg(
		'accountHeaderMargin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);

