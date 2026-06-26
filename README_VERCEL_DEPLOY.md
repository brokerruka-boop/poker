# Vercel Deploy Prep

This legacy PHP poker app can be deployed to Vercel only through a PHP custom runtime. It still requires an external MySQL-compatible database; the local portable MariaDB data is not deployed to Vercel.

## Included Vercel Files

- `vercel.json` uses `vercel-php@0.9.0` and routes all dynamic requests to `api/index.php`.
- `api/index.php` emulates the local router for page routes such as `/login.php` and direct PHP endpoints such as `/includes/live_games.php`.
- `.env.example` lists the required production database variables.
- `.vercelignore` excludes local runtime binaries, DB dumps, exports, and the React experiment folder.
- `includes/configure.local.php` keeps local database credentials out of Vercel deployments.

## Required Vercel Environment Variables

Set either:

```bash
DB_SERVER=your-mysql-host;port=3306
DB_SERVER_USERNAME=your-mysql-user
DB_SERVER_PASSWORD=your-mysql-password
DB_DATABASE=your-mysql-database
```

Or:

```bash
MYSQL_URL=mysql://user:password@host:3306/database
```

## Deploy Commands

```bash
npm i -g vercel
vercel
vercel --prod
```

Before production deploy, import the latest SQL dump into your external MySQL/MariaDB database.
