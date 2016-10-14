<?php

/**
 * Adds Content Block functionality to a page
 *
 * @since 1.0.0
 */
class ContentBlockExtension extends DataExtension
{

    private static $has_many = [
		'ContentBlocks' => 'ContentBlock',
	];

    public function updateCMSFields(FieldList $fields)
    {
        $types = Config::inst()->get('ContentBlock', 'types');
        $fields->addFieldToTab(
			'Root.ContentBlocks',
			GridField::create(
				'ContentBlocks',
				'Content Blocks',
				$this->owner->getComponents('ContentBlocks'),
				GridFieldConfig_RecordEditor::create()
				->addComponent(new GridFieldOrderableRows('Sort'))
                ->removeComponentsByType('GridFieldAddNewButton')
                ->addComponent(GridFieldDropdownAddNewButton::create('ContentBlock', $types)
                ->setButtonName('Add Content Block'))
			)
		);
    }
}
