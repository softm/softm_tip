Imports System.IO  'for StreamReader class
Public Class HelpInfo
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
    Friend WithEvents TextBox1 As System.Windows.Forms.TextBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Label1 As System.Windows.Forms.Label

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.TextBox1 = New System.Windows.Forms.TextBox()
        Me.SuspendLayout()
        '
        'Label1
        '
        Me.Label1.Location = New System.Drawing.Point(24, 8)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(288, 24)
        Me.Label1.TabIndex = 2
        Me.Label1.Text = "Operating Instructions for Lucky Seven Slot Machine"
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(136, 280)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(80, 24)
        Me.Button1.TabIndex = 1
        Me.Button1.Text = "OK"
        '
        'TextBox1
        '
        Me.TextBox1.Location = New System.Drawing.Point(8, 40)
        Me.TextBox1.Multiline = True
        Me.TextBox1.Name = "TextBox1"
        Me.TextBox1.ScrollBars = System.Windows.Forms.ScrollBars.Vertical
        Me.TextBox1.Size = New System.Drawing.Size(336, 224)
        Me.TextBox1.TabIndex = 0
        Me.TextBox1.Text = ""
        '
        'HelpInfo
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(352, 317)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.Label1, Me.Button1, Me.TextBox1})
        Me.Name = "HelpInfo"
        Me.Text = "Help"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub HelpInfo_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        Dim StreamToDisplay As StreamReader
        StreamToDisplay = New StreamReader("c:\vbnetsbs\chap14\readme.txt")
        TextBox1.Text = StreamToDisplay.ReadToEnd
        StreamToDisplay.Close()
        TextBox1.Select(0, 0)
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        Me.DialogResult = DialogResult.OK
    End Sub
End Class
