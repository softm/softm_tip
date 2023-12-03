Imports System.Drawing.Printing

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
        If Disposing Then
            If Not (components Is Nothing) Then
                components.Dispose()
            End If
        End If
        MyBase.Dispose(Disposing)
    End Sub
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents TextBox1 As System.Windows.Forms.TextBox
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents PrintDocument1 As System.Drawing.Printing.PrintDocument

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.TextBox1 = New System.Windows.Forms.TextBox()
        Me.PrintDocument1 = New System.Drawing.Printing.PrintDocument()
        Me.SuspendLayout()
        '
        'Label1
        '
        Me.Label1.Location = New System.Drawing.Point(24, 32)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(224, 16)
        Me.Label1.TabIndex = 2
        Me.Label1.Text = "Type the name of a graphic file to print."
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(96, 120)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(88, 23)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "Print Graphic"
        '
        'TextBox1
        '
        Me.TextBox1.Location = New System.Drawing.Point(24, 56)
        Me.TextBox1.Name = "TextBox1"
        Me.TextBox1.Size = New System.Drawing.Size(240, 20)
        Me.TextBox1.TabIndex = 1
        Me.TextBox1.Text = "c:\vbnetsbs\chap16\sun.ico"
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(292, 273)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.Label1, Me.TextBox1, Me.Button1})
        Me.Name = "Form1"
        Me.Text = "Print Graphics"
        Me.ResumeLayout(False)

    End Sub

#End Region

    'Sub for printing graphic
    Private Sub PrintGraphic(ByVal sender As Object, _
      ByVal ev As PrintPageEventArgs)
        ' Create the graphic using DrawImage
        ev.Graphics.DrawImage(Image.FromFile(TextBox1.Text), _
          ev.Graphics.VisibleClipBounds)
        ' Specify that this is the last page to print
        ev.HasMorePages = False
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        ' Print using an error handler to catch problems
        Try
            AddHandler PrintDocument1.PrintPage, AddressOf Me.PrintGraphic
            PrintDocument1.Print()   'print graphic
        Catch ex As Exception  'catch printing exception
            MessageBox.Show("Sorry--there is a problem printing", _
              ex.ToString())
        End Try
    End Sub
End Class
