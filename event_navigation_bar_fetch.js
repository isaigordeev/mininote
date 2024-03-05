// $(document).ready(function(){
//     $.ajax({
//         url: 'event_navigation_bar_fetch.php',
//         type: 'GET',
//         dataType: 'json',
//         success: function(paths) {
//
//             var data = JSON.parse(paths);
//             var html = '<ul>';
//
//             data.forEach(function(item) {
//                 if (Array.isArray(item.children) && item.children.length > 0) {
//                     html += '<li><a href="#">' + item.label + '</a>';
//                     html += renderMenu(item.children); // Recursively render nested menu
//                 } else {
//                     html += '<li><a href="#">' + item.label + '</a></li>';
//                 }
//             });
//             html += '</ul>';
//
//             console.log(html);
//
//             document.getElementById("navigation-bar").innerHTML = menuHtml;
//
//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     });
// });

function renderMenu(paths) {
    var html = '<ul>';

    for (var key in paths) {
        if (paths.hasOwnProperty(key)) { // Ensure the property belongs to the object itself, not inherited
            var item = paths[key];
            if (Array.isArray(item.children) && item.children.length > 0) {
                html += '<li>' + item.label;
                html += renderMenu(item.children); // Recursively render nested menu
            } else {
                html += '<li onclick="handleItemClick(this)">' + item + '</li>';
                // console.log(item.label);
            }
        }
    }

    html += '</ul>';

    return html;
}

function handleItemClick(element) {
    console.log('Clicked item:', element.textContent);

    $.ajax({
        type: "POST",
        url: "event_click_open_note.php",
        data: {note_name: element.textContent},
        success: function(resp) {
            console.log(resp);
            editorInitiation(element.textContent, resp);

            fetchCurrentNote(element.textContent);
        }
    });

}


function handleKeyboardEvent(event) {
    if (event.shiftKey && event.key === "F" ) {
        constructNavigationBar();
    } else if (event.shiftKey && event.key === "S" ) {
        saveNote();
    } else if (event.shiftKey && event.key === "N" ) {
        creationNote();
    } else if (event.shiftKey && event.key === "W" ) {
        saveNote();
        editorDelete();
    }

}

function editorDelete() {

    if ($("#code").length) {
        console.log("Textarea with ID 'code' already exists.");


        var editorWrapper = window.editor.getWrapperElement();
        editorWrapper.parentNode.removeChild(editorWrapper);

        var editorContainer = $("#editor-bar");

        var textarea = $("#code");
        textarea.remove();

        var noteNameSpaceOld = $("#editableNoteName");
        noteNameSpaceOld.remove();

    }

}

$(document).ready(function() {
    $("#noteNameSpace").on("input", function() {
        console.log("Note name modified:", $(this).text());
    });
});

// document.getElementById("editableNoteName").addEventListener("keydown", function(event) {
//     if (event.key === "Enter") {
//         event.preventDefault();
//     }
// });

$(document).ready(function() {
    $("#noteNameSpace").on("input", function() {


        $.post("fetch_session.php", function(sessionData) {
            console.log("Session data:", sessionData);
            FinalRequest(sessionData);
        });

        function FinalRequest(sessionData){

            var content = window.editor?.getValue();
            var note_name = $("#editableNoteName").text();
            // var note_name = "Untitled";
            // console.log(note_name);

            $.ajax({
                type: "POST",
                url: "event_keyboard_rename_note.php",
                data: {login: sessionData.login, note_name: note_name},
                success: function(resp) {
                    console.log(resp);
                }
            });

            constructNavigationBar();
        }
    });
});


