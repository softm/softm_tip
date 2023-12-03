VERSION 5.00
Object = "{831FDD16-0C5C-11D2-A9FC-0000F8754DA1}#2.0#0"; "MSCOMCTL.OCX"
Object = "{F9043C88-F6F2-101A-A3C9-08002B2F49FB}#1.2#0"; "comdlg32.ocx"
Object = "{3B7C8863-D78F-101B-B9B5-04021C009402}#1.2#0"; "RICHTX32.OCX"
Object = "{FE0065C0-1B7B-11CF-9D53-00AA003C9CB6}#1.1#0"; "COMCT232.OCX"
Begin VB.Form US_main 
   BackColor       =   &H80000013&
   Caption         =   "유성이기학(만세력)"
   ClientHeight    =   6975
   ClientLeft      =   75
   ClientTop       =   645
   ClientWidth     =   9510
   BeginProperty Font 
      Name            =   "굴림"
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
   StartUpPosition =   2  '화면 가운데
   Begin VB.Frame Frame4 
      BackColor       =   &H00C0FFFF&
      Caption         =   "帝旺學"
      Height          =   2055
      Index           =   1
      Left            =   7200
      TabIndex        =   52
      Top             =   4080
      Width           =   1815
      Begin VB.Label summary 
         Alignment       =   2  '가운데 맞춤
         BackColor       =   &H00C0FFFF&
         Caption         =   "※"
         BeginProperty Font 
            Name            =   "굴림"
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
         Alignment       =   2  '가운데 맞춤
         BackColor       =   &H00C0FFFF&
         Caption         =   "※"
         BeginProperty Font 
            Name            =   "굴림"
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
         Alignment       =   2  '가운데 맞춤
         BackColor       =   &H00C0FFFF&
         Caption         =   "※"
         BeginProperty Font 
            Name            =   "굴림"
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
         Alignment       =   2  '가운데 맞춤
         BackColor       =   &H00C0FFFF&
         Caption         =   "※"
         BeginProperty Font 
            Name            =   "굴림"
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
         Caption         =   "각  도"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   56
         Top             =   1680
         Width           =   615
      End
      Begin VB.Label destiny 
         BackColor       =   &H00C0FFFF&
         Caption         =   "운명수"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   54
         Top             =   795
         Width           =   615
      End
      Begin VB.Label quality 
         BackColor       =   &H00C0FFFF&
         Caption         =   "특성수"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   55
         Top             =   1245
         Width           =   615
      End
      Begin VB.Label fate 
         BackColor       =   &H00C0FFFF&
         Caption         =   "숙명수"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   53
         Top             =   360
         Width           =   615
      End
      Begin VB.Label destiny 
         Alignment       =   2  '가운데 맞춤
         BackColor       =   &H0080FF80&
         BeginProperty Font 
            Name            =   "바탕체"
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
         Alignment       =   2  '가운데 맞춤
         BackColor       =   &H00FFFF80&
         BeginProperty Font 
            Name            =   "바탕체"
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
         Alignment       =   2  '가운데 맞춤
         BackColor       =   &H00FF80FF&
         BeginProperty Font 
            Name            =   "바탕체"
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
         Alignment       =   2  '가운데 맞춤
         BackColor       =   &H008080FF&
         BeginProperty Font 
            Name            =   "바탕체"
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
      Caption         =   "바이오 리듬"
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
            Name            =   "굴림"
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
            Name            =   "굴림"
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
            Name            =   "굴림"
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
            Name            =   "굴림"
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
         Alignment       =   1  '오른쪽 맞춤
         BackColor       =   &H008080FF&
         BeginProperty Font 
            Name            =   "바탕체"
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
         Alignment       =   1  '오른쪽 맞춤
         BackColor       =   &H00FF80FF&
         BeginProperty Font 
            Name            =   "바탕체"
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
         Alignment       =   1  '오른쪽 맞춤
         BackColor       =   &H00FFFF80&
         BeginProperty Font 
            Name            =   "바탕체"
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
         Alignment       =   1  '오른쪽 맞춤
         BackColor       =   &H0080FF80&
         BeginProperty Font 
            Name            =   "바탕체"
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
         Caption         =   "신체"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   42
         Top             =   360
         Width           =   495
      End
      Begin VB.Label intellect 
         BackColor       =   &H00C0FFFF&
         Caption         =   "지성"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   41
         Top             =   1240
         Width           =   495
      End
      Begin VB.Label sensitivity 
         BackColor       =   &H00C0FFFF&
         Caption         =   "감성"
         Height          =   255
         Index           =   1
         Left            =   240
         TabIndex        =   40
         Top             =   800
         Width           =   495
      End
      Begin VB.Label hunch 
         BackColor       =   &H00C0FFFF&
         Caption         =   "직감"
         Height          =   255
         Index           =   0
         Left            =   240
         TabIndex        =   39
         Top             =   1680
         Width           =   495
      End
   End
   Begin VB.TextBox Text6 
      Alignment       =   1  '오른쪽 맞춤
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
   Begin VB.CommandButton 만세력 
      BackColor       =   &H00C0FFC0&
      Caption         =   "萬歲曆"
      Height          =   380
      Left            =   7320
      Style           =   1  '그래픽
      TabIndex        =   34
      Top             =   990
      Width           =   900
   End
   Begin VB.CommandButton b_Exit 
      BackColor       =   &H00C0C0FF&
      Caption         =   "종    료"
      BeginProperty Font 
         Name            =   "궁서"
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
      Style           =   1  '그래픽
      TabIndex        =   33
      Top             =   480
      Width           =   900
   End
   Begin VB.CommandButton 메모장 
      BackColor       =   &H00FFC0C0&
      Caption         =   "메모장"
      BeginProperty Font 
         Name            =   "궁서"
         Size            =   12
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   380
      Left            =   8460
      Style           =   1  '그래픽
      TabIndex        =   32
      Top             =   0
      Width           =   900
   End
   Begin ComCtl2.UpDown uBun 
      Height          =   375
      Left            =   6700
      TabIndex        =   31
      ToolTipText     =   "分을 변경합니다."
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
      ToolTipText     =   "時를 변경합니다."
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
      ToolTipText     =   "日을 변경합니다."
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
      ToolTipText     =   "月을 변경합니다."
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
      ToolTipText     =   "년도를 十年씩 변경합니다."
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
         Name            =   "굴림체"
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
         Name            =   "굴림체"
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
         Caption         =   "여(坤命)"
         BeginProperty Font 
            Name            =   "굴림체"
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
         Caption         =   "남(乾命)"
         BeginProperty Font 
            Name            =   "굴림체"
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
      Align           =   2  '아래 맞춤
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
            TextSave        =   "오후 12:28"
         EndProperty
      EndProperty
      BeginProperty Font {0BE35203-8F91-11CE-9DE3-00AA004BB851} 
         Name            =   "굴림"
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
         Name            =   "바탕"
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
      ScrollBars      =   2  '수직
      TabIndex        =   0
      Top             =   180
      Width           =   3255
   End
   Begin VB.Frame Frame2 
      BeginProperty Font 
         Name            =   "굴림체"
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
         Caption         =   "윤달"
         Enabled         =   0   'False
         BeginProperty Font 
            Name            =   "굴림체"
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
         Caption         =   "평달"
         Enabled         =   0   'False
         BeginProperty Font 
            Name            =   "굴림체"
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
         Name            =   "굴림체"
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
         Caption         =   "음력"
         BeginProperty Font 
            Name            =   "굴림체"
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
         Caption         =   "양력"
         BeginProperty Font 
            Name            =   "굴림체"
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
      Caption         =   "기   문"
      BeginProperty Font 
         Name            =   "바탕"
         Size            =   9.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   380
      Left            =   8460
      Style           =   1  '그래픽
      TabIndex        =   13
      Top             =   990
      Width           =   900
   End
   Begin VB.CommandButton b_saju 
      BackColor       =   &H00C0E0FF&
      Caption         =   "명   리"
      BeginProperty Font 
         Name            =   "바탕"
         Size            =   9.75
         Charset         =   129
         Weight          =   700
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   380
      Left            =   7320
      Style           =   1  '그래픽
      TabIndex        =   12
      Top             =   0
      Width           =   900
   End
   Begin VB.TextBox Text5 
      BeginProperty Font 
         Name            =   "굴림체"
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
         Name            =   "굴림체"
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
         Name            =   "굴림체"
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
         Name            =   "굴림체"
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
         Name            =   "굴림체"
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
      Caption         =   " 컬러 사용"
      Height          =   255
      Left            =   120
      TabIndex        =   25
      Top             =   1400
      Value           =   1  '확인
      Width           =   1335
   End
   Begin ComCtl2.UpDown u1Year 
      Height          =   375
      Left            =   3150
      TabIndex        =   29
      ToolTipText     =   "년도를 1年씩 변경합니다."
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
      Alignment       =   1  '오른쪽 맞춤
      BackColor       =   &H00808080&
      Caption         =   "일 입니다."
      BeginProperty Font 
         Name            =   "바탕체"
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
      Caption         =   "살아온 총 날 수는"
      BeginProperty Font 
         Name            =   "바탕"
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
      Caption         =   "성 명 :"
      BeginProperty Font 
         Name            =   "바탕"
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
      Caption         =   "분"
      BeginProperty Font 
         Name            =   "굴림체"
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
      Caption         =   "시"
      BeginProperty Font 
         Name            =   "굴림체"
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
      Caption         =   "일"
      BeginProperty Font 
         Name            =   "굴림체"
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
      Caption         =   "월"
      BeginProperty Font 
         Name            =   "굴림체"
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
      Caption         =   "년"
      BeginProperty Font 
         Name            =   "굴림체"
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
      Caption         =   "파일(&F)"
      Index           =   1
      Begin VB.Menu m_fopen 
         Caption         =   "열기(&O)..."
      End
      Begin VB.Menu m_fsave 
         Caption         =   "저장하기(&S)"
         Shortcut        =   ^S
      End
      Begin VB.Menu m_fprint 
         Caption         =   "인쇄(&P)"
         Shortcut        =   ^P
      End
      Begin VB.Menu m_2 
         Caption         =   "-"
      End
      Begin VB.Menu m_fExit 
         Caption         =   "종료(&X)"
      End
   End
   Begin VB.Menu m_E 
      Caption         =   "편집(&E)"
      Begin VB.Menu m_Eallh 
         Caption         =   "전체선택(&A)"
         Shortcut        =   ^A
         Visible         =   0   'False
      End
      Begin VB.Menu m_Eall 
         Caption         =   "전체선택(&A)  Ctrl+A"
      End
      Begin VB.Menu m_Ecut 
         Caption         =   "오려두기(&X)  Ctrl+X"
      End
      Begin VB.Menu m_Ecopy 
         Caption         =   "복사하기(&C)  Ctrl+C"
      End
      Begin VB.Menu m_Epaste 
         Caption         =   "붙여넣기(&V)  Ctrl+V"
      End
      Begin VB.Menu m_1 
         Caption         =   "-"
      End
      Begin VB.Menu m_ETclr 
         Caption         =   "글자색(&T)..."
      End
      Begin VB.Menu m_EBclr 
         Caption         =   "배경색(&B)..."
      End
      Begin VB.Menu m_EFont 
         Caption         =   "글꼴(&F)..."
      End
   End
   Begin VB.Menu m_o 
      Caption         =   "환경(&O)"
      Begin VB.Menu m_otime 
         Caption         =   "시간 설정(&T)..."
      End
   End
   Begin VB.Menu m_h 
      Caption         =   "도움말(&H)"
      Begin VB.Menu m_hman 
         Caption         =   "만세력 사용법"
      End
      Begin VB.Menu m_3 
         Caption         =   "-"
      End
      Begin VB.Menu m_hinf 
         Caption         =   "만세력 정보(&A)..."
      End
   End
