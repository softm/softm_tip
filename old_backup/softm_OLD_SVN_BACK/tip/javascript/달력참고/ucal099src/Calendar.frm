VERSION 5.00
Object = "{FE0065C0-1B7B-11CF-9D53-00AA003C9CB6}#1.1#0"; "COMCT232.OCX"
Begin VB.Form frm_Calendar 
   BorderStyle     =   3  'Fixed Dialog
   Caption         =   "������"
   ClientHeight    =   7425
   ClientLeft      =   3525
   ClientTop       =   1980
   ClientWidth     =   7680
   FillColor       =   &H00C0C0FF&
   BeginProperty Font 
      Name            =   "����ü"
      Size            =   11.25
      Charset         =   129
      Weight          =   400
      Underline       =   0   'False
      Italic          =   0   'False
      Strikethrough   =   0   'False
   EndProperty
   ForeColor       =   &H00C0FFFF&
   Icon            =   "Calendar.frx":0000
   LinkTopic       =   "Form1"
   MaxButton       =   0   'False
   MinButton       =   0   'False
   MouseIcon       =   "Calendar.frx":0442
   ScaleHeight     =   7425
   ScaleWidth      =   7680
   ShowInTaskbar   =   0   'False
   Begin VB.ComboBox Si 
      Height          =   345
      ItemData        =   "Calendar.frx":074C
      Left            =   4920
      List            =   "Calendar.frx":0774
      TabIndex        =   181
      Text            =   "�"
      Top             =   6000
      Width           =   600
   End
   Begin VB.CommandButton cmdSUN 
      BeginProperty Font 
         Name            =   "����"
         Size            =   9
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   420
      Left            =   7080
      Picture         =   "Calendar.frx":07A8
      Style           =   1  'Graphical
      TabIndex        =   54
      Top             =   120
      Width           =   495
   End
   Begin VB.CommandButton cmdCancel 
      Height          =   400
      Left            =   6680
      Picture         =   "Calendar.frx":0932
      Style           =   1  'Graphical
      TabIndex        =   52
      Top             =   6980
      Width           =   855
   End
   Begin VB.CommandButton cmdToday 
      Caption         =   "�� ����"
      BeginProperty Font 
         Name            =   "����"
         Size            =   12
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   400
      Left            =   120
      TabIndex        =   51
      Top             =   6980
      Width           =   1155
   End
   Begin VB.TextBox txtMonth 
      Alignment       =   1  'Right Justify
      BackColor       =   &H00BDFFFF&
      BeginProperty Font 
         Name            =   "�ü�"
         Size            =   15.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   430
      Left            =   2000
      Locked          =   -1  'True
      TabIndex        =   47
      Text            =   "5"
      Top             =   70
      Width           =   495
   End
   Begin ComCtl2.UpDown spnYear 
      Height          =   480
      Left            =   1250
      TabIndex        =   2
      ToolTipText     =   "�⵵�� 1�⾿ �����մϴ�."
      Top             =   50
      Width           =   240
      _ExtentX        =   423
      _ExtentY        =   847
      _Version        =   327681
      Value           =   1800
      AutoBuddy       =   -1  'True
      BuddyControl    =   "txtYear"
      BuddyDispid     =   196614
      OrigLeft        =   1740
      OrigTop         =   60
      OrigRight       =   1980
      OrigBottom      =   375
      Max             =   3000
      Min             =   1800
      SyncBuddy       =   -1  'True
      BuddyProperty   =   0
      Enabled         =   -1  'True
   End
   Begin VB.TextBox txtYear 
      Alignment       =   1  'Right Justify
      BackColor       =   &H00BDFFFF&
      BeginProperty Font 
         Name            =   "�ü�"
         Size            =   15.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   430
      Left            =   360
      Locked          =   -1  'True
      TabIndex        =   1
      Text            =   "2000"
      Top             =   70
      Width           =   900
   End
   Begin ComCtl2.UpDown spnMonth 
      Height          =   480
      Left            =   2520
      TabIndex        =   48
      ToolTipText     =   "���� �����մϴ�."
      Top             =   50
      Width           =   240
      _ExtentX        =   423
      _ExtentY        =   847
      _Version        =   327681
      Value           =   1
      AutoBuddy       =   -1  'True
      BuddyControl    =   "txtMonth"
      BuddyDispid     =   196613
      OrigLeft        =   2580
      OrigTop         =   60
      OrigRight       =   2820
      OrigBottom      =   390
      Max             =   12
      Min             =   1
      SyncBuddy       =   -1  'True
      BuddyProperty   =   0
      Enabled         =   -1  'True
   End
   Begin ComCtl2.UpDown spn10Year 
      Height          =   480
      Left            =   120
      TabIndex        =   0
      ToolTipText     =   "�⵵�� 10�⾿ �����մϴ�."
      Top             =   50
      Width           =   240
      _ExtentX        =   423
      _ExtentY        =   847
      _Version        =   327681
      Value           =   1800
      Alignment       =   0
      AutoBuddy       =   -1  'True
      BuddyControl    =   "txtYear"
      BuddyDispid     =   196614
      OrigLeft        =   1740
      OrigTop         =   60
      OrigRight       =   1980
      OrigBottom      =   375
      Increment       =   10
      Max             =   3000
      Min             =   1800
      SyncBuddy       =   -1  'True
      BuddyProperty   =   0
      Enabled         =   -1  'True
   End
   Begin VB.Label Label2 
      Alignment       =   2  'Center
      AutoSize        =   -1  'True
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   18
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   360
      Index           =   2
      Left            =   5025
      TabIndex        =   182
      Top             =   6360
      Width           =   405
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00FFFFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   9.75
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00000000&
      Height          =   260
      Index           =   10
      Left            =   2310
      TabIndex        =   180
      Top             =   6480
      Width           =   2600
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00FFC0FF&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   9.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00000000&
      Height          =   260
      Index           =   9
      Left            =   2310
      TabIndex        =   179
      Top             =   6220
      Width           =   2600
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00FFFFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   9.75
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00000000&
      Height          =   260
      Index           =   8
      Left            =   2310
      TabIndex        =   178
      Top             =   5950
      Width           =   2600
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00C0FFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   375
      Index           =   7
      Left            =   5540
      TabIndex        =   177
      Top             =   6460
      Width           =   420
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00C0FFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   375
      Index           =   6
      Left            =   5540
      TabIndex        =   176
      Top             =   6000
      Width           =   420
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00C0FFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   375
      Index           =   5
      Left            =   6020
      TabIndex        =   175
      Top             =   6480
      Width           =   420
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00C0FFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   375
      Index           =   4
      Left            =   6020
      TabIndex        =   174
      Top             =   6000
      Width           =   420
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00C0FFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   375
      Index           =   3
      Left            =   6500
      TabIndex        =   173
      Top             =   6460
      Width           =   420
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00C0FFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   375
      Index           =   2
      Left            =   6500
      TabIndex        =   172
      Top             =   6000
      Width           =   420
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00C0FFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   375
      Index           =   1
      Left            =   6980
      TabIndex        =   171
      Top             =   6460
      Width           =   420
   End
   Begin VB.Label Year 
      Alignment       =   2  'Center
      BackColor       =   &H00C0FFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   375
      Index           =   0
      Left            =   6980
      TabIndex        =   170
      Top             =   6000
      Width           =   420
   End
   Begin VB.Label Label2 
      Alignment       =   2  'Center
      AutoSize        =   -1  'True
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   18
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   360
      Index           =   1
      Left            =   6240
      TabIndex        =   169
      Top             =   120
      Width           =   390
   End
   Begin VB.Label Label1 
      Alignment       =   2  'Center
      AutoSize        =   -1  'True
      Caption         =   "Ҵ"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   18
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   360
      Index           =   1
      Left            =   4440
      TabIndex        =   168
      Top             =   120
      Width           =   390
   End
   Begin VB.Label Month 
      Alignment       =   1  'Right Justify
      BackColor       =   &H00C0FFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   495
      Index           =   38
      Left            =   5280
      TabIndex        =   167
      Top             =   70
      Width           =   900
   End
   Begin VB.Label Year 
      Alignment       =   1  'Right Justify
      BackColor       =   &H00C0FFC0&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   495
      Index           =   37
      Left            =   3480
      TabIndex        =   166
      Top             =   70
      Width           =   900
   End
   Begin VB.Shape Shape1 
      Height          =   6300
      Index           =   37
      Left            =   120
      Top             =   600
      Width           =   7460
   End
   Begin VB.Shape Shape1 
      Height          =   910
      Index           =   36
      Left            =   1250
      Top             =   5900
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   910
      Index           =   35
      Left            =   200
      Top             =   5900
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   34
      Left            =   6500
      Top             =   4950
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   33
      Left            =   5450
      Top             =   4950
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   32
      Left            =   4400
      Top             =   4950
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   31
      Left            =   3350
      Top             =   4950
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   30
      Left            =   2300
      Top             =   4950
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   29
      Left            =   1250
      Top             =   4950
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   28
      Left            =   200
      Top             =   4950
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   27
      Left            =   6500
      Top             =   4000
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   26
      Left            =   5450
      Top             =   4000
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   25
      Left            =   4400
      Top             =   4000
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   24
      Left            =   3350
      Top             =   4000
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   23
      Left            =   1250
      Top             =   4000
      Width           =   1005
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   22
      Left            =   2300
      Top             =   4000
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   21
      Left            =   200
      Top             =   4000
      Width           =   1005
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   20
      Left            =   6500
      Top             =   3050
      Width           =   1005
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   19
      Left            =   5450
      Top             =   3050
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   18
      Left            =   4400
      Top             =   3050
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   17
      Left            =   3350
      Top             =   3050
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   16
      Left            =   2300
      Top             =   3050
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   15
      Left            =   1250
      Top             =   3050
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   14
      Left            =   200
      Top             =   3050
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   13
      Left            =   6500
      Top             =   2100
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   12
      Left            =   5450
      Top             =   2100
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   11
      Left            =   4400
      Top             =   2100
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   10
      Left            =   3350
      Top             =   2100
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   9
      Left            =   2300
      Top             =   2100
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   8
      Left            =   1250
      Top             =   2100
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   7
      Left            =   200
      Top             =   2100
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   6
      Left            =   6500
      Top             =   1150
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   5
      Left            =   5450
      Top             =   1150
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   0
      Left            =   200
      Top             =   1150
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   4
      Left            =   4400
      Top             =   1150
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   3
      Left            =   3350
      Top             =   1150
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   2
      Left            =   2300
      Top             =   1150
      Width           =   1000
   End
   Begin VB.Shape Shape1 
      Height          =   900
      Index           =   1
      Left            =   1250
      Top             =   1150
      Width           =   1000
   End
   Begin VB.Label SunToDay 
      Alignment       =   2  'Center
      Caption         =   "2000-01-01"
      BeginProperty Font 
         Name            =   "MS Sans Serif"
         Size            =   13.5
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   375
      Left            =   1440
      TabIndex        =   53
      Top             =   6960
      Width           =   1935
   End
   Begin VB.Label Label2 
      Alignment       =   2  'Center
      AutoSize        =   -1  'True
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   18
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   360
      Index           =   0
      Left            =   2780
      TabIndex        =   50
      Top             =   120
      Width           =   390
   End
   Begin VB.Label Label1 
      Alignment       =   2  'Center
      AutoSize        =   -1  'True
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   18
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   360
      Index           =   0
      Left            =   1500
      TabIndex        =   49
      Top             =   120
      Width           =   390
   End
   Begin VB.Label lblWeek 
      Alignment       =   2  'Center
      BackColor       =   &H00FF0000&
      BorderStyle     =   1  'Fixed Single
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   15.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FFFFFF&
      Height          =   435
      Index           =   6
      Left            =   6500
      TabIndex        =   46
      Top             =   660
      Width           =   1000
   End
   Begin VB.Label lblWeek 
      Alignment       =   2  'Center
      BackColor       =   &H00808000&
      BorderStyle     =   1  'Fixed Single
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   15.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FFFFFF&
      Height          =   435
      Index           =   5
      Left            =   5450
      TabIndex        =   45
      Top             =   660
      Width           =   1000
   End
   Begin VB.Label lblWeek 
      Alignment       =   2  'Center
      BackColor       =   &H00808000&
      BorderStyle     =   1  'Fixed Single
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   15.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FFFFFF&
      Height          =   440
      Index           =   4
      Left            =   4400
      TabIndex        =   44
      Top             =   660
      Width           =   1000
   End
   Begin VB.Label lblWeek 
      Alignment       =   2  'Center
      BackColor       =   &H00808000&
      BorderStyle     =   1  'Fixed Single
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   15.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FFFFFF&
      Height          =   440
      Index           =   3
      Left            =   3350
      TabIndex        =   43
      Top             =   660
      Width           =   1000
   End
   Begin VB.Label lblWeek 
      Alignment       =   2  'Center
      BackColor       =   &H00808000&
      BorderStyle     =   1  'Fixed Single
      Caption         =   "ȭ"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   15.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FFFFFF&
      Height          =   435
      Index           =   2
      Left            =   2300
      TabIndex        =   42
      Top             =   660
      Width           =   1000
   End
   Begin VB.Label lblWeek 
      Alignment       =   2  'Center
      BackColor       =   &H00808000&
      BorderStyle     =   1  'Fixed Single
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   15.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FFFFFF&
      Height          =   435
      Index           =   1
      Left            =   1250
      TabIndex        =   41
      Top             =   660
      Width           =   1000
   End
   Begin VB.Label lblWeek 
      Alignment       =   2  'Center
      BackColor       =   &H000000FF&
      BorderStyle     =   1  'Fixed Single
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   15.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FFFFFF&
      Height          =   435
      Index           =   0
      Left            =   200
      TabIndex        =   40
      Top             =   660
      Width           =   1000
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   36
      Left            =   1250
      TabIndex        =   39
      Top             =   5910
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   500
      Index           =   35
      Left            =   200
      TabIndex        =   38
      Top             =   5910
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF0000&
      Height          =   500
      Index           =   34
      Left            =   6500
      TabIndex        =   37
      Top             =   4950
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   33
      Left            =   5450
      TabIndex        =   36
      Top             =   4950
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   32
      Left            =   4400
      TabIndex        =   35
      Top             =   4950
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   31
      Left            =   3360
      TabIndex        =   34
      Top             =   4950
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   30
      Left            =   2300
      TabIndex        =   33
      Top             =   4950
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   29
      Left            =   1250
      TabIndex        =   32
      Top             =   4950
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   500
      Index           =   28
      Left            =   200
      TabIndex        =   31
      Top             =   4950
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF0000&
      Height          =   500
      Index           =   27
      Left            =   6500
      TabIndex        =   30
      Top             =   4000
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   26
      Left            =   5450
      TabIndex        =   29
      Top             =   4000
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   25
      Left            =   4400
      TabIndex        =   28
      Top             =   4000
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   24
      Left            =   3360
      TabIndex        =   27
      Top             =   4000
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   23
      Left            =   2300
      TabIndex        =   26
      Top             =   4000
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   22
      Left            =   1250
      TabIndex        =   25
      Top             =   4000
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   500
      Index           =   21
      Left            =   195
      TabIndex        =   24
      Top             =   4000
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF0000&
      Height          =   500
      Index           =   20
      Left            =   6500
      TabIndex        =   23
      Top             =   3050
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   19
      Left            =   5450
      TabIndex        =   22
      Top             =   3050
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   18
      Left            =   4400
      TabIndex        =   21
      Top             =   3050
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   17
      Left            =   3360
      TabIndex        =   20
      Top             =   3050
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   16
      Left            =   2300
      TabIndex        =   19
      Top             =   3050
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   15
      Left            =   1250
      TabIndex        =   18
      Top             =   3050
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   500
      Index           =   14
      Left            =   200
      TabIndex        =   17
      Top             =   3050
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF0000&
      Height          =   500
      Index           =   13
      Left            =   6500
      TabIndex        =   16
      Top             =   2100
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   12
      Left            =   5450
      TabIndex        =   15
      Top             =   2100
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   11
      Left            =   4400
      TabIndex        =   14
      Top             =   2100
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   10
      Left            =   3350
      TabIndex        =   13
      Top             =   2100
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   9
      Left            =   2300
      TabIndex        =   12
      Top             =   2100
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   8
      Left            =   1250
      TabIndex        =   11
      Top             =   2100
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   500
      Index           =   7
      Left            =   200
      TabIndex        =   10
      Top             =   2100
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF0000&
      Height          =   500
      Index           =   6
      Left            =   6500
      TabIndex        =   9
      Top             =   1150
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   5
      Left            =   5450
      TabIndex        =   8
      Top             =   1150
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   4
      Left            =   4400
      TabIndex        =   7
      Top             =   1150
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   3
      Left            =   3350
      TabIndex        =   6
      Top             =   1150
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   2
      Left            =   2300
      TabIndex        =   5
      Top             =   1150
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   500
      Index           =   1
      Left            =   1250
      TabIndex        =   4
      Top             =   1150
      Width           =   700
   End
   Begin VB.Label SunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   18
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H000000FF&
      Height          =   500
      Index           =   0
      Left            =   200
      TabIndex        =   3
      Top             =   1150
      Width           =   700
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   36
      Left            =   1950
      TabIndex        =   55
      Top             =   6400
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   35
      Left            =   900
      TabIndex        =   57
      Top             =   6400
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   34
      Left            =   7200
      TabIndex        =   96
      Top             =   5450
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   33
      Left            =   6150
      TabIndex        =   97
      Top             =   5450
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   32
      Left            =   5100
      TabIndex        =   98
      Top             =   5450
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   31
      Left            =   4050
      TabIndex        =   99
      Top             =   5450
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   30
      Left            =   3000
      TabIndex        =   100
      Top             =   5450
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   29
      Left            =   1950
      TabIndex        =   101
      Top             =   5450
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   28
      Left            =   900
      TabIndex        =   102
      Top             =   5450
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   27
      Left            =   7200
      TabIndex        =   103
      Top             =   4500
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   26
      Left            =   6150
      TabIndex        =   104
      Top             =   4500
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   25
      Left            =   5100
      TabIndex        =   105
      Top             =   4500
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   24
      Left            =   4050
      TabIndex        =   106
      Top             =   4500
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   23
      Left            =   3000
      TabIndex        =   107
      Top             =   4500
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   22
      Left            =   1950
      TabIndex        =   108
      Top             =   4500
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   21
      Left            =   900
      TabIndex        =   109
      Top             =   4500
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   20
      Left            =   7200
      TabIndex        =   110
      Top             =   3540
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   19
      Left            =   6150
      TabIndex        =   111
      Top             =   3540
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   18
      Left            =   5100
      TabIndex        =   112
      Top             =   3540
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   17
      Left            =   4050
      TabIndex        =   113
      Top             =   3540
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   16
      Left            =   3000
      TabIndex        =   114
      Top             =   3540
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   15
      Left            =   1950
      TabIndex        =   115
      Top             =   3540
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   14
      Left            =   900
      TabIndex        =   116
      Top             =   3540
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   13
      Left            =   7200
      TabIndex        =   117
      Top             =   2600
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   12
      Left            =   6150
      TabIndex        =   118
      Top             =   2600
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   11
      Left            =   5100
      TabIndex        =   119
      Top             =   2600
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   10
      Left            =   4050
      TabIndex        =   120
      Top             =   2600
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   9
      Left            =   3000
      TabIndex        =   159
      Top             =   2600
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   8
      Left            =   1950
      TabIndex        =   160
      Top             =   2600
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   7
      Left            =   900
      TabIndex        =   162
      Top             =   2600
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   6
      Left            =   7200
      TabIndex        =   163
      Top             =   1650
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   5
      Left            =   6150
      TabIndex        =   165
      Top             =   1650
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   4
      Left            =   5100
      TabIndex        =   164
      Top             =   1650
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   3
      Left            =   4050
      TabIndex        =   161
      Top             =   1650
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   2
      Left            =   3000
      TabIndex        =   158
      Top             =   1650
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   1
      Left            =   1950
      TabIndex        =   56
      Top             =   1650
      Width           =   300
   End
   Begin VB.Label LunDay 
      Alignment       =   1  'Right Justify
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   12
         Charset         =   0
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00C000C0&
      Height          =   400
      Index           =   0
      Left            =   900
      TabIndex        =   58
      Top             =   1650
      Width           =   300
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   36
      Left            =   1260
      TabIndex        =   157
      Top             =   6400
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   35
      Left            =   210
      TabIndex        =   156
      Top             =   6400
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   34
      Left            =   6510
      TabIndex        =   155
      Top             =   5450
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   33
      Left            =   5460
      TabIndex        =   154
      Top             =   5450
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   32
      Left            =   4410
      TabIndex        =   153
      Top             =   5450
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   31
      Left            =   3360
      TabIndex        =   152
      Top             =   5450
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   30
      Left            =   2310
      TabIndex        =   151
      Top             =   5450
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   29
      Left            =   1260
      TabIndex        =   150
      Top             =   5450
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   28
      Left            =   210
      TabIndex        =   149
      Top             =   5450
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   27
      Left            =   6510
      TabIndex        =   148
      Top             =   4500
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   26
      Left            =   5460
      TabIndex        =   147
      Top             =   4500
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   25
      Left            =   4410
      TabIndex        =   146
      Top             =   4500
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   24
      Left            =   3360
      TabIndex        =   145
      Top             =   4500
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   23
      Left            =   2310
      TabIndex        =   144
      Top             =   4500
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   22
      Left            =   1260
      TabIndex        =   143
      Top             =   4500
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   21
      Left            =   210
      TabIndex        =   142
      Top             =   4500
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   20
      Left            =   6510
      TabIndex        =   141
      Top             =   3540
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   19
      Left            =   5460
      TabIndex        =   140
      Top             =   3540
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   18
      Left            =   4410
      TabIndex        =   139
      Top             =   3540
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   17
      Left            =   3360
      TabIndex        =   138
      Top             =   3540
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   16
      Left            =   2310
      TabIndex        =   137
      Top             =   3540
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   15
      Left            =   1260
      TabIndex        =   136
      Top             =   3540
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   14
      Left            =   210
      TabIndex        =   135
      Top             =   3540
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   13
      Left            =   6510
      TabIndex        =   134
      Top             =   2600
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   12
      Left            =   5460
      TabIndex        =   133
      Top             =   2600
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   11
      Left            =   4410
      TabIndex        =   132
      Top             =   2600
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   10
      Left            =   3360
      TabIndex        =   131
      Top             =   2600
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   9
      Left            =   2310
      TabIndex        =   130
      Top             =   2600
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   8
      Left            =   1260
      TabIndex        =   129
      Top             =   2600
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   7
      Left            =   210
      TabIndex        =   128
      Top             =   2600
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   6
      Left            =   6510
      TabIndex        =   127
      Top             =   1650
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   5
      Left            =   5460
      TabIndex        =   126
      Top             =   1650
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   4
      Left            =   4410
      TabIndex        =   125
      Top             =   1650
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   3
      Left            =   3360
      TabIndex        =   124
      Top             =   1650
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   2
      Left            =   2310
      TabIndex        =   123
      Top             =   1650
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   1
      Left            =   1260
      TabIndex        =   122
      Top             =   1650
      Width           =   700
   End
   Begin VB.Label GanJi 
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   15.75
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00008000&
      Height          =   400
      Index           =   0
      Left            =   210
      TabIndex        =   121
      Top             =   1650
      Width           =   700
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   36
      Left            =   1950
      TabIndex        =   95
      Top             =   5910
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   35
      Left            =   900
      TabIndex        =   94
      Top             =   5910
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   34
      Left            =   7200
      TabIndex        =   93
      Top             =   4960
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   33
      Left            =   6150
      TabIndex        =   92
      Top             =   4960
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   32
      Left            =   5100
      TabIndex        =   91
      Top             =   4960
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   31
      Left            =   4050
      TabIndex        =   90
      Top             =   4960
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   30
      Left            =   3000
      TabIndex        =   89
      Top             =   4960
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   29
      Left            =   1950
      TabIndex        =   88
      Top             =   4960
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   28
      Left            =   900
      TabIndex        =   87
      Top             =   4960
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   27
      Left            =   7200
      TabIndex        =   86
      Top             =   4020
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   26
      Left            =   6150
      TabIndex        =   85
      Top             =   4020
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   25
      Left            =   5100
      TabIndex        =   84
      Top             =   4020
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   24
      Left            =   4050
      TabIndex        =   83
      Top             =   4020
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   23
      Left            =   3000
      TabIndex        =   82
      Top             =   4020
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   22
      Left            =   1950
      TabIndex        =   81
      Top             =   4020
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   21
      Left            =   900
      TabIndex        =   80
      Top             =   4020
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   20
      Left            =   7200
      TabIndex        =   79
      Top             =   3060
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   19
      Left            =   6150
      TabIndex        =   78
      Top             =   3060
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   18
      Left            =   5100
      TabIndex        =   77
      Top             =   3060
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   17
      Left            =   4050
      TabIndex        =   76
      Top             =   3060
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   16
      Left            =   3000
      TabIndex        =   75
      Top             =   3060
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   15
      Left            =   1950
      TabIndex        =   74
      Top             =   3060
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   14
      Left            =   900
      TabIndex        =   73
      Top             =   3060
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   13
      Left            =   7200
      TabIndex        =   72
      Top             =   2110
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   12
      Left            =   6150
      TabIndex        =   71
      Top             =   2110
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   11
      Left            =   5100
      TabIndex        =   70
      Top             =   2110
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   10
      Left            =   4050
      TabIndex        =   69
      Top             =   2110
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   9
      Left            =   3000
      TabIndex        =   68
      Top             =   2110
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   8
      Left            =   1950
      TabIndex        =   67
      Top             =   2110
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   7
      Left            =   900
      TabIndex        =   66
      Top             =   2110
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   6
      Left            =   7200
      TabIndex        =   65
      Top             =   1170
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   5
      Left            =   6150
      TabIndex        =   64
      Top             =   1170
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   4
      Left            =   5100
      TabIndex        =   63
      Top             =   1170
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   3
      Left            =   4050
      TabIndex        =   62
      Top             =   1170
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   2
      Left            =   3000
      TabIndex        =   61
      Top             =   1170
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   1
      Left            =   1950
      TabIndex        =   60
      Top             =   1170
      Width           =   300
   End
   Begin VB.Label TxtDay 
      Alignment       =   2  'Center
      BackColor       =   &H80000005&
      BeginProperty Font 
         Name            =   "Times New Roman"
         Size            =   11.25
         Charset         =   0
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H00FF00FF&
      Height          =   500
      Index           =   0
      Left            =   900
      TabIndex        =   59
      Top             =   1170
      Width           =   300
   End
