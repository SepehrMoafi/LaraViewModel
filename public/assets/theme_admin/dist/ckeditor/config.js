/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    config.language = 'fa';
    // config.uiColor = '#AADC6E';

    config.allowedContent = true;
    config.protectedSource.push(/<i[^>]*><\/i>/g);

    config.filebrowserBrowseUrl = '/plugins/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
    config.filebrowserUploadUrl = '/plugins/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
    config.filebrowserImageBrowseUrl = '/plugins/filemanager/dialog.php?type=1&editor=ckeditor&fldr=';

     // config.mathJaxLib = 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML';
    // config.mathJaxLib = 'http://admin.farayad.local/assets/global/plugins/ckeditor/plugins/mathjax/MathJax.js?config=TeX-AMS_HTML';
     //config.extraPlugins = 'widgetselection,lineutils,widget';
     // config.extraPlugins = 'mathjax';


    //config.extraAllowedContent = 'div(*){*}[*];button(*)(*){*}[*];i(*)(*){*}[*];dl; dt dd[dir];';
};

/*
CKEDITOR.on('dialogDefinition', function (event)
{
    var editor = event.editor;
    var dialogDefinition = event.data.definition;
    var dialogName = event.data.name;

    var cleanUpFuncRef = CKEDITOR.tools.addFunction(function ()
    {
        // Do the clean-up of filemanager here (called when an image was selected or cancel was clicked)
        $('#fm-iframe').remove();
        $("body").css("overflow-y", "scroll");
    });

    var tabCount = dialogDefinition.contents.length;
    for (var i = 0; i < tabCount; i++) {
        var dialogTab = dialogDefinition.contents[i];
        if (!(dialogTab && typeof dialogTab.get === 'function')) {
            continue;
        }

        var browseButton = dialogTab.get('browse');
        if (browseButton !== null) {
            browseButton.hidden = false;
            browseButton.onClick = function (dialog, i) {
                editor._.filebrowserSe = this;
                var iframe = $("<iframe id='fm-iframe' class='fm-modal'/>").attr({
                    src: '/plugins/filemanager/dialog.php?editor=ckeditor&' + // Change it to wherever  Filemanager is stored.
                    'CKEditorFuncNum=' + CKEDITOR.instances[event.editor.name]._.filebrowserFn +
                    '&CKEditorCleanUpFuncNum=' + cleanUpFuncRef +
                    '&langCode=en_EN' +
                    '&CKEditor=' + event.editor.name
                });

                $("body").append(iframe);
                $("body").css("overflow-y", "hidden");  // Get rid of possible scrollbars in containing document
            }
        }
    }
});*/
