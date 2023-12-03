@echo off
SET KEY_1=JAVA_HOME
SET VAL_1=C:\Work\Java\jdk1.5.0_22

SET KEY_2=ORACLE_HOME
SET VAL_2=C:\app\Administrator\product\11.2.0\client_1
SET KEY_3=TNS_ADMIN
SET VAL_3=%VAL_2%\network\admin
SET KEY_4=NLS_LANG
SET VAL_4=KOREAN_KOREA.KO16KSC5601

SET KEY_5=ANT_HOME
SET VAL_5=C:\ant

call add_env_reg.bat %KEY_1% %VAL_1%
call add_env_reg.bat %KEY_2% %VAL_2%
call add_env_reg.bat %KEY_3% %VAL_3%
call add_env_reg.bat %KEY_4% %VAL_4%
call add_env_reg.bat %KEY_5% %VAL_5%

