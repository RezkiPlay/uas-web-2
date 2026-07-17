# Task 4: Registrasi Pelamar dan Apply Lowongan (MVP)

**Deskripsi:**
Membangun fitur manajemen profil pelamar dan proses melamar kerja.

**Spesifikasi:**
- Buat migration, model, dan controller untuk tabel pplicants, pplication_documents, dan pplications.
- Tabel pplicants: id, user_id, phone, address, summary, timestamps. (Relasi one-to-one ke users).
- Tabel pplication_documents: id, applicant_id, document_type, file_path, timestamps.
- Tabel pplications: id, job_posting_id, applicant_id, status (enum: applied, interview, assessment, offered, rejected), applied_at, timestamps.
- **Fitur Pelamar:**
  - Melengkapi profil di halaman dashboard/profil kandidat (pplicants).
  - Mengunggah dokumen/CV (pplication_documents).
  - Mengajukan lamaran ke lowongan yang pproved (pplications otomatis dibuat dengan status pplied).
- Buat seeder dengan data dummy pelamar (relasi ke user pelamar), lengkap dengan profil, dokumen dummmy, dan beberapa riwayat lamaran.
