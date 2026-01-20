# Web Pengaduan Masyarakat (Laravel)

Aplikasi web untuk pengaduan masyarakat dengan dua role:
- **Masyarakat**: membuat laporan + melihat status + melihat tanggapan
- **Admin**: memproses laporan (ubah status, kirim tanggapan) + export CSV

## Fitur Utama
- Login & role (admin/masyarakat)
- CRUD laporan (masyarakat: buat & lihat detail)
- Admin dapat memberi tanggapan dan mengubah status
- Status **tidak bisa mundur** (Menunggu → Diproses → Selesai)
- Ringkasan laporan di dashboard (total, menunggu, proses/selesai)
- Upload foto laporan (akses via `storage:link`)
- Export CSV laporan (admin)

## Akun Default (Seeder)
- **Admin**
  - Email: `admin@pengaduan.test`
  - Password: `password`

## Dokumen Tugas
File makalah dan PPT ada di folder:
- `docs/Makalah.pdf`
- `docs/Presentasi.pptx`
