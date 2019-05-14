define(
	['require', 'jquery'],
	function(require, $)
	{
		let action = $('body').find('[data-layout-action]').data('layout-action');
		if(action)
			require(['controller/default/'+action], function(){});
		else{

		}
	});
