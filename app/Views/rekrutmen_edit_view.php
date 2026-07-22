<div class="container my-5">
    <h3>Edit Rekrutmen</h3>

    <form action="/rekrutmen/update/<?= $rekrut['id_rekrut'] ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control" 
                   value="<?= esc($rekrut['deskripsi']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <input type="text" name="status" class="form-control" 
                   value="<?= esc($rekrut['status']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Syarat</label>
            <textarea name="syarat" class="form-control" required><?= esc($rekrut['syarat']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Jadwal</label>
            <select name="id_jadwal" class="form-select" required>
                <option value="">-- Pilih Jadwal --</option>
                <?php foreach ($jadwal as $j): ?>
                    <option value="<?= $j['id_jadwal'] ?>" 
                        <?= $j['id_jadwal'] == $rekrut['id_jadwal'] ? 'selected' : '' ?>>
                        <?= esc($j['tanggal']) ?> (<?= esc($j['waktu_mulai']) ?>) - <?= esc($j['nama_event']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/rekrutmen_admin" class="btn btn-secondary">Batal</a>
    </form>
</div>
