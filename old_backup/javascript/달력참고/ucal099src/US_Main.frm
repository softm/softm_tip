VERSION 5.00
Object = "{831FDD16-0C5C-11D2-A9FC-0000F8754DA1}#2.0#0"; "MSCOMCTL.OCX"
Object = "{F9043C88-F6F2-101A-A3C9-08002B2F49FB}#1.2#0"; "comdlg32.ocx"
Object = "{3B7C8863-D78F-101B-B9B5-04021C009402}#1.2#0"; "RICHTX32.OCX"
Object = "{FE0065C0-1B7B-11CF-9D53-00AA003C9CB6}#1.1#0"; "COMCT232.OCX"
Begin VB.Form US_main 
   BackColor       =   &H80000013&
   Caption         =   "�����̱���(������)"
   ClientHeight    =   6975
   ClientLeft      =   75
   ClientTop       =   645
   ClientWidth     =   9510
   BeginProperty Font 
      Name            =   "����"
      Size            =   9.75
      Charset         =   129
      Weight          =   400
      Underline       =   0   'False
      Italic          =   0   'False
      Strikethrough   =   0   'False
   EndProperty
   Icon            =   "US_Main.frx":0000
   LinkTopic       =   "Form1"
   ScaleHeight     =   6975
   ScaleWidth      =   9510
   StartUpPosition =   2  'ȭ�� ���
   Begin VB.Frame Frame4 
      BackColor       =   &H00C0FFFF&
      Caption         =   "�����"
      Height          =   2055
      Index           =   1
      Left            =   7200
      TabIndex        =   52
      Top             =   4080
      Width           =   1815
      Begin VB.Label summary 
         Alignment       =   2  '��� ����
         BackColor       =   &H00C0FFFF&
         Caption         =   "��"
         BeginProperty Font 
            Name            =   "����"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   255
         Index           =   3
         Left            =   1200
         TabIndex        =   64
         Top             =   1680
         Width           =   570
      End
      Begin VB.Label summary 
         Alignment       =   2  '��� ����
         BackColor       =   &H00C0FFFF&
         Caption         =   "��"
         BeginProperty Font 
            Name            =   "����"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   255
         Index           =   2
         Left            =   1200
         TabIndex        =   63
         Top             =   1240
         Width           =   570
      End
      Begin VB.Label summary 
         Alignment       =   2  '��� ����
         BackColor       =   &H00C0FFFF&
         Caption         =   "��"
         BeginProperty Font 
            Name            =   "����"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   255
         Index           =   1
         Left            =   1200
         TabIndex        =   62
         Top             =   795
         Width           =   570
      End
      Begin VB.Label summary 
         Alignment       =   2  '��� ����
         BackColor       =   &H00C0FFFF&
         Caption         =   "��"
         BeginProperty Font 
            Name            =   "����"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   255
         Index           =   0
         Left            =   1200
         TabIndex        =   61
         Top             =   360
         Width           =   575
      End
      Begin VB.Label angle 
         BackColor       =   &H00C0FFFF&
         Caption         =   "��  ��"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   56
         Top             =   1680
         Width           =   615
      End
      Begin VB.Label destiny 
         BackColor       =   &H00C0FFFF&
         Caption         =   "����"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   54
         Top             =   795
         Width           =   615
      End
      Begin VB.Label quality 
         BackColor       =   &H00C0FFFF&
         Caption         =   "Ư����"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   55
         Top             =   1245
         Width           =   615
      End
      Begin VB.Label fate 
         BackColor       =   &H00C0FFFF&
         Caption         =   "�����"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   53
         Top             =   360
         Width           =   615
      End
      Begin VB.Label destiny 
         Alignment       =   2  '��� ����
         BackColor       =   &H0080FF80&
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         ForeColor       =   &H00000000&
         Height          =   255
         Index           =   2
         Left            =   720
         TabIndex        =   58
         Top             =   780
         Width           =   495
      End
      Begin VB.Label quality 
         Alignment       =   2  '��� ����
         BackColor       =   &H00FFFF80&
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         ForeColor       =   &H00000000&
         Height          =   255
         Index           =   2
         Left            =   720
         TabIndex        =   59
         Top             =   1230
         Width           =   495
      End
      Begin VB.Label angle 
         Alignment       =   2  '��� ����
         BackColor       =   &H00FF80FF&
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         ForeColor       =   &H00000000&
         Height          =   255
         Index           =   2
         Left            =   720
         TabIndex        =   60
         Top             =   1660
         Width           =   495
      End
      Begin VB.Label fate 
         Alignment       =   2  '��� ����
         BackColor       =   &H008080FF&
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         ForeColor       =   &H00000000&
         Height          =   255
         Index           =   2
         Left            =   720
         TabIndex        =   57
         Top             =   350
         Width           =   495
      End
   End
   Begin VB.Frame Frame4 
      BackColor       =   &H00C0FFFF&
      Caption         =   "���̿� ����"
      Height          =   2055
      Index           =   0
      Left            =   7200
      TabIndex        =   38
      Top             =   1800
      Width           =   1815
      Begin VB.Label Label9 
         BackColor       =   &H00C0FFFF&
         Caption         =   "%"
         BeginProperty Font 
            Name            =   "����"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   255
         Index           =   3
         Left            =   1440
         TabIndex        =   51
         Top             =   1680
         Width           =   255
      End
      Begin VB.Label Label9 
         BackColor       =   &H00C0FFFF&
         Caption         =   "%"
         BeginProperty Font 
            Name            =   "����"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   255
         Index           =   2
         Left            =   1440
         TabIndex        =   50
         Top             =   1240
         Width           =   255
      End
      Begin VB.Label Label9 
         BackColor       =   &H00C0FFFF&
         Caption         =   "%"
         BeginProperty Font 
            Name            =   "����"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   255
         Index           =   1
         Left            =   1440
         TabIndex        =   49
         Top             =   800
         Width           =   255
      End
      Begin VB.Label Label9 
         BackColor       =   &H00C0FFFF&
         Caption         =   "%"
         BeginProperty Font 
            Name            =   "����"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   255
         Index           =   0
         Left            =   1440
         TabIndex        =   48
         Top             =   360
         Width           =   255
      End
      Begin VB.Label Label8 
         Alignment       =   1  '������ ����
         BackColor       =   &H008080FF&
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         ForeColor       =   &H00000000&
         Height          =   255
         Index           =   0
         Left            =   720
         TabIndex        =   46
         Top             =   360
         Width           =   615
      End
      Begin VB.Label Label8 
         Alignment       =   1  '������ ����
         BackColor       =   &H00FF80FF&
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         ForeColor       =   &H00000000&
         Height          =   255
         Index           =   3
         Left            =   720
         TabIndex        =   45
         Top             =   1680
         Width           =   615
      End
      Begin VB.Label Label8 
         Alignment       =   1  '������ ����
         BackColor       =   &H00FFFF80&
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         ForeColor       =   &H00000000&
         Height          =   255
         Index           =   2
         Left            =   720
         TabIndex        =   44
         Top             =   1245
         Width           =   615
      End
      Begin VB.Label Label8 
         Alignment       =   1  '������ ����
         BackColor       =   &H0080FF80&
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   12
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         ForeColor       =   &H00000000&
         Height          =   255
         Index           =   1
         Left            =   720
         TabIndex        =   43
         Top             =   795
         Width           =   615
      End
      Begin VB.Label physical 
         BackColor       =   &H00C0FFFF&
         Caption         =   "��ü"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   42
         Top             =   360
         Width           =   495
      End
      Begin VB.Label intellect 
         BackColor       =   &H00C0FFFF&
         Caption         =   "����"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   41
         Top             =   1240
         Width           =   495
      End
      Begin VB.Label sensitivity 
         BackColor       =   &H00C0FFFF&
         Caption         =   "����"
         Height          =   255
         Index           =   1
         Left            =   240
         TabIndex        =   40
         Top             =   800
         Width           =   495
      End
      Begin VB.Label hunch 
         BackColor       =   &H00C0FFFF&
         Caption         =   "����"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   39
         Top             =   1680
         Width           =   495
      End
   End
   Begin VB.TextBox Text6 
      Alignment       =   1  '������ ����
      Height          =   285
      Left            =   4560
      TabIndex        =   37
      Top             =   1320
      Width           =   1215
   End
   Begin VB.TextBox PopmenuText 
      Height          =   2055
      Left            =   1320
      TabIndex        =   35
      Top             =   1680
      Visible         =   0   'False
      Width           =   1695
   End
   Begin VB.CommandButton ������ 
      BackColor       =   &H00C0FFC0&
      Caption         =   "ؿ���"
      Height          =   380
      Left            =   7320
      Style           =   1  '�׷���
      TabIndex        =   34
      Top             =   990
      Width           =   900
   End
   Begin VB.CommandButton b_Exit 
      BackColor       =   &H00C0C0FF&
      Caption         =   "��    ��"
      BeginProperty Font 
         Name            =   "�ü�"
         Size            =   9.75
         Charset         =   129
         Weight          =   700
         Underline       =   -1  'True
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   460
      Left            =   7920
      MaskColor       =   &H00C0C0FF&
      Picture         =   "US_Main.frx":08CA
      Style           =   1  '�׷���
      TabIndex        =   33
      Top             =   480
      Width           =   900
   End
   Begin VB.CommandButton �޸��� 
      BackColor       =   &H00FFC0C0&
      Caption         =   "�޸���"
      BeginProperty Font 
         Name            =   "�ü�"
         Size            =   12
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   380
      Left            =   8460
      Style           =   1  '�׷���
      TabIndex        =   32
      Top             =   0
      Width           =   900
   End
   Begin ComCtl2.UpDown uBun 
      Height          =   375
      Left            =   6700
      TabIndex        =   31
      ToolTipText     =   "���� �����մϴ�."
      Top             =   800
      Width           =   240
      _ExtentX        =   423
      _ExtentY        =   661
      _Version        =   327681
      BuddyControl    =   "Text5"
      BuddyDispid     =   196638
      OrigLeft        =   6650
      OrigTop         =   800
      OrigRight       =   6890
      OrigBottom      =   1175
      Max             =   59
      SyncBuddy       =   -1  'True
      BuddyProperty   =   0
      Enabled         =   -1  'True
   End
   Begin ComCtl2.UpDown uSi 
      Height          =   375
      Left            =   5890
      TabIndex        =   30
      ToolTipText     =   "���� �����մϴ�."
      Top             =   795
      Width           =   240
      _ExtentX        =   423
      _ExtentY        =   661
      _Version        =   327681
      BuddyControl    =   "Text4"
      BuddyDispid     =   196639
      OrigLeft        =   5890
      OrigTop         =   800
      OrigRight       =   6130
      OrigBottom      =   1175
      Max             =   23
      SyncBuddy       =   -1  'True
      BuddyProperty   =   0
      Enabled         =   -1  'True
   End
   Begin ComCtl2.UpDown uDate 
      Height          =   375
      Left            =   4970
      TabIndex        =   28
      ToolTipText     =   "���� �����մϴ�."
      Top             =   795
      Width           =   240
      _ExtentX        =   423
      _ExtentY        =   661
      _Version        =   327681
      Value           =   1
      BuddyControl    =   "Text3"
      BuddyDispid     =   196640
      OrigLeft        =   5040
      OrigTop         =   800
      OrigRight       =   5280
      OrigBottom      =   1170
      Max             =   31
      Min             =   1
      SyncBuddy       =   -1  'True
      BuddyProperty   =   0
      Enabled         =   -1  'True
   End
   Begin ComCtl2.UpDown uMonth 
      Height          =   375
      Left            =   4050
      TabIndex        =   27
      ToolTipText     =   "���� �����մϴ�."
      Top             =   795
      Width           =   240
      _ExtentX        =   423
      _ExtentY        =   661
      _Version        =   327681
      Value           =   1
      BuddyControl    =   "Text2"
      BuddyDispid     =   196641
      OrigLeft        =   4080
      OrigTop         =   800
      OrigRight       =   4320
      OrigBottom      =   1170
      Max             =   12
      Min             =   1
      SyncBuddy       =   -1  'True
      BuddyProperty   =   0
      Enabled         =   -1  'True
   End
   Begin ComCtl2.UpDown u10Year 
      Height          =   375
      Left            =   2340
      TabIndex        =   26
      ToolTipText     =   "�⵵�� �Ҵ�� �����մϴ�."
      Top             =   795
      Width           =   240
      _ExtentX        =   423
      _ExtentY        =   661
      _Version        =   327681
      Value           =   1800
      Alignment       =   0
      BuddyControl    =   "Text1"
      BuddyDispid     =   196642
      OrigLeft        =   2280
      OrigTop         =   800
      OrigRight       =   2520
      OrigBottom      =   1170
      Increment       =   10
      Max             =   3000
      Min             =   1800
      SyncBuddy       =   -1  'True
      BuddyProperty   =   0
      Enabled         =   -1  'True
   End
   Begin RichTextLib.RichTextBox txt_Result 
      Height          =   5100
      Left            =   120
      TabIndex        =   24
      Top             =   1605
      Width           =   9285
      _ExtentX        =   16378
      _ExtentY        =   8996
      _Version        =   393217
      BackColor       =   12648447
      BorderStyle     =   0
      ScrollBars      =   2
      TextRTF         =   $"US_Main.frx":0A24
      BeginProperty Font {0BE35203-8F91-11CE-9DE3-00AA004BB851} 
         Name            =   "����ü"
         Size            =   12
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
   End
   Begin MSComDlg.CommonDialog CommonDialog1 
      Left            =   6360
      Top             =   120
      _ExtentX        =   847
      _ExtentY        =   847
      _Version        =   393216
   End
   Begin VB.Frame Frame3 
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   740
      Left            =   4680
      TabIndex        =   23
      Top             =   0
      Width           =   1335
      Begin VB.OptionButton Opt_Sex_Woman 
         Caption         =   "��(��٤)"
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   9.75
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   195
         Left            =   120
         TabIndex        =   2
         Top             =   440
         Width           =   1200
      End
      Begin VB.OptionButton Opt_Sex_Man 
         Caption         =   "��(��٤)"
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   9.75
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   195
         Left            =   120
         TabIndex        =   1
         Top             =   160
         Value           =   -1  'True
         Width           =   1200
      End
   End
   Begin MSComctlLib.StatusBar StatusBar1 
      Align           =   2  '�Ʒ� ����
      Height          =   285
      Left            =   0
      TabIndex        =   22
      Top             =   6690
      Width           =   9510
      _ExtentX        =   16775
      _ExtentY        =   503
      _Version        =   393216
      BeginProperty Panels {8E3867A5-8586-11D1-B16A-00C0F0283628} 
         NumPanels       =   3
         BeginProperty Panel1 {8E3867AB-8586-11D1-B16A-00C0F0283628} 
            Bevel           =   0
            Object.Width           =   11210
            MinWidth        =   11210
            Key             =   "pn_1"
            Object.Tag             =   "1"
         EndProperty
         BeginProperty Panel2 {8E3867AB-8586-11D1-B16A-00C0F0283628} 
            Style           =   6
            Alignment       =   1
            Object.Width           =   2647
            MinWidth        =   2647
            TextSave        =   "2003-09-04"
         EndProperty
         BeginProperty Panel3 {8E3867AB-8586-11D1-B16A-00C0F0283628} 
            Style           =   5
            Alignment       =   1
            Object.Width           =   2647
            MinWidth        =   2647
            TextSave        =   "���� 12:28"
         EndProperty
      EndProperty
      BeginProperty Font {0BE35203-8F91-11CE-9DE3-00AA004BB851} 
         Name            =   "����"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
   End
   Begin VB.TextBox txt_Name 
      BeginProperty Font 
         Name            =   "����"
         Size            =   12
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   375
      Left            =   1080
      MultiLine       =   -1  'True
      ScrollBars      =   2  '����
      TabIndex        =   0
      Top             =   180
      Width           =   3255
   End
   Begin VB.Frame Frame2 
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   620
      Left            =   1200
      TabIndex        =   20
      Top             =   700
      Width           =   975
      Begin VB.OptionButton Opt_Yun_True 
         Caption         =   "����"
         Enabled         =   0   'False
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   9.75
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   195
         Left            =   120
         TabIndex        =   8
         Top             =   380
         Width           =   735
      End
      Begin VB.OptionButton Opt_Yun_False 
         Caption         =   "���"
         Enabled         =   0   'False
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   9.75
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   195
         Left            =   120
         TabIndex        =   7
         Top             =   140
         Value           =   -1  'True
         Width           =   735
      End
   End
   Begin VB.Frame Frame1 
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   620
      Left            =   120
      TabIndex        =   19
      Top             =   700
      Width           =   975
      Begin VB.OptionButton Opt_Cal_Lun 
         Caption         =   "����"
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   9.75
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   195
         Left            =   120
         TabIndex        =   4
         Top             =   380
         Width           =   735
      End
      Begin VB.OptionButton Opt_Cal_Sun 
         Caption         =   "���"
         BeginProperty Font 
            Name            =   "����ü"
            Size            =   9.75
            Charset         =   129
            Weight          =   400
            Underline       =   0   'False
            Italic          =   0   'False
            Strikethrough   =   0   'False
         EndProperty
         Height          =   255
         Left            =   120
         TabIndex        =   3
         Top             =   140
         Value           =   -1  'True
         Width           =   735
      End
   End
   Begin VB.CommandButton b_gimun 
      BackColor       =   &H00FFC0FF&
      Caption         =   "��   ��"
      BeginProperty Font 
         Name            =   "����"
         Size            =   9.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   380
      Left            =   8460
      Style           =   1  '�׷���
      TabIndex        =   13
      Top             =   990
      Width           =   900
   End
   Begin VB.CommandButton b_saju 
      BackColor       =   &H00C0E0FF&
      Caption         =   "��   ��"
      BeginProperty Font 
         Name            =   "����"
         Size            =   9.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   380
      Left            =   7320
      Style           =   1  '�׷���
      TabIndex        =   12
      Top             =   0
      Width           =   900
   End
   Begin VB.TextBox Text5 
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   285
      Left            =   6360
      TabIndex        =   11
      Top             =   840
      Width           =   350
   End
   Begin VB.TextBox Text4 
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   285
      Left            =   5550
      TabIndex        =   10
      Top             =   840
      Width           =   350
   End
   Begin VB.TextBox Text3 
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   285
      Left            =   4640
      TabIndex        =   9
      Top             =   840
      Width           =   350
   End
   Begin VB.TextBox Text2 
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   285
      Left            =   3700
      TabIndex        =   6
      Top             =   840
      Width           =   350
   End
   Begin VB.TextBox Text1 
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   285
      Left            =   2600
      TabIndex        =   5
      Top             =   840
      Width           =   550
   End
   Begin VB.CheckBox chk_mode 
      Caption         =   " �÷� ���"
      Height          =   255
      Left            =   120
      TabIndex        =   25
      Top             =   1400
      Value           =   1  'Ȯ��
      Width           =   1335
   End
   Begin ComCtl2.UpDown u1Year 
      Height          =   375
      Left            =   3150
      TabIndex        =   29
      ToolTipText     =   "�⵵�� 1Ҵ�� �����մϴ�."
      Top             =   795
      Width           =   240
      _ExtentX        =   423
      _ExtentY        =   661
      _Version        =   327681
      Value           =   1800
      BuddyControl    =   "Text1"
      BuddyDispid     =   196642
      OrigLeft        =   3120
      OrigTop         =   800
      OrigRight       =   3360
      OrigBottom      =   1170
      Max             =   3000
      Min             =   1800
      SyncBuddy       =   -1  'True
      BuddyProperty   =   0
      Enabled         =   -1  'True
   End
   Begin VB.Label Label12 
      Alignment       =   1  '������ ����
      BackColor       =   &H00808080&
      Caption         =   "�� �Դϴ�."
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   12
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H8000000E&
      Height          =   255
      Left            =   5880
      TabIndex        =   47
      Top             =   1320
      Width           =   1095
   End
   Begin VB.Label Label1 
      BackColor       =   &H00808080&
      Caption         =   "��ƿ� �� �� ����"
      BeginProperty Font 
         Name            =   "����"
         Size            =   12
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      ForeColor       =   &H80000005&
      Height          =   255
      Left            =   2520
      TabIndex        =   36
      Top             =   1320
      Width           =   1935
   End
   Begin VB.Label Label7 
      Caption         =   "�� �� :"
      BeginProperty Font 
         Name            =   "����"
         Size            =   12
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   255
      Left            =   240
      TabIndex        =   21
      Top             =   240
      Width           =   735
   End
   Begin VB.Label Label6 
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   255
      Index           =   0
      Left            =   6940
      TabIndex        =   18
      Top             =   900
      Width           =   255
   End
   Begin VB.Label Label5 
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   255
      Left            =   6150
      TabIndex        =   17
      Top             =   900
      Width           =   255
   End
   Begin VB.Label Label4 
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   255
      Left            =   5250
      TabIndex        =   16
      Top             =   900
      Width           =   255
   End
   Begin VB.Label Label3 
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   255
      Left            =   4320
      TabIndex        =   15
      Top             =   900
      Width           =   255
   End
   Begin VB.Label Label2 
      Caption         =   "��"
      BeginProperty Font 
         Name            =   "����ü"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   255
      Left            =   3440
      TabIndex        =   14
      Top             =   900
      Width           =   255
   End
   Begin VB.Menu m_f 
      Caption         =   "����(&F)"
      Index           =   1
      Begin VB.Menu m_fopen 
         Caption         =   "����(&O)..."
      End
      Begin VB.Menu m_fsave 
         Caption         =   "�����ϱ�(&S)"
         Shortcut        =   ^S
      End
      Begin VB.Menu m_fprint 
         Caption         =   "�μ�(&P)"
         Shortcut        =   ^P
      End
      Begin VB.Menu m_2 
         Caption         =   "-"
      End
      Begin VB.Menu m_fExit 
         Caption         =   "����(&X)"
      End
   End
   Begin VB.Menu m_E 
      Caption         =   "����(&E)"
      Begin VB.Menu m_Eallh 
         Caption         =   "��ü����(&A)"
         Shortcut        =   ^A
         Visible         =   0   'False
      End
      Begin VB.Menu m_Eall 
         Caption         =   "��ü����(&A)  Ctrl+A"
      End
      Begin VB.Menu m_Ecut 
         Caption         =   "�����α�(&X)  Ctrl+X"
      End
      Begin VB.Menu m_Ecopy 
         Caption         =   "�����ϱ�(&C)  Ctrl+C"
      End
      Begin VB.Menu m_Epaste 
         Caption         =   "�ٿ��ֱ�(&V)  Ctrl+V"
      End
      Begin VB.Menu m_1 
         Caption         =   "-"
      End
      Begin VB.Menu m_ETclr 
         Caption         =   "���ڻ�(&T)..."
      End
      Begin VB.Menu m_EBclr 
         Caption         =   "����(&B)..."
      End
      Begin VB.Menu m_EFont 
         Caption         =   "�۲�(&F)..."
      End
   End
   Begin VB.Menu m_o 
      Caption         =   "ȯ��(&O)"
      Begin VB.Menu m_otime 
         Caption         =   "�ð� ����(&T)..."
      End
   End
   Begin VB.Menu m_h 
      Caption         =   "����(&H)"
      Begin VB.Menu m_hman 
         Caption         =   "������ ����"
      End
      Begin VB.Menu m_3 
         Caption         =   "-"
      End
      Begin VB.Menu m_hinf 
         Caption         =   "������ ����(&A)..."
      End
   End
