define(['helper/request'],function(r){
	return {
		URL_UPLOAD_DOCUMENT : "/files/document/",
		URL_UPLOAD_IMAGE : "/files/image/",
		document : function(data){
			return r.post(this.URL_UPLOAD_DOCUMENT, data);
		},
		image : function(data){
			return r.post(this.URL_UPLOAD_IMAGE, data);
		}
	}
});
