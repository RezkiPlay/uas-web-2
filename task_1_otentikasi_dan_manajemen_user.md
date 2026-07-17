# Task 1: Otentikasi dan Manajemen User (MVP)

**Deskripsi:**
Menyesuaikan sistem autentikasi dan manajemen pengguna (user management) yang sudah ada di template agar selaras dengan PRD.

**Spesifikasi:**
- **Tabel Users:** Ubah atau tambahkan kolom ole pada tabel users bawaan template dengan 3 nilai enum: dmin, hr, dan pelamar (hapus atau sesuaikan dari sistem role lama).
- **Seeder:** Perbarui UserSeeder atau sejenisnya untuk menyediakan minimal 1 akun dummy untuk masing-masing role (Admin, HR, Pelamar) lengkap dengan email & password yang jelas untuk keperluan testing/demo.
- **Modul User (CRUD):** Sesuaikan logika Create, Read, Update, Delete (CRUD) pada modul user yang sudah ada agar mengenali dan memproses 3 role baru ini. Pastikan untuk menggunakan middleware/akses otorisasi per role jika sudah ada polanya di template.
- **Registrasi (Self-Registration):** HANYA berlaku untuk role pelamar. Akun Admin dan HR tidak bisa mendaftar sendiri dan hanya dapat dibuat oleh Admin melalui fitur manajemen user.
- **Standar & Konvensi:** Wajib mengikuti standar coding style, pola arsitektur, dan konvensi penamaan yang sudah ada (existing) pada modul user saat ini. Dilarang membuat pola baru yang tidak konsisten dengan template.
