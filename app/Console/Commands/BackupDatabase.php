<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup 
                            {--label= : Optional label for the backup (e.g., "before-product-import")}
                            {--list : List all available backups}
                            {--clean : Remove backups older than 30 days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backup of the SQLite database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // List backups
        if ($this->option('list')) {
            return $this->listBackups();
        }

        // Clean old backups
        if ($this->option('clean')) {
            return $this->cleanOldBackups();
        }

        // Create backup
        return $this->createBackup();
    }

    /**
     * Create a database backup
     */
    protected function createBackup()
    {
        $dbPath = database_path('database.sqlite');
        
        if (!File::exists($dbPath)) {
            $this->error('Database file not found: ' . $dbPath);
            return 1;
        }

        // Create backups directory if it doesn't exist
        $backupDir = database_path('backups');
        if (!File::isDirectory($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        // Generate backup filename
        $timestamp = now()->format('Y-m-d_His');
        $label = $this->option('label');
        $filename = $label 
            ? "backup_{$timestamp}_{$label}.sqlite"
            : "backup_{$timestamp}.sqlite";
        
        $backupPath = $backupDir . '/' . $filename;

        // Copy the database file
        try {
            File::copy($dbPath, $backupPath);
            
            $fileSize = $this->formatBytes(File::size($backupPath));
            
            $this->info('✓ Backup created successfully!');
            $this->line('');
            $this->line("  <fg=cyan>File:</> {$filename}");
            $this->line("  <fg=cyan>Size:</> {$fileSize}");
            $this->line("  <fg=cyan>Path:</> {$backupPath}");
            $this->line('');
            
            // Show backup count
            $backupCount = count(File::glob($backupDir . '/backup_*.sqlite'));
            $this->line("  <fg=yellow>Total backups:</> {$backupCount}");
            $this->line('');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Failed to create backup: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * List all available backups
     */
    protected function listBackups()
    {
        $backupDir = database_path('backups');
        
        if (!File::isDirectory($backupDir)) {
            $this->warn('No backups directory found.');
            return 0;
        }

        $backups = File::glob($backupDir . '/backup_*.sqlite');
        
        if (empty($backups)) {
            $this->warn('No backups found.');
            return 0;
        }

        // Sort by modification time (newest first)
        usort($backups, function($a, $b) {
            return File::lastModified($b) - File::lastModified($a);
        });

        $this->info('Available backups:');
        $this->line('');

        $headers = ['#', 'Filename', 'Size', 'Created', 'Age'];
        $rows = [];

        foreach ($backups as $index => $backup) {
            $filename = basename($backup);
            $size = $this->formatBytes(File::size($backup));
            $modified = File::lastModified($backup);
            $created = date('Y-m-d H:i:s', $modified);
            $age = $this->getAge($modified);

            $rows[] = [
                $index + 1,
                $filename,
                $size,
                $created,
                $age
            ];
        }

        $this->table($headers, $rows);
        $this->line('');
        $this->line("  <fg=yellow>Total:</> " . count($backups) . " backup(s)");
        $this->line('');
        $this->line("  <fg=cyan>To restore:</> php artisan db:restore <filename>");
        $this->line("  <fg=cyan>To clean old:</> php artisan db:backup --clean");
        $this->line('');

        return 0;
    }

    /**
     * Clean old backups (older than 30 days)
     */
    protected function cleanOldBackups()
    {
        $backupDir = database_path('backups');
        
        if (!File::isDirectory($backupDir)) {
            $this->warn('No backups directory found.');
            return 0;
        }

        $backups = File::glob($backupDir . '/backup_*.sqlite');
        $thirtyDaysAgo = now()->subDays(30)->timestamp;
        $deleted = 0;

        foreach ($backups as $backup) {
            if (File::lastModified($backup) < $thirtyDaysAgo) {
                File::delete($backup);
                $deleted++;
                $this->line("  <fg=red>Deleted:</> " . basename($backup));
            }
        }

        if ($deleted === 0) {
            $this->info('No old backups to clean (keeping backups from last 30 days)');
        } else {
            $this->info("✓ Cleaned {$deleted} old backup(s)");
        }

        return 0;
    }

    /**
     * Format bytes to human-readable format
     */
    protected function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Get human-readable age
     */
    protected function getAge($timestamp)
    {
        $diff = time() - $timestamp;
        
        if ($diff < 60) {
            return $diff . ' sec ago';
        } elseif ($diff < 3600) {
            return floor($diff / 60) . ' min ago';
        } elseif ($diff < 86400) {
            return floor($diff / 3600) . ' hours ago';
        } else {
            return floor($diff / 86400) . ' days ago';
        }
    }
}
