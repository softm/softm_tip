@echo off
rem ��ó : http://moai.tistory.com/entry/ȯ�溯����-�ڵ�����-�߰�����
rem * �ý��ۺ����� �ƴ� ***(�α��λ����)�� ���� ����ں����� �߰���
 
rem echo %1 %2�� ����� ȯ�溯���� �߰��մϴ�.
rem reg add HKCU\Environment /v %1 /d %2

echo %1 %2�� �ý��� ȯ�溯���� �߰��մϴ�.
setx %1 %2 /M
pause
