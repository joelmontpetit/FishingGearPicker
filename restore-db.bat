@echo off
REM ============================================
REM FishingGearPicker - Database Restore Script
REM ============================================

echo.
echo ========================================
echo   Database Restore Tool
echo ========================================
echo.

REM Set backup directory
set BACKUP_DIR=database\backups

REM Check if backups exist
if not exist "%BACKUP_DIR%\*.sqlite" (
    echo [ERROR] No backups found in %BACKUP_DIR%
    echo.
    pause
    exit /b 1
)

echo Available backups:
echo.
dir /b /o-d "%BACKUP_DIR%\*.sqlite" | findstr /n "^"
echo.

set /p BACKUP_NUM="Enter backup number to restore (or 0 to cancel): "

if "%BACKUP_NUM%"=="0" (
    echo [INFO] Restore cancelled.
    pause
    exit /b 0
)

REM Get the backup file
set COUNT=0
for /f "delims=" %%F in ('dir /b /o-d "%BACKUP_DIR%\*.sqlite"') do (
    set /a COUNT+=1
    if !COUNT!==%BACKUP_NUM% set BACKUP_FILE=%%F
)

if not defined BACKUP_FILE (
    echo [ERROR] Invalid backup number!
    pause
    exit /b 1
)

echo.
echo [WARNING] This will overwrite your current database!
echo [SOURCE] %BACKUP_DIR%\%BACKUP_FILE%
echo [TARGET] database\database.sqlite
echo.
set /p CONFIRM="Are you sure? (yes/no): "

if /i not "%CONFIRM%"=="yes" (
    echo [INFO] Restore cancelled.
    pause
    exit /b 0
)

echo.
echo [INFO] Creating safety backup of current database...
copy database\database.sqlite database\database.sqlite.before_restore >nul

echo [INFO] Restoring database...
copy "%BACKUP_DIR%\%BACKUP_FILE%" database\database.sqlite >nul

if %ERRORLEVEL% EQU 0 (
    echo [SUCCESS] Database restored successfully!
    echo [FROM] %BACKUP_FILE%
) else (
    echo [ERROR] Restore failed!
    echo [INFO] Restoring previous database...
    copy database\database.sqlite.before_restore database\database.sqlite >nul
    exit /b 1
)

echo.
echo ========================================
echo   Restore Complete
echo ========================================
echo.
pause




