$(document).ready(function(){
    $("#makeAllPrivate").click(function(event) {

        $.post("fetch_session.php", function(sessionData) {
            console.log("Session data:", sessionData);

            FinalRequest(sessionData);
        });

        function FinalRequest(sessionData){

            $.ajax({
                type: "POST",
                url: "event_click_make_all_notes_private.php",
                data: { login: sessionData.login},
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
});
