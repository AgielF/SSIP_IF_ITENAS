<div class="calendar-container">
    <div id="calendar" class="bg-white p-4 rounded shadow-sm"></div>
</div>

<!-- FullCalendar CSS & JS -->

<script src='<?= base_url('assets/vendor/fullcalendar/index.global.min.js') ?>'></script>

<?php
function getStatusColorPHP($status) {
    switch(strtolower($status)) {
        case 'upcoming': return '#0d6efd'; // blue
        case 'today': return '#fd7e14'; // orange
        case 'completed': return '#198754'; // green
        default: return '#6c757d'; // gray
    }
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    // Prepare events data from PHP
    var events = <?= json_encode(array_map(function($schedule) {
        return [
            'id' => $schedule['id_jadwal'],
            'title' => $schedule['title'],
            'start' => $schedule['raw_date'] . 'T' . date('H:i:s', strtotime(explode(' - ', $schedule['time'])[0])),
            'end' => $schedule['raw_date'] . 'T' . date('H:i:s', strtotime(explode(' - ', $schedule['time'])[1])),
            'backgroundColor' => getStatusColorPHP($schedule['status']),
            'borderColor' => getStatusColorPHP($schedule['status']),
            'extendedProps' => [
                'kelas' => $schedule['kelas'],
                'lab' => $schedule['lab'],
                'instructor' => $schedule['instructor'],
                'assistants' => $schedule['assistants'],
                'status' => $schedule['status']
            ]
        ];
    }, $schedules ?? [])) ?>;

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
                'Dosen: ' + info.event.extendedProps.instructor + '\n' +
                'Asisten: ' + info.event.extendedProps.assistants + '\n' +
                'Status: ' + info.event.extendedProps.status
            );
        },
        eventContent: function(arg) {
            // Custom event display
            return {
                html: '<div class="fc-event-title" style="font-size: 16px; font-weight: bold;">' + arg.event.title + ' ' + arg.event.extendedProps.kelas + '</div>'
            };
        },
        eventMouseEnter: function(info) {
            // Show tooltip
            var tooltip = document.createElement('div');
            tooltip.className = 'calendar-tooltip';
            tooltip.innerHTML = '<strong>' + info.event.title + '</strong><br>' +
                                'Kelas: ' + info.event.extendedProps.kelas + '<br>' +
                                'Waktu: ' + info.event.start.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) +
                                ' - ' + info.event.end.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) + '<br>' +
                                'Ruangan: ' + info.event.extendedProps.lab + '<br>' +
                                'Asisten: ' + info.event.extendedProps.assistants + '<br>' +
                                'Status: ' + info.event.extendedProps.status;
            tooltip.style.position = 'absolute';
            tooltip.style.background = 'rgba(0,0,0,0.8)';
            tooltip.style.color = 'white';
            tooltip.style.padding = '5px 10px';
            tooltip.style.borderRadius = '4px';
            tooltip.style.zIndex = '1000';
            tooltip.style.pointerEvents = 'none';
            document.body.appendChild(tooltip);

            var rect = info.el.getBoundingClientRect();
            tooltip.style.left = rect.left + 'px';
            tooltip.style.top = (rect.top - 30) + 'px';

            info.el.tooltip = tooltip;
        },
        eventMouseLeave: function(info) {
            if (info.el.tooltip) {
                document.body.removeChild(info.el.tooltip);
                info.el.tooltip = null;
            }
        }
    });

    calendar.render();
});
</script>