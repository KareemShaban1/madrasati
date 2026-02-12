# Deploy Madrasati to Server (cPanel / aaPanel)

Guide to upload and run the project on a server using cPanel, aaPanel, or similar control panels.

---

## Prerequisites

- **PHP** 8.2+ (with extensions: bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, tokenizer, xml)
- **Node.js** 18+ (for building the frontend)
- **Composer** (PHP dependency manager)
- **MySQL** 8.0+ or **MariaDB** 10.3+
- **SSL certificate** (Let's Encrypt or similar)

---

## 1. Upload Project Files

### Option A: Git (recommended)

```bash
# SSH into your server
ssh user@your-server.com

# Navigate to web root (e.g. public_html or a subdomain folder)
cd public_html  # or /home/username/madrasati.com

# Clone the repository
git clone https://github.com/your-username/madrasati.git .
```

### Option B: FTP / File Manager

1. Create a **ZIP** of your project (exclude `node_modules`, `vendor`, `.env`)
2. Upload the ZIP via **File Manager** or **FTP client** (FileZilla)
3. Extract the archive in the target folder

---

## 2. Backend (Laravel) Setup

### 2.1 Install PHP dependencies

```bash
cd backend
composer install --optimize-autoloader --no-dev
```

### 2.2 Environment file

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your production values:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 2.3 Database

1. Create a MySQL database in cPanel/aaPanel
2. Create a database user and assign privileges
3. Run migrations:

```bash
php artisan migrate --force
php artisan db:seed --force   # optional: seed initial data
```

### 2.4 Storage & permissions

```bash
php artisan storage:link
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache   # Linux; adjust user if needed
```

### 2.5 Point public web root to `backend/public`

- In cPanel: set document root to `public_html/madrasati/backend/public`
- Or use a subdomain like `api.your-domain.com` pointing to `backend/public`

---

## 3. Frontend (React + Vite) Setup

### 3.1 Build the frontend

```bash
# From project root (not backend)
cd ..
npm install
npm run build
```

This creates `dist/` with static files.

### 3.2 Serve the frontend

**Option A — Same domain (SPA):**

1. Copy contents of `dist/` to `public_html/` (or your main domain folder)
2. Add `.htaccess` in `public_html/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteRule ^index\.html$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.html [L]
</IfModule>
```

**Option B — Subdomain (e.g. app.your-domain.com):**

1. Create subdomain in cPanel
2. Point it to a folder containing `dist/` contents
3. Add the same `.htaccess` for SPA routing

---

## 4. API URL Configuration

Set the API base URL in the frontend so it calls your Laravel backend:

- Create `.env.production` or set `VITE_API_URL` when building:

```env
VITE_API_URL=https://api.your-domain.com
# or https://your-domain.com if API is under same domain
```

- Rebuild: `npm run build`

---

## 5. Admin Panel (Blade)

If you use the Laravel admin (Blade views):

- Access at: `https://your-domain.com/admin` (or `https://api.your-domain.com/admin`)
- Storage link must exist: `php artisan storage:link`
- Ensure `storage/app/public` is writable

---

## 6. cPanel / aaPanel Specific Steps

### cPanel

1. **MySQL Databases** — Create DB and user, add user to database
2. **Subdomains** — Create `api` and `app` if using separate subdomains
3. **PHP Version** — Select PHP 8.2+ in **MultiPHP Manager**
4. **SSL** — Use **SSL/TLS Status** to install Let's Encrypt

### aaPanel

1. **Website** — Add site, set PHP version to 8.2+
2. **Database** — Create MySQL database and user
3. **SSL** — Enable Let's Encrypt in site settings
4. **Node** — Install Node.js via **App Store** if not present

---

## 7. Post-Deployment Checklist

- [ ] `.env` has correct `APP_URL` and `DB_*` values
- [ ] `APP_DEBUG=false` in production
- [ ] Storage symlink created (`storage:link`)
- [ ] Frontend `VITE_API_URL` points to backend
- [ ] CORS configured in Laravel if API is on different domain
- [ ] SSL enabled
- [ ] File permissions correct (`storage`, `bootstrap/cache`)

---

## 8. Common Issues

| Issue | Fix |
|-------|-----|
| 500 error | Check `storage/logs/laravel.log`, fix permissions |
| CORS errors | Configure `config/cors.php` and allowed origins |
| Mix content (HTTP/HTTPS) | Ensure `APP_URL` and API URL use `https://` |
| Blank page | Check browser console, verify API URL and routes |
| Images not loading | Verify `storage:link`, `storage/app/public` permissions |
