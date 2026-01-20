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
- Waktu ditampilkan menggunakan timezone **Asia/Jakarta**
- Export CSV laporan (admin)

## Akun Default (Seeder)
- **Admin**
  - Email: `admin@pengaduan.test`
  - Password: `password`

> Jika ingin membuat akun masyarakat, gunakan halaman register (jika tersedia) atau buat manual di database.

## Dokumen Tugas
Simpan file makalah dan PPT di folder:
- `docs/Makalah.pdf` (atau `.docx`)
- `docs/Presentasi.pptx`
