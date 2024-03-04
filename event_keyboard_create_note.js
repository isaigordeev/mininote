$(document).ready(function(){
    $(document).keydown(function(event) {
        if (event.shiftKey && event.key === "S") {

            var content = window.editor?.getValue();

            var dataToSend = {
                content: content,
                login: "isai",
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
                login: "isai"
            };


            $.ajax({
                type: "POST",
                url: "event_keyboard_create_note.php",
                data: dataToSend,
                success: function(response) {
                    console.log(response);

                    $("#elementToInitialize").show();

                    var newElement = $("<div>").text("Initialized Element");
                    $("body").append(newElement);
                }
            });
        }
    });
});

