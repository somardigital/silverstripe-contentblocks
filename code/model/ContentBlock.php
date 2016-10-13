<?php

/**
 * Models a Content Block - a base class for different types of Content Blocks
 *
 * @since 1.0.0
 * @package silverstripe-contentblocks
 */
class ContentBlock extends DataObject
{

    private static $casting = [
        'RenderBlock' => 'HTMLText'
    ];

    private static $db = [
        'Sort' => 'Int',
        'Title' => 'Text',
    ];

    private static $has_one = [
        'ParentPage' => 'SiteTree',
    ];

    private static $default_sort = 'Sort ASC';


    public function getCMSFields()
    {
        return FieldList::create([
            TextField::create('Title')
            ->setDescription('For CMS Identification')
        ]);
    }

    /**
     * @return RequiredFields
     */
    public function getCMSValidator()
    {
        return RequiredFields::create([
            'Title'
        ]);
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if (!$this->getField('Title')) {
            $this->Title = sprintf('New %s', $this->getBlockType());
        }
    }

    /**
     * @return string
     */
    public function getTemplateName()
    {
        $template = $this->getField('ClassName');
        $this->extend('updateTemplateName', $template);
        return $template;
    }

    /**
     * Renders the block for template
     *
     * @return string
     */
    public function RenderBlock()
    {
        if (Config::inst()->get('ContentBlock', 'include_bootstrap')) {
            Requirements::javascript(CONTENTBLOCKS_DIR . '/javascript/lib/bootstrap.min.js');
            Requirements::css(CONTENTBLOCKS_DIR . '/css/lib/bootstrap.min.css');
        }
        return $this->renderWith($this->getTemplateName());
    }

    /**
     * Gets the block type for CMS display
     *
     * @return string
     */
    public function getBlockType()
    {
        return 'Content Block';
    }

}
