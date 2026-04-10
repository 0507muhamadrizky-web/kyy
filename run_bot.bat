@echo off
echo Starting Telegram Bot Polling...
echo Press Ctrl+C to stop.
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan telegram:poll
pause
