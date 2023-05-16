document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth'
    });
    calendar.render();
});


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        events: [
            {
                title: 'Meeting with Ismail',
                start: '2023-05-15',
                end: '2023-05-16'
            },
            {
                title: 'Event 2',
                start: '2023-05-18',
                end: '2023-05-20'
            }
            // Add more events as needed
        ]
    });

    calendar.render();
});