End
Attribute VB_Name = "US_main"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
'-----------------------------------------------------------------------------*
' 제  목 : 유성이기학(由晟理氣學) 만세력(萬歲曆) 프로그램 Ver 0.99'
' 작성자 : 김석조
' 시작일 : 2000. 03. 01.
' 종료일 : 2000. 11. 22.
' 수정일 : 2003. 09. 04.
' 내  용 : 1. 사주팔자
'          2. 만세력
'          3. 메모장
'          4. 기문
'          5. 바이오리듬
'          6. 제왕학
'-----------------------------------------------------------------------------*
'날짜 버그 수정
' 1. 음력 1966년 11월 20일 --> 양력 1966년 12월 31일 (1967년 1월 0일로 잘못된 부분 수정)

'▶ [FORM 위치값 저장]###############################################################
'모듈 부분(폼을 종료시킨 후 다시 프로그램을 실행시키면, 이전에 있던 위치로 폼이 로드)
'-FormCoords.bas-------------------------------------------------------------
'-ParseStr.bas---------------------------------------------------------------
'-Replacetoken.BAS-----------------------------------------------------------
'Private Sub Form_Activate()
'    FormCoords Me, "GET"
'End Sub
'Private Sub Form_Unload(Cancel As Integer)
'    FormCoords Me, "SET"
'End Sub

'▶ [마우스 우측버튼 팝업메뉴]############################################################
'모듈에서 Public 로 선언하게되면 프로젝트파일의 어느곳에서도 사용할수 있는데 비해 폼 선언
'부에서 Private 로 선언하게 되면 그 폼에서 밖에 사용할 수 없다. 만약 폼 선언부에서 Public
'으로 선언하게 되면 다른폼에서 API 가 선언되어 있는 폼명을 쓰고 "." 을 쓰고 함수명을 Call
'하는 식으로 사용할 수가 있다. 모듈과 폼에 선언하는 차이는 프로그램의 무게를 좌우하게 된다.
'간단히 이야기해서 모듈에 선언하면 프로그램이 가동되는 동안 메모리에 상주하게 되는데 폼에
'선언하게 되면 폼이 로딩되어 있을때만 메모리에 올라가게 되고 해당폼을 닫아버리면 메모리에서
'지워지게 되므로 메모리 효율을 위해 선언위치를 적당히 선택해야한다.
Private Declare Function LockWindowUpdate Lib "user32" (ByVal hwndLock As Long) As Long

Dim yy, mm, dd As String '전역 변수 (양력 년,월,일)


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
  FormCoords Me, "GET"       '//레지스트리에 저장된 폼위치값 가져오기
End Sub



'최초로 form이 load될 때 실행되는 부분
Private Sub Form_Load()
    Dim i_err As Boolean
    Dim s_fname As String
    Dim from_date As Date
    Dim to_date As Date
          
    Call gp_load_Main
    Call gp_Load_Option '시간 option Load
    gitxt_Result_Use = 0
    
    s_fname = App.Path & "\suntolun.dat"
    i_err = gs_Init_Lunar(s_fname)
    If i_err = False Then
        MsgBox "음양력 변환 File(File명:suntolun.dat)을 읽을 수 없습니다.", vbOKOnly, "理氣學(만세력)"
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
            MsgBox "24절기 data를 읽는데 실패하였으므로 계산된 값을 사용합니다.", vbOKOnly, "理氣學(만세력)"
            gfDivLoad = False
            gstInDivFromTo = "없음"
        Else
            gstInDivFromTo = from_date & " ~ " & to_date
        End If
    Else
        i_err = init_gDIV
        gstInDivFromTo = "없음"
    End If
    Call sel_clip
End Sub
' 폼 size 확장시
Private Sub Form_Resize()
 
 txt_Result.Width = Me.ScaleWidth / 1.02
 txt_Result.Height = Me.ScaleHeight / 1.4
 txt_Result.Left = Me.ScaleLeft + 100
 txt_Result.Top = Me.ScaleTop + 1650
 
 
End Sub


'입력자료를 기준, 전역data insa initialize
Sub init_Insa()
    Dim i_saju_div As Integer
    Dim i_div_day As Date
    Dim b_Err As Boolean
    Dim i_year As Integer
    Dim i_Month As Integer
    Dim i_Day As Integer   '대운 수
    'Dim i_Day2 As Integer  '대운 수 소수점 영역
    Dim i_Yun As Boolean   '윤달 체크
    Dim iDEBUG As Integer
    Dim dDEBUG As Date
    Dim iCaldate As Integer
    Dim iCalHour As Integer
        
    INSA.Name = txt_Name.Text
    If Opt_Sex_Man.Value = True Then INSA.Sex = 1 Else INSA.Sex = 2 '음은 짝수, 양은 홀수
    
    If Opt_Cal_Sun.Value = True Then ' 양력으로 입력했을 때
        INSA.Birth1 = DateSerial(Text1.Text, Text2.Text, Text3.Text) _
                   + TimeSerial(Text4.Text, Text5.Text, 0)              '__양력일자
        i_year = CInt(Text1.Text)
        i_Month = CInt(Text2.Text)
        i_Day = CInt(Text3.Text)
        i_Yun = False
        INSA.B1y = i_year
        INSA.B1m = i_Month
        INSA.B1d = i_Day
        b_Err = gf_Sun2Lun(i_year, i_Month, i_Day, i_Yun)
        
        INSA.Birth0 = DateSerial(i_year, i_Month, i_Day) _
                    + TimeSerial(Text4.Text, Text5.Text, 0)            '__음력 일자
        INSA.B0y = i_year
        INSA.B0m = i_Month
        INSA.B0d = i_Day
        'MsgBox "(음력)=" & INSA.B0y & "년" & INSA.B0m & "월" & INSA.B0d & "일" & i_Yun, vbOKOnly, "유성"
    Else ' 음력을 입력했을 때
        INSA.Birth0 = DateSerial(Text1.Text, Text2.Text, Text3.Text) _
                      + TimeSerial(Text4.Text, Text5.Text, 0)          '__음력 일자
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
                    + TimeSerial(Text4.Text, Text5.Text, 0)            '__음력 일자
        INSA.B1y = i_year
        INSA.B1m = i_Month
        INSA.B1d = i_Day
        'MsgBox "(양력)=" & INSA.B1y & "년" & INSA.B1m & "월" & INSA.B1d & "일" & i_Yun, vbOKOnly, "유성"
    End If
    
    INSA.JulGi = fi_Pre_Div24(INSA.Birth1)
    Call p_Cal_Palja(INSA.Birth1, 135, CSng(gsLong), CBool(giYajaSi), CBool(giSummer), CBool(giKTime))
    
    i_saju_div = INSA.JulGi
    If i_saju_div Mod 2 = 0 Then i_saju_div = i_saju_div - 1
    
    If i_saju_div = 23 Then
          If (PALJA(1) Mod 2) = (INSA.Sex Mod 2) Then  '양남음녀인 경우
              If INSA.Birth1 < gDIV(Year(INSA.Birth1), 1) Then
                 i_div_day = gDIV(Year(INSA.Birth1), 1)
              Else
                 i_div_day = gDIV(Year(INSA.Birth1) + 1, 1)
              End If
          INSA.DaeUn_Under_date = i_div_day - INSA.Birth1 ' 양남음녀 다음절기
          'INSA.i_Day2 = (DateDiff("h", INSA.Birth1, i_div_day) Mod (24 * 3)) \ 7.2
          INSA.i_Day2 = (DateDiff("h", INSA.Birth1, i_div_day) / (24 * 3))
          'MsgBox "양남음녀1i_Day2=" & (DateDiff("h", INSA.Birth1, i_div_day) / (24 * 3)), vbOKOnly, "유성"
       Else
             If INSA.Birth1 > gDIV(Year(INSA.Birth1), 23) Then
                i_div_day = gDIV(Year(INSA.Birth1), 23)
             Else
                i_div_day = gDIV(Year(INSA.Birth1) - 1, 23)
             End If
          
          INSA.DaeUn_Over_date = INSA.Birth1 - i_div_day  ' 음남양녀 이전절기
          INSA.i_Day2 = (DateDiff("h", i_div_day, INSA.Birth1) / (24 * 3))
          'MsgBox "음남양녀1i_Day2=" & (DateDiff("h", i_div_day, INSA.Birth1) / (24 * 3)), vbOKOnly, "유성"
       End If
    Else
       If (PALJA(1) Mod 2) = (INSA.Sex Mod 2) Then  '양남음녀인 경우
          i_div_day = gDIV(Year(INSA.Birth1), i_saju_div + 2)
          INSA.DaeUn_Under_date = i_div_day - INSA.Birth1 ' 양남음녀 다음절기
          INSA.i_Day2 = (DateDiff("h", INSA.Birth1, i_div_day) / (24 * 3))
          'MsgBox "양남음녀2i_Day2=" & (DateDiff("h", INSA.Birth1, i_div_day) / (24 * 3)), vbOKOnly, "유성"
       Else
          i_div_day = gDIV(Year(INSA.Birth1), i_saju_div)
          INSA.DaeUn_Over_date = INSA.Birth1 - i_div_day  ' 음남양녀 이전절기
          INSA.i_Day2 = (DateDiff("h", i_div_day, INSA.Birth1) / (24 * 3))
          'MsgBox "음남양녀2i_Day2=" & (DateDiff("h", i_div_day, INSA.Birth1) / (24 * 3)), vbOKOnly, "유성"
       End If
    End If
    
    INSA.Old = i_div_day - INSA.Birth1 + 1 '나이계산(한국나이로)
    'MsgBox "i_div_day=" & i_div_day & "INSA.Birth1=" & INSA.Birth1, vbOKOnly, "유성"
    
    iDEBUG = Year(dDEBUG)
    iDEBUG = Month(dDEBUG)
    iDEBUG = Day(dDEBUG)
    iDEBUG = Hour(dDEBUG)
    iDEBUG = Minute(dDEBUG)
    iDEBUG = Second(dDEBUG)
    
    If ((PALJA(1) Mod 2) = (INSA.Sex Mod 2)) Or (((PALJA(1) Mod 2) <> 0) And ((INSA.Sex Mod 2) <> 0)) Then  '양남음녀인 경우
        iCaldate = Year(INSA.DaeUn_Under_date)
        If iCaldate <= 1899 Then
            iCaldate = 0
        Else
            iCaldate = Day(INSA.DaeUn_Under_date)
        End If
        iCalHour = Hour(INSA.DaeUn_Under_date) \ 2
        INSA.DaeUnSu = (iCaldate * 12 + iCalHour + 18) \ 36   '대운 수 계산시 소수점 생략
    Else '음남양녀인 경우 이전절기까지 일자를 계산
        iCaldate = Year(INSA.DaeUn_Over_date)
        If iCaldate <= 1899 Then  'date 표기상 같은 년도의 차는0이되는데 1900년으로 표기된다.
            iCaldate = 0
        Else
            iCaldate = Day(INSA.DaeUn_Over_date)
        End If
        iCalHour = Hour(INSA.DaeUn_Over_date) \ 2
        INSA.DaeUnSu = (iCaldate * 12 + iCalHour + 18) \ 36   '대운 수 계산시 소수점 생략
    End If
    'INSA.Old = Year(Date) - Year(INSA.Birth1)
    Select Case PALJA(4)
        Case 1 '자
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 10: INSA.DangLyung = 9  '壬
                Case Else:    INSA.DangLyung = 10 '癸
            End Select
        Case 2: '축
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 9: INSA.DangLyung = 10  '癸
                Case 10 To 12: INSA.DangLyung = 8 '辛
                Case Else:    INSA.DangLyung = 6  '己
            End Select
        Case 3: '인
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 7: INSA.DangLyung = 5   '戊
                Case 8 To 14: INSA.DangLyung = 3  '丙
                Case Else:    INSA.DangLyung = 1  '甲
            End Select
        Case 4: '묘
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 10: INSA.DangLyung = 1   '甲
                Case Else:    INSA.DangLyung = 2   '乙
            End Select
        Case 5: '진
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 9: INSA.DangLyung = 2    '乙
                Case 10 To 12: INSA.DangLyung = 10 '癸
                Case Else:    INSA.DangLyung = 5   '戊
            End Select
        Case 6: '사
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 7: INSA.DangLyung = 5  '戊
                Case 8 To 14: INSA.DangLyung = 7 '庚
                Case Else:    INSA.DangLyung = 3 '丙
            End Select
        Case 7: '오
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 10: INSA.DangLyung = 3  '丙
                Case 11 To 20: INSA.DangLyung = 6 '己
                Case Else:    INSA.DangLyung = 4  '丁
            End Select
        Case 8: '미
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 9: INSA.DangLyung = 4   '丁
                Case 10 To 12: INSA.DangLyung = 2 '乙
                Case Else:    INSA.DangLyung = 6  '己
            End Select
        Case 9: '신
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 7: INSA.DangLyung = 5  '戊
                Case 8 To 14: INSA.DangLyung = 9 '壬
                Case Else:    INSA.DangLyung = 7 '庚
            End Select
        Case 10: '유
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 10: INSA.DangLyung = 7 '庚
                Case Else:    INSA.DangLyung = 8 '辛
            End Select
        Case 11: '술
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 9: INSA.DangLyung = 8   '辛
                Case 10 To 12: INSA.DangLyung = 4 '丁
                Case Else:    INSA.DangLyung = 5  '戊
            End Select
        Case 12: '해
            Select Case Day(INSA.DaeUn_Over_date)
                Case 0 To 7: INSA.DangLyung = 5  '戊
                Case 8 To 14: INSA.DangLyung = 1 '甲
                Case Else:    INSA.DangLyung = 9 '壬
            End Select
    End Select
    With StatusBar1.Panels 'panel setting
        .Item(1).Text = "[" & fSS(INSA.Sex, Han_sex) & "命]: " & INSA.Name _
                      & fSS(PALJA(1), Gan) & fSS(PALJA(2), Ji) & "年 " _
                      & fSS(PALJA(3), Gan) & fSS(PALJA(4), Ji) & "月 " _
                      & fSS(PALJA(5), Gan) & fSS(PALJA(6), Ji) & "日 " _
                      & fSS(PALJA(7), Gan) & fSS(PALJA(8), Ji) & "時 "
    End With
    Exit Sub
