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
                html += '<li><a href="#">' + item.label + '</a>';
                html += renderMenu(item.children); // Recursively render nested menu
            } else {
                html += '<li><a href="#">' + item + '</a></li>';
                // console.log(item.label);
            }
        }
    }

    html += '</ul>';

    return html;
}

function handleKeyboardEvent(event) {
    if (event.shiftKey && event.key === "F" ) {
        constructNavigationBar();
    } else if (event.shiftKey && event.key === "S" ) {
        saveNote();
    } else if (event.shiftKey && event.key === "N" ) {
        creationNote();
        editorInitiation();
    }
}

function editorInitiation() {
    // console.log(response);

    if ($("#code").length) {
        console.log("Textarea with ID 'code' already exists.");


        var editorWrapper = window.editor.getWrapperElement();
        editorWrapper.parentNode.removeChild(editorWrapper);

        var editorContainer = $("#editor-bar");

        var textarea = $("#code");
        textarea.remove();

        var textarea = $("<textarea>").attr("id", "code").attr("rows", "30").attr("name", "code");
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
        var newElement = $("<div>").text("Initialized Element");
        $("body").append(newElement);

        var editorContainer = $("#editor-bar");
        var startMenu = $("#empty-state-action-list");
        startMenu.remove();

        // editorContainer.append(editorContainer);

        var textarea = $("<textarea>").attr("id", "code").attr("rows", "30").attr("name", "code");
        editorContainer.append(textarea);

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

        var content = window.editor?.getValue();

        $.ajax({
            type: "POST",
            url: "event_keyboard_save_note.php",
            data: { login: sessionData.login, content: content},
            success: function(resp) {
                console.log(resp);
            }
        });

        constructNavigationBar();
    }
}

function creationNote() {

    $.post("fetch_session.php", function(sessionData) {
        console.log("Session data:", sessionData);
        FinalRequest(sessionData);
    });

    function FinalRequest(sessionData){


        $.ajax({
            type: "POST",
            url: "event_keyboard_create_note.php",
            data: { login: sessionData.login},
            success: function() {
                // console.log(response);

                if ($("#code").length) {
                    console.log("Textarea with ID 'code' already exists.");

                    var editorWrapper = window.editor.getWrapperElement();
                    editorWrapper.parentNode.removeChild(editorWrapper);

                    var editorContainer = $("#editor-bar");

                    var textarea = $("#code");
                    textarea.remove();

                    var textarea = $("<textarea>").attr("id", "code").attr("rows", "30").attr("name", "code");
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
                    var newElement = $("<div>").text("Initialized Element");
                    $("body").append(newElement);

                    var editorContainer = $("#editor-bar");
                    var startMenu = $("#empty-state-action-list");
                    startMenu.remove();

                    // editorContainer.append(editorContainer);

                    var textarea = $("<textarea>").attr("id", "code").attr("rows", "30").attr("name", "code");
                    editorContainer.append(textarea);

                    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                        lineNumbers: true,
                        mode: "application/x-httpd-php",
                        theme: "default",
                        scrollbarStyle: null,
                        lineWrapping: true
                    });

                    window.editor = editor;
                }

                constructNavigationBar();
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
            console.log(paths);
            var data = JSON.parse(paths);
            var html = renderMenu(data);

            document.getElementById("navigation-bar").innerHTML = html;

            var newElement = $("<div>").text("Initialized Element");
            $("body").append(newElement);

        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}


// Add event listener for the "keydown" event on the document
document.addEventListener("keydown", handleKeyboardEvent);
document.addEventListener("click", handleClickEvent);
// document.getElementById("your-button-id").addEventListener("click", handleClickEvent);