End
Attribute VB_Name = "frm_Calendar"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Option Explicit
Dim FV_PreIndex As Integer
'======================================================================================
'������ ���Ѵ�.
'======================================================================================
Private Function FF_GetLastDay(nYear As Integer, nMonth As Integer) As Integer
Dim nMaxDay
    nMaxDay = Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)
        
    If nMonth = 2 Then
       If (nYear Mod 400) = 0 Or (nYear Mod 100) <> 0 And (nYear Mod 4) = 0 Then
          nMaxDay(1) = 29
       End If
    End If
    FF_GetLastDay = nMaxDay(nMonth - 1)
    
End Function
'======================================================================================
' 8�ڸ� ��¥������ �����´�.
'======================================================================================
Private Function FF_Get8Date(Index As Integer) As String
    '�⵵�� ���δ�.
    FF_Get8Date = txtYear.Text
    '���� ���δ�.
    If CInt(txtMonth.Text) < 10 Then FF_Get8Date = FF_Get8Date + "0"
    FF_Get8Date = FF_Get8Date + txtMonth.Text
    '���� ���δ�.
    If CInt(SunDay(Index).Caption) < 10 Then FF_Get8Date = FF_Get8Date + "0"
    FF_Get8Date = FF_Get8Date + SunDay(Index).Caption
