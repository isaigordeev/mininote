$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: '',
            right: ''
        },
        editable: true, // droit de déplacer
        eventSources: [
            // your event source
            {
                url: 'scripts/getEvents.php', // use the `url` property
                color: 'yellow', // an option!
                textColor: 'black'  // an option!
            }
        ],
        eventClick: function(calEvent, jsEvent, view) {
            alert('Event: ' + calEvent.title);
            alert('id: ' + calEvent.id);
            alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            alert('View: ' + view.name);

            // change the border color just for fun
            $(this).css('border-color', 'red');
        },
        /*eventDragStart: function(calEvent, jsEvent, ui, view ){
            console.log(calEvent.id);
        },*/
        eventDrop: function(event, delta, revertFunc, jsEvent, ui, view ){
            console.log("debut:"+event.start.format()+"id:"+event.id);
        }
    });
});
