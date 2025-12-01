@echo off
REM ============================================
REM FishingGearPicker - Database Backup Script
REM ============================================

echo.
echo ========================================
echo   Database Backup Tool
echo ========================================
echo.

REM Get current date and time
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value') do set datetime=%%I
set TIMESTAMP=%datetime:~0,4%-%datetime:~4,2%-%datetime:~6,2%_%datetime:~8,2%h%datetime:~10,2%m%datetime:~12,2%s

REM Set backup directory
set BACKUP_DIR=database\backups
if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

REM Set backup filename
set BACKUP_FILE=%BACKUP_DIR%\backup_%TIMESTAMP%.sqlite

echo [INFO] Creating backup...
echo [INFO] Source: database\database.sqlite
echo [INFO] Destination: %BACKUP_FILE%
echo.

REM Copy the database file
copy database\database.sqlite "%BACKUP_FILE%" >nul

if %ERRORLEVEL% EQU 0 (
    echo [SUCCESS] Backup created successfully!
    echo [FILE] %BACKUP_FILE%
    
    REM Get file size
    for %%A in ("%BACKUP_FILE%") do set SIZE=%%~zA
    echo [SIZE] %SIZE% bytes
) else (
    echo [ERROR] Backup failed!
    exit /b 1
)

echo.
echo ========================================
echo   Backup Complete
echo ========================================
echo.

REM List recent backups
echo Recent backups:
dir /b /o-d "%BACKUP_DIR%\*.sqlite" | findstr /n "^" | findstr "^[1-5]:"

echo.
pause

