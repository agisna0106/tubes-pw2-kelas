# Anggota 4 — Transaction & Report (Tubes PW2)

Dokumen ini merangkum pekerjaan yang sudah diselesaikan untuk bagian **Anggota 4 (Transaction & Report)**, sesuai pembagian tugas dari Ketua.

## 1. Yang Sudah Dikerjakan

- [x] Migration `sales` & `sale_details`
- [x] Model `Sale` & `SaleDetail` + relasi (`branch`, `cashier`, `details`, `product`)
- [x] Fitur Transaksi Penjualan (`SaleController`) — kasir input produk & qty, sistem hitung subtotal & total otomatis
- [x] Stok otomatis berkurang saat transaksi dibuat (pakai `DB::transaction` + `lockForUpdate` supaya aman dari race condition), sekaligus tercatat di `stock_movements` (tipe `OUT`) agar konsisten dengan modul Inventory milik Anggota 3
- [x] Validasi stok tidak boleh minus (transaksi ditolak kalau qty > stok tersedia)
- [x] Nomor invoice otomatis & unik: `INV-YYYYMMDD-XXXX`
- [x] Struk transaksi yang bisa dicetak (`sales/show.blade.php`, tombol "Cetak Struk")
- [x] Laporan Transaksi (`ReportController@transactions`) dengan filter rentang tanggal + ringkasan total transaksi, total pendapatan, total item terjual
- [x] Laporan Stok (`ReportController@stock`) — stok terkini semua produk + status "stok menipis", dan riwayat pergerakan stok dengan filter tanggal
- [x] Kedua laporan punya tombol "Cetak Laporan"
- [x] Middleware role sudah dipasang sesuai kesepakatan:
  - Sales Transaction → `cashier`
  - Transaction Report → `owner`, `manager`
  - Stock Report → `owner`, `manager`, `warehouse`
- [x] Menu navigasi ditambahkan **hanya** di blok role yang sesuai (tidak mengubah struktur nav yang sudah ada)
- [x] Test fitur (Pest) di `tests/Feature/SaleTest.php`: transaksi berhasil, stok berkurang, validasi stok kurang, dan akses role diuji

## 2. File Baru / Diubah

**Baru:**
```
database/migrations/2026_06_18_080000_create_sales_table.php
database/migrations/2026_06_18_080010_create_sale_details_table.php
app/Models/Sale.php
app/Models/SaleDetail.php
app/Http/Controllers/SaleController.php
app/Http/Controllers/ReportController.php
resources/views/sales/index.blade.php
resources/views/sales/create.blade.php
resources/views/sales/show.blade.php
resources/views/reports/transactions.blade.php
resources/views/reports/stock.blade.php
tests/Feature/SaleTest.php
```

**Diubah (hanya ditambah bagian milik Anggota 4, bagian lain tidak disentuh):**
```
routes/web.php                          -> isi blok "Laporan" & "Kasir" yang sebelumnya kosong
resources/views/layouts/navigation.blade.php -> isi blok @role('cashier') yang kosong + tambah menu Laporan
```

## 3. ⚠️ Catatan Penting — Mohon Diskusikan dengan Anggota 2

Saat saya cek struktur project, migration `create_branches_table` ternyata membuat kolom
`branch_name` dan `phone_number`, **bukan** `name` dan `phone`, dan **tidak ada kolom `manager_id`**.
Padahal `Branch` model, `BranchController`, dan semua view `branches/*` sudah memakai nama kolom
`name`, `phone`, `manager_id` (sesuai ERD yang disepakati Ketua).

Akibatnya CRUD Branch kemungkinan akan error (`column not found`) saat dijalankan, dan form
transaksi penjualan saya (yang butuh memilih cabang) tidak akan punya data cabang untuk dipilih
sampai ini diperbaiki.

Saya **tidak mengubah migration tersebut** karena itu bagian Anggota 2 dan sesuai aturan migration
("jangan ubah migration milik anggota lain tanpa diskusi"). Supaya transaksi penjualan tetap bisa
diuji, test saya (`SaleTest.php`) insert data branch langsung lewat `DB::table('branches')` memakai
nama kolom asli di migration saat ini.

**Saran:** Anggota 2 perlu membuat migration baru untuk menambah kolom `manager_id` dan
merename/menyesuaikan `branch_name` → `name`, `phone_number` → `phone` agar sesuai ERD.

## 4. Cara Menjalankan

```bash
composer install
cp .env.example .env   # kalau belum ada .env, lalu set koneksi database
php artisan key:generate
php artisan migrate --seed
php artisan test       # jalankan test, termasuk SaleTest
npm install && npm run build   # atau npm run dev
php artisan serve
```

Login kasir dummy (dari `RoleSeeder` + `DatabaseSeeder` milik Ketua): `cashier@gmail.com` / `password`

## 5. Alur Transaksi Singkat

1. Login sebagai role **cashier** → menu **Penjualan** muncul di navbar
2. Klik **Transaksi Baru** → pilih cabang, pilih produk + qty → klik **Tambah** (bisa berkali-kali)
3. Klik **Simpan Transaksi** → sistem otomatis: buat invoice, simpan detail, kurangi stok produk, catat ke `stock_movements`
4. Diarahkan ke halaman struk, bisa diklik **Cetak Struk**
5. Login sebagai **owner**/**manager** → menu **Laporan Transaksi** & **Laporan Stok** muncul, bisa difilter per tanggal dan dicetak

## 6. Langkah Git Selanjutnya (sesuai aturan Ketua)

```bash
git checkout main
git pull origin main
git checkout -b feature/transaction-management
# salin/replace file-file di atas ke project lokal kamu
git add .
git commit -m "feat: sales transaction, auto stock reduction, transaction & stock report"
git push origin feature/transaction-management
```
Jangan merge sendiri ke `main` — tunggu review dari Ketua sesuai aturan.
