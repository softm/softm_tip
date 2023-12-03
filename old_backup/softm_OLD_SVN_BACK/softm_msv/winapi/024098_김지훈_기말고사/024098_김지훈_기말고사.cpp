// 024098_������_�⸻���.cpp
//
// ���� ���� �⸻��� ����

#include <windows.h> //�������� ���α׷��� �ۼ��ϴµ� �ʿ��� ����ü,
                     // ���� API �Լ�, ��ũ��, �޽��� ���� ����� ��� ���Ϸ�
                     // �������� ���α׷��� �ݵ�� �����ؾ� �Ѵ�.
#include "resource.h" //�������� ���α׷��� �ۼ��ϴµ� �ʿ��� ����ü,
#include <mmsystem.h>
//#include <math.h>

HINSTANCE g_hInst;   // �ν��Ͻ� �ڵ��� �����ϱ� ���� ���� ����
                     // ������ ���ν��� ����
HWND	  g_hWnd;

void SetItem(HWND);
void ReadValue (HWND);
void DisplayEnergy();
void DisplayHit   ();
void    CALLBACK TimerProc (HWND, UINT, UINT_PTR, DWORD );
BOOL    CALLBACK DialogProc(HWND, UINT, WPARAM  , LPARAM);
LRESULT CALLBACK WndProc   (HWND, UINT, WPARAM  , LPARAM);

/* ------------------------- ���� ���� ------------------------- */
static char player_A[20], player_B[20]; // ���� �̸�
static int  prob_A, prob_B            ; // Ȯ��
static int  att_A , att_B             ; // ����
static int  curAtt_A, curAtt_B		  ; // ���� ����

static int  sumHit_A, sumHit_B        ; // �� ���� �հ�

static int  rndHit_A, rndHit_B        ; // ���� ���� �հ�

static int  round                     ; // ����
static int  roundTime                 ; // ���� ��
static int  maxRound                  ; // �� ���� ��
static int  maxHit                    ; // ���� �� ���ݼ�
static int  restTime	              ; // ������ �޽� �ð�
static int  chkRestTime               ; // �޽� �ð� üũ
static POINT point = {280,0}          ; // ��� ��ǥ

int    resultY = 0                    ; // ��� ��� ��ǥ Y��

// �������� ���ν��� (Window Procedure) �� ���� ����
// WinMain() : �������� ���ø����̼��� ������(Entry Point)
// ���⼭ ���α׷��� �����Ѵ�.
// �ֱܼ�� C���α׷��� main()�� �ش��Ѵ�.
int APIENTRY WinMain(HINSTANCE hInstance,
					 HINSTANCE hpreInstance,
					 LPSTR szCmdLine, 
					 int nCmdShow) 
{
	static char szClassName[] = "024098_������_�߰����"     ;
	static char szTitle[]     = "�ȳ��ϼ��� - 024098 - ������ �Դϴ�.";
	MSG        msg ; // �޽��� ����ü
    HWND       hWnd; // ������ �ڵ�
	WNDCLASSEX wc  ; // ������ Ŭ���� ����ü

	g_hInst = hInstance; // �ν��Ͻ� �ڵ� ����
	
/*** 1. ������ ����ü�� ���� �����Ѵ�. ***/
    wc.cbSize=sizeof(WNDCLASSEX)              ; //������ Ŭ���� ����ü�� ũ��
	wc.style         = CS_HREDRAW | CS_VREDRAW; // Ŭ���� ��Ÿ��
	wc.lpfnWndProc   = WndProc                ; // ������ ���ν��� ����
	wc.cbClsExtra    = 0                      ; // ������ Ŭ���� ������ ����
	wc.cbWndExtra    = 0                      ; // ������ ������ ����
    wc.hInstance     = hInstance              ; // �ν��Ͻ� �ڵ�
	wc.hIcon         = LoadIcon(hInstance,MAKEINTRESOURCE(IDI_ICON1))    ; // ������ �ڵ�
    wc.hCursor       = LoadCursor(hInstance,MAKEINTRESOURCE(IDC_CURSOR1))        ; // ����� Ŀ�� �ڵ�
    wc.hbrBackground =(HBRUSH)GetStockObject(WHITE_BRUSH); // ������ �귯�� �ڵ�
    wc.lpszMenuName  = MAKEINTRESOURCE(IDR_MENU1)        ; // �޴� �̸�
    wc.lpszClassName = szClassName                       ; // ������ Ŭ���� �̸�
    wc.hIconSm       = LoadIcon(hInstance,MAKEINTRESOURCE(IDI_ICON1))    ; // ���� ������ �ڵ�

/*** 2. ������ Ŭ������ ����Ѵ�. ***/    
    RegisterClassEx(&wc);
    
/*** 3. ������ �����츦 �����Ѵ�. ***/        
	hWnd = CreateWindow( 
		                 szClassName,           // registered class name           
		                 szTitle,               // window name                     
						 WS_OVERLAPPEDWINDOW,   // window style                    
						 0,						// horizontal position of window   
						 0,						// vertical position of window     
                         800,					// window width                    
						 600,					// window height                   
						 NULL,                  // handle to parent or owner window
						 NULL,                  // menu handle or child identifier 
						 hInstance,             // handle to application instance  
						 NULL                   // window-creation data
           );
	if ( !hWnd ) return (FALSE); //������ ������ �����ϸ� ���α׷��� ���� �մϴ�.

	g_hWnd = hWnd;

/*** 4. ������ �����츦 ȭ�鿡 ��Ÿ����. ***/
    ShowWindow(hWnd,nCmdShow); // �����츦 ȭ�鿡 ��Ÿ����.
    UpdateWindow(hWnd)       ; // �������� Ŭ���̾�Ʈ ������ ĥ�Ѵ�.
	//ShowWindow(hWnd,SW_HIDE);

/*** 5. �޽��� ����:������ ���� �޽��� ť�κ��� �޽����� ���� ó���Ѵ�. ***/
	while( GetMessage(&msg,NULL,0,0) )
	{
		TranslateMessage( &msg );
		DispatchMessage( &msg );
	}

	return msg.wParam;
}

