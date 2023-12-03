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
        If disposing Then
            If Not (components Is Nothing) Then
                components.Dispose()
            End If
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents TextBox1 As System.Windows.Forms.TextBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.TextBox1 = New System.Windows.Forms.TextBox()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.SuspendLayout()
        '
        'Label1
        '
        Me.Label1.Location = New System.Drawing.Point(16, 16)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(248, 40)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Type some text in this text box object, then click Print Text."
        '
        'TextBox1
        '
        Me.TextBox1.Location = New System.Drawing.Point(16, 64)
        Me.TextBox1.Multiline = True
        Me.TextBox1.Name = "TextBox1"
        Me.TextBox1.ScrollBars = System.Windows.Forms.ScrollBars.Vertical
        Me.TextBox1.Size = New System.Drawing.Size(256, 152)
        Me.TextBox1.TabIndex = 1
        Me.TextBox1.Text = ""
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(104, 232)
        Me.Button1.Name = "Button1"
        Me.Button1.TabIndex = 2
        Me.Button1.Text = "Print Text"
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(292, 273)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.Button1, Me.TextBox1, Me.Label1})
        Me.Name = "Form1"
        Me.Text = "Print Text"
        Me.ResumeLayout(False)

    End Sub

#End Region

    'Sub for printing text
    Private Sub PrintText(ByVal sender As Object, _
      ByVal ev As PrintPageEventArgs)
        'Use DrawString to create text in a Graphics object
        ev.Graphics.DrawString(TextBox1.Text, New Font("Arial", _
          11, FontStyle.Regular), Brushes.Black, 120, 120)
        ' Specify that this is the last page to print
        ev.HasMorePages = False
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        ' Print using an error handler to catch problems
        Try
            ' Declare PrintDoc variable of type PrintDocument
            Dim PrintDoc As New PrintDocument()
            AddHandler PrintDoc.PrintPage, AddressOf Me.PrintText
            PrintDoc.Print()   'print text
        Catch ex As Exception  'catch printing exception
            MessageBox.Show("Sorry--there is a problem printing", _
              ex.ToString())
        End Try
    End Sub
End Class