End
Attribute VB_Name = "US_main"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
'-----------------------------------------------------------------------------*
' ��  �� : �����̱���(����Ѩ��) ������(ؿ���) ���α׷� Ver 0.99'
' �ۼ��� : �輮��
' ������ : 2000. 03. 01.
' ������ : 2000. 11. 22.
' ������ : 2003. 09. 04.
' ��  �� : 1. ��������
'          2. ������
'          3. �޸���
'          4. �⹮
'          5. ���̿�����
'          6. ������
'-----------------------------------------------------------------------------*
'��¥ ���� ����
' 1. ���� 1966�� 11�� 20�� --> ��� 1966�� 12�� 31�� (1967�� 1�� 0�Ϸ� �߸��� �κ� ����)

'�� [FORM ��ġ�� ����]###############################################################
'��� �κ�(���� �����Ų �� �ٽ� ���α׷��� �����Ű��, ������ �ִ� ��ġ�� ���� �ε�)
'-FormCoords.bas-------------------------------------------------------------
'-ParseStr.bas---------------------------------------------------------------
'-Replacetoken.BAS-----------------------------------------------------------
'Private Sub Form_Activate()
'    FormCoords Me, "GET"
'End Sub
'Private Sub Form_Unload(Cancel As Integer)
'    FormCoords Me, "SET"
'End Sub

'�� [���콺 ������ư �˾��޴�]############################################################
'��⿡�� Public �� �����ϰԵǸ� ������Ʈ������ ����������� ����Ҽ� �ִµ� ���� �� ����
'�ο��� Private �� �����ϰ� �Ǹ� �� ������ �ۿ� ����� �� ����. ���� �� ����ο��� Public
'���� �����ϰ� �Ǹ� �ٸ������� API �� ����Ǿ� �ִ� ������ ���� "." �� ���� �Լ����� Call
'�ϴ� ������ ����� ���� �ִ�. ���� ���� �����ϴ� ���̴� ���α׷��� ���Ը� �¿��ϰ� �ȴ�.
'������ �̾߱��ؼ� ��⿡ �����ϸ� ���α׷��� �����Ǵ� ���� �޸𸮿� �����ϰ� �Ǵµ� ����
'�����ϰ� �Ǹ� ���� �ε��Ǿ� �������� �޸𸮿� �ö󰡰� �ǰ� �ش����� �ݾƹ����� �޸𸮿���
'�������� �ǹǷ� �޸� ȿ���� ���� ������ġ�� ������ �����ؾ��Ѵ�.
Private Declare Function LockWindowUpdate Lib "user32" (ByVal hwndLock As Long) As Long

Dim yy, mm, dd As String '���� ���� (��� ��,��,��)


Private Sub chk_mode_Click()
    Select Case gitxt_Result_Use
        Case 1: Call b_saju_Click
        Case 2: Call b_gimun_Click
    End Select
End Sub

Private Sub Command1_Click()

Dim ret1, ret2 As Boolean
Dim d_Begin As Date
Dim d_End As Date
    
    Call init_gDIV
'   ret1 = init_gDIV_Load("c:\div24.dat", d_Begin, d_End)
End Sub

Private Sub Form_Activate()
  FormCoords Me, "GET"       '//������Ʈ���� ����� ����ġ�� ��������
End Sub



'���ʷ� form�� load�� �� ����Ǵ� �κ�
Private Sub Form_Load()
    Dim i_err As Boolean
    Dim s_fname As String
    Dim from_date As Date
    Dim to_date As Date
          
    Call gp_load_Main
    Call gp_Load_Option '�ð� option Load
    gitxt_Result_Use = 0
    
    s_fname = App.Path & "\suntolun.dat"
    i_err = gs_Init_Lunar(s_fname)
    If i_err = False Then
        MsgBox "����� ��ȯ File(File��:suntolun.dat)�� ���� �� �����ϴ�.", vbOKOnly, "�Ѩ��(������)"
        End
    End If
    
    Text1.Text = Year(Date)
    Text2.Text = Month(Date)
    Text3.Text = Day(Date)
    Text4.Text = Hour(Time)
    Text5.Text = Minute(Time)
    Text6.Text = ""
    
    s_fname = App.Path & "\div24.dat"
    If gfDivLoad = True Then
        i_err = init_gDIV(s_fname, from_date, to_date)
        If i_err = False Then
            MsgBox "24���� data�� �дµ� �����Ͽ����Ƿ� ���� ���� ����մϴ�.", vbOKOnly, "�Ѩ��(������)"
            gfDivLoad = False
            gstInDivFromTo = "����"
        Else
            gstInDivFromTo = from_date & " ~ " & to_date
        End If
    Else
        i_err = init_gDIV
        gstInDivFromTo = "����"
    End If
    Call sel_clip
End Sub
' �� size Ȯ���
Private Sub Form_Resize()
 
 txt_Result.Width = Me.ScaleWidth / 1.02
 txt_Result.Height = Me.ScaleHeight / 1.4
 txt_Result.Left = Me.ScaleLeft + 100
 txt_Result.Top = Me.ScaleTop + 1650
 
 
End Sub


