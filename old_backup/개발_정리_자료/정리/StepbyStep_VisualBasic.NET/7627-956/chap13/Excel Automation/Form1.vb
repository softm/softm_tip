Imports System.Math
Imports Microsoft.Office.Interop

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
    Friend WithEvents btnCalculate As System.Windows.Forms.Button
    Friend WithEvents txtInterest As System.Windows.Forms.TextBox
    Friend WithEvents txtMonths As System.Windows.Forms.TextBox
    Friend WithEvents txtPrincipal As System.Windows.Forms.TextBox
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Label4 As System.Windows.Forms.Label

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.txtMonths = New System.Windows.Forms.TextBox()
        Me.Label4 = New System.Windows.Forms.Label()
        Me.btnCalculate = New System.Windows.Forms.Button()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.Label3 = New System.Windows.Forms.Label()
        Me.txtInterest = New System.Windows.Forms.TextBox()
        Me.txtPrincipal = New System.Windows.Forms.TextBox()
        Me.SuspendLayout()
        '
        'txtMonths
        '
        Me.txtMonths.Location = New System.Drawing.Point(112, 88)
        Me.txtMonths.Name = "txtMonths"
        Me.txtMonths.Size = New System.Drawing.Size(128, 20)
        Me.txtMonths.TabIndex = 2
        Me.txtMonths.Text = ""
        '
        'Label4
        '
        Me.Label4.Location = New System.Drawing.Point(56, 128)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(56, 24)
        Me.Label4.TabIndex = 6
        Me.Label4.Text = "Principal"
        '
        'btnCalculate
        '
        Me.btnCalculate.Location = New System.Drawing.Point(96, 184)
        Me.btnCalculate.Name = "btnCalculate"
        Me.btnCalculate.Size = New System.Drawing.Size(88, 32)
        Me.btnCalculate.TabIndex = 0
        Me.btnCalculate.Text = "Calculate"
        '
        'Label1
        '
        Me.Label1.Font = New System.Drawing.Font("Microsoft Sans Serif", 11.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(8, 8)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(264, 24)
        Me.Label1.TabIndex = 7
        Me.Label1.Text = "Calculate Payments Using Excel"
        Me.Label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        '
        'Label2
        '
        Me.Label2.Location = New System.Drawing.Point(56, 48)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(48, 16)
        Me.Label2.TabIndex = 4
        Me.Label2.Text = "Interest"
        '
        'Label3
        '
        Me.Label3.Location = New System.Drawing.Point(56, 88)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(48, 16)
        Me.Label3.TabIndex = 5
        Me.Label3.Text = "Months"
        '
        'txtInterest
        '
        Me.txtInterest.Location = New System.Drawing.Point(112, 48)
        Me.txtInterest.Name = "txtInterest"
        Me.txtInterest.Size = New System.Drawing.Size(128, 20)
        Me.txtInterest.TabIndex = 1
        Me.txtInterest.Text = ""
        '
        'txtPrincipal
        '
        Me.txtPrincipal.Location = New System.Drawing.Point(112, 128)
        Me.txtPrincipal.Name = "txtPrincipal"
        Me.txtPrincipal.Size = New System.Drawing.Size(128, 20)
        Me.txtPrincipal.TabIndex = 3
        Me.txtPrincipal.Text = ""
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(292, 245)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.Label1, Me.Label4, Me.Label3, Me.Label2, Me.txtPrincipal, Me.txtMonths, Me.txtInterest, Me.btnCalculate})
        Me.Name = "Form1"
        Me.Text = "Mortgage"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub btnCalculate_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnCalculate.Click
        Dim xlApp As Excel.Application
        Dim LoanPayment As Single
        xlApp = CType(CreateObject("Excel.Application"), Excel.Application)
        LoanPayment = xlApp.WorksheetFunction.Pmt _
          (txtInterest.Text / 12, txtMonths.Text, txtPrincipal.Text)
        MsgBox("The monthly payment is " & _
          Format(Abs(LoanPayment), "$#.##"), , "Mortgage")
        xlApp.Quit()
    End Sub
End Class
