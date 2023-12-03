Attribute VB_Name = "cal_saju"
Option Explicit

Global BIRTHDAY As Date 'Ãâ»ıÀÏÀÚ
Global PALJA(1 To 8) As Integer 'Ãâ»ıÀÏÀÚ¿¡ µû¸¥ ÆÈÀÚ
Global SAJU(1 To 4) As Integer

Type t_Insa
    Name As String * 17 '¼º¸í
    Sex As Integer '¼ºº°
    Birth0 As Date 'À½·Â»ıÀÏ
    B0y As Integer 'À½·Â ³â¼ö
    B0m As Integer 'À½·Â ¿ù¼ö
    B0d As Integer 'À½·Â ÀÏ¼ö
    Birth1 As Date '¾ç·Â»ıÀÏ
    B1y As Integer '¾ç·Â ³â¼ö
    B1m As Integer '¾ç·Â ¿ù¼ö
    B1d As Integer '¾ç·Â ÀÏ¼ö
    DaeUn_Under_date As Date 'ÀıÀÔ½Ã ÀÌÈÄ±îÁö ½Ã°£
    DaeUn_Over_date As Date '´ÙÀ½ ÀıÀÔ½Ã±îÁö ½Ã°£
    DaeUnSu As Integer '´ë¿î¼ö
    DangLyung As Integer 'Ãµ°£ Áß 1°³ ¼ıÀÚ(¿ùÁö´ç·É)
    JulGi As Integer 'ÇØ´çÀı±â
    Old As Integer '³ªÀÌ
    i_Day2 As String  '´ë¿î¼ö ¼Ò¼öÁ¡ ¿µ¿ª
    Title As String 'Ãß°¡»çÇ×
End Type
Global INSA As t_Insa
Enum e_SajuStr
    Number ' ÇÑÀÚ 1 ~ 12
    Gan ' Ãµ°£
    Ji ' ÁöÁö
    SipSung ' 10¼º
    Div '24Àı±â
    Div1 '24Àı±â(Ã¹ÀÚ)
    Div2 '24Àı±â(µÎ¹øÂ°ÀÚ)
    g_YukChin 'À°Ä£ : ±â¹®
    yukeui 'À°ÀÇ
    PalGwae1 'ÆÈ±¥(Ã¹ÀÚ)
    PalGwae2 'ÆÈ±¥(µÎ¹øÂ°ÀÚ)
    PalMun1 'ÆÈ¹®(Ã¹ÀÚ)
    PalMun2 'ÆÈ¹®(µÎ¹øÂ°ÀÚ)
    TaeEul1 'ÅÂÀ»(Ã¹ÀÚ)
    TaeEul2 'ÅÂÀ»(µÎ¹øÂ°ÀÚ)
    jikbu1 'Á÷ºÎ(Ã¹ÀÚ)
    jikbu2 'Á÷ºÎ(µÎ¹øÂ°ÀÚ)
    chunbong1 'ÃµºÀ(Ã¹ÀÚ)
    chunbong2 'ÃµºÀ(µÎ¹øÂ°ÀÚ)
    SamWon_name '»ï¿ø¸í
    EumYang_name 'À½¾ç¸í
    Han_sex '°Ç°ï±¸ºĞ
    Ohaeng '¿ÀÇàÇ¥½Ã
End Enum


Function p_cal_Yun_Gan(in_date As Date) As Integer
    Dim i_ret As Integer
    '1900³âÀº °æÀÚ³âÀÓ
    i_ret = (Year(in_date) - 1900 + 7) Mod 10
    If i_ret <= 0 Then i_ret = i_ret + 10
    p_cal_Yun_Gan = i_ret
    Exit Function
End Function

Function f_cal_Yun_Ji(in_date As Date) As Integer
    Dim i_ret As Integer
    '1900³âÀº °æÀÚ³âÀÓ
    i_ret = (Year(in_date) - 1900 + 1) Mod 12
    If i_ret <= 0 Then i_ret = i_ret + 12
    f_cal_Yun_Ji = i_ret
    Exit Function
End Function

