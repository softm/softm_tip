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
    Friend WithEvents Button1 As System.Windows.Forms.Button

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.SuspendLayout()
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(32, 24)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(96, 32)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "Display Date"
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(292, 273)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.Button1})
        Me.Name = "Form1"
        Me.Text = "Add Controls"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        'Declare new form and control objects
        Dim form2 As New Form()
        Dim lblDate As New Label()
        Dim btnCancel As New Button()

        'Set label properties
        lblDate.Text = "Current date is: " & DateString
        lblDate.Size = New Size(150, 50)
        lblDate.Location = New Point(80, 50)

        'Set button properties
        btnCancel.Text = "Cancel"
        btnCancel.Location = New Point(110, 100)

        'Set form properties
        form2.Text = "Current Date"
        form2.CancelButton = btnCancel
        form2.StartPosition = FormStartPosition.CenterScreen

        'Add new objects to Controls collection
        form2.Controls.Add(lblDate)
        form2.Controls.Add(btnCancel)

        'Display form as a dialog box
        form2.ShowDialog()
    End Sub
End Class
