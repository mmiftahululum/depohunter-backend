---
name: laravel-development
description: >
  Membantu pengembangan aplikasi Laravel, termasuk
  pembuatan CRUD, REST API, database migration,
  Eloquent ORM, validasi, autentikasi, dan debugging.
---

# Laravel Development Skill

## Architecture

- Ikuti struktur standar Laravel.
- Pisahkan business logic dari Controller jika diperlukan.
- Gunakan Service atau Action class untuk business logic
  yang kompleks.
- Gunakan Form Request untuk validasi yang kompleks.

## Database

- Gunakan Eloquent ORM jika sesuai.
- Gunakan migration untuk perubahan struktur database.
- Hindari query berulang yang tidak diperlukan.
- Perhatikan N+1 query.
- jika dibutuhkan untuk masuk database bisa akses ini mysql -u root -p tanpa password.

## API Development

- Gunakan API Resource untuk response yang konsisten.
- Terapkan validasi request.
- Gunakan HTTP status code yang sesuai.
- Tangani exception dengan benar.

## Security

- Jangan menyimpan password dalam bentuk plaintext.
- Validasi seluruh input pengguna.
- Gunakan authorization untuk melindungi data.
- Jangan mengekspos informasi sensitif dalam response.

## Workflow

1. Periksa struktur proyek yang sudah ada.
2. Identifikasi versi Laravel dan dependensinya.
3. Analisis kebutuhan sebelum mengubah kode.
4. Ikuti pola yang sudah digunakan proyek.
5. Implementasikan perubahan.
6. Jalankan test yang relevan jika tersedia.
7. Jelaskan file yang diubah.

## FRONTEND
1. Gunakan selalu mamakai jquery dan boostrap
2. Bila Memungkinkan Pisahkan antara jquery dan html kedalam file terpisah, Bila jquery lebih dari 100 baris.
