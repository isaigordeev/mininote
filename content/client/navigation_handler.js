var menuItems = document.querySelectorAll('ul > li');

menuItems.forEach(function(item) {
    item.addEventListener('click', function(event) {
        var submenu = item.querySelector('ul');
        if (submenu) {
            if (submenu.style.display === 'none') {
                submenu.style.display = 'block';
            } else {
                submenu.style.display = 'none';
            }
        }
    }
    );

    item.addEventListener('click', openNote);

    var submenuItems = item.querySelectorAll('ul > li');
    submenuItems.forEach(function(subitem) {
        subitem.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
});


function openNote(event){
    var note_name = event.target.item;
    $.ajax({
        url: 'event_click_open_note.php',
        type: 'GET',
        dataType: 'json',
        data: {note_name: note_name},
        success: function(text) {
            console.log(text);
            // var data = JSON.parse(paths);

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