@echo off
SET KEY_1=JAVA_HOME
SET VAL_1=E:\WEB_APP\jdk\jdk160_x64

REM SET KEY_2=ORACLE_HOME
REM SET VAL_2=C:\app\Administrator\product\11.2.0\client_1
REM SET KEY_3=TNS_ADMIN
REM SET VAL_3=%VAL_2%\network\admin
REM SET KEY_4=NLS_LANG
REM SET VAL_4=KOREAN_KOREA.KO16KSC5601

REM SET KEY_5=ANT_HOME
REM SET VAL_5=C:\ant

call add_env_reg.bat %KEY_1% %VAL_1%
REM call add_env_reg.bat %KEY_2% %VAL_2%
REM call add_env_reg.bat %KEY_3% %VAL_3%
REM call add_env_reg.bat %KEY_4% %VAL_4%
REM call add_env_reg.bat %KEY_5% %VAL_5%
