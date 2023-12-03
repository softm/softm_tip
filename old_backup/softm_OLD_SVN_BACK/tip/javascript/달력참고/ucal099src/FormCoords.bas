Attribute VB_Name = "Module1"
'▶ [FORM 위치값 저장]###############################################################

'모듈 부분(폼을 종료시킨 후 다시 프로그램을 실행시키면, 이전에 있던 위치로 폼이 로드)
'-FormCoords.bas-------------------------------------------------------------
'-ParseStr.bas---------------------------------------------------------------
'-Replacetoken.BAS-----------------------------------------------------------

'<참고>폼의 캡션바를 제거하지 않고 폼을 움직일수 없게 하는 방법
'폼 속성창에서 Moveable속성을 False로 셋팅(form.moveable = false)

Option Explicit

Public Function FormCoords(frmWork As Form, ByVal strMode As String, _
                        Optional ByVal strSection As String) As String
  
  On Local Error Resume Next
  
  strMode = UCase(strMode)
  If Len(strSection) = 0 Then strSection = "Startup"
    
  With frmWork
    If strMode = "GET" Then
      FormCoords = GetSetting(App.EXEName, strSection, .Name)
      If Len(FormCoords) Then
        .Left = ParseStr(FormCoords, 1, ",")
        .Top = ParseStr(FormCoords, 2, ",")
         ' 폼의 크기를 변경할 수 있으면, 폭과 높이를 설정한다.
        If .BorderStyle = 2 Then
          .Width = ParseStr(FormCoords, 3, ",")
          .Height = ParseStr(FormCoords, 4, ",")
        End If
      End If
    Else
      SaveSetting App.EXEName, strSection, .Name, .Left & "," _
                             & .Top & "," & .Width & "," & .Height
    End If
  End With
      
End Function

