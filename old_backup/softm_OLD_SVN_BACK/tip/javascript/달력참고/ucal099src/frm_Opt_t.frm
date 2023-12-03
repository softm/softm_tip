VERSION 5.00
Begin VB.Form frm_Opt_T 
   Caption         =   "�ð� ����"
   ClientHeight    =   3870
   ClientLeft      =   60
   ClientTop       =   345
   ClientWidth     =   8310
   BeginProperty Font 
      Name            =   "����ü"
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
   StartUpPosition =   3  'Windows �⺻��
   Begin VB.CommandButton c_Default 
      Caption         =   "�ʱⰪ"
      Height          =   375
      Left            =   4320
      TabIndex        =   6
      Top             =   3360
      Width           =   1215
   End
   Begin VB.CommandButton b_cancel 
      Caption         =   "��  ��"
      Height          =   375
      Left            =   6960
      TabIndex        =   8
      Top             =   3360
      Width           =   1215
   End
   Begin VB.CommandButton b_ok 
      Caption         =   "Ȯ  ��"
      Height          =   375
      Left            =   5640
      TabIndex        =   7
      Top             =   3360
      Width           =   1215
   End
   Begin VB.Frame Frame3 
      Caption         =   "�ð� ��� �ɼ�"
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
         Caption         =   "���ڽ� ���"
         Height          =   255
         Left            =   120
         TabIndex        =   1
         Top             =   600
         Width           =   3255
      End
      Begin VB.CheckBox chk_KTime 
         Caption         =   "127.5�� ���� �ѱ�ǥ�ؽð� ���Ⱓ �ݿ�"
         Height          =   255
         Left            =   120
         TabIndex        =   3
         Top             =   1320
         Width           =   4695
      End
      Begin VB.CheckBox chk_Summer 
         Caption         =   "�ϱ��ð������� �Ⱓ �ݿ�"
         Height          =   255
         Left            =   120
         TabIndex        =   2
         Top             =   960
         Width           =   5055
      End
      Begin VB.Label Label2 
         Caption         =   "��"
         Height          =   255
         Left            =   3360
         TabIndex        =   11
         Top             =   240
         Width           =   615
      End
      Begin VB.Label Label1 
         Caption         =   "���� ��� ���� �浵 :"
         Height          =   255
         Left            =   120
         TabIndex        =   10
         Top             =   240
         Width           =   2295
      End
   End
   Begin VB.Frame Frame1 
      Caption         =   "���� ��� �ɼ�"
      Height          =   1335
      Left            =   120
      TabIndex        =   12
      Top             =   1920
      Width           =   8055
      Begin VB.OptionButton opt_DivCal 
         Caption         =   "24���� ���ΰ�갪 �̿�"
         Height          =   255
         Left            =   120
         TabIndex        =   4
         Top             =   240
         Width           =   4215
      End
      Begin VB.OptionButton opt_DivLoad 
         Caption         =   "24���� �ܺ��Է°� �̿�"
         Height          =   255
         Left            =   120
         TabIndex        =   5
         Top             =   600
         Width           =   2775
      End
      Begin VB.Label lbl_From_to 
         BorderStyle     =   1  '���� ����
         Caption         =   "����"
         Enabled         =   0   'False
         Height          =   255
         Left            =   2880
         TabIndex        =   14
         Top             =   960
         Width           =   4815
      End
      Begin VB.Label Label4 
         Caption         =   "�� �Է°� �ݿ� �Ⱓ :"
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
    
    If gfDivLoad <> opt_DivLoad.Value Then '���� 24���� �Է� ���ΰ� �ٲ������
        gfDivLoad = opt_DivLoad.Value
        s_fname = App.Path & "\div24.dat"
        If gfDivLoad = True Then
            i_err = init_gDIV(s_fname, from_date, to_date)
            If i_err = False Then
                MsgBox "24���� data�� �дµ� �����Ͽ����Ƿ� ���� ���� ����մϴ�.", vbOKOnly, "�Ѩ��(������)"
                gfDivLoad = False
                opt_DivLoad.Value = False
                gstInDivFromTo = "����"
            Else
                gstInDivFromTo = from_date & " ~ " & to_date
            End If
        Else
            i_err = init_gDIV
            gstInDivFromTo = "����"
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

