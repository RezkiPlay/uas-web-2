# Task 3: Manajemen Lowongan Pekerjaan (MVP)

**Deskripsi:**
Membangun alur manajemen lowongan pekerjaan dari HR (membuat draft) hingga Admin (approval).

**Spesifikasi:**
- Buat migration, model, dan controller untuk tabel job_postings.
- Tabel job_postings: id, department_id, created_by, title, description, status (enum: draft, pending, approved, rejected, closed), timestamps.
- **Fitur HR:** Dapat membuat draft lowongan (status draft), mengeditnya, dan mengirimkan untuk approval (status menjadi pending). HR juga dapat menutup lowongan (status closed).
- **Fitur Admin:** Dapat melihat daftar lowongan pending, lalu melakukan review untuk menyetujui (ubah ke pproved) atau menolak (ubah ke ejected).
- **Tampilan Publik:** Halaman eksplorasi lowongan hanya menampilkan lowongan dengan status pproved.
- Buat JobPostingSeeder berisi beberapa data lowongan dummy dengan berbagai status.
