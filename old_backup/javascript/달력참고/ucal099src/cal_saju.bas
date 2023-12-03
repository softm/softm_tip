Attribute VB_Name = "cal_saju"
Option Explicit

Global BIRTHDAY As Date '�������
Global PALJA(1 To 8) As Integer '������ڿ� ���� ����
Global SAJU(1 To 4) As Integer

Type t_Insa
    Name As String * 17 '����
    Sex As Integer '����
    Birth0 As Date '���»���
    B0y As Integer '���� ���
    B0m As Integer '���� ����
    B0d As Integer '���� �ϼ�
    Birth1 As Date '��»���
    B1y As Integer '��� ���
    B1m As Integer '��� ����
    B1d As Integer '��� �ϼ�
    DaeUn_Under_date As Date '���Խ� ���ı��� �ð�
    DaeUn_Over_date As Date '���� ���Խñ��� �ð�
    DaeUnSu As Integer '����
    DangLyung As Integer 'õ�� �� 1�� ����(�������)
    JulGi As Integer '�ش�����
    Old As Integer '����
    i_Day2 As String  '���� �Ҽ��� ����
    Title As String '�߰�����
End Type
Global INSA As t_Insa
Enum e_SajuStr
    Number ' ���� 1 ~ 12
    Gan ' õ��
    Ji ' ����
    SipSung ' 10��
    Div '24����
    Div1 '24����(ù��)
    Div2 '24����(�ι�°��)
    g_YukChin '��ģ : �⹮
    yukeui '����
    PalGwae1 '�ȱ�(ù��)
    PalGwae2 '�ȱ�(�ι�°��)
    PalMun1 '�ȹ�(ù��)
    PalMun2 '�ȹ�(�ι�°��)
    TaeEul1 '����(ù��)
    TaeEul2 '����(�ι�°��)
    jikbu1 '����(ù��)
    jikbu2 '����(�ι�°��)
    chunbong1 'õ��(ù��)
    chunbong2 'õ��(�ι�°��)
    SamWon_name '�����
    EumYang_name '�����
    Han_sex '�ǰﱸ��
    Ohaeng '����ǥ��
End Enum


Function p_cal_Yun_Gan(in_date As Date) As Integer
    Dim i_ret As Integer
    '1900���� ���ڳ���
    i_ret = (Year(in_date) - 1900 + 7) Mod 10
    If i_ret <= 0 Then i_ret = i_ret + 10
    p_cal_Yun_Gan = i_ret
    Exit Function
End Function

Function f_cal_Yun_Ji(in_date As Date) As Integer
    Dim i_ret As Integer
    '1900���� ���ڳ���
    i_ret = (Year(in_date) - 1900 + 1) Mod 12
    If i_ret <= 0 Then i_ret = i_ret + 12
    f_cal_Yun_Ji = i_ret
    Exit Function
End Function

Function f_cal_Il_Gan(in_date As Date) As Integer
    Dim i_ret As Integer
    Dim d_ret As Date
'------------------------------------
' ����(���)���ϱ� ����
'------------------------------------
    '1901�� 1�� 1���� �⹦����
    d_ret = DateSerial(Year(in_date), Month(in_date), Day(in_date)) - DateSerial(1901, 1, 1)
    i_ret = (d_ret + 6) Mod 10
    If i_ret <= 0 Then i_ret = 10 + i_ret
    f_cal_Il_Gan = i_ret
    Exit Function
End Function

Function f_cal_Il_Ji(in_date As Date) As Integer
    Dim i_ret As Integer
    Dim d_ret As Date
    '1901�� 1�� 1���� �⹦����
    d_ret = DateSerial(Year(in_date), Month(in_date), Day(in_date)) - DateSerial(1901, 1, 1)
    i_ret = (d_ret + 4) Mod 12
    If i_ret <= 0 Then i_ret = 12 + i_ret
    f_cal_Il_Ji = i_ret
    Exit Function
End Function
'Function MyFunc(MyStr As String, Optional MyArg1 As _
    Integer = 5, Optional MyArg2 = "Dolly")

