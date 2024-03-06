$(document).ready(function(){
    $("#deleteAccount").click(function(event) {

            $.ajax({
                type: "POST",
                url: "event_click_delete_account.php",
                success: function(response) {
                    console.log(response);
                }
            });
    });
});
