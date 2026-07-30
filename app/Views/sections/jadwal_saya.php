<style>
    .schedule-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    #jadwalSayaTable thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        border-bottom: 2px solid #e9ecef;
    }
    #jadwalSayaTable tbody tr {
        border-bottom: 1px solid #e9ecef;
    }
    #jadwalSayaTable tbody tr:last-child {
        border-bottom: none;
    }
</style>

<div class="container my-5">
    <div class="schedule-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Jadwal Asistensi Saya</h4>
        </div>

        <div class="table-responsive">
            <table id="jadwalSayaTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th>Matakuliah</th>
                        <th>Kelas</th>
                        <th>Hari & Tanggal</th>
                        <th>Jam</th>
                        <th>Dosen</th>
                        <th>Ruangan</th>
                        <th>Asisten Bertugas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($schedules)): ?>
                        <?php $no = 1; foreach ($schedules as $schedule): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="fw-medium text-dark"><?= esc($schedule['title']) ?></span></td>
                                <td><?= esc($schedule['kelas'] ?: '-') ?></td>
                                <td><?= esc($schedule['date']) ?></td>
                                <td><?= esc($schedule['time']) ?></td>
                                <td><?= esc($schedule['instructor']) ?></td>
                                <td><?= esc($schedule['lab']) ?></td>
                                <td><?= esc($schedule['assistants']) ?></td>
                                <td>
                                    <span class="badge bg-<?= esc($schedule['status_color']) ?>">
                                        <?= esc($schedule['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times mb-2 fs-3 d-block"></i>
                                Anda belum ditugaskan pada jadwal praktikum manapun.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