End Sub
'============================================================================
'기문 button 이 눌러졌을 때
'============================================================================
Private Sub b_gimun_Click()
    Dim p, k, itime As Integer
    Dim sr(1 To 3, 1 To 4) As String
    Dim s_bar_m As String
    Dim i_B(1 To 15) As Integer
    Dim iBF As Integer
    Dim Icnt, Jcnt As Integer
    '1908년 이하 자료를 입력하였을 경우 error발생
    
    gitxt_Result_Use = 2
    Call gp_Set_Default_Font
    
    Call init_Insa
    If INSA.Birth1 <= gDIV(1908, 1) Then
        MsgBox "1908년 이전 기문 포국은 지원하지 않습니다.", vbOKOnly, "理氣學(만세력)"
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
    
    s_bar_m = "　━━━━━━━╋━━━━━━━╋━━━━━━━　"
    sr(1, 1) = "  " _
             & fGS(1, 1) & "　" & fSS(GUNG(1).Yuk_Chun, yukeui) & fSS(GUNG(1).Chun, Number) & "巽┃" _
             & fGS(2, 1) & "　" & fSS(GUNG(2).Yuk_Chun, yukeui) & fSS(GUNG(2).Chun, Number) & "離┃" _
             & fGS(3, 1) & "　" & fSS(GUNG(3).Yuk_Chun, yukeui) & fSS(GUNG(3).Chun, Number) & "坤　"
    sr(1, 2) = "  " _
             & fGS(1, 2) & "　" & fSS(GUNG(1).Yuk_Ji, yukeui) & fSS(GUNG(1).Ji, Number) & fSS(GUNG(1).YukChin, g_YukChin) & "┃" _
             & fGS(2, 2) & "　" & fSS(GUNG(2).Yuk_Ji, yukeui) & fSS(GUNG(2).Ji, Number) & fSS(GUNG(2).YukChin, g_YukChin) & "┃" _
             & fGS(3, 2) & "　" & fSS(GUNG(3).Yuk_Ji, yukeui) & fSS(GUNG(3).Ji, Number) & fSS(GUNG(3).YukChin, g_YukChin) & "　"
    sr(1, 3) = "  " _
             & fGS(1, 3) & fSS(GUNG(1).ChunBong, chunbong1) & fSS(GUNG(1).JikBu, jikbu1) & fSS(GUNG(1).PalGwae, PalGwae1) & fSS(GUNG(1).TaeEul, TaeEul1) & fSS(GUNG(1).PalMun, PalMun1) & "┃" _
             & fGS(2, 3) & fSS(GUNG(2).ChunBong, chunbong1) & fSS(GUNG(2).JikBu, jikbu1) & fSS(GUNG(2).PalGwae, PalGwae1) & fSS(GUNG(2).TaeEul, TaeEul1) & fSS(GUNG(2).PalMun, PalMun1) & "┃" _
             & fGS(3, 3) & fSS(GUNG(3).ChunBong, chunbong1) & fSS(GUNG(3).JikBu, jikbu1) & fSS(GUNG(3).PalGwae, PalGwae1) & fSS(GUNG(3).TaeEul, TaeEul1) & fSS(GUNG(3).PalMun, PalMun1) & "　"
    sr(1, 4) = "  " _
             & fGS(1, 4) & fSS(GUNG(1).ChunBong, chunbong2) & fSS(GUNG(1).JikBu, jikbu2) & fSS(GUNG(1).PalGwae, PalGwae2) & fSS(GUNG(1).TaeEul, TaeEul2) & fSS(GUNG(1).PalMun, PalMun2) & "┃" _
             & fGS(2, 4) & fSS(GUNG(2).ChunBong, chunbong2) & fSS(GUNG(2).JikBu, jikbu2) & fSS(GUNG(2).PalGwae, PalGwae2) & fSS(GUNG(2).TaeEul, TaeEul2) & fSS(GUNG(2).PalMun, PalMun2) & "┃" _
             & fGS(3, 4) & fSS(GUNG(3).ChunBong, chunbong2) & fSS(GUNG(3).JikBu, jikbu2) & fSS(GUNG(3).PalGwae, PalGwae2) & fSS(GUNG(3).TaeEul, TaeEul2) & fSS(GUNG(3).PalMun, PalMun2) & "　"
             
    sr(2, 1) = "  " _
             & fGS(4, 1) & "　" & fSS(GUNG(4).Yuk_Chun, yukeui) & fSS(GUNG(4).Chun, Number) & "震┃" _
             & fGS(5, 1) & "　　" & fSS(GUNG(5).Chun, Number) & "中┃" _
             & fGS(6, 1) & "　" & fSS(GUNG(6).Yuk_Chun, yukeui) & fSS(GUNG(6).Chun, Number) & "兌　"
    sr(2, 2) = "  " _
             & fGS(4, 2) & "　" & fSS(GUNG(4).Yuk_Ji, yukeui) & fSS(GUNG(4).Ji, Number) & fSS(GUNG(4).YukChin, g_YukChin) & "┃" _
             & fGS(5, 2) & "　" & fSS(GUNG(5).Yuk_Ji, yukeui) & fSS(GUNG(5).Ji, Number) & fSS(GUNG(5).YukChin, g_YukChin) & "┃" _
             & fGS(6, 2) & "　" & fSS(GUNG(6).Yuk_Ji, yukeui) & fSS(GUNG(6).Ji, Number) & fSS(GUNG(6).YukChin, g_YukChin) & "　"
    sr(2, 3) = "  " _
             & fGS(4, 3) & fSS(GUNG(4).ChunBong, chunbong1) & fSS(GUNG(4).JikBu, jikbu1) & fSS(GUNG(4).PalGwae, PalGwae1) & fSS(GUNG(4).TaeEul, TaeEul1) & fSS(GUNG(4).PalMun, PalMun1) & "┃" _
             & fGS(5, 3) & "　" & fSS(GUNG(5).TaeEul, TaeEul1) & "　　　┃" _
             & fGS(6, 3) & fSS(GUNG(6).ChunBong, chunbong1) & fSS(GUNG(6).JikBu, jikbu1) & fSS(GUNG(6).PalGwae, PalGwae1) & fSS(GUNG(6).TaeEul, TaeEul1) & fSS(GUNG(6).PalMun, PalMun1) & "　"
    sr(2, 4) = "  " _
             & fGS(4, 4) & fSS(GUNG(4).ChunBong, chunbong2) & fSS(GUNG(4).JikBu, jikbu2) & fSS(GUNG(4).PalGwae, PalGwae2) & fSS(GUNG(4).TaeEul, TaeEul2) & fSS(GUNG(4).PalMun, PalMun2) & "┃" _
             & fGS(5, 4) & "　" & fSS(GUNG(5).TaeEul, TaeEul2) & "　　　┃" _
             & fGS(6, 4) & fSS(GUNG(6).ChunBong, chunbong2) & fSS(GUNG(6).JikBu, jikbu2) & fSS(GUNG(6).PalGwae, PalGwae2) & fSS(GUNG(6).TaeEul, TaeEul2) & fSS(GUNG(6).PalMun, PalMun2) & "　"
    sr(3, 1) = "  " _
             & fGS(7, 1) & "　" & fSS(GUNG(7).Yuk_Chun, yukeui) & fSS(GUNG(7).Chun, Number) & "艮┃" _
             & fGS(8, 1) & "　" & fSS(GUNG(8).Yuk_Chun, yukeui) & fSS(GUNG(8).Chun, Number) & "坎┃" _
             & fGS(9, 1) & "　" & fSS(GUNG(9).Yuk_Chun, yukeui) & fSS(GUNG(9).Chun, Number) & "乾　"
    sr(3, 2) = "  " _
             & fGS(7, 2) & "　" & fSS(GUNG(7).Yuk_Ji, yukeui) & fSS(GUNG(7).Ji, Number) & fSS(GUNG(7).YukChin, g_YukChin) & "┃" _
             & fGS(8, 2) & "　" & fSS(GUNG(8).Yuk_Ji, yukeui) & fSS(GUNG(8).Ji, Number) & fSS(GUNG(8).YukChin, g_YukChin) & "┃" _
             & fGS(9, 2) & "　" & fSS(GUNG(9).Yuk_Ji, yukeui) & fSS(GUNG(9).Ji, Number) & fSS(GUNG(9).YukChin, g_YukChin) & "　"
    sr(3, 3) = "  " _
             & fGS(7, 3) & fSS(GUNG(7).ChunBong, chunbong1) & fSS(GUNG(7).JikBu, jikbu1) & fSS(GUNG(7).PalGwae, PalGwae1) & fSS(GUNG(7).TaeEul, TaeEul1) & fSS(GUNG(7).PalMun, PalMun1) & "┃" _
             & fGS(8, 3) & fSS(GUNG(8).ChunBong, chunbong1) & fSS(GUNG(8).JikBu, jikbu1) & fSS(GUNG(8).PalGwae, PalGwae1) & fSS(GUNG(8).TaeEul, TaeEul1) & fSS(GUNG(8).PalMun, PalMun1) & "┃" _
             & fGS(9, 3) & fSS(GUNG(9).ChunBong, chunbong1) & fSS(GUNG(9).JikBu, jikbu1) & fSS(GUNG(9).PalGwae, PalGwae1) & fSS(GUNG(9).TaeEul, TaeEul1) & fSS(GUNG(9).PalMun, PalMun1) & "　"
    sr(3, 4) = "  " _
             & fGS(7, 4) & fSS(GUNG(7).ChunBong, chunbong2) & fSS(GUNG(7).JikBu, jikbu2) & fSS(GUNG(7).PalGwae, PalGwae2) & fSS(GUNG(7).TaeEul, TaeEul2) & fSS(GUNG(7).PalMun, PalMun2) & "┃" _
             & fGS(8, 4) & fSS(GUNG(8).ChunBong, chunbong2) & fSS(GUNG(8).JikBu, jikbu2) & fSS(GUNG(8).PalGwae, PalGwae2) & fSS(GUNG(8).TaeEul, TaeEul2) & fSS(GUNG(8).PalMun, PalMun2) & "┃" _
             & fGS(9, 4) & fSS(GUNG(9).ChunBong, chunbong2) & fSS(GUNG(9).JikBu, jikbu2) & fSS(GUNG(9).PalGwae, PalGwae2) & fSS(GUNG(9).TaeEul, TaeEul2) & fSS(GUNG(9).PalMun, PalMun2) & "　"
    If chk_mode.Value = Unchecked Then
        txt_Result.Text = " 성명: " & INSA.Name & vbCrLf & " 陽曆 " & INSA.B1y & "年 " & INSA.B1m & "月 " _
                        & INSA.B1d & "日 " & fSS(PALJA(8), Ji) & "時, " & fSS(INSA.Sex, Han_sex) & "命" _
                        & "  " & GUNG_NAME & vbCrLf _
                        & vbCrLf & sr(1, 1) & vbCrLf & sr(1, 2) & vbCrLf & sr(1, 3) & vbCrLf & sr(1, 4) & vbCrLf & s_bar_m _
                        & vbCrLf & sr(2, 1) & vbCrLf & sr(2, 2) & vbCrLf & sr(2, 3) & vbCrLf & sr(2, 4) & vbCrLf & s_bar_m _
                        & vbCrLf & sr(3, 1) & vbCrLf & sr(3, 2) & vbCrLf & sr(3, 3) & vbCrLf & sr(3, 4)
    Else
        txt_Result.Text = " 성명: " & INSA.Name & vbCrLf & " 陽曆: " & INSA.B1y & "年 " & INSA.B1m & "月 " _
                        & INSA.B1d & "日 " & fSS(PALJA(8), Ji) & "時, " & fSS(INSA.Sex, Han_sex) & "命" _
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
                txt_Result.SelColor = vbRed '년월일을 빨갛게
                txt_Result.SelStart = i_B(Jcnt * 5 + 1) + iBF + 5 + Icnt * 8
                txt_Result.SelLength = 1
                txt_Result.SelColor = vbBlue '천반수를 파랗게
                txt_Result.SelStart = i_B(Jcnt * 5 + 2) + iBF + 5 + Icnt * 8
                txt_Result.SelLength = 1
                txt_Result.SelColor = vbBlue '지반수를 파랗게
                txt_Result.SelStart = i_B(Jcnt * 5 + 2) + iBF + 6 + Icnt * 8
                txt_Result.SelLength = 1
                txt_Result.SelColor = &H880000 '육친을 진한파랑으로
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
        txt_Result.SelColor = vbRed '세궁을 빨강으로
        txt_Result.SelStart = i_B(1 * 5 + 2) + iBF + 6 + 1 * 8
        txt_Result.SelLength = 1
        txt_Result.SelColor = vbRed '중궁육친을 빨강으로
    End If
    txt_Result.SelStart = 0
    txt_Result.SelLength = 0
    txt_Result.SetFocus '커서위치 지정