/*--------------------------------------------------------------
 �Լ���    : SetItem
 �ƱԸ�Ʈ1 : HWND hDlg
             handle to dialog box
 ���      : ���ӿ� �̿�� ���� ��ȭ������ �Ӽ����� �Ҵ��մϴ�.
---------------------------------------------------------------*/
void SetItem(HWND hDlg) {
      /* �Ѱ� �� ���� */
      SendMessage(GetDlgItem(hDlg,IDC_ROUND     ),EM_LIMITTEXT,(WPARAM) 2,0);
      SendMessage(GetDlgItem(hDlg,IDC_ROUND_HIT ),EM_LIMITTEXT,(WPARAM) 3,0);
      SendMessage(GetDlgItem(hDlg,IDC_REST_TIME ),EM_LIMITTEXT,(WPARAM) 3,0);
	  SendMessage(GetDlgItem(hDlg,IDC_PLAYER_A),EM_LIMITTEXT,(WPARAM)20,0);
	  SendMessage(GetDlgItem(hDlg,IDC_PROB_A  ),EM_LIMITTEXT,(WPARAM)3 ,0);
	  SendMessage(GetDlgItem(hDlg,IDC_ATT_A   ),EM_LIMITTEXT,(WPARAM)3 ,0);

	  SendMessage(GetDlgItem(hDlg,IDC_PLAYER_B),EM_LIMITTEXT,(WPARAM)20,0);
	  SendMessage(GetDlgItem(hDlg,IDC_PROB_B  ),EM_LIMITTEXT,(WPARAM)3 ,0);
	  SendMessage(GetDlgItem(hDlg,IDC_ATT_B   ),EM_LIMITTEXT,(WPARAM)3 ,0);

      /* ��ȭ ���ڿ� ���� ���� �κ� Setting  */
	  SetDlgItemInt (hDlg,IDC_ROUND    ,maxRound,TRUE); // �� ���� ��
	  SetDlgItemInt (hDlg,IDC_ROUND_HIT,maxHit	,TRUE); // ���� �� ���ݼ�
	  SetDlgItemInt (hDlg,IDC_REST_TIME,restTime,TRUE); // �޽� �ð�

	  SetDlgItemText(hDlg,IDC_PLAYER_A,player_A   ); // A ���� �̸�
	  SetDlgItemInt (hDlg,IDC_PROB_A  ,prob_A,TRUE); // A ���� Ȯ��
	  SetDlgItemInt (hDlg,IDC_ATT_A   ,att_A ,TRUE); // A ���� ����

	  SetDlgItemText(hDlg,IDC_PLAYER_B,player_B   ); // B ���� �̸�
	  SetDlgItemInt (hDlg,IDC_PROB_B  ,prob_B,TRUE); // B ���� Ȯ��
	  SetDlgItemInt (hDlg,IDC_ATT_B   ,att_B ,TRUE); // B ���� ����
}
/*--------------------------------------------------------------
 �Լ���    : ReadValue
 �ƱԸ�Ʈ1 : HWND hDlg
             handle to dialog box
 ���      : ���ӿ� �̿�� ���� ��ȭ������ �Ӽ����� �Ҵ��մϴ�.
---------------------------------------------------------------*/
void ReadValue(HWND hDlg) {
	  maxRound = GetDlgItemInt(hDlg,IDC_ROUND     , NULL, TRUE ); // �� ���� ��    
	  maxHit   = GetDlgItemInt(hDlg,IDC_ROUND_HIT , NULL, TRUE ); // ���� �� ���ݼ�
	  restTime = GetDlgItemInt(hDlg,IDC_REST_TIME , NULL, TRUE ); // �޽� �ð�       

	  GetDlgItemText(hDlg,IDC_PLAYER_A,player_A, sizeof(player_A) ); // A ���� �̸�
	  prob_A = GetDlgItemInt(hDlg,IDC_PROB_A, NULL, TRUE ); // A ���� Ȯ��
	  att_A  = GetDlgItemInt(hDlg,IDC_ATT_A , NULL, TRUE ); // A ���� ����

	  GetDlgItemText(hDlg,IDC_PLAYER_B,player_B, sizeof(player_B) ); // B ���� �̸�
	  prob_B = GetDlgItemInt(hDlg,IDC_PROB_B, NULL, TRUE ); // B ���� Ȯ��
	  att_B  = GetDlgItemInt(hDlg,IDC_ATT_B , NULL, TRUE ); // B ���� ����
}
/*--------------------------------------------------------------
 �Լ���    : InitValue
 ���      : �ʱ� ������ ����.
---------------------------------------------------------------*/
void InitValue() {
	// �ʱⰪ ����
	wsprintf(player_A,"%s","ȫ�浿");
	prob_A      = 50 ;
	att_A       = 100;
	wsprintf(player_B,"%s","�̼���");
	prob_B      = 100;
	att_B       = 100;

	maxRound    = 3  ;
	maxHit	    = 10 ;
	restTime    = 3  ;

	curAtt_A = att_A ;
	curAtt_B = att_B ;
	sumHit_A = 0;
	sumHit_B = 0; // �� ���� �հ�
}
/*--------------------------------------------------------------
 �Լ���    : RecoverRound
 ���      : ���� ���� �޴��� ������ ��� ���� �ʱ�ȭ
---------------------------------------------------------------*/
void RecoverRound (HWND hWnd) {

	point.x = 280;
	point.y = 0;
	resultY = 0;

	round    =1; // ����
	roundTime=1; // ���� ��
	chkRestTime = 0  ; // �޽� �ð� üũ

	curAtt_A = att_A;
	curAtt_B = att_B;

	sumHit_A = 0;
	sumHit_B = 0; // �� ���� �հ�

	InvalidateRect(hWnd,NULL,TRUE);
}

