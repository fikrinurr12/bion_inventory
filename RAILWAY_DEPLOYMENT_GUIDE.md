# 🚀 Panduan Deploy BION Inventory ke Railway.app

## Kenapa Railway?
✅ **$5 kredit gratis per bulan** (cukup untuk projek kecil)
✅ Database MySQL built-in otomatis
✅ Deploy langsung dari GitHub
✅ Setup hanya 5-10 menit!
✅ Support PHP & Laravel native

---

## 📋 Persiapan

### File-file yang Sudah Saya Buatkan:
1. ✅ `nixpacks.toml` - Build configuration
2. ✅ `Procfile` - Startup command
3. ✅ `railway.json` - Railway configuration
4. ✅ `.env.railway` - Template environment variables

### Yang Perlu Anda Lakukan:

#### 1. Upload File Konfigurasi ke GitHub

```bash
# Clone repository Anda (jika belum)
git clone https://github.com/fikrinurr12/bion_inventory.git
cd bion_inventory

# Copy file-file yang sudah saya buat ke root project
# (Download dulu semua file dari Claude, lalu copy ke folder project)

# Commit dan push
git add nixpacks.toml Procfile railway.json .env.railway
git commit -m "Add Railway configuration"
git push origin main
```

---

## 🎯 Langkah Deploy (Super Mudah!)

### Step 1: Daftar di Railway

1. Buka **https://railway.app**
2. Klik **"Start a New Project"** atau **"Login with GitHub"**
3. Authorize Railway untuk akses GitHub Anda

### Step 2: Create New Project

1. Di dashboard Railway, klik **"+ New Project"**
2. Pilih **"Deploy from GitHub repo"**
3. Pilih repository: **fikrinurr12/bion_inventory**
4. Klik **"Deploy Now"**

### Step 3: Add MySQL Database

1. Di project Railway Anda, klik **"+ New"**
2. Pilih **"Database"** → **"Add MySQL"**
3. Railway akan otomatis provision database MySQL
4. Database akan otomatis terkoneksi ke aplikasi Laravel Anda!

### Step 4: Configure Environment Variables

Railway akan auto-generate variable database, tapi Anda perlu tambah beberapa:

1. Klik service **Laravel Anda** (bukan database)
2. Buka tab **"Variables"**
3. Klik **"RAW Editor"**
4. Copy-paste dari file `.env.railway` yang sudah saya buat
5. **PENTING:** Ganti `APP_KEY` dengan yang baru:

```bash
# Generate APP_KEY baru (run di local)
php artisan key:generate --show

# Atau gunakan online generator:
# https://generate-random.org/laravel-key-generator
```

6. Pastikan variable berikut sudah ada (Railway auto-generate):
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`
   - `RAILWAY_PUBLIC_DOMAIN`

7. Klik **"Save"**

### Step 5: Run Database Migration

1. Di service Laravel, klik tab **"Settings"**
2. Scroll ke **"Deploy"**
3. Di **"Custom Build Command"**, tambahkan:
   ```bash
   composer install --no-dev --optimize-autoloader && php artisan migrate --force
   ```

4. Atau run migration manual via Railway CLI:
   ```bash
   # Install Railway CLI
   npm i -g @railway/cli
   
   # Login
   railway login
   
   # Link project
   railway link
   
   # Run migration
   railway run php artisan migrate --force
   railway run php artisan db:seed --force
   ```

### Step 6: Deploy!

1. Railway akan otomatis deploy aplikasi Anda
2. Tunggu beberapa menit (biasanya 3-5 menit)
3. Setelah selesai, klik **"Settings"** → **"Generate Domain"**
4. Railway akan berikan URL publik, contoh: `bion-inventory-production.up.railway.app`

---

## 🎉 Aplikasi Sudah Live!

Buka URL yang diberikan Railway. Aplikasi Laravel Anda sudah berjalan!

**URL Format:** `https://your-app-name.up.railway.app`

---

## 🔧 Troubleshooting

### Error: "500 Internal Server Error"