End Sub
'======================================================================================
'명리 버튼이 눌러졌을때
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
    
    Dim d_In, d_pD, d_nD, d_lD As Date  '절입일 나타내기
    Dim i_pD, i_nD, i_lD As Integer
   
'--------------------------------------------------(요일 구하기)
  'Dim i As Integer
   Dim nWeek As Integer '시작요일(1~7 : 월~일)
   Dim uWeek As String  '해당요일
   Dim GF_YUN As String '윤달
'--------------------------------------------------(12궁 별자리 구하기)
   Dim StarNum As Integer
   Dim StarGungText As String
'----------------------------------------------------(사주작성)
    gitxt_Result_Use = 1
    Call gp_Set_Default_Font
    Call init_Insa
    
    i_daeun_No = 0
    f_daeun_chk = False
    
   INSA.Old = Year(Date) - Year(INSA.Birth1) + 1 ' 세(世) 나이 = 만 나이 + 1살
    
    For i_cnt = 7 To 1 Step -1      ' 대운 나이를 각 10년간 8항목으로 나열한다.
        '대운수 구하기
        'If INSA.DaeUnSu = 10 Then INSA.DaeUnSu = INSA.DaeUnSu - 10
        
        i_Dae = INSA.DaeUnSu + (i_cnt - 1) * 10
        
        If i_Dae < INSA.Old And f_daeun_chk = False And INSA.Old - i_Dae <= 10 Then
            i_daeun_No = (i_cnt - 8) * (-1)
            f_daeun_chk = True               '대운수 색상표시
        End If
        
        'MsgBox "i_Dae =" & INSA.DaeUnSu, vbOKOnly, "유성"
        
        If i_Dae <= 9 And i_Dae <> 10 Then        ' 대운수의 두자리 칸 수 정렬
           s_Saju(3) = s_Saju(3) & Mid(INSA.i_Day2, 1, 3) & " "
        Else
           s_Saju(3) = s_Saju(3) & i_Dae & "  "
        End If
        
        '대운천간 구하기
        If (INSA.Sex Mod 2) = (PALJA(1) Mod 2) Then '양남 혹은 음녀
            i_Gan = (PALJA(3) + i_cnt) Mod 10
        Else
            i_Gan = (PALJA(3) - i_cnt) Mod 10
        End If
        If i_Gan <= 0 Then i_Gan = i_Gan + 10
        s_Saju(4) = s_Saju(4) & fSS((i_Gan), Gan) & "  "
        '대운지지 구하기
        If (INSA.Sex Mod 2) = (PALJA(1) Mod 2) Then '양남 혹은 음녀
            i_Ji = (PALJA(4) + i_cnt) Mod 12
        Else
            i_Ji = (PALJA(4) - i_cnt) Mod 12
        End If
        If i_Ji <= 0 Then i_Ji = i_Ji + 12
        s_Saju(5) = s_Saju(5) & fSS((i_Ji), Ji) & "  "
        
        '세운년도 구하기
        i_today_yy = (Year(Date) - 1900 + i_cnt - 3) Mod 100
        If i_today_yy < 0 Then i_today_yy = i_today_yy + 100
        If i_today_yy <= 9 Then
            s_Saju(6) = s_Saju(6) & "0" & i_today_yy & "  "
        Else
            s_Saju(6) = s_Saju(6) & i_today_yy & "  "
        End If
        '세운천간 구하기 : 1900년은 경자년임
        i_Today_Gan = (Year(Date) - 1900 + i_cnt + 7 - 3) Mod 10
        If i_Today_Gan <= 0 Then i_Today_Gan = 10 + i_Today_Gan
        s_Saju(7) = s_Saju(7) & fSS(CInt(i_Today_Gan), Gan) & "  "
        '세운지지 구하기 : 1900년은 경자년임
        i_Today_Ji = (Year(Date) - 1900 + i_cnt + 1 - 3) Mod 12
        If i_Today_Ji <= 0 Then i_Today_Ji = 12 + i_Today_Ji
        s_Saju(8) = s_Saju(8) & fSS(CInt(i_Today_Ji), Ji) & "  "
    Next i_cnt
