define(function (require) {
	require(['domReady!'], function (doc) {
		require('init/bootstrap');
		let $ = require('jquery'),
			controller = $('body').data('layout');
		if(controller)
			require(['controller/'+controller], function(){});
	});
});
