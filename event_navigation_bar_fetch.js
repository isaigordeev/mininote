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
    } else if (event.shiftKey && event.key === "C" ) {
        makePublic();
    } else if (event.shiftKey && event.key === "V" ) {
        makePrivate();
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

        const actions = [
            "Create new file (Shift N)",
            "Make a note public (Shift C)",
            "Make a note private (Shift V)",
            "Save and Quit (Shift W)",
            "Save (Shift S)",
        ];

// Create a new div to hold the actions
        const actionList = $("<div id='empty-state-action-list'></div>");

        actionList.append("<h2>No file is open</h2>");

// Loop through the actions and create div elements for each
        actions.forEach(action => {
            const div = $("<div></div>");
            div.addClass("empty-state-action");
            div.text(action);
            actionList.append(div);
        });

// Create a parent container with the class "col-md-6 offset-md-3"
        const parentContainer = $("<div></div>");
        parentContainer.addClass("col-md-6 offset-md-3");

// Insert the action list into the parent container
        parentContainer.append(actionList);

// Insert the parent container after the editor-bar
        editorContainer.after(parentContainer);


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

            var content = window.editor?.getValue();
            var note_name = $("#editableNoteName").text();

            $.ajax({
                type: "POST",
                url: "event_keyboard_rename_note.php",
                data: {content: content, note_name: note_name},
                success: function(resp) {
                    console.log(resp);

                    fetchCurrentNote(note_name);
                    constructNavigationBar();

                }
            });

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

        function refreshEditorSize() {
            editor.refresh();
        }

        editor.on("change", function() {
            refreshEditorSize();
        });

        window.editor = editor;



    } else{

        var editorContainer = $("#editor-bar");
        var noteNameSpace = $("#noteNameSpace");
        var startMenu = $("#empty-state-action-list");
        startMenu.remove();


        var textarea = $("<textarea>").attr("id", "code").attr("rows", "30").attr("name", "code").text(content);
        var noteNameArea = $("<div>").attr("id", "editableNoteName").attr("contentEditable", "true").text(note_name);

        editorContainer.append(textarea);
        noteNameSpace.append(noteNameArea);

        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            mode: "application/x-httpd-php",
            theme: "default",
            scrollbarStyle: null,
            lineWrapping: true,
            autoRefresh: true
        });

        function refreshEditorSize() {
            editor.refresh();
        }

        editor.on("change", function() {
            refreshEditorSize();
        });

        window.editor = editor;
    }
}

function saveNote0() {

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

function saveNote() {


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

function makePublic() {

    $.ajax({
        type: "POST",
        url: "event_keyboard_make_note_public.php",
        success: function(resp) {
            console.log(resp);
        }
    });
}

function makePrivate() {

    $.ajax({
        type: "POST",
        url: "event_keyboard_make_note_private.php",
        success: function(resp) {
            console.log(resp);
        }
    });
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

function creationNote0() {

    $.post("fetch_session.php", function(sessionData) {
        console.log("Session data:", sessionData);
        FinalRequest(sessionData);
    });

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


function creationNote() {

        $.ajax({
            type: "POST",
            url: "event_keyboard_create_note.php",
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
                console.log(paths);
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

function constructWall() {
    $.ajax({
        url: 'event_wall_fetch.php',
        type: 'GET',
        success: function(paths_json) {
            // Parse JSON data
            console.log(paths_json);
            var data = JSON.parse(paths_json);

            // Check if data is empty or null
            if (!data || data.length === 0) {
                document.getElementById("wall").innerHTML = "<p>No notes available</p>";
            } else {
                console.log(data);
                var html = '';

                // Iterate over each note in the data
                data.forEach(function(note) {
                    // Generate HTML for the note
                    html += '<div class="container">';
                    html += '<div class="row">';
                    html += '<div class="col-md-8 offset-md-1">';
                    html += '<div class="card">';
                    html += '<div class="card-header">';
                    html += 'Author: ~' + note.login;
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<h5 class="card-title">Title: ' + note.name + '</h5>';
                    html += '<p class="card-text">' + note.text + '</p>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                });

                // Insert generated HTML into the wall
                document.getElementById("wall").innerHTML = html;
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}



$(document).ready(function() {
    constructNavigationBar();
    constructWall();
});



document.addEventListener("keydown", handleKeyboardEvent);
document.addEventListener("click", handleClickEvent);
// document.getElementById("your-button-id").addEventListener("click", handleClickEvent);