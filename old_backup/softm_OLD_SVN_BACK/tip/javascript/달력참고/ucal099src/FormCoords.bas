Attribute VB_Name = "Module1"
'�� [FORM ��ġ�� ����]###############################################################

'��� �κ�(���� �����Ų �� �ٽ� ���α׷��� �����Ű��, ������ �ִ� ��ġ�� ���� �ε�)
'-FormCoords.bas-------------------------------------------------------------
'-ParseStr.bas---------------------------------------------------------------
'-Replacetoken.BAS-----------------------------------------------------------

'<����>���� ĸ�ǹٸ� �������� �ʰ� ���� �����ϼ� ���� �ϴ� ���
'�� �Ӽ�â���� Moveable�Ӽ��� False�� ����(form.moveable = false)

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
         ' ���� ũ�⸦ ������ �� ������, ���� ���̸� �����Ѵ�.
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

