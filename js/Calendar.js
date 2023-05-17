document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth'
    });
    calendar.render();
});


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    fetch('get-meetings.php')
        .then(response => response.json())
        .then(meetings => {
            var events = meetings.map(function(meeting) {
                return {
                    title: meeting.name, // Change 'name' to the appropriate field in your database
                    start: meeting.date, // Change 'date' to the appropriate field in your database
                    end: meeting.date, // Change 'date' to the appropriate field in your database
                    // You might need to combine the date and time fields
                };
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events,
            });

            calendar.render();
        });
});