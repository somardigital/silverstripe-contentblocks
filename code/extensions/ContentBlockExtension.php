<?php

/**
 * Adds Content Block functionality to a page
 *
 * @since 1.0.0
 * @package contentblocks
 */
class ContentBlockExtension extends DataExtension
{

    private static $has_many = [
		'ContentBlocks' => 'ContentBlock',
	];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab(
			'Root.ContentBlocks',
			GridField::create(
				'ContentBlocks',
				'Content Blocks',
				$this->owner->getComponents('ContentBlocks'),
				GridFieldConfig_RecordEditor::create()
				->addComponent(new GridFieldOrderableRows('Sort'))
				->addComponent(
					GridFieldAddClassesButton::create('ContentBlock_CaseStudy')
					->setButtonName('Add Case Study')
				)
				->addComponent(
					GridFieldAddClassesButton::create('ContentBlock_TileSection')
					->setButtonName('Add Tile Section')
				)
				->addComponent(
					GridFieldAddClassesButton::create('ContentBlock_ColumnLayout')
					->setButtonName('Add Column Layout')
				)
				->addComponent(
					GridFieldAddClassesButton::create('ContentBlock_Accordion')
					->setButtonName('Add Accordion')
				)
				->removeComponentsByType('GridFieldAddNewButton')
			)
		);
    }
}
