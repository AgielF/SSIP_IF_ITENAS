<?= $this->include('layout/header') ?>

<?= $this->include('sections/slider') ?>

<main>
    <div class="container my-5">
        <h1 class="mb-4">Jadwal Praktikum Laboratorium</h1>

        <!-- View Toggle -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <p class="mb-0">Daftar jadwal praktikum yang tersedia</p>
            <div class="btn-group">
                <a href="/jadwal-praktikum?view=list" class="btn btn-outline-primary <?= $current_view == 'list' ? 'active' : '' ?>">List View</a>
                <a href="/jadwal-praktikum?view=calendar" class="btn btn-outline-primary <?= $current_view == 'calendar' ? 'active' : '' ?>">Calendar View</a>
            </div>
        </div>

        <?php if($current_view == 'calendar'): ?>
            <?= $this->include('sections/jadwal_calendar') ?>
        <?php else: ?>
            <?= $this->include('sections/jadwal_list') ?>
        <?php endif; ?>
    </div>
</main>

<?= $this->include('layout/footer') ?>