'----------------------------------------------------(윤달표시)
    '음력일에서 윤달일 경우 윤달 출력문
    If Opt_Yun_True.Value = True And Opt_Yun_True.Enabled = True Then '윤달버튼 활성과 체크
            GF_YUN = "[閏月]"
    Else  '양력일에서 계산된 일자가 윤달이 있을 때 윤달 출력문
        If bYun = 1 Then    '윤월 전역변수(cal_saju.bas)
           GF_YUN = "[閏月]"
        Else ': bYun = 0   '윤월 전역변수(cal_saju.bas)
           GF_YUN = "[平月]"
        End If
    End If
'----------------------------------------------------(절입일 표기)
    d_In = INSA.Birth1
    d_pD = f_Pre_Div24((d_In))
    d_nD = f_Next_Div24((d_In))
    d_lD = f_Next_Div24((d_nD))
    i_pD = fi_Pre_Div24((d_In))
    i_nD = i_pD + 1:    If i_nD > 24 Then i_nD = i_nD - 24
    i_lD = i_pD + 2:    If i_lD > 24 Then i_lD = i_lD - 24
'----------------------------------------------------(피타고라스 운명수 계산)
   '// 년+월+일의 자리수를 따로 계산하여 합산함.
     
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
   
'----------------------------------------------------(Text 출력)
    s_Saju(1) = fSS(PALJA(7), Gan) & "  " & fSS(PALJA(5), Gan) & "  " & fSS(PALJA(3), Gan) & "  " & fSS(PALJA(1), Gan)
    s_Saju(2) = fSS(PALJA(8), Ji) & "  " & fSS(PALJA(6), Ji) & "  " & fSS(PALJA(4), Ji) & "  " & fSS(PALJA(2), Ji)
    
'----------------------------------------------------(요일 출력 + 바이오리듬 출력)
  'If Opt_Cal_Sun.Value = True Then '양력일 경우에만 바이오 리듬 출력..
  '   Bio(u) ' 바이오 리듬 출력
  'Else
  '   For i = 0 To 3
  '       Label8(i) = ""
  '   Next i
  '   Text6.Text = ""
  'End If
    
 ' 바이오 리듬 출력
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
                Case 1: uWeek = "土"
                Case 2: uWeek = "日"
                Case 3: uWeek = "月"
                Case 4: uWeek = "火"
                Case 5: uWeek = "水"
                Case 6: uWeek = "木"
                Case 7: uWeek = "金"
                Case Else: uWeek = "??"
    End Select
    
    If chk_mode.Value = Unchecked Then
        txt_Result.Text = "<" & fSS(INSA.Sex, Han_sex) & "命> " & INSA.Name & "(現나이:" & INSA.Old & "世)" _
                    & vbCrLf & " 陽曆 : " & INSA.B1y & "年 " & INSA.B1m & "月 " _
                    & INSA.B1d & "日 " & fSS(PALJA(8), Ji) & "時,, (" & uWeek & "曜日)" & " <運命數:" & p & "> " _
                    & vbCrLf & " 陰曆 : " & INSA.B0y & "年 " & INSA.B0m & "月 " _
                    & INSA.B0d & "日 " & GF_YUN & " " & Text4.Text & "時 " & Text5.Text & "分 "
                    
        If (CInt(INSA.B1m) = 1 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 2 And CInt(INSA.B1d) < 20) Then
           txt_Result.Text = txt_Result.Text & "<★물병자리>" & vbCrLf
           StarNum = 1
        End If
        If (CInt(INSA.B1m) = 2 And CInt(INSA.B1d) > 19) Or (CInt(INSA.B1m) = 3 And CInt(INSA.B1d) < 21) Then
           txt_Result.Text = txt_Result.Text & "<★물고기자리>" & vbCrLf
           StarNum = 2
        End If
        If (CInt(INSA.B1m) = 3 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 4 And CInt(INSA.B1d) < 21) Then
           txt_Result.Text = txt_Result.Text & "<★양자리>" & vbCrLf
           StarNum = 3
        End If
        If (CInt(INSA.B1m) = 4 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 5 And CInt(INSA.B1d) < 21) Then
           txt_Result.Text = txt_Result.Text & "<★황소자리>" & vbCrLf
           StarNum = 4
        End If
        If (CInt(INSA.B1m) = 5 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 6 And CInt(INSA.B1d) < 22) Then
           txt_Result.Text = txt_Result.Text & "<★쌍둥이자리>" & vbCrLf
           StarNum = 5
        End If
        If (CInt(INSA.B1m) = 6 And CInt(INSA.B1d) > 21) Or (CInt(INSA.B1m) = 7 And CInt(INSA.B1d) < 24) Then
           txt_Result.Text = txt_Result.Text & "<★게자리>" & vbCrLf
           StarNum = 6
        End If
        If (CInt(INSA.B1m) = 7 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 8 And CInt(INSA.B1d) < 24) Then
           txt_Result.Text = txt_Result.Text & "<★사자자리>" & vbCrLf
           StarNum = 7
        End If
        If (CInt(INSA.B1m) = 8 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 9 And CInt(INSA.B1d) < 24) Then
           txt_Result.Text = txt_Result.Text & "<★처녀자리>" & vbCrLf
           StarNum = 8
        End If
        If (CInt(INSA.B1m) = 9 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 10 And CInt(INSA.B1d) < 24) Then
           txt_Result.Text = txt_Result.Text & "<★천칭자리>" & vbCrLf
           StarNum = 9
        End If
        If (CInt(INSA.B1m) = 10 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 11 And CInt(INSA.B1d) < 23) Then
           txt_Result.Text = txt_Result.Text & "<★전갈자리>" & vbCrLf
           StarNum = 10
        End If
        If (CInt(INSA.B1m) = 11 And CInt(INSA.B1d) > 22) Or (CInt(INSA.B1m) = 12 And CInt(INSA.B1d) < 23) Then
           txt_Result.Text = txt_Result.Text & "<★사수자리>" & vbCrLf
           StarNum = 11
        End If
        If (CInt(INSA.B1m) = 12 And CInt(INSA.B1d) > 22) Or (CInt(INSA.B1m) = 1 And CInt(INSA.B1d) < 21) Then
           txt_Result.Text = txt_Result.Text & "<★염소자리>" & vbCrLf
           StarNum = 12
        End If
                    
        
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & "    時  日  月  年  <命造>" _
                    & vbCrLf & "  " & "    " & s_Saju(1) & vbCrLf _
                    & vbCrLf & "  " & "    " & s_Saju(2) _
                    & vbCrLf & "           (" & fSS(INSA.DangLyung, Gan) & fSS(INSA.DangLyung, Ohaeng) & "分野)" _
                    & vbCrLf & "  " & s_Saju(4) _
                    & vbCrLf & "  " & s_Saju(5) _
                    & vbCrLf & "  " & s_Saju(3) & "<大運>" & vbCrLf _
                    & vbCrLf & "  " & s_Saju(7) _
                    & vbCrLf & "  " & s_Saju(8) _
                    & vbCrLf & "  " & s_Saju(6) & "<歲運>  " & vbCrLf
   
                   
        txt_Result.SelStart = 0 '"　"
        txt_Result.SelLength = 0
        txt_Result.SetFocus
    Else
        txt_Result.Text = "<" & fSS(INSA.Sex, Han_sex) & "命> " & INSA.Name & "(現나이:" & INSA.Old & "世)" _
                    & vbCrLf & " 陽曆 : " & INSA.B1y & "年 " & INSA.B1m & "月 " _
                    & INSA.B1d & "日 " & fSS(PALJA(8), Ji) & "時,, (" & uWeek & "曜日)" & "  <運命數:" & p & "> " _
                    & vbCrLf & " 陰曆 : " & INSA.B0y & "年 " & INSA.B0m & "月 " _
                    & INSA.B0d & "日 " & GF_YUN & " " & Text4.Text & "時 " & Text5.Text & "分" _
                    & vbCrLf & "  " & "   時     日     月     年  <命式>"
                    
        i_B(1) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(1) & vbCrLf & "  " & s_Saju(2)
        i_B(2) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "                (" & fSS(INSA.DangLyung, Gan) & fSS(INSA.DangLyung, Ohaeng) & "分野)"
        i_B(3) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(4) & ","
        i_B(4) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(5) & ","
        i_B(5) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(3) & "<大運>" & vbCrLf
        i_B(6) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(7)
        i_B(7) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(8)
        i_B(8) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & "  " & s_Saju(6) & "<歲運>"
        i_B(9) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf & vbCrLf & f_SajuStr((i_pD), Div) & " :" & "(양력)" & d_pD _
                & vbCrLf & f_SajuStr((i_nD), Div) & " :" & "(양력)" & d_nD _
                & vbCrLf & f_SajuStr((i_lD), Div) & " :" & "(양력)" & d_lD
        i_B(10) = Len(txt_Result.Text)
        txt_Result.Text = txt_Result.Text & vbCrLf
        
        If (CInt(INSA.B1m) = 1 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 2 And CInt(INSA.B1d) < 20) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(물병자리)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 2 And CInt(INSA.B1d) > 19) Or (CInt(INSA.B1m) = 3 And CInt(INSA.B1d) < 21) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(물고기자리)=============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 3 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 4 And CInt(INSA.B1d) < 21) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(양자리)=================" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 4 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 5 And CInt(INSA.B1d) < 21) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(황소자리)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 5 And CInt(INSA.B1d) > 20) Or (CInt(INSA.B1m) = 6 And CInt(INSA.B1d) < 22) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(쌍둥이자리)=============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 6 And CInt(INSA.B1d) > 21) Or (CInt(INSA.B1m) = 7 And CInt(INSA.B1d) < 24) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(게자리)=================" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 7 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 8 And CInt(INSA.B1d) < 24) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(사자자리)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 8 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 9 And CInt(INSA.B1d) < 24) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(처녀자리)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 9 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 10 And CInt(INSA.B1d) < 24) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(천칭자리)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 10 And CInt(INSA.B1d) > 23) Or (CInt(INSA.B1m) = 11 And CInt(INSA.B1d) < 23) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(전갈자리)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 11 And CInt(INSA.B1d) > 22) Or (CInt(INSA.B1m) = 12 And CInt(INSA.B1d) < 23) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(사수자리)===============" & vbCrLf
        End If
        If (CInt(INSA.B1m) = 12 And CInt(INSA.B1d) > 22) Or (CInt(INSA.B1m) = 1 And CInt(INSA.B1d) < 21) Then
            txt_Result.Text = txt_Result.Text & "==★12宮★==(염소자리)===============" & vbCrLf
        End If
        

        txt_Result.SelStart = i_B(1) - 6
        txt_Result.SelLength = 6
        txt_Result.SelColor = vbBlue '<명식>'을 파랗게 (-.-)
        txt_Result.SelStart = i_B(1)
        txt_Result.SelLength = i_B(2) - i_B(1)
        txt_Result.SelFontName = "굴림체"
        txt_Result.SelFontSize = "20"
        txt_Result.SelBold = True '팔자를 굵고 크게
        txt_Result.SelStart = i_B(6) - 6
        txt_Result.SelLength = 6
        txt_Result.SelColor = vbBlue '<대운>'을 파랗게
        txt_Result.SelStart = i_B(9) - 6
        txt_Result.SelLength = 6
        txt_Result.SelColor = vbBlue '<세운>'을 파랗게
        txt_Result.SelStart = i_B(3) + i_daeun_No * 3
        txt_Result.SelLength = 2
        txt_Result.SelColor = vbRed '대운천간을 빨갛게
        txt_Result.SelStart = i_B(4) + i_daeun_No * 3
        txt_Result.SelLength = 2
        txt_Result.SelColor = vbRed '대운지지를 빨갛게
        txt_Result.SelStart = i_B(6) + 5 * 3
        txt_Result.SelLength = 2
        txt_Result.SelColor = vbRed '세운천간을 빨갛게
        txt_Result.SelStart = i_B(7) + 5 * 3
        txt_Result.SelLength = 2
        txt_Result.SelColor = vbRed '세운지지를 빨갛게
        txt_Result.SelStart = 0
        txt_Result.SelLength = 0
        txt_Result.SetFocus
        txt_Result.SelStart = i_B(10)
        txt_Result.SelFontName = "바탕체"
        txt_Result.SelBold = True '팔자를 굵고 크게
    End If
   
   Call StarGung(StarNum, StarGungText)
   
   Select Case p
          Case 1: MsgBox "피타고라스: 1 번 유아독존형(唯我獨尊型)입니다." & vbCrLf & StarGungText
          Case 2: MsgBox "피타고라스: 2 번 모성애형(母性愛型)입니다." & vbCrLf & StarGungText
          Case 3: MsgBox "피타고라스: 3 번 단계적 발전형(段階的發展型)입니다." & vbCrLf & StarGungText
          Case 4: MsgBox "피타고라스: 4 번 안전우선형(安全優先型)입니다." & vbCrLf & StarGungText
          Case 5: MsgBox "피타고라스: 5 번 물에뜬 기름형입니다." & vbCrLf & StarGungText
          Case 6: MsgBox "피타고라스: 6 번 외유내집형(外柔內執型)입니다." & vbCrLf & StarGungText
          Case 7: MsgBox "피타고라스: 7 번 신비주의형(神秘主義型)입니다." & vbCrLf & StarGungText
          Case 8: MsgBox "피타고라스: 8 번 일방통행형(一方通行型)입니다." & vbCrLf & StarGungText
          Case 9: MsgBox "피타고라스: 9 번 이미지 과잉형입니다." & vbCrLf & StarGungText
          Case 11: MsgBox "피타고라스: 11 번 유토피아형입니다." & vbCrLf & StarGungText
          Case 22: MsgBox "피타고라스: 22 번 하면된다형입니다." & vbCrLf & StarGungText
   End Select
    
