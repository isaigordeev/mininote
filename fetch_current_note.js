
var currentNote = $("#noteNameSpace").text();
console.log(currentNote);
console.log("current note");

$.ajax({
    type: "POST",
    url: "fetch_current_note.php", // Server-side PHP script
    data: { elementId: currentNote},
    success: function(response) {
        console.log("HTML content of #noteNameSpace:", response);
    }
});