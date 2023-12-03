Module Module1
    Public Wins As Short
    Public Spins As Short

    Function HitRate(ByVal Hits As Short, ByVal Tries As Short) As String
        Dim Percent As Single
        Percent = Hits / Tries
        Return Format(Percent, "0.0%")
    End Function

End Module
