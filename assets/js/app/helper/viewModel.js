define(['knockout', 'komapping'], function(ko, km){
	ko.mapping = km;
	let obj = {};
	let model;
	return {
		model : model,
		init : function(object) {
			obj = object;
			model = ko.mapping.fromJS(obj);
			ko.applyBindings(model);
			return obj;
		},
		update : function(object) {
			obj = object;
			ko.mapping.fromJS(obj, model);
			return obj;
		},
		get : function(index = null) {
			let object = ko.mapping.toJS(model);
			return index === null ? object : object[index];
		},
		getNotUpdated : function(index = null) {
			return index === null ? obj : obj[index];
		},
		set : function(name, value){
			obj[name] = value;
			this.update(obj);
			return this;
		},
	};
});