End Function

'======================================================================================
' ������ ǥ��
'======================================================================================
Private Function Ymd_Cal(i_us_Gan As Integer, i_us_Ji As Integer) As String
Dim Gan, Ji As String
            Select Case i_us_Gan
                Case 1: Gan = "ˣ"
                Case 2: Gan = "��"
                Case 3: Gan = "ܰ"
                Case 4: Gan = "��"
                Case 5: Gan = "��"
                Case 6: Gan = "��"
                Case 7: Gan = "��"
                Case 8: Gan = "��"
                Case 9: Gan = "��"
                Case 10, 0: Gan = "ͤ"
                Case Else: Gan = "??"
            End Select

            Select Case i_us_Ji
                Case 1, 13: Ji = "�"
                Case 2, 14: Ji = "��"
                Case 3: Ji = "��"
                Case 4: Ji = "��"
                Case 5: Ji = "��"
                Case 6: Ji = "��"
                Case 7: Ji = "��"
                Case 8: Ji = "ڱ"
                Case 9: Ji = "��"
                Case 10: Ji = "�"
                Case 11: Ji = "��"
                Case 12, 0: Ji = "��"
                Case Else: Ji = "!!"
            End Select
 Ymd_Cal = Gan & Ji
End Function
Private Function Back_Gan(Gan As String) As String
Dim Gan2 As String
            Select Case Gan
                Case "ˣ": Gan2 = "ͤ"
                Case "��": Gan2 = "ˣ"
                Case "ܰ": Gan2 = "��"
                Case "��": Gan2 = "ܰ"
                Case "��": Gan2 = "��"
                Case "��": Gan2 = "��"
                Case "��": Gan2 = "��"
                Case "��": Gan2 = "��"
                Case "��": Gan2 = "��"
                Case "ͤ": Gan2 = "��"
                Case Else: Gan2 = "??"
            End Select
 Back_Gan = Gan2
