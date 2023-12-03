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
    Friend WithEvents lblTitle As System.Windows.Forms.Label
    Friend WithEvents lblTextBoxLabel As System.Windows.Forms.Label
    Friend WithEvents lstCountryBox As System.Windows.Forms.ListBox
    Friend WithEvents lblCountry As System.Windows.Forms.Label
    Friend WithEvents lblGreeting As System.Windows.Forms.Label
    Friend WithEvents btnGreeting As System.Windows.Forms.Button

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.lblGreeting = New System.Windows.Forms.Label()
        Me.lblTitle = New System.Windows.Forms.Label()
        Me.lblTextBoxLabel = New System.Windows.Forms.Label()
        Me.btnGreeting = New System.Windows.Forms.Button()
        Me.lblCountry = New System.Windows.Forms.Label()
        Me.lstCountryBox = New System.Windows.Forms.ListBox()
        Me.SuspendLayout()
        '
        'lblGreeting
        '
        Me.lblGreeting.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.lblGreeting.ForeColor = System.Drawing.Color.Red
        Me.lblGreeting.Location = New System.Drawing.Point(48, 192)
        Me.lblGreeting.Name = "lblGreeting"
        Me.lblGreeting.Size = New System.Drawing.Size(184, 24)
        Me.lblGreeting.TabIndex = 4
        '
        'lblTitle
        '
        Me.lblTitle.Font = New System.Drawing.Font("Times New Roman", 12!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblTitle.Location = New System.Drawing.Point(24, 16)
        Me.lblTitle.Name = "lblTitle"
        Me.lblTitle.Size = New System.Drawing.Size(248, 32)
        Me.lblTitle.TabIndex = 0
        Me.lblTitle.Text = "International Welcome Program"
        '
        'lblTextBoxLabel
        '
        Me.lblTextBoxLabel.Location = New System.Drawing.Point(48, 56)
        Me.lblTextBoxLabel.Name = "lblTextBoxLabel"
        Me.lblTextBoxLabel.Size = New System.Drawing.Size(128, 16)
        Me.lblTextBoxLabel.TabIndex = 1
        Me.lblTextBoxLabel.Text = "Choose a country"
        '
        'btnGreeting
        '
        Me.btnGreeting.Location = New System.Drawing.Point(104, 232)
        Me.btnGreeting.Name = "btnGreeting"
        Me.btnGreeting.Size = New System.Drawing.Size(80, 24)
        Me.btnGreeting.TabIndex = 5
        Me.btnGreeting.Text = "Quit"
        '
        'lblCountry
        '
        Me.lblCountry.Font = New System.Drawing.Font("Microsoft Sans Serif", 9.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblCountry.Location = New System.Drawing.Point(48, 168)
        Me.lblCountry.Name = "lblCountry"
        Me.lblCountry.Size = New System.Drawing.Size(128, 24)
        Me.lblCountry.TabIndex = 3
        '
        'lstCountryBox
        '
        Me.lstCountryBox.Location = New System.Drawing.Point(48, 72)
        Me.lstCountryBox.Name = "lstCountryBox"
        Me.lstCountryBox.Size = New System.Drawing.Size(128, 69)
        Me.lstCountryBox.TabIndex = 2
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(292, 273)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.btnGreeting, Me.lblGreeting, Me.lblCountry, Me.lstCountryBox, Me.lblTextBoxLabel, Me.lblTitle})
        Me.Name = "Form1"
        Me.Text = "Case Greeting"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        lstCountryBox.Items.Add("England")
        lstCountryBox.Items.Add("Germany")
        lstCountryBox.Items.Add("Mexico")
        lstCountryBox.Items.Add("Italy")
    End Sub

    Private Sub lstCountryBox_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lstCountryBox.SelectedIndexChanged
        lblCountry.Text = lstCountryBox.Text
        Select Case lstCountryBox.SelectedIndex
            Case 0
                lblGreeting.Text = "Hello, programmer"
            Case 1
                lblGreeting.Text = "Hallo, programmierer"
            Case 2
                lblGreeting.Text = "Hola, programador"
            Case 3
                lblGreeting.Text = "Ciao, programmatore"
        End Select
    End Sub

    Private Sub btnGreeting_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnGreeting.Click
        End
    End Sub

    Private Sub lstCountryBox_MouseHover(ByVal sender As Object, ByVal e As System.EventArgs) Handles lstCountryBox.MouseHover
        If lstCountryBox.SelectedIndex < 0 Or _
          lstCountryBox.SelectedIndex > 4 Then
            lblGreeting.Text = "Please click the country name"
        End If
    End Sub
End Class
