/* Code Mirror */
function loadCodeMirror()
{ 
   var code_type = '';
   var readonly = '';
   var readonly_mode = true;

   jQuery('html,body').find('.CodeMirror').each(function(index) {

        /* Check for undefined elements */
        if (typeof $(this) != 'undefined'){


           /* Set readonly mode */
            readonly = $(this).attr('readonly');

            /* Iterate ids to be unique */
            var element_code;
            element_code = 'code-' + index;

                $(this).attr('id',element_code);

                /* Activate editor */
                text_editors[element_code] = CodeMirror.fromTextArea(document.getElementById( element_code ), {
                        mode: 'text/css',
                        lineNumbers: true,
                        tabMode: "indent",
                        readOnly : readonly,
                        lineWrapping: true
                    }
                );

                /* Save editor content */
                text_editors[element_code].on("blur", function(){ text_editors[element_code].save();});

        }

    });

    /* Theme documentation textarea - view source code */

        el_editor_theme_designer = document.getElementById('CodeMirror-theme-designer');

        /* Check for undefined elements */
        if (typeof(el_editor_theme_designer) != 'undefined' && el_editor_theme_designer != null) {

            el_editor_theme_designer = CodeMirror.fromTextArea( el_editor_theme_designer , {
                    mode: 'text/css',
                    lineNumbers: true,
                    tabMode: "indent",
                    readOnly : true,
                    lineWrapping: true
                }
            );

            el_editor_theme_designer.on("blur", function(){ el_editor_theme_designer.save();});

        }

    /* Theme documentation textarea - view source code */


    /* Theme documentation textarea - view source code */

        var el_editor_theme_doc = document.getElementById('CodeMirror-theme-doc');

        /* Check for undefined elements */
        if (typeof(el_editor_theme_doc) != 'undefined' && el_editor_theme_doc != null) {

            editor_theme_doc = CodeMirror.fromTextArea( el_editor_theme_doc , {
                    mode: 'text/css',
                    lineNumbers: true,
                    tabMode: "indent",
                    readOnly : true,
                    lineWrapping: true
                }
            );

            editor_theme_doc.on("blur", function(){ editor_theme_doc.save();});

        }

    /* Theme documentation textarea - view source code */
}



