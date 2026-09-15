---
description: Refactor views SSIP ke CUBE CSS + Atomic Design + ES Modules
---

# /refactor-views

Repo: SSIP_IF_ITENAS
Branch: refactor/views (WAJIB aktif — konfirmasi dulu)
Rules: .agents/rules/refactor-views.md (WAJIB dibaca & dipatuhi)

## INSTRUKSI

Baca `.agents/rules/refactor-views.md` dulu. Konfirmasi branch = `refactor/views`. Lalu jalankan 8 fase berikut BERTAHAP, commit per fase, tanpa tanya sampai selesai.

## SCOPE EDIT
- app/Views/**
- public/assets/css/**
- public/assets/js/**
- app/Cells/** (baru)
- app/Config/TemplateMenu.php (baru)

DILARANG edit: Controllers, Models, Config (kecuali TemplateMenu), migrations, .env, composer.json.

## PRINSIP
1. Zero behavior change — fitur harus sama persis
2. Commit per fase pakai Conventional Commits
3. Error tidak bisa fix dalam 2x percobaan → skip, catat di docs/refactor/skipped.md, lanjut
4. JANGAN push ke remote
5. STOP setelah FASE 8, lapor hasil

## FASE 1 — BASELINE
Commit: `chore(views): setup refactor baseline`
- Konfirmasi branch
- List semua file di app/Views/, public/assets/css/, public/assets/js/
- List library di public/assets/ (bootstrap, fontawesome, dll)
- Catat baseline di docs/refactor/baseline.md (struktur + file dengan inline style/script)

## FASE 2 — DESIGN TOKENS
Commit: `feat(css): add design tokens`
- Scan views, ekstrak warna/spacing/radius/shadow yang dipakai
- Buat public/assets/css/tokens.css dengan CSS custom properties :root
- Ambil nilai dari kode lama SSIP supaya konsisten

## FASE 3 — CUBE CSS
Commit: `feat(css): add cube css layers`
- Buat public/assets/css/base.css (reset + elemen dasar)
- Buat public/assets/css/composition.css (flow, grid, cluster, sidebar, container)
- Buat public/assets/css/blocks.css (btn, card, alert, badge, form-group, table, modal, pagination, toast)
- Buat public/assets/css/exceptions.css (utility + override Bootstrap)
- Buat public/assets/css/main.css (entry point @import semua)
- Update layout main.php + admin_header.php untuk load main.css

## FASE 4 — JS MODULES
Commit: `feat(js): add es modules`
- Buat public/assets/js/app.js (entry point, baca JSON island)
- Buat public/assets/js/core/utils.js (escapeHtml, debounce, formatDate)
- Buat public/assets/js/modules/rbac.js
- Buat public/assets/js/modules/datatable.js
- Buat public/assets/js/modules/export.js
- Buat public/assets/js/modules/modal.js
- Buat public/assets/js/modules/toast.js
- Update layout: tambah JSON island (#app-config) + load app.js type=module

## FASE 5 — COMPONENTS & CELLS
Commit: `feat(views): add reusable components`
- Buat app/Views/components/_alert.php, _modal.php, _form-group.php, _pagination.php, _table-empty.php, _table-loading.php
- Buat app/Cells/MenuCell.php
- Buat app/Config/TemplateMenu.php (menu array, pindahkan dari header hardcoded)
- Semua komponen enforce a11y (label for, aria-*, role)

## FASE 6 — PILOT MIGRATION
Commit: `refactor(views): migrate berita section`
- Refactor HANYA app/Views/sections/berita_list_admin.php
- Hapus inline <style> dan <script>
- Pakai components/ dan modules/ yang sudah dibuat
- Hardcoded warna → CSS variable
- Perbaiki a11y (label for, modal aria, th scope)
- Naming konsisten kebab-case

## FASE 7 — BATCH MIGRATION
Loop semua file di app/Views/sections/*.php (kecuali berita).
Setiap file = 1 commit: `refactor(views): migrate {nama_modul} section`
Kalau butuh component baru → commit terpisah dulu: `feat(views): add {nama} component`
Kalau error → skip, catat di docs/refactor/skipped.md, lanjut

## FASE 8 — CLEANUP
Commit: `chore(views): cleanup and update readme`
- Grep sisa inline style/script, fix kalau ada
- Grep hardcoded warna, ganti CSS variable
- Update layout/footer.php: hapus branding SSIP, ganti pakai config('App')->siteName
- Update layout/header.php & admin_header.php: menu dari TemplateMenu via MenuCell
- Update .env.example: hapus credential, tambah app.siteName, app.logoURL, app.footerText
- Update README.md: cara pakai struktur baru
- Buat docs/refactor/summary.md

## OUTPUT AKHIR
Lapor: total commit, file yang dibuat/diubah, file di-skip, status test, rekomendasi next step.
STOP. Tunggu instruksi push.
