D:\WEB_APP\MYSQL50\bin\mysqld.exe --remove
D:\WEB_APP\MYSQL50\bin\mysqld.exe --install
net stop mysql
net start mysql

copy .\my.ini %windir%\System32
D:\WEB_APP\Apache2\bin\apache -k install

If EXIST %windir%\SysWOW64 (
    copy D:\WEB_APP\php52\libmysql.dll %windir%\SysWOW64
) Else (
    copy D:\WEB_APP\php52\libmysql.dll %windir%\System32
)
net stop apache2
net start apache2

REM D:\WEB_APP\JWAS\tomcat-553\apache-tomcat-5.5.30\bin\service.bat
REM net start "Apache Tomcat tomcat"

