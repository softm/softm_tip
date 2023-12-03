VERSION 5.00
Begin VB.Form frm_Help_inf 
   Caption         =   "À¯¼ºÀÌ±âÇÐ(¸¸¼¼·Â)Á¤º¸"
   ClientHeight    =   3045
   ClientLeft      =   60
   ClientTop       =   345
   ClientWidth     =   6390
   BeginProperty Font 
      Name            =   "±¼¸²"
      Size            =   9.75
      Charset         =   129
      Weight          =   400
      Underline       =   0   'False
      Italic          =   0   'False
      Strikethrough   =   0   'False
   EndProperty
   Icon            =   "frm_Help_inf.frx":0000
   LinkTopic       =   "Form1"
   ScaleHeight     =   3045
   ScaleWidth      =   6390
   StartUpPosition =   3  'Windows ±âº»°ª
   Begin VB.PictureBox Picture1 
      Height          =   975
      Left            =   840
      Picture         =   "frm_Help_inf.frx":08CA
      ScaleHeight     =   915
      ScaleWidth      =   4635
      TabIndex        =   7
      Top             =   240
      Width           =   4695
   End
   Begin VB.CommandButton Command1 
      Caption         =   "È®  ÀÎ"
      BeginProperty Font 
         Name            =   "±¼¸²Ã¼"
         Size            =   9.75
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   375
      Left            =   4800
      TabIndex        =   0
      Top             =   2520
      Width           =   1215
   End
   Begin VB.Label Label8 
      Caption         =   "- usung73@hitel.net -"
      Height          =   255
      Left            =   3840
      TabIndex        =   6
      Top             =   2040
      Width           =   2055
   End
   Begin VB.Label Label7 
      Caption         =   "³ôÀº °÷¿¡¼­ ³·Àº °÷À¸·Î~~~"
      Height          =   255
      Left            =   120
      TabIndex        =   5
      Top             =   1920
      Width           =   2775
   End
   Begin VB.Label Label4 
      Caption         =   "Ver 0.96 (2000-11-22)"
      Height          =   255
      Left            =   1200
      TabIndex        =   4
      Top             =   1320
      Width           =   3375
   End
   Begin VB.Line Line1 
      X1              =   120
      X2              =   6000
      Y1              =   1800
      Y2              =   1800
   End
   Begin VB.Label Label3 
      Caption         =   "Developed by usung73@hitel.net"
      Height          =   255
      Left            =   2880
      TabIndex        =   3
      Top             =   1560
      Width           =   3135
   End
   Begin VB.Label Label2 
      Caption         =   "Window 98"
      Height          =   255
      Left            =   1200
      TabIndex        =   2
      Top             =   1560
      Width           =   1335
   End
   Begin VB.Label Label1 
      Caption         =   "ë¦àùìµÑ¨ùÊØ¿á¨Õõ"
      BeginProperty Font 
         Name            =   "±¼¸²"
         Size            =   14.25
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   255
      Left            =   600
      TabIndex        =   1
      Top             =   2400
      Width           =   2295
   End
End
Attribute VB_Name = "frm_Help_inf"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Private Sub Command1_Click()
    Unload Me
End Sub
