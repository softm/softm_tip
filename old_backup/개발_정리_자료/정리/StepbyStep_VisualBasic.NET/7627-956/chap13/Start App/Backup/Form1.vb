Imports System.Threading
Imports System.Diagnostics

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
        Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents Button3 As System.Windows.Forms.Button
    Friend WithEvents noteProcess As System.Diagnostics.Process

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Button2 = New System.Windows.Forms.Button()
        Me.Button3 = New System.Windows.Forms.Button()
        Me.noteProcess = New System.Diagnostics.Process()
        Me.SuspendLayout()
        '
        'Button2
        '
        Me.Button2.Location = New System.Drawing.Point(64, 40)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(136, 32)
        Me.Button2.TabIndex = 1
        Me.Button2.Text = "Start Notepad"
        '
        'Button3
        '
        Me.Button3.Location = New System.Drawing.Point(64, 104)
        Me.Button3.Name = "Button3"
        Me.Button3.Size = New System.Drawing.Size(136, 32)
        Me.Button3.TabIndex = 2
        Me.Button3.Text = "Stop Notepad"
        '
        'noteProcess
        '
        Me.noteProcess.StartInfo.FileName = "notepad.exe"
        Me.noteProcess.SynchronizingObject = Me
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(292, 189)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.Button3, Me.Button2})
        Me.Name = "Form1"
        Me.Text = "Process Start Examples"
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        noteProcess.Start()
    End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button3.Click
        noteProcess.CloseMainWindow()
    End Sub
End Class
