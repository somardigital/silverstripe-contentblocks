<?php

/**
 * This component creates a dropdown of possible data object classes and a button to create a new instance.
 *
 */
class GridFieldDropdownAddNewButton extends GridFieldAddNewButton
	implements GridField_ActionProvider {

	/**
	 * Class names
	 *
	 * @var array
	 */
	protected $modelClasses = null;

	/**
	 * This is because this doesn't extend Object
	 *
	 */
	public static function create($baseClass, $classes, $targetFragment = 'buttons-before-left')
	{
		return new GridFieldDropdownAddNewButton($baseClass, $classes, $targetFragment);
	}

	/**
	 * @param string $baseClass
	 * @param array $classes Class or list of classes to create.
	 * @param string $targetFragment The fragment to render the button into
	 */
	public function __construct($baseClass, $classes, $targetFragment = 'buttons-before-left')
	{
		if (!is_array($classes)) {
			user_error('$classes is not an array', E_USER_ERROR);
		}

		$this->setClasses($classes);

		foreach($this->getClasses() as $class => $nice){
			if(!is_subclass_of($class, $baseClass)){
				user_error(sprintf('%s is not a subclass of %s', $class, $baseClass), E_USER_ERROR);
			}
		}

		parent::__construct($targetFragment);
	}

	/**
	 * Specify the classes to create
	 *
	 * @param array $classes
	 */
	public function setClasses($classes)
	{
		$this->modelClasses = $classes;
	}

	/**
	 * Get the classes of the objects to create
	 *
	 * @return array
	 */
	public function getClasses()
	{
		return $this->modelClasses;
	}

	/**
	 * Abstract method to fill out. Gets the HTML for this component
	 * @param $gridField GridField
	 */
	public function getHTMLFragments($gridField)
	{
		$state = $gridField->State->GridFieldDropdownAddNewButton;
		$classesSource = $this->getClasses();

		if(empty($classesSource)) {
			return [];
		} else if(count($classesSource) > 1) {
			$dropdown = DropdownField::create(
				"Class",
				"Class",
				$classesSource
			)->setFieldHolderTemplate("GridFieldDropdownAddNewButton_holder")
			->addExtraClass("gridfield-dropdown no-change-track");

			if (!$this->buttonName) {
				$this->buttonName = 'Add new';
			}
		} else {
			$class = key($classesSource);
			$dropdown = HiddenField::create(
				"Class",
				"Class",
				$class
			);

			if (!$this->buttonName) {
				$this->buttonName = sprintf('Add new %s', $class);
			}
		}

		$state->class = key($classesSource);

		$action = GridField_FormAction::create(
			$gridField,
			'add',
			$this->buttonName,
			'add',
			'add'
		)->setAttribute(
			'data-icon',
			'add'
		)->addExtraClass("no-ajax ss-ui-action-constructive dropdown-action");

		Requirements::css(CONTENTBLOCKS_DIR . "/css/GridFieldDropdownAddNewButton.css");
		Requirements::javascript(CONTENTBLOCKS_DIR . "/javascript/GridFieldDropdownAddNewButton.js");

		return [
			$this->targetFragment => ArrayData::create([
				'Fields' => ArrayList::create([
					$dropdown,
					$action,
				]),
			])->renderWith("GridFieldDropdownAddNewButton"),
		];
	}

	/**
	 * Provide actions to this component.
	 *
	 * @param GridField $gridField
	 * @return array
	**/
	public function getActions($gridField) {
		return ["add"];
	}

	/**
	 * Handles the add action
	 *
	 * @param GridField $gridField
	 * @param string $actionName
	 * @param mixed $arguments
	 * @param array $data
	**/
	public function handleAction(GridField $gridField, $actionName, $arguments, $data)
	{
		$response = $gridField->getForm()->controller->response;

		if(in_array(strtolower($actionName), $this->getActions($gridField))) {
			$class = null;
			$name = $gridField->getName();
			if (isset($data[$name]) && isset($data[$name]['GridState'])){
				$state = json_decode($data[$name]['GridState'], true);
				// Debug::dump($state);
				if (isset($state['GridFieldDropdownAddNewButton'])
				&& isset($state['GridFieldDropdownAddNewButton']['class'])) {
					$class = $state['GridFieldDropdownAddNewButton']['class'];
				}
			}

			if(!$class || !$this->isValidClass($class)) {
				return Controller::curr()->redirectBack();
			}

			$list = $gridField->getList();
			$object = $class::create();
			$object->write();
			$list->add($object);

			$url = Controller::join_links($gridField->link('item'), $object->ID);

			$response->redirect(Director::absoluteBaseURL() . $url);
			return $response;
		}

		return Controller::curr()->redirectBack();
	}

	/**
	 * Validates that a class is okay for creation
	 *
	 * @param string
	 * @return bool
	 */
	public function isValidClass($class)
	{
		if (!array_key_exists($class, $this->getClasses())) {
			return false;
		}

		return singleton($class)->canCreate();
	}
}