End Function
Private Function Back_Ji(Ji As String) As String
Dim Ji2 As String
            Select Case Ji
                Case "�": Ji2 = "��"
                Case "��": Ji2 = "�"
                Case "��": Ji2 = "��"
                Case "��": Ji2 = "��"
                Case "��": Ji2 = "��"
                Case "��": Ji2 = "��"
                Case "��": Ji2 = "��"
                Case "ڱ": Ji2 = "��"
                Case "��": Ji2 = "ڱ"
                Case "�": Ji2 = "��"
                Case "��": Ji2 = "�"
                Case "��": Ji2 = "��"
                Case Else: Ji2 = "!!"
            End Select
 Back_Ji = Ji2
End Function

'======================================================================================
'�޷��� �����.
'======================================================================================
Private Sub FP_DisplayCalendar()
Dim i As Integer
Dim j As Integer
Dim nWeek As Integer '���ۿ���
Dim nLast As Integer '����
'Dim s_Saju(1 To 8) As String
Dim i_year As Integer
Dim i_Month As Integer
Dim i_Day As Integer
Dim i_Yun As Boolean
Dim b_Err As Boolean


    nLast = FF_GetLastDay(CInt(txtYear.Text), CInt(txtMonth.Text))
    nWeek = Weekday(txtYear.Text + "-" + txtMonth.Text + "-01")
    
    '��� ������ 1�� 1���� ���� ���ڷ� ȯ��---------------------
    i_year = CInt(txtYear.Text)
    i_Month = CInt(txtMonth.Text)
    i_Day = 1
    i_Yun = False
    b_Err = gf_Sun2Lun(i_year, i_Month, i_Day, i_Yun)
    
    
'************************************************************
' ������ �¼�, ����, ���� ���ϱ�
'************************************************************
 Dim i_year2, i_us_Gan, i_us_Ji, i_us2_Gan, i_us2_Ji, il_Gan, il_Ji As Integer
 
 '-----------------------------------------------------------
    Dim d_In, d_pD, d_nD, d_lD As Date       '������ ��Ÿ����
    Dim i_pD, i_nD, i_lD As Integer
'-----------------------------------------------(������ ǥ��)
    d_In = DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), 1) + TimeSerial(0, 0, 0)        '__�������
    d_pD = f_Pre_Div24((d_In))
    d_nD = f_Next_Div24((d_In))
    d_lD = f_Next_Div24((d_nD))
    i_pD = fi_Pre_Div24((d_In))
    i_nD = i_pD + 1:    If i_nD > 24 Then i_nD = i_nD - 24
    i_lD = i_pD + 2:    If i_lD > 24 Then i_lD = i_lD - 24
 
   Year(8).Caption = f_SajuStr((i_pD), Div) & ": " & d_pD
   Year(9).Caption = f_SajuStr((i_nD), Div) & ": " & d_nD
   Year(10).Caption = f_SajuStr((i_lD), Div) & ": " & d_lD
 
