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
    Friend WithEvents TextBox1 As System.Windows.Forms.TextBox
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents Button2 As System.Windows.Forms.Button

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.TextBox1 = New System.Windows.Forms.TextBox()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.Button2 = New System.Windows.Forms.Button()
        Me.SuspendLayout()
        '
        'TextBox1
        '
        Me.TextBox1.Location = New System.Drawing.Point(29, 9)
        Me.TextBox1.Multiline = True
        Me.TextBox1.Name = "TextBox1"
        Me.TextBox1.ScrollBars = System.Windows.Forms.ScrollBars.Vertical
        Me.TextBox1.Size = New System.Drawing.Size(288, 198)
        Me.TextBox1.TabIndex = 0
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(48, 224)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(106, 34)
        Me.Button1.TabIndex = 1
        Me.Button1.Text = "Enter Temps"
        '
        'Button2
        '
        Me.Button2.Location = New System.Drawing.Point(192, 224)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(106, 34)
        Me.Button2.TabIndex = 2
        Me.Button2.Text = "Display Temps"
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(6, 14)
        Me.ClientSize = New System.Drawing.Size(376, 261)
        Me.Controls.Add(Me.Button2)
        Me.Controls.Add(Me.Button1)
        Me.Controls.Add(Me.TextBox1)
        Me.Name = "Form1"
        Me.Text = "Fixed Array Temps"
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub

#End Region
    Dim Temperatures() As Single
    Dim Days As Integer

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        Dim Prompt, Title As String
        Dim i As Short
        Prompt = "Enter the day's high temperature."
        Days = InputBox("How many days?", "Create Array")
        If Days > 0 Then ReDim Temperatures(Days - 1)
        For i = 0 To UBound(Temperatures)
            Title = "Day " & (i + 1)
            Temperatures(i) = InputBox(Prompt, Title)
        Next
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        Dim Result As String
        Dim i As Short
        Dim Total As Single = 0
        Result = "High temperatures:" & vbCrLf & vbCrLf
        For i = 0 To UBound(Temperatures)
            Result = Result & "Day " & (i + 1) & vbTab & _
              Temperatures(i) & vbCrLf
            Total = Total + Temperatures(i)
        Next
        Result = Result & vbCrLf & _
          "Average temperature:  " & Format(Total / Days, "0.0")
        TextBox1.Text = Result
    End Sub
End Class
