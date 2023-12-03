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
    Friend WithEvents ComboBox1 As System.Windows.Forms.ComboBox
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Button1 As System.Windows.Forms.Button
    
    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.ComboBox1 = New System.Windows.Forms.ComboBox()
        Me.SuspendLayout()
        '
        'Label1
        '
        Me.Label1.Location = New System.Drawing.Point(40, 32)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(392, 24)
        Me.Label1.TabIndex = 1
        Me.Label1.Text = "Enter the URL for a valid HTML document and click Display HTML"
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(192, 160)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(112, 32)
        Me.Button1.TabIndex = 2
        Me.Button1.Text = "Display HTML"
        '
        'ComboBox1
        '
        Me.ComboBox1.DropDownWidth = 392
        Me.ComboBox1.Location = New System.Drawing.Point(40, 64)
        Me.ComboBox1.Name = "ComboBox1"
        Me.ComboBox1.Size = New System.Drawing.Size(392, 21)
        Me.ComboBox1.TabIndex = 0
        Me.ComboBox1.Text = "http://www.microsoft.com"
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(480, 245)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.Button1, Me.Label1, Me.ComboBox1})
        Me.Name = "Form1"
        Me.Text = "Show HTML"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Public Explorer As SHDocVw.InternetExplorer

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        Explorer = New SHDocVw.InternetExplorer()
        Explorer.Visible = True
        Explorer.Navigate(ComboBox1.Text)
    End Sub

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        'Add a few useful Web sites to the combo box at startup
        ComboBox1.Items.Add("http://www.microsoft.com")
        ComboBox1.Items.Add("http://www.microsoft.com/mspress")
        ComboBox1.Items.Add("http://msdn.microsoft.com/vbasic")
        ComboBox1.Items.Add("http://www.devx.com")
    End Sub

End Class
