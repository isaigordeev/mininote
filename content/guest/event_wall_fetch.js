
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
                    html += '<div class="note">';
                    html += '<div class="note-header">';
                    html += '<h4 class="login">' + note.login + '</h4>';
                    html += '<h4 class="name">' + note.name + '</h4>';
                    html += '</div>';
                    html += '<p>' + note.text + '</p>';
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
    constructWall();
});
