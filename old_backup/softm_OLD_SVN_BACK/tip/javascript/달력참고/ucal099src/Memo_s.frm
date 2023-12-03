VERSION 5.00
Object = "{F9043C88-F6F2-101A-A3C9-08002B2F49FB}#1.2#0"; "COMDLG32.OCX"
Begin VB.MDIForm MDIMemo 
   BackColor       =   &H8000000C&
   Caption         =   "���������"
   ClientHeight    =   6975
   ClientLeft      =   165
   ClientTop       =   735
   ClientWidth     =   7740
   Icon            =   "Memo_s.frx":0000
   LinkTopic       =   "MDIForm1"
   StartUpPosition =   3  'Windows �⺻��
   Begin MSComDlg.CommonDialog CMD 
      Left            =   3960
      Top             =   2640
      _ExtentX        =   847
      _ExtentY        =   847
      _Version        =   393216
      DialogTitle     =   "���Ͽ���"
      Filter          =   "�ؽ�Ʈ ����|*.txt"
   End
   Begin VB.Menu mnuFile 
      Caption         =   "����"
      WindowList      =   -1  'True
      Begin VB.Menu mnuFileNew 
         Caption         =   "������"
         Shortcut        =   ^N
      End
      Begin VB.Menu mnuFileOpen 
         Caption         =   "����"
         Shortcut        =   ^O
      End
      Begin VB.Menu mnuFileSave 
         Caption         =   "����"
         Shortcut        =   ^S
      End
      Begin VB.Menu mnuSep 
         Caption         =   "-"
      End
      Begin VB.Menu mnuEnd 
         Caption         =   "����"
         Shortcut        =   ^X
      End
   End
   Begin VB.Menu mnuEdit 
      Caption         =   "����"
      Begin VB.Menu mnuEditCut 
         Caption         =   "�߶󳻱�"
         Shortcut        =   {DEL}
      End
      Begin VB.Menu mnuEditCopy 
         Caption         =   "����"
         Shortcut        =   ^C
      End
      Begin VB.Menu mnuEditAdd 
         Caption         =   "�ٿ��ֱ�"
         Shortcut        =   ^V
      End
      Begin VB.Menu mnuEditDelete 
         Caption         =   "����"
         Shortcut        =   ^D
      End
   End
   Begin VB.Menu mnuForm 
      Caption         =   "�۲�"
      Begin VB.Menu mnuFormFont 
         Caption         =   "��Ʈ"
      End
      Begin VB.Menu mnuFormCColor 
         Caption         =   "���ڻ�"
      End
      Begin VB.Menu mnuFormBColor 
         Caption         =   "����"
      End
   End
End
Attribute VB_Name = "MDIMemo"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Option Explicit

Dim i As Integer '�� �������� �ĺ��� ���� Caption�� ���ڸ� �Է��ϱ����� �����Դϴ�
Dim cuttext As String '���ڿ��� �Ҵ��ϱ����� �����Դϴ�.


Private Sub mnuEditAdd_Click() '�ٿ��ֱ� �̺�Ʈ

    ActiveForm.txtMemo.SelText = cuttext '������ ����� ���ڿ��� txtMemo�� ����Ѵ�.
    
End Sub

Private Sub mnuEditCopy_Click() '�����ϱ� �̺�Ʈ

    cuttext = ActiveForm.txtMemo.SelText '������ ���ڿ��� ������ �����Ѵ�.
    
End Sub

Private Sub mnuEditCut_Click() '�߶󳻱� �̺�Ʈ
    
    cuttext = ActiveForm.txtMemo.SelText '���õ� ���ڿ��� cuttext ��Ʈ�� ������ �Ҵ��Ѵ�.
    ActiveForm.txtMemo.SelText = "" '���ڿ��� �����.
    
End Sub

Private Sub mnuEditDelete_Click()

    ActiveForm.txtMemo.SelText = "" '���ڿ��� �����.
    
End Sub


Private Sub mnuFormBColor_Click() '���� ���� �̺�Ʈ

    CMD.DialogTitle = "���� ����" 'Ÿ��Ʋ����
    CMD.ShowColor '����ȭ���ڸ� ����.
    CMD.CancelError = True
    
    ActiveForm.txtMemo.BackColor = CMD.Color '������ ���� �������� �ٲ۴�.
    
End Sub

