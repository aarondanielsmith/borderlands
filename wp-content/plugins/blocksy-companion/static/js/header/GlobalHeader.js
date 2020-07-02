import {
	createElement,
	Fragment,
	Component,
	useContext,
	useRef,
	useState
} from '@wordpress/element'
import {
	Overlay,
	OptionsPanel,
	getValueFromInput,
	PlacementsDragDropContext,
	Switch
} from 'blocksy-options'
import { __ } from 'ct-i18n'
import classnames from 'classnames'

import { fetchCurrentHeader } from './EditConditions'

const GlobalHeader = () => {
	const { builderValueCollection, builderValueDispatch } = useContext(
		PlacementsDragDropContext
	)

	if (
		(
			builderValueCollection.__forced_static_header__ ||
			fetchCurrentHeader() ||
			builderValueCollection.current_section
		).indexOf('ct-custom') > -1
	) {
		return null
	}

	return (
		<span
			className={classnames('ct-instance-button-global', {
				active:
					builderValueCollection.current_section ===
					builderValueCollection.__forced_static_header__
			})}
			onClick={() => {
				builderValueDispatch({
					type: 'MARK_HEADER_AS_GLOBAL',
					payload: {}
				})
			}}>
			<svg width="16" height="16" viewBox="0 0 16 16">
				<path d="M16,0v6h-6l2.2-2.2C11.1,2.6,9.6,2,8,2C5.1,2,2.6,4.1,2.1,7h-2c0,0,0-0.1,0-0.1C0.6,2.9,4,0,8,0c2.1,0,4.2,0.9,5.6,2.4L16,0z M8,14c-1.7,0-3.2-0.6-4.4-1.6L6,10H0v6l2.2-2.2C3.7,15.2,5.8,16,8,16c4.1,0,7.4-3.1,7.9-7h-2C13.4,11.8,11,14,8,14z" />
			</svg>

			<i className="ct-tooltip-top">
				{builderValueCollection.current_section ===
				builderValueCollection.__forced_static_header__
					? __('Is Global', 'blocksy')
					: __('Make Global', 'blocksy')}
			</i>
		</span>
	)
}

export default GlobalHeader
