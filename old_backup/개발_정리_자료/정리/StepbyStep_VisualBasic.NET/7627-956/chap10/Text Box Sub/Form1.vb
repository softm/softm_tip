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
    Friend WithEvents txtSales As System.Windows.Forms.TextBox
    Friend WithEvents txtMkt As System.Windows.Forms.TextBox
    Friend WithEvents lblSales As System.Windows.Forms.Label
    Friend WithEvents lblMkt As System.Windows.Forms.Label
    Friend WithEvents btnSales As System.Windows.Forms.Button
    Friend WithEvents btnMkt As System.Windows.Forms.Button
    Friend WithEvents btnQuit As System.Windows.Forms.Button

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.txtMkt = New System.Windows.Forms.TextBox()
        Me.btnQuit = New System.Windows.Forms.Button()
        Me.txtSales = New System.Windows.Forms.TextBox()
        Me.lblSales = New System.Windows.Forms.Label()
        Me.lblMkt = New System.Windows.Forms.Label()
        Me.btnMkt = New System.Windows.Forms.Button()
        Me.btnSales = New System.Windows.Forms.Button()
        Me.SuspendLayout()
        '
        'txtMkt
        '
        Me.txtMkt.Location = New System.Drawing.Point(176, 48)
        Me.txtMkt.Multiline = True
        Me.txtMkt.Name = "txtMkt"
        Me.txtMkt.ReadOnly = True
        Me.txtMkt.ScrollBars = System.Windows.Forms.ScrollBars.Vertical
        Me.txtMkt.Size = New System.Drawing.Size(144, 72)
        Me.txtMkt.TabIndex = 1
        Me.txtMkt.TabStop = False
        Me.txtMkt.Text = ""
        '
        'btnQuit
        '
        Me.btnQuit.Location = New System.Drawing.Point(240, 184)
        Me.btnQuit.Name = "btnQuit"
        Me.btnQuit.TabIndex = 6
        Me.btnQuit.Text = "Quit"
        '
        'txtSales
        '
        Me.txtSales.Location = New System.Drawing.Point(16, 48)
        Me.txtSales.Multiline = True
        Me.txtSales.Name = "txtSales"
        Me.txtSales.ReadOnly = True
        Me.txtSales.ScrollBars = System.Windows.Forms.ScrollBars.Vertical
        Me.txtSales.Size = New System.Drawing.Size(144, 72)
        Me.txtSales.TabIndex = 0
        Me.txtSales.TabStop = False
        Me.txtSales.Text = ""
        '
        'lblSales
        '
        Me.lblSales.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblSales.Location = New System.Drawing.Point(16, 24)
        Me.lblSales.Name = "lblSales"
        Me.lblSales.TabIndex = 2
        Me.lblSales.Text = "Sales"
        '
        'lblMkt
        '
        Me.lblMkt.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.lblMkt.Location = New System.Drawing.Point(176, 24)
        Me.lblMkt.Name = "lblMkt"
        Me.lblMkt.TabIndex = 3
        Me.lblMkt.Text = "Marketing"
        '
        'btnMkt
        '
        Me.btnMkt.Location = New System.Drawing.Point(208, 136)
        Me.btnMkt.Name = "btnMkt"
        Me.btnMkt.TabIndex = 5
        Me.btnMkt.Text = "Add Name"
        '
        'btnSales
        '
        Me.btnSales.Location = New System.Drawing.Point(48, 136)
        Me.btnSales.Name = "btnSales"
        Me.btnSales.TabIndex = 4
        Me.btnSales.Text = "Add Name"
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(336, 221)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.btnQuit, Me.btnMkt, Me.btnSales, Me.lblMkt, Me.lblSales, Me.txtMkt, Me.txtSales})
        Me.Name = "Form1"
        Me.Text = "Assign Department Teams"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub btnSales_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSales.Click
        Dim SalesPosition As String
        AddName("Sales", SalesPosition)
        txtSales.Text = txtSales.Text & SalesPosition
    End Sub

    Private Sub btnMkt_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnMkt.Click
        Dim MktPosition As String
        AddName("Marketing", MktPosition)
        txtMkt.Text = txtMkt.Text & MktPosition
    End Sub

    Private Sub btnQuit_Click(ByVal sender As Object, ByVal e As System.EventArgs) Handles btnQuit.Click
        End
    End Sub
End Class
