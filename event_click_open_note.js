function editorInitiation() {

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

        editor.

        window.editor = editor;
}