/*--------------------------------------------------------------
 �Լ���    : Judgment
 ���      : ���и� ������ ����� ����մϴ�.
---------------------------------------------------------------*/
void Judgment (HDC hdc, int ko) {
	char szMessage[50]; // ��� ���� �޽��� ���
		wsprintf(szMessage,"���� ��� : %d �� %d ", sumHit_A, sumHit_B);
		//MessageBox(g_hWnd,szMessage,"dd",MB_OK);
		TextOut(hdc, 0, resultY + (15 * round), szMessage, strlen(szMessage));
		if ( sumHit_A == sumHit_B ) {
			wsprintf(szMessage,"���º�");
			TextOut(hdc, 0, resultY + (15 * (round+1) ), szMessage, strlen(szMessage));
		} else if ( sumHit_A > sumHit_B ) {
			if ( ko ) {
				wsprintf(szMessage,"A�� %s KO �¸�", player_A);
			} else {
				wsprintf(szMessage,"A�� %s �¸�", player_A);
			}
			TextOut(hdc, 0, resultY + (15 * (round+1) ), szMessage, strlen(szMessage));
		} else if ( sumHit_A < sumHit_B ) {
			if ( ko ) {
				wsprintf(szMessage,"B�� %s KO �¸�", player_B);
			} else {
				wsprintf(szMessage,"B�� %s �¸�", player_B);
			}
			TextOut(hdc, 0, resultY + (15 * (round+1) ), szMessage, strlen(szMessage));
		}
}

