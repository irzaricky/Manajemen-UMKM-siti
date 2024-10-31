# Manajemen-UMKM-siti

> Website manajemen UMKM siti mata kuliah manajemen proyek

## Install and .env setup

1. npm install & composer install
2. php artisan key:generate

## Database setup

1. Buat database pada mysql sesuai dengan env
2. Modified file .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_db_umkm_siti
DB_USERNAME=root
DB_PASSWORD=
```

3. php artisan migrate --seed

## Usage

```sh
npm run dev & php artisan serve
```
