VERSION 5.00
Object = "{F9043C88-F6F2-101A-A3C9-08002B2F49FB}#1.2#0"; "COMDLG32.OCX"
Begin VB.MDIForm MDIMemo 
   BackColor       =   &H8000000C&
   Caption         =   "명반편집기"
   ClientHeight    =   6975
   ClientLeft      =   165
   ClientTop       =   735
   ClientWidth     =   7740
   Icon            =   "Memo_s.frx":0000
   LinkTopic       =   "MDIForm1"
   StartUpPosition =   3  'Windows 기본값
   Begin MSComDlg.CommonDialog CMD 
      Left            =   3960
      Top             =   2640
      _ExtentX        =   847
      _ExtentY        =   847
      _Version        =   393216
      DialogTitle     =   "파일열기"
      Filter          =   "텍스트 파일|*.txt"
   End
   Begin VB.Menu mnuFile 
      Caption         =   "파일"
      WindowList      =   -1  'True
      Begin VB.Menu mnuFileNew 
         Caption         =   "새파일"
         Shortcut        =   ^N
      End
      Begin VB.Menu mnuFileOpen 
         Caption         =   "열기"
         Shortcut        =   ^O
      End
      Begin VB.Menu mnuFileSave 
         Caption         =   "저장"
         Shortcut        =   ^S
      End
      Begin VB.Menu mnuSep 
         Caption         =   "-"
      End
      Begin VB.Menu mnuEnd 
         Caption         =   "종료"
         Shortcut        =   ^X
      End
   End
   Begin VB.Menu mnuEdit 
      Caption         =   "편집"
      Begin VB.Menu mnuEditCut 
         Caption         =   "잘라내기"
         Shortcut        =   {DEL}
      End
      Begin VB.Menu mnuEditCopy 
         Caption         =   "복사"
         Shortcut        =   ^C
      End
      Begin VB.Menu mnuEditAdd 
         Caption         =   "붙여넣기"
         Shortcut        =   ^V
      End
      Begin VB.Menu mnuEditDelete 
         Caption         =   "삭제"
         Shortcut        =   ^D
      End
   End
   Begin VB.Menu mnuForm 
      Caption         =   "글꼴"
      Begin VB.Menu mnuFormFont 
         Caption         =   "폰트"
      End
      Begin VB.Menu mnuFormCColor 
         Caption         =   "글자색"
      End
      Begin VB.Menu mnuFormBColor 
         Caption         =   "배경색"
      End
   End
End
Attribute VB_Name = "MDIMemo"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Option Explicit

Dim i As Integer '각 서브폼의 식별을 위해 Caption에 숫자를 입력하기위한 변수입니다
Dim cuttext As String '문자열을 할당하기위한 변수입니다.


Private Sub mnuEditAdd_Click() '붙여넣기 이벤트

    ActiveForm.txtMemo.SelText = cuttext '변수에 저장된 문자열을 txtMemo에 출력한다.
    
End Sub

Private Sub mnuEditCopy_Click() '복사하기 이벤트

    cuttext = ActiveForm.txtMemo.SelText '지정한 문자열을 변수에 저장한다.
    
End Sub

Private Sub mnuEditCut_Click() '잘라내기 이벤트
    
    cuttext = ActiveForm.txtMemo.SelText '선택된 문자열을 cuttext 스트링 변수에 할당한다.
    ActiveForm.txtMemo.SelText = "" '문자열을 지운다.
    
End Sub

Private Sub mnuEditDelete_Click()

    ActiveForm.txtMemo.SelText = "" '문자열을 지운다.
    
End Sub


Private Sub mnuFormBColor_Click() '배경색 설정 이벤트

    CMD.DialogTitle = "배경색 설정" '타이틀설정
    CMD.ShowColor '색대화상자를 연다.
    CMD.CancelError = True
    
    ActiveForm.txtMemo.BackColor = CMD.Color '지정한 색을 배경색으로 바꾼다.
    
