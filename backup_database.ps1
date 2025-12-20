# SmartCart Database Backup Script
# Run: .\backup_database.ps1
# Examples:
#   .\backup_database.ps1                          # Backup PostgreSQL
#   .\backup_database.ps1 -BackupType sqlite       # Backup SQLite
#   .\backup_database.ps1 -BackupPath "D:\Backups" # Custom backup location

param(
    [string]$BackupType = "postgresql",  # postgresql or sqlite
    [string]$BackupPath = ".\backups"
)

Write-Host "`n=== SmartCart Database Backup ===" -ForegroundColor Cyan
Write-Host "Type: $BackupType" -ForegroundColor Gray
Write-Host "Time: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')" -ForegroundColor Gray
Write-Host ""

# Create backup directory if it doesn't exist
if (-not (Test-Path $BackupPath)) {
    New-Item -ItemType Directory -Path $BackupPath | Out-Null
    Write-Host "✓ Created backup directory: $BackupPath" -ForegroundColor Green
}

# Generate timestamp
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"

if ($BackupType -eq "postgresql") {
    Write-Host "Starting PostgreSQL backup..." -ForegroundColor Yellow
    
    # Read .env file for database credentials
    if (Test-Path .env) {
        $envContent = Get-Content .env -Raw
        $dbName = if ($envContent -match 'DB_DATABASE=(.+)') { $matches[1].Trim() } else { "smartcart" }
        $dbUser = if ($envContent -match 'DB_USERNAME=(.+)') { $matches[1].Trim() } else { "postgres" }
    }
    else {
        $dbName = "smartcart"
        $dbUser = "postgres"
        Write-Host "⚠ .env file not found, using defaults" -ForegroundColor Yellow
    }
    
    Write-Host "Database: $dbName" -ForegroundColor Gray
    Write-Host "User: $dbUser" -ForegroundColor Gray
    Write-Host ""
    
    # Check if pg_dump exists
    try {
        $null = Get-Command pg_dump -ErrorAction Stop
    }
    catch {
        Write-Host "✗ Error: pg_dump not found in PATH" -ForegroundColor Red
        Write-Host "Add PostgreSQL to PATH: `$env:Path += ';C:\Program Files\PostgreSQL\16\bin'" -ForegroundColor Yellow
        exit 1
    }
    
    # Custom format backup (compressed, faster restore)
    $backupFile = "$BackupPath\smartcart_backup_$timestamp.backup"
    Write-Host "Creating custom format backup..." -ForegroundColor Cyan
    Write-Host "File: $backupFile" -ForegroundColor Gray
    
    $env:PGPASSWORD = Read-Host "Enter PostgreSQL password" -AsSecureString | ConvertFrom-SecureString -AsPlainText
    pg_dump -U $dbUser -d $dbName -F c -f $backupFile 2>&1 | Out-Null
    
    if ($LASTEXITCODE -eq 0) {
        $size = (Get-Item $backupFile).Length / 1MB
        Write-Host "✓ Custom backup created successfully" -ForegroundColor Green
        Write-Host "  Size: $([math]::Round($size, 2)) MB" -ForegroundColor Gray
        Write-Host ""
    }
    else {
        Write-Host "✗ Custom backup failed" -ForegroundColor Red
        exit 1
    }
    
    # SQL format backup (human-readable)
    $sqlFile = "$BackupPath\smartcart_backup_$timestamp.sql"
    Write-Host "Creating SQL dump..." -ForegroundColor Cyan
    Write-Host "File: $sqlFile" -ForegroundColor Gray
    
    pg_dump -U $dbUser -d $dbName --clean --if-exists -f $sqlFile 2>&1 | Out-Null
    
    if ($LASTEXITCODE -eq 0) {
        $size = (Get-Item $sqlFile).Length / 1MB
        Write-Host "✓ SQL dump created successfully" -ForegroundColor Green
        Write-Host "  Size: $([math]::Round($size, 2)) MB" -ForegroundColor Gray
    }
    else {
        Write-Host "⚠ SQL dump failed (custom backup is still available)" -ForegroundColor Yellow
    }
    
}
elseif ($BackupType -eq "sqlite") {
    Write-Host "Starting SQLite backup..." -ForegroundColor Yellow
    
    $sourceDb = "database\database.sqlite"
    
    if (-not (Test-Path $sourceDb)) {
        Write-Host "✗ SQLite database not found: $sourceDb" -ForegroundColor Red
        exit 1
    }
    
    $backupFile = "$BackupPath\database_backup_$timestamp.sqlite"
    Write-Host "File: $backupFile" -ForegroundColor Gray
    Write-Host ""
    
    try {
        Copy-Item $sourceDb $backupFile -Force
        $size = (Get-Item $backupFile).Length / 1KB
        Write-Host "✓ SQLite backup created successfully" -ForegroundColor Green
        Write-Host "  Size: $([math]::Round($size, 2)) KB" -ForegroundColor Gray
    }
    catch {
        Write-Host "✗ Backup failed: $_" -ForegroundColor Red
        exit 1
    }
    
}
else {
    Write-Host "✗ Invalid backup type: $BackupType" -ForegroundColor Red
    Write-Host "Use: postgresql or sqlite" -ForegroundColor Yellow
    exit 1
}

Write-Host "`n=== Backup Completed Successfully ===" -ForegroundColor Green
Write-Host "Location: $BackupPath" -ForegroundColor Cyan
Write-Host ""

# List recent backups
Write-Host "Recent backups:" -ForegroundColor Cyan
Get-ChildItem $BackupPath -File | 
Sort-Object LastWriteTime -Descending | 
Select-Object -First 10 | 
Format-Table @{
    Label = "Filename"; Expression = { $_.Name }; Width = 50
}, @{
    Label = "Size"; Expression = {
        if ($_.Length -gt 1MB) { "$([math]::Round($_.Length/1MB, 2)) MB" }
        else { "$([math]::Round($_.Length/1KB, 2)) KB" }
    }; Width = 15
}, @{
    Label = "Created"; Expression = { $_.LastWriteTime.ToString("yyyy-MM-dd HH:mm:ss") }; Width = 20
}

Write-Host "`nTo restore this backup:" -ForegroundColor Yellow
if ($BackupType -eq "postgresql") {
    Write-Host "pg_restore -U $dbUser -d $dbName -c -F c $backupFile" -ForegroundColor Gray
}
else {
    Write-Host "Copy-Item $backupFile database\database.sqlite -Force" -ForegroundColor Gray
}
Write-Host ""
