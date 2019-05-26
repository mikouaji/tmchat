define(['helper/request'],function(r){
	return {
		URL_UPLOAD : "/chat/upload/",
		upload : function(data){
			return r.post(this.URL_UPLOAD, data);
		},
	}
});