function editorInitiation(note_name, content="") {
    // console.log(response);

    if ($("#code").length) {
        console.log("Textarea with ID 'code' already exists.");

        var editorWrapper = window.editor.getWrapperElement();
        editorWrapper.parentNode.removeChild(editorWrapper);

        var editorContainer = $("#editor-bar");

        var textarea = $("#code");
        var noteNameSpaceOld = $("#editableNoteName");
        noteNameSpaceOld.remove();
        textarea.remove();

        var noteNameArea = $("<div>").attr("id", "editableNoteName").attr("contentEditable", "true").text(note_name);

        var noteNameSpace = $("#noteNameSpace");
        noteNameSpace.append(noteNameArea);

        var textarea = $("<textarea>").attr("id", "code").attr("rows", "30").attr("name", "code").text(content);
        editorContainer.append(textarea);

        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            mode: "application/x-httpd-php",
            theme: "default",
            scrollbarStyle: null,
            lineWrapping: true
        });

        window.editor = editor;



    } else{

        var editorContainer = $("#editor-bar");
        var noteNameSpace = $("#noteNameSpace");
        var startMenu = $("#empty-state-action-list");
        startMenu.remove();

        // editorContainer.append(editorContainer);

        var textarea = $("<textarea>").attr("id", "code").attr("rows", "30").attr("name", "code").text(content);
        // var noteNameArea = <div id="editableNoteName" contentEditable="true">Untitled
        // </div>
        // var noteNameArea = '<div id="editableNoteName" contentEditable="true">Untitled</div>';
        var noteNameArea = $("<div>").attr("id", "editableNoteName").attr("contentEditable", "true").text(note_name);

        editorContainer.append(textarea);
        noteNameSpace.append(noteNameArea);

        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            mode: "application/x-httpd-php",
            theme: "default",
            scrollbarStyle: null,
            lineWrapping: true
        });

        window.editor = editor;
    }
}

function saveNote() {

    $.post("fetch_session.php", function(sessionData) {
        console.log("Session data:", sessionData);
        FinalRequest(sessionData);
    });

    function FinalRequest(sessionData){

        console.log(window.editor);
        var content = window.editor?.getValue();
        console.log(content);
        var note_name = $("#editableNoteName").text();
        console.log(note_name);


        $.ajax({
            type: "POST",
            url: "event_keyboard_save_note.php",
            data: {login: sessionData.login, content: content, note_name: note_name},
            success: function(resp) {
                console.log(resp);
            }
        });

        constructNavigationBar();
    }
}

function saveNote0() {


        var content = window.editor?.getValue();
        var note_name = $("#noteNameSpace").text();

        $.ajax({
            type: "POST",
            url: "event_keyboard_save_note.php",
            data: {content: content, note_name: note_name},
            success: function(resp) {
                console.log(resp);
            }
        });

        constructNavigationBar();
}

function fetchCurrentNote(response){

    $.ajax({
        type: "POST",
        url: "fetch_current_note.php",
        data: { currentNote: response},
        success: function(resp) {
            console.log(resp);
        }
    });
}

function creationNote() {

    // $.post("fetch_session.php", function(sessionData) {
    //     console.log("Session data:", sessionData);
    //     FinalRequest(sessionData);
    // });

    function FinalRequest(sessionData){


        $.ajax({
            type: "POST",
            url: "event_keyboard_create_note.php",
            data: { login: sessionData.login},
            success: function(response) {
                console.log(response);
                console.log("note name yes");

                editorInitiation(response);

                var currentNote = $("#editableNoteName").text();
                console.log(currentNote);
                console.log("another flag");

                fetchCurrentNote(currentNote);

                constructNavigationBar();

                console.log(window.editor);


            }
        });


    }
}

function handleClickEvent(event) {
    var editor_window = $("#editor-bar");
    if (!$(editor_window).is(event.target) && $(editor_window).has(event.target).length === 0){
        constructNavigationBar()
    }
}

function constructNavigationBar() {
    $.ajax({
        url: 'event_navigation_bar_fetch.php',
        type: 'GET',
        // dataType: 'json',
        success: function(paths) {
            if (paths == null || paths === ""){
                document.getElementById("navigation-bar").innerHTML = "";
            } else {

                var data = JSON.parse(paths);
                var html = renderMenu(data);

                document.getElementById("navigation-bar").innerHTML = html;
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

$(document).ready(function() {
    constructNavigationBar();
});



document.addEventListener("keydown", handleKeyboardEvent);
document.addEventListener("click", handleClickEvent);
// document.getElementById("your-button-id").addEventListener("click", handleClickEvent);