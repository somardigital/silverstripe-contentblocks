<?php

/**
 * Models a Content Block Case Study
 *
 * @since 1.0.0
 */
class ContentBlock_CaseStudy extends ContentBlock
{

    private static $db = [
        'CaseStudyTitle' => 'Text',
        'CaseStudyContent' => 'HTMLText',
    ];

    private static $has_one = [
        'CaseStudyImage' => 'Image',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->push(
            TextField::create('CaseStudyTitle')
            ->setDescription('Title line for the case study')
        );

        $fields->push(
            HTMLEditorField::create('CaseStudyContent')
            ->setDescription('Content for the case study')
            ->setRows(10)
        );

        $fields->push(
            UploadField::create('CaseStudyImage')
            ->setDescription('This will be cropped into a circle. Please use dimensions: 100px x 100px')
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
        return 'Case Study';
    }

}
