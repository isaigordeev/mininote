var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    lineNumbers: true,
    mode: "application/x-httpd-php", // Set the mode to PHP
    theme: "default", // You can choose a different theme
});

// var code = editor.getValue();
//
// console.log(code);


function getText() {

    // var text = document.getElementById("code").getValue();
    var text = editor.getValue();

    document.getElementById("output").textContent = text;

    console.log(text);

}