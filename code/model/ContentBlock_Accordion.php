<?php

/**
 * Models a Content Block Accordion
 *
 * @since 1.0.0
 */
class ContentBlock_Accordion extends ContentBlock
{

    private static $db = [
        'AccordionTitle' => 'Text',
        'AccordionSummary' => 'Text',
        'AccordionContent' => 'HTMLText',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->push(
            TextField::create('AccordionTitle')
            ->setDescription('Title line for the Accordion')
        );

        $fields->push(
            TextareaField::create('AccordionSummary')
            ->setDescription('Custom Summary for the Accordion')
        );

        $fields->push(
            HTMLEditorField::create('AccordionContent')
            ->setDescription('Content in the accordion')
            ->setRows(20)
        );

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * Gets the block type for CMS display
     *
     * @return string
     */
    public function getBlockType()
    {
        return 'Accordion';
    }

    /**
     * Gets the configured classes for a column
     *
     * @return string
     */
    public function AccordionClasses()
    {
        $classesArray = Config::inst()->get('ContentBlock_Accordion', 'accordion_classes');

        $this->extend('updateAccordionClasses', $classes);

        return (!empty($classesArray)) ? implode(' ', $classesArray) : '' ;
    }

}
