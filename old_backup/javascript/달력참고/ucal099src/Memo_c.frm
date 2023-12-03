VERSION 5.00
Begin VB.Form frm_Memo 
   AutoRedraw      =   -1  'True
   BorderStyle     =   1  'Fixed Single
   Caption         =   "¸Þ¸ðÀå"
   ClientHeight    =   7005
   ClientLeft      =   45
   ClientTop       =   330
   ClientWidth     =   7425
   LinkTopic       =   "frmMemo"
   MaxButton       =   0   'False
   MDIChild        =   -1  'True
   MinButton       =   0   'False
   NegotiateMenus  =   0   'False
   ScaleHeight     =   7005
   ScaleWidth      =   7425
   WhatsThisHelp   =   -1  'True
   Begin VB.TextBox txtMemo 
      BeginProperty Font 
         Name            =   "±¼¸²"
         Size            =   12
         Charset         =   129
         Weight          =   400
         Underline       =   0   'False
         Italic          =   0   'False
         Strikethrough   =   0   'False
      EndProperty
      Height          =   7000
      Left            =   20
      MultiLine       =   -1  'True
      ScrollBars      =   3  'Both
      TabIndex        =   0
      Top             =   0
      Width           =   7400
   End
End
Attribute VB_Name = "frm_Memo"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Option Explicit

Private Sub Form_Resize()

   'Me.ScaleWidth = 7000
   'Me.ScaleHeight = 6600
    
   'Me.Width = Me.ScaleWidth
   'Me.Height = Me.ScaleHeight
    
End Sub
