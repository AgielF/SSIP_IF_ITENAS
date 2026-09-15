---
always_on: true
---

# REFACTOR VIEWS RULE — SSIP_IF_ITENAS

## Scope BOLEH edit
- app/Views/**
- public/assets/css/**
- public/assets/js/**
- app/Cells/**
- app/Views/components/**
- app/Config/TemplateMenu.php (baru)

## DILARANG tanpa persetujuan eksplisit
- Edit app/Controllers/**, app/Models/**, app/Config/** (kecuali TemplateMenu.php)
- Edit migrations/seeds
- git push (user push manual setelah review)
- git reset --hard atau operasi destruktif
- Edit .env, composer.json, composer.lock

## WAJIB
- Commit per fase pakai Conventional Commits
- Test di browser setiap akhir fase
- Zero behavior change — fitur harus sama persis
- Kalau error tidak bisa fix dalam 2x percobaan → STOP, revert, lapor
- Setiap akhir fase → STOP, lapor, tunggu instruksi user

## URUTAN FASE (tidak boleh lompat)
FASE 1 — Setup & baseline screenshot
FASE 2 — Design tokens (tokens.css)
FASE 3 — CUBE CSS structure (base, composition, blocks, exceptions)
FASE 4 — JS modules ES Modules (app.js, core/, modules/)
FASE 5 — View components + Cells (components/, Cells/, TemplateMenu.php)
FASE 6 — Pilot migration: berita_list_admin.php saja → tunggu APPROVAL
FASE 7 — Batch migration 44 file lain (1 file = 1 commit)
FASE 8 — Cleanup + README
