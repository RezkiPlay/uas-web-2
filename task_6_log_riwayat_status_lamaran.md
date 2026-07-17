# Task 6: Log Riwayat Status Lamaran (MVP)

**Deskripsi:**
Mencatat dan menampilkan histori setiap kali ada perubahan status pada lamaran.

**Spesifikasi:**
- Buat migration dan model untuk tabel pplication_status_logs.
- Tabel pplication_status_logs: id, application_id, previous_status, new_status, changed_by, created_at, updated_at.
- Tiap kali HR mengubah status pplications, sebuah record log harus dimasukkan ke tabel ini.
- Tampilkan log riwayat ini pada detail lamaran di dashboard HR, Admin, dan Pelamar.
- Sediakan seeder untuk dummy log histori.
