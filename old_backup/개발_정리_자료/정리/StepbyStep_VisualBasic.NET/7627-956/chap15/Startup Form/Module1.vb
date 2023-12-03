Module Module1
    Public MyForm1 As New Form1()
    Public MyForm2 As New Form2()
    Public Sub Main()
        MsgBox("This is Sub Main")
        'place additional program code here
        MyForm1.ShowDialog()
    End Sub
End Module
