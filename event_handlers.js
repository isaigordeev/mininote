$(document).ready(function(){
    $(document).click(function(event) {
        var editor_window = $("#editor-bar");
        if (!$(editor_window).is(event.target) && $(editor_window).has(event.target).length === 0) {

            var content = window.editor?.getValue();

            var dataToSend = {
                content: content,
                login: "isai",
            };

            $.ajax({
                type: "POST",
                url: "event_click_save_note.php",
                data: dataToSend,
                success: function(response) {
                    console.log(response);
                    var newElement = $("<div>").text("Initialized Element");
                    $("body").append(newElement);
                }
            });
        }
    });
});

$(document).ready(function() {
    function performAjaxRequest() {
        $.ajax({
            url: 'event_navigation_bar_fetch.php',
            type: 'GET',
            // dataType: 'json',
            success: function(paths) {
                console.log(paths);
                // var data = JSON.parse(paths);
                var html = renderMenu(paths);

                // Update the navigation bar with the generated HTML
                document.getElementById("navigation-bar").innerHTML = html;

                var newElement = $("<div>").text("Initialized Element");
                $("body").append(newElement);

            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    performAjaxRequest();
});