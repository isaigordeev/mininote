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
    });

    var submenuItems = item.querySelectorAll('ul > li');
    submenuItems.forEach(function(subitem) {
        subitem.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
});