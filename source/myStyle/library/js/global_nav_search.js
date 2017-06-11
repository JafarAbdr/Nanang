$(document).ready(function(){
    NavSearchControl.initialize();
});
var NavSearchControlClass = function(){
    this.temp;
    this.initialize = function(a,b){
        this.temp = function(x){
            a(x);
        };
		this.temp1 = function(){
            b();
        };
        this._enableEvents();
    }
    this._enableEvents = function () {
		var o = this;

		// Listen for the nav search button click
		$('.navbar-search .btn').on('click', function (e) {
			o._handleButtonClick(e);
		});

		// When the search field loses focus
		$('.navbar-search input').on('blur', function (e) {
			o._handleFieldBlur(e);
		});
	};
    this._handleButtonClick = function (e) {
		e.preventDefault();
        var o = this;
		var form = $(e.currentTarget).closest('form');
		var input = form.find('input');
		var keyword = input.val();

		if ($.trim(keyword) === '') {
			// When there is no keyword, just open the bar
			form.addClass('expanded');
			o.temp1();
			input.focus();
		}
		else {
			// When there is a keyword, submit the keyword
			form.addClass('expanded');
			//form.submit();
            o.temp(input.val());
			// Clear the timer that removes the keyword
			clearTimeout(this._clearSearchTimer);
		}
	};

	// =========================================================================
	// FIELD BLUR
	// =========================================================================

	this._handleFieldBlur = function (e) {
		// When the search field loses focus
		var input = $(e.currentTarget);
		var form = input.closest('form');

		// Collapse the search field
		form.removeClass('expanded');

		// Clear the textfield after 300 seconds (the time it takes to collapse the field)
		clearTimeout(this._clearSearchTimer);
		this._clearSearchTimer = setTimeout(function () {
			input.val('');
		}, 300);
	};
};
NavSearchControl = new NavSearchControlClass();
