# Mini Market Management System

## Deskripsi Project

Mini Market Management System adalah aplikasi berbasis web yang dibangun menggunakan Laravel 13 dan MySQL untuk membantu pemilik usaha minimarket mengelola banyak cabang dalam satu sistem terpusat.

Sistem ini dibuat berdasarkan studi kasus dimana pemilik minimarket memiliki beberapa cabang yang tersebar di berbagai kota dan mengalami kesulitan dalam melakukan pengawasan transaksi maupun stok barang secara real-time.

Dengan sistem ini, pemilik dapat memantau seluruh aktivitas cabang melalui satu aplikasi, sementara setiap pegawai hanya dapat mengakses fitur sesuai dengan tugas dan tanggung jawabnya.

---

## Tujuan Sistem

- Mengelola data pengguna berdasarkan role.
- Mengelola data cabang minimarket.
- Mengelola data produk dan kategori.
- Mengelola stok barang.
- Mengelola transaksi penjualan.
- Menghasilkan laporan transaksi dan stok.
- Membatasi akses pengguna berdasarkan role.
- Memudahkan pemilik dalam memonitor seluruh cabang secara terpusat.

---

## Teknologi yang Digunakan

### Backend

- Laravel 13
- PHP 8.3+
- MySQL

### Frontend

- Blade Template
- Tailwind CSS
- Laravel Breeze

### Authentication & Authorization

- Laravel Breeze
- Spatie Laravel Permission

### Version Control

- Git
- GitHub

---

## Role Pengguna

### Owner

Hak akses:

- Dashboard
- User Management
- Branch Management
- Product Management
- Inventory Management
- Transaction Report
- Stock Report

---

### Manager

Hak akses:

- Dashboard
- Transaction Report
- Stock Report

---

### Supervisor

Hak akses:

- Dashboard
- Product Management
- Inventory Monitoring

---

### Cashier

Hak akses:

- Dashboard
- Sales Transaction

---

### Warehouse

Hak akses:

- Dashboard
- Stock In
- Stock Out
- Inventory Monitoring

---

## Struktur Database

### Users

| Field | Type |
|---------|---------|
| id | bigint |
| branch_id | bigint nullable |
| username | string |
| name | string |
| email | string |
| password | string |
| is_active | boolean |
| created_at | timestamp |
| updated_at | timestamp |
| deleted_at | timestamp |

---

### Branches

| Field | Type |
|---------|---------|
| id | bigint |
| name | string |
| city | string |
| address | text |
| phone | string |
| manager_id | bigint |

---

### Categories

| Field | Type |
|---------|---------|
| id | bigint |
| name | string |
| description | text |

---

### Products

| Field | Type |
|---------|---------|
| id | bigint |
| category_id | bigint |
| barcode | string |
| name | string |
| purchase_price | decimal |
| selling_price | decimal |
| stock | integer |
| minimum_stock | integer |

---

### Stock Movements

| Field | Type |
|---------|---------|
| id | bigint |
| product_id | bigint |
| user_id | bigint |
| type | enum(IN, OUT) |
| quantity | integer |
| notes | text |

---

### Sales

| Field | Type |
|---------|---------|
| id | bigint |
| invoice_number | string |
| branch_id | bigint |
| cashier_id | bigint |
| total | decimal |
| transaction_date | datetime |

---

### Sale Details

| Field | Type |
|---------|---------|
| id | bigint |
| sale_id | bigint |
| product_id | bigint |
| qty | integer |
| price | decimal |
| subtotal | decimal |

---

## Struktur Branch Git

### Main Branch

```bash
main
```

### Anggota 1

```bash
feat/user-management
```

### Anggota 2

```bash
feature/branch-management
```

### Anggota 3

```bash
feature/product-inventory
```

### Anggota 4

```bash
feature/transaction-report
```

---

## Instalasi Project

### Clone Repository

```bash
git clone <repository-url>
```

Masuk ke folder project:

```bash
cd tubes-pw2-kelas
```

---

### Install Dependency

```bash
composer install
```

---

### Copy Environment

```bash
cp .env.example .env
```

---

### Generate Application Key

```bash
php artisan key:generate
```

---

### Konfigurasi Database

Atur file `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tubes_pw2
DB_USERNAME=root
DB_PASSWORD=
```

---

### Jalankan Migration dan Seeder

```bash
php artisan migrate --seed
```

---

### Jalankan Server

```bash
php artisan serve
```

---

## Akun Testing

| Username | Password | Role |
|-----------|-----------|-----------|
| owner | password | Owner |
| manager | password | Manager |
| supervisor | password | Supervisor |
| cashier | password | Cashier |
| warehouse | password | Warehouse |

---

## Kontributor

### Anggota 1

- Authentication
- Authorization
- User Management
- Dashboard
- Seeder

### Anggota 2

- Branch Management

### Anggota 3

- Product & Inventory Management

### Anggota 4

- Transaction & Reporting

---

## License

Project ini dibuat untuk memenuhi tugas mata kuliah Pemrograman Web 2.
