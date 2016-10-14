(function($){

	$.entwine('ss', function($) {
		$('.ss-gridfield .field .gridfield-dropdown').entwine({

			onchange: function() {
				var gridField = this.getGridField();
				var state = gridField.getState().GridFieldDropdownAddNewButton;

				state.class = this.val();
				gridField.setState("GridFieldDropdownAddNewButton", state);
			}
		});
	});

}(jQuery));
