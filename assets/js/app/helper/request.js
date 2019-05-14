define(['axios'], function(axios){
	return {
		get : function(url, params = null){
			return axios({
				method : 'GET',
				url : url,
				params : params,
			});
		},
		post : function(url, data){
			return axios({
				method : 'POST',
				url : url,
				data : data,
			});
		},
		put : function(url, data){
			return axios({
				method : 'PUT',
				url : url,
				data : data,
			});
		},
		patch : function(url, data){
			return axios({
				method : 'PATCH',
				url : url,
				data : data,
			});
		},
		delete : function(url, params = null){
			return axios({
				method : 'DELETE',
				url : url,
				params : params,
			});
		},
	};
});
