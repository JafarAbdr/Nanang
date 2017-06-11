FormControlClass = function(){
	this.initialize = function(){
		this.enableEvents();
		this.initRadioAndCheckbox();
		this.initFloatingLabels();
		//this.initValidation();
		
	};
	this.enableEvents = function () {
		// Link submit function
		$('[data-submit="form"]').on('click', function (e) {
			e.preventDefault();
			var formId = $(e.currentTarget).attr('href');
			$(formId).submit();
		});
		
		// Init textarea autosize
		$('textarea.autosize').on('focus', function () {
			$(this).autosize({append: ''});
		});
		
	};
	
	// =========================================================================
	// RADIO AND CHECKBOX LISTENERS
	// =========================================================================

	this.initRadioAndCheckbox = function () {
		// Add a span class the styled checkboxes and radio buttons for correct styling
		$('.checkbox-styled input, .radio-styled input').each(function () {
			if ($(this).next('span').length === 0) {
				$(this).after('<span></span>');
			}
		});
	};
	
	// =========================================================================
	// FLOATING LABELS
	// =========================================================================

	this.initFloatingLabels = function () {
		$('.floating-label .form-control').on('keyup change', function (e) {
			var input = $(e.currentTarget);

			if ($.trim(input.val()) !== '') {
				input.addClass('dirty').removeClass('static');
			} else {
				input.removeClass('dirty').removeClass('static');
			}
		});

		$('.floating-label .form-control').each(function () {
			var input = $(this);

			if ($.trim(input.val()) !== '') {
				input.addClass('static').addClass('dirty');
			}
		});

		$('.form-horizontal .form-control').each(function () {
			$(this).after('<div class="form-control-line"></div>');
		});
	};
	
	// =========================================================================
	// VALIDATION
	// =========================================================================

	this.initValidation = function () {
		/* to control form on modal disable it, if all form reload from server
		if (!$.isFunction($.fn.validate)) {
			return;
		} */
		$.validator.setDefaults({
			highlight: function (element) {
				$(element).closest('.form-group').addClass('has-error');
			},
			unhighlight: function (element) {
				$(element).closest('.form-group').removeClass('has-error');
			},
			errorElement: 'span',
			errorClass: 'help-block',
			errorPlacement: function (error, element) {
				if (element.parent('.input-group').length) {
					error.insertAfter(element.parent());
				}
				else if (element.parent('label').length) {
					error.insertAfter(element.parent());
				}
				else {
					error.insertAfter(element);
				}
			}
		});

		$('.form-validate').each(function () {
			var validator = $(this).validate();
			$(this).data('validator', validator);
		});
	};
}
FormControl = new FormControlClass();