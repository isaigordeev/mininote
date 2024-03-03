$(document).ready(function(){
    $(document).keydown(function(event) {
        if (event.shiftKey && event.key === "S") {
            var myDiv = $("#myDiv");
            $.ajax({
                type: "POST",
                url: "event_keyboard_save.php",
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
});