<div class="calendar-container">
    <div id="calendar" class="bg-white p-4 rounded shadow-sm"></div>
</div>

<!-- FullCalendar CSS & JS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    // Prepare events data from PHP
    var events = [
        <?php if (!empty($schedules)): ?>
            <?php foreach ($schedules as $schedule): ?>
                {
                    id: '<?= esc($schedule['id_jadwal']) ?>',
                    title: '<?= esc($schedule['title']) ?>',
                    start: '<?= esc($schedule['date']) ?>T<?= date('H:i:s', strtotime(explode(' - ', $schedule['time'])[0])) ?>',
                    end: '<?= esc($schedule['date']) ?>T<?= date('H:i:s', strtotime(explode(' - ', $schedule['time'])[1])) ?>',
                    backgroundColor: getStatusColor('<?= esc($schedule['status']) ?>'),
                    borderColor: getStatusColor('<?= esc($schedule['status']) ?>'),
                    extendedProps: {
                        lab: '<?= esc($schedule['lab']) ?>',
                        instructor: '<?= esc($schedule['instructor']) ?>',
                        status: '<?= esc($schedule['status']) ?>'
                    }
                }<?= (end($schedules) !== $schedule) ? ',' : '' ?>
            <?php endforeach; ?>
        <?php endif; ?>
    ];

    function getStatusColor(status) {
        switch(status.toLowerCase()) {
            case 'upcoming': return '#0d6efd'; // blue
            case 'today': return '#fd7e14'; // orange
            case 'completed': return '#198754'; // green
            default: return '#6c757d'; // gray
        }
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: events,
        eventClick: function(info) {
            // Show event details in a modal or alert
            alert(
                'Jadwal: ' + info.event.title + '\n' +
                'Tanggal: ' + info.event.start.toLocaleDateString('id-ID') + '\n' +
                'Waktu: ' + info.event.start.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) +
                ' - ' + info.event.end.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) + '\n' +
                'Ruangan: ' + info.event.extendedProps.lab + '\n' +
                'Asisten: ' + info.event.extendedProps.instructor + '\n' +
                'Status: ' + info.event.extendedProps.status
            );
        },
        eventMouseEnter: function(info) {
            // Optional: Show tooltip on hover
        }
    });

    calendar.render();
});
</script>