void CALLBACK TimerProc(HWND hWnd, UINT uMsg, UINT_PTR idEvent, DWORD dwTime)
{
	HDC hdc;
	HFONT font,oldfont;
	hdc = GetDC(hWnd);

	font = CreateFont(12,0,0,0,0,0,0,0,HANGUL_CHARSET,3,2,1,VARIABLE_PITCH|FF_ROMAN,"����");
	oldfont = (HFONT) SelectObject(hdc,font);
	char szMessage[100]; // ��� ���� �޽��� ���

	if ( round <= maxRound ) {
		if ( curAtt_A <= 0 || curAtt_B <= 0 ) {
			SetTextColor(hdc,RGB(255,0,0));
			Judgment (hdc,1); // ����
		} else {
			
			if ( roundTime > maxHit ) {
				roundTime = 1;
				rndHit_A  = 0;
				rndHit_B  = 0;
			}
/*
	wsprintf(szMessage,"[%d / %d / %d / %d / %d ]",chkRestTime , restTime, roundTime, maxHit, maxRound);
	MessageBox(hWnd,szMessage,"",MB_OK);
*/
			if ( roundTime == maxHit ) {
				chkRestTime = restTime;
				if ( maxRound > 1 ) {
					round++     ; // ���� ����
				}
			} else if ( chkRestTime > 0 ) {
				if ( chkRestTime == restTime ) {
					point.y += 15; // ĭ ������
					wsprintf(szMessage,"[%d�ʰ� �޽���...]",restTime);
					TextOut(hdc, point.x, point.y, szMessage, strlen(szMessage));
				}
				chkRestTime--;
			}

			if ( chkRestTime == 0 || chkRestTime == restTime ) {
				int  hit_A, hit_B ; // �ָ��� ��

				hit_A = (rand()%10) + 1;
				hit_B = (rand()%10) + 1;
				int attHit_A = hit_A *  prob_A / 100 ;
				int attHit_B = hit_B *  prob_B / 100 ;
				sumHit_A += attHit_A;
				sumHit_B += attHit_B;
				rndHit_A += attHit_A;
				rndHit_B += attHit_B;

				/* ���ߵ� ��Ʈ���� �������� ���� */
				curAtt_B -= attHit_A;
				curAtt_A -= attHit_B;

				//SetBkColor  (hdc, RGB(255,0,0));
				SetTextColor(hdc,RGB(0,0,255 ));
				//SetBkMode (hdc,TRANSPARENT);

				// ȸ�� ��� ���
				if ( roundTime == maxHit || curAtt_A<=0 || curAtt_B<=0) {
					wsprintf(szMessage,"%d ȸ�� ��� : %d �� %d ", round-1, rndHit_A, rndHit_B);
					resultY = resultY + (15 * (round-1));
					TextOut(hdc, 0, resultY, szMessage, strlen(szMessage));
				}

				if ( round==1 && roundTime==1 ) {
					wsprintf(szMessage,"[%s]", "A����");
					TextOut(hdc, point.x, point.y, szMessage, strlen(szMessage));
					wsprintf(szMessage,"[%s]", "B����");
					TextOut(hdc, point.x+250, point.y, szMessage, strlen(szMessage));
				}
				point.y += 15; // ĭ ������

				if ( roundTime == 1 ) {
					//point.y += 15; // ĭ ������
					wsprintf(szMessage,"[%d ROUND]", round);
					TextOut(hdc, point.x-70, point.y, szMessage, strlen(szMessage));
				}

				wsprintf(szMessage,"[ %d ��] %d �� ��ġ�� %d�� ���� -> ���� %d ",
					roundTime, hit_A, attHit_A, curAtt_A );
				TextOut(hdc, point.x, point.y, szMessage, strlen(szMessage));

				wsprintf(szMessage,"[ %d ��] %d �� ��ġ�� %d�� ���� -> ���� %d ",
					roundTime, hit_B, attHit_B, curAtt_B );
				TextOut(hdc, point.x+250, point.y, szMessage, strlen(szMessage));

				InvalidateRect(hWnd,NULL,FALSE); 

				roundTime++; // ���� �� ����
			}
		}
	} else {
		SetTextColor(hdc,RGB(255,0,0));
		Judgment (hdc,0); // ����
	}

	SelectObject(hdc,oldfont);
	DeleteObject(font);
	ReleaseDC(hWnd,hdc);
}

