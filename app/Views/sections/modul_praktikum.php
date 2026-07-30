<?= $this->include('layout/header') ?? '' ?>
<?= $this->include('sections/slider') ?? '' ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Modul Praktikum</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        /* Styling Khusus Card Etalase */
        .etalase-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 24px 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }
        .etalase-card:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transform: translateY(-2px);
        }
        .etalase-icon {
            font-size: 38px;
            margin-bottom: 15px;
        }
        .etalase-title {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
            line-height: 1.4;
        }
        .etalase-badges {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-bottom: 15px;
        }
        .etalase-badge-outline {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 4px;
            border: 1px solid #d1d5db;
            color: #4b5563;
            background: #ffffff;
            font-weight: 500;
        }
        .etalase-desc {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .etalase-actions {
            margin-top: auto; /* Mendorong tombol selalu ke paling bawah card */
            width: 100%;
            display: flex;
            gap: 10px;
        }
        .btn-etalase {
            flex: 1;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 0;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="container my-5">

    <div class="mb-5 text-center">
        <h3 class="fw-bold text-dark">Daftar Modul Praktikum</h3>
        <p class="text-muted">Akses dan unduh materi praktikum Anda di bawah ini.</p>
    </div>

    <div class="row g-4">
        <?php if (!empty($modulPraktikum)): ?>
            <?php foreach ($modulPraktikum as $modul): ?>
                
                <div class="col-md-6 col-lg-4">
                    <div class="etalase-card">
                        
                        <div class="etalase-icon">
                            <?php 
                                $fileUrl = $modul['file_url'] ?? '';
                                $isPdf = preg_match('/\.pdf$/i', $fileUrl);
                                
                                if ($isPdf) {
                                    echo '<i class="fas fa-file-pdf text-danger"></i>';
                                } elseif (!empty($fileUrl)) {
                                    echo '<i class="fas fa-file-word text-primary"></i>';
                                } else {
                                    echo '<i class="fas fa-file-alt text-secondary"></i>';
                                }
                            ?>
                        </div>

                        <div class="etalase-title">
                            <?= esc($modul['judul'] ?? 'Modul Praktikum') ?>
                        </div>

                      

                        <div class="etalase-desc">
                            <?= esc($modul['deskripsi'] ?? 'Deskripsi modul belum tersedia.') ?>
                        </div>

                        <div class="etalase-actions">
                            <?php if (!empty($fileUrl)): ?>
                                <a href="<?= base_url('modul-praktikum/download/'.$fileUrl) ?>" class="btn btn-outline-primary btn-etalase">
                                    <i class="fas fa-download me-1"></i> Unduh
                                </a>
                                <?php if ($isPdf): ?>
                                    <a href="<?= base_url('modul-praktikum/preview/'.$fileUrl) ?>" target="_blank" class="btn btn-primary btn-etalase">
                                        <i class="fas fa-eye me-1"></i> Buka
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="w-100 text-muted" style="font-size: 12px; font-style: italic;">File belum tersedia</span>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-light text-center border py-5 text-muted">
                    <i class="fas fa-folder-open fs-1 mb-3"></i><br>
                    Tidak ada data modul praktikum tersedia.
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
<?= $this->include('layout/footer') ?? '' ?>