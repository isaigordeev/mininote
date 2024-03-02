var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    lineNumbers: true,
    mode: "application/x-httpd-php", // Set the mode to PHP
    theme: "default", // You can choose a different theme
});

window.editor = editor;

const mirror = document.getElementById('editor_bar');

function getText() {

    // var text = document.getElementById("code").getValue();

    var text = document.getElementById("code").textContent;
    var text = editor.getValue();


    document.getElementById("output").textContent = text;

    console.log(text);


}