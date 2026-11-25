# Starter Template MVP Strict Passive View — Daftar Kandidat Karyawan

Starter template praktikum DPBO menggunakan pola **Model-View-Presenter (MVP)** edisi **Strict Passive View (*Dumb View*)**.

## Setup Awal
1. Import `mvp_db.sql` ke MySQL / phpMyAdmin (membuat database `mvp_kandidat_db`).
2. Pastikan folder berada di `htdocs/` (XAMPP) atau `www/` (Laragon).

## Fitur
- CRUD data kandidat karyawan.
- CRUD interviewer, termasuk form tambah/edit dan daftar data.
- Pemisahan Model, View, dan Presenter menggunakan kontrak interface.

## Modul Interviewer
Modul Interviewer menyediakan fitur tambah, daftar, edit, dan hapus data interviewer. Untuk database yang sudah dibuat, jalankan perintah `CREATE TABLE interviewer` dari `mvp_db.sql` sebelum menggunakan modul. Akses melalui tombol **Kelola Interviewer** pada daftar kandidat.

