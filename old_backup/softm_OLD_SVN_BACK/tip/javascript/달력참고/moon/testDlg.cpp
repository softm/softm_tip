// testDlg.cpp : implementation file
//

#include "stdafx.h"
#include "test.h"
#include "testDlg.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CAboutDlg dialog used for App About

class CAboutDlg : public CDialog
{
public:
	CAboutDlg();

// Dialog Data
	//{{AFX_DATA(CAboutDlg)
	enum { IDD = IDD_ABOUTBOX };
	//}}AFX_DATA

	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CAboutDlg)
	protected:
	virtual void DoDataExchange(CDataExchange* pDX);    // DDX/DDV support
	//}}AFX_VIRTUAL

// Implementation
protected:
	//{{AFX_MSG(CAboutDlg)
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};

CAboutDlg::CAboutDlg() : CDialog(CAboutDlg::IDD)
{
	//{{AFX_DATA_INIT(CAboutDlg)
	//}}AFX_DATA_INIT
}

void CAboutDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	//{{AFX_DATA_MAP(CAboutDlg)
	//}}AFX_DATA_MAP
}

BEGIN_MESSAGE_MAP(CAboutDlg, CDialog)
	//{{AFX_MSG_MAP(CAboutDlg)
		// No message handlers
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CTestDlg dialog

CTestDlg::CTestDlg(CWnd* pParent /*=NULL*/)
	: CDialog(CTestDlg::IDD, pParent)
{
	//{{AFX_DATA_INIT(CTestDlg)
	m_nSDay = 1;
	m_nSMonth = 8;
	m_nSYear = 2002;
	m_nLDay = 0;
	m_nLMonth = 0;
	m_nLYear = 0;
	//}}AFX_DATA_INIT
	// Note that LoadIcon does not require a subsequent DestroyIcon in Win32
	m_hIcon = AfxGetApp()->LoadIcon(IDR_MAINFRAME);
}

void CTestDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	//{{AFX_DATA_MAP(CTestDlg)
	DDX_Text(pDX, IDC_S_DAY, m_nSDay);
	DDX_Text(pDX, IDC_S_MONTH, m_nSMonth);
	DDX_Text(pDX, IDC_S_YEAR, m_nSYear);
	DDX_Text(pDX, IDC_L_DAY, m_nLDay);
	DDX_Text(pDX, IDC_L_MONTH, m_nLMonth);
	DDX_Text(pDX, IDC_L_YEAR, m_nLYear);
	//}}AFX_DATA_MAP
}

BEGIN_MESSAGE_MAP(CTestDlg, CDialog)
	//{{AFX_MSG_MAP(CTestDlg)
	ON_WM_SYSCOMMAND()
	ON_WM_PAINT()
	ON_WM_QUERYDRAGICON()
	ON_BN_CLICKED(IDC_BUTTON1, OnButton1)
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CTestDlg message handlers

BOOL CTestDlg::OnInitDialog()
{
	CDialog::OnInitDialog();

	// Add "About..." menu item to system menu.

	// IDM_ABOUTBOX must be in the system command range.
	ASSERT((IDM_ABOUTBOX & 0xFFF0) == IDM_ABOUTBOX);
	ASSERT(IDM_ABOUTBOX < 0xF000);

	CMenu* pSysMenu = GetSystemMenu(FALSE);
	if (pSysMenu != NULL)
	{
		CString strAboutMenu;
		strAboutMenu.LoadString(IDS_ABOUTBOX);
		if (!strAboutMenu.IsEmpty())
		{
			pSysMenu->AppendMenu(MF_SEPARATOR);
			pSysMenu->AppendMenu(MF_STRING, IDM_ABOUTBOX, strAboutMenu);
		}
	}

	// Set the icon for this dialog.  The framework does this automatically
	//  when the application's main window is not a dialog
	SetIcon(m_hIcon, TRUE);			// Set big icon
	SetIcon(m_hIcon, FALSE);		// Set small icon
	
	// TODO: Add extra initialization here
	
	return TRUE;  // return TRUE  unless you set the focus to a control
}

