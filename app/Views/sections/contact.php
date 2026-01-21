<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fa;
        }
        .contact-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row g-4 align-items-stretch">

        <!-- ================= CONTACT CARD ================= -->
        <div class="col-lg-6">
            <div class="contact-card h-100">

                <h3 class="mb-3 text-center">Contact Us</h3>
                <p class="text-muted text-center">
                    Silakan hubungi kami melalui form di bawah ini.
                </p>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('debug')): ?>
                    <pre class="bg-light p-2 small">
<?= session()->getFlashdata('debug') ?>
                    </pre>
                <?php endif; ?>

                <form action="<?= site_url('contact/send') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subjek</label>
                        <input type="text" name="subject" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Pesan</label>
                        <textarea name="message" rows="5" class="form-control" required></textarea>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary">
                            Kirim Pesan
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <!-- ================= MAP CARD ================= -->
        <div class="col-lg-6">
            <div class="contact-card h-100 p-0 overflow-hidden">

                <div class="p-3 text-center border-bottom">
                    <h5 class="mb-0">Lokasi Kami</h5>
                    <small class="text-muted">Kampus / Kantor Riset</small>
                </div>

                <!-- MAP -->
                <iframe
                    src="https://www.google.com/maps?q=-6.897718323036624,107.63626459640159&hl=id&z=15&output=embed"
                    width="100%"
                    height="100%"
                    style="border:0; min-height:420px;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>

            </div>
        </div>

    </div>
</div>


</body>
</html>