BOOL CALLBACK DialogProc(HWND hDlg, UINT uMsg, WPARAM wParam, LPARAM lParam) 
{

	switch (uMsg) {
	case WM_INITDIALOG:
		SetItem(hDlg);
		ReadValue (hDlg);
		RecoverRound(hDlg);
		return TRUE;
	case WM_COMMAND:
		switch (wParam) {
			case IDOK:
				ReadValue(hDlg);
				EndDialog(hDlg,0);
				RecoverRound(hDlg);
				break;
			case IDCANCEL:
				EndDialog(hDlg,0);
				break;
		}
		return TRUE;
	}
	return FALSE;
}

DWORD WINAPI ThreadFunc(LPVOID temp) {
	for(;;) {
			DisplayHit   ();
			DisplayEnergy();
		Sleep(100);
		//if (xx==1) xx=0;
	}
	return 0;
}


int hPosXFA=10,hPosXTA=180,hPosYFA=260,hPosYTA=310;

/*--------------------------------------------------------------
 �Լ���    : DisplayHit
 ���      : ��ȿ Ÿ�ݼ��� ����� ��ġ�� ����׷��� ���·� ǥ���մϴ�.
---------------------------------------------------------------*/
void DisplayHit   () {
	HDC hdc;
	HBRUSH hBrush , hOldBrush	;
	HBRUSH hHBrush, hHOldBrush	;

	hdc=GetDC(g_hWnd);
	hBrush = CreateSolidBrush(RGB(0,0,255));
	hOldBrush=(HBRUSH)SelectObject(hdc,hBrush);
	Rectangle(hdc,hPosXFA,hPosYFA,hPosXTA,hPosYTA);

	int barSize = hPosXTA - hPosXFA;
	int prgA=0;
	int sumTotAtt = sumHit_A + sumHit_B;
	int cPrgA=50;
	if ( sumHit_A > 0 ) {
		prgA = (sumHit_A*100)/sumTotAtt;
	} else {
		prgA=50;
	}
	
	TextOut(hdc,hPosXFA+ 20,hPosYFA-25,player_A,strlen(player_A));

	cPrgA = (barSize*prgA) / 100;
	TextOut(hdc,hPosXFA+ 20,hPosYFA-25,player_A,strlen(player_A));
	TextOut(hdc,hPosXFA+100,hPosYFA-25,player_B,strlen(player_B));
	char dd[100];
//	wsprintf(dd,"barSize : %d / prgA : %d / cPrgA : %d",barSize,prgA,cPrgA);
	wsprintf(dd,"       %s       "," ");
	TextOut(hdc,hPosXTA-70,hPosYTA+20,dd,strlen(dd));

//	if ( cPrgA == 0 ) { cPrgA =1; MessageBox(g_hWnd,"�˸�",dd,MB_OK); }

	char percent[10];
	wsprintf(percent,"%d %%(%d hit)",prgA    ,sumHit_A);
	TextOut(hdc,hPosXFA   ,hPosYTA,percent,strlen(percent));
	wsprintf(percent,"%d %%(%d hit)",100-prgA,sumHit_B);
	TextOut(hdc,hPosXTA-70,hPosYTA,percent,strlen(percent));

	hHBrush = CreateSolidBrush(RGB(255,0,0));
	hHOldBrush=(HBRUSH)SelectObject(hdc,hHBrush);

	Rectangle(hdc,hPosXFA,hPosYFA,cPrgA+hPosXFA,hPosYTA);

	SelectObject(hdc,hOldBrush );
	SelectObject(hdc,hHOldBrush);
	DeleteObject(hBrush);
	DeleteObject(hHBrush);
	ReleaseDC(g_hWnd,hdc);
}

