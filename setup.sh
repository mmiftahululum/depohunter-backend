#!/bin/bash
set -e

echo "=========================================="
echo "🛠️  Depo Hunter - Setup Awal Hostinger"
echo "=========================================="

# 1. Setup file .env
if [ ! -f .env ]; then
    echo "📄 Menyalin .env.example ke .env..."
    cp .env.example .env
    echo "⚠️  CATATAN: Jangan lupa sesuaikan DB_DATABASE, DB_USERNAME, dan DB_PASSWORD di .env!"
else
    echo "📄 File .env sudah ada."
fi

# 2. Atur izin akses direktori
echo "🔒 Mengatur permission storage & bootstrap/cache..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# 3. Install dependency composer
echo "📦 Menginstall dependencies via Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 4. Generate Application Key jika belum ada
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 Membuat APP_KEY..."
    php artisan key:generate --force
fi

# 5. Pasang Git Hook post-merge agar tiap 'git pull' otomatis deploy
echo "🪝 Memasang Git post-merge hook..."
mkdir -p .git/hooks
cat << 'EOF' > .git/hooks/post-merge
#!/bin/bash
echo ""
echo "🚀 [Git Hook] Mendeteksi git pull, menjalankan deployment otomatis..."
bash deploy.sh
EOF
chmod +x .git/hooks/post-merge
chmod +x deploy.sh

# 6. Buat symbolic link storage
echo "🔗 Membuat storage link..."
php artisan storage:link 2>/dev/null || true

echo ""
echo "=========================================="
echo "🎉 SETUP SELESAI!"
echo "=========================================="
echo "Langkah selanjutnya:"
echo "1. Edit file .env (masukkan kredensial database Hostinger)."
echo "2. Jalankan migrasi pertama: php artisan migrate --force"
echo "3. Buat admin Filament: php artisan make:filament-user"
echo ""
echo "Setelah ini, setiap kali Anda menjalankan:"
echo "👉 git pull"
echo "Script deploy akan berjalan otomatis tanpa perlu setting lagi!"
echo "=========================================="