End Sub

Private Sub StarGung(StarNum As Integer, StarGungText As String)

Select Case StarNum
       Case 1: StarGungText = "☞ ★12宮★==1월 21일 ~ 2월 19일 생" & vbCrLf & "물병자리(1.21~2.19) -- 이 별자리에 속한 사람은 항상 집단가운데 있으며 대중과 함께 생각하고 행동하는 것을 바란다. 물병자리 사람의 의지를 결정하는 것은 그 주위에 몰려 있는 사람들이다. 대중을 사랑하고, 그들을 위해서는 생명조차도 내던질 수 있다고 생각한다. 사회 일반의 도덕보다는 인간전체의 고뇌를 이해하려고 한다. 그리고 그것이 사회적으로 더 가치있는 일이라고 본다. 결국은 혁명가가 되려고도 하지않고, 평범한 민중으로 인생을 마치려고도 하지 않는다."
       Case 2: StarGungText = "☞ ★12宮★==2월 20일 ~ 3월 20일 생" & vbCrLf & "물고기자리(2.20~3.20) -- 이 기간에 태어난 사람은 정신적으로든 물질적으로든 철저하려고 하는 타입이다. 그렇게 함으로서 충분히 자기자신도 만족할 수 있다. 가령 장사등을 하면서 사람들과 사귈 경우 그 포용력이 진가를 발휘한다면 깊은 충족감을 맛볼 수가 있겠지만 만약 그렇지 못하다면 생각하지 못한 실패를 떠맡아 버리게 된다. 주위와 친절한 인간관계를 유지하기는 하나 다른 사람들을 쉽사리 믿기 때문에 인생에 있어서 여러 차례 속임을 당하거나 손해를 본다."
       Case 3: StarGungText = "☞ ★12宮★==3월 21일 ~ 4월 20일 생" & vbCrLf & "양자리(3.21~4.20) -- 이 별자리에 속하는 사람은 정의감에 넘친 강한 생명력을 가진다. 어떠한 분야에서도 제1인자로서 실력을 발휘할 수 있는 통솔력이 있다. 그러나 그 방법에 있어서 너무 성급하거나 이론만 앞서가기 때문에 주위사람들에 대한 작은 배려를 하지 못해 예상치 못한 실패를 하는 수도 있다. 그 결과 모처럼 얻은 천부의 재능을 다 써보지 못하고 좌절하는 경우가 생길 수도 있다."
       Case 4: StarGungText = "☞ ★12宮★==4월 21일 ~ 5월 20일 생" & vbCrLf & "황소자리(4.21~5.20) -- 온후한 성격과 성실한 인간관계로 위험보다는 안전한 길을 택해 신중한 인생을 살아가려는 것이 황소자리에 속한 사람의 특징이다. 사물들을 심각하게 생각하지 않으며, 커다란 흐름에 거서리지 않고 주위와의 조화를 지키려고 한다. 따라서 적도 적고, 편안한 환경이 보장되기만 한다면 주위의 사람들과 어울려 온화하고 평화로운 생활을 해 나간다."
       Case 5: StarGungText = "☞ ★12宮★==5월 21일 ~ 6월 21일 생" & vbCrLf & "쌍둥이자리(5.21~6.21)  -- 쌍둥이자리에 속한 사람은 재치가 풍부하고 자유로운 생각과 결단력을 가지고 있다. 한 곳에 정착하는 것을 좋아하지 않으며, 무엇인가에 몰두하는 일이 드물다. 분위기에 맞는 적절한 생각과 행동을 하지만 단조롭고 따분한 환경을 좋아하지 않는다. 자기 안에 있는 여러가지 모순된 요소를 자신의 의지에의해 하나의 힘으로 합칠 수만 있다면 뜻대로 진가를 발휘할 수 있을 것이다."
       Case 6: StarGungText = "☞ ★12宮★==6월 22일 ~ 7월 22일 생" & vbCrLf & "게자리(6.22~7.22)  -- 게자리에 태어난 사람은 마음이 굳고 성실하며 가정적인 성격의 소유자이다. 따라서 사람들과의 관계에 있어서도 모가나지 않으며 환경에 대한 순응력이 뛰어나다. 목적을 달성하는데 있어서도 타인의 행동과 의지에 융통성있게 반응하여 안전한 결과를 얻어려고 노력한다. 자기와 남과의 구별이 명확하지 않으며, 남의 일이나 물건도 자신의 것인양 책임감을 가지고 행동한다."
       Case 7: StarGungText = "☞ ★12宮★==7월 23일 ~ 8월 22일 생" & vbCrLf & "사자자리(7.23~8.22)  -- 명쾌한 성격과 뜨거운 열정을 가진 사자자리의 사람은 언제나 명랑하며 남의 관심의 대상이 되는 것을 좋아한다. 천성의 순진함으로 때로는 자기 만족에 빠지거나, 허영에 찬 사교세계에 젖어들 위험성이 있다. 그러나 자기의 성격을 누르고 열심히 노력한다면 의지의 강도에 따라 어떤 곤란한 난관도 밀어부치고 목적을 향해 매진할 수 있으며 사람들로부터 압도적인 인기를 얻을 수도 있다."
       Case 8: StarGungText = "☞ ★12宮★==8월 23일 ~ 9월 22일 생" & vbCrLf & "처녀자리(8.23~9.22)  -- 처녀자리의 사람은 감정이 섬세하며 순수한 정신을 간직하고 있다. 그래서 자기를 희생하여도 여전히 모든 일에 헌신적인 사명감을 가지고 성의를 다한다. 일을 행함에 있어서는 보다 높고 완전한 수준을 향하여 일로 매진하며, 결코 중도에서 포기하거나 좋은 형편의 현실과 타협하지 않는 결벽증을 가지고 있다. 희망과 꿈의 세계는 늘 이러한 사람들의 무한한 봉사정신을 요구하고 있다."
       Case 9: StarGungText = "☞ ★12宮★==9월 23일 ~ 10월 21일 생" & vbCrLf & "천칭자리(9.23~10.21)  -- 이 별자리에 태어난 사람은 균형잡힌 우아한 세계에 안주하기를 바란다. 온화한 인간 관계로 다툼을 좋아하지 않으며, 주위 사람들과 사회와의 조화를 생각해서 그 누구라도 사랑할 수 있다. 아울러 천칭자리의 냉철한 이성은 극단적인 행동을 거부하고 항상 품위있는 태도를 유지 할려고 한다. 자신이 원하는 이러한 세계를 위해 자존심과 욕망을 표면에 내세우지 않고 평화롭고 균형잡힌 환경을 유지하는데 최선을 다한다."
       Case 10: StarGungText = "☞ ★12宮★==10월 22일 ~ 11월 21일 생" & vbCrLf & "전갈자리(10.22~11.21)  -- 사물의 이면성을 의식하며 탐구를 계속해 나가는 것이 이 별자리에 속하는 사람의 특징이다. 이들이 가지고 있는 세계는 비밀이 가득차서 그 속을 해석하기가 쉽지않다. 침착한 통찰력과 신중한 행동은 밖으로 눈에 뛰는 것이 아니며, 내면 깊은 곳으로 항해지는 것이다. 따라서 비사교적이며 말수도 적고 겸허한 표현밖에 할 수 없어 남에게서 과소평가를 받기도 하지만, 일단 반격에 나서면 그 힘은 상대를 철저히 두들길만큼 강렬하다. 전갈자리에는 겸허한 감각과 존엄함이 늘 함께하고 있다."
       Case 11: StarGungText = "☞ ★12宮★==11월 22일 ~ 12월 21일 생" & vbCrLf & "사수자리(11.22~12.21)  -- 십일월 말에서 십이월 중순에 태어난 사수자리의 사람은 천진난만 밝음과 다른일에 일체 신경쓰지 않고 한곳으로 돌진하는 행동력을 가지고 있다. 이러한 성격은 온갖경험을 원하고, 풍부한 지식을 획득해 힘찬 생활인을 만들어 낸다. 보다 넓게, 보다 멀리, 보다 깊게, 그리고 보다 많이, 인생을 확실히 즐기려 할 것이다. 게다가 민첩한 행동력으로 목적을 향해 화살처럼 전진해 나간다. 하찮은 것에 고민하거나 과거의 상처따위를 되돌아보는 일은 하지않는 것이 또한 이 별자리에 속한 사람의 특징이다."
       Case 12: StarGungText = "☞ ★12宮★==12월 23일 ~ 1월 20일 생" & vbCrLf & "염소 자리(12.23~1.20) -- 일견하기에는 온화하고 얌전하게 보이지만 그 이면에는 격렬한 공격성을 감추고 있는것이 염소자리의 사람이다. 목적에 도달하기 위해서는 주의 깊게 한걸음 한걸음 안전한 방법을 선택하면서 결국에는 승리를 얻는다. 꾸준한 자기 향상의 마음은 가능한한 위험을 피하고 정해진 야망을 향해 참을성있게 쉬지않고 나아가는 노력을 행한다. 이러한 성격 때문에 마음에 드는 친구를 얻기 어렵고 주위에서 고립되어 버릴지 모른다."
 
 End Select
 
