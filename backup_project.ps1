# Laravel Project Backup Script (Inspired by Video #24)
# This script clears the cache and zips the source code.

Write-Host "--- Starting Backup Process ---" -ForegroundColor Cyan

# 1. Clear Cache
Write-Host "1. Clearing Laravel Cache..." -ForegroundColor Yellow
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan optimize

# 2. Define Backup Name
$date = Get-Date -Format "yyyyMMdd_HHmm"
$backupName = "realestate_backup_$date.zip"
$destination = Join-Path (Get-Item .).Parent.FullName $backupName

# 3. Create Zip
Write-Host "2. Creating Zip archive at $destination ..." -ForegroundColor Yellow
Write-Host "   (Excluding vendor, node_modules, and .git to keep it small)" -ForegroundColor Gray

Compress-Archive -Path . -DestinationPath $destination -Force -Exclude "vendor", "node_modules", ".git", "storage/framework/cache/*", "storage/framework/sessions/*", "storage/framework/views/*"

Write-Host "--- Backup Complete! ---" -ForegroundColor Green
Write-Host "Source backup saved to: $destination"
Write-Host "IMPORTANT: Please remember to export your database (SQL file) manually via PHPMyAdmin as shown in the video!" -ForegroundColor Cyan
