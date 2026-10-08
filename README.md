# REPOSITORI DOKUMEN TUGAS AKHIR & KERJA PRAKTIK MAHASISWA D3 TI UKSW

Sistem Repository KP & TA merupakan aplikasi berbasis web yang digunakan untuk membantu proses pengelolaan, pengumpulan, dan pemantauan dokumen Kerja Praktik (KP) dan Tugas Akhir (TA) mahasiswa.

---

## Project Overview

Project ini dikembangkan untuk meningkatkan efisiensi dalam proses pengumpulan dan pengelolaan dokumen Tugas Akhir (TA) dan Kerja Praktik (KP). Sistem menyediakan berbagai fitur yang membantu mahasiswa dan dosen D3 Teknik Informatika UKSW dalam mengelola dokumen akademik secara lebih terstruktur dan efisien.

### Tujuan

* Mempermudah mahasiswa D3 Teknik Informatika UKSW dalam mengumpulkan dokumen Tugas Akhir (TA) dan Kerja Praktik (KP).
* Membantu dosen dalam mengelola dan memantau dokumen Tugas Akhir (TA) dan Kerja Praktik (KP) mahasiswa. 
* Mempermudah proses pengecekan dokumen serta pemantauan status pengumpulan dokumen.

---

## Features

* Authentication & Login
* Pengumpulan dokumen
* Status revisi
* Notifikasi
* History / riwayat submission
* Pengelolaan Dokumen
* Approval dokumen
* Automatic Semester Detection
* Pengelolaan pengguna

---

## Tech Stack

### Backend

* PHP
* Laravel 

### Frontend

* HTML
* CSS
* Bootstrap
* JavaScript

### Database

* MySQL

### Tools

* Visual Studio Code
* XAMPP
* phpMyAdmin
* Git & GitHub

---

## Screenshots


### Guest - Landing Page

![Landing Page](docs/screenshots/Guest/tampilan_awal_guest.png)
Halaman ini merupakan tampilan awal website yang menyediakan akses untuk login ke sistem dan melihat dokumen abstrak yang sudah disetujui.

### Guest - Daftar File Abstrak KP dan TA
![Daftar File Abstrak](docs/screenshots/Guest/daftar_kp_ta_guest.png)
Halaman ini merupakan halaman lanjutan dari Landing Page yang menampilkan daftar file abstrak Tugas Akhir (TA) dan Kerja Praktik (KP) mahasiswa yang sudah disetujui.

### Guest - Login
![Login](docs/screenshots/Guest/login.png)
Halaman ini digunakan untuk masuk ke dalam sistem sebagai User (mahasiswa) atau Admin (dosen) sesuai dengan hak akses masing-masing.

### User - Homepage
![Homepage User](docs/screenshots/User/home.png)
Halaman ini merupakan tampilan awal setelah User (mahasiswa) berhasil login. Pada halaman ini, User dapat memilih jenis dokumen yang akan dikumpulkan, yaitu Kerja Praktik (KP) atau Tugas Akhir (TA).

### User - Form Pengumpulan Dokumen
![Form Pengumpulan Dokumen](docs/screenshots/User/form_pengumpulan.png)
Halaman ini digunakan oleh User (mahasiswa) untuk mengisi data terkait dokumen yang akan dikumpulkan. Formulir pengumpulan dokumen Tugas Akhir (TA) dan Kerja Praktik (KP) memiliki struktur yang serupa.

### User - History Dokumen
Halaman untuk melihat aktivitas User maupun Admin terkait dokumen yang sudah dikumpulkan. Terdapat 3 status yaitu Terkumpul, Revisi, dan Disetujui untuk menginformasikan ke user tentang progres dari dokumen yang sudah dikumpulkan

### User - History Dokumen Status Terkumpul
![History Dokumen Terkumpul](docs/screenshots/User/history_kumpul.png)

### User - History Dokumen Status Revisi
![History Dokumen Revisi](docs/screenshots/User/history_revisi.png)

### User - History Dokumen Status Disetujui
![History Dokumen Disetujui](docs/screenshots/User/history_disetujui.png)

