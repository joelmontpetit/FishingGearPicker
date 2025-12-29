<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RestoreDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore {backup? : The backup filename to restore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore the database from a backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $backupDir = database_path('backups');
        
        if (!File::isDirectory($backupDir)) {
            $this->error('No backups directory found.');
            return 1;
        }

        // Get backup filename
        $backupFilename = $this->argument('backup');
        
        if (!$backupFilename) {
            return $this->selectBackup($backupDir);
        }

        // If filename doesn't include path, assume it's in backups directory
        if (!str_contains($backupFilename, '/') && !str_contains($backupFilename, '\\')) {
            $backupPath = $backupDir . '/' . $backupFilename;
        } else {
            $backupPath = $backupFilename;
        }

        return $this->restoreBackup($backupPath);
    }

    /**
     * Interactive backup selection
     */
    protected function selectBackup($backupDir)
    {
        $backups = File::glob($backupDir . '/backup_*.sqlite');
        
        if (empty($backups)) {
            $this->error('No backups found.');
            return 1;
        }

        // Sort by modification time (newest first)
        usort($backups, function($a, $b) {
            return File::lastModified($b) - File::lastModified($a);
        });

        $this->info('Available backups:');
        $this->line('');

        $choices = [];
        foreach ($backups as $index => $backup) {
            $filename = basename($backup);
            $size = $this->formatBytes(File::size($backup));
            $created = date('Y-m-d H:i:s', File::lastModified($backup));
            $choices[$index] = "{$filename} ({$size}) - {$created}";
        }

        $selection = $this->choice(
            'Select a backup to restore',
            $choices
        );

        $selectedIndex = array_search($selection, $choices);
        $selectedBackup = $backups[$selectedIndex];

        return $this->restoreBackup($selectedBackup);
    }

    /**
     * Restore a backup
     */
    protected function restoreBackup($backupPath)
    {
        if (!File::exists($backupPath)) {
            $this->error("Backup file not found: {$backupPath}");
            return 1;
        }

        $dbPath = database_path('database.sqlite');

        // Confirm restoration
        $this->warn('⚠️  WARNING: This will replace your current database!');
        $this->line('');
        $this->line("  <fg=cyan>Current DB:</> {$dbPath}");
        $this->line("  <fg=cyan>Restore from:</> " . basename($backupPath));
        $this->line('');

        if (!$this->confirm('Do you want to continue?', false)) {
            $this->info('Restore cancelled.');
            return 0;
        }

        // Create a safety backup of current database
        $safetyBackup = database_path('backups/safety_backup_' . now()->format('Y-m-d_His') . '.sqlite');
        try {
            File::copy($dbPath, $safetyBackup);
            $this->line('  <fg=green>✓</> Safety backup created: ' . basename($safetyBackup));
        } catch (\Exception $e) {
            $this->warn('Could not create safety backup: ' . $e->getMessage());
        }

        // Restore the backup
        try {
            File::copy($backupPath, $dbPath);
            
            $this->line('');
            $this->info('✓ Database restored successfully!');
            $this->line('');
            $this->line("  <fg=cyan>Restored from:</> " . basename($backupPath));
            $this->line("  <fg=cyan>Database size:</> " . $this->formatBytes(File::size($dbPath)));
            $this->line('');
            $this->line("  <fg=yellow>Safety backup:</> " . basename($safetyBackup));
            $this->line('');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Failed to restore backup: ' . $e->getMessage());
            
            // Try to restore from safety backup
            if (File::exists($safetyBackup)) {
                $this->warn('Attempting to restore from safety backup...');
                try {
                    File::copy($safetyBackup, $dbPath);
                    $this->info('✓ Restored from safety backup');
                } catch (\Exception $e2) {
                    $this->error('Failed to restore safety backup: ' . $e2->getMessage());
                }
            }
            
            return 1;
        }
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
}
