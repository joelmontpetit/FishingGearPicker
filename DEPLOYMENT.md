# 🚀 Deployment Guide - FishingGearPicker

## Production Deployment Checklist

### Pre-Deployment

#### 1. Environment Configuration
Update your `.env` file for production:

```env
APP_NAME=FishingGearPicker
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Generate a new key
APP_KEY=

# Database (PostgreSQL recommended for production)
DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_PORT=5432
DB_DATABASE=fishinggear_prod
DB_USERNAME=your-username
DB_PASSWORD=strong-password

# Cache & Sessions
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@fishinggear.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### 2. Security Updates

**Change Admin Credentials**
```bash
php artisan tinker
>>> $user = User::where('email', 'admin@fishinggear.com')->first();
>>> $user->email = 'your-secure-email@domain.com';
>>> $user->password = Hash::make('your-secure-password');
>>> $user->save();
```

**Generate Application Key**
```bash
php artisan key:generate
```

### Server Requirements

- PHP 8.2 or higher
- Composer 2.x
- Node.js 18+ & NPM
- PostgreSQL 14+ (or MySQL 8+)
- Redis (recommended for caching)
- Nginx or Apache
- SSL Certificate (Let's Encrypt)

### Deployment Steps

#### Option 1: Traditional Server (VPS/Dedicated)

**1. Clone Repository**
```bash
cd /var/www
git clone your-repo-url fishinggear
cd fishinggear
```

**2. Install Dependencies**
```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

**3. Set Permissions**
```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

**4. Run Migrations**
```bash
php artisan migrate --force
php artisan db:seed --force  # Only first time
```

**5. Optimize for Production**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

**6. Configure Web Server**

**Nginx Configuration** (`/etc/nginx/sites-available/fishinggear`):
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/fishinggear/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable the site:
```bash
ln -s /etc/nginx/sites-available/fishinggear /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

**7. Set Up SSL**
```bash
certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

**8. Configure Supervisor for Queue Workers**

Create `/etc/supervisor/conf.d/fishinggear-worker.conf`:
```ini
[program:fishinggear-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/fishinggear/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/fishinggear/storage/logs/worker.log
stopwaitsecs=3600
```

Start supervisor:
```bash
supervisorctl reread
supervisorctl update
supervisorctl start fishinggear-worker:*
```

#### Option 2: Laravel Forge

1. Create new server on Forge
2. Connect your repository
3. Configure environment variables
4. Enable Quick Deploy
5. Deploy!

Forge handles:
- SSL certificates
- Queue workers
- Scheduled tasks
- Database backups

#### Option 3: Laravel Vapor (Serverless)

1. Install Vapor CLI: `composer require laravel/vapor-cli`
2. Configure `vapor.yml`
3. Deploy: `vapor deploy production`

### Post-Deployment

#### 1. Set Up Scheduled Tasks

Add to crontab (`crontab -e`):
```bash
* * * * * cd /var/www/fishinggear && php artisan schedule:run >> /dev/null 2>&1
```

#### 2. Configure Backups

Install Laravel Backup:
```bash
composer require spatie/laravel-backup
php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
```

Configure in `config/backup.php` and schedule:
```php
// In App\Console\Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('backup:clean')->daily()->at('01:00');
    $schedule->command('backup:run')->daily()->at('02:00');
}
```

#### 3. Monitoring

**Application Monitoring**
- Install Laravel Telescope (dev only)
- Set up error tracking (Sentry, Bugsnag, etc.)
- Configure uptime monitoring (Pingdom, UptimeRobot)

**Server Monitoring**
- CPU/Memory usage
- Disk space
- Database performance
- Queue status

#### 4. Performance Optimization

**Enable OPcache** (`/etc/php/8.2/fpm/php.ini`):
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.validate_timestamps=0
opcache.revalidate_freq=0
```

**Redis Configuration**:
```bash
# Install Redis
apt-get install redis-server
systemctl enable redis-server
```

**Database Optimization**:
- Enable query caching
- Add appropriate indexes
- Regular VACUUM (PostgreSQL)

### Continuous Deployment

#### GitHub Actions Example

Create `.github/workflows/deploy.yml`:
```yaml
name: Deploy to Production

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Deploy to server
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.HOST }}
          username: ${{ secrets.USERNAME }}
          key: ${{ secrets.SSH_KEY }}
          script: |
            cd /var/www/fishinggear
            git pull origin main
            composer install --no-dev --optimize-autoloader
            npm install
            npm run build
            php artisan migrate --force
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
            php artisan queue:restart
```

### Database Migration Strategy

**Zero-Downtime Deployments**:
1. Always make migrations backward compatible
2. Use database transactions
3. Test migrations on staging first
4. Have rollback plan ready

```bash
# Before deployment
php artisan migrate --pretend

# During deployment
php artisan migrate --force

# If issues occur
php artisan migrate:rollback --step=1
```

### Rollback Procedure

```bash
# 1. Revert code
git checkout previous-stable-tag
composer install --no-dev
npm run build

# 2. Rollback database if needed
php artisan migrate:rollback

# 3. Clear caches
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Restart services
php artisan queue:restart
supervisorctl restart fishinggear-worker:*
```

### Security Hardening

1. **Disable Directory Listing**
2. **Hide Laravel Version** (remove from headers)
3. **Rate Limiting** (already configured in Laravel)
4. **CSRF Protection** (enabled by default)
5. **SQL Injection Protection** (use Eloquent)
6. **XSS Protection** (Blade escaping)
7. **Regular Updates**: `composer update` monthly

### Performance Benchmarks

Target metrics:
- **Page Load**: < 2 seconds
- **TTFB**: < 500ms
- **Database Queries**: < 50ms average
- **API Response**: < 100ms

### Support & Maintenance

**Regular Tasks**:
- Weekly: Review error logs
- Monthly: Update dependencies
- Quarterly: Security audit
- Yearly: Performance review

**Monitoring Checklist**:
- [ ] Server uptime
- [ ] Error rates
- [ ] Response times
- [ ] Database size
- [ ] Disk space
- [ ] SSL certificate expiry

---

## Quick Commands Reference

```bash
# Deploy updates
git pull && composer install --no-dev && npm run build && php artisan migrate --force && php artisan optimize

# Clear everything
php artisan optimize:clear

# Check application health
php artisan about

# View logs
tail -f storage/logs/laravel.log

# Database backup
php artisan backup:run

# Queue status
php artisan queue:work --once

# Restart workers
php artisan queue:restart
```

---

**🎣 Your FishingGearPicker is now production-ready!**

For issues, check logs in `storage/logs/` or enable debug mode temporarily.

