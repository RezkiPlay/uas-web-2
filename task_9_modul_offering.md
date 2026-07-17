# Task 9: Modul Penerbitan Offer Letter (Nice to Have)

**Deskripsi:**
Mengakomodasi pembuatan, pengiriman, dan respon terhadap surat penawaran kerja.

**Spesifikasi:**
- Buat migration dan model untuk tabel offer_letters.
- Tabel offer_letters: id, application_id, salary_offered, join_date, status (enum: pending, accepted, declined), file_path, timestamps.
- HR menerbitkan offer letter untuk kandidat yang lolos (status offered).
- Pelamar dapat melihat dan merespon dengan menekan tombol Terima (ccepted) atau Tolak (declined).
- Jika diterima, HR dapat menutup lowongan.
- Sediakan data dummy (Seeder).