'�Է��ڷḦ ����, ����data insa initialize
Sub init_Insa()
    Dim i_saju_div As Integer
    Dim i_div_day As Date
    Dim b_Err As Boolean
    Dim i_year As Integer
    Dim i_Month As Integer
    Dim i_Day As Integer   '��� ��
    'Dim i_Day2 As Integer  '��� �� �Ҽ��� ����
    Dim i_Yun As Boolean   '���� üũ
    Dim iDEBUG As Integer
    Dim dDEBUG As Date
    Dim iCaldate As Integer
    Dim iCalHour As Integer
        
    INSA.Name = txt_Name.Text
    If Opt_Sex_Man.Value = True Then INSA.Sex = 1 Else INSA.Sex = 2 '���� ¦��, ���� Ȧ��
    
    If Opt_Cal_Sun.Value = True Then ' ������� �Է����� ��
        INSA.Birth1 = DateSerial(Text1.Text, Text2.Text, Text3.Text) _
                   + TimeSerial(Text4.Text, Text5.Text, 0)              '__�������
        i_year = CInt(Text1.Text)
        i_Month = CInt(Text2.Text)
        i_Day = CInt(Text3.Text)
        i_Yun = False
        INSA.B1y = i_year
        INSA.B1m = i_Month
        INSA.B1d = i_Day
        b_Err = gf_Sun2Lun(i_year, i_Month, i_Day, i_Yun)
        
        INSA.Birth0 = DateSerial(i_year, i_Month, i_Day) _
                    + TimeSerial(Text4.Text, Text5.Text, 0)            '__���� ����
        INSA.B0y = i_year
        INSA.B0m = i_Month
        INSA.B0d = i_Day
        'MsgBox "(����)=" & INSA.B0y & "��" & INSA.B0m & "��" & INSA.B0d & "��" & i_Yun, vbOKOnly, "����"
    Else ' ������ �Է����� ��
        INSA.Birth0 = DateSerial(Text1.Text, Text2.Text, Text3.Text) _
                      + TimeSerial(Text4.Text, Text5.Text, 0)          '__���� ����
        i_year = CInt(Text1.Text)
        i_Month = CInt(Text2.Text)
        i_Day = CInt(Text3.Text)
        INSA.B0y = i_year
        INSA.B0m = i_Month
        INSA.B0d = i_Day
        If Opt_Yun_False.Enabled = False And Opt_Yun_True.Value = False Then
            Opt_Yun_True.Value = True
            Opt_Yun_False.Value = False
        End If
        i_Yun = Opt_Yun_True.Value
        b_Err = gf_Lun2Sun(i_year, i_Month, i_Day, i_Yun)
        
        INSA.Birth1 = DateSerial(i_year, i_Month, i_Day) _
                    + TimeSerial(Text4.Text, Text5.Text, 0)            '__���� ����
        INSA.B1y = i_year
        INSA.B1m = i_Month
        INSA.B1d = i_Day
        'MsgBox "(���)=" & INSA.B1y & "��" & INSA.B1m & "��" & INSA.B1d & "��" & i_Yun, vbOKOnly, "����"
    End If
    
    INSA.JulGi = fi_Pre_Div24(INSA.Birth1)
    Call p_Cal_Palja(INSA.Birth1, 135, CSng(gsLong), CBool(giYajaSi), CBool(giSummer), CBool(giKTime))
    
    i_saju_div = INSA.JulGi
    If i_saju_div Mod 2 = 0 Then i_saju_div = i_saju_div - 1
    
    If i_saju_div = 23 Then
          If (PALJA(1) Mod 2) = (INSA.Sex Mod 2) Then  '�糲������ ���
              If INSA.Birth1 < gDIV(Year(INSA.Birth1), 1) Then
                 i_div_day = gDIV(Year(INSA.Birth1), 1)
              Else
                 i_div_day = gDIV(Year(INSA.Birth1) + 1, 1)
              End If
          INSA.DaeUn_Under_date = i_div_day - INSA.Birth1 ' �糲���� ��������
          'INSA.i_Day2 = (DateDiff("h", INSA.Birth1, i_div_day) Mod (24 * 3)) \ 7.2
          INSA.i_Day2 = (DateDiff("h", INSA.Birth1, i_div_day) / (24 * 3))
          'MsgBox "�糲����1i_Day2=" & (DateDiff("h", INSA.Birth1, i_div_day) / (24 * 3)), vbOKOnly, "����"
       Else
             If INSA.Birth1 > gDIV(Year(INSA.Birth1), 23) Then
                i_div_day = gDIV(Year(INSA.Birth1), 23)
             Else
                i_div_day = gDIV(Year(INSA.Birth1) - 1, 23)
             End If
          
          INSA.DaeUn_Over_date = INSA.Birth1 - i_div_day  ' ������� ��������
          INSA.i_Day2 = (DateDiff("h", i_div_day, INSA.Birth1) / (24 * 3))
          'MsgBox "�������1i_Day2=" & (DateDiff("h", i_div_day, INSA.Birth1) / (24 * 3)), vbOKOnly, "����"
       End If
    Else
       If (PALJA(1) Mod 2) = (INSA.Sex Mod 2) Then  '�糲������ ���
          i_div_day = gDIV(Year(INSA.Birth1), i_saju_div + 2)
          INSA.DaeUn_Under_date = i_div_day - INSA.Birth1 ' �糲���� ��������
          INSA.i_Day2 = (DateDiff("h", INSA.Birth1, i_div_day) / (24 * 3))
          'MsgBox "�糲����2i_Day2=" & (DateDiff("h", INSA.Birth1, i_div_day) / (24 * 3)), vbOKOnly, "����"
       Else
          i_div_day = gDIV(Year(INSA.Birth1), i_saju_div)
          INSA.DaeUn_Over_date = INSA.Birth1 - i_div_day  ' ������� ��������
          INSA.i_Day2 = (DateDiff("h", i_div_day, INSA.Birth1) / (24 * 3))
          'MsgBox "�������2i_Day2=" & (DateDiff("h", i_div_day, INSA.Birth1) / (24 * 3)), vbOKOnly, "����"
       End If
    End If
    
    INSA.Old = i_div_day - INSA.Birth1 + 1 '���̰��(�ѱ����̷�)
    'MsgBox "i_div_day=" & i_div_day & "INSA.Birth1=" & INSA.Birth1, vbOKOnly, "����"
    
    iDEBUG = Year(dDEBUG)
    iDEBUG = Month(dDEBUG)
    iDEBUG = Day(dDEBUG)
    iDEBUG = Hour(dDEBUG)
    iDEBUG = Minute(dDEBUG)
    iDEBUG = Second(dDEBUG)
    
    If ((PALJA(1) Mod 2) = (INSA.Sex Mod 2)) Or (((PALJA(1) Mod 2) <> 0) And ((INSA.Sex Mod 2) <> 0)) Then  '�糲������ ���
        iCaldate = Year(INSA.DaeUn_Under_date)
        If iCaldate <= 1899 Then
            iCaldate = 0
        Else
            iCaldate = Day(INSA.DaeUn_Under_date)
        End If
        iCalHour = Hour(INSA.DaeUn_Under_date) \ 2
        INSA.DaeUnSu = (iCaldate * 12 + iCalHour + 18) \ 36   '��� �� ���� �Ҽ��� ����
    Else '��������� ��� ����������� ���ڸ� ���
        iCaldate = Year(INSA.DaeUn_Over_date)
        If iCaldate <= 1899 Then  'date ǥ��� ���� �⵵�� ����0�̵Ǵµ� 1900������ ǥ��ȴ�.
            iCaldate = 0
        Else
            iCaldate = Day(INSA.DaeUn_Over_date)
        End If
        iCalHour = Hour(INSA.DaeUn_Over_date) \ 2
        INSA.DaeUnSu = (iCaldate * 12 + iCalHour + 18) \ 36   '��� �� ���� �Ҽ��� ����
    End If
    'INSA.Old = Year(Date) - Year(INSA.Birth1)
    Select Case PALJA(4)
        Case 1 '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 10: INSA.DangLyung = 9  '��
                Case Else:    INSA.DangLyung = 10 'ͤ
            End Select
        Case 2: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 9: INSA.DangLyung = 10  'ͤ
                Case 10 To 12: INSA.DangLyung = 8 '��
                Case Else:    INSA.DangLyung = 6  '��
            End Select
        Case 3: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 7: INSA.DangLyung = 5   '��
                Case 8 To 14: INSA.DangLyung = 3  'ܰ
                Case Else:    INSA.DangLyung = 1  'ˣ
            End Select
        Case 4: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 10: INSA.DangLyung = 1   'ˣ
                Case Else:    INSA.DangLyung = 2   '��
            End Select
        Case 5: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 9: INSA.DangLyung = 2    '��
                Case 10 To 12: INSA.DangLyung = 10 'ͤ
                Case Else:    INSA.DangLyung = 5   '��
            End Select
        Case 6: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 7: INSA.DangLyung = 5  '��
                Case 8 To 14: INSA.DangLyung = 7 '��
                Case Else:    INSA.DangLyung = 3 'ܰ
            End Select
        Case 7: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 10: INSA.DangLyung = 3  'ܰ
                Case 11 To 20: INSA.DangLyung = 6 '��
                Case Else:    INSA.DangLyung = 4  '��
            End Select
        Case 8: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 9: INSA.DangLyung = 4   '��
                Case 10 To 12: INSA.DangLyung = 2 '��
                Case Else:    INSA.DangLyung = 6  '��
            End Select
        Case 9: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 7: INSA.DangLyung = 5  '��
                Case 8 To 14: INSA.DangLyung = 9 '��
                Case Else:    INSA.DangLyung = 7 '��
            End Select
        Case 10: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 10: INSA.DangLyung = 7 '��
                Case Else:    INSA.DangLyung = 8 '��
            End Select
        Case 11: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 9: INSA.DangLyung = 8   '��
                Case 10 To 12: INSA.DangLyung = 4 '��
                Case Else:    INSA.DangLyung = 5  '��
            End Select
        Case 12: '��
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 7: INSA.DangLyung = 5  '��
                Case 8 To 14: INSA.DangLyung = 1 'ˣ
                Case Else:    INSA.DangLyung = 9 '��
            End Select
    End Select
    With StatusBar1.Panels 'panel setting
        .Item(1).Text = "[" & fSS(INSA.Sex, Han_sex) & "٤]: " & INSA.Name _
                      & fSS(PALJA(1), Gan) & fSS(PALJA(2), Ji) & "Ҵ " _
                      & fSS(PALJA(3), Gan) & fSS(PALJA(4), Ji) & "�� " _
                      & fSS(PALJA(5), Gan) & fSS(PALJA(6), Ji) & "�� " _
                      & fSS(PALJA(7), Gan) & fSS(PALJA(8), Ji) & "�� "
    End With
    Exit Sub
