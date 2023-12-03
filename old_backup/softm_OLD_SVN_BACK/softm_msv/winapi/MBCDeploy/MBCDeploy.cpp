// MBCDeploy.cpp : Defines the entry point for the application.
//

#include "stdafx.h"
#include <windows.h>
#include <stdio.h>
#include "winreg.h"
#include "wininet.h"
#pragma comment(lib,"wininet.lib")
#include <shellapi.h>
int APIENTRY WinMain(HINSTANCE hInstance,HINSTANCE hPrevInstance
		  ,LPSTR lpszCmdParam,int nCmdShow)
{

	LONG error = 0;
	HKEY hKey;
	DWORD dwDisp;
    //DWORD dwData;
	char lpMsg[] = "설치가 완료되었습니다.";
	char lpDefaultIcon[] = "alert.exe,1";
	char lpCommand[] = "\"c:\\alert.exe\" \"%1\"";

	RegDeleteKey(HKEY_CLASSES_ROOT,"mbcp");
	// 먼저 만들려는 키가 이미 존재하는 것인지 살펴본다.
	error = RegOpenKeyEx(HKEY_CLASSES_ROOT, "mbcp",0, KEY_ALL_ACCESS, &hKey);

	if (error == ERROR_SUCCESS) // 없다면 새로 생성한다.
	{
		RegDeleteKey(HKEY_CLASSES_ROOT,"mbcp");
	}
	
			// 키를 생성한다.
			error = RegCreateKeyEx(HKEY_CLASSES_ROOT,"mbcp", 0, "REG_BINARY",REG_OPTION_NON_VOLATILE, KEY_ALL_ACCESS, 0, &hKey, &dwDisp);
			/*
			if ( error == NULL ) {
				wsprintf(lpMsg,"에러1 : %d",  GetLastError());
				MessageBox(NULL, lpMsg, "에러", MB_OK);
			}
			*/
   			        error = RegSetValueEx( hKey, "URL Protocol", 0, REG_SZ, NULL, 0);

			// 위의 키 밑에 Type이란 DWORD 타입의 값을 만들고 1로 초기화
			//dwData = 0x1;
			//error = RegSetValueEx( hKey, "Type", 0, REG_DWORD,&dwData,4);

			// 위의 키 밑에 Group이란 문자열 타입의 값을 만들고 lpDefaultIcon의 값으로 초기화

			error = RegCreateKeyEx(HKEY_CLASSES_ROOT,"mbcp\\DefaultIcon", 0, "REG_BINARY",REG_OPTION_NON_VOLATILE, KEY_ALL_ACCESS, 0, &hKey, &dwDisp);
			        error = RegSetValueEx( hKey, "", 0, REG_SZ, (const unsigned char *)lpDefaultIcon, strlen(lpDefaultIcon)*2);

			error = RegCreateKeyEx(HKEY_CLASSES_ROOT,"mbcp\\shell\\open\\command", 0, "REG_BINARY",REG_OPTION_NON_VOLATILE, KEY_ALL_ACCESS, 0, &hKey, &dwDisp);
			        error = RegSetValueEx( hKey, "", 0, REG_SZ, (const unsigned char *)lpCommand, strlen(lpCommand)*2);

			// 키를 닫는다.
			RegCloseKey(hKey);
	
   //InternetSetCookie("http://127.0.0.1","installed","install");
   //InternetSetCookie(lpMsg,NULL,NULL);
   //InternetSetCookie(TEXT("http://127.0.0.1"), "MyCookie",TEXT("installed = install"));
       //BOOL bresult;
   //bresult = InternetSetCookie(TEXT("http://127.0.0.1"), TEXT("installed"), TEXT("installed = install"));

       //if ( bresult == FALSE ) 
				
    BOOL bresult;

    bresult = InternetSetCookie("http://192.168.184.1", NULL,
                                 "installed = install; expires=Fri, 31 Dec 9999 23:59:59 GMT");

    bresult = InternetSetCookie("http://192.168.11.3", NULL,
                                 "installed = install; expires=Fri, 31 Dec 9999 23:59:59 GMT");

    if ( bresult == FALSE )  {
		wsprintf(lpMsg,"에러 : %d",  GetLastError());
		MessageBox(NULL, lpMsg, "에러", MB_OK);
	}
    else MessageBox(NULL, lpMsg, "완료~~~~", MB_OK);

	// ie만 지원할 경우 필요 없음.
	//ShellExecute(NULL, "open", "http://192.168.184.1:8080/test_java/file_download_install_end.jsp", "", "", SW_HIDE);

	ShellExecute(NULL, "open", "http://192.168.11.3:8080/test_java/file_download_install_end.jsp", "", "", SW_HIDE);
	return 1;
}


LRESULT CALLBACK WndProc(HWND hWnd,UINT iMessage,WPARAM wParam,LPARAM lParam)
 {
     switch(iMessage) {
     case WM_DESTROY:
         FreeConsole();
         PostQuitMessage(0);
         return 0;
     case WM_CREATE:
         AllocConsole();
		 MessageBox(NULL, NULL, "CmdParam", MB_OK);
         printf("Hello, World! in Win32 API Application...\n");
         return 0;
     }
     return(DefWindowProc(hWnd,iMessage,wParam,lParam));
 }