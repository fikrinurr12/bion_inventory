# ⚡ Quick Start - Railway Deployment (5 Menit!)

## 1️⃣ Upload File ke GitHub (2 menit)

```bash
cd bion_inventory
# Copy semua file yang sudah didownload ke folder project

git add .
git commit -m "Add Railway config"
git push origin main
```

**File yang harus ada di root project:**
- ✅ `nixpacks.toml`
- ✅ `Procfile`
- ✅ `railway.json`
- ✅ `.env.railway`

---

## 2️⃣ Deploy di Railway (3 menit)

1. **Login:** https://railway.app → Login with GitHub
2. **New Project:** Klik "+ New Project" → "Deploy from GitHub repo"
3. **Pilih repo:** `fikrinurr12/bion_inventory` → "Deploy Now"
4. **Add Database:** Klik "+ New" → "Database" → "Add MySQL"
5. **Generate Domain:** Settings → "Generate Domain"

---

## 3️⃣ Set Environment Variables

1. Klik service Laravel (bukan database)
2. Tab "Variables" → "RAW Editor"
3. Copy-paste dari `.env.railway`
4. **Generate APP_KEY baru:**
   - Run: `php artisan key:generate --show`
   - Atau: https://generate-random.org/laravel-key-generator
5. Paste ke `APP_KEY`
6. Save

---

## 4️⃣ Run Migration

**Via Railway Dashboard:**
```
Settings → Custom Build Command:
composer install --no-dev --optimize-autoloader && php artisan migrate --force
```

**Atau via CLI:**
```bash
npm i -g @railway/cli
railway login
railway link
railway run php artisan migrate --force
```

---

## ✅ SELESAI!

Buka domain Railway Anda: `https://your-app.up.railway.app`

**Troubleshooting?** Lihat `RAILWAY_DEPLOYMENT_GUIDE.md` untuk panduan lengkap!

---

## 💰 Free Tier

- ✅ $5 kredit/bulan gratis
- ✅ Cukup untuk 500 jam execution
- ✅ Database MySQL included
- ✅ Auto-deploy dari GitHub

**Gratis untuk traffic rendah-menengah!** 🎉