End Sub
'============================================================================
'�⹮ button �� �������� ��
'============================================================================
Private Sub b_gimun_Click()
    Dim p, k, itime As Integer
    Dim sr(1 To 3, 1 To 4) As String
    Dim s_bar_m As String
    Dim i_B(1 To 15) As Integer
    Dim iBF As Integer
    Dim Icnt, Jcnt As Integer
    '1908�� ���� �ڷḦ �Է��Ͽ��� ��� error�߻�
    
    gitxt_Result_Use = 2
    Call gp_Set_Default_Font
    
    Call init_Insa
    If INSA.Birth1 <= gDIV(1908, 1) Then
        MsgBox "1908�� ���� �⹮ ������ �������� �ʽ��ϴ�.", vbOKOnly, "�Ѩ��(������)"
        Exit Sub
    End If
    Call p_ChunJi_Po
    Call p_YukEui_po
    Call p_PalMun_Po
    Call p_PalGwae_Po
    Call p_TaeEul_po
    Call p_JikBu_po
    Call p_ChunBong_po
    Call p_Else_Po
    
    s_bar_m = "��������������������������������������������������"
    sr(1, 1) = "  " _
             & fGS(1, 1) & "��" & fSS(GUNG(1).Yuk_Chun, yukeui) & fSS(GUNG(1).Chun, Number) & "�ަ�" _
             & fGS(2, 1) & "��" & fSS(GUNG(2).Yuk_Chun, yukeui) & fSS(GUNG(2).Chun, Number) & "�" _
             & fGS(3, 1) & "��" & fSS(GUNG(3).Yuk_Chun, yukeui) & fSS(GUNG(3).Chun, Number) & "�ޡ�"
    sr(1, 2) = "  " _
             & fGS(1, 2) & "��" & fSS(GUNG(1).Yuk_Ji, yukeui) & fSS(GUNG(1).Ji, Number) & fSS(GUNG(1).YukChin, g_YukChin) & "��" _
             & fGS(2, 2) & "��" & fSS(GUNG(2).Yuk_Ji, yukeui) & fSS(GUNG(2).Ji, Number) & fSS(GUNG(2).YukChin, g_YukChin) & "��" _
             & fGS(3, 2) & "��" & fSS(GUNG(3).Yuk_Ji, yukeui) & fSS(GUNG(3).Ji, Number) & fSS(GUNG(3).YukChin, g_YukChin) & "��"
    sr(1, 3) = "  " _
             & fGS(1, 3) & fSS(GUNG(1).ChunBong, chunbong1) & fSS(GUNG(1).JikBu, jikbu1) & fSS(GUNG(1).PalGwae, PalGwae1) & fSS(GUNG(1).TaeEul, TaeEul1) & fSS(GUNG(1).PalMun, PalMun1) & "��" _
             & fGS(2, 3) & fSS(GUNG(2).ChunBong, chunbong1) & fSS(GUNG(2).JikBu, jikbu1) & fSS(GUNG(2).PalGwae, PalGwae1) & fSS(GUNG(2).TaeEul, TaeEul1) & fSS(GUNG(2).PalMun, PalMun1) & "��" _
             & fGS(3, 3) & fSS(GUNG(3).ChunBong, chunbong1) & fSS(GUNG(3).JikBu, jikbu1) & fSS(GUNG(3).PalGwae, PalGwae1) & fSS(GUNG(3).TaeEul, TaeEul1) & fSS(GUNG(3).PalMun, PalMun1) & "��"
    sr(1, 4) = "  " _
             & fGS(1, 4) & fSS(GUNG(1).ChunBong, chunbong2) & fSS(GUNG(1).JikBu, jikbu2) & fSS(GUNG(1).PalGwae, PalGwae2) & fSS(GUNG(1).TaeEul, TaeEul2) & fSS(GUNG(1).PalMun, PalMun2) & "��" _
             & fGS(2, 4) & fSS(GUNG(2).ChunBong, chunbong2) & fSS(GUNG(2).JikBu, jikbu2) & fSS(GUNG(2).PalGwae, PalGwae2) & fSS(GUNG(2).TaeEul, TaeEul2) & fSS(GUNG(2).PalMun, PalMun2) & "��" _
             & fGS(3, 4) & fSS(GUNG(3).ChunBong, chunbong2) & fSS(GUNG(3).JikBu, jikbu2) & fSS(GUNG(3).PalGwae, PalGwae2) & fSS(GUNG(3).TaeEul, TaeEul2) & fSS(GUNG(3).PalMun, PalMun2) & "��"
             
    sr(2, 1) = "  " _
             & fGS(4, 1) & "��" & fSS(GUNG(4).Yuk_Chun, yukeui) & fSS(GUNG(4).Chun, Number) & "�覭" _
             & fGS(5, 1) & "����" & fSS(GUNG(5).Chun, Number) & "�馭" _
             & fGS(6, 1) & "��" & fSS(GUNG(6).Yuk_Chun, yukeui) & fSS(GUNG(6).Chun, Number) & "����"
    sr(2, 2) = "  " _
             & fGS(4, 2) & "��" & fSS(GUNG(4).Yuk_Ji, yukeui) & fSS(GUNG(4).Ji, Number) & fSS(GUNG(4).YukChin, g_YukChin) & "��" _
             & fGS(5, 2) & "��" & fSS(GUNG(5).Yuk_Ji, yukeui) & fSS(GUNG(5).Ji, Number) & fSS(GUNG(5).YukChin, g_YukChin) & "��" _
             & fGS(6, 2) & "��" & fSS(GUNG(6).Yuk_Ji, yukeui) & fSS(GUNG(6).Ji, Number) & fSS(GUNG(6).YukChin, g_YukChin) & "��"
    sr(2, 3) = "  " _
             & fGS(4, 3) & fSS(GUNG(4).ChunBong, chunbong1) & fSS(GUNG(4).JikBu, jikbu1) & fSS(GUNG(4).PalGwae, PalGwae1) & fSS(GUNG(4).TaeEul, TaeEul1) & fSS(GUNG(4).PalMun, PalMun1) & "��" _
             & fGS(5, 3) & "��" & fSS(GUNG(5).TaeEul, TaeEul1) & "��������" _
             & fGS(6, 3) & fSS(GUNG(6).ChunBong, chunbong1) & fSS(GUNG(6).JikBu, jikbu1) & fSS(GUNG(6).PalGwae, PalGwae1) & fSS(GUNG(6).TaeEul, TaeEul1) & fSS(GUNG(6).PalMun, PalMun1) & "��"
    sr(2, 4) = "  " _
             & fGS(4, 4) & fSS(GUNG(4).ChunBong, chunbong2) & fSS(GUNG(4).JikBu, jikbu2) & fSS(GUNG(4).PalGwae, PalGwae2) & fSS(GUNG(4).TaeEul, TaeEul2) & fSS(GUNG(4).PalMun, PalMun2) & "��" _
             & fGS(5, 4) & "��" & fSS(GUNG(5).TaeEul, TaeEul2) & "��������" _
             & fGS(6, 4) & fSS(GUNG(6).ChunBong, chunbong2) & fSS(GUNG(6).JikBu, jikbu2) & fSS(GUNG(6).PalGwae, PalGwae2) & fSS(GUNG(6).TaeEul, TaeEul2) & fSS(GUNG(6).PalMun, PalMun2) & "��"
    sr(3, 1) = "  " _
             & fGS(7, 1) & "��" & fSS(GUNG(7).Yuk_Chun, yukeui) & fSS(GUNG(7).Chun, Number) & "�ݦ�" _
             & fGS(8, 1) & "��" & fSS(GUNG(8).Yuk_Chun, yukeui) & fSS(GUNG(8).Chun, Number) & "�즭" _
             & fGS(9, 1) & "��" & fSS(GUNG(9).Yuk_Chun, yukeui) & fSS(GUNG(9).Chun, Number) & "�롡"
    sr(3, 2) = "  " _
             & fGS(7, 2) & "��" & fSS(GUNG(7).Yuk_Ji, yukeui) & fSS(GUNG(7).Ji, Number) & fSS(GUNG(7).YukChin, g_YukChin) & "��" _
             & fGS(8, 2) & "��" & fSS(GUNG(8).Yuk_Ji, yukeui) & fSS(GUNG(8).Ji, Number) & fSS(GUNG(8).YukChin, g_YukChin) & "��" _
             & fGS(9, 2) & "��" & fSS(GUNG(9).Yuk_Ji, yukeui) & fSS(GUNG(9).Ji, Number) & fSS(GUNG(9).YukChin, g_YukChin) & "��"
    sr(3, 3) = "  " _
             & fGS(7, 3) & fSS(GUNG(7).ChunBong, chunbong1) & fSS(GUNG(7).JikBu, jikbu1) & fSS(GUNG(7).PalGwae, PalGwae1) & fSS(GUNG(7).TaeEul, TaeEul1) & fSS(GUNG(7).PalMun, PalMun1) & "��" _
             & fGS(8, 3) & fSS(GUNG(8).ChunBong, chunbong1) & fSS(GUNG(8).JikBu, jikbu1) & fSS(GUNG(8).PalGwae, PalGwae1) & fSS(GUNG(8).TaeEul, TaeEul1) & fSS(GUNG(8).PalMun, PalMun1) & "��" _
             & fGS(9, 3) & fSS(GUNG(9).ChunBong, chunbong1) & fSS(GUNG(9).JikBu, jikbu1) & fSS(GUNG(9).PalGwae, PalGwae1) & fSS(GUNG(9).TaeEul, TaeEul1) & fSS(GUNG(9).PalMun, PalMun1) & "��"
    sr(3, 4) = "  " _
             & fGS(7, 4) & fSS(GUNG(7).ChunBong, chunbong2) & fSS(GUNG(7).JikBu, jikbu2) & fSS(GUNG(7).PalGwae, PalGwae2) & fSS(GUNG(7).TaeEul, TaeEul2) & fSS(GUNG(7).PalMun, PalMun2) & "��" _
             & fGS(8, 4) & fSS(GUNG(8).ChunBong, chunbong2) & fSS(GUNG(8).JikBu, jikbu2) & fSS(GUNG(8).PalGwae, PalGwae2) & fSS(GUNG(8).TaeEul, TaeEul2) & fSS(GUNG(8).PalMun, PalMun2) & "��" _
             & fGS(9, 4) & fSS(GUNG(9).ChunBong, chunbong2) & fSS(GUNG(9).JikBu, jikbu2) & fSS(GUNG(9).PalGwae, PalGwae2) & fSS(GUNG(9).TaeEul, TaeEul2) & fSS(GUNG(9).PalMun, PalMun2) & "��"
    If chk_mode.Value = Unchecked Then
        txt_Result.Text = " ����: " & INSA.Name & vbCrLf & " ���� " & INSA.B1y & "Ҵ " & INSA.B1m & "�� " _
                        & INSA.B1d & "�� " & fSS(PALJA(8), Ji) & "��, " & fSS(INSA.Sex, Han_sex) & "٤" _
                        & "  " & GUNG_NAME & vbCrLf _
                        & vbCrLf & sr(1, 1) & vbCrLf & sr(1, 2) & vbCrLf & sr(1, 3) & vbCrLf & sr(1, 4) & vbCrLf & s_bar_m _
                        & vbCrLf & sr(2, 1) & vbCrLf & sr(2, 2) & vbCrLf & sr(2, 3) & vbCrLf & sr(2, 4) & vbCrLf & s_bar_m _
                        & vbCrLf & sr(3, 1) & vbCrLf & sr(3, 2) & vbCrLf & sr(3, 3) & vbCrLf & sr(3, 4)
    Else
        txt_Result.Text = " ����: " & INSA.Name & vbCrLf & " ����: " & INSA.B1y & "Ҵ " & INSA.B1m & "�� " _
                        & INSA.B1d & "�� " & fSS(PALJA(8), Ji) & "��, " & fSS(INSA.Sex, Han_sex) & "٤" _
                        & "  " & GUNG_NAME & vbCrLf
        i_B(1) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(1, 1)
        i_B(2) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(1, 2)
        i_B(3) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(1, 3)
        i_B(4) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(1, 4)
        i_B(5) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & s_bar_m
        i_B(6) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(2, 1)
        i_B(7) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(2, 2)
        i_B(8) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(2, 3)
        i_B(9) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(2, 4)
        i_B(10) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & s_bar_m
        i_B(11) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(3, 1)
        i_B(12) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(3, 2)
        i_B(13) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(3, 3)
        i_B(14) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & sr(3, 4)
        i_B(15) = Len(txt_Result.Text)
        
        iBF = 4
        For Icnt = 0 To 2 Step 1
            For Jcnt = 0 To 2 Step 1
                txt_Result.SelStart = i_B(Jcnt * 5 + 1) + iBF + Icnt * 8
                txt_Result.SelLength = 3
                txt_Result.SelColor = vbRed '������� ������
                txt_Result.SelStart = i_B(Jcnt * 5 + 1) + iBF + 5 + Icnt * 8
                txt_Result.SelLength = 1
                txt_Result.SelColor = vbBlue 'õ�ݼ��� �Ķ���
                txt_Result.SelStart = i_B(Jcnt * 5 + 2) + iBF + 5 + Icnt * 8
                txt_Result.SelLength = 1
                txt_Result.SelColor = vbBlue '���ݼ��� �Ķ���
                txt_Result.SelStart = i_B(Jcnt * 5 + 2) + iBF + 6 + Icnt * 8
                txt_Result.SelLength = 1
                txt_Result.SelColor = &H880000 '��ģ�� �����Ķ�����
                txt_Result.SelStart = i_B(Jcnt * 5 + 1) + iBF + 6 + Icnt * 8
                txt_Result.SelLength = 1
                txt_Result.SelColor = &HAAAAAA
            Next Jcnt
        Next Icnt
        For Icnt = 1 To 9 Step 1
            If GUNG(Icnt).YukChin = 1 Then
                Jcnt = Icnt
            End If
        Next Icnt
        txt_Result.SelStart = i_B(((Jcnt - 1) \ 3) * 5 + 2) + iBF + 6 + ((Jcnt - 1) Mod 3) * 8
        txt_Result.SelLength = 1
        txt_Result.SelColor = vbRed '������ ��������
        txt_Result.SelStart = i_B(1 * 5 + 2) + iBF + 6 + 1 * 8
        txt_Result.SelLength = 1
        txt_Result.SelColor = vbRed '�߱���ģ�� ��������
    End If
    txt_Result.SelStart = 0
    txt_Result.SelLength = 0
    txt_Result.SetFocus 'Ŀ����ġ ����
End Sub
'======================================================================================
'�� ��ư�� ����������
'======================================================================================
Private Sub b_saju_Click()
    Dim i As Date
    Dim k, itime As Integer
    Dim i_cnt As Integer
    Dim i_Dae, i_Gan, i_Ji As Integer
    Dim i_today_yy, i_Today_Gan, i_Today_Ji As Integer
    Dim s_Saju(1 To 8) As String
    Dim i_B(1 To 10) As Integer
    Dim i_daeun_No As Integer
    Dim f_daeun_chk As Boolean
    
    Dim d_In, d_pD, d_nD, d_lD As Date  '������ ��Ÿ����
    Dim i_pD, i_nD, i_lD As Integer
   
'--------------------------------------------------(���� ���ϱ�)
  'Dim i As Integer
   Dim nWeek As Integer '���ۿ���(1~7 : ��~��)
   Dim uWeek As String  '�ش����
   Dim GF_YUN As String '����
'--------------------------------------------------(12�� ���ڸ� ���ϱ�)
   Dim StarNum As Integer
   Dim StarGungText As String
'----------------------------------------------------(�����ۼ�)
    gitxt_Result_Use = 1
    Call gp_Set_Default_Font
    Call init_Insa
    
    i_daeun_No = 0
    f_daeun_chk = False
    
   INSA.Old = Year(Date) - Year(INSA.Birth1) + 1 ' ��(�) ���� = �� ���� + 1��
    
    For i_cnt = 7 To 1 Step -1      ' ��� ���̸� �� 10�Ⱓ 8�׸����� �����Ѵ�.
        '���� ���ϱ�
        'If INSA.DaeUnSu = 10 Then INSA.DaeUnSu = INSA.DaeUnSu - 10
        
        i_Dae = INSA.DaeUnSu + (i_cnt - 1) * 10
        
        If i_Dae < INSA.Old And f_daeun_chk = False And INSA.Old - i_Dae <= 10 Then
            i_daeun_No = (i_cnt - 8) * (-1)
            f_daeun_chk = True               '���� ����ǥ��
        End If
        
        'MsgBox "i_Dae =" & INSA.DaeUnSu, vbOKOnly, "����"
        
        If i_Dae <= 9 And i_Dae <> 10 Then        ' ������ ���ڸ� ĭ �� ����
           s_Saju(3) = s_Saju(3) & Mid(INSA.i_Day2, 1, 3) & " "
        Else
           s_Saju(3) = s_Saju(3) & i_Dae & "  "
        End If
        
        '���õ�� ���ϱ�
        If (INSA.Sex Mod 2) = (PALJA(1) Mod 2) Then '�糲 Ȥ�� ����
            i_Gan = (PALJA(3) + i_cnt) Mod 10
        Else
            i_Gan = (PALJA(3) - i_cnt) Mod 10
        End If
        If i_Gan <= 0 Then i_Gan = i_Gan + 10
        s_Saju(4) = s_Saju(4) & fSS((i_Gan), Gan) & "  "
        '������� ���ϱ�
        If (INSA.Sex Mod 2) = (PALJA(1) Mod 2) Then '�糲 Ȥ�� ����
            i_Ji = (PALJA(4) + i_cnt) Mod 12
        Else
            i_Ji = (PALJA(4) - i_cnt) Mod 12
        End If
        If i_Ji <= 0 Then i_Ji = i_Ji + 12
        s_Saju(5) = s_Saju(5) & fSS((i_Ji), Ji) & "  "
        
        '����⵵ ���ϱ�
        i_today_yy = (Year(Date) - 1900 + i_cnt - 3) Mod 100
        If i_today_yy < 0 Then i_today_yy = i_today_yy + 100
        If i_today_yy <= 9 Then
            s_Saju(6) = s_Saju(6) & "0" & i_today_yy & "  "
        Else
            s_Saju(6) = s_Saju(6) & i_today_yy & "  "
        End If
        '����õ�� ���ϱ� : 1900���� ���ڳ���
        i_Today_Gan = (Year(Date) - 1900 + i_cnt + 7 - 3) Mod 10
        If i_Today_Gan <= 0 Then i_Today_Gan = 10 + i_Today_Gan
        s_Saju(7) = s_Saju(7) & fSS(CInt(i_Today_Gan), Gan) & "  "
        '�������� ���ϱ� : 1900���� ���ڳ���
        i_Today_Ji = (Year(Date) - 1900 + i_cnt + 1 - 3) Mod 12
        If i_Today_Ji <= 0 Then i_Today_Ji = 12 + i_Today_Ji
        s_Saju(8) = s_Saju(8) & fSS(CInt(i_Today_Ji), Ji) & "  "
    Next i_cnt
'----------------------------------------------------(����ǥ��)
    '�����Ͽ��� ������ ��� ���� ��¹�
    If Opt_Yun_True.Value = True And Opt_Yun_True.Enabled = True Then '���޹�ư Ȱ���� üũ
            GF_YUN = "[����]"
    Else  '����Ͽ��� ���� ���ڰ� ������ ���� �� ���� ��¹�
        If bYun = 1 Then    '���� ��������(cal_saju.bas)
           GF_YUN = "[����]"
        Else ': bYun = 0   '���� ��������(cal_saju.bas)
           GF_YUN = "[����]"
        End If
    End If
'----------------------------------------------------(������ ǥ��)
    d_In = INSA.Birth1
    d_pD = f_Pre_Div24((d_In))
    d_nD = f_Next_Div24((d_In))
    d_lD = f_Next_Div24((d_nD))
    i_pD = fi_Pre_Div24((d_In))
    i_nD = i_pD + 1:    If i_nD > 24 Then i_nD = i_nD - 24
    i_lD = i_pD + 2:    If i_lD > 24 Then i_lD = i_lD - 24
'----------------------------------------------------(��Ÿ��� ���� ���)
   '// ��+��+���� �ڸ����� ���� ����Ͽ� �ջ���.
     
   p = CInt(Mid(INSA.B1y, 1, 1)) + CInt(Mid(INSA.B1y, 2, 1)) + CInt(Mid(INSA.B1y, 3, 1)) + CInt(Mid(INSA.B1y, 4, 1))
   
   If CInt(INSA.B1m) < 10 Then
      p = p + CInt(Mid(INSA.B1m, 1, 1))
   Else
      p = p + CInt(Mid(INSA.B1m, 1, 1)) + CInt(Mid(INSA.B1m, 2, 1))
   End If
   If CInt(INSA.B1d) < 10 Then
      p = p + CInt(Mid(INSA.B1d, 1, 1))
   Else
      p = p + CInt(Mid(INSA.B1d, 1, 1)) + CInt(Mid(INSA.B1d, 2, 1))
   End If
   If p <> 11 Then
      If p <> 22 Then
         If p > 9 Then
            p = CInt(Mid(CStr(p), 1, 1)) + CInt(Mid(CStr(p), 2, 1))
            If p <> 11 Then
               If p <> 22 Then
                  If p > 9 Then
                     p = CInt(Mid(CStr(p), 1, 1)) + CInt(Mid(CStr(p), 2, 1))
                  End If
               End If
            End If
         End If
      End If
   End If
   