Sub p_Cal_Palja(in_date As Date, _
    Optional s_TimeLongitude As Single = 135, _
    Optional s_EarthLongitude As Single = 127.5, _
    Optional b_YajaSi As Boolean = False, _
    Optional b_Summer As Boolean = False, _
    Optional b_KTime As Boolean = False)  '�浵 : longitude
'On Error GoTo exit_cal_palja
    Dim d_CDate As Date '127�� ���� ��������
    Dim i_year As Integer
    Dim yun_ju As Integer
    Dim wol_cnt As Integer
    Dim BTime As Date
    Dim TimeCor As Integer '�� ������ ����
    Dim s_TL, s_EL As Single
    
    s_TL = s_TimeLongitude
    s_EL = s_EarthLongitude
    
    If b_KTime = True Then
        If (in_date >= DateSerial(1954, 3, 21) And in_date <= DateSerial(1961, 8, 9)) Then
            s_TL = s_EL
        End If
    End If
    TimeCor = (s_EL - s_TL) * 4
    If b_Summer = True Then
        If (in_date >= DateSerial(1948, 5, 31) And in_date <= DateSerial(1948, 9, 12)) _
        Or (in_date >= DateSerial(1949, 5, 31) And in_date <= DateSerial(1949, 9, 23)) _
        Or (in_date >= DateSerial(1950, 5, 31) And in_date <= DateSerial(1950, 9, 23)) _
        Or (in_date >= DateSerial(1951, 5, 31) And in_date <= DateSerial(1951, 9, 8)) _
        Or (in_date >= DateSerial(1955, 5, 31) And in_date <= DateSerial(1955, 9, 21)) _
        Or (in_date >= DateSerial(1956, 5, 31) And in_date <= DateSerial(1956, 9, 29)) _
        Or (in_date >= DateSerial(1957, 5, 31) And in_date <= DateSerial(1957, 9, 21)) _
        Or (in_date >= DateSerial(1958, 5, 31) And in_date <= DateSerial(1958, 9, 20)) _
        Or (in_date >= DateSerial(1959, 5, 31) And in_date <= DateSerial(1959, 9, 19)) _
        Or (in_date >= DateSerial(1960, 5, 31) And in_date <= DateSerial(1960, 9, 17)) _
        Or (in_date >= DateSerial(1987, 5, 31) And in_date <= DateSerial(1987, 10, 10)) _
        Or (in_date >= DateSerial(1988, 5, 31) And in_date <= DateSerial(1988, 10, 8)) _
        Then
            TimeCor = TimeCor - 60
        End If
    End If '��ġ, ����Ÿ��, �ѱ��ð���� � ���� �ð� ����
    d_CDate = DateSerial(Year(in_date), Month(in_date), Day(in_date)) _
            + TimeSerial(Hour(in_date), Minute(in_date) + TimeCor, Second(in_date))
            
    i_year = Year(d_CDate)
    If d_CDate < gDIV(i_year, 3) Then
        yun_ju = i_year - 1
    Else: yun_ju = i_year
    End If
    '1900�� ���ڳ� ����
    PALJA(1) = (yun_ju - 1900 + 7) Mod 10
    If PALJA(1) <= 0 Then PALJA(1) = PALJA(1) + 10
    PALJA(2) = (yun_ju - 1900 + 1) Mod 12
    If PALJA(2) <= 0 Then PALJA(2) = PALJA(2) + 12
    ' ���� ���ϱ�
    wol_cnt = 1
    Do While wol_cnt < 25   ' Inner loop.
        If gDIV(i_year, wol_cnt) > in_date Then Exit Do '�Է°� �����̸� in_dat�� check, ��갪 �����̸� d_CDATE �� check
                                                    
        wol_cnt = wol_cnt + 1
    Loop 'max�� : 25
    
    PALJA(4) = ((wol_cnt \ 2) + 1) Mod 12
    If PALJA(4) <= 0 Then PALJA(4) = 12 + PALJA(4)
    
    If PALJA(4) <> 1 And PALJA(4) <> 2 Then
        PALJA(3) = (((PALJA(1) Mod 5) * 2 + 8) + PALJA(4)) Mod 10
    Else
        PALJA(3) = (((PALJA(1) Mod 5) * 2) + PALJA(4)) Mod 10
    End If
    If PALJA(3) <= 0 Then PALJA(3) = 10 + PALJA(3)
    '����:1901�� 1�� 1�� ����(�⹦��)
    PALJA(5) = (DateSerial(Year(d_CDate), Month(d_CDate), Day(d_CDate)) _
                - DateSerial(1901, 1, 1) + 6) Mod 10
    If PALJA(5) <= 0 Then PALJA(5) = 10 + PALJA(5)
    PALJA(6) = (DateSerial(Year(d_CDate), Month(d_CDate), Day(d_CDate)) _
                - DateSerial(1901, 1, 1) + 4) Mod 12
    If PALJA(6) <= 0 Then PALJA(6) = 12 + PALJA(6)
    'option�� ���� ���ֿ� ���� ����
    'Optional s_TimeLongitude = 135 :�Է½ð� ���ذ浵
    'Optional s_EarthLongitude = 127.5 :���� ��ġ�� �浵
    'Optional b_DayChange = true :������ ���� ���ֿ� ������ �� ������ �ݿ�
    'Optional b_YajaSi = true:���ڽ� �ݿ�����
    'Optional b_Summer = False:���Ÿ�� ���Ⱓ �ݿ�����,
    'Optional b_KTime = False:Korean time ���Ⱓ �ݿ�����)
    BTime = DateSerial(Year(d_CDate), Month(d_CDate), Day(d_CDate))
    Select Case d_CDate
        'Case BTime - TimeSerial(1, 0, 0) To BTime - TimeSerial(0, 0, 1): palja(8) = 0
        Case BTime + TimeSerial(0, 0, 0) To BTime + TimeSerial(0, 59, 59): PALJA(8) = 1
        Case BTime + TimeSerial(1, 0, 0) To BTime + TimeSerial(2, 59, 59): PALJA(8) = 2
        Case BTime + TimeSerial(3, 0, 0) To BTime + TimeSerial(4, 59, 59): PALJA(8) = 3
        Case BTime + TimeSerial(5, 0, 0) To BTime + TimeSerial(6, 59, 59): PALJA(8) = 4
        Case BTime + TimeSerial(7, 0, 0) To BTime + TimeSerial(8, 59, 59): PALJA(8) = 5
        Case BTime + TimeSerial(9, 0, 0) To BTime + TimeSerial(10, 59, 59): PALJA(8) = 6
        Case BTime + TimeSerial(11, 0, 0) To BTime + TimeSerial(12, 59, 59): PALJA(8) = 7
        Case BTime + TimeSerial(13, 0, 0) To BTime + TimeSerial(14, 59, 59): PALJA(8) = 8
        Case BTime + TimeSerial(15, 0, 0) To BTime + TimeSerial(16, 59, 59): PALJA(8) = 9
        Case BTime + TimeSerial(17, 0, 0) To BTime + TimeSerial(18, 59, 59): PALJA(8) = 10
        Case BTime + TimeSerial(19, 0, 0) To BTime + TimeSerial(20, 59, 59): PALJA(8) = 11
        Case BTime + TimeSerial(21, 0, 0) To BTime + TimeSerial(22, 59, 59): PALJA(8) = 12
        '���ڽ� ����ϴ� ��� �������� ����, �ð�����,
        '���ڽ� �̻���� ��� ��������, �ð��� �ڽ�
        Case BTime + TimeSerial(23, 0, 0) To BTime + TimeSerial(23, 59, 59)
            If b_YajaSi = True Then '���ڽ� ����� ��� �������� ����, �ð�����
                PALJA(8) = 13
            Else '���ڽ� �̻���� ��� �������� , �ð��� ���� ���� �������� ���
                PALJA(5) = (PALJA(5) + 1) Mod 10
                If PALJA(5) <= 0 Then PALJA(5) = PALJA(5) + 10
                PALJA(6) = (PALJA(6) + 1) Mod 12
                If PALJA(6) <= 0 Then PALJA(6) = PALJA(6) + 12
                PALJA(8) = 1
            End If
    End Select
    PALJA(7) = (((PALJA(5) Mod 5) * 2 + 8) + PALJA(8)) Mod 10
    If PALJA(7) <= 0 Then PALJA(7) = PALJA(7) + 10
    PALJA(8) = PALJA(8) Mod 12
    If PALJA(8) <= 0 Then PALJA(8) = PALJA(8) + 12
    SAJU(1) = f_Cal_GapJa60(PALJA(1), PALJA(2))
    SAJU(2) = f_Cal_GapJa60(PALJA(3), PALJA(4))
    SAJU(3) = f_Cal_GapJa60(PALJA(5), PALJA(6))
    SAJU(4) = f_Cal_GapJa60(PALJA(7), PALJA(8))
    BIRTHDAY = in_date
    Exit Sub