**Check logs:**
1. Di Railway dashboard → Service → Tab **"Deployments"**
2. Klik deployment terakhir → Lihat logs

**Solusi umum:**

```bash
# Via Railway CLI
railway run php artisan key:generate
railway run php artisan migrate --force
railway run php artisan config:clear
railway run php artisan cache:clear
railway run php artisan view:clear
```

### Error: "Database connection failed"

**Pastikan:**
1. MySQL service sudah dibuat di Railway
2. Environment variables database sudah otomatis di-set
3. Check di tab Variables, pastikan ada: `MYSQLHOST`, `MYSQLUSER`, dll.

**Fix:**
```bash
railway run php artisan config:clear
```

### Error: "Storage not writable"

Laravel butuh permission untuk folder storage. Railway biasanya handle ini otomatis, tapi jika error:

**Edit `nixpacks.toml`, tambahkan di section build:**
```toml
[phases.build]
cmds = [
    'php artisan config:cache',
    'php artisan route:cache',
    'php artisan view:cache',
    'chmod -R 775 storage bootstrap/cache'
]
```

### Error: "APP_KEY not set"

**Generate APP_KEY baru:**
```bash
# Di local
php artisan key:generate --show

# Copy hasilnya (contoh: base64:abcd1234...)
# Paste ke Railway Variables → APP_KEY
```

---

## ⚙️ Konfigurasi Lanjutan

### Custom Domain

1. Railway → Settings → Networking → Custom Domain
2. Tambahkan domain Anda (misal: `inventory.yourdomain.com`)
3. Update DNS A record di registrar domain Anda

### Auto-Deploy dari GitHub

Railway otomatis deploy setiap kali Anda push ke GitHub! 

**Disable auto-deploy:**
1. Settings → Source → Disconnect dari GitHub
2. Deploy manual via Railway CLI

### Monitoring & Logs

**View logs real-time:**
```bash
railway logs
```

**View logs di dashboard:**
Railway → Service → Deployments → Klik deployment → View logs

### Scaling

**Free tier limitation:**
- $5 kredit/bulan
- ~500 jam execution time
- Cukup untuk 20-30 ribu request/bulan

**Upgrade ke Pro:** $5/bulan untuk unlimited usage

---

## 📊 Estimasi Biaya Free Tier

Dengan **$5 kredit gratis/bulan:**
- Aplikasi Laravel kecil: **$2-3/bulan** ✅
- Database MySQL: **$1-2/bulan** ✅
- Total: **$3-5/bulan** (masih dalam free tier!)

Untuk traffic rendah-menengah, **Railway tetap gratis**!

---

## 🆘 Need Help?

**Railway Documentation:**
- https://docs.railway.app
- https://docs.railway.app/guides/laravel

**Laravel Deployment:**
- https://laravel.com/docs/deployment

**Railway Community:**
- Discord: https://discord.gg/railway

---

## 🔐 Security Checklist

Sebelum production:

- [ ] `APP_DEBUG=false` di Railway Variables
- [ ] `APP_ENV=production`
- [ ] Generate `APP_KEY` baru (jangan pakai yang sama dengan local)
- [ ] Update `APP_URL` dengan domain Railway
- [ ] Enable HTTPS (Railway sudah otomatis)
- [ ] Backup database regular
- [ ] Set up error monitoring (Sentry, Bugsnag)

---

## 🎯 Next Steps After Deploy

1. **Setup SMTP untuk email** (gunakan Mailtrap/SendGrid)
2. **Enable cache** (Redis add-on jika perlu)
3. **Setup cron jobs** (untuk scheduled tasks)
4. **Add file storage** (S3/Cloudinary untuk upload files)
5. **Monitoring** (Setup Sentry untuk error tracking)

---

## 🚀 Deployment Complete!

Selamat! Aplikasi BION Inventory Anda sudah live di Railway! 🎉

**Your App URL:** `https://bion-inventory-production.up.railway.app`

Questions? Railway's documentation is excellent, atau tanya saya di chat ini! 😊