'------------------------------------------------------------
' ������ ����(Ҵ�) ���ϱ�
'------------------------------------------------------------
  
    '��� 1���� ���� �������� ���� �ʾұ⿡ ���⵵ ���ָ� �����..
    If CInt(txtMonth.Text) = 1 Then i_year2 = CInt(txtYear.Text) - 1 Else i_year2 = CInt(txtYear.Text) '���ִ� ��� 2���� ���� �ٲ�..
    '����õ�� ���ϱ� : 1924���� ˣ����
        i_us_Gan = (i_year2 - 1924 + 1) Mod 10
        If i_us_Gan <= 0 Then i_us_Gan = 10 + i_us_Gan
    '�������� ���ϱ� : 1924���� ���ڳ���
        i_us_Ji = (i_year2 - 1924 + 1) Mod 12
        If i_us_Ji <= 0 Then i_us_Ji = 12 + i_us_Ji
    Year(37).Caption = Ymd_Cal(CInt(i_us_Gan), CInt(i_us_Ji))
    Year(0).Caption = Mid(Year(37).Caption, 1, 1)                   '���������� �Ⱓ
    Year(1).Caption = Mid(Year(37).Caption, 2, 1)                   '���������� ����
'------------------------------------------------------------
' ������ ����(���) ���ϱ�
'------------------------------------------------------------
    '�������� ���ϱ�
    i_us2_Ji = (CInt(txtMonth.Text) + 1) Mod 12  '�ų� ��� 1���� ����̸� 2������ �ٿ��̴�.
            
    Select Case i_us_Gan
           Case 1, 6:  i_us2_Gan = 3 + CInt(txtMonth.Text) ' "��" ˣ����Ҵ ܰ����
           Case 2, 7:  i_us2_Gan = 5 + CInt(txtMonth.Text) ' "��" ������Ҵ ������
           Case 3, 8:  i_us2_Gan = 7 + CInt(txtMonth.Text) ' "��" ܰ����Ҵ ������
           Case 4, 9:  i_us2_Gan = 9 + CInt(txtMonth.Text) ' "��" ������Ҵ ������
           Case 5, 10: i_us2_Gan = 1 + CInt(txtMonth.Text) ' "��" ��ͤ��Ҵ ˣ����
           Case Else: i_us2_Gan = "??"
    End Select
    
    If CInt(txtMonth.Text) = 1 Then i_us2_Gan = i_us2_Gan + 2
    i_us2_Gan = (i_us2_Gan - 2) Mod 10
    If i_us2_Gan <= 0 Then i_us2_Gan = 10 + i_us2_Gan
    Month(38).Caption = Ymd_Cal(CInt(i_us2_Gan), CInt(i_us2_Ji))
    
    Year(2).Caption = Mid(Month(38).Caption, 1, 1)                 '���������� ����
    Year(3).Caption = Mid(Month(38).Caption, 2, 1)                 '���������� ����

'------------------------------------------------------------
' ������ ����(���) ���ϱ�
'------------------------------------------------------------
    '����:1901�� 1�� 1�� ����(�⹦��)
    il_Gan = (DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), 1) _
                - DateSerial(1901, 1, 1) + 6) Mod 10
    If il_Gan <= 0 Then il_Gan = 10 + il_Gan
    
    il_Ji = (DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), 1) _
                - DateSerial(1901, 1, 1) + 4) Mod 12
    If il_Ji <= 0 Then il_Ji = 12 + il_Ji
  
        
    'MsgBox "��/��/����=" & CInt(txtMonth.Text) & "��" & CInt(txtMonth.Text) & "��" & il_Gan & "+" & il_Ji, vbOKOnly, "�Ѩ��(������)"
    'MsgBox "������=" & CInt(txtMonth.Text) & "��=" & Gan2, vbOKOnly, "�Ѩ��(������)"
    'MsgBox "�Ⱓ��=" & Gan & Ji, vbOKOnly, "�Ѩ��(������)"
    'MsgBox "������=" & Gan & Ji, vbOKOnly, "�Ѩ��(������)"
    'If b_Err = False Then
    '  MsgBox "�߸��� �����Դϴ�."
    'End If
    
'************************************************************
    For i = 0 To 36
        If i < nWeek - 1 Then
            SunDay(i).Caption = ""
            LunDay(i).Caption = ""
            TxtDay(i).Caption = ""
            GanJi(i).Caption = ""
        ElseIf i > nLast + nWeek - 2 Then
            SunDay(i).Caption = ""
            LunDay(i).Caption = ""
            TxtDay(i).Caption = ""
            GanJi(i).Caption = ""
        Else
            'If CStr(SunDay(i).Caption) < 10 Then SunDay.Alignment = 2
            SunDay(i).Caption = CStr(i - nWeek + 2)  '����� ǥ��
            LunDay(i).Caption = CStr(i_Day)   '������ ǥ��
            GanJi(i).Caption = Ymd_Cal(CInt(il_Gan), CInt(il_Ji)) '60���� ����(���)ǥ��
            il_Gan = il_Gan + 1
            If il_Gan > 10 Then il_Gan = il_Gan - 10
            il_Ji = il_Ji + 1
            If il_Ji > 12 Then il_Ji = il_Ji - 12
            If CInt(LunDay(i).Caption) = 1 Then
               TxtDay(i).Caption = CStr(i_Month) & vbCrLf & "��"      '��������ǥ��
               If bYun = 1 Then
                  TxtDay(i).Caption = "��" & vbCrLf & CStr(i_Month)   '��������ǥ��
               End If
            Else
                TxtDay(i).Caption = ""
            End If
            
           'GanJi(i).Caption = CStr(i - nWeek + 2)  '60���� ����(���)ǥ��

            
            If i_Day > 28 And nLast > CInt(SunDay(i).Caption) Then
               i_year = CInt(txtYear.Text)
               i_Month = CInt(txtMonth.Text)
               i_Day = CInt(SunDay(i).Caption) + 1
               i_Yun = False
               'MsgBox "��� ��/��=" & CStr(i_Month) & "/" & CStr(i_Day),vbOKOnly, "�Ѩ��(������)"
               Call gf_Sun2Lun(i_year, i_Month, i_Day, i_Yun)
               'MsgBox "���� ��/��=" & CStr(i_Month) & "/" & CStr(i_Day),vbOKOnly, "�Ѩ��(������)"
'              If i_Day = 1 Then TxtDay(i + 1).Caption = CStr(i_Month) & "��"
'              Else: i_Day = 30
'              End If
            Else
               i_Day = i_Day + 1
            End If
 
        End If
    Next
End Sub
'======================================================================================
'����
'======================================================================================
Private Sub cmdCancel_Click()
    Unload Me
End Sub
'======================================================================================
'����
'======================================================================================
Private Sub cmdSUN_Click()
    GV_sCalendarDate = Format$(Now, "YYYYMMDD")
    GV_bCalendarDateSelect = True
    Unload Me
End Sub
'======================================================================================
'����
'======================================================================================
Private Sub cmdToday_Click()
Dim i As Integer
Dim il_Gan, il_Ji As Integer
    
    txtYear.Text = Format$(Now, "YYYY")
    txtMonth.Text = CStr(CInt(Format$(Now, "MM")))
    
    SunToDay.Caption = Format$(Now, "YYYY-MM-DD")
    
    For i = 0 To 36
        If SunDay(i).Caption = CStr(CInt(Format$(Now, "DD"))) Then
           If (FV_PreIndex > -1) Then
               SunDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
               LunDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
               TxtDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
               GanJi(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
            End If
            SunDay(i).BackColor = vbBlue 'GC_SelColor ������
            LunDay(i).BackColor = vbBlue
            TxtDay(i).BackColor = vbBlue
            GanJi(i).BackColor = vbBlue
            FV_PreIndex = i
            Exit For
        End If
    Next
   
    il_Gan = (DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), CInt(SunDay(i).Caption)) _
                - DateSerial(1901, 1, 1) + 6) Mod 10
    If il_Gan <= 0 Then il_Gan = 10 + il_Gan
    il_Ji = (DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), CInt(SunDay(i).Caption)) _
                - DateSerial(1901, 1, 1) + 4) Mod 12
    If il_Ji <= 0 Then il_Ji = 12 + il_Ji
   
   Year(4).Caption = Mid(Ymd_Cal(CInt(il_Gan), CInt(il_Ji)), 1, 1)   '���������� �ϰ�
   Year(5).Caption = Mid(Ymd_Cal(CInt(il_Gan), CInt(il_Ji)), 2, 1)   '���������� ����
   Call Si_Click
  
End Sub
'======================================================================================
'����
'======================================================================================
Private Sub Form_Activate()
    If Me.Tag = "" Then
        txtYear.Text = Format$(Now, "YYYY")
        txtMonth.Text = CStr(CInt(Format$(Now, "MM")))
    Else
        txtYear.Text = Left$(Me.Tag, 4)
        txtMonth.Text = CStr(CInt(Mid$(Me.Tag, 5, 2)))
    End If
