var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    lineNumbers: true,
    mode: "application/x-httpd-php", // Set the mode to PHP
    theme: "default", // You can choose a different theme
});