# Skeleton Laravel

## Cara Instalasi

- Clone repository [https://gitlab.com/dev-landa-system/belajar-laravel](https://gitlab.com/dev-landa-system/belajar-laravel)
- Masuk ke folder **belajar-laravel** dan jalankan perintah **composer install**
- Pada root Folder **belajar-laravel** buat sebuah file dengan nama **.env** dan copy konten dari file **.env.example** ke dalam file tersebut
- Sesuaikan pengaturan koneksi database pada file **.env** (Key yang perlu disesuaikan DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- Install Redis, tutorial bisa dibaca di [https://redis.io/topics/quickstart](https://redis.io/topics/quickstart)
- Pada terminal jalankan perintah **php artisan migrate** untuk migrasi tabel yang diperlukan ke database
- Pada terminal jalankan perintah **php artisan db:seed --class=UserSeeder** untuk mengimport data user dan hak akses default ke database
- Pada terminal jalankan perintah **php artisan serve --port=4201** 
- Laravel bisa diakses menggunakan url **http://localhost:4201/**
- Dokumentasi API bisa dilihat di [https://documenter.getpostman.com/view/398508/UVeJJPk8#4c18847b-12a3-4f8a-be5d-83ac83034411](https://documenter.getpostman.com/view/398508/UVeJJPk8#4c18847b-12a3-4f8a-be5d-83ac83034411)
