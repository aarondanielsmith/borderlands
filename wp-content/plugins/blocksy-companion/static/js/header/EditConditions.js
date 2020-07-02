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
	PlacementsDragDropContext
} from 'blocksy-options'
import { __ } from 'ct-i18n'
import useFetch from 'react-fetch-hook'

import createTrigger from 'react-use-trigger'
import useTrigger from 'react-use-trigger/useTrigger'

const getDocument = x =>
	x.document || x.contentDocument || x.contentWindow.document

export const fetchCurrentHeader = () => {
	const document = getDocument(
		wp.customize.previewer.container.find('iframe')[0]
	)

	if (
		wp.customize.previewer.container
			.find('iframe')[0]
			.contentDocument.querySelector('header#header')
	) {
		return wp.customize.previewer.container
			.find('iframe')[0]
			.contentDocument.querySelector('header#header').dataset.id
	}

	return null
}

const requestTrigger = createTrigger()
const EditConditions = ({ forcedEdit = false }) => {
	const [isEditing, setIsEditing] = useState(false)
	const [localConditions, setConditions] = useState(null)
	const { builderValueCollection, builderValueDispatch } = useContext(
		PlacementsDragDropContext
	)

	const containerRef = useRef()

	const requestTriggerValue = useTrigger(requestTrigger)

	const saveSettings = () => {
		wp.ajax
			.send({
				url: `${wp.ajax.settings.url}?action=blocksy_header_update_all_conditions`,
				contentType: 'application/json',
				data: JSON.stringify(localConditions)
			})
			.then(() => {
				requestTrigger()
				setIsEditing(false)
			})
	}

	const { data: conditions, isLoading, error } = useFetch(
		`${blocksy_admin.ajax_url}?action=blocksy_header_get_all_conditions`,
		{
			method: 'POST',
			formatter: async r => {
				const { success, data } = await r.json()

				if (!success || !data.conditions) {
					throw new Error()
				}

				return data.conditions
			},
			depends: [requestTriggerValue]
		}
	)

	return (
		<Fragment>
			{((
				builderValueCollection.__forced_static_header__ ||
				fetchCurrentHeader() ||
				builderValueCollection.current_section
			).indexOf('ct-custom') > -1 ||
				forcedEdit) && (
				<span
					className="ct-instance-button-conditions"
					onClick={() => {
						if (isLoading) {
							return
						}
						setIsEditing(true)
					}}>
					<i className="ct-tooltip-top">
						{sprintf(__('Conditions', 'blc'))}
					</i>
				</span>
			)}
			<Overlay
				items={isEditing}
				initialFocusRef={containerRef}
				className="ct-admin-modal ct-conditions-modal"
				onDismiss={() => {
					setIsEditing(false)
					setConditions(null)
				}}
				render={() => (
					<div className="ct-header-conditions" ref={containerRef}>
						<h1>{sprintf(__('Display Conditions', 'blc'))}</h1>
						<p>
							{__(
								'Add one or more conditions in order to display your header.',
								'blc'
							)}
						</p>
						<OptionsPanel
							onChange={(optionId, cond) => {
								setConditions(localConditions => [
									...(localConditions || conditions).filter(
										({ id }) =>
											id !==
											builderValueCollection.__forced_static_header__
									),
									{
										id:
											builderValueCollection.__forced_static_header__,
										conditions: cond
									}
								])
							}}
							options={{
								conditions: {
									type: 'blocksy-display-condition',
									value: [],
									label: false
								}
							}}
							value={{
								conditions: (
									(localConditions || conditions).find(
										({ id }) =>
											id ===
											(builderValueCollection.__forced_static_header__ ||
												fetchCurrentHeader())
									) || { conditions: [] }
								).conditions
							}}
							hasRevertButton={false}
						/>

						<div className="ct-conditions-actions">
							<button
								className="button-primary"
								disabled={!localConditions}
								onClick={() => saveSettings()}>
								{__('Save Conditions', 'blc')}
							</button>
						</div>
					</div>
				)}
			/>
		</Fragment>
	)
}

export default EditConditions
