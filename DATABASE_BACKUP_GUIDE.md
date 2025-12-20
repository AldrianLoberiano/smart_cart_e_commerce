# SmartCart Database Backup & Restore Guide

## Quick Backup Commands

### PostgreSQL Backup

```powershell
# Full database backup
pg_dump -U postgres -d smartcart -F c -f backups/smartcart_backup_%date:~-4,4%%date:~-10,2%%date:~-7,2%.backup

# SQL format backup
pg_dump -U postgres -d smartcart -f backups/smartcart_backup.sql

# Compressed backup
pg_dump -U postgres -d smartcart | gzip > backups/smartcart_backup.sql.gz
```

### SQLite Backup

```powershell
# Copy database file
Copy-Item database/database.sqlite backups/database_backup.sqlite

# SQL dump
sqlite3 database/database.sqlite .dump > backups/smartcart_backup.sql
```

## Automated Backup Scripts

### PowerShell Backup Script (backup_database.ps1)

Save this as `backup_database.ps1`:

```powershell
# SmartCart Database Backup Script
# Run: .\backup_database.ps1

param(
    [string]$BackupType = "postgresql",  # postgresql or sqlite
    [string]$BackupPath = ".\backups"
)

# Create backup directory if it doesn't exist
if (-not (Test-Path $BackupPath)) {
    New-Item -ItemType Directory -Path $BackupPath | Out-Null
    Write-Host "Created backup directory: $BackupPath" -ForegroundColor Green
}

# Generate timestamp
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"

if ($BackupType -eq "postgresql") {
    Write-Host "Starting PostgreSQL backup..." -ForegroundColor Cyan

    # Read .env file for database credentials
    $envFile = Get-Content .env
    $dbName = ($envFile | Select-String "DB_DATABASE=(.+)").Matches.Groups[1].Value
    $dbUser = ($envFile | Select-String "DB_USERNAME=(.+)").Matches.Groups[1].Value

    if (-not $dbName) { $dbName = "smartcart" }
    if (-not $dbUser) { $dbUser = "postgres" }

    $backupFile = "$BackupPath\smartcart_backup_$timestamp.backup"
    $sqlFile = "$BackupPath\smartcart_backup_$timestamp.sql"

    # Custom format backup (recommended - smaller, faster)
    Write-Host "Creating custom format backup..." -ForegroundColor Yellow
    pg_dump -U $dbUser -d $dbName -F c -f $backupFile

    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Custom backup created: $backupFile" -ForegroundColor Green
        $size = (Get-Item $backupFile).Length / 1MB
        Write-Host "  Size: $([math]::Round($size, 2)) MB" -ForegroundColor Gray
    }

    # SQL format backup (human-readable)
    Write-Host "Creating SQL dump..." -ForegroundColor Yellow
    pg_dump -U $dbUser -d $dbName --clean --if-exists -f $sqlFile

    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ SQL dump created: $sqlFile" -ForegroundColor Green
        $size = (Get-Item $sqlFile).Length / 1MB
        Write-Host "  Size: $([math]::Round($size, 2)) MB" -ForegroundColor Gray
    }

} elseif ($BackupType -eq "sqlite") {
    Write-Host "Starting SQLite backup..." -ForegroundColor Cyan

    $sourceDb = "database\database.sqlite"
    $backupFile = "$BackupPath\database_backup_$timestamp.sqlite"

    if (Test-Path $sourceDb) {
        Copy-Item $sourceDb $backupFile
        Write-Host "✓ SQLite backup created: $backupFile" -ForegroundColor Green
        $size = (Get-Item $backupFile).Length / 1KB
        Write-Host "  Size: $([math]::Round($size, 2)) KB" -ForegroundColor Gray
    } else {
        Write-Host "✗ SQLite database not found: $sourceDb" -ForegroundColor Red
    }
}

Write-Host "`nBackup completed successfully!" -ForegroundColor Green
Write-Host "Backup location: $BackupPath" -ForegroundColor Cyan

# List recent backups
Write-Host "`nRecent backups:" -ForegroundColor Cyan
Get-ChildItem $BackupPath | Sort-Object LastWriteTime -Descending | Select-Object -First 5 | Format-Table Name, Length, LastWriteTime
```

## Restore Database

### PostgreSQL Restore

```powershell
# Restore from custom format backup
pg_restore -U postgres -d smartcart -c -F c backups/smartcart_backup.backup

# Restore from SQL dump
psql -U postgres -d smartcart -f backups/smartcart_backup.sql

# Restore to a new database
createdb -U postgres smartcart_restored
pg_restore -U postgres -d smartcart_restored -F c backups/smartcart_backup.backup
```

### SQLite Restore

```powershell
# Restore by copying file
Copy-Item backups/database_backup.sqlite database/database.sqlite -Force