'----------------------------------------------------(Text ���)
    s_Saju(1) = fSS(PALJA(7), Gan) & "  " & fSS(PALJA(5), Gan) & "  " & fSS(PALJA(3), Gan) & "  " & fSS(PALJA(1), Gan)
    s_Saju(2) = fSS(PALJA(8), Ji) & "  " & fSS(PALJA(6), Ji) & "  " & fSS(PALJA(4), Ji) & "  " & fSS(PALJA(2), Ji)
    
'----------------------------------------------------(���� ��� + ���̿����� ���)
  'If Opt_Cal_Sun.Value = True Then '����� ��쿡�� ���̿� ���� ���..
  '   Bio(u) ' ���̿� ���� ���
  'Else
  '   For i = 0 To 3
  '       Label8(i) = ""
  '   Next i
  '   Text6.Text = ""
  'End If
    
 ' ���̿� ���� ���
    yy = CStr(INSA.B1y)
    mm = CStr(INSA.B1m)
    dd = CStr(INSA.B1d)
    
    Bio (u)
    Ksj (u)
       
    
    nWeek = Weekday(CStr(INSA.B1y) + "-" + CStr(INSA.B1m) + "-01") + CInt(INSA.B1d)
  ' nWeek = Weekday("#" + CInt(INSA.B1m) + "/" + CInt(INSA.B1d) + "/" + CInt(INSA.B1y) + "#")
    For i = 0 To 6
        If 7 < nWeek Then
           nWeek = nWeek - 7
        End If
    Next
    Select Case nWeek
                Case 1: uWeek = "��"
                Case 2: uWeek = "��"
                Case 3: uWeek = "��"
                Case 4: uWeek = "��"
                Case 5: uWeek = "�"
                Case 6: uWeek = "��"
                Case 7: uWeek = "��"
                Case Else: uWeek = "??"
    End Select
    
    If chk_mode.Value = Unchecked Then
        txt_Result.Text = "<" & fSS(INSA.Sex, Han_sex) & "٤> " & INSA.Name & "(�޳���:" & INSA.Old & "�)" _
                    & vbCrLf & " ���� : " & INSA.B1y & "Ҵ " & INSA.B1m & "�� " _
                    & INSA.B1d & "�� " & fSS(PALJA(8), Ji) & "��,, (" & uWeek & "����)" & " <�٤�:" & p & "> " _
                    & vbCrLf & " ���� : " & INSA.B0y & "Ҵ " & INSA.B0m & "�� " _
                    & INSA.B0d & "�� " & GF_YUN & " " & Text4.Text & "�� " & Text5.Text & "�� "
                    
        If (CInt(INSA.B1m) = 1 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 2 And CInt(INSA.B1d) < 20) Then
           txt_Result.Text = txt_Result.Text & "<�ڹ����ڸ�>" & vbCrLf
           StarNum = 1
        End If
        If (CInt(INSA.B1m) = 2 And CInt(INSA.B1d) > 19) Or (CInt(INSA.B1m) = 3 And CInt(INSA.B1d) < 21) Then
           txt_Result.Text = txt_Result.Text & "<�ڹ�����ڸ�>" & vbCrLf
           StarNum = 2
        End If
        If (CInt(INSA.B1m) = 3 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 4 And CInt(INSA.B1d) < 21) Then
           txt_Result.Text = txt_Result.Text & "<�ھ��ڸ�>" & vbCrLf
           StarNum = 3
        End If
        If (CInt(INSA.B1m) = 4 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 5 And CInt(INSA.B1d) < 21) Then
           txt_Result.Text = txt_Result.Text & "<��Ȳ���ڸ�>" & vbCrLf
           StarNum = 4
        End If
        If (CInt(INSA.B1m) = 5 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 6 And CInt(INSA.B1d) < 22) Then
           txt_Result.Text = txt_Result.Text & "<�ڽֵ����ڸ�>" & vbCrLf
           StarNum = 5
        End If
        If (CInt(INSA.B1m) = 6 And CInt(INSA.B1d) > 21) Or (CInt(INSA.B1m) = 7 And CInt(INSA.B1d) < 24) Then
           txt_Result.Text = txt_Result.Text & "<�ڰ��ڸ�>" & vbCrLf
           StarNum = 6
        End If
        If (CInt(INSA.B1m) = 7 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 8 And CInt(INSA.B1d) < 24) Then
           txt_Result.Text = txt_Result.Text & "<�ڻ����ڸ�>" & vbCrLf
           StarNum = 7
        End If
        If (CInt(INSA.B1m) = 8 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 9 And CInt(INSA.B1d) < 24) Then
           txt_Result.Text = txt_Result.Text & "<��ó���ڸ�>" & vbCrLf
           StarNum = 8
        End If
        If (CInt(INSA.B1m) = 9 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 10 And CInt(INSA.B1d) < 24) Then
           txt_Result.Text = txt_Result.Text & "<��õĪ�ڸ�>" & vbCrLf
           StarNum = 9
        End If
        If (CInt(INSA.B1m) = 10 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 11 And CInt(INSA.B1d) < 23) Then
           txt_Result.Text = txt_Result.Text & "<�������ڸ�>" & vbCrLf
           StarNum = 10
        End If
        If (CInt(INSA.B1m) = 11 And CInt(INSA.B1d) > 22) Or (CInt(INSA.B1m) = 12 And CInt(INSA.B1d) < 23) Then
           txt_Result.Text = txt_Result.Text & "<�ڻ���ڸ�>" & vbCrLf
           StarNum = 11
        End If
        If (CInt(INSA.B1m) = 12 And CInt(INSA.B1d) > 22) Or (CInt(INSA.B1m) = 1 And CInt(INSA.B1d) < 21) Then
           txt_Result.Text = txt_Result.Text & "<�ڿ����ڸ�>" & vbCrLf
           StarNum = 12
        End If
                    
        
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & "    ��  ��  ��  Ҵ  <٤��>" _
                    & vbCrLf & "  " & "    " & s_Saju(1) & vbCrLf _
                    & vbCrLf & "  " & "    " & s_Saju(2) _
                    & vbCrLf & "           (" & fSS(INSA.DangLyung, Gan) & fSS(INSA.DangLyung, Ohaeng) & "���)" _
                    & vbCrLf & "  " & s_Saju(4) _
                    & vbCrLf & "  " & s_Saju(5) _
                    & vbCrLf & "  " & s_Saju(3) & "<���>" & vbCrLf _
                    & vbCrLf & "  " & s_Saju(7) _
                    & vbCrLf & "  " & s_Saju(8) _
                    & vbCrLf & "  " & s_Saju(6) & "<��>  " & vbCrLf
   
                   
        txt_Result.SelStart = 0 '"��"
        txt_Result.SelLength = 0
        txt_Result.SetFocus
    Else
        txt_Result.Text = "<" & fSS(INSA.Sex, Han_sex) & "٤> " & INSA.Name & "(�޳���:" & INSA.Old & "�)" _
                    & vbCrLf & " ���� : " & INSA.B1y & "Ҵ " & INSA.B1m & "�� " _
                    & INSA.B1d & "�� " & fSS(PALJA(8), Ji) & "��,, (" & uWeek & "����)" & "  <�٤�:" & p & "> " _
                    & vbCrLf & " ���� : " & INSA.B0y & "Ҵ " & INSA.B0m & "�� " _
                    & INSA.B0d & "�� " & GF_YUN & " " & Text4.Text & "�� " & Text5.Text & "��" _
                    & vbCrLf & "  " & "   ��     ��     ��     Ҵ  <٤��>"
                    
        i_B(1) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(1) & vbCrLf & "  " & s_Saju(2)
        i_B(2) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "                (" & fSS(INSA.DangLyung, Gan) & fSS(INSA.DangLyung, Ohaeng) & "���)"
        i_B(3) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(4) & ","
        i_B(4) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(5) & ","
        i_B(5) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(3) & "<���>" & vbCrLf
        i_B(6) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(7)
        i_B(7) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(8)
        i_B(8) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(6) & "<��>"
        i_B(9) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & vbCrLf & f_SajuStr((i_pD), Div) & " :" & "(���)" & d_pD _
                & vbCrLf & f_SajuStr((i_nD), Div) & " :" & "(���)" & d_nD _
                & vbCrLf & f_SajuStr((i_lD), Div) & " :" & "(���)" & d_lD
        i_B(10) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf
        
        If (CInt(INSA.B1m) = 1 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 2 And CInt(INSA.B1d) < 20) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(�����ڸ�)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 2 And CInt(INSA.B1d) > 19) Or (CInt(INSA.B1m) = 3 And CInt(INSA.B1d) < 21) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(������ڸ�)=============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 3 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 4 And CInt(INSA.B1d) < 21) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(���ڸ�)=================" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 4 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 5 And CInt(INSA.B1d) < 21) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(Ȳ���ڸ�)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 5 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 6 And CInt(INSA.B1d) < 22) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(�ֵ����ڸ�)=============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 6 And CInt(INSA.B1d) > 21) Or (CInt(INSA.B1m) = 7 And CInt(INSA.B1d) < 24) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(���ڸ�)=================" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 7 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 8 And CInt(INSA.B1d) < 24) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(�����ڸ�)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 8 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 9 And CInt(INSA.B1d) < 24) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(ó���ڸ�)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 9 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 10 And CInt(INSA.B1d) < 24) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(õĪ�ڸ�)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 10 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 11 And CInt(INSA.B1d) < 23) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(�����ڸ�)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 11 And CInt(INSA.B1d) > 22) Or (CInt(INSA.B1m) = 12 And CInt(INSA.B1d) < 23) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(����ڸ�)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 12 And CInt(INSA.B1d) > 22) Or (CInt(INSA.B1m) = 1 And CInt(INSA.B1d) < 21) Then
            txt_Result.Text = txt_Result.Text & "==��12���==(�����ڸ�)===============" & vbCrLf
        End If
        

        txt_Result.SelStart = i_B(1) - 6
        txt_Result.SelLength = 6
        txt_Result.SelColor = vbBlue '<���>'�� �Ķ��� (-.-)
        txt_Result.SelStart = i_B(1)
        txt_Result.SelLength = i_B(2) - i_B(1)
        txt_Result.SelFontName = "����ü"
        txt_Result.SelFontSize = "20"
        txt_Result.SelBold = True '���ڸ� ���� ũ��
        txt_Result.SelStart = i_B(6) - 6
        txt_Result.SelLength = 6
        txt_Result.SelColor = vbBlue '<���>'�� �Ķ���
        txt_Result.SelStart = i_B(9) - 6
        txt_Result.SelLength = 6
        txt_Result.SelColor = vbBlue '<����>'�� �Ķ���
        txt_Result.SelStart = i_B(3) + i_daeun_No * 3
        txt_Result.SelLength = 2
        txt_Result.SelColor = vbRed '���õ���� ������
        txt_Result.SelStart = i_B(4) + i_daeun_No * 3
        txt_Result.SelLength = 2
        txt_Result.SelColor = vbRed '��������� ������
        txt_Result.SelStart = i_B(6) + 5 * 3
        txt_Result.SelLength = 2
        txt_Result.SelColor = vbRed '����õ���� ������
        txt_Result.SelStart = i_B(7) + 5 * 3
        txt_Result.SelLength = 2
        txt_Result.SelColor = vbRed '���������� ������
        txt_Result.SelStart = 0
        txt_Result.SelLength = 0
        txt_Result.SetFocus
        txt_Result.SelStart = i_B(10)
        txt_Result.SelFontName = "����ü"
        txt_Result.SelBold = True '���ڸ� ���� ũ��
    End If
   
   Call StarGung(StarNum, StarGungText)
   
   Select Case p
          Case 1: MsgBox "��Ÿ���: 1 �� ���Ƶ�����(���Լ����)�Դϴ�." & vbCrLf & StarGungText
          Case 2: MsgBox "��Ÿ���: 2 �� �𼺾���(ٽ������)�Դϴ�." & vbCrLf & StarGungText
          Case 3: MsgBox "��Ÿ���: 3 �� �ܰ��� ������(ӫͭ��ۡ����)�Դϴ�." & vbCrLf & StarGungText
          Case 4: MsgBox "��Ÿ���: 4 �� �����켱��(���������)�Դϴ�." & vbCrLf & StarGungText
          Case 5: MsgBox "��Ÿ���: 5 �� ������ �⸧���Դϴ�." & vbCrLf & StarGungText
          Case 6: MsgBox "��Ÿ���: 6 �� ����������(����Ү����)�Դϴ�." & vbCrLf & StarGungText
          Case 7: MsgBox "��Ÿ���: 7 �� �ź�������(���������)�Դϴ�." & vbCrLf & StarGungText
          Case 8: MsgBox "��Ÿ���: 8 �� �Ϲ�������(��۰������)�Դϴ�." & vbCrLf & StarGungText
          Case 9: MsgBox "��Ÿ���: 9 �� �̹��� �������Դϴ�." & vbCrLf & StarGungText
          Case 11: MsgBox "��Ÿ���: 11 �� �����Ǿ����Դϴ�." & vbCrLf & StarGungText
          Case 22: MsgBox "��Ÿ���: 22 �� �ϸ�ȴ����Դϴ�." & vbCrLf & StarGungText
   End Select
    
End Sub

Private Sub StarGung(StarNum As Integer, StarGungText As String)