End Sub


Private Sub m_fExit_Click()
    Call gp_Save_Main
    End
End Sub

'menu:파일-열기
Private Sub m_fopen_Click()
    Dim File_Line As String
    Dim File_Data As String
    On Error GoTo ErrHandler

    With CommonDialog1
        .CancelError = True
  
        .Filter = "지원파일(*.rtf;*.txt;*.cap;*doc)|*.txt;*.cap;*doc;*.rtf|" & _
           "텍스트 파일(*.txt)|*.txt|캡쳐 파일(*.cap)|*.cap|" & _
           "리치텍스트 파일(*.rtf)|*.rtf|" & _
           "설명 파일(*.doc)|*.doc|모든 파일(*.*)|*.*"
        .FilterIndex = 1
        .Flags = 0
        .DialogTitle = "텍스트파일 열기"
 
        CommonDialog1.ShowOpen
'        file_name = .FileName

        '파일 여는동안 모래시계 표시한다.
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
        ' 마우스 포인터 원래 값으로 표시한다.
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
'Resume  '확인시까지 무한루프를 돌린다. (Ctrl+Break)로 정지시킨다.
'Resume next '에러가 난 다음 행부터 실행시킨다.
End Sub

Private Sub m_fprint_Click()
 On Error GoTo ErrHandler
    ' Cancel을 True로 설정한다.
    CommonDialog1.CancelError = True
    '출력 기본 플레그 지정
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

'menu:파일-저장
Private Sub m_fsave_Click()
    On Error GoTo Err
    CommonDialog1.CancelError = True
    CommonDialog1.Filter = "지원파일(*.rtf;*.txt;*.cap;*doc)|*.txt;*.cap;*doc;*.rtf|" & _
           "텍스트 파일(*.txt)|*.txt|캡쳐 파일(*.cap)|*.cap|" & _
           "리치텍스트 파일(*.rtf)|*.rtf|" & _
           "설명 파일(*.doc)|*.doc|모든 파일(*.*)|*.*"
    CommonDialog1.FilterIndex = 1
    CommonDialog1.Flags = 0
    If PALJA(1) <> 0 Then
        CommonDialog1.FileName = fSS(PALJA(1), Gan) & fSS(PALJA(2), Ji) & "년" _
                               & fSS(PALJA(3), Gan) & fSS(PALJA(4), Ji) & "월" _
                               & fSS(PALJA(5), Gan) & fSS(PALJA(6), Ji) & "일" _
                               & fSS(PALJA(7), Gan) & fSS(PALJA(8), Ji) & "시-" _
                               & Trim(txt_Name.Text)
    End If
    CommonDialog1.DialogTitle = "파일 저장"
    CommonDialog1.InitDir = App.Path ' exe 실행파일이 있는 위치지정
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
'menu:파일-종료
Private Sub m_file_Exit_Click(Index As Integer)
 Unload Me
'종료
'End는 (프로그램 중단 터미네이터)이기에 윈도우 종료함수를 사용한다.
End Sub

'menu:편집-전체선택
Private Sub m_Eall_Click()
    With txt_Result
        .SetFocus
        .SelStart = 0
        .SelLength = Len(.Text)
    End With
End Sub

'menu:편집-잘라내기
Private Sub m_Ecut_Click()
    Clipboard.Clear
    Clipboard.SetText txt_Result.SelText
    txt_Result.SelText = ""
End Sub

'menu:편집-복사
Private Sub m_Ecopy_Click()
    Clipboard.Clear
    Clipboard.SetText txt_Result.SelText
End Sub

'menu:편집-붙여넣기
Private Sub m_Epaste_Click()
    txt_Result.SelText = Clipboard.GetText
End Sub

'menu:편집-글자색
Private Sub m_ETclr_Click()
    On Error GoTo ErrHandler

    ' Cancel을 True로 설정한다.
    CommonDialog1.CancelError = True
    '플래그값 설정한다.
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

'menu:편집:배경색
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

'메뉴:옵션-시간
Private Sub m_otime_Click()
    frm_Opt_T.Show vbModal
End Sub '메뉴:도움말-만세력정보


'menu:편집-폰트
Private Sub m_EFont_Click()
    On Error GoTo ErrHandler
    txt_Result.SetFocus
    With CommonDialog1
        .CancelError = True
  
  ' 리치텍스트박스에 설정된 정보를 글꼴대화상자에 설정한다.
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
        ' 글꼴 대화상자를 화면에 출력한다.
        .ShowFont
  
        If txt_Result.SelLength > 0 Then
        ' 글꼴 대화상자에서 설정된 정보를 텍스트박스에 설정한다.
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
    StatusBar1.Panels(1) = "글자체:" + txt_Result.Font.Name _
                         & "  글자크기:" + Str(txt_Result.Font.Size)
    End With
    txt_Result.SetFocus
    Exit Sub
ErrHandler:
    MsgBox Str$(Err) & "==>" & Error$
End Sub
'메뉴:도움말-만세력사용법
Private Sub m_hman_Click()
On Error GoTo h_hinf_ERR
    txt_Result.LoadFile "ucalhelp.rtf", rtfRTF
    Exit Sub
h_hinf_ERR:
    MsgBox "도움말 file(ucalhelp.rtf)을 열 수 없습니다.[file path확인要!]", vbOKOnly, "理氣學(만세력)"
End Sub

'메뉴:도움말-만세력정보
Private Sub m_hinf_Click()
    frm_Help_inf.Show vbModal
End Sub
'문자열 선택시 menu 선택가능 조정
Private Sub sel_clip()
    If txt_Result.SelLength > 0 Then '선택영역이 있을 경우 전체 사용가능
        m_Ecopy.Enabled = True
        m_Ecut.Enabled = True
        m_Epaste.Enabled = True
    Else '선택영역이 없을 경우
        If Len(Clipboard.GetText) > 0 Then '클립보드에 있는경우 붙여넣기만 가능
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



'입력 편의를 위해 역상으로 해줌
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
'년이 바뀔 때
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
'월이 바뀔 때
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
'년에서 좌측 버튼을 위아래로 움직이면 년도가 10년씩 증감한다.
'---------------
'Private Sub u10Year_DownClick()
'        Text1.Text = CStr(CInt(Text1.Text) - 10)
'End Sub
'Private Sub u10Year_UpClick()
'        Text1.Text = CStr(CInt(Text1.Text) + 10)
'End Sub
'---------------
'년에서 우측 버튼을 위아래로 움직이면 년도가 1년씩 증감한다.
'---------------
'Private Sub u1Year_DownClick()
'        Text1.Text = CStr(CInt(Text1.Text) - 1)
'End Sub
'Private Sub u1Year_UpClick()
'        Text1.Text = CStr(CInt(Text1.Text) + 1)
'End Sub
'---------------
'1월에서 아래로 내리면 년도가 바뀌고 12월로 된다.
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
'12월에서 위로올리면 년도가 바뀌고 1월로 된다.
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
'일에서 버튼을 아래로 내리면 일수가 하루씩 준다.
'---------------
Private Sub uDate_DownClick()
           
    If Text3.Text = "1" Then
        Text2.Text = CStr(CInt(Text2.Text) - 1)
        If Text2.Text = "0" Then       ' 1월 밑으로 내려가면 다시 12월로 복귀
           Text2.Text = "12"
        End If
        Text3.Text = "31"
    'Else
    '    Text3.Text = CStr(CInt(Text3.Text) - 1)
    End If
End Sub
'---------------
'일에서 버튼을 위로올리면 일수가 하루씩 증가한다.
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
'시(時) 콘트롤
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
'분(分) 콘트롤
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
'말일을 구한다.
'---------------
Private Function uGetLastDay(nYear As Integer, nMonth As Integer) As Integer
Dim nMaxDay

Dim nLast As Integer '말일

    nMaxDay = Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)
    
    If nMonth = 2 Then
        If (nYear Mod 400) = 0 Or (nYear Mod 100) <> 0 And (nYear Mod 4) = 0 Then
        nMaxDay(1) = 29
        End If
    End If
    
    nLast = nMaxDay(nMonth - 1)  '마지막 날 수를 반환
    
    If nLast < CInt(Text3.Text) Then
       MsgBox nLast & "일이 이달의 마지막 날입니다.", vbOKOnly, "理氣學(만세력)"
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
            MsgBox "년도는 1881와 2050 사이값이어야 합니다.", vbOKOnly, "理氣學(만세력)"
            With Text1
                .SetFocus
                .SelStart = 0
                .SelLength = Len(.Text)
            End With
        End If
        Exit Sub
    Else
        MsgBox "년도값은 반드시 숫자이어야 합니다.", vbOKOnly, "理氣學(만세력)"
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
            MsgBox "월은 1과 12 사이값이어야 합니다.", vbOKOnly, "理氣學(만세력)"
            With Text2
                .SetFocus
                .SelStart = 0
                .SelLength = Len(.Text)
            End With
        End If
        Exit Sub
    Else
        MsgBox "월값은 반드시 숫자이어야 합니다.", vbOKOnly, "理氣學(만세력)"
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
    'Dim nLast As Integer '말일
    
    'nLast = uGetLastDay(CInt(Text1.Text), CInt(Text2.Text))

    If IsNumeric(Text3.Text) Then
        idd = CInt(Text3.Text)
        If idd < 1 Or idd > 31 Then
            MsgBox "일은 1과 31 사이값이어야 합니다.", vbOKOnly, "理氣學(만세력)"
            With Text3
                .SetFocus
                .SelStart = 0
                .SelLength = Len(.Text)
            End With
        End If
    Else
        MsgBox "일값은 반드시 숫자이어야 합니다.", vbOKOnly, "理氣學(만세력)"
        With Text3
            .SetFocus
            .SelStart = 0
            .SelLength = Len(.Text)
        End With
    End If

    'If nLast < CInt(Text3.Text) Then
    '    MsgBox nLast & "일이 이달의 마지막 날입니다.", vbOKOnly, "理氣學(만세력)"
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
            MsgBox Chr(34) & "시는 0과 23사이 값이어야 합니다." & Chr(34), vbOKOnly, "理氣學(만세력)"  ' "(쌍 따옴표) 는 아스키 값으로 chr(34)로 표현
            With Text4
                .SetFocus
                .SelStart = 0
                .SelLength = Len(.Text)
            End With
        End If
    Else
        MsgBox Chr(34) & "시값은 반드시 숫자이어야 합니다." & Chr(34), vbOKOnly, "理氣學(만세력)"
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
            MsgBox "분은 0과 59 사이값이어야 합니다.", vbOKOnly, "理氣學(만세력)"
            With Text5
                .SetFocus
                .SelStart = 0
                .SelLength = Len(.Text)
            End With
        End If
    Else
        MsgBox "분은 반드시 숫자이어야 합니다.", vbOKOnly, "理氣學(만세력)"
        With Text5
            .SetFocus
            .SelStart = 0
            .SelLength = Len(.Text)
        End With
    End If
