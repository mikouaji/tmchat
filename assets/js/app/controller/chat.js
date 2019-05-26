define(
	['require', 'jquery', 'controller/constants', 'helper/viewModel', 'controller/model', 'socketio'],
	function(require, $, c, v, m, io)
	{
		v.init({
			filteredTopics: [],
			topics : [],
			messages : [],
			current : "",
			filter: "",
			newTopic: "",
		});

		m.getAll().then(function(response){
			updateView(response.data.obj);
			initSocketIO();
			$(c.DOM_LOADER).addClass(c.CSS_HIDDEN);
		}).catch(function(error){
			showErrors(error.response.data.messages);
		});

		$('body').on('keyup', c.DOM_TOPIC_FILTER, function(){
			v.set('filteredTopics', v.get('topics').filter(item => (item.name.search(v.get('filter')) !== -1 || item.active)));
		}).on('click', c.DOM_TOPIC_SELECT, function(){
			$(c.DOM_TOPIC_WINDOW).addClass(c.CSS_HIDDEN);
			$(c.DOM_LOADER_MESSAGES).removeClass(c.CSS_HIDDEN);
			let id = $(this).data('id');
			m.get(id).then(function(response){
				updateView(response.data.obj);
				$(c.DOM_LOADER_MESSAGES).addClass(c.CSS_HIDDEN);
				$(c.DOM_TOPIC_WINDOW).removeClass(c.CSS_HIDDEN);
			}).catch(function(error){
				showErrors(error.response.data.messages);
			});
		}).on('click', c.DOM_TOPIC_ADD, function(){
			addTopic();
		}).on('click', c.DOM_FLASH, function(){
			$(this).remove();
		}).on('click', c.DOM_MESSAGE_SEND, function(){
			sendMessage();
		}).on('keypress', function(e){
			if(e.keyCode === c.KEYCODE_ENTER){
				let target = e.target;
				if(target === $(c.DOM_TOPIC_ADD_NAME)[0]){
					addTopic();
				}
				if(target === $(c.DOM_MESSAGE_VALUE)[0] && e.shiftKey === false){
					sendMessage();
				}
			}
		});

		function initSocketIO(){
			const socket = io(socketAddr);
			socket.on('message', function(message){
				let data = JSON.parse(message);
				if(data.topic === v.get('current')){
					let messages = v.get('messages');
					messages.push(data.message);
					v.set('messages', messages);
				}else{
					let topics = v.get('topics');
					topics.forEach(function(item){
						if(item.id === data.topic)
							item.unread ++ ;
					});
					let filteredTopics = v.get('topics');
					filteredTopics.forEach(function(item){
						if(item.id === data.topic)
							item.unread ++ ;
					});
					v.set('topics', topics)
						.set('filteredTopics', filteredTopics);
				}
			});
		}

		function sendMessage(){
			$(c.DOM_MESSAGE_VALUE).prop('disabled', true);
			let value = $(c.DOM_MESSAGE_VALUE).val();
			let file = "";
			m.send(value, file).then(function(response){
				if(response.data.obj === true){
					$(c.DOM_MESSAGE_VALUE).val("");
					$(c.DOM_MESSAGE_VALUE).removeAttr('disabled');
					$(c.DOM_MESSAGE_VALUE).focus();
				}
			}).catch(function(error){
				showErrors(error.response.data.messages);
			});
		}

		function addTopic(){
			let name = $(c.DOM_TOPIC_ADD_NAME).val();
			if(name !== "")
				m.add(name).then(function(response){
					let topics = v.get('topics');
					let topic = {
						id: response.data.obj.id,
						name: response.data.obj.name,
						active: false,
						unread: 0,
					};
					topics.splice(1,0,topic);
					v.set('topics', topics)
						.set('filteredTopics', topics);
				}).catch(function(error){
					showErrors(error.response.data.messages);
				});
			$(c.DOM_TOPIC_ADD_NAME).val("");
		}

		function updateView(data){
			let topics = [];
			let current = v.get('current');
			let messages = v.get('messages');
			let isAnyActive = false;
			data.forEach(function(item){
				if(item.active === true){
					current = item.id;
					messages = item.messages;
					isAnyActive = true;
				}
				topics.push(item);
			});
			if(!isAnyActive){
				let general = data.find(item => item.name === c.TOPIC_GENERAL);
				current = general.id;
				messages = general.messages;
			}
			v.set('current', current)
				.set('topics', topics)
				.set('filteredTopics', topics)
				.set('messages', messages)
				.set('filter', '');
		}

		function showErrors(messages){
			messages.forEach(function(text){
				let message = $('body').append(c.newErrorMessage(text)).find(c.DOM_FLASH);
				window.setTimeout(function(){
					message.remove();
				}, c.FLASH_TIMEOUT);
			});
		}
	});
