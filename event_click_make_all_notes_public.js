$(document).ready(function(){
    $("#makeAllPublic").click(function(event) {

        $.post("fetch_session.php", function(sessionData) {
            console.log("Session data:", sessionData);

            FinalRequest(sessionData);
        });

        function FinalRequest(sessionData){

            $.ajax({
                type: "POST",
                url: "event_click_make_all_notes_public.php",
                data: { login: sessionData.login},
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
});
