import {
	createElement,
	Component,
	useContext,
	useState,
	Fragment
} from '@wordpress/element'

import cls from 'classnames'
import { Select, PlacementsDragDropContext } from 'blocksy-options'
import { __ } from 'ct-i18n'

const BuilderTemplates = ({
	// global | remove
	additionType = 'global'
}) => {
	const {
		builderValueCollection,
		builderValue,
		builderValueDispatch
	} = useContext(PlacementsDragDropContext)

	const secondaryItems =
		ct_customizer_localizations.header_builder_data.secondary_items.header
	const allItems = ct_customizer_localizations.header_builder_data.header

	return (
		<Select
			onChange={id =>
				builderValueDispatch({
					type: 'PICK_BUILDER_SECTION',
					payload: {
						id
					}
				})
			}
			option={{
				placeholder: __('Picker header', 'blocksy'),
				choices: builderValueCollection.sections.map(
					({ name, id }) => ({
						key: id,
						value:
							name ||
							{
								'type-1': __('Default', 'blocksy'),
								'type-2': __('Centered', 'blocksy'),
								'type-3': __('Secondary', 'blocksy')
							}[id] ||
							id
					})
				)
			}}
			renderItemFor={item => (
				<Fragment>
					<span>{item.value}</span>

					{additionType === 'global' &&
						builderValueCollection.current_section === item.key && (
							<span
								className="ct-global-item"
								title={__('Global header', 'blc')}
								onClick={e => {}}>
								{__('Global', 'blc')}
							</span>
						)}

					{additionType === 'remove' &&
						item.key !== builderValue.id &&
						item.key.indexOf('ct-custom') > -1 &&
						item.key !== 'ct-custom-transparent' && (
							<span
								className="ct-remove-item"
								title="Remove header"
								onClick={e => {
									e.preventDefault()
									e.stopPropagation()

									builderValueDispatch({
										type: 'REMOVE_BUILDER_SECTION',
										payload: {
											id: item.key
										}
									})
								}}></span>
						)}
				</Fragment>
			)}
			value={builderValue.id}
		/>
	)
}

export default BuilderTemplates
