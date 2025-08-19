@echo off
echo ==========================================
echo  MAYVIS Development Sync Tool
echo ==========================================
echo.
echo Syncing changes from C:\Dev\KEEN-Mayvis to XAMPP...
echo.

xcopy "C:\Dev\KEEN-Mayvis" "C:\xampp\htdocs\mayvis" /E /Y /Q

echo.
echo ✅ Sync complete! 
echo Your modernized MAYVIS project is now available at:
echo 📧 http://localhost/mayvis
echo.
echo Press any key to exit...
pause >nul
