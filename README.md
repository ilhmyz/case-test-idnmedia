# case-test-idnmedia

Ini adalah repositori yang dibuat sebagai bagian dari proses seleksi di IDN Media.

## Deskripsi

Repositori ini merupakan case test untuk IDN Media posisi Infrastructure Engineer.

## Struktur Proyek

tiap directory terdapat `Dockerfile` untuk build docker image dan di push di DockerHub

- `mysql/`: pada directory ini berisi file `*.sql` yang mana untuk inisialisasi pembuatan table saat container db berjalan.
- `nginx/`: nginx config.
- `php/`: pada ini terdapat folder `app/` yang isinya adalah aplikasi simple-blog yang dibuat dengan php native.

## Cara Menjalankan

Untuk menjalankan ini, pastikan telah memiliki lingkungan yang telah disiapkan. Ikuti langkah-langkah di bawah:

1. Install `docker` dan `docker-compose`.
2. Jalankan menggunakan docker-compose.
```bash
docker-compose up -d
```
3. Cek container yang tadi dengan perintah `docker ps`
4. buka di browser dengan mengakses http://localhost/
5. untuk login, akses di http://localhost/login.php, gunakan user dan password `admin`
