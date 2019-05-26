define(function(){
    return {
        DOM_LOADER : '.loader',
        DOM_LOADER_MESSAGES : '.loader-messages',
        DOM_TOPIC_FILTER : '.topic-filter',
        DOM_TOPIC_SELECT : '.topic-select',
        DOM_TOPIC_WINDOW : '.topic-window',
        DOM_TOPIC_ADD : '.topic-add',
        DOM_TOPIC_ADD_NAME : '.topic-add-name',
        DOM_MESSAGE_VALUE: '.message-value',
        DOM_MESSAGE_SEND: '.message-send',
        DOM_MESSAGE_ATTACH: '.message-attach',
        DOM_FILES_TOGGLE: '.files-toggle',
        DOM_FILES_COL: '.files-col',
        DOM_FILES_LIST_URLS: '.files-list-urls',
        DOM_FILES_SHOW_URLS: '.files-show-urls',
        DOM_FILES_LIST_IMGS: '.files-list-imgs',
        DOM_FILES_SHOW_IMGS: '.files-show-imgs',
        DOM_FILES_LIST_DOCS: '.files-list-docs',
        DOM_FILES_SHOW_DOCS: '.files-show-docs',
        DOM_FLASH : '.flash',
        CSS_HIDDEN : 'd-none',
        URL_GET_ALL : 'api/get',
        URL_GET : 'api/get/',
        URL_PUT : 'api/put/',
        TOPIC_GENERAL : 'general',
        FLASH_TIMEOUT : 2500,
        KEYCODE_ENTER : 13,
        newErrorMessage : function(message){
            return '<div class="flash bg-danger"><small>error:</small>'+message+'</div>';
        },
    };
});