'exit_cal_palja:
End Sub

Function f_Cal_GapJa60(in_Gan As Integer, in_Ji As Integer)
    Dim cal_gapja60 As Integer
    Dim cal_ji As Integer
    If in_Gan < 0 Or in_Ji < 0 Then
        f_Cal_GapJa60 = -1
        Exit Function
    End If
    If in_Gan = 0 And in_Ji = 0 Then
        f_Cal_GapJa60 = 0
        Exit Function
    End If
    cal_ji = in_Ji
    If in_Gan >= cal_ji Then cal_ji = cal_ji + 10

    cal_gapja60 = ((10 - (cal_ji - in_Gan)) Mod 10) * 6 + in_Ji
    f_Cal_GapJa60 = cal_gapja60
    Exit Function
End Function

Public Function f_Cal_SipSung(in_ilgan As Integer, in_Tagan As Integer) As Integer
    Dim EumYang As Integer
    Dim Ohaeng As Integer
    
    If in_Tagan < in_ilgan Then in_Tagan = in_Tagan + 10

    If in_ilgan Mod 2 = 1 Then '�簣�� ���
        f_Cal_SipSung = in_Tagan - in_ilgan + 1
    Else '������ ���
        Select Case (in_Tagan - in_ilgan)
            Case 0: f_Cal_SipSung = 1
            Case 1: f_Cal_SipSung = 4
            Case 2: f_Cal_SipSung = 3
            Case 3: f_Cal_SipSung = 6
            Case 4: f_Cal_SipSung = 5
            Case 5: f_Cal_SipSung = 8
            Case 6: f_Cal_SipSung = 7
            Case 7: f_Cal_SipSung = 10
            Case 8: f_Cal_SipSung = 9
            Case 9: f_Cal_SipSung = 2
        End Select
    End If
    Exit Function
