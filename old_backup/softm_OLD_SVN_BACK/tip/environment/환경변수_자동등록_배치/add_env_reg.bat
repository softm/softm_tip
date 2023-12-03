@echo off
rem 출처 : http://moai.tistory.com/entry/환경변수를-자동으로-추가하자
rem * 시스템변수가 아닌 ***(로그인사용자)에 대한 사용자변수에 추가됨
 
rem echo %1 %2를 사용자 환경변수에 추가합니다.
rem reg add HKCU\Environment /v %1 /d %2

echo %1 %2를 시스템 환경변수에 추가합니다.
setx %1 %2 /M
pause
