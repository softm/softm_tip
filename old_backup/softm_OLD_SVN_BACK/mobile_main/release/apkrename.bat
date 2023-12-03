@echo off
set o=%~1
set t=tools
set label=mpgas_main
set version=
set src=..\bin\mpgas_main-release.apk
if "%~1"=="" set o=.

:version
for /f "tokens=1 delims=" %%a in ('%t%\aapt d badging %src% ^| %t%\grep "versionName=" ^| %t%\cut -d' -f6') do set version=%%a

if "%version%" == "" set version=0.0.0

:core
echo %label% %version%
copy /b /y %src% "%o%\%label%_%version%.apk" >nul
goto end

:end




