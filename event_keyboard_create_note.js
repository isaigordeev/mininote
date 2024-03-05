$(document).ready(function(){
    $(document).keydown(function(event) {
        if (event.shiftKey && event.key === "S") {

            var content = window.editor?.getValue();

            var dataToSend = {
                content: content,
            };

            $.ajax({
                type: "POST",
                url: "event_keyboard_save_note.php",
                data: dataToSend,
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
});

$(document).ready(function(){
    $(document).keydown(function(event) {
        if (event.shiftKey && event.key === "N") {

            var dataToSend = {
                isNote: "true",
            };


            $.ajax({
                type: "POST",
                url: "event_keyboard_create_note.php",
                data: dataToSend,
                success: function(response) {
                    console.log(response);

                    if ($("#code").length) {
                        console.log("Textarea with ID 'code' already exists.");


                        var editorWrapper = window.editor.getWrapperElement();
                        editorWrapper.parentNode.removeChild(editorWrapper);

                        var editorContainer = $("#editor-bar");

                        var textarea = $("#code");
                        textarea.remove();

                        var textarea = $("<textarea>").attr("id", "code").attr("rows", "30").attr("name", "code");
                        editorContainer.append(textarea);

                        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                            lineNumbers: true,
                            mode: "application/x-httpd-php",
                            theme: "default",
                            scrollbarStyle: null,
                            lineWrapping: true
                        });

                        window.editor = editor;



                    } else{
                        var newElement = $("<div>").text("Initialized Element");
                        $("body").append(newElement);

                        var editorContainer = $("#editor-bar");
                        var startMenu = $("#empty-state-action-list");
                        startMenu.remove();

                        // editorContainer.append(editorContainer);

                        var textarea = $("<textarea>").attr("id", "code").attr("rows", "30").attr("name", "code");
                        editorContainer.append(textarea);

                        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                            lineNumbers: true,
                            mode: "application/x-httpd-php",
                            theme: "default",
                            scrollbarStyle: null,
                            lineWrapping: true
                        });

                        window.editor = editor;
                    }
                }
            });
        }
    });
});