Select Case StarNum
       Case 1: StarGungText = "�� ��12���==1�� 21�� ~ 2�� 19�� ��" & vbCrLf & "�����ڸ�(1.21~2.19) -- �� ���ڸ��� ���� ����� �׻� ���ܰ�� ������ ���߰� �Բ� �����ϰ� �ൿ�ϴ� ���� �ٶ���. �����ڸ� ����� ������ �����ϴ� ���� �� ������ ���� �ִ� ������̴�. ������ ����ϰ�, �׵��� ���ؼ��� ���������� ������ �� �ִٰ� �����Ѵ�. ��ȸ �Ϲ��� �������ٴ� �ΰ���ü�� ����� �����Ϸ��� �Ѵ�. �׸��� �װ��� ��ȸ������ �� ��ġ�ִ� ���̶�� ����. �ᱹ�� ������ �Ƿ��� �����ʰ�, ����� �������� �λ��� ��ġ���� ���� �ʴ´�."
       Case 2: StarGungText = "�� ��12���==2�� 20�� ~ 3�� 20�� ��" & vbCrLf & "������ڸ�(2.20~3.20) -- �� �Ⱓ�� �¾ ����� ���������ε� ���������ε� ö���Ϸ��� �ϴ� Ÿ���̴�. �׷��� �����μ� ����� �ڱ��ڽŵ� ������ �� �ִ�. ���� ������ �ϸ鼭 ������ ��� ��� �� ������� ������ �����Ѵٸ� ���� �������� ���� ���� �ְ����� ���� �׷��� ���ϴٸ� �������� ���� ���и� ���þ� ������ �ȴ�. ������ ģ���� �ΰ����踦 �����ϱ�� �ϳ� �ٸ� ������� ���縮 �ϱ� ������ �λ��� �־ ���� ���� ������ ���ϰų� ���ظ� ����."
       Case 3: StarGungText = "�� ��12���==3�� 21�� ~ 4�� 20�� ��" & vbCrLf & "���ڸ�(3.21~4.20) -- �� ���ڸ��� ���ϴ� ����� ���ǰ��� ��ģ ���� ������� ������. ��� �о߿����� ��1���ڷμ� �Ƿ��� ������ �� �ִ� ��ַ��� �ִ�. �׷��� �� ����� �־ �ʹ� �����ϰų� �̷и� �ռ����� ������ ��������鿡 ���� ���� ����� ���� ���� ����ġ ���� ���и� �ϴ� ���� �ִ�. �� ��� ��ó�� ���� õ���� ����� �� �Ẹ�� ���ϰ� �����ϴ� ��찡 ���� ���� �ִ�."
       Case 4: StarGungText = "�� ��12���==4�� 21�� ~ 5�� 20�� ��" & vbCrLf & "Ȳ���ڸ�(4.21~5.20) -- ������ ���ݰ� ������ �ΰ������ ���躸�ٴ� ������ ���� ���� ������ �λ��� ��ư����� ���� Ȳ���ڸ��� ���� ����� Ư¡�̴�. �繰���� �ɰ��ϰ� �������� ������, Ŀ�ٶ� �帧�� �ż����� �ʰ� �������� ��ȭ�� ��Ű���� �Ѵ�. ���� ���� ����, ����� ȯ���� ����Ǳ⸸ �Ѵٸ� ������ ������ ���� ��ȭ�ϰ� ��ȭ�ο� ��Ȱ�� �� ������."
       Case 5: StarGungText = "�� ��12���==5�� 21�� ~ 6�� 21�� ��" & vbCrLf & "�ֵ����ڸ�(5.21~6.21)  -- �ֵ����ڸ��� ���� ����� ��ġ�� ǳ���ϰ� �����ο� ������ ��ܷ��� ������ �ִ�. �� ���� �����ϴ� ���� �������� ������, �����ΰ��� �����ϴ� ���� �幰��. �����⿡ �´� ������ ������ �ൿ�� ������ �����Ӱ� ������ ȯ���� �������� �ʴ´�. �ڱ� �ȿ� �ִ� �������� ����� ��Ҹ� �ڽ��� ���������� �ϳ��� ������ ��ĥ ���� �ִٸ� ���� ������ ������ �� ���� ���̴�."
       Case 6: StarGungText = "�� ��12���==6�� 22�� ~ 7�� 22�� ��" & vbCrLf & "���ڸ�(6.22~7.22)  -- ���ڸ��� �¾ ����� ������ ���� �����ϸ� �������� ������ �������̴�. ���� �������� ���迡 �־�� �𰡳��� ������ ȯ�濡 ���� �������� �پ��. ������ �޼��ϴµ� �־�� Ÿ���� �ൿ�� ������ ���뼺�ְ� �����Ͽ� ������ ����� ������ ����Ѵ�. �ڱ�� ������ ������ ��Ȯ���� ������, ���� ���̳� ���ǵ� �ڽ��� ���ξ� å�Ӱ��� ������ �ൿ�Ѵ�."
       Case 7: StarGungText = "�� ��12���==7�� 23�� ~ 8�� 22�� ��" & vbCrLf & "�����ڸ�(7.23~8.22)  -- ������ ���ݰ� �߰ſ� ������ ���� �����ڸ��� ����� ������ ����ϸ� ���� ������ ����� �Ǵ� ���� �����Ѵ�. õ���� ���������� ���δ� �ڱ� ������ �����ų�, �㿵�� �� �米���迡 ����� ���輺�� �ִ�. �׷��� �ڱ��� ������ ������ ������ ����Ѵٸ� ������ ������ ���� � ����� ������ �о��ġ�� ������ ���� ������ �� ������ �����κ��� �е����� �α⸦ ���� ���� �ִ�."
       Case 8: StarGungText = "�� ��12���==8�� 23�� ~ 9�� 22�� ��" & vbCrLf & "ó���ڸ�(8.23~9.22)  -- ó���ڸ��� ����� ������ �����ϸ� ������ ������ �����ϰ� �ִ�. �׷��� �ڱ⸦ ����Ͽ��� ������ ��� �Ͽ� ������� ����� ������ ���Ǹ� ���Ѵ�. ���� ���Կ� �־�� ���� ���� ������ ������ ���Ͽ� �Ϸ� �����ϸ�, ���� �ߵ����� �����ϰų� ���� ������ ���ǰ� Ÿ������ �ʴ� �Ắ���� ������ �ִ�. ����� ���� ����� �� �̷��� ������� ������ ���������� �䱸�ϰ� �ִ�."
       Case 9: StarGungText = "�� ��12���==9�� 23�� ~ 10�� 21�� ��" & vbCrLf & "õĪ�ڸ�(9.23~10.21)  -- �� ���ڸ��� �¾ ����� �������� ����� ���迡 �����ϱ⸦ �ٶ���. ��ȭ�� �ΰ� ����� ������ �������� ������, ���� ������ ��ȸ���� ��ȭ�� �����ؼ� �� ������ ����� �� �ִ�. �ƿ﷯ õĪ�ڸ��� ��ö�� �̼��� �ش����� �ൿ�� �ź��ϰ� �׻� ǰ���ִ� �µ��� ���� �ҷ��� �Ѵ�. �ڽ��� ���ϴ� �̷��� ���踦 ���� �����ɰ� ����� ǥ�鿡 �������� �ʰ� ��ȭ�Ӱ� �������� ȯ���� �����ϴµ� �ּ��� ���Ѵ�."
       Case 10: StarGungText = "�� ��12���==10�� 22�� ~ 11�� 21�� ��" & vbCrLf & "�����ڸ�(10.22~11.21)  -- �繰�� �̸鼺�� �ǽ��ϸ� Ž���� ����� ������ ���� �� ���ڸ��� ���ϴ� ����� Ư¡�̴�. �̵��� ������ �ִ� ����� ����� �������� �� ���� �ؼ��ϱⰡ �����ʴ�. ħ���� �����°� ������ �ൿ�� ������ ���� �ٴ� ���� �ƴϸ�, ���� ���� ������ �������� ���̴�. ���� ��米���̸� ������ ���� ������ ǥ���ۿ� �� �� ���� �����Լ� �����򰡸� �ޱ⵵ ������, �ϴ� �ݰݿ� ������ �� ���� ��븦 ö���� �ε�游ŭ �����ϴ�. �����ڸ����� ������ ������ �������� �� �Բ��ϰ� �ִ�."
       Case 11: StarGungText = "�� ��12���==11�� 22�� ~ 12�� 21�� ��" & vbCrLf & "����ڸ�(11.22~12.21)  -- ���Ͽ� ������ ���̿� �߼��� �¾ ����ڸ��� ����� õ������ ������ �ٸ��Ͽ� ��ü �Ű澲�� �ʰ� �Ѱ����� �����ϴ� �ൿ���� ������ �ִ�. �̷��� ������ �°������� ���ϰ�, ǳ���� ������ ȹ���� ���� ��Ȱ���� ����� ����. ���� �а�, ���� �ָ�, ���� ���, �׸��� ���� ����, �λ��� Ȯ���� ���� �� ���̴�. �Դٰ� ��ø�� �ൿ������ ������ ���� ȭ��ó�� ������ ������. ������ �Ϳ� ����ϰų� ������ ��ó������ �ǵ��ƺ��� ���� �����ʴ� ���� ���� �� ���ڸ��� ���� ����� Ư¡�̴�."
       Case 12: StarGungText = "�� ��12���==12�� 23�� ~ 1�� 20�� ��" & vbCrLf & "���� �ڸ�(12.23~1.20) -- �ϰ��ϱ⿡�� ��ȭ�ϰ� �����ϰ� �������� �� �̸鿡�� �ݷ��� ���ݼ��� ���߰� �ִ°��� �����ڸ��� ����̴�. ������ �����ϱ� ���ؼ��� ���� ��� �Ѱ��� �Ѱ��� ������ ����� �����ϸ鼭 �ᱹ���� �¸��� ��´�. ������ �ڱ� ����� ������ �������� ������ ���ϰ� ������ �߸��� ���� �������ְ� �����ʰ� ���ư��� ����� ���Ѵ�. �̷��� ���� ������ ������ ��� ģ���� ��� ��ư� �������� ���Ǿ� ������ �𸥴�."
 
 End Select
 
End Sub


Private Sub m_fExit_Click()
    Call gp_Save_Main
    End
End Sub

'menu:����-����
Private Sub m_fopen_Click()
    Dim File_Line As String
    Dim File_Data As String
    On Error GoTo ErrHandler

    With CommonDialog1
        .CancelError = True
  
        .Filter = "��������(*.rtf;*.txt;*.cap;*doc)|*.txt;*.cap;*doc;*.rtf|" & _
           "�ؽ�Ʈ ����(*.txt)|*.txt|ĸ�� ����(*.cap)|*.cap|" & _
           "��ġ�ؽ�Ʈ ����(*.rtf)|*.rtf|" & _
           "���� ����(*.doc)|*.doc|��� ����(*.*)|*.*"
        .FilterIndex = 1
        .Flags = 0
        .DialogTitle = "�ؽ�Ʈ���� ����"
 
        CommonDialog1.ShowOpen
'        file_name = .FileName

        '���� ���µ��� �𷡽ð� ǥ���Ѵ�.
        Screen.MousePointer = 11

'        Form1.Show
'        Form1.Top = 0
'        Form1.Left = 0
'        Form1.Width = 9500
'        Form1.Height = 5500
 
'        Form1.RichTextBox1.Text = ""
        txt_Result.Text = ""

        If Right(.FileTitle, 4) = ".rtf" Then
'            Form1.RichTextBox1.LoadFile File_Name, rtfRTF
            txt_Result.LoadFile .FileName, rtfRTF
        Else
'            Form1.RichTextBox1.LoadFile File_Name, rtfText
            txt_Result.LoadFile .FileName, rtfText
        End If

'        Form1.RichTextBox1.Enabled = True
        txt_Result.Enabled = True
        ' ���콺 ������ ���� ������ ǥ���Ѵ�.
        Screen.MousePointer = 0
        txt_Result.SetFocus
        'Call Btn_Enabled

'        Form1.Caption = File_Name
'        Form1.RichTextBox1.SetFocus
'        Edit_Str = Len(Form1.RichTextBox1.Text)
 
'       `Call Reg_Update(File_Name)
        Call sel_clip
    End With
    Exit Sub
ErrHandler:
    MsgBox Str$(Err) & "==>" & Error$
'Resume  'Ȯ�νñ��� ���ѷ����� ������. (Ctrl+Break)�� ������Ų��.
'Resume next '������ �� ���� ����� �����Ų��.
End Sub

Private Sub m_fprint_Click()
 On Error GoTo ErrHandler
    ' Cancel�� True�� �����Ѵ�.
    CommonDialog1.CancelError = True
    '��� �⺻ �÷��� ����
    CommonDialog1.Flags = cdlPDAllPages + cdlPDCollate + cdlPDPageNums _
                      + cdlPDSelection + cdlPDPrintSetup
    CommonDialog1.ShowPrinter

    Printer.FontName = txt_Result.SelFontName
    Printer.Print ""
    txt_Result.SelPrint Printer.hDC
    Printer.EndDoc
    txt_Result.SetFocus
    Exit Sub

ErrHandler:
    MsgBox Str$(Err) & "==>" & Error$
End Sub

'menu:����-����
Private Sub m_fsave_Click()
    On Error GoTo Err
    CommonDialog1.CancelError = True
    CommonDialog1.Filter = "��������(*.rtf;*.txt;*.cap;*doc)|*.txt;*.cap;*doc;*.rtf|" & _
           "�ؽ�Ʈ ����(*.txt)|*.txt|ĸ�� ����(*.cap)|*.cap|" & _
           "��ġ�ؽ�Ʈ ����(*.rtf)|*.rtf|" & _
           "���� ����(*.doc)|*.doc|��� ����(*.*)|*.*"
    CommonDialog1.FilterIndex = 1
    CommonDialog1.Flags = 0
    If PALJA(1) <> 0 Then
        CommonDialog1.FileName = fSS(PALJA(1), Gan) & fSS(PALJA(2), Ji) & "��" _
                               & fSS(PALJA(3), Gan) & fSS(PALJA(4), Ji) & "��" _
                               & fSS(PALJA(5), Gan) & fSS(PALJA(6), Ji) & "��" _
                               & fSS(PALJA(7), Gan) & fSS(PALJA(8), Ji) & "��-" _
                               & Trim(txt_Name.Text)
    End If
    CommonDialog1.DialogTitle = "���� ����"
    CommonDialog1.InitDir = App.Path ' exe ���������� �ִ� ��ġ����
    CommonDialog1.Flags = cdlOFNOverwritePrompt
    CommonDialog1.DefaultExt = "rtf"
    CommonDialog1.ShowSave

'    File_Name = CommonDialog1.FileName

    If Right(CommonDialog1.FileTitle, 4) = ".rtf" Then
'        Form1.RichTextBox1.SaveFile File_Name, rtfRTF
        txt_Result.SaveFile CommonDialog1.FileName, rtfRTF
    Else
        txt_Result.SaveFile CommonDialog1.FileName, rtfText
'        Form1.RichTextBox1.SaveFile File_Name, rtfText
    End If

    StatusBar1.Panels(1) = CommonDialog1.FileTitle
'    Edit_Str = Len(Form1.RichTextBox1.Text)
'    Form1.Caption = File_Name
    Exit Sub
Err:
End Sub
'menu:����-����
Private Sub m_file_Exit_Click(Index As Integer)
 Unload Me
'����
'End�� (���α׷� �ߴ� �͹̳�����)�̱⿡ ������ �����Լ��� ����Ѵ�.
End Sub

'menu:����-��ü����
Private Sub m_Eall_Click()
    With txt_Result
        .SetFocus
        .SelStart = 0
        .SelLength = Len(.Text)
    End With
End Sub

'menu:����-�߶󳻱�
Private Sub m_Ecut_Click()
    Clipboard.Clear
    Clipboard.SetText txt_Result.SelText
    txt_Result.SelText = ""
End Sub

'menu:����-����
Private Sub m_Ecopy_Click()
    Clipboard.Clear
    Clipboard.SetText txt_Result.SelText
End Sub

'menu:����-�ٿ��ֱ�
Private Sub m_Epaste_Click()
    txt_Result.SelText = Clipboard.GetText
End Sub

'menu:����-���ڻ�
Private Sub m_ETclr_Click()
    On Error GoTo ErrHandler

    ' Cancel�� True�� �����Ѵ�.
    CommonDialog1.CancelError = True
    '�÷��װ� �����Ѵ�.
    CommonDialog1.Flags = cdlCCRGBInit

    CommonDialog1.ShowColor

    'Form1.RichTextBox1.SelColor = CommonDialog1.Color
    'Form1.RichTextBox1.SetFocus
    txt_Result.SelColor = CommonDialog1.Color
    txt_Result.SetFocus
    Exit Sub
ErrHandler:
    MsgBox Str$(Err) & "==>" & Error$
End Sub

'menu:����:����
Private Sub m_EBclr_Click()
    On Error GoTo ErrHandler
    
    CommonDialog1.CancelError = True
    CommonDialog1.Flags = cdlCCRGBInit
    CommonDialog1.ShowColor

    txt_Result.BackColor = CommonDialog1.Color
    txt_Result.SetFocus
    Exit Sub
