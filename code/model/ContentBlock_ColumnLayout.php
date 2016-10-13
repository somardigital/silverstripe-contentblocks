<?php

/**
 * Models a Content Block Column Layout
 *
 * @since 1.0.0
 * @package silverstripe-contentblocks
 */
class ContentBlock_ColumnLayout extends ContentBlock
{

    private static $db = [
        'Layout' => 'Enum("One Column, Two Column, Three Column")',
        'ColumnOneContent' => 'HTMLText',
        'ColumnTwoContent' => 'HTMLText',
        'ColumnThreeContent' => 'HTMLText',
        'ColumnOneColour' => 'Varchar',
        'ColumnTwoColour' => 'Varchar',
        'ColumnThreeColour' => 'Varchar',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->push(
            DropdownField::create('Layout')
            ->setSource(
                singleton('ContentBlock_ColumnLayout')
                ->dbObject('Layout')
                ->enumValues()
            )
        );

        $colourSource = Config::inst()->get('ContentBlock_ColumnLayout', 'colour_options');

        //Column One -------
        $columnOne = DisplayLogicWrapper::create(CompositeField::create([
             HeaderField::create('ColumnOne', 'Column One'),
             DropdownField::create(
                 'ColumnOneColour',
                 'Colour',
                 $colourSource
             ),
             HTMLEditorField::create('ColumnOneContent', 'Content'),
        ]));
        //Display if One Column || Two Column || Three Column
        $columnOne->displayIf('Layout')->isEqualTo('One Column')
            ->orIf('Layout')->isEqualTo('Two Column')
            ->orIf('Layout')->isEqualTo('Three Column');
        $fields->push($columnOne);

        //Column Two -------
        //Display if Two Column
        $columnTwo = DisplayLogicWrapper::create(CompositeField::create([
             HeaderField::create('ColumnTwo', 'Column Two'),
             DropdownField::create(
                 'ColumnTwoColour',
                 'Colour',
                 $colourSource
             ),
             HTMLEditorField::create('ColumnTwoContent', 'Content'),
        ]));
        $columnTwo->displayIf('Layout')->isEqualTo('Two Column')
            ->orIf('Layout')->isEqualTo('Three Column');
        $fields->push($columnTwo);

        //Column Three -------
        $columnThree =  DisplayLogicWrapper::create(CompositeField::create([
             HeaderField::create('ColumnThree', 'Column Three'),
             DropdownField::create(
                 'ColumnThreeColour',
                 'Colour',
                 $colourSource
             ),
             HTMLEditorField::create('ColumnThreeContent', 'Content'),
        ]));
        $columnThree->displayIf('Layout')->isEqualTo('Three Column');
        $fields->push($columnThree);

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * Get the colour for a column
     *
     * @return string
     */
    public function ColumnColour($column)
    {
        $property = sprintf('Column%sColour', $column);
        $colour = $this->getField($property);
        return sprintf('#%s', $colour);
    }

    public function IsLayout($layout){
        return ($this->getField('Layout') == $layout);
    }

    /**
     * Gets the configured classes for a column
     *
     * @return string
     */
    public function ColumnClasses()
    {
        $classesArray = Config::inst()->get('ContentBlock_ColumnLayout', 'column_classes');

        $this->extend('updateColumnClasses', $classes);

        return (!empty($classesArray)) ? implode(' ', $classesArray) : '' ;
    }

    /**
     * Gets the configured classes for a row
     *
     * @return string
     */
    public function RowClasses()
    {
        $classesArray = Config::inst()->get('ContentBlock_ColumnLayout', 'row_classes');

        $this->extend('updateRowClasses', $classes);

        return (!empty($classesArray)) ? implode(' ', $classesArray) : '' ;
    }

    /**
     * Gets the block type for CMS display
     *
     * @return string
     */
    public function getBlockType()
    {
        return 'Column Layout';
    }

    /**
     * Renders the block for template
     *
     * @return string
     */
    public function RenderBlock()
    {
        Requirements::javascript(CONTENTBLOCKS_DIR . '/javascript/lib/jquery.matchHeight-min.js');
        return parent::RenderBlock();
    }

}
