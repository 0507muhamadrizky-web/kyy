# Informasi Aplikasi - Distanbun V2

## Deskripsi Singkat
**Distanbun V2** adalah Sistem Informasi Inventaris Barang yang dirancang untuk mengelola stok barang secara efisien. Aplikasi ini mendukung alur kerja lengkap mulai dari pencatatan barang masuk, barang keluar, hingga sistem peminjaman dan pengembalian barang oleh pengguna dengan sistem verifikasi admin.

## Fitur Utama
1. **Dashboard Interaktif**: Statistik stok barang, peminjaman aktif, dan grafik monitoring.
2. **Manajemen Stok**: Pencatatan data barang masuk dan keluar secara mendetail.
3. **Sistem Peminjaman**:
   - User dapat mengajukan peminjaman barang.
   - Admin melakukan verifikasi (Setujui/Tolak).
   - Stok berkurang otomatis jika disetujui.
4. **Sistem Pengembalian**: Pencatatan barang yang telah selesai dipinjam.
5. **Laporan & Eksport**: Fitur ekspor data riwayat ke format Excel dan PDF.
6. **Notifikasi Bot Telegram**: Integrasi untuk pemberitahuan aktivitas sistem melalui Telegram.

## Struktur Folders View (Baru)
Aplikasi telah diorganisir untuk memisahkan antarmuka berdasarkan peran pengguna:
- `resources/views/admin/`: Folder berisi halaman-halaman khusus untuk administrator (Dashboard Admin, Kelola Barang, Verifikasi).
- `resources/views/user/`: Folder berisi halaman-halaman untuk pengguna umum (Landing Page, Dashboard User, Form Peminjaman).
- `resources/views/layouts/`: Template dasar aplikasi.

## Teknologi yang Digunakan
- **Framework**: Laravel (PHP)
- **Frontend**: Tailwind CSS & Alpine.js
- **Build Tool**: Vite
- **Database**: MySQL (Terintegrasi via Laragon)
- **Status Database**:
  - Database `distanbun_v2` telah dibuat.
  - Migrasi tabel berhasil dijalankan.
  - Data awal (Seeding) telah dimasukkan.

## Akun Demo (Default)
- **Admin**: `admindistanbun@gmail.com` / `admin123`
- **User**: `userdistanbun@gmail.com` / `user123`

## Kontak & Pengembangan
Aplikasi ini dikembangkan untuk kebutuhan internal Distanbun dengan fokus pada kemudahan penggunaan dan akurasi data inventaris.