# Restore from SQL dump
sqlite3 database/database.sqlite < backups/smartcart_backup.sql
```

## Scheduled Automatic Backups

### Windows Task Scheduler Setup

1. **Create the backup script** (save as `backup_database.ps1` above)

2. **Create a scheduled task:**

```powershell
# Run as Administrator
$action = New-ScheduledTaskAction -Execute "PowerShell.exe" -Argument "-NoProfile -ExecutionPolicy Bypass -File `"C:\SmartCart – Modern E-Commerce Web Application\backup_database.ps1`""

$trigger = New-ScheduledTaskTrigger -Daily -At "2:00AM"

$settings = New-ScheduledTaskSettingsSet -StartWhenAvailable -DontStopIfGoingOnBatteries

Register-ScheduledTask -TaskName "SmartCart Database Backup" -Action $action -Trigger $trigger -Settings $settings -Description "Daily backup of SmartCart database"
```

3. **Verify the task:**

```powershell
Get-ScheduledTask -TaskName "SmartCart Database Backup"
```

## Laravel Backup Commands

### Create Custom Artisan Command

Create `app/Console/Commands/BackupDatabase.php`:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup {--format=sql}';
    protected $description = 'Backup the database';

    public function handle()
    {
        $format = $this->option('format');
        $timestamp = now()->format('Y-m-d_His');
        $connection = config('database.default');

        $this->info("Creating {$connection} database backup...");

        if ($connection === 'pgsql') {
            $this->backupPostgres($timestamp, $format);
        } elseif ($connection === 'sqlite') {
            $this->backupSqlite($timestamp);
        }

        $this->info('Backup completed successfully!');
    }

    private function backupPostgres($timestamp, $format)
    {
        $database = config('database.connections.pgsql.database');
        $username = config('database.connections.pgsql.username');
        $filename = "smartcart_backup_{$timestamp}." . ($format === 'custom' ? 'backup' : 'sql');
        $path = storage_path("backups/{$filename}");

        if (!file_exists(storage_path('backups'))) {
            mkdir(storage_path('backups'), 0755, true);
        }

        $formatFlag = $format === 'custom' ? '-F c' : '';
        $command = "pg_dump -U {$username} -d {$database} {$formatFlag} -f {$path}";

        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            $size = filesize($path) / 1024 / 1024;
            $this->info("✓ Backup saved: {$filename} (" . round($size, 2) . " MB)");
        }
    }

    private function backupSqlite($timestamp)
    {
        $source = database_path('database.sqlite');
        $filename = "database_backup_{$timestamp}.sqlite";
        $destination = storage_path("backups/{$filename}");

        if (!file_exists(storage_path('backups'))) {
            mkdir(storage_path('backups'), 0755, true);
        }

        copy($source, $destination);

        $size = filesize($destination) / 1024;
        $this->info("✓ Backup saved: {$filename} (" . round($size, 2) . " KB)");
    }
}
```

### Register the command in `app/Console/Kernel.php`:

```php
protected $commands = [
    Commands\BackupDatabase::class,
];

protected function schedule(Schedule $schedule)
{
    // Backup database daily at 2 AM
    $schedule->command('db:backup')->dailyAt('02:00');
}
```

### Run backup manually:

```powershell
php artisan db:backup
php artisan db:backup --format=custom
```

## Backup Best Practices

### 1. Backup Frequency

- **Production**: Daily automated backups
- **Development**: Before major changes
- **Before migrations**: Always backup

### 2. Retention Policy

```powershell
# Delete backups older than 30 days
Get-ChildItem backups -Filter "*.backup" | Where-Object { $_.LastWriteTime -lt (Get-Date).AddDays(-30) } | Remove-Item

# Keep only last 10 backups
Get-ChildItem backups -Filter "*.backup" | Sort-Object LastWriteTime -Descending | Select-Object -Skip 10 | Remove-Item
```

### 3. Verify Backups

```powershell
# Test PostgreSQL backup
pg_restore --list backups/smartcart_backup.backup

# Verify SQLite backup
sqlite3 backups/database_backup.sqlite "SELECT COUNT(*) FROM products;"
```

### 4. Store Backups Offsite

- Copy to cloud storage (AWS S3, Azure Blob, Google Drive)
- Use version control for SQL dumps
- Encrypt sensitive backups

## Quick Reference

```powershell
# Create backup
.\backup_database.ps1 -BackupType postgresql

# Restore latest backup
$latest = Get-ChildItem backups\*.backup | Sort-Object LastWriteTime -Descending | Select-Object -First 1
pg_restore -U postgres -d smartcart -c -F c $latest.FullName

# List all backups
Get-ChildItem backups | Sort-Object LastWriteTime -Descending | Format-Table Name, Length, LastWriteTime

# Export as SQL for version control
pg_dump -U postgres -d smartcart --schema-only -f database_schema.sql
pg_dump -U postgres -d smartcart --data-only -f database_data.sql

# Backup before migration
php artisan db:backup
php artisan migrate

# Rollback if needed
php artisan migrate:rollback
# Then restore from backup
```

## Troubleshooting

### Error: "pg_dump: command not found"

Add PostgreSQL to PATH:

```powershell
$env:Path += ";C:\Program Files\PostgreSQL\16\bin"
```

### Error: "Access denied"

Run PowerShell as Administrator for scheduled tasks.

### Large Database Backups

Use compressed backups:

```powershell
pg_dump -U postgres -d smartcart | gzip > backups/smartcart.sql.gz
```

Restore:

```powershell
gunzip -c backups/smartcart.sql.gz | psql -U postgres -d smartcart
```