End Sub

Private Sub txt_Result_MouseDown(Button As Integer, Shift As Integer, X As Single, Y As Single)


'오른쪽 마우스버튼이 클릭되었으면
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
Private Sub 메모장_Click()
'MDIMemo.Show
 frm_Memo.Show
' Call mnuFileOpen_Click
End Sub
'======================================================================================
' 만세력(萬歲曆) 버튼이 눌러졌을때
'======================================================================================
Private Sub 만세력_Click()
  frm_Calendar.Show , US_main 'Owner 모드로 불러옴.
End Sub '메뉴:-달력 보기
'종료 button
Private Sub b_Exit_Click()
 
 'If MsgBox("종료하시겠습니까?", vbYesNo + vbQuestion + vbDefaultButton2, "프로그램 종료확인") = 6 Then
 '   Call gp_Save_Main
 '   'End는 (프로그램 중단 터미네이터)이기에 윈도우 종료함수인 Unload Me를 사용한다.
    Unload Me
 'End If
    
End Sub

Private Sub Form_Unload(Cancel As Integer)  '종료시 마지막 이벤트 처리..
 If MsgBox("종료하시겠습니까?", 4 + 32, "프로그램 종료확인") = 7 Then
      Cancel = -1  ' 폼이 종료되어지지 않도록 하는 방법!
 End If
 FormCoords Me, "SET"       '//폼위치값 레지스트리에 저장하기
End Sub

'======================================================================================
' 바이오 리듬 함수
'======================================================================================
Private Sub Bio(u As Integer) '바이오 리듬 계산
'--------------------------------------------------(바이오 리듬 구하기)
 Dim TotalDay As Integer '총 살아온 날을 저장
 Dim BioRythm(0 To 3) As Integer '바이오리듬을 저장
 Dim Mon(0 To 11) As Integer '달이 지남에 따라 중첩되는 날짜
 Dim YunYears As Integer '윤년의 계산

 Const Pis = 3.141592 '파이값
 Const 신체지수 = 23
 Const 감성지수 = 28
 Const 지성지수 = 33
 Const 지각지수 = 38
   
   'Dim u As Integer
   'Total:살아온 날 계산
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
   'YunYear 윤년 계산
   '윤년 계산은 4로 나누어 떨어지면 윤년이되고
   '다시 100으로 나누어 떨어지면 윤년이 안된다.
   '그리고 400으로 나누어 지면 윤년이 된다.
    For u = yy To Year(Date) '입력한 년도에서 현재 년도까지
     If (u Mod 4) = 0 Then '4로 나누어 지면
        '이러면 윤년
         YunYears = YunYears + 1
         If (u Mod 100) = 0 Then '100으로 나누어 지면
              '이러면 윤년 아님
               YunYears = YunYears - 1
               If (u Mod 400) = 0 Then '400으로 나누어 지면
                  '이러면 윤년
                   YunYears = YunYears + 1
               End If
          End If
     End If
    Next u
   '살아온 총 날 수 계산
    TotalDay = (Year(Date) - (yy) - 1) * 365
    TotalDay = TotalDay + (365 - Mon((mm) - 1) - (dd))
    TotalDay = TotalDay + (Mon(Month(Date) - 1) + Day(Date)) + YunYears
    Text6.Text = TotalDay '살아온 날을 텍스트 창에 표시
   '바이오리듬 계산
    BioRythm(0) = Sin((TotalDay / 신체지수) * 2 * Pis) * 100
    BioRythm(1) = Sin((TotalDay / 감성지수) * 2 * Pis) * 100
    BioRythm(2) = Sin((TotalDay / 지성지수) * 2 * Pis) * 100
    BioRythm(3) = Sin((TotalDay / 지각지수) * 2 * Pis) * 100
   'For문을 써서 간단하게 표시
    For u = 0 To 3
        Label8(u) = BioRythm(u)
    Next u
   '설정 초기화
    For u = 0 To 3
        BioRythm(u) = 0
    Next u
    TotalDay = 0
End Sub

'======================================================================================
' 제왕학 계산 함수
'======================================================================================
Private Sub Ksj(u As Integer) '제왕학 계산
'--------------------------------------------------(바이오 리듬 구하기)

' Dim KsjRythm(4 To 7) As Integer '제왕학 리듬을 저장
 Dim Yn, Sn, Fn, Dn, Qn As Integer '수치 계산 변수
 Dim Sm As String
  
    d_In = INSA.Birth1
    d_pD = f_Pre_Div24((d_In))
    d_nD = f_Next_Div24((d_In))
    d_lD = f_Next_Div24((d_nD))
    i_pD = fi_Pre_Div24((d_In))
 'INSA.B1y = i_year
 'INSA.B1d = i_Day
 
 
 If CInt(INSA.B1m) < 3 Then   ' i_Month : 양력 1,2월인 경우
    If i_pD < 5 Then Yn = CInt(INSA.B1y) - 1  ' 입춘절 이전이면
 Else
    Yn = CInt(INSA.B1y)
 End If
 
 
 '제왕학 계산(年)
 If Yn Mod 9 = 0 Then
    Fn = 2
 ElseIf Yn Mod 9 = 1 Then
    Fn = 1
 Else
    Fn = 11 - Yn Mod 9
 End If
 fate(2).Caption = Fn   '숙명수
 
 
    Select Case i_pD
        
        Case 1, 2                   'MsgBox "2. 大寒: 1월 20일"
            'MsgBox "1. 小寒: 1월 6일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 6
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 9
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 3
             End If
        Case 3, 4                   'MsgBox "4. 雨水: 2월 19일"
            'MsgBox "3. 立春: 2월 4일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 8
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 2
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 5
             End If
        Case 5, 6                   'MsgBox "6. 春分: 3월 21일"
            'MsgBox "5. 驚蟄: 3월 6일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 7
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 1
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 4
             End If
        Case 7, 8                   'MsgBox "8. 穀雨: 4월 20일"
            'MsgBox "7. 淸明: 4월 5일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 6
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 9
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 3
             End If
        Case 9, 10                  'MsgBox "10.小瀟: 5월 21일"
            'MsgBox "9. 立夏: 5월 6일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 5
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 8
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 2
             End If
        Case 11, 12                 'MsgBox "12.夏至: 6월 22일"
            'MsgBox "11.芒種: 6월 6일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 4
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 7
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 1
             End If
        Case 13, 14                 'MsgBox "14.大署: 7월 23일"
            'MsgBox "13.所暑: 7월 7일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 3
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 6
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 9
             End If
        Case 15, 16                 'MsgBox "16.處署: 8월 23일"
            'MsgBox "15.立秋: 8월 8일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 2
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 5
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 8
             End If
        Case 17, 18                 'MsgBox "18.秋分: 9월 23일"
            'MsgBox "17.白露: 9월 8일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 1
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 4
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 7
             End If
        Case 19, 20                 'MsgBox "20.霜降:10월 24일"
            'MsgBox "19.寒露:10월 9일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 9
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 3
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 6
             End If
        Case 21, 22                 'MsgBox "22.小雪:11월 23일"
            'MsgBox "21.立冬:11월 8일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 8
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 2
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 5
             End If
        Case 23, 24                 'MsgBox "24.冬至:12월 22일"
            'MsgBox "23.大雪:12월 7일"
             If Fn = 1 Or Fn = 4 Or Fn = 7 Then
                Dn = 7
             ElseIf Fn = 2 Or Fn = 5 Or Fn = 8 Then
                Dn = 1
             ElseIf Fn = 3 Or Fn = 6 Or Fn = 9 Then
                Dn = 4
             End If
    End Select
  
  destiny(2).Caption = Dn   '운명수
  
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
     
  quality(2).Caption = Qn   '특성수
  
   'For문을 써서 간단하게 표시
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
            Sm = "독립"
        ElseIf Sn = 2 Then
            Sm = "인내"
        ElseIf Sn = 3 Then
            Sm = "발상"
        ElseIf Sn = 4 Then
            Sm = "사교"
        ElseIf Sn = 5 Then
            Sm = "욕망"
        ElseIf Sn = 6 Then
            Sm = "철칙"
        ElseIf Sn = 7 Then
            Sm = "사념"
        ElseIf Sn = 8 Then
            Sm = "이론"
        ElseIf Sn = 9 Then
            Sm = "고집"
        Else
            Sm = "※"
        End If
        summary(u) = Sm
    Next u
 
 
 
 
 
 
 
 
   '설정 초기화
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
    If KeyAscii = 13 Then '엔터키가 발생하면 체크
    
        If Len(Text3.Text) < 3 Then '글자가 3자보다 작으면
            
            Case_Select (Text2.Text) '정확한 일수인지 체크
        
        Else '아니라면
            
            MsgBox_call (1)
            Text3.Text = ""
            Text3.SetFocus
                
        End If
    
        Call Command1_Click
        
    End If
    
    Exit Sub
    
Err:
    If Len(Text2.Text) = 0 Then '텍스트창에 글이 없으면
        
        MsgBox_call (2) '메세지 2번
    
    End If

End Sub

Private Sub MsgBox_call(i As Integer)

    '자주쓰는 메세지 박스를 따로 분리해 놨다.
    
    Select Case i
        
        Case 1
            MsgBox "잘못된 입력입니다."
        
        Case 2
            MsgBox "값을 넣어주세요"
    
    End Select

End Sub


Private Sub Case_Select(i As Integer)

   '매 달마다 조금씩 날짜가 틀리다. 그것을 조회
    
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