### User - Form Revisi Dokumen
![Form Revisi Dokumen](docs/screenshots/User//form_revisi.png)
Halaman ini digunakan untuk mengirimkan kembali dokumen atau mengubah data jika terdapat revisi

### User - Dropdown Notification
![Dropdown Notificatiom](docs/screenshots/User/dropdown_notif_logout.png)
Tampilan ketika admin sudah mengubah status atau memberikan catatan untuk dokumen yang sudah dikumpulkan mahasiswa

### User - Notification
![Notification](docs/screenshots/User/notif.png)
Halaman ini digunakan untuk melihat daftar notifikasi yang diterima User

### Admin - Dashboard
![Dashboard](docs/screenshots/Admin/branda_admin.png)
Menampilkan jumlah dan statistik dokumen yang telah dikumpulkan mahasiswa untuk membantu admin memantau proses pengumpulan dokumen

### Admin - Detail Mahasiswa Semester Ini
![Mahasiswa Semester Ini](docs/screenshots/Admin/detail_mahasiswa_semesterini.png)
Menampilkan daftar mahasiswa yang sudah mengumpulkan dokumen pada semester berjalan sekarang

### Admin - Detail Mahasiswa Semua Semester
![Mahasiswa Semua Semester](docs/screenshots/Admin/detail_mahasiswa_semua.png)
Menampilkan daftar mahasiswa yang telah mengumpulkan dokumen tanpa dibatasi oleh periode atau semester tertentu

### Admin - Daftar Data Dokumen Mahasiswa
![Data Dokumen Mahasiswa](docs/screenshots/Admin/data_dokumen_mahasiswa.png)
Menampilkan daftar data dokumen mahasiswa yang sudah dikumpulkan disertai search untuk memudahkan dalam mencari dokumen

### Admin - Detail Dokumen Mahasiswa
![Detail Dokumen Mahasiswa](docs/screenshots/Admin/detail_data_dokumen.png)
Menampilkan detail dari dokumen mahasiswa. Disini Admin bisa mengubah status dan menambahkan catatan pada dokumen

### Admin - Kelola User
![Kelola User](docs/screenshots/Admin/kelola_user.png)
Halaman ini digunakan untuk mengelola data User. Admin bisa mencari, mengedit, dan menghapus User 

---

## Database

Project ini menggunakan **MySQL** sebagai database.

### Entity Relationship Diagram

![ERD](docs/erd.png)

### Database Structure

Beberapa tabel utama yang digunakan antara lain:

| Table            | Description                                                         |
| ---------------- | ------------------------------------------------------------------- |
| `users`          | Menyimpan data pengguna                                             |
| `kerja_pratik`   | Menyimpan data pengumpulan dokumen kerja praktik                    |
| `tugas_akhir`    | Menyimpan data pengumpulan dokumen tugas akhir                      |
| `notification`   | Mengelola notifikasi terkait aktivitas dan perubahan status dokumen |
| `submission_log` | Mencatat riwayat aktivitas pengumpulan dokumen KP/TA                |

---

## Testing

Pengujian sistem dilakukan menggunakan metode **Black Box Testing** untuk memastikan fitur-fitur yang tersedia berjalan sesuai dengan kebutuhan sistem.

### Black Box Testing – Guest

| No. | Fitur yang Diuji       | Hasil Pengujian                                                  | Status   |
| --- | ---------------------- | ---------------------------------------------------------------- | -------- |
| 1   | List data file abstrak | Data abstrak berhasil ditampilkan                                | Berhasil |
| 2   | Unduh file abstrak     | File abstrak berhasil diunduh                                    | Berhasil |
| 3   | Login                  | User berhasil masuk sesuai hak akses                             | Berhasil |
| 4   | Validasi login         | Sistem menampilkan peringatan ketika email/password tidak sesuai | Berhasil |
| 5   | Registrasi             | Data pengguna berhasil disimpan                                  | Berhasil |
| 6   | Validasi registrasi    | Sistem memberikan peringatan ketika form tidak lengkap           | Berhasil |
| 7   | Lupa password          | Link reset password berhasil dikirim ke email                    | Berhasil |

### Black Box Testing – User (Mahasiswa)

| No. | Fitur yang Diuji          | Hasil Pengujian                                            | Status   |
| --- | ------------------------- | ---------------------------------------------------------- | -------- |
| 1   | Pengumpulan dokumen TA/KP | Form pengumpulan berhasil ditampilkan                      | Berhasil |
| 2   | Submit dokumen TA/KP      | Data pengumpulan berhasil disimpan                         | Berhasil |
| 3   | Validasi form pengumpulan | Form tidak dapat disubmit jika belum lengkap               | Berhasil |
| 4   | Validasi ukuran file      | Sistem menolak file yang melebihi batas ukuran             | Berhasil |
| 5   | History TA/KP             | Halaman history berhasil ditampilkan                       | Berhasil |
| 6   | Melihat aktivitas dokumen | Data dokumen dan riwayat aktivitas berhasil ditampilkan    | Berhasil |
| 7   | Edit dokumen              | Dokumen dengan status "Terkumpul" dapat diedit             | Berhasil |
| 8   | Hapus dokumen             | Dokumen dengan status "Terkumpul" dapat dihapus            | Berhasil |
| 9   | Revisi dokumen            | Halaman revisi berhasil ditampilkan ketika status "Revisi" | Berhasil |
| 10  | Notifikasi                | Halaman notifikasi berhasil ditampilkan                    | Berhasil |
| 11  | Detail notifikasi         | Notifikasi mengarahkan user ke history TA/KP terkait       | Berhasil |

### Black Box Testing – Admin

| No. | Fitur yang Diuji         | Hasil Pengujian                                                     | Status   |
| --- | ------------------------ | ------------------------------------------------------------------- | -------- |
| 1   | Dashboard                | Jumlah dokumen TA/KP berhasil ditampilkan                           | Berhasil |
| 2   | Daftar mahasiswa         | Data mahasiswa yang telah mengumpulkan dokumen berhasil ditampilkan | Berhasil |
| 3   | Filter "Semester Ini"    | Data mahasiswa sesuai periode semester berhasil ditampilkan         | Berhasil |
| 4   | Data TA/KP               | Daftar dokumen TA/KP berhasil ditampilkan                           | Berhasil |
| 5   | Hapus dokumen TA/KP      | Dokumen berhasil dihapus                                            | Berhasil |
| 6   | Unduh dokumen TA/KP      | Dokumen berhasil diunduh                                            | Berhasil |
| 7   | Review dokumen           | Halaman review dokumen berhasil ditampilkan                         | Berhasil |
| 8   | Perubahan status dokumen | Status dokumen berhasil diperbarui                                  | Berhasil |
| 9   | Kelola user              | Daftar user yang telah terdaftar berhasil ditampilkan               | Berhasil |
| 10  | Edit user                | Data user berhasil diperbarui                                       | Berhasil |
| 11  | Hapus user               | User berhasil dihapus                                               | Berhasil |

---

## My Contribution

Dalam project ini saya berkontribusi dalam:

* Merancang database
* Mengembangkan backend menggunakan Laravel
* Mengembangkan frontend
* Membuat authentication
* Mengembangkan fitur pengumpulan dokumen
* Mengembangkan fitur Automatic Semester Detection
* Mengembangkan fitur approval/revisi
* Melakukan testing

---

## What I Learned

Melalui project ini, saya mempelajari dan menerapkan:

* Pengembangan aplikasi web menggunakan Laravel
* Konsep MVC
* Perancangan dan pengelolaan database relasional
* Authentication dan authorization
* Pengelolaan file/dokumen
* Database migration
* Git dan GitHub
* Software testing menggunakan Black Box Testing

---

## Installation
1. Clone Repositoriy
- git clone https://github.com/Hendro08/repositori_kp_ta.git 
- cd repositori_kp_ta

2. Install dependency Laravel
- composer install

3. Copy .env.example menjadi .env
- cp .env.example .env

4. Buat database baru melalui phpMyAdmin

5. Atur konfigurasi database pada file .env
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=

6. Generate application key:
- php artisan key:generate

7. Jalankan migration dan seeder:
- php artisan migrate --seed

8. Jalankan aplikasi:
- php artisan serve

9. Buka aplikasi melalui:
- http://127.0.0.1:8000

---

## Project Status

**Completed**

Project ini telah selesai dikembangkan dan digunakan sebagai bagian dari portfolio.
