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
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.SuspendLayout()
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(29, 26)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(105, 34)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "Create Form"
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(6, 14)
        Me.ClientSize = New System.Drawing.Size(292, 273)
        Me.Controls.Add(Me.Button1)
        Me.Location = New System.Drawing.Point(200, 50)
        Me.Name = "Form1"
        Me.StartPosition = System.Windows.Forms.FormStartPosition.Manual
        Me.Text = "Form1"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        'Create a second form named form2
        Dim form2 As New Form()

        'Define the Text property and border style of the form
        form2.Text = "My New Form"
        form2.FormBorderStyle = FormBorderStyle.FixedDialog

        'Specify that the position of the form will be set manually
        form2.StartPosition = FormStartPosition.Manual

        'Declare a Rectangle structure to hold the form dimensions
        'Upper left corner of form (200, 100)
        'Width and height of form (300, 250)
        Dim Form2Rect As New Rectangle(200, 100, 300, 250)
        'Dim Form2Rect As New Rectangle

        'Set the bounds of the form using the Rectangle object
        form2.DesktopBounds = Form2Rect
        Dim button1 As New Button()
        button1.Text = "Click Me"
        button1.Location = New Point(20, 25)
        form2.Controls.Add(button1)

        Dim lblDate As New Label()
        Dim btnCancel As New Button()
        lblDate.Text = "Current date is :" & DateString
        lblDate.Size = New Size(150, 50)
        lblDate.Location = New Point(80, 50)

        btnCancel.Text = "Cancel"
        btnCancel.Location = New Point(110, 100)
        'btnCancel.Size = New Size(150, 150)
        form2.Text = "Current Date"
        form2.CancelButton = btnCancel
        form2.StartPosition = FormStartPosition.CenterScreen

        form2.Controls.Add(lblDate)
        form2.Controls.Add(btnCancel)
        'Display the form as a modal dialog box
        form2.ShowDialog()

    End Sub

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load

    End Sub
End Class