ErrHandler:
    MsgBox Str$(Err) & "==>" & Error$
End Sub

'�޴�:�ɼ�-�ð�
Private Sub m_otime_Click()
    frm_Opt_T.Show vbModal
End Sub '�޴�:����-����������


'menu:����-��Ʈ
Private Sub m_EFont_Click()
    On Error GoTo ErrHandler
    txt_Result.SetFocus
    With CommonDialog1
        .CancelError = True
  
  ' ��ġ�ؽ�Ʈ�ڽ��� ������ ������ �۲ô�ȭ���ڿ� �����Ѵ�.
        If txt_Result.SelLength > 0 Then
            .FontName = txt_Result.SelFontName
            .FontSize = txt_Result.SelFontSize
            .FontBold = txt_Result.SelBold
            .FontItalic = txt_Result.SelItalic
            .FontUnderline = txt_Result.SelUnderline
            .FontStrikethru = txt_Result.SelStrikeThru
        Else
            .FontName = txt_Result.Font.Name
            .FontSize = txt_Result.Font.Size
            .FontBold = txt_Result.Font.Bold
            .FontItalic = txt_Result.Font.Italic
            .FontUnderline = txt_Result.Font.Underline
            .FontStrikethru = txt_Result.Font.Strikethrough
        End If
  
        .Flags = cdlCFEffects Or cdlCFBoth
        ' �۲� ��ȭ���ڸ� ȭ�鿡 ����Ѵ�.
        .ShowFont
  
        If txt_Result.SelLength > 0 Then
        ' �۲� ��ȭ���ڿ��� ������ ������ �ؽ�Ʈ�ڽ��� �����Ѵ�.
            txt_Result.SelFontName = .FontName
            txt_Result.SelFontSize = .FontSize
            txt_Result.SelBold = .FontBold
            txt_Result.SelItalic = .FontItalic
            txt_Result.SelUnderline = .FontUnderline
            txt_Result.SelStrikeThru = .FontStrikethru
        Else
            txt_Result.Font.Name = .FontName
            txt_Result.Font.Size = .FontSize
            txt_Result.Font.Bold = .FontBold
            txt_Result.Font.Italic = .FontItalic
            txt_Result.Font.Underline = .FontUnderline
            txt_Result.Font.Strikethrough = .FontStrikethru
        End If
    StatusBar1.Panels(1) = "����ü:" + txt_Result.Font.Name _
                         & "  ����ũ��:" + Str(txt_Result.Font.Size)
    End With
    txt_Result.SetFocus
    Exit Sub
ErrHandler:
    MsgBox Str$(Err) & "==>" & Error$
End Sub
'�޴�:����-�����»���
Private Sub m_hman_Click()
On Error GoTo h_hinf_ERR
    txt_Result.LoadFile "ucalhelp.rtf", rtfRTF
    Exit Sub
h_hinf_ERR:
    MsgBox "���� file(ucalhelp.rtf)�� �� �� �����ϴ�.[file pathȮ���!]", vbOKOnly, "�Ѩ��(������)"
End Sub

'�޴�:����-����������
Private Sub m_hinf_Click()
    frm_Help_inf.Show vbModal
End Sub
'���ڿ� ���ý� menu ���ð��� ����
Private Sub sel_clip()
    If txt_Result.SelLength > 0 Then '���ÿ����� ���� ��� ��ü ��밡��
        m_Ecopy.Enabled = True
        m_Ecut.Enabled = True
        m_Epaste.Enabled = True
    Else '���ÿ����� ���� ���
        If Len(Clipboard.GetText) > 0 Then 'Ŭ�����忡 �ִ°�� �ٿ��ֱ⸸ ����
            m_Ecopy.Enabled = False
            m_Ecut.Enabled = False
            m_Epaste.Enabled = True
        Else
            m_Ecopy.Enabled = False
            m_Ecut.Enabled = False
            m_Epaste.Enabled = False
        End If
    End If
End Sub

Private Sub Opt_Cal_Lun_Click()
    Opt_Yun_False.Enabled = True
    If gf_Is_Yun(CInt(Text1.Text), CInt(Text2.Text)) = True Then
        Opt_Yun_True.Enabled = True
    Else
        Opt_Yun_True.Enabled = False
        Opt_Yun_False.Value = True
        Opt_Yun_True.Value = False
    End If
End Sub

Private Sub Opt_Cal_Sun_Click()
    Opt_Yun_False.Value = True
    Opt_Yun_True.Enabled = False
    Opt_Yun_False.Enabled = False
End Sub



'�Է� ���Ǹ� ���� �������� ����
Private Sub txt_Name_GotFocus()
    With txt_Name
        .SetFocus
        .SelStart = 0
        .SelLength = Len(.Text)
    End With
End Sub
Private Sub Text1_GotFocus()
    With Text1
        .SetFocus
        .SelStart = 0
        .SelLength = Len(.Text)
    End With
End Sub
'---------------
'���� �ٲ� ��
'---------------
Private Sub Text1_Change()
On Error GoTo end_text1_change
    If Opt_Cal_Lun.Value = True And gf_Is_Yun(CInt(Text1.Text), CInt(Text2.Text)) = True Then
        Opt_Yun_True.Enabled = True
    Else
        Opt_Yun_True.Enabled = False
        Opt_Yun_False.Value = True
        Opt_Yun_True.Value = False
    End If
end_text1_change:
    Exit Sub
End Sub
'======================================================================================
'���� �ٲ� ��
'======================================================================================
Private Sub Text2_Change()
On Error GoTo end_text2_change
    If Opt_Cal_Lun.Value = True And gf_Is_Yun(CInt(Text1.Text), CInt(Text2.Text)) = True Then
        Opt_Yun_True.Enabled = True
    Else
        Opt_Yun_False.Value = True
        Opt_Yun_True.Enabled = False
    End If
end_text2_change:
    Exit Sub
End Sub


'---------------
'�⿡�� ���� ��ư�� ���Ʒ��� �����̸� �⵵�� 10�⾿ �����Ѵ�.
'---------------
'Private Sub u10Year_DownClick()
'        Text1.Text = CStr(CInt(Text1.Text) - 10)
'End Sub
'Private Sub u10Year_UpClick()
'        Text1.Text = CStr(CInt(Text1.Text) + 10)
'End Sub
'---------------
'�⿡�� ���� ��ư�� ���Ʒ��� �����̸� �⵵�� 1�⾿ �����Ѵ�.
'---------------
'Private Sub u1Year_DownClick()
'        Text1.Text = CStr(CInt(Text1.Text) - 1)
'End Sub
'Private Sub u1Year_UpClick()
'        Text1.Text = CStr(CInt(Text1.Text) + 1)
'End Sub
'---------------
'1������ �Ʒ��� ������ �⵵�� �ٲ�� 12���� �ȴ�.
'---------------
Private Sub uMonth_DownClick()
    If Text2.Text = "1" Then
        Text1.Text = CStr(CInt(Text1.Text) - 1)
        If Text1.Text = "0" Then
           Text1.Text = "9999"
        End If
        Text2.Text = "12"
    'Else
    '    Text2.Text = CStr(CInt(Text2.Text) - 1)
    End If
End Sub
'---------------
'12������ ���οø��� �⵵�� �ٲ�� 1���� �ȴ�.
'---------------
Private Sub uMonth_UpClick()
    If Text2.Text = "12" Then
        Text1.Text = CStr(CInt(Text1.Text) + 1)
        Text2.Text = "1"
        If Text1.Text = "10000" Then
           Text1.Text = "0001"
        End If
    'Else
    '    Text2.Text = CStr(CInt(Text2.Text) + 1)
    End If
End Sub
'---------------
'�Ͽ��� ��ư�� �Ʒ��� ������ �ϼ��� �Ϸ羿 �ش�.
'---------------
Private Sub uDate_DownClick()
           
    If Text3.Text = "1" Then
        Text2.Text = CStr(CInt(Text2.Text) - 1)
        If Text2.Text = "0" Then       ' 1�� ������ �������� �ٽ� 12���� ����
           Text2.Text = "12"
        End If
        Text3.Text = "31"
    'Else
    '    Text3.Text = CStr(CInt(Text3.Text) - 1)
    End If
End Sub
'---------------
'�Ͽ��� ��ư�� ���οø��� �ϼ��� �Ϸ羿 �����Ѵ�.
'---------------
Private Sub uDate_UpClick()
  
     If Text3.Text = "31" Then
        Text2.Text = CStr(CInt(Text2.Text) + 1)
        If Text2.Text = "13" Then
           Text2.Text = "1"
        End If
        Text3.Text = "1"
    'Else
    '    Text3.Text = CStr(CInt(Text3.Text) + 1)
    End If
End Sub

Private Sub Text2_Click()
On Error GoTo end_text2_click
    If Opt_Cal_Lun.Value = True And gf_Is_Yun(CInt(Text1.Text), CInt(Text2.Text)) = True Then
        Opt_Yun_True.Enabled = True
    Else
        Opt_Yun_True.Enabled = False
        Opt_Yun_False.Value = True
        Opt_Yun_True.Value = False
    End If
end_text2_click:
    Exit Sub
    b_saju_Click
End Sub
'---------------
'��(��) ��Ʈ��
'---------------
Private Sub uSi_DownClick()
    If Text4.Text = "0" Then
        Text3.Text = CStr(CInt(Text3.Text) - 1)
        If Text3.Text = "0" Then
            Text3.Text = "31"
        End If
        Text4.Text = "23"
    'Else
    '    Text4.Text = CStr(CInt(Text4.Text) - 1)
    End If
    
End Sub
Private Sub uSi_UpClick()
    If Text4.Text = "23" Then
        Text3.Text = CStr(CInt(Text3.Text) + 1)
        Text4.Text = "0"
        If Text3.Text = "32" Then
           Text3.Text = "1"
        End If
    'Else
    '    Text4.Text = CStr(CInt(Text4.Text) + 1)
    End If
End Sub
'---------------
'��(��) ��Ʈ��
'---------------
Private Sub uBun_DownClick()
    If Text5.Text = "0" Then
        Text4.Text = CStr(CInt(Text4.Text) - 1)
        If CInt(Text4.Text) < 0 Then
            Text4.Text = "23"
        End If
        Text5.Text = "59"
 '   Else
 '       Text5.Text = CStr(CInt(Text5.Text) - 1)
    End If
End Sub
Private Sub uBun_UpClick()
    If Text5.Text = "59" Then
        Text4.Text = CStr(CInt(Text4.Text) + 1)
        Text5.Text = "0"
        If Text4.Text = "24" Then
           Text4.Text = "0"
        End If
    'Else
    'Text5.Text = CStr(CInt(Text5.Text) + 1)
    End If
End Sub

Private Sub Text2_GotFocus()
On Error GoTo TEXT_GETFOCUS_end
    If Opt_Cal_Lun.Value = True And gf_Is_Yun(CInt(Text1.Text), CInt(Text2.Text)) = True Then
        Opt_Yun_True.Enabled = True
    Else
        Opt_Yun_True.Enabled = False
        Opt_Yun_False.Value = True
        Opt_Yun_True.Value = False
    End If
    With Text2
        .SetFocus
        .SelStart = 0
        .SelLength = Len(.Text)
    End With
TEXT_GETFOCUS_end:
End Sub
'---------------
'������ ���Ѵ�.
'---------------
Private Function uGetLastDay(nYear As Integer, nMonth As Integer) As Integer
Dim nMaxDay

Dim nLast As Integer '����

    nMaxDay = Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)
    
    If nMonth = 2 Then
        If (nYear Mod 400) = 0 Or (nYear Mod 100) <> 0 And (nYear Mod 4) = 0 Then
        nMaxDay(1) = 29
        End If
    End If
    
    nLast = nMaxDay(nMonth - 1)  '������ �� ���� ��ȯ
    
    If nLast < CInt(Text3.Text) Then
       MsgBox nLast & "���� �̴��� ������ ���Դϴ�.", vbOKOnly, "�Ѩ��(������)"
       If Text2.Text < 13 Then
          Text2.Text = CStr(CInt(Text2.Text) + 1)
          Text3.Text = "1"
       Else
          Text2.Text = "1"
          Text3.Text = "1"
       End If
    End If
    
End Function
Private Sub Text3_GotFocus()
    With Text3
        .SetFocus
        .SelStart = 0
        .SelLength = Len(.Text)
    End With
End Sub

Private Sub Text4_GotFocus()
    With Text4
        .SetFocus
        .SelStart = 0
        .SelLength = Len(.Text)
    End With
End Sub
Private Sub Text5_GotFocus()
    With Text5
        .SetFocus
        .SelStart = 0
        .SelLength = Len(.Text)
    End With
End Sub

Private Sub Text1_LostFocus()
    Dim iyyyy As Integer
    If IsNumeric(Text1.Text) Then
        iyyyy = CInt(Text1.Text)
        If iyyyy < "1881" Or iyyyy > "2050" Then
            MsgBox "�⵵�� 1881�� 2050 ���̰��̾�� �մϴ�.", vbOKOnly, "�Ѩ��(������)"
            With Text1
                .SetFocus
                .SelStart = 0
                .SelLength = Len(.Text)
            End With
        End If
        Exit Sub
    Else
        MsgBox "�⵵���� �ݵ�� �����̾�� �մϴ�.", vbOKOnly, "�Ѩ��(������)"
        With Text1
            .SetFocus
            .SelStart = 0
            .SelLength = Len(.Text)
        End With
        Exit Sub
    End If
    If Opt_Cal_Lun.Value = True And gf_Is_Yun(CInt(Text1.Text), CInt(Text2.Text)) = True Then
        Opt_Yun_True.Enabled = True
    Else
        Opt_Yun_True.Enabled = False
        Opt_Yun_False.Value = True
        Opt_Yun_True.Value = False
    End If
End Sub

Private Sub Text2_LostFocus()
    Dim imm As Integer
    If IsNumeric(Text2.Text) Then
        imm = CInt(Text2.Text)
        If imm < 1 Or imm > 12 Then
            MsgBox "���� 1�� 12 ���̰��̾�� �մϴ�.", vbOKOnly, "�Ѩ��(������)"
            With Text2
                .SetFocus
                .SelStart = 0
                .SelLength = Len(.Text)
            End With
        End If
        Exit Sub
    Else
        MsgBox "������ �ݵ�� �����̾�� �մϴ�.", vbOKOnly, "�Ѩ��(������)"
        With Text2
            .SetFocus
            .SelStart = 0
            .SelLength = Len(.Text)
        End With
        Exit Sub
    End If
    If Opt_Cal_Lun.Value = True And gf_Is_Yun(CInt(Text1.Text), CInt(Text2.Text)) = True Then
        Opt_Yun_True.Enabled = True
    Else
        Opt_Yun_True.Enabled = False
        Opt_Yun_False.Value = True
        Opt_Yun_True.Value = False
    End If
End Sub

