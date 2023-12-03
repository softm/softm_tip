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
    Friend WithEvents MainMenu1 As System.Windows.Forms.MainMenu
    Friend WithEvents MenuItem1 As System.Windows.Forms.MenuItem
    Friend WithEvents txtNote As System.Windows.Forms.TextBox
    Friend WithEvents mnuSaveAsItem As System.Windows.Forms.MenuItem
    Friend WithEvents mnuInsertDateItem As System.Windows.Forms.MenuItem
    Friend WithEvents mnuExitItem As System.Windows.Forms.MenuItem
    Friend WithEvents SaveFileDialog1 As System.Windows.Forms.SaveFileDialog
    Friend WithEvents lblNote As System.Windows.Forms.Label
    Friend WithEvents mnuOpenItem As System.Windows.Forms.MenuItem
    Friend WithEvents mnuSortTextItem As System.Windows.Forms.MenuItem
    Friend WithEvents OpenFileDialog1 As System.Windows.Forms.OpenFileDialog
    Friend WithEvents mnuCloseItem As System.Windows.Forms.MenuItem

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.txtNote = New System.Windows.Forms.TextBox()
        Me.mnuSaveAsItem = New System.Windows.Forms.MenuItem()
        Me.MainMenu1 = New System.Windows.Forms.MainMenu()
        Me.MenuItem1 = New System.Windows.Forms.MenuItem()
        Me.mnuInsertDateItem = New System.Windows.Forms.MenuItem()
        Me.mnuExitItem = New System.Windows.Forms.MenuItem()
        Me.SaveFileDialog1 = New System.Windows.Forms.SaveFileDialog()
        Me.lblNote = New System.Windows.Forms.Label()
        Me.mnuOpenItem = New System.Windows.Forms.MenuItem()
        Me.mnuSortTextItem = New System.Windows.Forms.MenuItem()
        Me.OpenFileDialog1 = New System.Windows.Forms.OpenFileDialog()
        Me.mnuCloseItem = New System.Windows.Forms.MenuItem()
        Me.SuspendLayout()
        '
        'txtNote
        '
        Me.txtNote.Location = New System.Drawing.Point(16, 48)
        Me.txtNote.Multiline = True
        Me.txtNote.Name = "txtNote"
        Me.txtNote.ScrollBars = System.Windows.Forms.ScrollBars.Both
        Me.txtNote.Size = New System.Drawing.Size(360, 184)
        Me.txtNote.TabIndex = 1
        Me.txtNote.Text = ""
        '
        'mnuSaveAsItem
        '
        Me.mnuSaveAsItem.Index = 2
        Me.mnuSaveAsItem.Text = "Save &As..."
        '
        'MainMenu1
        '
        Me.MainMenu1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.MenuItem1})
        '
        'MenuItem1
        '
        Me.MenuItem1.Index = 0
        Me.MenuItem1.MenuItems.AddRange(New System.Windows.Forms.MenuItem() {Me.mnuOpenItem, Me.mnuCloseItem, Me.mnuSaveAsItem, Me.mnuInsertDateItem, Me.mnuSortTextItem, Me.mnuExitItem})
        Me.MenuItem1.Text = "File"
        '
        'mnuInsertDateItem
        '
        Me.mnuInsertDateItem.Index = 3
        Me.mnuInsertDateItem.Text = "&Insert Date"
        '
        'mnuExitItem
        '
        Me.mnuExitItem.Index = 5
        Me.mnuExitItem.Text = "E&xit"
        '
        'SaveFileDialog1
        '
        Me.SaveFileDialog1.FileName = "doc1"
        '
        'lblNote
        '
        Me.lblNote.Location = New System.Drawing.Point(16, 8)
        Me.lblNote.Name = "lblNote"
        Me.lblNote.Size = New System.Drawing.Size(240, 24)
        Me.lblNote.TabIndex = 0
        Me.lblNote.Text = "Type text or open file for sorting."
        '
        'mnuOpenItem
        '
        Me.mnuOpenItem.Index = 0
        Me.mnuOpenItem.Text = "Open..."
        '
        'mnuSortTextItem
        '
        Me.mnuSortTextItem.Index = 4
        Me.mnuSortTextItem.Text = "Sort Text"
        '
        'mnuCloseItem
        '
        Me.mnuCloseItem.Enabled = False
        Me.mnuCloseItem.Index = 1
        Me.mnuCloseItem.Text = "Close"
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(392, 277)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.txtNote, Me.lblNote})
        Me.Menu = Me.MainMenu1
        Me.Name = "Form1"
        Me.Text = "Sort Text"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub mnuSaveAsItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuSaveAsItem.Click
        SaveFileDialog1.Filter = "Text files (*.txt)|*.txt"
        SaveFileDialog1.ShowDialog()
        If SaveFileDialog1.FileName <> "" Then
            FileOpen(1, SaveFileDialog1.FileName, OpenMode.Output)
            PrintLine(1, txtNote.Text) 'copy text to disk
            FileClose(1)
        End If
    End Sub

    Private Sub mnuInsertDateItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuInsertDateItem.Click
        txtNote.Text = DateString & vbCrLf & txtNote.Text
        txtNote.Select(1, 0)  'remove selection
    End Sub

    Private Sub mnuExitItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuExitItem.Click
        End
    End Sub

    Private Sub mnuOpenItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuOpenItem.Click
        Dim AllText, LineOfText As String
        OpenFileDialog1.Filter = "Text files (*.TXT)|*.TXT"
        OpenFileDialog1.ShowDialog() 'display Open dialog box
        If OpenFileDialog1.FileName <> "" Then
            Try 'open file and trap any errors using handler
                FileOpen(1, OpenFileDialog1.FileName, OpenMode.Input)
                Do Until EOF(1) 'read lines from file
                    LineOfText = LineInput(1)
                    'add each line to the AllText variable
                    AllText = AllText & LineOfText & vbCrLf
                Loop                   'update label
                lblNote.Text = OpenFileDialog1.FileName
                txtNote.Text = AllText 'display file
                txtNote.Select(1, 0)   'remove text selection
                txtNote.Enabled = True 'allow text cursor
                mnuCloseItem.Enabled = True  'enable Close command
                mnuOpenItem.Enabled = False  'disable Open command
            Catch
                MsgBox("Error opening file. It might be too big.")
            Finally
                FileClose(1) 'close file
            End Try
        End If
    End Sub

    Private Sub mnuCloseItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuCloseItem.Click
        txtNote.Text = ""             'clear text box
        lblNote.Text = "Load a text file with the Open command."
        mnuCloseItem.Enabled = False  'disable Close command
        mnuOpenItem.Enabled = True    'enable Open command
    End Sub

    Private Sub mnuSortTextItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles mnuSortTextItem.Click
        Dim ln, curline, letter As String
        Dim i, charsInFile, lineCount As Short

        'determine number of lines in text box object (txtNote)
        lineCount = 0 'this variable holds total number of lines
        charsInFile = txtNote.Text.Length 'get total characters
        For i = 0 To charsInFile - 1 'move one char at a time
            letter = txtNote.Text.Substring(i, 1) 'get letter
            If letter = Chr(13) Then 'if carriage ret found
                lineCount += 1 'go to next line (add to count)
                i += 1 'skip linefeed char (always follows cr)
            End If
        Next i

        'build an array to hold the text in the text box
        ReDim strArray(lineCount) 'create array of proper size
        curline = 1
        ln = "" 'use ln to build lines one character at a time
        For i = 0 To charsInFile - 1 'loop through text again
            letter = txtNote.Text.Substring(i, 1) 'get letter
            If letter = Chr(13) Then 'if carriage return found
                curline = curline + 1 'increment line count
                i += 1 'skip linefeed char
                ln = "" 'clear line and go to next
            Else
                ln = ln & letter 'add letter to line
                strArray(curline) = ln 'and put in array
            End If
        Next i

        'sort array
        ShellSort(strArray, lineCount)

        'then display sorted array in text box
        txtNote.Text = ""
        curline = 1
        For i = 1 To lineCount
            txtNote.Text = txtNote.Text & _
              strArray(curline) & vbCrLf
            curline += 1
        Next i
        txtNote.Select(1, 0)   'remove text selection
    End Sub
End Class
