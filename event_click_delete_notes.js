$(document).ready(function(){
    $("#deleteNotesButton").click(function(event) {

        $.post("fetch_session.php", function(sessionData) {
            console.log("Session data:", sessionData);

            FinalRequest(sessionData);
        });

        function FinalRequest(sessionData){

            $.ajax({
                type: "POST",
                url: "event_click_delete_notes.php",
                data: { login: sessionData.login},
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
});
