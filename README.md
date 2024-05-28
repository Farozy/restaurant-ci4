# Aplikasi Kasir Restoran CodeIgniter 4

Aplikasi kasir restoran adalah solusi teknologi yang sangat bermanfaat untuk mendukung pengelolaan transaksi keuangan dalam bisnis restoran.

Aplikasi kasir restoran digunakan untuk menunjang kelancaran dari transaksi penjualan agar lebih efisien dan cepat.

## Petunjuk penginstalan (PHP 7.4)

- Silahkan clone atau download projectnya terlebih dahulu
- Ganti nama file .env_copy menjadi .env kemudian edit dan sesuaikan nama database, username dan password
- Buat database baru sesuai dengan nama database di .env
- Bukan terminal / cmd, lalu ketikan dan jalankan secara berurutan
   - composer install
   - php spark migrate --all
   - php spark db:seed AuthSeeder
   - php spark db:seed UserSeeder
   - Buka text file (petunjuk_memasukkan_data) sebagai contoh
- jalankan project dengan php spark serve
- Masukkan username: admin & password: admin
- Untuk masuk ke role kasir, harus membuat data karyawan terlebih dahulu
- Kemudian tentukan role di menu User

## Kritik & Saran

- Laporkan jika ada bug
- Laporkan jika terjadi error pada menu di aplikasi
- Menerima masukan untuk pengembangan lebih lanjut aplikasi
