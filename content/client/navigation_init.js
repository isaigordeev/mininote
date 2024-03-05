function renderMenu(paths) {
    var html = '<ul>';

    for (var key in paths) {
        if (paths.hasOwnProperty(key)) { // Ensure the property belongs to the object itself, not inherited
            var item = paths[key];
            if (Array.isArray(item.children) && item.children.length > 0) {
                html += '<li>' + item.label;
                html += renderMenu(item.children); // Recursively render nested menu
            } else {
                html += '<li>' + item + '</li>';
                // console.log(item.label);
            }
        }
    }

    html += '</ul>';

    return html;
}


function navigationBarUpdate(){
    $.ajax({
        url: 'event_navigation_bar_fetch.php',
        type: 'GET',
        dataType: 'json',
        success: function(paths) {
            console.log(paths);
            // var data = JSON.parse(paths);
            var html = renderMenu(paths);

            // Update the navigation bar with the generated HTML
            document.getElementById("navigation-bar").innerHTML = html;

            // var newElement = $("<div>").text("Initialized Element");
            // $("body").append(newElement);

        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}





// navigationBarUpdate()