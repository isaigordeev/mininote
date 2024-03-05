// $(document).ready(function(){
//     $(document).click(function(event) {
//         var editor_window = $("#editor-bar");
//         if (!$(editor_window).is(event.target) && $(editor_window).has(event.target).length === 0) {
//
//             var content = window.editor?.getValue();
//
//             var dataToSend = {
//                 content: content,
//                 login: "isai",
//             };
//
//             $.ajax({
//                 type: "POST",
//                 url: "event_click_save_note.php",
//                 data: dataToSend,
//                 success: function(response) {
//                     console.log(response);
//                     var newElement = $("<div>").text("Initialized Element");
//                     $("body").append(newElement);
//                 }
//             });
//         }
//     });
// });

// document.addEventListener("DOMContentLoaded", function() {
//     var editableDiv = document.getElementById("editableNoteName");
//
//     editableDiv.addEventListener("click", function() {
//         editableDiv.focus();
//     });
// });



