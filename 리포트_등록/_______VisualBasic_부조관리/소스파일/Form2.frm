VERSION 5.00
Object = "{67397AA1-7FB1-11D0-B148-00A0C922E820}#6.0#0"; "MSADODC.OCX"
Begin VB.Form Form2 
   BorderStyle     =   1  '���� ����
   Caption         =   "���� �Է�"
   ClientHeight    =   3825
   ClientLeft      =   45
   ClientTop       =   435
   ClientWidth     =   3480
   LinkTopic       =   "Form2"
   MaxButton       =   0   'False
   MinButton       =   0   'False
   ScaleHeight     =   3825
   ScaleWidth      =   3480
   StartUpPosition =   3  'Windows �⺻��
   Begin VB.ComboBox comboSex 
      Height          =   300
      ItemData        =   "Form2.frx":0000
      Left            =   960
      List            =   "Form2.frx":0002
      TabIndex        =   12
      Text            =   "����"
      Top             =   2640
      Width           =   2175
   End
   Begin VB.OptionButton gubun 
      Caption         =   "�ź���"
      Height          =   375
      Index           =   1
      Left            =   2280
      TabIndex        =   11
      Top             =   240
      Width           =   1215
   End
   Begin VB.OptionButton gubun 
      Caption         =   "�Ŷ���"
      Height          =   375
      Index           =   0
      Left            =   1080
      TabIndex        =   10
      Top             =   240
      Value           =   -1  'True
      Width           =   1215
   End
   Begin VB.CommandButton cmdInsert 
      Caption         =   "�Է�"
      Height          =   375
      Left            =   2400
      TabIndex        =   4
      Top             =   3360
      Width           =   855
   End
   Begin VB.TextBox txtName 
      Height          =   390
      Left            =   960
      TabIndex        =   0
      Top             =   840
      Width           =   2295
   End
   Begin VB.TextBox txtHanName 
      Height          =   390
      Left            =   960
      TabIndex        =   1
      Top             =   1440
      Width           =   2295
   End
   Begin VB.TextBox txtHelpMoney 
      Alignment       =   1  '������ ����
      BeginProperty DataFormat 
         Type            =   1
         Format          =   "0"
         HaveTrueFalseNull=   0
         FirstDayOfWeek  =   0
         FirstWeekOfYear =   0
         LCID            =   1042
         SubFormatType   =   1
      EndProperty
      Height          =   390
      Left            =   960
      TabIndex        =   2
      Text            =   "0"
      Top             =   2040
      Width           =   1095
   End
   Begin MSAdodcLib.Adodc Adodc1 
      Height          =   375
      Left            =   120
      Top             =   3360
      Visible         =   0   'False
      Width           =   1815
      _ExtentX        =   3201
      _ExtentY        =   661
      ConnectMode     =   0
      CursorLocation  =   3
      IsolationLevel  =   -1
      ConnectionTimeout=   15
      CommandTimeout  =   30
      CursorType      =   2
      LockType        =   3
      CommandType     =   4
      CursorOptions   =   0
      CacheSize       =   50
      MaxRecords      =   0
      BOFAction       =   0
      EOFAction       =   0
      ConnectStringType=   1
      Appearance      =   1
      BackColor       =   -2147483643
      ForeColor       =   -2147483640
      Orientation     =   0
      Enabled         =   -1
      Connect         =   "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=F:\�б�\��������α׷���\����\�⸻���\wedding.mdb"
      OLEDBString     =   "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=F:\�б�\��������α׷���\����\�⸻���\wedding.mdb"
      OLEDBFile       =   ""
      DataSourceName  =   ""
      OtherAttributes =   ""
      UserName        =   ""
      Password        =   ""
      RecordSource    =   ""
      Caption         =   "Adodc1"
      BeginProperty Font {0BE35203-8F91-11CE-9DE3-00AA004BB851} 
         Name            =   "����"
         Size            =   9
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      _Version        =   393216
   End
   Begin VB.Label lbGubun 
      BackStyle       =   0  '����
      Caption         =   "����"
      Height          =   375
      Left            =   120
      TabIndex        =   9
      Top             =   240
      Width           =   735
   End
   Begin VB.Label Label1 
      Caption         =   "����"
      Height          =   255
      Left            =   2160
      TabIndex        =   8
      Top             =   2160
      Width           =   975
   End
   Begin VB.Label lbHanName 
      BackStyle       =   0  '����
      Caption         =   "���� �̸�"
      Height          =   375
      Left            =   120
      TabIndex        =   7
      Top             =   1560
      Width           =   1095
   End
   Begin VB.Label lbName 
      Caption         =   "�̸�"
      Height          =   375
      Left            =   120
      TabIndex        =   6
      Top             =   960
      Width           =   735
   End
   Begin VB.Label lbSex 
      Caption         =   "����"
      Height          =   375
      Left            =   120
      TabIndex        =   5
      Top             =   2760
      Width           =   735
   End
   Begin VB.Label lbHelpMoney 
      Caption         =   "�ݾ�"
      Height          =   375
      Left            =   120
      TabIndex        =   3
      Top             =   2160
      Width           =   735
   End
