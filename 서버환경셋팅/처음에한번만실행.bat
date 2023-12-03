C:\WEB_APP\MYSQL50\bin\mysqld.exe --remove
C:\WEB_APP\MYSQL50\bin\mysqld.exe --install
net stop mysql
net start mysql

apache -k install
copy c:\WEB_APP\php52\php.ini %SystemDrive%\WINDOWS
copy c:\WEB_APP\php52\libmysql.dll %SystemDrive%\WINDOWS\System32

C:\WEB_APP\JWAS\tomcat-553\apache-tomcat-5.5.30\bin\service.bat
net start "Apache Tomcat tomcat"