FP_DisplayCalendar
End Sub

'======================================================================================
'�� ó�� ����
'======================================================================================
Private Sub Form_Load()
    FV_PreIndex = -1

End Sub

'------------------------------------
' �������� �ٲ� ��
'------------------------------------
Private Sub Si_Click()    '(Text As String) 'Si_Change()
Dim i_Gan, i_Ji As Integer
   
   Year(7).Caption = Si.Text                            '���������� ����
   
  ' MsgBox "�ϰ�=" & Mid(Year(4).Caption, 1, 1), vbOKOnly, "�Ѩ��(������)"
  
   Select Case Mid(Year(4).Caption, 1, 1)
         Case "ˣ", "��": i_Gan = 1 'ˣ������ ˣ�����"
         Case "��", "��": i_Gan = 3 '�������� ܰ�����"
         Case "ܰ", "��": i_Gan = 5 'ܰ������ �������"
         Case "��", "��": i_Gan = 7 '�������� �������"
         Case "��", "ͤ": i_Gan = 9 '��ͤ���� �������
         Case Else: Si.Text = "??"
   End Select
  
   ' ˣ�, ����, ˣ��, ����, ˣ��, ����, ˣ��, ����, ˣ��, ���, ˣ��, ��ڱ: ˣ������ ˣ�����
   ' ����, ����, ����, ����, ���, ����, ��ڱ, ���, ����, ����, ����, ����: �������� ܰ�����
   ' ܰ��, ��ڱ, ܰ�, ����, ܰ��, ����, ܰ��, ����, ܰ��, ����, ܰ��, ���: ܰ������ �������
   ' ����, ����, ����, ����, ����, ����, ���, ����, ��ڱ, ���, ����, ����: �������� �������
   ' ����, ͤ�, ����, ͤڱ, ���, ͤ��, ����, ͤ��, ����, ͤ��, ����, ͤ��: ��ͤ���� �������
    
   Select Case Si.Text
          Case "�": i_Ji = 1
          Case "��": i_Ji = 2
          Case "��": i_Ji = 3
          Case "��": i_Ji = 4
          Case "��": i_Ji = 5
          Case "��": i_Ji = 6
          Case "��": i_Ji = 7
          Case "ڱ": i_Ji = 8
          Case "��": i_Ji = 9
          Case "�": i_Ji = 10
          Case "��": i_Ji = 11
          Case "��": i_Ji = 12
          Case Else: Year(6).Caption = "??"
   End Select
    
   i_Gan = i_Gan + i_Ji - 1
   If i_Gan > 10 Then i_Gan = i_Gan Mod 10
   Year(6).Caption = Mid(Ymd_Cal(CInt(i_Gan), i_Ji), 1, 1)

End Sub

'======================================================================================
'��¥�� �����Ҷ�
'======================================================================================
Private Sub SunDay_Click(Index As Integer)
Dim i_Gan, i_Ji As Integer
   
    If SunDay(Index).Caption = "" Then
        Unload Me
        Exit Sub
    End If
      
    GV_sCalendarDate = FF_Get8Date(Index)
    GV_bCalendarDateSelect = True
    Call Si_Click
    
  MsgBox Year(0).Caption & Year(1).Caption & "��" & Year(2).Caption & Year(3).Caption & "��" & GanJi(Index).Caption & "��" & Year(6).Caption & Year(7).Caption & "�� �Դϴ�.", vbOKOnly, "�Ѩ��(������)"
  ' Unload Me
End Sub

'======================================================================================
'���콺�� ������ ��
'======================================================================================
 Private Sub SunDay_MouseMove(Index As Integer, Button As Integer, Shift As Integer, X As Single, Y As Single)
 Dim sDate As String
 Dim d_In, d_pD, d_tmp As Date                       '������ ��Ÿ����
 Dim i As Integer
 Dim a_Ji As Integer

   If (FV_PreIndex = Index) Then Exit Sub
   If (FV_PreIndex > -1) Then
      SunDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      LunDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      TxtDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      GanJi(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
   End If
      
      SunDay(Index).BackColor = vbGreen 'GC_SelColor ������
      LunDay(Index).BackColor = vbGreen
      TxtDay(Index).BackColor = vbGreen
      GanJi(Index).BackColor = vbGreen
      FV_PreIndex = Index
      
    If SunDay(Index).Caption = "" Then
       SunToDay.Caption = ""
    Else
       sDate = FF_Get8Date(Index)
       SunToDay.Caption = Left$(sDate, 4) + "-" + Mid$(sDate, 5, 2) + "-" + Right$(sDate, 2)
    End If
   
   If SunDay(Index).Caption <> "" Then
       Year(4).Caption = Mid(GanJi(Index).Caption, 1, 1)   '���������� �ϰ�
       Year(5).Caption = Mid(GanJi(Index).Caption, 2, 1)   '���������� ����
       Call Si_Click     '��񺼼���
   
       Select Case Si.Text
          Case "�": a_Ji = 1
          Case "��": a_Ji = 3
          Case "��": a_Ji = 5
          Case "��": a_Ji = 7
          Case "��": a_Ji = 9
          Case "��": a_Ji = 11
          Case "��": a_Ji = 13
          Case "ڱ": a_Ji = 15
          Case "��": a_Ji = 17
          Case "�": a_Ji = 19
          Case "��": a_Ji = 21
          Case "��": a_Ji = 23
          Case Else: a_Ji = 0  '���� �Է��� ���� ���� �ʱⰪ�� 0����..
       End Select
       
       d_In = DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), CInt(SunDay(Index).Caption)) + TimeSerial(a_Ji, 30, 0)   '__�������
       d_tmp = DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), 15) + TimeSerial(0, 0, 0)   '__�������
       d_pD = f_Pre_Div24((d_tmp))  ' ���ֱ��� ���Ա�
       
      '---------------------------------------------(yy-mm-dd ��-��-���� ���� ǥ��)
      ' �ѱ� ����� ������ 6.0 or ����� ��Ʃ��� 6.0
      ' �ý����� ��翡 ���� ������ dd/mm/yy,('0'� ����),
      ' yy-mm-dd, yyyy-mm-dd ��-��-�Ϸ� ���ǥ�Ⱑ ���� �ٸ���.
      '------------------------------------------------------------
      
    'MsgBox "�������=" & d_In & " ��������=" & d_pD, vbOKOnly, "�Ѩ��(������)"
    '  MsgBox DateDiff("yyyy", d_pD, d_In)   '�� ���̼�
    '  MsgBox DateDiff("m", d_pD, d_In)      '�� ���̼�
    '  MsgBox DateDiff("d", d_pD, d_In)      '�� ���̼�
    '  MsgBox DateDiff("h", d_pD, d_In)      '�� ���̼�
    '  MsgBox DateDiff("n", d_pD, d_In)      '�� ���̼�
    '  MsgBox DateDiff("s", d_pD, d_In)      .�� ���̼�
      
      If DateDiff("d", d_pD, d_In) < 0 Then    '���缱���� - �������� 0���� ���� �� yy-mm-dd ��-��-���� �ϼ�����
            Year(2).Caption = Back_Gan(Mid(Month(38).Caption, 1, 1))  '����
            Year(3).Caption = Back_Ji(Mid(Month(38).Caption, 2, 1))   '����
    
           If CInt(txtMonth.Text) = 2 Then
              Year(0).Caption = Back_Gan(Mid(Year(37).Caption, 1, 1)) '���������� �Ⱓ(���⵵)
              Year(1).Caption = Back_Ji(Mid(Year(37).Caption, 2, 1))  '���������� ����(���⵵)
           End If
       
       Else
            Year(0).Caption = Mid(Year(37).Caption, 1, 1)  '���������� �Ⱓ(�ݳ�)
            Year(1).Caption = Mid(Year(37).Caption, 2, 1)  '���������� ����(�ݳ�)
            Year(2).Caption = Mid(Month(38).Caption, 1, 1) '���������� ����
            Year(3).Caption = Mid(Month(38).Caption, 2, 1) '���������� ����
           
           If DateDiff("d", d_pD, d_In) = 0 Then    '�������� �������϶�
              If DateDiff("n", d_pD, d_In) < 0 Then '�������� �ð��� ���Խð����� ���� ��
                'MsgBox "����ð�-���Խð�(��)=" & DateDiff("n", d_In, d_pD), vbOKOnly, "�Ѩ��(����"
                 Year(2).Caption = Back_Gan(Mid(Month(38).Caption, 1, 1))  '����
                 Year(3).Caption = Back_Ji(Mid(Month(38).Caption, 2, 1))   '����
                 If CInt(txtMonth.Text) = 2 Then    '��� 2���̸� ���⵵ �¼��� �ٲ��.
                    Year(0).Caption = Back_Gan(Mid(Year(37).Caption, 1, 1)) '���������� �Ⱓ(���⵵)
                    Year(1).Caption = Back_Ji(Mid(Year(37).Caption, 2, 1))  '���������� ����(���⵵)
                 End If
              Else
                 Year(0).Caption = Mid(Year(37).Caption, 1, 1)  '���������� �Ⱓ(�ݳ�)
                 Year(1).Caption = Mid(Year(37).Caption, 2, 1)  '���������� ����(�ݳ�)
                 Year(2).Caption = Mid(Month(38).Caption, 1, 1) '���������� ����
                 Year(3).Caption = Mid(Month(38).Caption, 2, 1) '���������� ����
              End If
           End If
       End If
         
