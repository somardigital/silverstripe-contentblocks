
# Content Blocks

Add Content Blocks with different Layouts to pages.

## Installation

### Composer

`composer require somardesignstudios/silverstripe-contentblocks`

### Manually

Download the archive and extract it into your web root.

## Features

This module provides four different Content Block layouts out of the Box.

### Column Layout

This Content Block enables a up to 3 columns of content with background colour options.
The columns heights are matched with the the jQuery match heights plugin.

### Accordion

This Content Block provides basic Bootstrap `panel-collapse` functionality.

### Tile Section

This Content Block provides a landing-page type tile layout. Each Tile can have
an image, title, caption and link. Tiles can be displayed in rows of two or three. There is
also support for user selected templates.

### Case Study

TO DO

## Usage

`ContentBlockExtension` will add a ContentBlocks tab and GridField to all Pages.
Each class of Content Block has it's own button to add to the page.

Currently, you can add these to any template by looping over the `ContentBlocks` and using `$RenderBlock`

__Layout/Page.ss__
```
<% if ContentBlocks %>
    <% loop ContentBlocks %>
        $RenderBlock
    <% end_loop %>
<% end_if %>
```
Future improvements include allowing content blocks to be inserted individually via Shortcodes
as well as allowing the creation of a ContentBlock via a Dropdown Field as opposed to individual buttons.

The styling will be basic if not non-existent, this is to allow you full control of the look and
feel of the content blocks apart from the Bootstrap bits ofcourse.

## Configuration

### Base Configuration

#### Bootstrap

This module requires Twitter Bootstrap 3 for a number of layouts and components. It is recommended
to include Bootstrap in your theme as you will better be able to manage cascading styles however,
to get going quickly you can set a configuration flag to include the module's bootstrap library
which includes just the CSS needed for the components:

__config.yml__
```
ContentBlock:
  include_bootstrap: true

```

#### Extending

Extension hooks are provided in most appropriate places so you can easily customise the behaviour.
If you believe there is one missing, feel free to raise an issue or create a pull request.

#### Templates

You can override any of the default templates in this module by creating Templates
 of the same name in your themes folder.

### Column Layout

#### column_classes
You can configure the classes that will be applied to every column with `column_classes` option.

__config.yml__
```
ContentBlock_ColumnLayout:
  column_classes:
    - 'my-custom-css-class'
    - 'another-class'

```

#### colour_options
You can configure the background colour options using the `colour_options` option.

__config.yml__
```
ContentBlock_ColumnLayout:
  colour_options:
    ffffff: 'White'
    hexcode: 'Dropdown Label'

```


### Accordion

#### accordion_classes
You can configure the classes that will be applied to all panels with `accordion_classes` option.

__config.yml__
```
ContentBlock_Accordion:
  accordion_classes:
    - 'my-custom-css-class'
    - 'another-class'

```

### Tiles Section
TO DO

 - tile_classes
 - tile_templates

### Case Study
TO DO


## Development
TO DO

## TO DO
- Tests
- Internationalization
- A neater interface to add the different classes of Content Block
- Remove dependency on Userforms module.