void CTestDlg::OnSysCommand(UINT nID, LPARAM lParam)
{
	if ((nID & 0xFFF0) == IDM_ABOUTBOX)
	{
		CAboutDlg dlgAbout;
		dlgAbout.DoModal();
	}
	else
	{
		CDialog::OnSysCommand(nID, lParam);
	}
}

// If you add a minimize button to your dialog, you will need the code below
//  to draw the icon.  For MFC applications using the document/view model,
//  this is automatically done for you by the framework.

void CTestDlg::OnPaint() 
{
	if (IsIconic())
	{
		CPaintDC dc(this); // device context for painting

		SendMessage(WM_ICONERASEBKGND, (WPARAM) dc.GetSafeHdc(), 0);

		// Center icon in client rectangle
		int cxIcon = GetSystemMetrics(SM_CXICON);
		int cyIcon = GetSystemMetrics(SM_CYICON);
		CRect rect;
		GetClientRect(&rect);
		int x = (rect.Width() - cxIcon + 1) / 2;
		int y = (rect.Height() - cyIcon + 1) / 2;

		// Draw the icon
		dc.DrawIcon(x, y, m_hIcon);
	}
	else
	{
		CDialog::OnPaint();
	}
}

// The system calls this to obtain the cursor to display while the user drags
//  the minimized window.
HCURSOR CTestDlg::OnQueryDragIcon()
{
	return (HCURSOR) m_hIcon;
}



void getsubstr(char *instr,int pos,int size,char *outstr)
{
    char buff[1024];
    char *pch;
    register int i;

    pch = instr;
    for(i=0;i<pos;i++){ pch++;}
    for(i=0;i<size;i++){
        buff[i] = *pch;
        pch++;
    }
    buff[i]='\0';
    strcpy(outstr,buff);
}


