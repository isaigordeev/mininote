$(document).ready(function() {
    $.post("fetch_session.php", function(sessionData) {
        // Use the session data as needed
        console.log("Session data:", sessionData);
    });
});
