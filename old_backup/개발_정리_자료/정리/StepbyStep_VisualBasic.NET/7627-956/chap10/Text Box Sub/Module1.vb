Module Module1
    Sub AddName(ByVal Team As String, ByRef ReturnString As String)
        Dim Prompt, Nm, WrapCharacter As String
        Prompt = "Enter a " & Team & " employee."
        Nm = InputBox(Prompt, "Input Box")
        WrapCharacter = Chr(13) + Chr(10)
        ReturnString = Nm & WrapCharacter
    End Sub

End Module
