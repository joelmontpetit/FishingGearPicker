# 💾 Database Backup System

## 🎯 Overview

System to backup and restore your SQLite database before making changes or implementing new features.

---

## 📂 Backup Location

All backups are stored in:
```
database/backups/
```

Backup filename format:
```
backup_YYYY-MM-DD_HHhMMmSSs.sqlite
```

Example: `backup_2025-11-30_15h30m45s.sqlite`

---

## 🚀 Quick Start

### 1. Create a Backup

**Windows:**
```bash
backup-db.bat
```

**Manual (if needed):**
```bash
copy database\database.sqlite database\backups\backup_manual_YYYY-MM-DD.sqlite
```

### 2. Restore a Backup

**Windows:**
```bash
restore-db.bat
```

Follow the prompts to select which backup to restore.

---

## 📋 Usage Workflow

### Before Implementing New Features

1. **Create a backup:**
   ```bash
   backup-db.bat
   ```

2. **Note the backup name** (displayed after creation)

3. **Implement your feature**

4. **If something goes wrong:**
   ```bash
   restore-db.bat
   ```

### Regular Backup Schedule

**Recommended:**
- Before adding new features
- Before major database changes
- Before testing complex queries
- Daily during active development

---

## 🛠️ Manual Backup Methods

### Method 1: Using Laravel Artisan (Recommended)

Create a custom Artisan command for backups:

```bash
php artisan make:command BackupDatabase
```

### Method 2: Using Git

Add backups to `.gitignore` but keep them locally:

```gitignore
# In .gitignore
database/backups/*
!database/backups/.gitkeep
```

### Method 3: Using Task Scheduler (Windows)

1. Open **Task Scheduler**
2. Create **New Task**
3. Set trigger (daily, weekly, etc.)
4. Action: Run `backup-db.bat`

---

## 📊 Backup Management

### List All Backups

**Windows:**
```bash
dir database\backups\*.sqlite /o-d
```

### Check Backup Size

**Windows:**
```bash
dir database\backups\*.sqlite
```

### Delete Old Backups

**Keep only last 10:**
```bash
# Manual cleanup - delete older files
```

---

## 🔄 Automated Backup Script (Advanced)

For automatic backups before migrations:

### Create: `database/backups/.gitkeep`
```bash
# Keep this directory in git
```

### Add to `.gitignore`
```gitignore
database/backups/*.sqlite
```

### Create Artisan Command

```bash
php artisan make:command BackupDatabase
```

**File:** `app/Console/Commands/BackupDatabase.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup the SQLite database';

    public function handle()
    {
        $sourceDb = database_path('database.sqlite');
        $backupDir = database_path('backups');
        
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir);
        }
        
        $timestamp = now()->format('Y-m-d_His');
        $backupFile = $backupDir . "/backup_{$timestamp}.sqlite";
        
        File::copy($sourceDb, $backupFile);
        
        $size = File::size($backupFile);
        $sizeInMB = round($size / 1024 / 1024, 2);
        
        $this->info("✅ Backup created successfully!");
        $this->info("📁 File: {$backupFile}");
        $this->info("📊 Size: {$sizeInMB} MB");
        
        return 0;
    }
}
```

**Usage:**
```bash
php artisan db:backup
```

---

## 🔧 Integration with Workflow

### Before Running Migrations

```bash
# 1. Backup
backup-db.bat

# 2. Run migration
php artisan migrate

# 3. If error, restore
restore-db.bat
```

### Before Seeding

```bash
# 1. Backup
backup-db.bat

# 2. Seed
php artisan db:seed

# 3. If needed, restore
restore-db.bat
```

### Before Major Changes

```bash
# 1. Backup with descriptive name
copy database\database.sqlite database\backups\backup_before_feature_X.sqlite

# 2. Make changes

# 3. Test

# 4. If OK, keep backup. If not, restore.
```

---

## 🗂️ Backup Retention Policy

### Suggested Strategy

**Keep:**
- Last 7 daily backups
- Last 4 weekly backups
- Last 3 monthly backups

**Delete:**
- Backups older than 3 months (unless milestone)

### Cleanup Script

Create `cleanup-old-backups.bat`:

```batch
@echo off
REM Delete backups older than 30 days
forfiles /P database\backups /S /M *.sqlite /D -30 /C "cmd /c del @path"
echo Old backups cleaned up!
pause
```

---

## 🚨 Emergency Recovery

If something goes terribly wrong:

1. **Stop the server:**
   ```bash
   # Press Ctrl+C in terminal running php artisan serve
   ```

2. **List available backups:**
   ```bash
   dir database\backups\*.sqlite /o-d
   ```

3. **Restore most recent:**
   ```bash
   restore-db.bat
   ```

4. **Or manual restore:**
   ```bash
   copy database\backups\backup_YYYY-MM-DD_HHhMMmSSs.sqlite database\database.sqlite
   ```

5. **Restart server:**
   ```bash
   php artisan serve
   ```

---

## 📈 Best Practices

### ✅ DO

- Backup before every major change
- Name backups descriptively for milestones
- Test restore process regularly
- Keep backups organized
- Document what each backup contains

### ❌ DON'T

- Don't commit backups to Git (too large)
- Don't delete all backups at once
- Don't forget to verify backup was created
- Don't skip backups for "quick changes"

---

## 🔐 Security

### Backup Files Contain

- All user data
- Passwords (hashed)
- OAuth tokens
- All application data

### Protect Your Backups

1. **Never commit to public repos**
2. **Add to `.gitignore`:**
   ```gitignore
   database/backups/*.sqlite
   ```
3. **Store securely** if backing up to cloud
4. **Encrypt** for cloud storage

---

## 📝 Backup Checklist

Before starting work:
- [ ] Create backup
- [ ] Verify backup file exists
- [ ] Note backup timestamp
- [ ] Continue with changes

After completing work:
- [ ] Test changes
- [ ] If successful, keep backup
- [ ] If failed, restore from backup
- [ ] Document what was changed

---

## 🆘 Troubleshooting

### "Database is locked"
**Solution:** Stop the Laravel server, then backup

### "Backup failed"
**Solution:** Check disk space, verify permissions

### "Cannot restore"
**Solution:** Ensure server is stopped, try manual copy

### "Backup file is empty"
**Solution:** Database might be in use, stop server first

---

## 📞 Quick Reference

| Task | Command |
|------|---------|
| Create backup | `backup-db.bat` |
| Restore backup | `restore-db.bat` |
| List backups | `dir database\backups\*.sqlite` |
| Delete old backups | `cleanup-old-backups.bat` |
| Manual copy | `copy database\database.sqlite database\backups\backup_NAME.sqlite` |

---

**Created:** November 30, 2025  
**Version:** 1.0  
**Author:** FishingGearPicker Team

