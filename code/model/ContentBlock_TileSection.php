<?php

/**
 * Models a Content Block Tile Section
 *
 * @since 1.0.0
 */
class ContentBlock_TileSection extends ContentBlock
{
    private static $db = [
        'TilesPerRow' => 'Enum("One, Two, Three")',
        'TileTemplate' => 'Text'
    ];

    private static $has_many = [
        'ContentTiles' => 'TileSection_ContentTile',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->push(DropdownField::create(
            'TilesPerRow',
            'Tiles Per Row',
            singleton('ContentBlock_TileSection')
            ->dbObject('TilesPerRow')
            ->enumValues()
        ));

        $fields->push(DropdownField::create(
            'TileTemplate',
            'Tile Template',
            $this->getAvailableTemplates()
        ));

        if ($this->getField('ID')) {
            $fields->push(GridField::create(
                'ContentTiles',
                'Content Tiles',
                $this->ContentTiles(),
                GridFieldConfig_RecordEditor::create()
                ->addComponent(new GridFieldOrderableRows('Sort'))
            ));
        } else {
            $fields->push(LiteralField::create(
                'Unsaved',
                '<p class="message info">Please save first, to begin adding Tiles </p>'
            ));
        }

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * Gets available templates from the static configuration
     *
     * @return array
     */
     public function getAvailableTemplates()
     {
         $templates = Config::inst()->get('ContentBlock_TileSection', 'tile_templates');

         $this->extend('updateAvailableTemplates', $templates);

         return (!empty($templates)) ? $templates : [] ;
     }


    /**
     * Gets the block type for CMS display
     *
     * @return string
     */
    public function getBlockType()
    {
        return 'Tile Section';
    }
}
