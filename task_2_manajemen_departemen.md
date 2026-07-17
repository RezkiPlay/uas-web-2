# Task 2: Manajemen Departemen (MVP)

**Deskripsi:**
Membuat fitur CRUD (Create, Read, Update, Delete) untuk data master departemen yang akan dikelola oleh Admin.

**Spesifikasi:**
- Buat migration, model, dan controller untuk tabel departments.
- Tabel departments memiliki atribut: id, name, description, timestamps.
- Implementasikan antarmuka (UI) untuk mengelola departemen menggunakan style template yang sudah ada.
- Tambahkan validasi pada form input (misal: nama departemen wajib diisi).
- Buat DepartmentSeeder dengan data dummy beberapa departemen perusahaan.
- Akses ke fitur ini dibatasi hanya untuk user dengan role dmin.
