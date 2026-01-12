#!/bin/bash

# Post-deployment script for Railway
# This script runs after each deployment

echo "🚀 Running post-deployment tasks..."

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
until php artisan migrate:status 2>/dev/null; do
  echo "Database not ready, waiting..."
  sleep 5
done

echo "✅ Database is ready!"

# Run migrations
echo "📦 Running database migrations..."
php artisan migrate --force

# Seed database (optional - comment out if not needed)
# echo "🌱 Seeding database..."
# php artisan db:seed --force

# Clear and cache config
echo "⚙️  Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set storage permissions
echo "🔐 Setting storage permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Post-deployment complete!"
