Public Class Form1
    Inherits System.Windows.Forms.Form

#Region " Windows Form Designer generated code "

    Public Sub New()
        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()

        'Add any initialization after the InitializeComponent() call

    End Sub

    'Form overrides dispose to clean up the component list.
    Protected Overloads Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing Then
            If Not (components Is Nothing) Then
                components.Dispose()
            End If
        End If
        MyBase.Dispose(disposing)
    End Sub
    Friend WithEvents MainMenu1 As System.Windows.Forms.MainMenu
    Friend WithEvents MenuItem1 As System.Windows.Forms.MenuItem
        Friend WithEvents txtNote As System.Windows.Forms.TextBox
    Friend WithEvents mnuSaveAsItem As System.Windows.Forms.MenuItem
    Friend WithEvents mnuInsertDateItem As System.Windows.Forms.MenuItem
    Friend WithEvents mnuExitItem As System.Windows.Forms.MenuItem
    Friend WithEvents SaveFileDialog1 As System.Windows.Forms.SaveFileDialog
    Friend WithEvents lblNote As System.Windows.Forms.Label

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.MainMenu1 = New System.Windows.Forms.MainMenu()
        Me.MenuItem1 = New System.Windows.Forms.MenuItem()
        Me.mnuSaveAsItem = New System.Windows.Forms.MenuItem()
        Me.mnuInsertDateItem = New System.Windows.Forms.MenuItem()
        Me.mnuExitItem = New System.Windows.Forms.MenuItem()
        Me.txtNote = New System.Windows.Forms.TextBox()
        Me.lblNote = New System.Windows.Forms.Label()
        Me.SaveFileDialog1 = New System.Windows.Forms.SaveFileDialog()
        Me.SuspendLayout()
        '
        'MainMenu1
        '
        Me.MainMenu1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.MenuItem1})
        '
        'MenuItem1
        '
        Me.MenuItem1.Index = 0
        Me.MenuItem1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.mnuSaveAsItem, Me.mnuInsertDateItem, Me.mnuExitItem})
        Me.MenuItem1.Text = "File"
        '
        'mnuSaveAsItem
        '
        Me.mnuSaveAsItem.Index = 0
        Me.mnuSaveAsItem.Text = "Save &As..."
        '
        'mnuInsertDateItem
        '
        Me.mnuInsertDateItem.Index = 1
        Me.mnuInsertDateItem.Text = "&Insert Date"
        '
        'mnuExitItem
        '
        Me.mnuExitItem.Index = 2
        Me.mnuExitItem.Text = "E&xit"
        '
        'txtNote
        '
        Me.txtNote.Location = New System.Drawing.Point(16, 48)
        Me.txtNote.Multiline = True
        Me.txtNote.Name = "txtNote"
        Me.txtNote.ScrollBars = System.Windows.Forms.ScrollBars.Both
        Me.txtNote.Size = New System.Drawing.Size(360, 184)
        Me.txtNote.TabIndex = 1
        Me.txtNote.Text = ""
        '
        'lblNote
        '
        Me.lblNote.Location = New System.Drawing.Point(16, 8)
        Me.lblNote.Name = "lblNote"
        Me.lblNote.Size = New System.Drawing.Size(240, 24)
        Me.lblNote.TabIndex = 0
        Me.lblNote.Text = "Type your note and then save it to disk."
        '
        'SaveFileDialog1
        '
        Me.SaveFileDialog1.FileName = "doc1"
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(392, 277)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.txtNote, Me.lblNote})
        Me.Menu = Me.MainMenu1
        Me.Name = "Form1"
        Me.Text = "Quick Note"
        Me.ResumeLayout(False)

    End Sub

#End Region


    Private Sub mnuSaveAsItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuSaveAsItem.Click
        SaveFileDialog1.Filter = "Text files (*.txt)|*.txt"
        SaveFileDialog1.ShowDialog()
        If SaveFileDialog1.FileName <> "" Then
            FileOpen(1, SaveFileDialog1.FileName, OpenMode.Output)
            PrintLine(1, txtNote.Text)  'copy text to disk
            FileClose(1)
        End If
    End Sub

    Private Sub mnuInsertDateItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuInsertDateItem.Click
        txtNote.Text = DateString & vbCrLf & txtNote.Text
        txtNote.Select(1, 0)  'remove selection
    End Sub

    Private Sub mnuExitItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuExitItem.Click
        End
    End Sub
End Class