End
Attribute VB_Name = "Form2"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Private Sub cmdInsert_Click()
    '����
    Set cn = New ADODB.Connection
    cn.ConnectionString = dbStr
    cn.Open
    Dim sql As String
    Dim tmpGubun As String
    If txtName.Text = "" Then
        MsgBox "�̸��� �Է��� �ּ���", vbInformation
        txtName.SetFocus
        Exit Sub
    End If
    
    If gubun(1).Value Then
        tmpGubun = "�ź�"
    Else
        tmpGubun = "�Ŷ�"
    End If
    sql = "insert into wedding_main (gubun, name, han_name, sex, help_money, visit_time) values "
    sql = sql & "('" & tmpGubun & "','" & txtName.Text & "','" & txtHanName.Text & "','" & comboSex.Text & "','" & txtHelpMoney.Text & "','" & Now() & "')"
    cn.Execute (sql)
    cn.Close
    reSelect
    Form2.Hide
End Sub
Private Sub reSelect()
    Form1.Adodc1.ConnectionString = dbStr
    Form1.Adodc1.CommandType = adCmdText
    
    Dim sql As String
    Dim where As String
    
    sql = "select gubun as ����, name as �̸�, han_name as �����̸�, sex as ����, help_money as �ݾ�, visit_time as �湮���� from wedding_main "
    where = " ORDER BY gubun "
    Form1.Adodc1.RecordSource = sql & where
    Form1.Adodc1.Refresh
    colWidthFix
    totalPrint
End Sub

Private Sub colWidthFix()
    Form1.DataGrid1.Columns(0).Width = 500  ' ����
    Form1.DataGrid1.Columns(1).Width = 1000 ' �̸�
    Form1.DataGrid1.Columns(2).Width = 800  ' �����̸�
    Form1.DataGrid1.Columns(3).Width = 800  ' ����
    Form1.DataGrid1.Columns(4).Width = 1000 ' �ݾ�
    Form1.DataGrid1.Columns(5).Width = 2100 ' �湮����
    Form1.DataGrid1.Columns(4).Alignment = dbgRight
    'DataGrid1.Columns(4).NumberFormat = "#,##0"
End Sub

Private Sub totalPrint()
    '����
    Set cn = New ADODB.Connection
    cn.ConnectionString = dbStr
    cn.Open
    Dim sql As String
    Dim total1 As String
    Dim total2 As String
    
    '�Ŷ�
    Set rs = New ADODB.Recordset
    sql = "SELECT sum(help_money) as �ѱݾ� FROM wedding_main where gubun = '�Ŷ�'"
    rs.Open sql, cn, adOpenStatic
    If IsNull(rs!�ѱݾ�) Then
        total1 = 0
    Else
        total1 = rs!�ѱݾ�
    End If
    
    Form1.lbTotal1.Caption = total1
    '�ź�
    Set rs = New ADODB.Recordset
    sql = "SELECT sum(help_money) as �ѱݾ� FROM wedding_main where gubun = '�ź�'"
    rs.Open sql, cn, adOpenStatic
    If IsNull(rs!�ѱݾ�) Then
        total2 = 0
    Else
        total2 = rs!�ѱݾ�
    End If
    Form1.lbTotal2.Caption = total2
    '��ü
    Form1.lbTotal3.Caption = CLng(total1) + CLng(total2)
    rs.Close
    cn.Close
End Sub

Private Sub Form_load()
    comboSex.AddItem "����"
    comboSex.AddItem "����"
End Sub

