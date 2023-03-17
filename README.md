<h1 align="center" height="800" font-weight="bold">SURPLUS PRETEST</h1>

# Requirements
- PHP >=8.1
- Composer >=2
- PostgreSQL or any SQL RDBMS

# Installation
- Cloning from git repository
- Open the cloned repository directory
- Run command `composer install`
- Run command `cp .env.example .env`
- `APP_URL` env value should present within the port used by the Laravel
- `FILESYSTEM_DISK` env value must be `public`!!!
- Run command `php artisan storage:link` to enable image preview
- Run command `php artisan migrate` to seed DB schema
- Good to go, run `php artisan serve`

# API's
Laravel backend service ini digunakan untuk menyediakan API untuk melakukan CRUD terkait data produk dengan kapabilitas
dapat dilakukan flagging menggunakan category dan terdapat fitur tambahan seperti dukungan upload multiple media image untuk masing" produk yang dibuat. Berikut routings API's yang tersedia pada backend service ini:
- `/category` digunakan untuk melakukan get data categories yang telah dibuat
- `/category/create` digunakan untuk membuat data category baru
- `/category/update/{id}` digunakan untuk melakukan perubahan data pada category
- `/category/delete/{id}` digunakan untuk menghilangkan data category, tidak bisa dilakukan penghapusan ketika data category terdapat data produk didalamnya
- `/product` digunakan untuk melakukan get data produk
- `/product/{id}` digunakan untuk melakukan get data spesifik produk
- `/product/create` digunakan untuk membuat data produk baru
- `/product/{id}/image/append` digunakan untuk menambahkan multiple media image pada data produk yang telah terbuat
- `/product/update/{id}` digunakan untuk melakukan perubahan data pada produk
- `/product/delete/{id}` digunakan untuk menghapus data produk (data image didalamnya akan otomatis hilang)
- `/product/image/update/{id}` digunakan untuk merubah media image yang sudah ada pada data produk
- `/product/image/delete/{id}` digunakan untuk menghapus data image pada data produk yang telah terbuat

# API's Usage Documentation
[DOWNLOAD POSTMAN API COLLECTION](https://drive.google.com/file/d/1Hum3U62t0aenaNtTP027epDe2KK7o3jj/view?usp=sharing)
<br />
**OR**
<br />
[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/4551391-86edc6b2-18b8-462b-8826-fbfb1a5b4e9e?action=collection%2Ffork&collection-url=entityId%3D4551391-86edc6b2-18b8-462b-8826-fbfb1a5b4e9e%26entityType%3Dcollection%26workspaceId%3D6ceb5ec7-69f0-41df-b9d3-806e5455d740)