/*--------------------------------------------------------------
 �Լ���    : DisplayEnergy
 ���      : ���� ��Ȳ�� ������ �׷��� ���·� ǥ�� �մϴ�.
---------------------------------------------------------------*/
int ePosXFA=30 ,ePosXTA=80 ,ePosYFA=350,ePosYTA=500;
int ePosXFB=100,ePosXTB=150,ePosYFB=350,ePosYTB=500;
void DisplayEnergy() {
	HDC hdc;
	HBRUSH hBrush , hOldBrush	;
	HBRUSH hPBrush, hPOldBrush	;
	hdc=GetDC(g_hWnd);

	hBrush = CreateSolidBrush(RGB(255,0,0));
	hOldBrush=(HBRUSH)SelectObject(hdc,hBrush);
	Rectangle(hdc,ePosXFA,ePosYFA+1,ePosXTA,ePosYTA+1);
	Rectangle(hdc,ePosXFB,ePosYFB+1,ePosXTB,ePosYTB+1);
	
	char dd[100];
	int prgA=(curAtt_A*100)/att_A;
	int prgB=(curAtt_B*100)/att_B;
	int barSize = ePosYTA - ePosYFA;
	int cPrgA = (barSize*(100-prgA)) / 100;
	int cPrgB = (barSize*(100-prgB)) / 100;
	wsprintf(dd,"att_A : %d, curAtt_A : %d, prs %d, cPrgA %d",att_A, curAtt_A,prgA, cPrgA);
	// TextOut(hdc,100,500,dd,strlen(dd));
	// MessageBox(g_hWnd,dd,"info",MB_OK);

	hPBrush = CreateSolidBrush(RGB(0,0,0));
	hPOldBrush=(HBRUSH)SelectObject(hdc,hPBrush);

	if ( curAtt_A > 0 ) {
		Rectangle(hdc,ePosXFA,ePosYFA+1,ePosXTA,ePosYFA + cPrgA);
	} else {
		Rectangle(hdc,ePosXFA,ePosYFA+1,ePosXTA,ePosYTA);
	}
	if ( curAtt_B > 0 ) {
		Rectangle(hdc,ePosXFB,ePosYFB+1,ePosXTB,ePosYFB + cPrgB);
	} else {
		Rectangle(hdc,ePosXFB,ePosYFB+1,ePosXTB,ePosYTB);
	}

	char percent[20];
	wsprintf(percent,"%d / %d  ",curAtt_A,att_A);
	TextOut(hdc,ePosXFA,ePosYTA+1,percent,strlen(percent));
	wsprintf(percent,"%d / %d  ",curAtt_B,att_B);
	TextOut(hdc,ePosXFA+70,ePosYTA+1,percent,strlen(percent));
	
	SelectObject(hdc,hOldBrush );
	DeleteObject(hBrush );
	SelectObject(hdc,hPOldBrush);
	DeleteObject(hPBrush);

	ReleaseDC(g_hWnd,hdc);
}

/*--------------------------------------------------------------
 �Լ���    : StartThread
 �ƱԸ�Ʈ1 : DWORD ThreadID
 �ƱԸ�Ʈ2 : HANDLE hThread
 ���      : ���ӿ� �̿�� ���� ��ȭ������ �Ӽ����� �Ҵ��մϴ�.
---------------------------------------------------------------*/
//StartThread(DWORD ThreadID,HANDLE hThread); // Thread ����
void StartThread(DWORD ThreadID,HANDLE hThread) {
	hThread = CreateThread(NULL,0,ThreadFunc,NULL,0,&ThreadID);
	SetThreadPriority(hThread,THREAD_PRIORITY_TIME_CRITICAL);
	CloseHandle  (hThread);
}

/*--------------------------------------------------------------
 �Լ���    : StartBGMusic
 ���      : ��� ����(Eye OF The Tiger) ���
---------------------------------------------------------------*/
void StartBGMusic() {
	// ���ҽ��� �ִ� WAVE�� �����ϱ�
	PlaySound(MAKEINTRESOURCE(IDR_WAVE1), g_hInst, SND_RESOURCE | SND_ASYNC | SND_LOOP);
}

