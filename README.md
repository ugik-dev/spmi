## Untuk Running Docker

1. sail build <!-- Untuk build image (cukup running 1x jika image sudah dibuild) -->
2. sail up <!-- Untuk running container -->

## Command running ke container docker

1. sail artisan
2. sail composer
3. sail npm

## Command Inisiasi:

1. php artisan migrate atau php artisan migrate:fresh (untuk migrasi awal;buat struktur database)
2. php artisan db:seed (untuk melakukan inisiasi data;import database letakkan file SQL inisiasi data ke dalam folder seeds)
3. npm install
4. npm run dev <!-- run dev (development) atau run production (production/online/hosting) -->

## Command Tambahan untuk development (bukan dihosting)

1. browser-sync start --config bs-config.js (untuk running sinkron ke browser syarat aplikasi yang dalam docker/php artisan serve harus sudah running terlebih dahulu)
2. npm run [dev atau watch] (untuk mengkompilasi file asset dalam resources. js,css,images) <!-- command npm run dev untuk sekali kompilasi sedangkan untuk npm run watch untuk memantau apabila ada perubahan file js atau scss maka otomatis akan melakukan re-compile (detail files yang dipantau bisa cek di webpack.config.js) -->

## Cara penggunaan factory untuk dummy data (data testing) (running command menggunakan php artisan tinker):

1. Masuk ke terminal dan running php artisan tinker, untuk masuk ke command console artisan tinker
2. syntax factory contoh: App\User::factory(100)->create()

## PhpMyadmin

docker run --name spmiv2-phpmyadmin -d --network spmi_app-network -e PMA_HOST=laravel-db -e PMA_USER=spmi -e PMA_PASSWORD=spmi -p 8080:80 phpmyadmin

### Troubleshoot

- Untuk permasalahan seperti class yang tidak ditemukan (not found), bisa running **composer dump-autoload** dan/atau **php artisan cache:clear**

## Referensi

1. [fungsi ambil instance datatable](https://github.com/yajra/laravel-datatables-html/blob/4.0/src/resources/views/script.blade.php)
