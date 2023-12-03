Imports System.IO

Public Class HelpInfo

    Private Sub Label1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Label1.Click

    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        Me.DialogResult = DialogResult.OK
    End Sub

    Private Sub HelpInfo_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        Dim StreamToDisplay As StreamReader
        StreamToDisplay = New StreamReader("C:\Users\Administrator\Desktop\StepbyStepVisualBasicdotNET[1]\7627-956\chap14\readme.txt")
        TextBox1.Text = StreamToDisplay.ReadToEnd
        StreamToDisplay.Close()
        TextBox1.Select(0, 0)
    End Sub
End Class