End Function

Public Function fSS(in_N As Integer, in_T As e_SajuStr) As String 'print�� �� �����ϱ� ����
    fSS = f_SajuStr(in_N, in_T)
    Exit Function
End Function

Public Function f_SajuStr(in_strNum As Integer, in_strtype As e_SajuStr) As String
    Select Case in_strtype
        Case Gan
            Select Case in_strNum
                Case 1: f_SajuStr = "ˣ"
                Case 2: f_SajuStr = "��"
                Case 3: f_SajuStr = "ܰ"
                Case 4: f_SajuStr = "��"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "��"
                Case 7: f_SajuStr = "��"
                Case 8: f_SajuStr = "��"
                Case 9: f_SajuStr = "��"
                Case 10: f_SajuStr = "ͤ"
                Case Else: f_SajuStr = "??"
            End Select
        Case Ji
            Select Case in_strNum
                Case 1: f_SajuStr = "�"
                Case 2: f_SajuStr = "��"
                Case 3: f_SajuStr = "��"
                Case 4: f_SajuStr = "��"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "��"
                Case 7: f_SajuStr = "��"
                Case 8: f_SajuStr = "ڱ"
                Case 9: f_SajuStr = "��"
                Case 10: f_SajuStr = "�"
                Case 11: f_SajuStr = "��"
                Case 12: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case Number
            Select Case in_strNum '���� ���ڸ� ǥ���� ���
                Case 0: f_SajuStr = "00"
                Case 1: f_SajuStr = "��"
                Case 2: f_SajuStr = "�"
                Case 3: f_SajuStr = "߲"
                Case 4: f_SajuStr = "��"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "�"
                Case 7: f_SajuStr = "��"
                Case 8: f_SajuStr = "��"
                Case 9: f_SajuStr = "��"
                Case 10: f_SajuStr = "�"
                Case 100: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case SipSung '���� �ʼ��� ǥ���� ���
            Select Case in_strNum
                Case 1: f_SajuStr = "��̷"
                Case 2: f_SajuStr = "̤�"
                Case 3: f_SajuStr = "����"
                Case 4: f_SajuStr = "߿ί"
                Case 5: f_SajuStr = "���"
                Case 6: f_SajuStr = "���"
                Case 7: f_SajuStr = "��ί"
                Case 8: f_SajuStr = "��ί"
                Case 9: f_SajuStr = "����"
                Case 10: f_SajuStr = "����"
                Case Else: f_SajuStr = "??"
            End Select
        Case g_YukChin '�⹮ ��ģ�� ���
            Select Case in_strNum
                Case 0, 1: f_SajuStr = "�"
                Case 2: f_SajuStr = "��"
                Case 3, 4: f_SajuStr = "��"
                Case 5, 6: f_SajuStr = "�"
                Case 7: f_SajuStr = "С"
                Case 8: f_SajuStr = "ί"
                Case 9, 10: f_SajuStr = "ݫ"
                Case Else: f_SajuStr = "??"
            End Select
        Case Div1 ' ������ ���
            Select Case in_strNum
                Case 1: f_SajuStr = "�"
                Case 2: f_SajuStr = "��"
                Case 3: f_SajuStr = "�"
                Case 4: f_SajuStr = "��"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "��"
                Case 7: f_SajuStr = "��"
                Case 8: f_SajuStr = "��"
                Case 9: f_SajuStr = "�"
                Case 10: f_SajuStr = "�"
                Case 11: f_SajuStr = "��"
                Case 12: f_SajuStr = "��"
                Case 13: f_SajuStr = "�"
                Case 14: f_SajuStr = "��"
                Case 15: f_SajuStr = "�"
                Case 16: f_SajuStr = "��"
                Case 17: f_SajuStr = "��"
                Case 18: f_SajuStr = "��"
                Case 19: f_SajuStr = "��"
                Case 20: f_SajuStr = "��"
                Case 21: f_SajuStr = "�"
                Case 22: f_SajuStr = "�"
                Case 23: f_SajuStr = "��"
                Case 24: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case Div2 ' ������ ���
            Select Case in_strNum
                Case 1: f_SajuStr = "��"
                Case 2: f_SajuStr = "��"
                Case 3: f_SajuStr = "��"
                Case 4: f_SajuStr = "�"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "��"
                Case 7: f_SajuStr = "٥"
                Case 8: f_SajuStr = "��"
                Case 9: f_SajuStr = "��"
                Case 10: f_SajuStr = "ػ"
                Case 11: f_SajuStr = "��"
                Case 12: f_SajuStr = "�"
                Case 13: f_SajuStr = "��"
                Case 14: f_SajuStr = "��"
                Case 15: f_SajuStr = "��"
                Case 16: f_SajuStr = "��"
                Case 17: f_SajuStr = "��"
                Case 18: f_SajuStr = "��"
                Case 19: f_SajuStr = "��"
                Case 20: f_SajuStr = "˽"
                Case 21: f_SajuStr = "��"
                Case 22: f_SajuStr = "��"
                Case 23: f_SajuStr = "��"
                Case 24: f_SajuStr = "�"
                Case Else: f_SajuStr = "??"
            End Select
        Case Div ' ������ ���
            Select Case in_strNum
                Case 1: f_SajuStr = "���"
                Case 2: f_SajuStr = "����"
                Case 3: f_SajuStr = "���"
                Case 4: f_SajuStr = "���"
                Case 5: f_SajuStr = "����"
                Case 6: f_SajuStr = "����"
                Case 7: f_SajuStr = "��٥"
                Case 8: f_SajuStr = "����"
                Case 9: f_SajuStr = "���"
                Case 10: f_SajuStr = "�ػ"
                Case 11: f_SajuStr = "����"
                Case 12: f_SajuStr = "���"
                Case 13: f_SajuStr = "���"
                Case 14: f_SajuStr = "����"
                Case 15: f_SajuStr = "���"
                Case 16: f_SajuStr = "����"
                Case 17: f_SajuStr = "����"
                Case 18: f_SajuStr = "����"
                Case 19: f_SajuStr = "����"
                Case 20: f_SajuStr = "��˽"
                Case 21: f_SajuStr = "���"
                Case 22: f_SajuStr = "���"
                Case 23: f_SajuStr = "����"
                Case 24: f_SajuStr = "���"
                Case Else: f_SajuStr = "??"
            End Select
        Case yukeui
            Select Case in_strNum
                Case 1: f_SajuStr = "��"
                Case 2: f_SajuStr = "��"
                Case 3: f_SajuStr = "��"
                Case 4: f_SajuStr = "��"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "ͤ"
                Case 7: f_SajuStr = "��"
                Case 8: f_SajuStr = "ܰ"
                Case 9: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case PalGwae1
            'Select Case in_strNum
            '    Case 1: f_SajuStr = "��Ѩ"
            '    Case 2: f_SajuStr = "����"
            '    Case 3: f_SajuStr = "���"
            '    Case 4: f_SajuStr = "���"
            '    Case 5: f_SajuStr = "����"
            '    Case 6: f_SajuStr = "����"
            '    Case 7: f_SajuStr = "�٤"
            '    Case 8: f_SajuStr = "����"
            'End Select
            Select Case in_strNum
                Case 1: f_SajuStr = "��"
                Case 2: f_SajuStr = "��"
                Case 3: f_SajuStr = "�"
                Case 4: f_SajuStr = "�"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "��"
                Case 7: f_SajuStr = "�"
                Case 8: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case PalGwae2
            Select Case in_strNum
                Case 1: f_SajuStr = "Ѩ"
                Case 2: f_SajuStr = "��"
                Case 3: f_SajuStr = "��"
                Case 4: f_SajuStr = "��"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "��"
                Case 7: f_SajuStr = "٤"
                Case 8: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case PalMun1
            'Select Case in_strNum
            '    Case 1: f_SajuStr = "��ڦ"
            '    Case 2: f_SajuStr = "߿ڦ"
            '    Case 3: f_SajuStr = "��ڦ"
            '    Case 4: f_SajuStr = "��ڦ"
            '    Case 5: f_SajuStr = "��ڦ"
            '    Case 6: f_SajuStr = "��ڦ"
            '    Case 7: f_SajuStr = "��ڦ"
            '    Case 8: f_SajuStr = "��ڦ"
            'End Select
            Select Case in_strNum
                Case 1: f_SajuStr = "��"
                Case 2: f_SajuStr = "߿"
                Case 3: f_SajuStr = "��"
                Case 4: f_SajuStr = "��"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "��"
                Case 7: f_SajuStr = "��"
                Case 8: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case PalMun2
            f_SajuStr = "ڦ"
        Case TaeEul1
            'Select Case in_strNum
            '    Case 1: f_SajuStr = "����"
            '    Case 2: f_SajuStr = "���"
            '    Case 3: f_SajuStr = "���"
            '    Case 4: f_SajuStr = "����"
            '    Case 5: f_SajuStr = "��ݬ"
            '    Case 6: f_SajuStr = "����"
            '    Case 7: f_SajuStr = "���"
            '    Case 8: f_SajuStr = "����"
            '    Case 9: f_SajuStr = "����"
            'End Select
            Select Case in_strNum
                Case 1: f_SajuStr = "��"
                Case 2: f_SajuStr = "��"
                Case 3: f_SajuStr = "��"
                Case 4: f_SajuStr = "��"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "��"
                Case 7: f_SajuStr = "��"
                Case 8: f_SajuStr = "��"
                Case 9: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case TaeEul2
            Select Case in_strNum
                Case 1: f_SajuStr = "��"
                Case 2: f_SajuStr = "�"
                Case 3: f_SajuStr = "�"
                Case 4: f_SajuStr = "��"
                Case 5: f_SajuStr = "ݬ"
                Case 6: f_SajuStr = "��"
                Case 7: f_SajuStr = "�"
                Case 8: f_SajuStr = "��"
                Case 9: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case jikbu1
