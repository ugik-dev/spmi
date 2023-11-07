## Untuk Running Docker
1. docker-compose build <!-- Untuk build image (cukup running 1x jika image sudah dibuild) -->
2. docker-compose up <!-- Untuk running container -->

## Command Inisiasi:
1. php artisan migrate atau php artisan migrate:fresh (untuk migrasi awal;buat struktur database)
2. php artisan db:seed (untuk melakukan inisiasi data;import database letakkan file SQL inisiasi data ke dalam folder seeds)

## Command Tambahan untuk development (bukan dihosting)
> browser-sync start --config bs-config.js (untuk running sinkron ke browser syarat aplikasi yang dalam docker/php artisan serve harus sudah running terlebih dahulu)

## Cara penggunaan factory untuk dummy data (data testing) (running command menggunakan php artisan tinker):
1. Masuk ke terminal dan running php artisan tinker, untuk masuk ke command console artisan tinker
2. Urutan generate factory saat ini adalah sebagai berikut:
    i. factory(App\Element::class,100)->create() 
    ii. factory(App\Target::class,100)->create()
    iii. factory(App\Berkas::class,100)->create()
