import ctEvents from 'ct-events'
import {
	updateAndSaveEl,
	handleBackgroundOptionFor
} from 'blocksy-customizer-sync'
import { markImagesAsLoaded } from '../../../../extensions/cookies-consent/static/js/lazy-load-helpers'

ctEvents.on(
	'ct:header:sync:collect-variable-descriptors',
	variableDescriptors => {
		variableDescriptors['account'] = {
			accountHeaderIconSize: {
				selector: '.ct-header-account',
				variable: 'iconSize',
				responsive: true,
				unit: 'px'
			},

			accountHeaderAvatarSize: {
				selector: '.ct-header-account',
				variable: 'avatarSize',
				responsive: true,
				unit: 'px'
			},

			accountHeaderColor: [
				{
					selector: '.ct-header-account',
					variable: 'linkInitialColor',
					type: 'color:default',
					responsive: true
				},

				{
					selector: '.ct-header-account',
					variable: 'linkHoverColor',
					type: 'color:hover',
					responsive: true
				}
			],

			...handleBackgroundOptionFor({
				id: 'accountHeaderBackground',
				selector: '#account-modal'
			}),

			accountHeaderMargin: {
				selector: '.ct-header-account',
				type: 'spacing',
				variable: 'margin',
				responsive: true,
				important: true
			}
		}
	}
)

ctEvents.on(
	'ct:header:sync:item:account',
	({ values: { loggedin_style, loggedin_label }, optionId, optionValue }) => {
		const selector = '[data-id="account"]'

		if (optionId === 'loggedin_style' || optionId === 'loggedin_label') {
			updateAndSaveEl(selector, el => {
				;[...el.querySelectorAll('.ct-label')].map(label => {
					label.removeAttribute('hidden')

					if (!loggedin_style.label) {
						label.hidden = true
					}

					label.innerHTML = loggedin_label
				})
				;[...el.querySelectorAll('.ct-image-container')].map(img => {
					img.removeAttribute('hidden')

					if (!loggedin_style.avatar) {
						img.hidden = true
					}

					markImagesAsLoaded(img.parentNode)
				})
			})
		}
	}
)