End Sub

Private Sub mnuFormCColor_Click()

    CMD.DialogTitle = "글자색 설정" '타이틀설정
    CMD.ShowColor '색대화상자를 연다.
    
    ActiveForm.txtMemo.ForeColor = CMD.Color '지정한 색을 글자색으로 바꾼다.
    
End Sub

Private Sub mnuFormFont_Click()

    CMD.DialogTitle = "폰트 선택" '타이틀설정
    CMD.FontName = "" '폰트 초기값을 결정한다.
    CMD.Flags = cdlCFBoth '화면용과 프린터용 글꼴을 모두 표시
    CMD.ShowFont '폰트 대화상자를 연다.
    
    If CMD.FontName <> "" Then '폰트를 설정했다면
        With ActiveForm.txtMemo '대화상자에서의 선택사항을 텍스트박스에 적용한다.
            .FontName = CMD.FontName
            .FontSize = CMD.FontSize
            .FontBold = CMD.FontBold
            .FontItalic = CMD.FontItalic
            .FontStrikethru = CMD.FontStrikethru
            .FontUnderline = CMD.FontUnderline
        End With
    Else
        MsgBox "폰트가 선택되지 않았습니다.", vbOKOnly, "理氣學(만세력)"
    End If
    
End Sub

Private Sub mnuEnd_Click() '종료 이벤트

    End '종료
    
End Sub

Private Sub mnuFileNew_Click() '새파일 이벤트

    Dim Memo As New frm_Memo '클릭이벤트가 생길때마다 똑같은 폼을 호출하기위한 변수입니다.
    
    Memo.Show '메모장을 Display합니다.
    Memo.Caption = i + 1 & "번째 메모장" 'Caption Bar에 1번부터 고유번호를 부여합니다.
    i = i + 1 '그리고 1을 증가시킵니다.
    
End Sub

Private Sub mnuFileOpen_Click() '열기 이벤트
    
    Dim Memo As New frm_Memo
    Dim f As Integer  'FreeFile()에 의해 얻은 파일 번호 변수입니다.
    Dim textline As String '윈도우로 장치 사용 권한을 받은 핸들값변수입니다.
    
    CMD.DialogTitle = "열기" '타이틀 설정
    CMD.ShowOpen '열기대화상자를 연다
    
    If Err.Number = cdlCancel Then Exit Sub '취소버튼이라면 폼에서 빠져나온다.
    
    If CMD.FileName <> "" Then '파일을 입력했으면
        
        f = FreeFile() '파일번호를 변수에 할당
                
        Memo.Show '메모장을 Display합니다.
        Memo.Caption = i + 1 & "번째 메모장" 'Caption Bar에 1번부터 고유번호를 부여합니다.
        i = i + 1 '그리고 1을 증가시킵니다.
        
        Open CMD.FileName For Input As f '지정한 파일을 연다
       
        Do Until EOF(1) '파일의 끝이 아닐때까지
            Line Input #f, textline ''파일을 한줄씩 읽어드린다
            Memo.txtMemo.Text = Memo.txtMemo.Text + textline + Chr(13) + Chr(10) '읽어드린 줄을 한줄씩 출력한다.
        Loop
        
        Close f
        
    End If
    
End Sub

Private Sub mnuFileSave_Click() '저장 이벤트
    
    Dim f As Integer 'FreeFile()에 의해 얻은 파일 번호 변수입니다.
    
    CMD.DialogTitle = "저장하기" '타이틀 설정
    CMD.ShowSave '저장대화상자를 연다
    
    If Err.Number = cdlCancel Then Exit Sub '취소버튼이라면 폼에서 빠져나온다.
    
    If CMD.FileName <> "" Then
        
        f = FreeFile()
        
        Open CMD.FileName For Output As f '지정한 파일을 연다
        
        Print #f, ActiveForm.txtMemo.Text '활성화된 폼에 파일을 출력한다.
        
        Close f
    
    End If
    
End Sub