'            Select Case in_strNum
'                Case 1, -1: f_SajuStr = "��ݬ"
'                Case 2, -2: f_SajuStr = "����"
'                Case 3, -3: f_SajuStr = "����"
'                Case 4, -4: f_SajuStr = "���"
'                Case 5: f_SajuStr = "ϣ��"
'                Case -5: f_SajuStr = "����"
'                Case 6: f_SajuStr = "���"
'                Case -6: f_SajuStr = "����"
'                Case 7, -7: f_SajuStr = "���"
'                Case 8, -8: f_SajuStr = "����"
'                Case Else: f_SajuStr = "??"
'            End Select
            Select Case in_strNum
                Case 1, -1: f_SajuStr = "��"
                Case 2, -2: f_SajuStr = "��"
                Case 3, -3: f_SajuStr = "��"
                Case 4, -4: f_SajuStr = "�"
                Case 5: f_SajuStr = "ϣ"
                Case -5: f_SajuStr = "��"
                Case 6: f_SajuStr = "�"
                Case -6: f_SajuStr = "��"
                Case 7, -7: f_SajuStr = "��"
                Case 8, -8: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case jikbu2
            Select Case in_strNum
                Case 1, -1: f_SajuStr = "ݬ"
                Case 2, -2: f_SajuStr = "��"
                Case 3, -3: f_SajuStr = "��"
                Case 4, -4: f_SajuStr = "��"
                Case 5: f_SajuStr = "��"
                Case -5: f_SajuStr = "��"
                Case 6: f_SajuStr = "��"
                Case -6: f_SajuStr = "��"
                Case 7, -7: f_SajuStr = "�"
                Case 8, -8: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case chunbong1: f_SajuStr = "��"
        Case chunbong2
            Select Case in_strNum
                Case 1: f_SajuStr = "��"
                Case 2: f_SajuStr = "��"
                Case 3: f_SajuStr = "��"
                Case 4: f_SajuStr = "��"
                Case 5: f_SajuStr = "��"
                Case 6: f_SajuStr = "��"
                Case 7: f_SajuStr = "�"
                Case 8: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case SamWon_name
            Select Case in_strNum
                Case 0: f_SajuStr = "߾"
                Case 1: f_SajuStr = "��"
                Case 2: f_SajuStr = "��"
                Case Else: f_SajuStr = "??"
            End Select
        Case EumYang_name
            Select Case ((in_strNum) Mod 2)
                Case 1: f_SajuStr = "��" 'Ȧ���� ��� ��
                Case 0: f_SajuStr = "��" '¦���� ��� ��
                Case Else: f_SajuStr = "??"
            End Select
        Case Han_sex
            Select Case ((in_strNum) Mod 2)
                Case 1: f_SajuStr = "��" 'Ȧ���� ��� ��
                Case 0: f_SajuStr = "��" '¦���� ��� ��
                Case Else: f_SajuStr = "??"
            End Select
        Case Ohaeng
            Select Case in_strNum
                Case 1, 2: f_SajuStr = "��" 'Ȧ���� ��� ��
                Case 3, 4: f_SajuStr = "��" '¦���� ��� ��
                Case 5, 6: f_SajuStr = "��" '¦���� ��� ��
                Case 7, 8: f_SajuStr = "��" '¦���� ��� ��
                Case 9, 10: f_SajuStr = "�" '¦���� ��� ��
                Case Else: f_SajuStr = "??"
            End Select
        Case Else: f_SajuStr = "ER"
    End Select
    Exit Function
End Function



