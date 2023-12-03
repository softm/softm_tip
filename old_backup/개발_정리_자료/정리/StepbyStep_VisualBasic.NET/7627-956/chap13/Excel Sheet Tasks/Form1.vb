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
        Me.Button1.Location = New System.Drawing.Point(96, 69)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(125, 34)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "Create Worksheet"
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(6, 14)
        Me.ClientSize = New System.Drawing.Size(292, 213)
        Me.Controls.Add(Me.Button1)
        Me.Name = "Form1"
        Me.Text = "Excel Worksheet Builder"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        ' Declare Excel object variables and create types
        Dim xlApp As Excel.Application
        Dim xlBook As Excel.Workbook
        Dim xlSheet As Excel.Worksheet
        xlApp = CType(CreateObject("Excel.Application"), Excel.Application)
        xlBook = CType(xlApp.Workbooks.Add, Excel.Workbook)
        xlSheet = CType(xlBook.Worksheets(1), Excel.Worksheet)

        ' Insert data
        xlSheet.Cells(1, 2) = 5000
        xlSheet.Cells(2, 2) = 75
        xlSheet.Cells(3, 1) = "Total"
        ' Insert a Sum formula in cell B3
        xlSheet.Range("B3").Formula = "=Sum(R1C2:R2C2)"
        ' Format cell B3 with bold
        xlSheet.Range("B3").Font.Bold = True
        ' Display the sheet
        xlSheet.Application.Visible = True
        ' Save the sheet to c:\vbnetsbs\chap13 folder
        xlSheet.SaveAs("C:\Users\Administrator\Desktop\StepbyStepVisualBasicdotNET[1]\7627-956\chap13\Excel Sheet Tasks\myexcelsheet.xls")
        ' Leave Excel running and sheet open
    End Sub

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load

    End Sub
End Class
