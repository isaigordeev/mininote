var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    lineNumbers: true,
    mode: "application/x-httpd-php", // Set the mode to PHP
    theme: "default", // You can choose a different theme
    scrollbarStyle: null,
    lineWrapping: true,

});

window.editor = editor;

const mirror = document.getElementById('editor_bar');

function updateEditorHeight() {
    var container = document.getElementById("editor-bar");
    var scrollHeight = editor.getScrollInfo().height;
    var contentHeight = editor.getScrollInfo().clientHeight;
    if (scrollHeight > contentHeight) {
        container.style.height = scrollHeight + "px";
        editor.setSize(null, scrollHeight);
    }
}

editor.on("change", function() {
    updateEditorHeight();
});

updateEditorHeight();

function handleWindowResize() {
    updateEditorHeight();
    editor.setSize(null, editor.getScrollInfo().clientHeight);
}

window.addEventListener("resize", handleWindowResize);

function getText() {

    // var text = document.getElementById("code").getValue();

    var text = document.getElementById("code").textContent;
    var text = editor.getValue();

    document.getElementById("output").textContent = text;

    console.log(text);


}