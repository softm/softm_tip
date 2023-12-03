Imports System.Math

Public Class WebForm1
    Inherits System.Web.UI.Page
    Protected WithEvents txtAmount As System.Web.UI.WebControls.TextBox
    Protected WithEvents txtInterest As System.Web.UI.WebControls.TextBox
    Protected WithEvents txtPayment As System.Web.UI.WebControls.TextBox
    Protected WithEvents lblAmount As System.Web.UI.WebControls.Label
    Protected WithEvents lblInterest As System.Web.UI.WebControls.Label
    Protected WithEvents lblPayment As System.Web.UI.WebControls.Label
    Protected WithEvents HyperLink1 As System.Web.UI.WebControls.HyperLink
    Protected WithEvents btnCalculate As System.Web.UI.WebControls.Button

#Region " Web Form Designer Generated Code "

    'This call is required by the Web Form Designer.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()

    End Sub

    Private Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init
        'CODEGEN: This method call is required by the Web Form Designer
        'Do not modify it using the code editor.
        InitializeComponent()
    End Sub

#End Region

    Private Sub Page_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        'Put user code to initialize the page here
    End Sub

    Private Sub btnCalculate_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnCalculate.Click
        Dim LoanPayment As Single
        'Use Pmt function to determine payment for 36 month loan
        LoanPayment = Pmt(txtInterest.Text / 12, 36, txtAmount.Text)
        txtPayment.Text = Format(Abs(LoanPayment), "$0.00")
    End Sub
End Class