'   Else
'       Year(4).Caption = ""
'       Year(5).Caption = ""
'       Year(6).Caption = ""
  End If
End Sub
 Private Sub LunDay_MouseMove(Index As Integer, Button As Integer, Shift As Integer, X As Single, Y As Single)
 Dim sDate As String
 Dim d_In, d_pD, d_tmp As Date                       '������ ��Ÿ����
 Dim i As Integer
 Dim a_Ji As Integer

   If (FV_PreIndex = Index) Then Exit Sub
   If (FV_PreIndex > -1) Then
      SunDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      LunDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      TxtDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      GanJi(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
   End If
      
      SunDay(Index).BackColor = vbGreen 'GC_SelColor ������
      LunDay(Index).BackColor = vbGreen
      TxtDay(Index).BackColor = vbGreen
      GanJi(Index).BackColor = vbGreen
      FV_PreIndex = Index
      
    If SunDay(Index).Caption = "" Then
       SunToDay.Caption = ""
    Else
       sDate = FF_Get8Date(Index)
       SunToDay.Caption = Left$(sDate, 4) + "-" + Mid$(sDate, 5, 2) + "-" + Right$(sDate, 2)
    End If
   
   If SunDay(Index).Caption <> "" Then
       Year(4).Caption = Mid(GanJi(Index).Caption, 1, 1)   '���������� �ϰ�
       Year(5).Caption = Mid(GanJi(Index).Caption, 2, 1)   '���������� ����
       Call Si_Click     '��񺼼���
   
       Select Case Si.Text
          Case "�": a_Ji = 1
          Case "��": a_Ji = 3
          Case "��": a_Ji = 5
          Case "��": a_Ji = 7
          Case "��": a_Ji = 9
          Case "��": a_Ji = 11
          Case "��": a_Ji = 13
          Case "ڱ": a_Ji = 15
          Case "��": a_Ji = 17
          Case "�": a_Ji = 19
          Case "��": a_Ji = 21
          Case "��": a_Ji = 23
          Case Else: a_Ji = 0  '���� �Է��� ���� ���� �ʱⰪ�� 0����..
       End Select
       
       d_In = DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), CInt(SunDay(Index).Caption)) + TimeSerial(a_Ji, 30, 0)   '__�������
       d_tmp = DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), 15) + TimeSerial(0, 0, 0)   '__�������
       d_pD = f_Pre_Div24((d_tmp))  ' ���ֱ��� ���Ա�
       
If DateDiff("d", d_pD, d_In) < 0 Then    '���缱���� - �������� 0���� ���� �� yy-mm-dd ��-��-���� �ϼ�����
            Year(2).Caption = Back_Gan(Mid(Month(38).Caption, 1, 1))  '����
            Year(3).Caption = Back_Ji(Mid(Month(38).Caption, 2, 1))   '����
    
           If CInt(txtMonth.Text) = 2 Then
              Year(0).Caption = Back_Gan(Mid(Year(37).Caption, 1, 1)) '���������� �Ⱓ(���⵵)
              Year(1).Caption = Back_Ji(Mid(Year(37).Caption, 2, 1))  '���������� ����(���⵵)
           End If
       
       Else
            Year(0).Caption = Mid(Year(37).Caption, 1, 1)  '���������� �Ⱓ(�ݳ�)
            Year(1).Caption = Mid(Year(37).Caption, 2, 1)  '���������� ����(�ݳ�)
            Year(2).Caption = Mid(Month(38).Caption, 1, 1) '���������� ����
            Year(3).Caption = Mid(Month(38).Caption, 2, 1) '���������� ����
           
           If DateDiff("d", d_pD, d_In) = 0 Then    '�������� �������϶�
              If DateDiff("n", d_pD, d_In) < 0 Then '�������� �ð��� ���Խð����� ���� ��
                 Year(2).Caption = Back_Gan(Mid(Month(38).Caption, 1, 1))  '����
                 Year(3).Caption = Back_Ji(Mid(Month(38).Caption, 2, 1))   '����
                 If CInt(txtMonth.Text) = 2 Then    '��� 2���̸� ���⵵ �¼��� �ٲ��.
                    Year(0).Caption = Back_Gan(Mid(Year(37).Caption, 1, 1)) '���������� �Ⱓ(���⵵)
                    Year(1).Caption = Back_Ji(Mid(Year(37).Caption, 2, 1))  '���������� ����(���⵵)
                 End If
              Else
                 Year(0).Caption = Mid(Year(37).Caption, 1, 1)  '���������� �Ⱓ(�ݳ�)
                 Year(1).Caption = Mid(Year(37).Caption, 2, 1)  '���������� ����(�ݳ�)
                 Year(2).Caption = Mid(Month(38).Caption, 1, 1) '���������� ����
                 Year(3).Caption = Mid(Month(38).Caption, 2, 1) '���������� ����
              End If
           End If
       End If
  End If
 End Sub
 Private Sub GanJi_MouseMove(Index As Integer, Button As Integer, Shift As Integer, X As Single, Y As Single)
 Dim sDate As String
 Dim d_In, d_pD, d_tmp As Date                       '������ ��Ÿ����
 Dim i As Integer
 Dim a_Ji As Integer

   If (FV_PreIndex = Index) Then Exit Sub
   If (FV_PreIndex > -1) Then
      SunDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      LunDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      TxtDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      GanJi(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
   End If
      
      SunDay(Index).BackColor = vbGreen 'GC_SelColor ������
      LunDay(Index).BackColor = vbGreen
      TxtDay(Index).BackColor = vbGreen
      GanJi(Index).BackColor = vbGreen
      FV_PreIndex = Index
      
    If SunDay(Index).Caption = "" Then
       SunToDay.Caption = ""
    Else
       sDate = FF_Get8Date(Index)
       SunToDay.Caption = Left$(sDate, 4) + "-" + Mid$(sDate, 5, 2) + "-" + Right$(sDate, 2)
    End If
   
   If SunDay(Index).Caption <> "" Then
       Year(4).Caption = Mid(GanJi(Index).Caption, 1, 1)   '���������� �ϰ�
       Year(5).Caption = Mid(GanJi(Index).Caption, 2, 1)   '���������� ����
       Call Si_Click     '��񺼼���
   
       Select Case Si.Text
          Case "�": a_Ji = 1
          Case "��": a_Ji = 3
          Case "��": a_Ji = 5
          Case "��": a_Ji = 7
          Case "��": a_Ji = 9
          Case "��": a_Ji = 11
          Case "��": a_Ji = 13
          Case "ڱ": a_Ji = 15
          Case "��": a_Ji = 17
          Case "�": a_Ji = 19
          Case "��": a_Ji = 21
          Case "��": a_Ji = 23
          Case Else: a_Ji = 0  '���� �Է��� ���� ���� �ʱⰪ�� 0����..
       End Select
       
       d_In = DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), CInt(SunDay(Index).Caption)) + TimeSerial(a_Ji, 30, 0)   '__�������
       d_tmp = DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), 15) + TimeSerial(0, 0, 0)   '__�������
       d_pD = f_Pre_Div24((d_tmp))  ' ���ֱ��� ���Ա�
       
