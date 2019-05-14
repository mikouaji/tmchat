define(['jquery', 'bootstrap'], function($){
	const popOverSettings = {
		placement: 'top',
		container: 'body',
		trigger: 'focus',
		html: true,
		selector: '[data-toggle="popover"]',
	};
	$('body').popover(popOverSettings);
});