Private Sub Text3_LostFocus()
    Dim idd As Integer
    'Dim nLast As Integer '����
    
    'nLast = uGetLastDay(CInt(Text1.Text), CInt(Text2.Text))

    If IsNumeric(Text3.Text) Then
        idd = CInt(Text3.Text)
        If idd < 1 Or idd > 31 Then
            MsgBox "���� 1�� 31 ���̰��̾�� �մϴ�.", vbOKOnly, "�Ѩ��(������)"
            With Text3
                .SetFocus
                .SelStart = 0
                .SelLength = Len(.Text)
            End With
        End If
    Else
        MsgBox "�ϰ��� �ݵ�� �����̾�� �մϴ�.", vbOKOnly, "�Ѩ��(������)"
        With Text3
            .SetFocus
            .SelStart = 0
            .SelLength = Len(.Text)
        End With
    End If

    'If nLast < CInt(Text3.Text) Then
    '    MsgBox nLast & "���� �̴��� ������ ���Դϴ�.", vbOKOnly, "�Ѩ��(������)"
    '    If Text2.Text = "13" Then
    '       Text2.Text = "1"
    '       Text3.Text = "1"
    '    End If
    'End If
End Sub

Private Sub Text4_LostFocus()
   Dim idd As Integer
   
   If IsNumeric(Text4.Text) Then
        idd = CInt(Text4.Text)
        If idd < 0 Or idd > 23 Then
            MsgBox Chr(34) & "�ô� 0�� 23���� ���̾�� �մϴ�." & Chr(34), vbOKOnly, "�Ѩ��(������)"  ' "(�� ����ǥ) �� �ƽ�Ű ������ chr(34)�� ǥ��
            With Text4
                .SetFocus
                .SelStart = 0
                .SelLength = Len(.Text)
            End With
        End If
    Else
        MsgBox Chr(34) & "�ð��� �ݵ�� �����̾�� �մϴ�." & Chr(34), vbOKOnly, "�Ѩ��(������)"
        With Text4
            .SetFocus
            .SelStart = 0
            .SelLength = Len(.Text)
        End With
    End If
End Sub

Private Sub Text5_LostFocus()
   Dim isec As Integer
   If IsNumeric(Text5.Text) Then
        isec = CInt(Text5.Text)
        If isec < 0 Or isec > 59 Then
            MsgBox "���� 0�� 59 ���̰��̾�� �մϴ�.", vbOKOnly, "�Ѩ��(������)"
            With Text5
                .SetFocus
                .SelStart = 0
                .SelLength = Len(.Text)
            End With
        End If
    Else
        MsgBox "���� �ݵ�� �����̾�� �մϴ�.", vbOKOnly, "�Ѩ��(������)"
        With Text5
            .SetFocus
            .SelStart = 0
            .SelLength = Len(.Text)
        End With
    End If
End Sub

Private Sub txt_Result_MouseDown(Button As Integer, Shift As Integer, X As Single, Y As Single)


'������ ���콺��ư�� Ŭ���Ǿ�����
 'If Button = vbRightButton Then

 If Button = 2 Then
 '   PopupMenu Popmenu
          LockWindowUpdate PopmenuText.hWnd
          PopmenuText.Enabled = False
          DoEvents
          PopupMenu m_E
          PopmenuText.Enabled = True
          LockWindowUpdate 0&
 End If
End Sub

Private Sub txt_Result_Click()
    Call sel_clip
End Sub

Private Sub txt_Result_KeyUp(KeyCode As Integer, Shift As Integer)
    Call sel_clip
End Sub
Private Sub �޸���_Click()
'MDIMemo.Show
 frm_Memo.Show
' Call mnuFileOpen_Click
End Sub
'======================================================================================
' ������(ؿ���) ��ư�� ����������
'======================================================================================
Private Sub ������_Click()
  frm_Calendar.Show , US_main 'Owner ���� �ҷ���.
End Sub '�޴�:-�޷� ����
'���� button
Private Sub b_Exit_Click()
 
 'If MsgBox("�����Ͻðڽ��ϱ�?", vbYesNo + vbQuestion + vbDefaultButton2, "���α׷� ����Ȯ��") = 6 Then
 '   Call gp_Save_Main
 '   'End�� (���α׷� �ߴ� �͹̳�����)�̱⿡ ������ �����Լ��� Unload Me�� ����Ѵ�.
    Unload Me
 'End If
    
End Sub

Private Sub Form_Unload(Cancel As Integer)  '����� ������ �̺�Ʈ ó��..
 If MsgBox("�����Ͻðڽ��ϱ�?", 4 + 32, "���α׷� ����Ȯ��") = 7 Then
      Cancel = -1  ' ���� ����Ǿ����� �ʵ��� �ϴ� ���!
 End If
 FormCoords Me, "SET"       '//����ġ�� ������Ʈ���� �����ϱ�
End Sub

'======================================================================================
' ���̿� ���� �Լ�
'======================================================================================
Private Sub Bio(u As Integer) '���̿� ���� ���
'--------------------------------------------------(���̿� ���� ���ϱ�)
 Dim TotalDay As Integer '�� ��ƿ� ���� ����
 Dim BioRythm(0 To 3) As Integer '���̿������� ����
 Dim Mon(0 To 11) As Integer '���� ������ ���� ��ø�Ǵ� ��¥
 Dim YunYears As Integer '������ ���

 Const Pis = 3.141592 '���̰�
 Const ��ü���� = 23
 Const �������� = 28
 Const �������� = 33
 Const �������� = 38
   
   'Dim u As Integer
   'Total:��ƿ� �� ���
    Mon(0) = 0
    Mon(1) = 31
    Mon(2) = 59
    Mon(3) = 90
    Mon(4) = 120
    Mon(5) = 151
    Mon(6) = 181
    Mon(7) = 212
    Mon(8) = 243
    Mon(9) = 273
    Mon(10) = 304
    Mon(11) = 334
   'YunYear ���� ���
   '���� ����� 4�� ������ �������� �����̵ǰ�
   '�ٽ� 100���� ������ �������� ������ �ȵȴ�.
   '�׸��� 400���� ������ ���� ������ �ȴ�.
    For u = yy To Year(Date) '�Է��� �⵵���� ���� �⵵����
     If (u Mod 4) = 0 Then '4�� ������ ����
        '�̷��� ����
         YunYears = YunYears + 1
         If (u Mod 100) = 0 Then '100���� ������ ����
              '�̷��� ���� �ƴ�
               YunYears = YunYears - 1
               If (u Mod 400) = 0 Then '400���� ������ ����
                  '�̷��� ����
                   YunYears = YunYears + 1
               End If
          End If
     End If
    Next u
   '��ƿ� �� �� �� ���
    TotalDay = (Year(Date) - (yy) - 1) * 365
    TotalDay = TotalDay + (365 - Mon((mm) - 1) - (dd))
    TotalDay = TotalDay + (Mon(Month(Date) - 1) + Day(Date)) + YunYears
    Text6.Text = TotalDay '��ƿ� ���� �ؽ�Ʈ â�� ǥ��
   '���̿����� ���
    BioRythm(0) = Sin((TotalDay / ��ü����) * 2 * Pis) * 100
    BioRythm(1) = Sin((TotalDay / ��������) * 2 * Pis) * 100
    BioRythm(2) = Sin((TotalDay / ��������) * 2 * Pis) * 100
    BioRythm(3) = Sin((TotalDay / ��������) * 2 * Pis) * 100
   'For���� �Ἥ �����ϰ� ǥ��
    For u = 0 To 3
        Label8(u) = BioRythm(u)
    Next u
   '���� �ʱ�ȭ
    For u = 0 To 3
        BioRythm(u) = 0
    Next u
    TotalDay = 0
End Sub

'======================================================================================
' ������ ��� �Լ�
'======================================================================================
Private Sub Ksj(u As Integer) '������ ���
'--------------------------------------------------(���̿� ���� ���ϱ�)

' Dim KsjRythm(4 To 7) As Integer '������ ������ ����
 Dim Yn, Sn, Fn, Dn, Qn As Integer '��ġ ��� ����
 Dim Sm As String
  
    d_In = INSA.Birth1
    d_pD = f_Pre_Div24((d_In))
    d_nD = f_Next_Div24((d_In))
    d_lD = f_Next_Div24((d_nD))
    i_pD = fi_Pre_Div24((d_In))
 'INSA.B1y = i_year
 'INSA.B1d = i_Day
 
 
 If CInt(INSA.B1m) < 3 Then   ' i_Month : ��� 1,2���� ���
    If i_pD < 5 Then Yn = CInt(INSA.B1y) - 1  ' ������ �����̸�
 Else
    Yn = CInt(INSA.B1y)
 End If
 
 
 '������ ���(Ҵ)
 If Yn Mod 9 = 0 Then
    Fn = 2
 ElseIf Yn Mod 9 = 1 Then
    Fn = 1
 Else
    Fn = 11 - Yn Mod 9
 End If
 fate(2).Caption = Fn   '�����
 
 
    Select Case i_pD
        
        Case 1, 2                   'MsgBox "2. ����: 1�� 20��"
            'MsgBox "1. ���: 1�� 6��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 6
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 9
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 3
             End If
        Case 3, 4                   'MsgBox "4. ���: 2�� 19��"
            'MsgBox "3. ���: 2�� 4��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 8
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 2
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 5
             End If
        Case 5, 6                   'MsgBox "6. ����: 3�� 21��"
            'MsgBox "5. ����: 3�� 6��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 7
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 1
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 4
             End If
        Case 7, 8                   'MsgBox "8. ����: 4�� 20��"
            'MsgBox "7. ��٥: 4�� 5��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 6
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 9
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 3
             End If
        Case 9, 10                  'MsgBox "10.��: 5�� 21��"
            'MsgBox "9. ���: 5�� 6��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 5
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 8
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 2
             End If
        Case 11, 12                 'MsgBox "12.���: 6�� 22��"
            'MsgBox "11.����: 6�� 6��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 4
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 7
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 1
             End If
        Case 13, 14                 'MsgBox "14.����: 7�� 23��"
            'MsgBox "13.���: 7�� 7��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 3
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 6
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 9
             End If
        Case 15, 16                 'MsgBox "16.����: 8�� 23��"
            'MsgBox "15.���: 8�� 8��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 2
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 5
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 8
             End If
        Case 17, 18                 'MsgBox "18.����: 9�� 23��"
            'MsgBox "17.����: 9�� 8��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 1
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 4
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 7
             End If
        Case 19, 20                 'MsgBox "20.��˽:10�� 24��"
            'MsgBox "19.����:10�� 9��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 9
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 3
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 6
             End If
        Case 21, 22                 'MsgBox "22.���:11�� 23��"
            'MsgBox "21.���:11�� 8��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 8
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 2
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 5
             End If
        Case 23, 24                 'MsgBox "24.���:12�� 22��"
            'MsgBox "23.����:12�� 7��"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 7
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 1
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 4
             End If
    End Select
  
  destiny(2).Caption = Dn   '����
  
  If Fn >= Dn Then
     Qn = Fn - Dn + 5
  Else
     Qn = 5 - (Dn - Fn)
  End If
  
  If Qn > 9 Then
     Qn = Qn - 9
  ElseIf Qn <= 0 Then
     Qn = Qn + 9
  Else
  End If
     
  quality(2).Caption = Qn   'Ư����
  
   'For���� �Ἥ �����ϰ� ǥ��
    For u = 0 To 3
       If u = 0 Then
          Sn = Fn
       ElseIf u = 1 Then
          Sn = Dn
       ElseIf u = 2 Then
          Sn = Qn
       Else
          Sn = 0
       End If
        
        If Sn = 1 Then
            Sm = "����"
        ElseIf Sn = 2 Then
            Sm = "�γ�"
        ElseIf Sn = 3 Then
            Sm = "�߻�"
        ElseIf Sn = 4 Then
            Sm = "�米"
        ElseIf Sn = 5 Then
            Sm = "���"
        ElseIf Sn = 6 Then
            Sm = "öĢ"
        ElseIf Sn = 7 Then
            Sm = "���"
        ElseIf Sn = 8 Then
            Sm = "�̷�"
        ElseIf Sn = 9 Then
            Sm = "����"
        Else
            Sm = "��"
        End If
        summary(u) = Sm
    Next u
 
 
 
 
 
 
 
 
   '���� �ʱ�ȭ
'    fate(2) = 0
'    destiny(2) = 0
'    quality(2) = 0
'    angle(2) = 0

End Sub
 
 
Private Sub Text1_KeyPress(KeyAscii As Integer)
    
    On Error GoTo Err
    
    If KeyAscii = 13 Then
        
        If Len(Text1.Text) < 5 Then
            
            If Text1.Text > Year(Date) Then
                
                MsgBox_call (1)
                Text1.Text = ""
                Text1.SetFocus
                
            End If
        
        Else
            
            MsgBox_call (1)
            Text1.Text = ""
            Text1.SetFocus
            
        End If
        
        Text2.SetFocus
        
    End If
    
    Exit Sub
    
Err:
    If Len(Text1.Text) = 0 Then
        
        MsgBox_call (2)
    
    End If

End Sub

Private Sub Text2_KeyPress(KeyAscii As Integer)
    
    On Error GoTo Err
    
    If KeyAscii = 13 Then
        
        If Len(Text2.Text) < 3 Then
            
            If Text2.Text > 13 Then
                
                MsgBox_call (1)
                Text2.Text = ""
                Text2.SetFocus
                
            End If
        
        Else
            
            MsgBox_call (1)
            Text2.Text = ""
            Text2.SetFocus
            
        End If
        
        Text3.SetFocus
    
    End If
    
    Exit Sub
    
Err:
    If Len(Text2.Text) = 0 Then
        
        MsgBox_call (2)
    
    End If

End Sub

Private Sub Text3_KeyPress(KeyAscii As Integer)
    
    On Error GoTo Err
    If KeyAscii = 13 Then '����Ű�� �߻��ϸ� üũ
    
        If Len(Text3.Text) < 3 Then '���ڰ� 3�ں��� ������
            
            Case_Select (Text2.Text) '��Ȯ�� �ϼ����� üũ
        
        Else '�ƴ϶��
            
            MsgBox_call (1)
            Text3.Text = ""
            Text3.SetFocus
                
        End If
    
        Call Command1_Click
        
    End If
    
    Exit Sub
    
Err:
    If Len(Text2.Text) = 0 Then '�ؽ�Ʈâ�� ���� ������
        
        MsgBox_call (2) '�޼��� 2��
    
    End If

End Sub

Private Sub MsgBox_call(i As Integer)

    '���־��� �޼��� �ڽ��� ���� �и��� ����.
    
    Select Case i
        
        Case 1
            MsgBox "�߸��� �Է��Դϴ�."
        
        Case 2
            MsgBox "���� �־��ּ���"
    
    End Select

End Sub


Private Sub Case_Select(i As Integer)

   '�� �޸��� ���ݾ� ��¥�� Ʋ����. �װ��� ��ȸ
    
    Select Case i
        Case 1
            If i > 31 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
        
        Case 2
            If i > 29 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
        
        Case 3
            If i > 31 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
        
        Case 4
            If i > 30 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
            
        Case 5
            If i > 31 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
            
        Case 6
            If i > 30 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
            
        Case 7
            If i > 31 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
        Case 8
            If i > 31 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
        Case 9
            If i > 30 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
        Case 10
            If i > 31 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
        Case 11
            If i > 30 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
        Case 12
            If i > 31 Then
                
                MsgBox_call (1)
                Text3.Text = ""
                Text3.SetFocus
            
            End If
    
    
    End Select

End Sub