Function f_cal_Il_Gan(in_date As Date) As Integer
    Dim i_ret As Integer
    Dim d_ret As Date
'------------------------------------
' ÀÏÁÖ(ìíñº)±¸ÇÏ±â °ø½Ä
'------------------------------------
    '1901³â 1¿ù 1ÀÏÀº ±â¹¦ÀÏÀÓ
    d_ret = DateSerial(Year(in_date), Month(in_date), Day(in_date)) - DateSerial(1901, 1, 1)
    i_ret = (d_ret + 6) Mod 10
    If i_ret <= 0 Then i_ret = 10 + i_ret
    f_cal_Il_Gan = i_ret
    Exit Function
End Function

Function f_cal_Il_Ji(in_date As Date) As Integer
    Dim i_ret As Integer
    Dim d_ret As Date
    '1901³â 1¿ù 1ÀÏÀº ±â¹¦ÀÏÀÓ
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
    Optional b_KTime As Boolean = False)  '°æµµ : longitude
'On Error GoTo exit_cal_palja
    Dim d_CDate As Date '127µµ ±âÁØ º¸Á¤ÀÏÀÚ
    Dim i_year As Integer
    Dim yun_ju As Integer
    Dim wol_cnt As Integer
    Dim BTime As Date
    Dim TimeCor As Integer 'ºĞ ´ÜÀ§·Î º¸Á¤
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
    End If 'À§Ä¡, ¼¶¸ÓÅ¸ÀÓ, ÇÑ±¹½Ã°£»ç¿ë µî¿¡ µû¸¥ ½Ã°£ º¸Á¤
    d_CDate = DateSerial(Year(in_date), Month(in_date), Day(in_date)) _
            + TimeSerial(Hour(in_date), Minute(in_date) + TimeCor, Second(in_date))
            
    i_year = Year(d_CDate)
    If d_CDate < gDIV(i_year, 3) Then
        yun_ju = i_year - 1
    Else: yun_ju = i_year
    End If
    '1900³â °æÀÚ³â ±âÁØ
    PALJA(1) = (yun_ju - 1900 + 7) Mod 10
    If PALJA(1) <= 0 Then PALJA(1) = PALJA(1) + 10
    PALJA(2) = (yun_ju - 1900 + 1) Mod 12
    If PALJA(2) <= 0 Then PALJA(2) = PALJA(2) + 12
    ' ¿ùÁÖ ±¸ÇÏ±â
    wol_cnt = 1
    Do While wol_cnt < 25   ' Inner loop.
        If gDIV(i_year, wol_cnt) > in_date Then Exit Do 'ÀÔ·Â°ª ±âÁØÀÌ¸é in_dat·Î check, °è»ê°ª ±âÁØÀÌ¸é d_CDATE ·Î check
                                                    
        wol_cnt = wol_cnt + 1
    Loop 'max°ª : 25
    
    PALJA(4) = ((wol_cnt \ 2) + 1) Mod 12
    If PALJA(4) <= 0 Then PALJA(4) = 12 + PALJA(4)
    
    If PALJA(4) <> 1 And PALJA(4) <> 2 Then
        PALJA(3) = (((PALJA(1) Mod 5) * 2 + 8) + PALJA(4)) Mod 10
    Else
        PALJA(3) = (((PALJA(1) Mod 5) * 2) + PALJA(4)) Mod 10
    End If
    If PALJA(3) <= 0 Then PALJA(3) = 10 + PALJA(3)
    'ÀÏÁÖ:1901³â 1¿ù 1ÀÏ ±âÁØ(±â¹¦ÀÏ)
    PALJA(5) = (DateSerial(Year(d_CDate), Month(d_CDate), Day(d_CDate)) _
                - DateSerial(1901, 1, 1) + 6) Mod 10
    If PALJA(5) <= 0 Then PALJA(5) = 10 + PALJA(5)
    PALJA(6) = (DateSerial(Year(d_CDate), Month(d_CDate), Day(d_CDate)) _
                - DateSerial(1901, 1, 1) + 4) Mod 12
    If PALJA(6) <= 0 Then PALJA(6) = 12 + PALJA(6)
    'option¿¡ µû¶ó ÀÏÁÖ¿Í ½ÃÁÖ Á¶Á¤
    'Optional s_TimeLongitude = 135 :ÀÔ·Â½Ã°£ ±âÁØ°æµµ
    'Optional s_EarthLongitude = 127.5 :ÇöÀç À§Ä¡ÀÇ °æµµ
    'Optional b_DayChange = true :½ÃÁö¿¡ µû¶ó ÀÏÁÖ¿¡ ¿µÇâÀ» ÁÙ °ÍÀÎÁö ¹İ¿µ
    'Optional b_YajaSi = true:¾ßÀÚ½Ã ¹İ¿µ¿©ºÎ
    'Optional b_Summer = False:½æ¸ÓÅ¸ÀÓ »ç¿ë±â°£ ¹İ¿µ¿©ºÎ,
    'Optional b_KTime = False:Korean time »ç¿ë±â°£ ¹İ¿µ¿©ºÎ)
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
        '¾ßÀÚ½Ã »ç¿ëÇÏ´Â °æ¿ì ÀÏÁøº¯°æ ¾øÀ½, ½Ã°£º¯°æ,
        '¾ßÀÚ½Ã ¹Ì»ç¿ëÀÎ °æ¿ì ÀÏÁøº¯°æ, ½Ã°£Àº ÀÚ½Ã
        Case BTime + TimeSerial(23, 0, 0) To BTime + TimeSerial(23, 59, 59)
            If b_YajaSi = True Then '¾ßÀÚ½Ã »ç¿ëÀÎ °æ¿ì ÀÏÁøº¯°æ ¾øÀ½, ½Ã°£º¯°æ
                PALJA(8) = 13
            Else '¾ßÀÚ½Ã ¹Ì»ç¿ëÀÎ °æ¿ì ÀÏÁøº¯°æ , ½Ã°£Àº ´ÙÀ½ ÀÏÁø ±âÁØÀ¸·Î »ç¿ë
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

    If in_ilgan Mod 2 = 1 Then '¾ç°£ÀÏ °æ¿ì
        f_Cal_SipSung = in_Tagan - in_ilgan + 1
    Else 'À½°£ÀÏ °æ¿ì
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

