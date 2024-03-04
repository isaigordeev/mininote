$(document).ready(function(){
    $(document).keydown(function(event) {
        if (event.shiftKey && event.key === "N" ) {

            var content = window.editor?.getValue();

            var dataToSend = {
                content: content,
                login: "isai",
            };

            $.ajax({
                type: "POST",
                url: "event_keyboard_create_note.php",
                data: dataToSend,
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
});
