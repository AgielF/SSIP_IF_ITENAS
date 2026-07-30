<div class="container my-5">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3">Jadwal Kalender</h2>
        <a href="/jadwal" class="btn btn-outline-primary"><i class="fas fa-calendar-alt me-2"></i>List View</a>
    </div>

    <!-- Di sinilah kalender akan dimuat oleh JavaScript -->
    <div id="calendar" class="bg-white p-4 rounded shadow-sm"></div>
</div>

<!-- FullCalendar CSS & JS (via CDN) -->
<script src='<?= base_url('assets/vendor/fullcalendar/index.global.min.js') ?>'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        // Tampilan awal kalender
        initialView: 'dayGridMonth', 
        
        // Konfigurasi tombol-tombol di header kalender
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        
        // Membuat kalender bisa diklik
        selectable: true,
        
        // Data acara/jadwal.
        // IDEALNYA: data ini diambil dari URL API, contoh: '/api/get_jadwal'
        // Untuk demo, kita gunakan data statis.
        events: [
            {
                title: 'Praktikum Fisika - Kelompok A',
                start: '2025-07-21T10:00:00',
                end: '2025-07-21T12:00:00',
                backgroundColor: '#0d6efd', // Biru
                borderColor: '#0d6efd'
            },
            {
                title: 'Rapat Asisten Lab',
                start: '2025-07-22',
                allDay: true, // Acara seharian
                backgroundColor: '#198754', // Hijau
                borderColor: '#198754'
            },
            {
                title: 'Praktikum Fisika - Kelompok B',
                start: '2025-07-23T13:00:00',
                end: '2025-07-23T15:00:00',
                backgroundColor: '#0d6efd',
                borderColor: '#0d6efd'
            },
            {
                title: 'Batas Akhir Pengumpulan Laporan',
                start: '2025-07-25',
                allDay: true,
                backgroundColor: '#dc3545', // Merah
                borderColor: '#dc3545'
            }
        ]
    });

    // Render kalender
    calendar.render();
});
</script>