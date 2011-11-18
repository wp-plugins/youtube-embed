(function() {
    tinymce.create('tinymce.plugins.youtube', {
        init : function(ed, url) {
            ed.addButton('YouTube', {
                title : 'YouTube Embed',
                onclick : function() {
                     ed.selection.setContent('[youtube]' + ed.selection.getContent() + '[/youtube]'); 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('YouTube', tinymce.plugins.youtube);
})();