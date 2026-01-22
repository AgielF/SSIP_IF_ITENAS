<!-- Panel Tab untuk Publikasi dan Proyek -->
<div class="container my-5"> 
    <div class="profile-card">
        <ul class="nav nav-tabs" id="dosenTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="publikasi-tab" data-bs-toggle="tab" data-bs-target="#publikasi" type="button" role="tab">
                    Publikasi Ilmiah
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="proyek-tab" data-bs-toggle="tab" data-bs-target="#proyek" type="button" role="tab">
                    Penelitian & Proyek
                </button>
            </li>
        </ul>

        <div class="tab-content pt-4" id="dosenTabContent">
            
            <!-- Publikasi -->
            <div class="tab-pane fade show active" id="publikasi" role="tabpanel">
                <div class="printable-area">
                    <div class="table-responsive">
                        <table class="table table-hover" id="publikasiTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Jenis</th>
                                    <th>Tahun</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php if (empty($publicationData)): ?>
        <tr>
            <td colspan="5" class="text-center text-muted">Belum ada publikasi</td>
        </tr>
    <?php else: ?>
        <?php foreach ($publicationData as $i => $pub): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <!-- 🔹 Gunakan deskripsi jika judul kosong -->
                <td><?= esc($pub['judul'] ?? $pub['deskripsi'] ?? '-') ?></td>
                <td><?= esc($pub['jenis_publikasi'] ?? '-') ?></td>
                <td><?= esc($pub['tahun'] ?? '-') ?></td>
                <td>
                    <?php if (!empty($pub['link_doi'])): ?>
                        <a href="<?= esc($pub['link_doi']) ?>" target="_blank">DOI</a>
                    <?php endif; ?>
                    <?php if (!empty($pub['link_publikasi'])): ?>
                        | <a href="<?= esc($pub['link_publikasi']) ?>" target="_blank">Publikasi</a>
                    <?php endif; ?>
                    <?php if (!empty($pub['link_gdrive'])): ?>
                        | <a href="<?= esc($pub['link_gdrive']) ?>" target="_blank">GDrive</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
    <?php endif; ?>
</tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Proyek Riset -->
            <div class="tab-pane fade" id="proyek" role="tabpanel">
                <div class="printable-area">
                    <div class="table-responsive">
                        <table class="table table-hover" id="proyekTable">
                            <thead>
                                <tr>
                                    <th>Judul Proyek</th>
                                    <th>Deskripsi</th>
                                    <th>Mitra</th>
                                    <th>Sumber Dana</th>
                                    <th>Tahun Mulai</th>
                                    <th>Tahun Selesai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($proyekData)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada proyek riset</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($proyekData as $proyek): ?>
                                        <?php 
                                            $tahunSelesai = $proyek['tahun_selesai'] ?? date('Y');
                                            $status = ($tahunSelesai < date('Y')) ? 'Selesai' : 'Berjalan';
                                        ?>
                                        <tr>
                                            <td><?= esc($proyek['judul'] ?? '-') ?></td>
                                            <td><?= esc($proyek['deskripsi'] ?? '-') ?></td>
                                            <td><?= esc($proyek['mitra'] ?? '-') ?></td>
                                            <td><?= esc($proyek['sumber_dana'] ?? '-') ?></td>
                                            <td><?= esc($proyek['tahun_mulai'] ?? '-') ?></td>
                                            <td><?= esc($proyek['tahun_selesai'] ?? '-') ?></td>
                                            <td>
                                                <span class="badge <?= $status=='Selesai' ? 'bg-primary' : 'bg-info' ?>">
                                                    <?= $status ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
