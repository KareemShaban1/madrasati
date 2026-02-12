# Fix: 404 on /api/public/curriculum

The error `GET https://madrasati.kareemsoft.org/api/public/curriculum 404` happens because the **Laravel backend is not serving the API routes**. The document root is likely pointing to the React build only.

---

## Solution: Use Laravel `public` as Document Root

**Both the React app and API must be served from Laravel's `backend/public` folder.**

### Step 1: Build the frontend

```bash
# From project root
npm run build
```

### Step 2: Deploy to server

1. Upload the entire project (or use Git).
2. On the server, copy the React build into Laravel's public folder:

```bash
# Copy React build into backend/public
cp -r dist/* backend/public/
```

This puts `index.html` and the `assets/` folder inside `backend/public/`.

### Step 3: Set document root in cPanel / aaPanel

Set the **document root** for `madrasati.kareemsoft.org` to:

```
/home/username/public_html/madrasati/backend/public
```

(Adjust the path to match your actual folder structure.)

### Step 4: Build with correct API URL

If frontend and backend are on the **same domain**, leave `VITE_API_URL` **empty** when building:

```bash
# .env or when building - use empty or same origin
VITE_API_URL=
npm run build
```

The frontend will then request `/api/public/curriculum` (relative URL), which Laravel will handle.

### Step 5: Verify .htaccess

Ensure `backend/public/.htaccess` exists and contains the Laravel rewrite rules (it should already).

### Step 6: Laravel SPA fallback (already in project)

The project includes routes that serve the React `index.html` for the root and frontend paths like `/stage/1`, `/grade/2`. No extra config needed.

---

## Alternative: API Subdomain

If you prefer to keep the React app in the main document root:

1. **Main domain** `madrasati.kareemsoft.org` → document root = folder with React `index.html` + `assets/`
2. **Subdomain** `api.madrasati.kareemsoft.org` → document root = `backend/public`

3. Build frontend with API subdomain:

```bash
VITE_API_URL=https://api.madrasati.kareemsoft.org npm run build
```

4. Create the `api` subdomain in cPanel and point it to `backend/public`.

---

## Quick Checklist

- [ ] Document root = `backend/public` (not project root, not `dist/`)
- [ ] React `index.html` and `assets/` are inside `backend/public/`
- [ ] `VITE_API_URL` is empty (same domain) or `https://api.madrasati.kareemsoft.org` (subdomain)
- [ ] Run `composer install` and `php artisan migrate` in `backend/`
- [ ] Run `php artisan storage:link` in `backend/`

---

## Test the API directly

Visit in browser or with curl:

```
https://madrasati.kareemsoft.org/api/public/curriculum
```

If Laravel is configured correctly, you should get JSON (curriculum data), not 404 or HTML.
