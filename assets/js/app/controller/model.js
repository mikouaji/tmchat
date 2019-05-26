define(['helper/request', 'controller/constants'], function(r,c){
    return {
        getAll : function(){
            return r.get(c.URL_GET_ALL);
        },
        get : function(id){
            return r.get(c.URL_GET + id);
        },
        getFiles : function(){
            return r.get(c.URL_GET + "files");
        },
        add : function(name){
            return r.put(c.URL_PUT, {type: 'topic', name: name});
        },
        send : function(value, file){
            return r.put(c.URL_PUT, {type: 'message', data: { value: value, files : file}});
        }
    };
});