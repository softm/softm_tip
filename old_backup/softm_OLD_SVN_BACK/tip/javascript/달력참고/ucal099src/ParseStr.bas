Attribute VB_Name = "Module2"
'▶ [FORM 위치값 저장]###############################################################

'모듈 부분(폼을 종료시킨 후 다시 프로그램을 실행시키면, 이전에 있던 위치로 폼이 로드)
'-FormCoords.bas-------------------------------------------------------------
'-ParseStr.bas---------------------------------------------------------------
'-Replacetoken.BAS-----------------------------------------------------------

Option Explicit

Public Function ParseStr(ByVal strWork As String, intTokenNum As Integer, _
   strDelimitChr As String, Optional ByVal strEncapChr As String) As String

  On Local Error Resume Next
  
  Dim blnExitDo As Boolean
  Dim intDPos As Integer
  Dim intSPtr As Integer
  Dim intEPtr As Integer
  Dim intCurrentTokenNum As Integer
  Dim intWorkStrLen As Integer
  Dim intEncapStatus As Integer
  Static intSPos As Integer
  Dim strTemp As String
  Static intDelimitLen As Integer

  intWorkStrLen = Len(strWork)
    
  If Len(strEncapChr) Then
    intEncapStatus = Len(strEncapChr)
  End If

  If intWorkStrLen = 0 Or (intSPos > intWorkStrLen And intTokenNum = 0) Then
    intSPos = 0
    Exit Function
  ElseIf intTokenNum > 0 Or intSPos = 0 Then
    intSPos = 1
    intDelimitLen = Len(strDelimitChr)
  End If

  Do
    
    intDPos = InStr(intSPos, strWork, strDelimitChr)

    If intEncapStatus Then
      intSPtr = InStr(intSPos, strWork, strEncapChr)
      intEPtr = InStr(intSPtr + 1, strWork, strEncapChr)
      If intDPos > intSPtr And intDPos < intEPtr Then
        intDPos = InStr(intEPtr, strWork, strDelimitChr)
      End If
    End If

    If intDPos < intSPos Then
      intDPos = intWorkStrLen + intDelimitLen
    End If

    If intDPos Then
      If intTokenNum Then
        intCurrentTokenNum = intCurrentTokenNum + 1
        If intCurrentTokenNum = intTokenNum Then
          strTemp = Mid(strWork, intSPos, intDPos - intSPos)
          blnExitDo = True
        Else
          blnExitDo = False
        End If
      Else
        strTemp = Mid(strWork, intSPos, intDPos - intSPos)
          blnExitDo = True
      End If
      intSPos = intDPos + intDelimitLen
    Else
      intSPos = 0
      blnExitDo = True
    End If
  Loop Until blnExitDo

  If intEncapStatus Then
    ParseStr = ReplaceCS(strTemp, strEncapChr, "", StringBinaryCompare)
  Else
    ParseStr = strTemp
  End If

End Function