If DateDiff("d", d_pD, d_In) < 0 Then    '���缱���� - �������� 0���� ���� �� yy-mm-dd ��-��-���� �ϼ�����
            Year(2).Caption = Back_Gan(Mid(Month(38).Caption, 1, 1))  '����
            Year(3).Caption = Back_Ji(Mid(Month(38).Caption, 2, 1))   '����
    
           If CInt(txtMonth.Text) = 2 Then
              Year(0).Caption = Back_Gan(Mid(Year(37).Caption, 1, 1)) '���������� �Ⱓ(���⵵)
              Year(1).Caption = Back_Ji(Mid(Year(37).Caption, 2, 1))  '���������� ����(���⵵)
           End If
       
       Else
            Year(0).Caption = Mid(Year(37).Caption, 1, 1)  '���������� �Ⱓ(�ݳ�)
            Year(1).Caption = Mid(Year(37).Caption, 2, 1)  '���������� ����(�ݳ�)
            Year(2).Caption = Mid(Month(38).Caption, 1, 1) '���������� ����
            Year(3).Caption = Mid(Month(38).Caption, 2, 1) '���������� ����
           
           If DateDiff("d", d_pD, d_In) = 0 Then    '�������� �������϶�
              If DateDiff("n", d_pD, d_In) < 0 Then '�������� �ð��� ���Խð����� ���� ��
                 Year(2).Caption = Back_Gan(Mid(Month(38).Caption, 1, 1))  '����
                 Year(3).Caption = Back_Ji(Mid(Month(38).Caption, 2, 1))   '����
                 If CInt(txtMonth.Text) = 2 Then    '��� 2���̸� ���⵵ �¼��� �ٲ��.
                    Year(0).Caption = Back_Gan(Mid(Year(37).Caption, 1, 1)) '���������� �Ⱓ(���⵵)
                    Year(1).Caption = Back_Ji(Mid(Year(37).Caption, 2, 1))  '���������� ����(���⵵)
                 End If
              Else
                 Year(0).Caption = Mid(Year(37).Caption, 1, 1)  '���������� �Ⱓ(�ݳ�)
                 Year(1).Caption = Mid(Year(37).Caption, 2, 1)  '���������� ����(�ݳ�)
                 Year(2).Caption = Mid(Month(38).Caption, 1, 1) '���������� ����
                 Year(3).Caption = Mid(Month(38).Caption, 2, 1) '���������� ����
              End If
           End If
       End If
  End If

 End Sub
 Private Sub TxtDay_MouseMove(Index As Integer, Button As Integer, Shift As Integer, X As Single, Y As Single)
 Dim sDate As String
 Dim d_In, d_pD, d_tmp As Date                       '������ ��Ÿ����
 Dim i As Integer
 Dim a_Ji As Integer

   If (FV_PreIndex = Index) Then Exit Sub
   If (FV_PreIndex > -1) Then
      SunDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      LunDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      TxtDay(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
      GanJi(FV_PreIndex).BackColor = vbWhite 'vbWhite=��� vbGreen=���
   End If
      
      SunDay(Index).BackColor = vbGreen 'GC_SelColor ������
      LunDay(Index).BackColor = vbGreen
      TxtDay(Index).BackColor = vbGreen
      GanJi(Index).BackColor = vbGreen
      FV_PreIndex = Index
      
    If SunDay(Index).Caption = "" Then
       SunToDay.Caption = ""
    Else
       sDate = FF_Get8Date(Index)
       SunToDay.Caption = Left$(sDate, 4) + "-" + Mid$(sDate, 5, 2) + "-" + Right$(sDate, 2)
    End If
   
   If SunDay(Index).Caption <> "" Then
       Year(4).Caption = Mid(GanJi(Index).Caption, 1, 1)   '���������� �ϰ�
       Year(5).Caption = Mid(GanJi(Index).Caption, 2, 1)   '���������� ����
       Call Si_Click     '��񺼼���
   
       Select Case Si.Text
          Case "�": a_Ji = 1
          Case "��": a_Ji = 3
          Case "��": a_Ji = 5
          Case "��": a_Ji = 7
          Case "��": a_Ji = 9
          Case "��": a_Ji = 11
          Case "��": a_Ji = 13
          Case "ڱ": a_Ji = 15
          Case "��": a_Ji = 17
          Case "�": a_Ji = 19
          Case "��": a_Ji = 21
          Case "��": a_Ji = 23
          Case Else: a_Ji = 0  '���� �Է��� ���� ���� �ʱⰪ�� 0����..
       End Select
       
       d_In = DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), CInt(SunDay(Index).Caption)) + TimeSerial(a_Ji, 30, 0)   '__�������
       d_tmp = DateSerial(CInt(txtYear.Text), CInt(txtMonth.Text), 15) + TimeSerial(0, 0, 0)   '__�������
       d_pD = f_Pre_Div24((d_tmp))  ' ���ֱ��� ���Ա�
       
If DateDiff("d", d_pD, d_In) < 0 Then    '���缱���� - �������� 0���� ���� �� yy-mm-dd ��-��-���� �ϼ�����
            Year(2).Caption = Back_Gan(Mid(Month(38).Caption, 1, 1))  '����
            Year(3).Caption = Back_Ji(Mid(Month(38).Caption, 2, 1))   '����
    
           If CInt(txtMonth.Text) = 2 Then
              Year(0).Caption = Back_Gan(Mid(Year(37).Caption, 1, 1)) '���������� �Ⱓ(���⵵)
              Year(1).Caption = Back_Ji(Mid(Year(37).Caption, 2, 1))  '���������� ����(���⵵)
           End If
       
       Else
            Year(0).Caption = Mid(Year(37).Caption, 1, 1)  '���������� �Ⱓ(�ݳ�)
            Year(1).Caption = Mid(Year(37).Caption, 2, 1)  '���������� ����(�ݳ�)
            Year(2).Caption = Mid(Month(38).Caption, 1, 1) '���������� ����
            Year(3).Caption = Mid(Month(38).Caption, 2, 1) '���������� ����
           
           If DateDiff("d", d_pD, d_In) = 0 Then    '�������� �������϶�
              If DateDiff("n", d_pD, d_In) < 0 Then '�������� �ð��� ���Խð����� ���� ��
                 Year(2).Caption = Back_Gan(Mid(Month(38).Caption, 1, 1))  '����
                 Year(3).Caption = Back_Ji(Mid(Month(38).Caption, 2, 1))   '����
                 If CInt(txtMonth.Text) = 2 Then    '��� 2���̸� ���⵵ �¼��� �ٲ��.
                    Year(0).Caption = Back_Gan(Mid(Year(37).Caption, 1, 1)) '���������� �Ⱓ(���⵵)
                    Year(1).Caption = Back_Ji(Mid(Year(37).Caption, 2, 1))  '���������� ����(���⵵)
                 End If
              Else
                 Year(0).Caption = Mid(Year(37).Caption, 1, 1)  '���������� �Ⱓ(�ݳ�)
                 Year(1).Caption = Mid(Year(37).Caption, 2, 1)  '���������� ����(�ݳ�)
                 Year(2).Caption = Mid(Month(38).Caption, 1, 1) '���������� ����
                 Year(3).Caption = Mid(Month(38).Caption, 2, 1) '���������� ����
              End If
           End If
       End If
  End If
 End Sub
 
 
'======================================================================================
'1������ �Ʒ��� ������ �⵵�� �ٲ�� 12���� �ȴ�.
'======================================================================================
Private Sub spnMonth_DownClick()
    If txtMonth.Text = "1" Then
       txtYear.Text = CStr(CInt(txtYear.Text) - 1)
       txtMonth.Text = "12"
    'Else
    '   txtMonth.Text = CStr(CInt(txtMonth.Text) - 1)
    End If
End Sub
'======================================================================================
'12������ ���οø��� �⵵�� �ٲ�� 1���� �ȴ�.
'======================================================================================
Private Sub spnMonth_UpClick()
    If txtMonth.Text = "12" Then
        txtYear.Text = CStr(CInt(txtYear.Text) + 1)
        txtMonth.Text = "1"
    'Else
    '    txtMonth.Text = CStr(CInt(txtMonth.Text) + 1)
    End If
End Sub

'======================================================================================
'���� �ٲ� ��
'======================================================================================
Private Sub txtMonth_Change()
    FP_DisplayCalendar
End Sub
'======================================================================================
'���� �ٲ� ��
'======================================================================================
Private Sub txtYEAR_Change()
    FP_DisplayCalendar
End Sub

