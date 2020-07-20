<h1 align="center">Selamat datang di Point of Sale! 👋</h1>

## Apa itu Point of Sale?

Web Point of Sale yang dibuat oleh <a href="https://github.com/adhiariyadi"> Adhi Ariyadi </a>. **Point of Sale adalah Website transaksi penjualan barang melalui website dengan mudah.**

## Fitur apa saja yang tersedia di Point of Sale?

-   Autentikasi Admin
-   User & CRUD
-   Category & CRUD
-   Product & CRUD
-   Discount
-   Transaksi
-   Dan lain-lain

## Release Date

**Release date : 12 Jul 2020**

> Point of Sale merupakan project open source yang dibuat oleh Adhi Ariyadi. Kalian dapat download/fork/clone. Cukup beri stars di project ini agar memberiku semangat. Terima kasih!

---

## Default Account for testing

**Admin Default Account**

-   Username: admin
-   Password: admin

**Kasir Default Account**

-   Username: kasir
-   Password: kasir

---

## Install

1. **Clone Repository**

```bash
git clone https://github.com/adhiariyadi/Point-of-Sale-Laravel-Vue.git
cd Point-of-Sale-Laravel-Vue
composer install
npm install
cp .env.example .env
```

2. **Buka `.env` lalu ubah baris berikut sesuai dengan databasemu yang ingin dipakai**

```bash
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. **Instalasi website**

```bash
php artisan key:generate
php artisan migrate --seed
php artisan jwt:secret
php artisan config:cache
```

4. **Jalankan website**

```bash
php artisan serve
```

## Author

-   Facebook : <a href="https://web.facebook.com/adhiariyadi.me/"> Adhi Ariyadi</a>
-   LinkedIn : <a href="https://www.linkedin.com/in/adhiariyadi/"> Adhi Ariyadi</a>

## Contributing

Contributions, issues and feature requests di persilahkan.
Jangan ragu untuk memeriksa halaman masalah jika Anda ingin berkontribusi. **Berhubung Project ini saya sudah selesaikan sendiri, namun banyak fitur yang kalian dapat tambahkan silahkan berkontribusi yaa!**

## License

-   Copyright © 2020 Adhi Ariyadi.
-   **Point of Sale is open-sourced software licensed under the MIT license.**
