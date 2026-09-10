# eXP Dashboard

eXP Dashboard is a Laravel-based client and project management portal for eXP Designs.

The portal is planned for both internal agency work and client access. It covers clients, projects, German maintenance reports, task control, client documents, tickets, and later invoices.

## Planned Domain

```text
https://dashboard.expdesign.de
```

## Current Features

- Login-first private portal
- eXP Designs branding
- Admin dashboard
- Client and Kundenprofil management
- Project management
- German Wartungsbericht form and preview
- Filters and pagination on client, project, and report lists

## Local Development

Start MySQL first, then run these in two terminals:

```bash
php artisan serve
```

```bash
npm run dev
```

Open:

```text
http://127.0.0.1:8000
```

## Database

Local development uses MySQL/MariaDB.

```env
DB_CONNECTION=mysql
DB_DATABASE=wartungsbericht
```

Production is planned for ALL-INKL hosting with the public URL `dashboard.expdesign.de`.
