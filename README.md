# Sistem Manajemen Rekrutmen

Aplikasi PHP untuk mengelola kandidat karyawan dan interviewer menggunakan arsitektur **Model–View–Presenter (MVP)** dengan prinsip **Strict Passive View**.

## Desain Program

```text
Browser
   |
   v
project/index.php          Front controller: memilih modul dan aksi
   |
   v
Presenter                  Mengatur alur aplikasi dan menyiapkan data tampilan
   |                                  |
   v                                  v
Kontrak Model -> Model/Entity   Kontrak View -> View -> Template HTML
   |                                  |
   v                                  v
PDO / MySQL                         Browser
```

### Tanggung Jawab Komponen

- **Model** (`project/models/`) menangani akses database melalui PDO dan prepared statement, serta memetakan baris database ke entity `Kandidat` atau `Interviewer`.
- **Presenter** (`project/presenters/`) meminta data melalui kontrak Model, menyiapkan data/HTML daftar dan form, lalu memanggil View melalui kontraknya.
- **View** (`project/views/`) hanya mengisi template HTML dengan data yang diterima. View tidak mengakses Model atau entity, dan tidak melakukan iterasi atau penghitungan data.
- **Front controller** (`project/index.php`) memilih modul berdasarkan request, membuat Model/View/Presenter, dan meneruskan aksi CRUD.
- **Template** (`project/template/`) berisi markup untuk daftar dan form setiap modul.

Komunikasi Presenter dengan Model dan View menggunakan interface. Kontrak Kandidat menggunakan `KontrakModel`, `KontrakView`, dan `KontrakPresenter`; modul Interviewer menggunakan kontrak khusus dengan akhiran `Interviewer`.

### Struktur File Utama

```text
project/
├── index.php
├── models/
│   ├── DB.php
│   ├── Kandidat.php
│   ├── Interviewer.php
│   ├── KontrakModel.php
│   ├── KontrakInterviewerModel.php
│   ├── TabelKandidat.php
│   └── TabelInterviewer.php
├── presenters/
│   ├── KontrakPresenter.php
│   ├── KontrakInterviewerPresenter.php
│   ├── PresenterKandidat.php
│   └── PresenterInterviewer.php
├── views/
│   ├── KontrakView.php
│   ├── KontrakInterviewerView.php
│   ├── ViewKandidat.php
│   └── ViewInterviewer.php
└── template/
    ├── skin.html
    ├── form.html
    ├── interviewer_skin.html
    └── interviewer_form.html

mvp_db.sql
documentation/
```

## Alur Program

### Menampilkan halaman

1. Browser mengirim request ke `project/index.php`.
2. Front controller memilih modul. Tanpa parameter `module`, aplikasi membuka daftar Kandidat; `module=interviewer` membuka daftar Interviewer.
3. Presenter meminta data kepada Model melalui interface Model.
4. Presenter menyiapkan baris tabel atau data form, lalu meminta View merendernya.
5. View mengisi placeholder pada template dan mengembalikan HTML ke browser.

### Proses CRUD

- **Create:** tombol tambah membuka form kosong. Form mengirim POST dengan `action=tambah`; Presenter meneruskan data ke method tambah Model.
- **Read:** halaman daftar mengambil seluruh data melalui Model dan menampilkan tabel.
- **Update:** tombol Edit membuka form dengan data yang sudah diisi. Form mengirim POST dengan `action=ubah` dan ID data.
- **Delete:** tombol Hapus mengirim POST dengan `action=hapus` dan ID data.
- Setelah perubahan berhasil, Presenter mengarahkan pengguna kembali ke daftar modul terkait.

Untuk modul Interviewer, form mengirim `module=interviewer` agar front controller meneruskan request ke Presenter dan Model Interviewer.

## Database

Database bernama `mvp_kandidat_db` dan didefinisikan di [mvp_db.sql](./mvp_db.sql).

- `kandidat`: nama, posisi, domisili, skor tes, dan pengalaman kerja.
- `interviewer`: nama, jabatan, departemen, dan email.

## Menjalankan Aplikasi

1. Jalankan Apache dan MySQL melalui XAMPP/Laragon.
2. Import `mvp_db.sql` melalui phpMyAdmin atau MySQL.
3. Pastikan konfigurasi koneksi di `project/models/DB.php` sesuai dengan lingkungan lokal.
4. Letakkan folder proyek di `htdocs/` atau `www/`, lalu buka URL folder `project/` melalui browser, misalnya `http://localhost/TP9DPBO2526C2/project/`.

## Dokumentasi Screen Record

Rekaman demonstrasi akan disimpan di folder [documentation/](./documentation/). Tambahkan file rekaman setelah tersedia, misalnya `documentation/screenrecord.mp4`.

Disarankan rekaman memperlihatkan daftar Kandidat dan Interviewer, proses tambah, edit dengan form terisi, serta hapus data pada kedua modul.
