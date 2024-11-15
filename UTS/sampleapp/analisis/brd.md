# Business Requirement Document (BRD) - Aplikasi Beasiswa

## 1. Pendahuluan
Aplikasi ini bertujuan untuk mengelola data penerima beasiswa, termasuk informasi pribadi penerima dan jumlah nominal beasiswa yang diterima. Analisis ini didasarkan pada kode program yang telah dibuat.

---

## 2. Tujuan Sistem
- Mempermudah pencatatan data penerima beasiswa dalam sebuah sistem berbasis web.
- Memastikan transparansi dan efisiensi dalam pengelolaan data penerima beasiswa.

---

## 3. Fitur Utama

### Fitur yang Diimplementasikan
1. **Manajemen Penerima Beasiswa**
   - Pendaftaran data penerima beasiswa (nama, NIM, dan nominal uang diterima).
   - Penyimpanan data ke dalam database dengan tabel bernama `beasiswas`.

### Fitur yang Belum Diimplementasikan
1. **CRUD (Create, Read, Update, Delete)**
   - Sistem perlu menyediakan antarmuka untuk menambahkan, mengedit, melihat, dan menghapus data penerima beasiswa.
2. **Laporan Beasiswa**
   - Kemampuan untuk menghasilkan laporan data penerima beasiswa, baik dalam bentuk file (PDF/Excel) atau visualisasi statistik.
3. **Autentikasi dan Otorisasi**
   - Fitur login untuk admin yang mengelola data.

---

## 4. Data yang Dikelola

### Entity: Penerima Beasiswa
- **Nama Field:**
  - `id`: Identifikasi unik untuk setiap penerima.
  - `nama`: Nama penerima beasiswa.
  - `nim`: Nomor Induk Mahasiswa penerima.
  - `nominal uang di terima`: Jumlah uang yang diterima penerima.
  - `created_at` dan `updated_at`: Waktu pencatatan dan pembaruan data.

**Catatan:**  
Penulisan field `nominal uang di terima` tidak konsisten. Disarankan mengganti menjadi `nominal_uang_diterima` untuk mengikuti standar penamaan `snake_case` pada database.

---

## 5. Kebutuhan Fungsional
1. **Database Management:**
   - Sistem migrasi database telah dibuat (`2024_11_15_213511_create_beasiswas_table.php`) untuk mengelola tabel `beasiswas`.

2. **Seeder Data:**
   - Seeder telah disiapkan (`BeasiswaSeeder.php`) untuk memasukkan data awal ke dalam tabel.

3. **Model:**
   - Model `Beasiswa.php` mendukung pengelolaan data dengan metode ORM Laravel.

4. **Form Input:**
   - Tidak ada kode terkait form input atau validasi data. Validasi (seperti memastikan format NIM atau angka untuk nominal uang) harus ditambahkan di sisi frontend dan backend.

---

## 6. Kebutuhan Non-Fungsional
- **Kinerja:**
  - Sistem harus dapat menangani penyimpanan data dalam jumlah besar tanpa menurunkan kinerja.
- **Keamanan:**
  - Data harus dilindungi dari akses yang tidak sah, terutama informasi pribadi dan nominal beasiswa.
- **Kompatibilitas:**
  - Sistem dirancang untuk bekerja pada framework Laravel, sehingga perlu server yang kompatibel (PHP >= 8.1, database MySQL/PostgreSQL).

---

## 7. Risiko dan Tantangan
1. **Inkonistensi Penulisan Field:**
   - Penamaan yang tidak konsisten antara kode seeder, model, dan migrasi dapat menyebabkan error.
2. **Validasi Data:**
   - Tidak ada validasi data pada level aplikasi atau database.
3. **Keterbatasan Fitur:**
   - Saat ini hanya mampu menambahkan data secara manual melalui seeder.

---

## 8. Rekomendasi Pengembangan
1. **Perbaikan Penamaan Field:**
   - Ganti semua field dengan format konsisten, seperti `nominal_uang_diterima`.
2. **Tambahkan Validasi Data:**
   - Validasi untuk nama (karakter alfanumerik), NIM (panjang angka), dan nominal uang (angka).
3. **Implementasikan CRUD:**
   - Bangun antarmuka pengguna untuk menambah, mengedit, melihat, dan menghapus data.
4. **Fitur Tambahan:**
   - Laporan penerima beasiswa dalam format PDF/Excel.
   - Filter dan pencarian data berdasarkan nama, NIM, atau rentang nominal beasiswa.
5. **Keamanan:**
   - Tambahkan middleware autentikasi untuk mengamankan akses sistem.

---

## 9. Kesimpulan
Aplikasi ini memiliki dasar yang baik untuk mengelola data penerima beasiswa, namun memerlukan pengembangan lebih lanjut untuk memenuhi kebutuhan bisnis secara keseluruhan. Fokus utama adalah memperbaiki struktur data, menambah fitur CRUD, dan meningkatkan keamanan sistem.
