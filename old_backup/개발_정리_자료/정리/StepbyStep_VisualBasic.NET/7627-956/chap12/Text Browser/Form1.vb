
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
    Friend WithEvents mnuExitItem As System.Windows.Forms.MenuItem
    Friend WithEvents OpenFileDialog1 As System.Windows.Forms.OpenFileDialog
    Friend WithEvents mnuOpenItem As System.Windows.Forms.MenuItem
    Friend WithEvents mnuCloseItem As System.Windows.Forms.MenuItem
    Friend WithEvents lblNote As System.Windows.Forms.Label

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.txtNote = New System.Windows.Forms.TextBox()
        Me.mnuOpenItem = New System.Windows.Forms.MenuItem()
        Me.MainMenu1 = New System.Windows.Forms.MainMenu()
        Me.MenuItem1 = New System.Windows.Forms.MenuItem()
        Me.mnuCloseItem = New System.Windows.Forms.MenuItem()
        Me.mnuExitItem = New System.Windows.Forms.MenuItem()
        Me.OpenFileDialog1 = New System.Windows.Forms.OpenFileDialog()
        Me.lblNote = New System.Windows.Forms.Label()
        Me.SuspendLayout()
        '
        'txtNote
        '
        Me.txtNote.Enabled = False
        Me.txtNote.Location = New System.Drawing.Point(16, 48)
        Me.txtNote.Multiline = True
        Me.txtNote.Name = "txtNote"
        Me.txtNote.ScrollBars = System.Windows.Forms.ScrollBars.Both
        Me.txtNote.Size = New System.Drawing.Size(360, 184)
        Me.txtNote.TabIndex = 1
        Me.txtNote.Text = ""
        '
        'mnuOpenItem
        '
        Me.mnuOpenItem.Index = 0
        Me.mnuOpenItem.Text = "Open..."
        '
        'MainMenu1
        '
        Me.MainMenu1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.MenuItem1})
        '
        'MenuItem1
        '
        Me.MenuItem1.Index = 0
        Me.MenuItem1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.mnuOpenItem, Me.mnuCloseItem, Me.mnuExitItem})
        Me.MenuItem1.Text = "File"
        '
        'mnuCloseItem
        '
        Me.mnuCloseItem.Enabled = False
        Me.mnuCloseItem.Index = 1
        Me.mnuCloseItem.Text = "Close"
        '
        'mnuExitItem
        '
        Me.mnuExitItem.Index = 2
        Me.mnuExitItem.Text = "E&xit"
        '
        'lblNote
        '
        Me.lblNote.Location = New System.Drawing.Point(16, 8)
        Me.lblNote.Name = "lblNote"
        Me.lblNote.Size = New System.Drawing.Size(360, 24)
        Me.lblNote.TabIndex = 0
        Me.lblNote.Text = "Load a text file with the Open command."
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(392, 277)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.txtNote, Me.lblNote})
        Me.Menu = Me.MainMenu1
        Me.Name = "Form1"
        Me.Text = "Text Browser"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub mnuExitItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuExitItem.Click
        End
    End Sub

    Private Sub mnuOpenItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuOpenItem.Click
        Dim AllText, LineOfText As String
        OpenFileDialog1.Filter = "Text files (*.TXT)|*.TXT"
        OpenFileDialog1.ShowDialog() 'display Open dialog box
        If OpenFileDialog1.FileName <> "" Then
            Try 'open file and trap any errors using handler
                FileOpen(1, OpenFileDialog1.FileName, OpenMode.Input)
                Do Until EOF(1) 'read lines from file
                    LineOfText = LineInput(1)
                    'add each line to the AllText variable
                    AllText = AllText & LineOfText & vbCrLf
                Loop
                lblNote.Text = OpenFileDialog1.FileName 'update label
                txtNote.Text = AllText 'display file
                txtNote.Select(1, 0)   'remove text selection
                txtNote.Enabled = True 'allow text cursor
                mnuCloseItem.Enabled = True 'enable Close command
                mnuOpenItem.Enabled = False 'disable Open command
            Catch
                MsgBox("Error opening file.")
            Finally
                FileClose(1) 'close file
            End Try
        End If
    End Sub

    Private Sub mnuCloseItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuCloseItem.Click
        txtNote.Text = ""             'clear text box
        lblNote.Text = "Load a text file with the Open command."
        mnuCloseItem.Enabled = False  'disable Close command
        mnuOpenItem.Enabled = True    'enable Open command
    End Sub
End Class
