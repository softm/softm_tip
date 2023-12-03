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
    Friend WithEvents MenuItem2 As System.Windows.Forms.MenuItem
    Friend WithEvents MenuItem3 As System.Windows.Forms.MenuItem
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents OpenFileDialog1 As System.Windows.Forms.OpenFileDialog
    Friend WithEvents mnuFile As System.Windows.Forms.MenuItem
    Friend WithEvents mnuOpenItem As System.Windows.Forms.MenuItem
    Friend WithEvents mnuCloseItem As System.Windows.Forms.MenuItem
    Friend WithEvents mnuExitItem As System.Windows.Forms.MenuItem
    Friend WithEvents PictureBox1 As System.Windows.Forms.PictureBox
    Friend WithEvents ColorDialog1 As System.Windows.Forms.ColorDialog
    Friend WithEvents mnuTextColorItem As System.Windows.Forms.MenuItem
    Private components As System.ComponentModel.IContainer

    'Required by the Windows Form Designer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container()
        Me.mnuExitItem = New System.Windows.Forms.MenuItem()
        Me.OpenFileDialog1 = New System.Windows.Forms.OpenFileDialog()
        Me.mnuFile = New System.Windows.Forms.MenuItem()
        Me.mnuOpenItem = New System.Windows.Forms.MenuItem()
        Me.mnuCloseItem = New System.Windows.Forms.MenuItem()
        Me.PictureBox1 = New System.Windows.Forms.PictureBox()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.MainMenu1 = New System.Windows.Forms.MainMenu(Me.components)
        Me.MenuItem1 = New System.Windows.Forms.MenuItem()
        Me.MenuItem3 = New System.Windows.Forms.MenuItem()
        Me.MenuItem2 = New System.Windows.Forms.MenuItem()
        Me.mnuTextColorItem = New System.Windows.Forms.MenuItem()
        Me.ColorDialog1 = New System.Windows.Forms.ColorDialog()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'mnuExitItem
        '
        Me.mnuExitItem.Index = 2
        Me.mnuExitItem.Text = "E&xit"
        '
        'mnuFile
        '
        Me.mnuFile.Index = 0
        Me.mnuFile.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.mnuOpenItem, Me.mnuCloseItem, Me.mnuExitItem})
        Me.mnuFile.Text = "&File"
        '
        'mnuOpenItem
        '
        Me.mnuOpenItem.Checked = True
        Me.mnuOpenItem.Index = 0
        Me.mnuOpenItem.Text = "&Open..."
        '
        'mnuCloseItem
        '
        Me.mnuCloseItem.Enabled = False
        Me.mnuCloseItem.Index = 1
        Me.mnuCloseItem.Text = "&Close"
        '
        'PictureBox1
        '
        Me.PictureBox1.Location = New System.Drawing.Point(86, 138)
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.Size = New System.Drawing.Size(173, 138)
        Me.PictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.PictureBox1.TabIndex = 1
        Me.PictureBox1.TabStop = False
        '
        'Label1
        '
        Me.Label1.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle
        Me.Label1.Font = New System.Drawing.Font("Microsoft Sans Serif", 14.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(86, 69)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(173, 52)
        Me.Label1.TabIndex = 0
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'MainMenu1
        '
        Me.MainMenu1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.mnuFile, Me.MenuItem1})
        '
        'MenuItem1
        '
        Me.MenuItem1.Index = 1
        Me.MenuItem1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.MenuItem3, Me.MenuItem2, Me.mnuTextColorItem})
        Me.MenuItem1.Text = "&Clock"
        '
        'MenuItem3
        '
        Me.MenuItem3.Index = 0
        Me.MenuItem3.Shortcut = System.Windows.Forms.Shortcut.CtrlT
        Me.MenuItem3.Text = "&Time"
        '
        'MenuItem2
        '
        Me.MenuItem2.Index = 1
        Me.MenuItem2.Shortcut = System.Windows.Forms.Shortcut.CtrlD
        Me.MenuItem2.Text = "&Date"
        '
        'mnuTextColorItem
        '
        Me.mnuTextColorItem.Index = 2
        Me.mnuTextColorItem.Text = "Text Co&lor..."
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(6, 14)
        Me.ClientSize = New System.Drawing.Size(292, 273)
        Me.Controls.Add(Me.PictureBox1)
        Me.Controls.Add(Me.Label1)
        Me.Menu = Me.MainMenu1
        Me.Name = "Form1"
        Me.Text = "Form1"
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub MenuItem3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MenuItem3.Click
        Label1.Text = TimeString
    End Sub

    Private Sub MenuItem2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MenuItem2.Click
        Label1.Text = DateString
    End Sub

    Private Sub mnuOpenItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuOpenItem.Click
        OpenFileDialog1.Filter = "Bitmaps (*.bmp)|*.bmp"
        If OpenFileDialog1.ShowDialog() = DialogResult.OK Then
            PictureBox1.Image = System.Drawing.Image.FromFile _
              (OpenFileDialog1.FileName)
            mnuCloseItem.Enabled = True
        End If
    End Sub

    Private Sub mnuExitItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuExitItem.Click
        End
    End Sub

    Private Sub mnuCloseItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuCloseItem.Click
        PictureBox1.Image = Nothing
        mnuCloseItem.Enabled = False
    End Sub

    Private Sub MenuItem4_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuTextColorItem.Click
        ColorDialog1.ShowDialog()
        Label1.ForeColor = ColorDialog1.Color
    End Sub

End Class
