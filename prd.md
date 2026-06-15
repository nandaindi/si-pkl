# Product Requirements Document (PRD) - Sistem Informasi PKL

## 1. Pendahuluan
Sistem Informasi Praktik Kerja Lapangan (PKL) adalah aplikasi berbasis web yang dirancang untuk mengelola, memonitor, dan mendokumentasikan seluruh proses PKL siswa. Sistem ini memfasilitasi interaksi antara Siswa, Guru Pembimbing, Guru Penguji, dan Administrator.

## 2. Aktor / Pengguna Sistem
Berdasarkan diagram Use Case, sistem ini memiliki 4 aktor utama:
1. **Admin**: Bertanggung jawab mengelola data master (pengguna dan data tempat PKL).
2. **Guru Pembimbing**: Bertanggung jawab membimbing siswa, memverifikasi pengajuan, memonitor laporan, mengelola jadwal sidang, merekap nilai, dan mengelola sertifikat.
3. **Siswa**: Pengguna utama yang melaksanakan PKL, mulai dari pengajuan, pelaporan harian, hingga mengunduh sertifikat.
4. **Guru Penguji**: Bertanggung jawab menguji siswa saat sidang, dan memiliki akses untuk melihat jadwal sidang.

---

## 3. Kebutuhan Fungsional (Berdasarkan Use Case)

### 3.1. Autentikasi (Global)
- **Login**: Semua aktor (Admin, Guru Pembimbing, Guru Penguji, Siswa) wajib melakukan autentikasi / login sebelum dapat mengakses fitur sistem sesuai perannya masing-masing.

### 3.2. Modul Admin
Admin memiliki kewenangan penuh terhadap data master sistem:
- **Kelola Data Guru Pembimbing**: Menambah, mengedit, melihat, dan menghapus data Guru Pembimbing.
- **Kelola Data Guru Penguji**: Menambah, mengedit, melihat, dan menghapus data Guru Penguji.
- **Kelola Data Siswa**: Menambah, mengedit, melihat, dan menghapus data Siswa.
- **Kelola Data PKL**: Menambah, mengedit, melihat, dan menghapus daftar tempat/instansi pelaksaan PKL.

### 3.3. Modul Guru Pembimbing
Guru Pembimbing mengelola aktivitas akademis dan administratif untuk siswa bimbingannya:
- **Verifikasi Pengajuan PKL**: Menyetujui atau menolak pengajuan tempat PKL yang dikirimkan oleh siswa.
- **Membuat Surat Pengantar PKL**: Membuat atau meng-generate surat pengantar resmi bagi siswa yang pengajuannya telah diverifikasi.
- **Monitoring Laporan PKL**: Membaca dan memonitor laporan harian serta laporan akhir yang dikumpulkan oleh siswa.
- **Kelola Jadwal Sidang**: Menentukan jadwal sidang PKL (waktu, tempat, penguji, dan peserta sidang).
- **Rekap Nilai PKL**: Menginput dan merekapitulasi nilai akhir PKL siswa berdasarkan laporan dan hasil sidang.
- **Kelola Sertifikat PKL**: Memproses, membuat, dan mengelola sertifikat kelulusan PKL untuk siswa.

### 3.4. Modul Siswa
Siswa melakukan interaksi administratif terkait pelaksanaan PKL-nya:
- **Mengajukan PKL**: Menginput data pengajuan tempat/instansi untuk pelaksanaan PKL.
- **Unduh Surat Pengantar PKL**: Mengunduh surat pengantar resmi yang telah dibuat oleh Guru Pembimbing.
- **Mengisi Laporan Harian PKL**: Mengisi logbook atau catatan kegiatan harian selama melaksanakan PKL.
- **Mengumpulkan Laporan Akhir PKL**: Mengunggah dokumen laporan akhir PKL.
- **Lihat Jadwal Sidang**: Melihat informasi mengenai jadwal, tempat, dan penguji untuk sidang PKL.
- **Unduh Sertifikat PKL**: Mengunduh sertifikat kelulusan setelah PKL, sidang, dan penilaian selesai direkap.

### 3.5. Modul Guru Penguji
- **Lihat Jadwal Sidang**: Melihat daftar jadwal sidang di mana guru penguji tersebut ditugaskan (informasi siswa, waktu, dan tempat).

---

## 4. Kebutuhan Non-Fungsional

1. **UI/UX (Premium & Anti-Slop)**: 
   - Antarmuka harus estetis, modern, bersih (clean), dan intuitif. 
   - Menghindari desain yang terkesan kaku/generik, dan mengutamakan _Micro-animations_, pewarnaan yang harmonis, serta _spacing_ yang proporsional.
2. **Keamanan (Security)**: 
   - Pembatasan hak akses yang ketat menggunakan _Role-based Access Control_ (RBAC). 
   - Enkripsi kata sandi dan proteksi jalur data (CSRF, XSS Protection).
3. **Kinerja (Performance)**: 
   - Sistem mampu memuat halaman dengan cepat dan meng-generate dokumen (PDF Surat Pengantar & Sertifikat) secara efisien tanpa membebani server secara signifikan.

## 5. Teknologi yang Digunakan
- **Backend**: Laravel (PHP)
- **Frontend**: Blade Templating, Tailwind CSS (Disesuaikan dengan kaidah desain Premium)
- **Database**: MySQL / PostgreSQL
- **Dokumen Generator**: Library PDF (misal: DomPDF / barryvdh/laravel-dompdf)
