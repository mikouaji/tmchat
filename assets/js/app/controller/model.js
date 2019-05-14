define(['helper/request', 'controller/constants'], function(r,c){
    return {
        getAll : function(){
            return r.get(c.URL_GET_ALL);
        },
    };
});