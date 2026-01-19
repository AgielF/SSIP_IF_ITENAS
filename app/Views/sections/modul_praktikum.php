<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VR Learning Platform</title>
    <style>
        body { font-family: sans-serif; color: #333; background-color: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        .lesson-card { background-color: #fff; border-radius: 8px; padding: 25px; margin-bottom: 20px;
                       display: flex; justify-content: space-between; align-items: center; border: 1px solid #e9e9e9; }
        .lesson-content { flex-basis: 60%; }
        .lesson-image { flex-basis: 35%; text-align: right; }
        .lesson-image img { max-width: 100%; border-radius: 8px; }
        h2 { font-size: 24px; margin-top: 0; color: #444; }
        p { color: #777; line-height: 1.6; }
        .btn { border: 1px solid #3498db; color: #3498db; padding: 10px 20px; text-decoration: none;
               border-radius: 5px; display: inline-block; margin-top: 15px; font-weight: bold; }
        .status { margin-top: 20px; color: #aaa; font-style: italic; }
        .header { display: flex; justify-content: space-between; align-items: center; padding: 20px;
                  background-color: #fff; border: 1px solid #e9e9e9; border-radius: 8px; margin-bottom: 20px; }
        .header-title { color: #999; }
        .header-title span { display: block; font-size: 20px; color: #333; }
        .btn-primary { background-color: #3498db; color: #fff; text-decoration: none; padding: 12px 25px; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">

    <?php if (!empty($modulPraktikum)): ?>
        <?php foreach ($modulPraktikum as $modul): ?>
            <section class="lesson-card">
                <div class="lesson-content">
                    <h2><?= esc($modul['judul'] ?? 'Modul Praktikum') ?></h2>
                    <p><?= esc($modul['deskripsi'] ?? 'Deskripsi modul belum tersedia.') ?></p>
                    <?php if (!empty($modul['file_url'])): ?>
                        <a href="<?= base_url('modul-praktikum/download/'.$modul['file_url']) ?>" class="btn">📥 DOWNLOAD PDF</a>
                        <a href="<?= base_url('modul-praktikum/preview/'.$modul['file_url']) ?>" target="_blank" class="btn" style="background-color: #27ae60; border-color: #27ae60;">👁️ PREVIEW PDF</a>
                    <?php else: ?>
                        <span class="text-muted">File belum tersedia</span>
                    <?php endif; ?>
                    <div class="status">Tanggal: <?= esc($modul['jadwal_tanggal']) ?></div>
                </div>
                <div class="lesson-image">
                    <?php if (!empty($modul['file_url'])): ?>
                        <img src="https://via.placeholder.com/300x150.png?text=PDF+File" alt="PDF Icon">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x150.png?text=Modul+Praktikum" alt="Default Gambar">
                    <?php endif; ?>
                </div>
            </section>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tidak ada data modul praktikum tersedia.</p>
    <?php endif; ?>

</div>

</body>
</html>
