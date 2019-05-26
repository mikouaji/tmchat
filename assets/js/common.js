requirejs.config({
	baseUrl: '../assets/js/lib',
	paths: {
		axios: "https://unpkg.com/axios@0.18.0/dist/axios.min",
		app: '../app',
		init: '../app/init',
		helper: '../app/helper',
		controller: '../app/controller',
		jquery: "jquery-3.3.1.slim.min",
		bootstrap: "bootstrap.bundle.min",
		knockout : "knockout-3.5.0",
		komapping : "knockout.mapping-latest",
		socketio : "socket.io",
	},
	shim: {
		bootstrap: {
			deps: ['jquery'],
		},
		komapping: {
			deps: ['knockout'],
			exports: 'komapping',
		},
	},
});
requirejs(['app/main']);
