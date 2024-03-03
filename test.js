
$(document).ready(function(){
    $(document).keydown(function(event) {
        if (event.shiftKey && event.key === "S") {
            var myDiv = $("#myDiv");
            $.ajax({
                type: "POST",
                url: "process_keyboard_save.php",
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
});

var editor_div = document.getElementById("code");


$(document).ready(function(){
    $(document).click(function(event) {
        var editor_window = $("#editor-bar");
        if (!$(event.target).is(editor_window) && $(editor_window).has(event.target).length === 0) {


            var content = window.editor?.getValue();

            var dataToSend = {
                content: content,
                login: "isai",
            };

            $.ajax({
                type: "POST",
                url: "process_click_save.php",
                data: dataToSend,
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
});