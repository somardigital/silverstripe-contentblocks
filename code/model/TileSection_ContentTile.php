<?php
/**
 * Models a Content Tile for a {@link ContentBlock_TileSection}
 *
 * @since 1.0.0
 */
class TileSection_ContentTile extends DataObject
{
    private static $singular_name = 'Content Tile';
    private static $plural_name = 'Content Tiles';

    private static $casting = [
        'RenderTile' => 'HTMLText'
    ];

    private static $db = [
        'Title' => 'Text',
        'Caption' => 'Text',
        'Sort' => 'Int'
    ];

    private static $has_one = [
        'Image' => 'Image',
        'Link' => 'Link',
        'Parent' => 'ContentBlock_TileSection',
    ];

    private static $default_sort = 'Sort ASC';

    public function getCMSFields()
    {
        $fields = FieldList::create([
            TextField::create('Title'),
            TextareaField::create('Caption'),
            UploadField::create('Image'),
            LinkField::create('LinkID'),
        ]);

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * @return RequiredFields
     */
    public function getCMSValidator()
    {
        return RequiredFields::create(array(
            'Title',
            'Image',
            'LinkID',
        ));
    }

    /**
     * Gets the chosen template name from the parent {@link ContentBlock_TileSection}
     *
     * @return string
     */
    public function getTemplateName()
    {
        if ($parent = $this->getComponent('Parent')) {
            return $parent->getField('TileTemplate');
        }
    }

    /**
     * Renders the Tile into the parent {@link ContentBlock_TileSection}'s chosen template
     *
     * @return string
     */
    public function RenderTile()
    {
        if ($template = $this->getTemplateName()) {
            return $this->renderWith($template);
        }
    }

    /**
     * Gets the configured classes for a row
     *
     * @return string
     */
    public function TileClasses()
    {
        $classesArray = Config::inst()->get('ContentBlock_TileSection', 'tile_classes');

        $this->extend('updateTileClasses', $classes);

        return (!empty($classesArray)) ? implode(' ', $classesArray) : '' ;
    }
}
