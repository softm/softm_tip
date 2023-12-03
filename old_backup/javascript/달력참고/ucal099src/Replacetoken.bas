Attribute VB_Name = "Module3"
'▶ [FORM 위치값 저장]###############################################################

'모듈 부분(폼을 종료시킨 후 다시 프로그램을 실행시키면, 이전에 있던 위치로 폼이 로드)
'-FormCoords.bas-------------------------------------------------------------
'-ParseStr.bas---------------------------------------------------------------
'-Replacetoken.BAS-----------------------------------------------------------

Public Enum OpMode
  StringBinaryCompare = vbBinaryCompare + 1
  StringTextCompare = vbTextCompare + 1
  StringDataBaseCompare = vbDatabaseCompare + 1
  CharacterBinaryCompare = -(vbBinaryCompare + 1)
  CharacterTextCompare = -(vbTextCompare + 1)
  CharacterDataBaseCompare = -(vbDatabaseCompare + 1)
End Enum

Public Function ReplaceCS(ByVal strWork As String, ByVal strOld As String, _
  ByVal strNew As String, Optional ByVal intOPMode As OpMode, _
  Optional blnUpdated As Boolean) As String

On Error Resume Next

Dim intOldLen As Integer
Dim intNewLen As Integer
Dim intSPos As Long
Dim intN As Integer

If intOPMode = 0 Then
  intOPMode = StringBinaryCompare
End If

intNewLen = Len(strNew)
intOldLen = Len(strOld)

intSPos = 1
blnUpdated = False

If intOPMode < 0 Then
  intOPMode = Abs(intOPMode) - 1
  For intN = 1 To intOldLen
    intSPos = 1
    Do
      intSPos = InStr(intSPos, strWork, Mid(strOld, intN, 1), intOPMode)
      If intSPos Then
        strWork = Left(strWork, intSPos - 1) & strNew & Mid(strWork, _
          intSPos + 1)
        intSPos = intSPos + intNewLen
        blnUpdated = True
      End If
    Loop While intSPos
  Next
Else
  intOPMode = intOPMode - 1
  Do
    intSPos = InStr(intSPos, strWork, strOld, intOPMode)
    If intSPos Then
      strWork = Left(strWork, intSPos - 1) & strNew _
                & Mid(strWork, intSPos + intOldLen)
      intSPos = intSPos + intNewLen
      blnUpdated = True
    End If
  Loop While intSPos
End If

ReplaceCS = strWork

End Function