Public Function fSS(in_N As Integer, in_T As e_SajuStr) As String 'printÇÒ ¶§ ¿ëÀÌÇÏ±â À§ÇØ
    fSS = f_SajuStr(in_N, in_T)
    Exit Function
End Function

Public Function f_SajuStr(in_strNum As Integer, in_strtype As e_SajuStr) As String
    Select Case in_strtype
        Case Gan
            Select Case in_strNum
                Case 1: f_SajuStr = "Ë£"
                Case 2: f_SajuStr = "ëà"
                Case 3: f_SajuStr = "Ü°"
                Case 4: f_SajuStr = "ïË"
                Case 5: f_SajuStr = "Ùæ"
                Case 6: f_SajuStr = "Ğù"
                Case 7: f_SajuStr = "ÌÒ"
                Case 8: f_SajuStr = "ãô"
                Case 9: f_SajuStr = "ìó"
                Case 10: f_SajuStr = "Í¤"
                Case Else: f_SajuStr = "??"
            End Select
        Case Ji
            Select Case in_strNum
                Case 1: f_SajuStr = "í­"
                Case 2: f_SajuStr = "õä"
                Case 3: f_SajuStr = "ìÙ"
                Case 4: f_SajuStr = "ÙÖ"
                Case 5: f_SajuStr = "òã"
                Case 6: f_SajuStr = "ŞÓ"
                Case 7: f_SajuStr = "çí"
                Case 8: f_SajuStr = "Ú±"
                Case 9: f_SajuStr = "ãé"
                Case 10: f_SajuStr = "ë·"
                Case 11: f_SajuStr = "âù"
                Case 12: f_SajuStr = "ú¤"
                Case Else: f_SajuStr = "??"
            End Select
        Case Number
            Select Case in_strNum 'ÇÑÀÚ ¼ıÀÚ¸¦ Ç¥ÇöÇÒ °æ¿ì
                Case 0: f_SajuStr = "00"
                Case 1: f_SajuStr = "ìé"
                Case 2: f_SajuStr = "ì£"
                Case 3: f_SajuStr = "ß²"
                Case 4: f_SajuStr = "ŞÌ"
                Case 5: f_SajuStr = "çé"
                Case 6: f_SajuStr = "ë»"
                Case 7: f_SajuStr = "öÒ"
                Case 8: f_SajuStr = "ø¢"
                Case 9: f_SajuStr = "Îú"
                Case 10: f_SajuStr = "ä¨"
                Case 100: f_SajuStr = "Ûİ"
                Case Else: f_SajuStr = "??"
            End Select
        Case SipSung '»çÁÖ ½Ê¼ºÀ» Ç¥½ÃÇÒ °æ¿ì
            Select Case in_strNum
                Case 1: f_SajuStr = "İïÌ·"
                Case 2: f_SajuStr = "Ì¤î¯"
                Case 3: f_SajuStr = "ãİãó"
                Case 4: f_SajuStr = "ß¿Î¯"
                Case 5: f_SajuStr = "ø·î¯"
                Case 6: f_SajuStr = "ïáî¯"
                Case 7: f_SajuStr = "ø·Î¯"
                Case 8: f_SajuStr = "ïáÎ¯"
                Case 9: f_SajuStr = "ø·ìÔ"
                Case 10: f_SajuStr = "ïáìÔ"
                Case Else: f_SajuStr = "??"
            End Select
        Case g_YukChin '±â¹® À°Ä£ÀÎ °æ¿ì
            Select Case in_strNum
                Case 0, 1: f_SajuStr = "á¦"
                Case 2: f_SajuStr = "úü"
                Case 3, 4: f_SajuStr = "áİ"
                Case 5, 6: f_SajuStr = "î¯"
                Case 7: f_SajuStr = "Ğ¡"
                Case 8: f_SajuStr = "Î¯"
                Case 9, 10: f_SajuStr = "İ«"
                Case Else: f_SajuStr = "??"
            End Select
        Case Div1 ' Àı±âÀÎ °æ¿ì
            Select Case in_strNum
                Case 1: f_SajuStr = "á³"
                Case 2: f_SajuStr = "ÓŞ"
                Case 3: f_SajuStr = "í¡"
                Case 4: f_SajuStr = "éë"
                Case 5: f_SajuStr = "Ìó"
                Case 6: f_SajuStr = "õğ"
                Case 7: f_SajuStr = "ôè"
                Case 8: f_SajuStr = "ÍÚ"
                Case 9: f_SajuStr = "í¡"
                Case 10: f_SajuStr = "á³"
                Case 11: f_SajuStr = "ØÓ"
                Case 12: f_SajuStr = "ù¾"
                Case 13: f_SajuStr = "á³"
                Case 14: f_SajuStr = "ÓŞ"
                Case 15: f_SajuStr = "í¡"
                Case 16: f_SajuStr = "ô¥"
                Case 17: f_SajuStr = "ÛÜ"
                Case 18: f_SajuStr = "õÕ"
                Case 19: f_SajuStr = "ùÎ"
                Case 20: f_SajuStr = "ßÜ"
                Case 21: f_SajuStr = "í¡"
                Case 22: f_SajuStr = "á³"
                Case 23: f_SajuStr = "ÓŞ"
                Case 24: f_SajuStr = "ÔÏ"
                Case Else: f_SajuStr = "??"
            End Select
        Case Div2 ' Àı±âÀÎ °æ¿ì
            Select Case in_strNum
                Case 1: f_SajuStr = "ùÎ"
                Case 2: f_SajuStr = "ùÎ"
                Case 3: f_SajuStr = "õğ"
                Case 4: f_SajuStr = "â©"
                Case 5: f_SajuStr = "öŞ"
                Case 6: f_SajuStr = "İÂ"
                Case 7: f_SajuStr = "Ù¥"
                Case 8: f_SajuStr = "éë"
                Case 9: f_SajuStr = "ù¾"
                Case 10: f_SajuStr = "Ø»"
                Case 11: f_SajuStr = "ğú"
                Case 12: f_SajuStr = "ò¸"
                Case 13: f_SajuStr = "ßş"
                Case 14: f_SajuStr = "ßş"
                Case 15: f_SajuStr = "õÕ"
                Case 16: f_SajuStr = "ßş"
                Case 17: f_SajuStr = "ÖÚ"
                Case 18: f_SajuStr = "İÂ"
                Case 19: f_SajuStr = "ÖÚ"
                Case 20: f_SajuStr = "Ë½"
                Case 21: f_SajuStr = "ÔÏ"
                Case 22: f_SajuStr = "àä"
                Case 23: f_SajuStr = "àä"
                Case 24: f_SajuStr = "ò¸"
                Case Else: f_SajuStr = "??"
            End Select
        Case Div ' Àı±âÀÎ °æ¿ì
            Select Case in_strNum
                Case 1: f_SajuStr = "á³ùÎ"
                Case 2: f_SajuStr = "ÓŞùÎ"
                Case 3: f_SajuStr = "í¡õğ"
                Case 4: f_SajuStr = "éëâ©"
                Case 5: f_SajuStr = "ÌóöŞ"
                Case 6: f_SajuStr = "õğİÂ"
                Case 7: f_SajuStr = "ôèÙ¥"
                Case 8: f_SajuStr = "ÍÚéë"
                Case 9: f_SajuStr = "í¡ù¾"
                Case 10: f_SajuStr = "á³Ø»"
                Case 11: f_SajuStr = "ØÓğú"
                Case 12: f_SajuStr = "ù¾ò¸"
                Case 13: f_SajuStr = "á³ßş"
                Case 14: f_SajuStr = "ÓŞßş"
                Case 15: f_SajuStr = "í¡õÕ"
                Case 16: f_SajuStr = "ô¥ßş"
                Case 17: f_SajuStr = "ÛÜÖÚ"
                Case 18: f_SajuStr = "õÕİÂ"
                Case 19: f_SajuStr = "ùÎÖÚ"
                Case 20: f_SajuStr = "ßÜË½"
                Case 21: f_SajuStr = "í¡ÔÏ"
                Case 22: f_SajuStr = "á³àä"
                Case 23: f_SajuStr = "ÓŞàä"
                Case 24: f_SajuStr = "ÔÏò¸"
                Case Else: f_SajuStr = "??"
            End Select
        Case yukeui
            Select Case in_strNum
                Case 1: f_SajuStr = "Ùæ"
                Case 2: f_SajuStr = "Ğù"
                Case 3: f_SajuStr = "ÌÒ"
                Case 4: f_SajuStr = "ãô"
                Case 5: f_SajuStr = "ìó"
                Case 6: f_SajuStr = "Í¤"
                Case 7: f_SajuStr = "ïË"
                Case 8: f_SajuStr = "Ü°"
                Case 9: f_SajuStr = "ëà"
                Case Else: f_SajuStr = "??"
            End Select
        Case PalGwae1
            'Select Case in_strNum
            '    Case 1: f_SajuStr = "ßæÑ¨"
            '    Case 2: f_SajuStr = "ô¸ëñ"
            '    Case 3: f_SajuStr = "ï¾ô÷"
            '    Case 4: f_SajuStr = "ë´ûë"
            '    Case 5: f_SajuStr = "ü¡úª"
            '    Case 6: f_SajuStr = "ÜØÓì"
            '    Case 7: f_SajuStr = "ï¾Ù¤"
            '    Case 8: f_SajuStr = "Ïıûë"
            'End Select
            Select Case in_strNum
                Case 1: f_SajuStr = "ßæ"
                Case 2: f_SajuStr = "ô¸"
                Case 3: f_SajuStr = "ï¾"
                Case 4: f_SajuStr = "ë´"
                Case 5: f_SajuStr = "ü¡"
                Case 6: f_SajuStr = "ÜØ"
                Case 7: f_SajuStr = "ï¾"
                Case 8: f_SajuStr = "Ïı"
                Case Else: f_SajuStr = "??"
            End Select
        Case PalGwae2
            Select Case in_strNum
                Case 1: f_SajuStr = "Ñ¨"
                Case 2: f_SajuStr = "ëñ"
                Case 3: f_SajuStr = "ô÷"
                Case 4: f_SajuStr = "ûë"
                Case 5: f_SajuStr = "úª"
                Case 6: f_SajuStr = "Óì"
                Case 7: f_SajuStr = "Ù¤"
                Case 8: f_SajuStr = "ûë"
                Case Else: f_SajuStr = "??"
            End Select
        Case PalMun1
            'Select Case in_strNum
            '    Case 1: f_SajuStr = "ßæÚ¦"
            '    Case 2: f_SajuStr = "ß¿Ú¦"
            '    Case 3: f_SajuStr = "ÔáÚ¦"
            '    Case 4: f_SajuStr = "ÌØÚ¦"
            '    Case 5: f_SajuStr = "ŞİÚ¦"
            '    Case 6: f_SajuStr = "ÌóÚ¦"
            '    Case 7: f_SajuStr = "ËÒÚ¦"
            '    Case 8: f_SajuStr = "ıÌÚ¦"
            'End Select
            Select Case in_strNum
                Case 1: f_SajuStr = "ßæ"
                Case 2: f_SajuStr = "ß¿"
                Case 3: f_SajuStr = "Ôá"
                Case 4: f_SajuStr = "ÌØ"
                Case 5: f_SajuStr = "Şİ"
                Case 6: f_SajuStr = "Ìó"
                Case 7: f_SajuStr = "ËÒ"
                Case 8: f_SajuStr = "ıÌ"
                Case Else: f_SajuStr = "??"
            End Select
        Case PalMun2
            f_SajuStr = "Ú¦"
        Case TaeEul1
            'Select Case in_strNum
            '    Case 1: f_SajuStr = "÷¼ëà"
            '    Case 2: f_SajuStr = "àîğ«"
            '    Case 3: f_SajuStr = "úÍê¿"
            '    Case 4: f_SajuStr = "ôıèô"
            '    Case 5: f_SajuStr = "ô¸İ¬"
            '    Case 6: f_SajuStr = "ôìéÌ"
            '    Case 7: f_SajuStr = "ùàò®"
            '    Case 8: f_SajuStr = "÷¼ëä"
            '    Case 9: f_SajuStr = "ô¸ëà"
            'End Select
            Select Case in_strNum
                Case 1: f_SajuStr = "÷¼"
                Case 2: f_SajuStr = "àî"
                Case 3: f_SajuStr = "úÍ"
                Case 4: f_SajuStr = "ôı"
                Case 5: f_SajuStr = "ô¸"
                Case 6: f_SajuStr = "ôì"
                Case 7: f_SajuStr = "ùà"
                Case 8: f_SajuStr = "÷¼"
                Case 9: f_SajuStr = "ô¸"
                Case Else: f_SajuStr = "??"
            End Select
        Case TaeEul2
            Select Case in_strNum
                Case 1: f_SajuStr = "ëà"
                Case 2: f_SajuStr = "ğ«"
                Case 3: f_SajuStr = "ê¿"
                Case 4: f_SajuStr = "èô"
                Case 5: f_SajuStr = "İ¬"
                Case 6: f_SajuStr = "éÌ"
                Case 7: f_SajuStr = "ò®"
                Case 8: f_SajuStr = "ëä"
                Case 9: f_SajuStr = "ëà"
                Case Else: f_SajuStr = "??"
            End Select
        Case jikbu1
