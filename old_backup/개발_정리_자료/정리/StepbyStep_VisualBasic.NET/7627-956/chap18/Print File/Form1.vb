Imports System.IO  'for FileStream class
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
    Friend WithEvents btnOpen As System.Windows.Forms.Button
    Friend WithEvents btnPrint As System.Windows.Forms.Button
    Friend WithEvents RichTextBox1 As System.Windows.Forms.RichTextBox
    Friend WithEvents OpenFileDialog1 As System.Windows.Forms.OpenFileDialog
    Friend WithEvents PrintDocument1 As System.Drawing.Printing.PrintDocument
    Friend WithEvents PrintDialog1 As System.Windows.Forms.PrintDialog

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.btnOpen = New System.Windows.Forms.Button()
        Me.btnPrint = New System.Windows.Forms.Button()
        Me.RichTextBox1 = New System.Windows.Forms.RichTextBox()
        Me.OpenFileDialog1 = New System.Windows.Forms.OpenFileDialog()
        Me.PrintDocument1 = New System.Drawing.Printing.PrintDocument()
        Me.PrintDialog1 = New System.Windows.Forms.PrintDialog()
        Me.SuspendLayout()
        '
        'btnOpen
        '
        Me.btnOpen.Location = New System.Drawing.Point(24, 16)
        Me.btnOpen.Name = "btnOpen"
        Me.btnOpen.Size = New System.Drawing.Size(88, 24)
        Me.btnOpen.TabIndex = 0
        Me.btnOpen.Text = "Open"
        '
        'btnPrint
        '
        Me.btnPrint.Enabled = False
        Me.btnPrint.Location = New System.Drawing.Point(24, 56)
        Me.btnPrint.Name = "btnPrint"
        Me.btnPrint.Size = New System.Drawing.Size(88, 24)
        Me.btnPrint.TabIndex = 1
        Me.btnPrint.Text = "Print"
        '
        'RichTextBox1
        '
        Me.RichTextBox1.Location = New System.Drawing.Point(8, 104)
        Me.RichTextBox1.Name = "RichTextBox1"
        Me.RichTextBox1.Size = New System.Drawing.Size(312, 160)
        Me.RichTextBox1.TabIndex = 2
        Me.RichTextBox1.Text = ""
        '
        'PrintDocument1
        '
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(328, 269)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.RichTextBox1, Me.btnPrint, Me.btnOpen})
        Me.Name = "Form1"
        Me.Text = "Print File"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private PrintPageSettings As New PageSettings()
    Private StringToPrint As String
    Private PrintFont As New Font("Arial", 10)

    Private Sub btnOpen_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnOpen.Click
        Dim FilePath As String
        'Display Open dialog box and select text file
        OpenFileDialog1.Filter = "Text files (*.txt)|*.txt"
        OpenFileDialog1.ShowDialog()
        'If Cancel button not selected, load FilePath variable
        If OpenFileDialog1.FileName <> "" Then
            FilePath = OpenFileDialog1.FileName
            Try
                'Read text file and load into RichTextBox1
                Dim MyFileStream As New FileStream(FilePath, FileMode.Open)
                RichTextBox1.LoadFile(MyFileStream, _
                  RichTextBoxStreamType.PlainText)
                MyFileStream.Close()
                'Initialize string to print
                StringToPrint = RichTextBox1.Text
                'Enable Print button
                btnPrint.Enabled = True
            Catch ex As Exception
                'display error messages if they appear
                MessageBox.Show(ex.Message)
            End Try
        End If
    End Sub

    Private Sub btnPrint_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnPrint.Click
        Try
            'Specify current page settings
            PrintDocument1.DefaultPageSettings = PrintPageSettings
            'Specify document for print dialog box and show
            StringToPrint = RichTextBox1.Text
            PrintDialog1.Document = PrintDocument1
            Dim result As DialogResult = PrintDialog1.ShowDialog()
            'If click OK, print document to printer
            If result = DialogResult.OK Then
                PrintDocument1.Print()
            End If
        Catch ex As Exception
            'Display error message
            MessageBox.Show(ex.Message)
        End Try
    End Sub

    Private Sub PrintDocument1_PrintPage(ByVal sender As System.Object, ByVal e As System.Drawing.Printing.PrintPageEventArgs) Handles PrintDocument1.PrintPage
        Dim numChars As Integer
        Dim numLines As Integer
        Dim stringForPage As String
        Dim strFormat As New StringFormat()
        'Based on page setup, define drawable rectangle on page
        Dim rectDraw As New RectangleF( _
          e.MarginBounds.Left, e.MarginBounds.Top, _
          e.MarginBounds.Width, e.MarginBounds.Height)
        'Define area to determine how much text can fit on a page
        'Make height one line shorter to ensure text doesn't clip
        Dim sizeMeasure As New SizeF(e.MarginBounds.Width, _
          e.MarginBounds.Height - PrintFont.GetHeight(e.Graphics))

        'When drawing long strings, break between words
        strFormat.Trimming = StringTrimming.Word
        'Compute how many chars and lines can fit based on sizeMeasure
        e.Graphics.MeasureString(StringToPrint, PrintFont, _
          sizeMeasure, strFormat, numChars, numLines)
        'Compute string that will fit on a page
        stringForPage = StringToPrint.Substring(0, numChars)
        'Print string on current page
        e.Graphics.DrawString(stringForPage, PrintFont, _
          Brushes.Black, rectDraw, strFormat)
        'If there is more text, indicate there are more pages
        If numChars < StringToPrint.Length Then
            'Subtract text from string that has been printed
            StringToPrint = StringToPrint.Substring(numChars)
            e.HasMorePages = True
        Else
            e.HasMorePages = False
            'All text has been printed, so restore string
            StringToPrint = RichTextBox1.Text
        End If
    End Sub
End Class