Private Sub mnuFormCColor_Click()

    CMD.DialogTitle = "���ڻ� ����" 'Ÿ��Ʋ����
    CMD.ShowColor '����ȭ���ڸ� ����.
    
    ActiveForm.txtMemo.ForeColor = CMD.Color '������ ���� ���ڻ����� �ٲ۴�.
    
End Sub

Private Sub mnuFormFont_Click()

    CMD.DialogTitle = "��Ʈ ����" 'Ÿ��Ʋ����
    CMD.FontName = "" '��Ʈ �ʱⰪ�� �����Ѵ�.
    CMD.Flags = cdlCFBoth 'ȭ���� �����Ϳ� �۲��� ��� ǥ��
    CMD.ShowFont '��Ʈ ��ȭ���ڸ� ����.
    
    If CMD.FontName <> "" Then '��Ʈ�� �����ߴٸ�
        With ActiveForm.txtMemo '��ȭ���ڿ����� ���û����� �ؽ�Ʈ�ڽ��� �����Ѵ�.
            .FontName = CMD.FontName
            .FontSize = CMD.FontSize
            .FontBold = CMD.FontBold
            .FontItalic = CMD.FontItalic
            .FontStrikethru = CMD.FontStrikethru
            .FontUnderline = CMD.FontUnderline
        End With
    Else
        MsgBox "��Ʈ�� ���õ��� �ʾҽ��ϴ�.", vbOKOnly, "�Ѩ��(������)"
    End If
    
End Sub

Private Sub mnuEnd_Click() '���� �̺�Ʈ

    End '����
    
End Sub

Private Sub mnuFileNew_Click() '������ �̺�Ʈ

    Dim Memo As New frm_Memo 'Ŭ���̺�Ʈ�� ���涧���� �Ȱ��� ���� ȣ���ϱ����� �����Դϴ�.
    
    Memo.Show '�޸����� Display�մϴ�.
    Memo.Caption = i + 1 & "��° �޸���" 'Caption Bar�� 1������ ������ȣ�� �ο��մϴ�.
    i = i + 1 '�׸��� 1�� ������ŵ�ϴ�.
    
End Sub

Private Sub mnuFileOpen_Click() '���� �̺�Ʈ
    
    Dim Memo As New frm_Memo
    Dim f As Integer  'FreeFile()�� ���� ���� ���� ��ȣ �����Դϴ�.
    Dim textline As String '������� ��ġ ��� ������ ���� �ڵ鰪�����Դϴ�.
    
    CMD.DialogTitle = "����" 'Ÿ��Ʋ ����
    CMD.ShowOpen '�����ȭ���ڸ� ����
    
    If Err.Number = cdlCancel Then Exit Sub '��ҹ�ư�̶�� ������ �������´�.
    
    If CMD.FileName <> "" Then '������ �Է�������
        
        f = FreeFile() '���Ϲ�ȣ�� ������ �Ҵ�
                
        Memo.Show '�޸����� Display�մϴ�.
        Memo.Caption = i + 1 & "��° �޸���" 'Caption Bar�� 1������ ������ȣ�� �ο��մϴ�.
        i = i + 1 '�׸��� 1�� ������ŵ�ϴ�.
        
        Open CMD.FileName For Input As f '������ ������ ����
       
        Do Until EOF(1) '������ ���� �ƴҶ�����
            Line Input #f, textline ''������ ���پ� �о�帰��
            Memo.txtMemo.Text = Memo.txtMemo.Text + textline + Chr(13) + Chr(10) '�о�帰 ���� ���پ� ����Ѵ�.
        Loop
        
        Close f
        
    End If
    
End Sub

Private Sub mnuFileSave_Click() '���� �̺�Ʈ
    
    Dim f As Integer 'FreeFile()�� ���� ���� ���� ��ȣ �����Դϴ�.
    
    CMD.DialogTitle = "�����ϱ�" 'Ÿ��Ʋ ����
    CMD.ShowSave '�����ȭ���ڸ� ����
    
    If Err.Number = cdlCancel Then Exit Sub '��ҹ�ư�̶�� ������ �������´�.
    
    If CMD.FileName <> "" Then
        
        f = FreeFile()
        
        Open CMD.FileName For Output As f '������ ������ ����
        
        Print #f, ActiveForm.txtMemo.Text 'Ȱ��ȭ�� ���� ������ ����Ѵ�.
        
        Close f
    
    End If
    
End Sub
