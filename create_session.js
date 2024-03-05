$(document).ready(function() {
    $.post("create_session.php", function(sessionData) {
        console.log("Session created successfully:", sessionData);
    }, "json");
});
