define(
	['require', 'jquery', 'controller/constants', 'helper/viewModel', 'controller/model'],
	function(require, $, c, v, m)
	{
		v.init({
			topics : [],
			messages : [],
			current : "",
		});
		m.getAll().then(function(response){
			let data = response.data.obj;
			let topics = [];
			let current = v.get('current');
			let messages = v.get('messages');
			data.forEach(function(item){
				item.active = 0;
				if(item.name === c.TOPIC_GENERAL){
					current = item.id;
					messages = item.messages;
					item.active = 1;
				}
				topics.push(item);
			});
			v.set('current', current)
				.set('topics', topics)
				.set('messages', messages);
			console.log(topics);
			$(c.DOM_LOADER).addClass(c.CSS_HIDDEN);
		}).catch(function(error){
			console.log(error);
		});
	});