void get_negative(int gf_year,int gf_month,int gf_day,int *year,int *month,int *day,int *youn)
{
// 처리가능 기간 1881 - 2043년
	char lunar[][14] = 
	{"1212122322121","1212121221220","1121121222120","2112132122122","2112112121220",
            
		"2121211212120","2212321121212","2122121121210","2122121212120","1232122121212",
            
		"1212121221220","1121123221222","1121121212220","1212112121220","2121231212121",
            
		"2221211212120","1221212121210","2123221212121","2121212212120","1211212232212",
            
		"1211212122210","2121121212220","1212132112212","2212112112210","2212211212120",
            
		"1221412121212","1212122121210","2112212122120","1231212122212","1211212122210",
            
		"2121123122122","2121121122120","2212112112120","2212231212112","2122121212120",
            
		"1212122121210","2132122122121","2112121222120","1211212322122","1211211221220",
            
		"2121121121220","2122132112122","1221212121120","2121221212110","2122321221212",
            
		"1121212212210","2112121221220","1231211221222","1211211212220","1221123121221",
            
		"2221121121210","2221212112120","1221241212112","1212212212120","1121212212210",
            
		"2114121212221","2112112122210","2211211412212","2211211212120","2212121121210",
            
		"2212214112121","2122122121120","1212122122120","1121412122122","1121121222120",
            
		"2112112122120","2231211212122","2121211212120","2212121321212","2122121121210",
            
		"2122121212120","1212142121212","1211221221220","1121121221220","2114112121222",
            
		"1212112121220","2121211232122","1221211212120","1221212121210","2121223212121",
            
		"2121212212120","1211212212210","2121321212221","2121121212220","1212112112210",
            
		"2223211211221","2212211212120","1221212321212","1212122121210","2112212122120",
            
		"1211232122212","1211212122210","2121121122210","2212312112212","2212112112120",
            
		"2212121232112","2122121212110","2212122121210","2112124122121","2112121221220",
            
		"1211211221220","2121321122122","2121121121220","2122112112322","1221212112120",
            
		"1221221212110","2122123221212","1121212212210","2112121221220","1211231212222",
            
		"1211211212220","1221121121220","1223212112121","2221212112120","1221221232112",
            
		"1212212122120","1121212212210","2112132212221","2112112122210","2211211212210",
            
		"2221321121212","2212121121210","2212212112120","1232212122112","1212122122120",
            
		"1121212322122","1121121222120","2112112122120","2211231212122","2121211212120",
            
		"2122121121210","2124212112121","2122121212120","1212121223212","1211212221220",
            
		"1121121221220","2112132121222","1212112121220","2121211212120","2122321121212",
            
		"1221212121210","2121221212120","1232121221212","1211212212210","2121123212221",
            
		"2121121212220","1212112112220","1221231211221","2212211211220","1212212121210",
            
		"2123212212121","2112122122120","1211212322212","1211212122210","2121121122120",
            
		"2212114112122","2212112112120","2212121211210","2212232121211","2122122121210",
					"2112122122120","1231212122212","1211211221220" };
	int lday[] = {31,0,31,30,31,30,31,31,30,31,30,31};

		register int i,j;
		char buff[20];
		int dt[500];
		int tmp,td,td0,td1,td2,k11;
		int m1,m2,jcount;

	// 양력 -> 음력
	for(i = 0;i <= 162;i++) {
	dt[i] = 0;
	for(j = 0;j < 12;j++) {
	getsubstr(lunar[i],j,1,&buff[0]);
	tmp = atoi(buff);
	if(tmp == 1 || tmp == 3) {
	dt[i] += 29;
			}
			else if(tmp == 2 || tmp == 4) {
	dt[i] += 30;
			}
			else;
		 }

	getsubstr(lunar[i],12,1,&buff[0]);
	tmp = atoi(buff);
	if(tmp == 1 || tmp == 3) {
	dt[i] += 29;
		 }
	else if(tmp == 2 || tmp == 4) {
	dt[i] += 30;
	}
	else;
	}

	td1 = 1880 * 365 + (int)(1880 / 4) - (int)(1880 / 100) + (int)(1880 / 400) + 30;
	k11 = gf_year - 1;
	td2 = k11 * 365 + (int)(k11 / 4) - (int)(k11 / 100) + (int)(k11 / 400);

	if((gf_year % 400) == 0 || (gf_year % 100) != 0 && (gf_year % 4)== 0)
	{
		lday[1] = 29;
	}
	else {
		lday[1] = 28;
	}

	if(gf_day > lday[gf_month - 1]) {
	return;
	}

	for(i = 0;i <= gf_month - 2;i++) {
	td2 += lday[i];
	}
	td2 += gf_day;
	td = td2 - td1 + 1;
	td0 = dt[0];

	for(i = 0;i <= 162;i++) {
	if(td <= td0) {
	break;
	}
	td0 += dt[i + 1];
	}

	gf_year = i + 1881;
	td0 -= dt[i];
	td -= td0;

	getsubstr(lunar[i],12,1,&buff[0]);
	if(atoi(buff) == 0) {
	jcount = 11;
	}
	else {
	jcount = 12;
	}
	m2 = 0;

	for(j = 0;j <= jcount;j++) {
	getsubstr(lunar[i],j,1,&buff[0]);
	if(atoi(buff) <= 2) {
	m2++;
	m1 = atoi(buff) + 28;
			*youn = 0;
		 }
	else {
	m1 = atoi(buff) + 26;
			*youn = 1;
	}
	if(td <= m1) {
	break;
	}
	td -= m1;
	}
	gf_month = m2;
	gf_day = td;

	*year = gf_year;
	*month = gf_month;
	*day = gf_day;
}
	
void CTestDlg::OnButton1() 
{
	UpdateData(TRUE);

	int nYoun;

	get_negative(m_nSYear, m_nSMonth, m_nSDay, &m_nLYear, &m_nLMonth, &m_nLDay, &nYoun);

	UpdateData(FALSE);

	
}
