import { createElement, Fragment } from '@wordpress/element'
import { __ } from 'ct-i18n'

import { Slot } from '@wordpress/components'

import BuilderTemplates from './BuilderTemplates'
import EditConditions from './EditConditions'
import GlobalHeader from './GlobalHeader'

const PreviewedHeader = () => {
	return (
		<Fragment>
			<h3 className="ct-title">{__('Select Header', 'blc')}</h3>

			<div className="ct-instance-selector">
				<Slot
					name="PlacementsBuilderButtons"
					fillProps={{
						editConditions: () => (
							<EditConditions forcedEdit={true} />
						)
					}}>
					{fills =>
						fills.length === 0 ? (
							<Fragment>
								<BuilderTemplates />
								<EditConditions />
								<GlobalHeader />
							</Fragment>
						) : (
							<Fragment>
								<BuilderTemplates additionType="remove" />
								{fills}
							</Fragment>
						)
					}
				</Slot>
			</div>

			<div className="ct-option-description">
				{__(
					'Set one of these headers as a global one. You can edit them idependently.',
					'blc'
				)}
			</div>
		</Fragment>
	)
}

export default PreviewedHeader
