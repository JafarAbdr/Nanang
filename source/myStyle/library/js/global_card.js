CardControlClass = function(){
	this.initialize = function(){
		//if (!$.isFunction($.fn.tab)) {
			//return;
		//}
		$('[data-toggle="tabs"] a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
		var temp = this;
		$('.card-head .tools .btn-refresh').on('click', function (e) {
			temp.handleCardRefresh(e);
		});
		$('.card-head .tools .btn-collapse').on('click', function (e) {
			temp.handleCardCollapse(e);
		});
		$('.card-head .tools .btn-close').on('click', function (e) {
			temp.handleCardClose(e);
		});
		$('.card-head .tools .menu-card-styling a').on('click', function (e) {
			temp.handleCardStyling(e);
		});
	};
	this.handleCardRefresh = function (e) {
		var card = $(e.currentTarget).closest('.card');
		materialadmin.AppCard.addCardLoader(card);
		setTimeout(function () {
			materialadmin.AppCard.removeCardLoader(card);
		}, 1500);
	};

	this.handleCardCollapse = function (e) {
		var card = $(e.currentTarget).closest('.card');
		materialadmin.AppCard.toggleCardCollapse(card);
	};

	this.handleCardClose = function (e) {
		var card = $(e.currentTarget).closest('.card');
		materialadmin.AppCard.removeCard(card);
	};

	this.handleCardStyling = function (e) {
		// Get selected style and active card
		var newStyle = $(e.currentTarget).data('style');
		var card = $(e.currentTarget).closest('.card');

		// Display the selected style in the dropdown menu
		$(e.currentTarget).closest('ul').find('li').removeClass('active');
		$(e.currentTarget).closest('li').addClass('active');

		// Find all cards with a 'style-' class
		var styledCard = card.closest('[class*="style-"]');

		if (styledCard.length > 0 && (!styledCard.hasClass('style-white') && !styledCard.hasClass('style-transparent'))) {
			// If a styled card is found, replace the style with the selected style
			// Exclude style-white and style-transparent
			styledCard.attr('class', function (i, c) {
				return c.replace(/\bstyle-\S+/g, newStyle);
			});
		}
		else {
			// Create variable to check if a style is switched
			var styleSwitched = false;

			// When no cards are found with a style, look inside the card for styled headers or body
			card.find('[class*="style-"]').each(function () {
				// Replace the style with the selected style
				// Exclude style-white and style-transparent
				if (!$(this).hasClass('style-white') && !$(this).hasClass('style-transparent')) {
					$(this).attr('class', function (i, c) {
						return c.replace(/\bstyle-\S+/g, newStyle);
					});
					styleSwitched = true;
				}
			});

			// If no style is switched, add 1 to the main Card
			if (styleSwitched === false) {
				card.addClass(newStyle);
			}
		}
	};
};
var CardControl = new CardControlClass();