// ������ ���ν��� (Window Procedure)
LRESULT CALLBACK WndProc(HWND hWnd, UINT uMsg, WPARAM wParam, LPARAM lParam) 
{
	DWORD ThreadID;
	HANDLE hThread;
	hThread = 0;
	ThreadID = 0;
	// switch-case ���� �Ἥ �޽����� ������ ���� 
	// ������ �۾��� �����Ѵ�.
	switch( uMsg ) 
	{
		case WM_PAINT:
			resultY = 0;
			PAINTSTRUCT ps; // ����Ʈ ����ü�� ��� �ɴϴ�.
			HDC hdc;
			HFONT font,oldfont;
			hdc = BeginPaint(hWnd,&ps);
			font = CreateFont(12,0,0,0,0,0,0,0,HANGUL_CHARSET,3,2,1,VARIABLE_PITCH|FF_ROMAN,"����");

			oldfont = (HFONT) SelectObject(hdc,font);
			// BeginPaint �Լ��� �̿��Ͽ�, DC�� ������
			// TextOut �Լ��� �̿��Ͽ� ���ڿ��� ����Ѵ�.
			char szMessage[100];
			wsprintf(szMessage,"%s","========================");
			TextOut(hdc,0  , resultY, szMessage, strlen(szMessage));
			wsprintf(szMessage,"A�� ���� �̸� : %s ",player_A);resultY = resultY + 15;
			TextOut(hdc,0  , resultY, szMessage, strlen(szMessage));
			wsprintf(szMessage,"Ȯ�� : %d / ���� : %d ",prob_A, att_A );resultY = resultY + 15;
			TextOut(hdc,0  , resultY, szMessage, strlen(szMessage));
/*
			wsprintf(szMessage,"���� ���� : %d ",curAtt_A);resultY = resultY + 15;
			TextOut(hdc,0  , resultY, szMessage, strlen(szMessage));
*/
			wsprintf(szMessage,"%s","========================");resultY = resultY + 15;
			TextOut(hdc,0  , resultY, szMessage, strlen(szMessage));

			wsprintf(szMessage,"B�� ���� �̸� : %s ",player_B);resultY = resultY + 15;
			TextOut(hdc,0  , resultY, szMessage, strlen(szMessage));
			wsprintf(szMessage,"Ȯ�� : %d / ���� : %d ",prob_B, att_B );resultY = resultY + 15;
			TextOut(hdc,0  , resultY, szMessage, strlen(szMessage));
/*
			wsprintf(szMessage,"���� ���� : %d ",curAtt_B);resultY = resultY + 15;
			TextOut(hdc,0  , resultY, szMessage, strlen(szMessage));
*/
			wsprintf(szMessage,"%s","========================");resultY = resultY + 15;
			TextOut(hdc,0  , resultY, szMessage, strlen(szMessage));
			SelectObject(hdc,oldfont);
			DeleteObject(font);
			EndPaint(hWnd,&ps);
			break;
		case WM_CREATE : // �����찡 ���� �ɶ�
			InitValue    ();
			DisplayHit   ();
			DisplayEnergy();
			
			break;
		case WM_LBUTTONDBLCLK:
			KillTimer(hWnd,1);
			break;
		case WM_COMMAND: // �����쿡�� ����� ���� �Ǿ�����
			if(LOWORD(wParam) == ID_SETUP) { // ���� ����
				RecoverRound (hWnd);
				KillTimer(hWnd,1);
				DialogBox(g_hInst, MAKEINTRESOURCE(IDD_DIALOG1),hWnd,(DLGPROC) DialogProc);
			} else if ( LOWORD(wParam) == ID_START ) { // ���� ����
				StartThread(ThreadID, hThread); // Thread ����
				StartBGMusic();					// ������� ����
				RecoverRound (hWnd);
				SetTimer(hWnd,1,1000,(TIMERPROC)TimerProc);
			} else if ( LOWORD(wParam) == ID_EXIT ) { // ���� ����
				DestroyWindow(hWnd);
			}
			break;
		case WM_DESTROY: // ���α׷��� �����ϴ� ���
			KillTimer(hWnd,1);
			PostQuitMessage(0); // WM_QUIT �޽����� �߻����� �޽��� ������ �ߴ��Ѵ�.
			break;
		default: // ó������ ���� �޽����� 
			return DefWindowProc(hWnd, uMsg, wParam, lParam);
	}
	return 0;
}
