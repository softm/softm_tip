VERSION 5.00
Begin VB.Form frm_Opt_T 
   Caption         =   "시간 설정"
   ClientHeight    =   3870
   ClientLeft      =   60
   ClientTop       =   345
   ClientWidth     =   8310
   BeginProperty Font 
      Name            =   "굴림체"
      Size            =   9.75
      Charset         =   129
      Weight          =   400
      Underline       =   0   'False
      Italic          =   0   'False
      Strikethrough   =   0   'False
   EndProperty
   Icon            =   "frm_Opt_t.frx":0000
   LinkTopic       =   "Form1"
   ScaleHeight     =   3870
   ScaleWidth      =   8310
   StartUpPosition =   3  'Windows 기본값
   Begin VB.CommandButton c_Default 
      Caption         =   "초기값"
      Height          =   375
      Left            =   4320
      TabIndex        =   6
      Top             =   3360
      Width           =   1215
   End
   Begin VB.CommandButton b_cancel 
      Caption         =   "취  소"
      Height          =   375
      Left            =   6960
      TabIndex        =   8
      Top             =   3360
      Width           =   1215
   End
   Begin VB.CommandButton b_ok 
      Caption         =   "확  인"
      Height          =   375
      Left            =   5640
      TabIndex        =   7
      Top             =   3360
      Width           =   1215
   End
   Begin VB.Frame Frame3 
      Caption         =   "시간 계산 옵션"
      Height          =   1695
      Left            =   120
      TabIndex        =   9
      Top             =   120
      Width           =   8055
      Begin VB.TextBox txt_Long 
         Height          =   285
         Left            =   2520
         TabIndex        =   0
         Text            =   "127.5"
         Top             =   240
         Width           =   735
      End
      Begin VB.CheckBox chk_Yajasi 
         Caption         =   "야자시 사용"
         Height          =   255
         Left            =   120
         TabIndex        =   1
         Top             =   600
         Width           =   3255
      End
      Begin VB.CheckBox chk_KTime 
         Caption         =   "127.5도 기준 한국표준시간 사용기간 반영"
         Height          =   255
         Left            =   120
         TabIndex        =   3
         Top             =   1320
         Width           =   4695
      End
      Begin VB.CheckBox chk_Summer 
         Caption         =   "일광시간절약제 기간 반영"
         Height          =   255
         Left            =   120
         TabIndex        =   2
         Top             =   960
         Width           =   5055
      End
      Begin VB.Label Label2 
         Caption         =   "도"
         Height          =   255
         Left            =   3360
         TabIndex        =   11
         Top             =   240
         Width           =   615
      End
      Begin VB.Label Label1 
         Caption         =   "시지 계산 기준 경도 :"
         Height          =   255
         Left            =   120
         TabIndex        =   10
         Top             =   240
         Width           =   2295
      End
   End
   Begin VB.Frame Frame1 
      Caption         =   "월간 계산 옵션"
      Height          =   1335
      Left            =   120
      TabIndex        =   12
      Top             =   1920
      Width           =   8055
      Begin VB.OptionButton opt_DivCal 
         Caption         =   "24절기 내부계산값 이용"
         Height          =   255
         Left            =   120
         TabIndex        =   4
         Top             =   240
         Width           =   4215
      End
      Begin VB.OptionButton opt_DivLoad 
         Caption         =   "24절기 외부입력값 이용"
         Height          =   255
         Left            =   120
         TabIndex        =   5
         Top             =   600
         Width           =   2775
      End
      Begin VB.Label lbl_From_to 
         BorderStyle     =   1  '단일 고정
         Caption         =   "없음"
         Enabled         =   0   'False
         Height          =   255
         Left            =   2880
         TabIndex        =   14
         Top             =   960
         Width           =   4815
      End
      Begin VB.Label Label4 
         Caption         =   "▣ 입력값 반영 기간 :"
         Enabled         =   0   'False
         Height          =   255
         Left            =   600
         TabIndex        =   13
         Top             =   960
         Width           =   2535
      End
   End
End
Attribute VB_Name = "frm_Opt_T"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False

Private Sub b_cancel_Click()
    Unload Me
End Sub

Private Sub b_ok_Click()
    Dim s_fname As String
    Dim from_date As Date
    Dim to_date As Date
    
    If gfDivLoad <> opt_DivLoad.Value Then '만약 24절기 입력 여부가 바뀌었으면
        gfDivLoad = opt_DivLoad.Value
        s_fname = App.Path & "\div24.dat"
        If gfDivLoad = True Then
            i_err = init_gDIV(s_fname, from_date, to_date)
            If i_err = False Then
                MsgBox "24절기 data를 읽는데 실패하였으므로 계산된 값을 사용합니다.", vbOKOnly, "理氣學(만세력)"
                gfDivLoad = False
                opt_DivLoad.Value = False
                gstInDivFromTo = "없음"
            Else
                gstInDivFromTo = from_date & " ~ " & to_date
            End If
        Else
            i_err = init_gDIV
            gstInDivFromTo = "없음"
        End If
    End If
    gsLong = CSng(txt_Long.Text)
    giYajaSi = chk_Yajasi.Value
    giSummer = chk_Summer.Value
    giKTime = chk_KTime.Value
    gfDivCal = opt_DivCal.Value
    
    Call gp_Save_Option
    
    Unload Me
End Sub

Private Sub c_Default_Click()
    Call gp_Default_option
    txt_Long.Text = CStr(gsLong)
    chk_Yajasi.Value = giYajaSi
    chk_Summer.Value = giSummer
    chk_KTime.Value = giKTime
    opt_DivCal.Value = gfDivCal
    opt_DivLoad.Value = gfDivLoad
End Sub

Private Sub Form_Load()
    Call gp_Load_Option
    txt_Long.Text = CStr(gsLong)
    chk_Yajasi.Value = giYajaSi
    chk_Summer.Value = giSummer
    chk_KTime.Value = giKTime
    opt_DivCal.Value = gfDivCal
    opt_DivLoad.Value = gfDivLoad
    frm_Opt_T.lbl_From_to.Caption = gstInDivFromTo
End Sub

