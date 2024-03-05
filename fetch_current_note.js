
var currentNote = $("#noteNameSpace").text();

$.ajax({
    type: "POST",
    url: "fetch_session.php",
    data: { currentNote: currentNote},
    // success: function(response) {
    //     console.log("HTML content of #noteNameSpace:", response);
    // }
});