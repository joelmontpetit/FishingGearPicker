# 💾 Database Backup System - FishingGearSetups.com

## Quick Start

### Create a Backup

**Option 1: Using Artisan (Recommended)**
```bash
php artisan db:backup
```

**Option 2: Using Batch Script (Windows)**
```bash
.\backup-db.bat
```

**With a custom label:**
```bash
php artisan db:backup --label="before-product-import"
```

---

## Available Commands

### 📦 Backup Commands

| Command | Description |
|---------|-------------|
| `php artisan db:backup` | Create a new backup with timestamp |
| `php artisan db:backup --label="my-label"` | Create backup with custom label |
| `php artisan db:backup --list` | List all available backups |
| `php artisan db:backup --clean` | Remove backups older than 30 days |

### 🔄 Restore Commands

| Command | Description |
|---------|-------------|
| `php artisan db:restore` | Interactive backup selection |
| `php artisan db:restore backup_2025-12-29_143022.sqlite` | Restore specific backup |

---

## Workflow Examples

### Before Adding Products
```bash
# Create labeled backup
php artisan db:backup --label="before-products-batch-1"

# Add your products in Filament admin...

# If something goes wrong, restore:
php artisan db:restore backup_2025-12-29_143022_before-products-batch-1.sqlite
```

### Daily Backup Routine
```bash
# Morning backup
php artisan db:backup --label="morning-$(date +%F)"

# Work on products all day...

# Evening backup
php artisan db:backup --label="evening-$(date +%F)"
```

### Before Major Changes
```bash
# Before importing 100 products
php artisan db:backup --label="before-major-import"

# Import products...

# After successful import
php artisan db:backup --label="after-major-import"
```

---

## Backup Locations

**Directory:** `database/backups/`

**Filename Format:**
- Standard: `backup_YYYY-MM-DD_HHMMSS.sqlite`
- With label: `backup_YYYY-MM-DD_HHMMSS_my-label.sqlite`

**Example:**
```
database/backups/
├── backup_2025-12-29_143022.sqlite
├── backup_2025-12-29_150530_before-products.sqlite
├── backup_2025-12-29_163045_after-products.sqlite
└── safety_backup_2025-12-29_170000.sqlite
```

---

## Features

### ✅ Automatic Safety Backup
When restoring, a safety backup of the current database is automatically created before restoration.

### ✅ Backup Metadata
Each backup shows:
- File size
- Creation date/time
- Age (e.g., "2 hours ago")
- Custom label (if provided)

### ✅ Listing Backups
```bash
php artisan db:backup --list
```

Output:
```
Available backups:

 # │ Filename                                     │ Size     │ Created              │ Age
───┼──────────────────────────────────────────────┼──────────┼──────────────────────┼──────────────
 1 │ backup_2025-12-29_163045_after-products.sqlite │ 1.25 MB  │ 2025-12-29 16:30:45  │ 2 hours ago
 2 │ backup_2025-12-29_150530_before-products.sqlite│ 856 KB   │ 2025-12-29 15:05:30  │ 3 hours ago
 3 │ backup_2025-12-29_143022.sqlite              │ 845 KB   │ 2025-12-29 14:30:22  │ 4 hours ago

Total: 3 backup(s)
```

### ✅ Cleanup Old Backups
```bash
# Remove backups older than 30 days
php artisan db:backup --clean
```

---

## Best Practices

### 1. **Before Major Operations**
Always backup before:
- Importing many products
- Bulk updating data
- Testing new features
- Database migrations

### 2. **Regular Backups**
- Daily: Before starting work
- Weekly: Keep at least one backup per week
- Monthly: Archive important milestones

### 3. **Labeling Strategy**
Use descriptive labels:
```bash
php artisan db:backup --label="before-100-bass-products"
php artisan db:backup --label="after-images-upload"
php artisan db:backup --label="milestone-v1.0"
```

### 4. **Test Restores**
Periodically test that your backups can be restored:
```bash
# Create test backup
php artisan db:backup --label="test"

# Restore it
php artisan db:restore backup_2025-12-29_test.sqlite
```

---

## Automation (Optional)

### Windows Task Scheduler

Create a daily backup at 9 AM:
```bash
schtasks /create /tn "FishingGearSetups Daily Backup" /tr "C:\laravel\fshinggearpicker\backup-db.bat" /sc daily /st 09:00
```

### Laravel Scheduler

Add to `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    // Daily backup at 9 AM
    $schedule->command('db:backup --label=auto-daily')
             ->daily()
             ->at('09:00');
    
    // Clean old backups weekly
    $schedule->command('db:backup --clean')
             ->weekly()
             ->sundays()
             ->at('03:00');
}
```

Then ensure Laravel scheduler is running:
```bash
# Add to crontab (Linux)
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## Troubleshooting

### Backup fails
```bash
# Check if database file exists
ls -la database/database.sqlite

# Check permissions
chmod 755 database/
chmod 644 database/database.sqlite
```

### Restore fails
```bash
# Safety backup is created automatically
# Check database/backups/ for safety_backup_* files

# Manually restore from safety backup
cp database/backups/safety_backup_*.sqlite database/database.sqlite
```

### Out of disk space
```bash
# Check backup sizes
php artisan db:backup --list

# Clean old backups
php artisan db:backup --clean

# Manually delete specific backups
rm database/backups/backup_old_file.sqlite
```

---

## File Sizes

Typical database sizes:
- **Empty database:** ~50 KB
- **With sample data:** ~850 KB
- **With 100 products:** ~2-3 MB
- **With 1000 products:** ~10-15 MB
- **With images (URLs only):** No significant increase

---

## Security Notes

### ⚠️ Important
- **Never commit** `database.sqlite` to Git (already in `.gitignore`)
- **Never commit** backup files to Git
- **Always backup** before deploying to production
- **Store production backups** in a secure, separate location

### Production Backups
For production, consider:
- Daily automated backups
- Off-site backup storage (AWS S3, Google Drive, etc.)
- Encrypted backups for sensitive data
- Backup retention policy (e.g., keep 30 days)

---

## Quick Reference

```bash
# Create backup
php artisan db:backup

# Create backup with label
php artisan db:backup --label="my-milestone"

# List all backups
php artisan db:backup --list

# Restore interactively
php artisan db:restore

# Restore specific file
php artisan db:restore backup_2025-12-29_143022.sqlite

# Clean old backups
php artisan db:backup --clean
```

---

**💡 Tip:** Before each product import session, run `php artisan db:backup` with a descriptive label. This way, you can always roll back if something goes wrong!

---

*Last updated: 2025-12-29*