'            Select Case in_strNum
'                Case 1, -1: f_SajuStr = "òÁİ¬"
'                Case 2, -2: f_SajuStr = "ÔùŞï"
'                Case 3, -3: f_SajuStr = "÷¼ëä"
'                Case 4, -4: f_SajuStr = "ë»ùê"
'                Case 5: f_SajuStr = "Ï£òç"
'                Case -5: f_SajuStr = "ÛÜûÛ"
'                Case 6: f_SajuStr = "ñ¹íÍ"
'                Case -6: f_SajuStr = "úÜÙë"
'                Case 7, -7: f_SajuStr = "Îúò¢"
'                Case 8, -8: f_SajuStr = "Îúô¸"
'                Case Else: f_SajuStr = "??"
'            End Select
            Select Case in_strNum
                Case 1, -1: f_SajuStr = "òÁ"
                Case 2, -2: f_SajuStr = "Ôù"
                Case 3, -3: f_SajuStr = "÷¼"
                Case 4, -4: f_SajuStr = "ë»"
                Case 5: f_SajuStr = "Ï£"
                Case -5: f_SajuStr = "ÛÜ"
                Case 6: f_SajuStr = "ñ¹"
                Case -6: f_SajuStr = "úÜ"
                Case 7, -7: f_SajuStr = "Îú"
                Case 8, -8: f_SajuStr = "Îú"
                Case Else: f_SajuStr = "??"
            End Select
        Case jikbu2
            Select Case in_strNum
                Case 1, -1: f_SajuStr = "İ¬"
                Case 2, -2: f_SajuStr = "Şï"
                Case 3, -3: f_SajuStr = "ëä"
                Case 4, -4: f_SajuStr = "ùê"
                Case 5: f_SajuStr = "òç"
                Case -5: f_SajuStr = "ûÛ"
                Case 6: f_SajuStr = "íÍ"
                Case -6: f_SajuStr = "Ùë"
                Case 7, -7: f_SajuStr = "ò¢"
                Case 8, -8: f_SajuStr = "ô¸"
                Case Else: f_SajuStr = "??"
            End Select
        Case chunbong1: f_SajuStr = "ô¸"
        Case chunbong2
            Select Case in_strNum
                Case 1: f_SajuStr = "Üï"
                Case 2: f_SajuStr = "ìò"
                Case 3: f_SajuStr = "õø"
                Case 4: f_SajuStr = "ÜĞ"
                Case 5: f_SajuStr = "çÈ"
                Case 6: f_SajuStr = "çÜ"
                Case 7: f_SajuStr = "ñº"
                Case 8: f_SajuStr = "ãı"
                Case Else: f_SajuStr = "??"
            End Select
        Case SamWon_name
            Select Case in_strNum
                Case 0: f_SajuStr = "ß¾"
                Case 1: f_SajuStr = "ñé"
                Case 2: f_SajuStr = "ù»"
                Case Else: f_SajuStr = "??"
            End Select
        Case EumYang_name
            Select Case ((in_strNum) Mod 2)
                Case 1: f_SajuStr = "åÕ" 'È¦¼öÀÎ °æ¿ì ¾ç
                Case 0: f_SajuStr = "ëä" 'Â¦¼öÀÎ °æ¿ì À½
                Case Else: f_SajuStr = "??"
            End Select
        Case Han_sex
            Select Case ((in_strNum) Mod 2)
                Case 1: f_SajuStr = "Ëë" 'È¦¼öÀÎ °æ¿ì ¾ç
                Case 0: f_SajuStr = "ÍŞ" 'Â¦¼öÀÎ °æ¿ì À½
                Case Else: f_SajuStr = "??"
            End Select
        Case Ohaeng
            Select Case in_strNum
                Case 1, 2: f_SajuStr = "ÙÊ" 'È¦¼öÀÎ °æ¿ì ¾ç
                Case 3, 4: f_SajuStr = "ûı" 'Â¦¼öÀÎ °æ¿ì À½
                Case 5, 6: f_SajuStr = "÷Ï" 'Â¦¼öÀÎ °æ¿ì À½
                Case 7, 8: f_SajuStr = "Ğİ" 'Â¦¼öÀÎ °æ¿ì À½
                Case 9, 10: f_SajuStr = "â©" 'Â¦¼öÀÎ °æ¿ì À½
                Case Else: f_SajuStr = "??"
            End Select
        Case Else: f_SajuStr = "ER"
    End Select
    Exit Function
End Function



