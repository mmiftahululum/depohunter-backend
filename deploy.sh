#!/bin/bash
set -e

echo "=========================================="
echo "🚀 [Deploy] Memulai update aplikasi..."
echo "=========================================="

# 1. Masuk mode maintenance sementara (jika aplikasi sedang berjalan)
php artisan down --render="errors::503" 2>/dev/null || true

# 2. Update dependensi Composer (production mode)
if [ -f "composer.json" ]; then
    echo "📦 Menginstall / memperbarui dependency composer..."
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
fi

# 3. Jalankan migrasi database otomatis
echo "🗄️ Menjalankan migrasi database..."
php artisan migrate --force

# 4. Pastikan storage link tersedia
echo "🔗 Mengecek symlink storage..."
php artisan storage:link 2>/dev/null || true

# 5. Clear dan cache ulang untuk performa maksimal
echo "⚡ Memperbarui cache Laravel..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Optimasi Filament jika ada
if php artisan list | grep -q "filament:optimize"; then
    echo "🎨 Mengoptimasi Filament Admin..."
    php artisan filament:optimize 2>/dev/null || true
fi

# 7. Matikan mode maintenance
php artisan up

echo "=========================================="
echo "✅ [Deploy] Aplikasi berhasil diupdate dan aktif!"
echo "=========================================="
