Attribute VB_Name = "cal_Gimun"
Type t_GuGung ' 구궁 data table
    Chun As Integer '천반수
    Ji As Integer '지반수
    YukChin As Integer '육친
    Yuk_Chun As Integer '육의천반
    Yuk_Ji As Integer '육의지반
    PalGwae As Integer '팔괘
    PalMun As Integer '팔문
    TaeEul As Integer '태을구성
    JikBu As Integer '직부
    ChunBong As Integer '천봉
    Yun_Gung As Integer '년
    Wol_Gung As Integer '월
    Si_Gung As Integer '시
    GongMang As Integer '공망
    SeGung As Integer '세년
    IlMa As Integer '일마
    SeMa As Integer '세마
End Type
Global GUNG(0 To 9) As t_GuGung '구궁내용 저장
Global GUNG_NAME As String

Private g_Sun_Po(1 To 9) As Integer '낙서수 순포내용 저장
Private g_Yuk_Po(1 To 9) As Integer '낙서수 역포내용 저장

Function f_Cal_SamWon(in_GapJa60 As Integer) As Integer '3원 구하기
    f_Cal_SamWon = CInt(((in_GapJa60 - 1) \ 5) Mod 3)
    Exit Function '0 : 상원, 1: 중원, 2: 하원
End Function

Function f_Cal_SamWonSu(in_GapJa60 As Integer) As Integer '3원수 구하기 ex) 상원 1일
    Dim i_ret As Integer
    
    i_ret = CInt((in_GapJa60) Mod 5)
    If i_ret = 0 Then i_ret = 5
    f_Cal_SamWonSu = i_ret
    Exit Function '0 : 상원, 1: 중원, 2: 하원
End Function

Function f_Cal_GDiv24(in_date As Date) As Integer '기문 절기 구하기, 초신접기 이용
    Dim gimunDIV(0 To 50) As Date
    Dim d_pre_yun As Date '이전절기 윤국
    Dim i_pre_yy, i_pre_div As Integer '윤국의 년도, 윤국의 절기번호
    Dim i_today_yy, i_Today_div As Integer '현재날짜의 년도, 현재날짜의 절기번호
    Dim i_dec_Div, r_dec_RDiv As Integer
    Dim i_dec_Day As Integer
    Dim i_tmp_Sam, i_tmp_SamSu As Integer
    Dim i_cnt As Integer '
    Dim i_F As Boolean
    Dim d_tmp_div As Date
    gimunDIV(0) = gDIV(1907, 23)
    gimunDIV(1) = gDIV(1910, 23):  gimunDIV(2) = gDIV(1913, 11)
    gimunDIV(3) = gDIV(1916, 11):  gimunDIV(4) = gDIV(1919, 11)
    gimunDIV(5) = gDIV(1922, 11):  gimunDIV(6) = gDIV(1924, 23)
    gimunDIV(7) = gDIV(1927, 23):  gimunDIV(8) = gDIV(1930, 23)
    gimunDIV(9) = gDIV(1933, 11):  gimunDIV(10) = gDIV(1936, 11)
    gimunDIV(11) = gDIV(1939, 11): gimunDIV(12) = gDIV(1941, 23)
    gimunDIV(13) = gDIV(1944, 23): gimunDIV(14) = gDIV(1947, 23)
    gimunDIV(15) = gDIV(1950, 11): gimunDIV(16) = gDIV(1953, 11)
    gimunDIV(17) = gDIV(1956, 11): gimunDIV(18) = gDIV(1959, 11)
    gimunDIV(19) = gDIV(1962, 11): gimunDIV(20) = gDIV(1964, 23)
    gimunDIV(21) = gDIV(1967, 23): gimunDIV(22) = gDIV(1970, 23)
    gimunDIV(23) = gDIV(1973, 11): gimunDIV(24) = gDIV(1976, 11)
    gimunDIV(25) = gDIV(1979, 11): gimunDIV(26) = gDIV(1981, 23)
    gimunDIV(27) = gDIV(1984, 23): gimunDIV(28) = gDIV(1987, 23)
    gimunDIV(29) = gDIV(1990, 11): gimunDIV(30) = gDIV(1993, 11)
    gimunDIV(31) = gDIV(1996, 11): gimunDIV(32) = gDIV(1999, 11)
    gimunDIV(33) = gDIV(2001, 23): gimunDIV(34) = gDIV(2004, 23)
    gimunDIV(35) = gDIV(2007, 23): gimunDIV(36) = gDIV(2010, 23)
    gimunDIV(37) = gDIV(2013, 23): gimunDIV(38) = gDIV(2016, 11)
    gimunDIV(39) = gDIV(2019, 23): gimunDIV(40) = gDIV(2021, 11)
    gimunDIV(41) = gDIV(2024, 23): gimunDIV(42) = gDIV(2027, 23)
    gimunDIV(43) = gDIV(2030, 23): gimunDIV(44) = gDIV(2033, 23)
    gimunDIV(45) = gDIV(2036, 11): gimunDIV(46) = gDIV(2039, 11)
    gimunDIV(47) = gDIV(2041, 23): gimunDIV(48) = gDIV(2044, 23)
    gimunDIV(49) = gDIV(2047, 23): gimunDIV(50) = gDIV(2050, 23)
    
    For i_cnt = 1 To 50 Step 1
        If in_date <= gimunDIV(i_cnt) Then
            d_pre_yun = gimunDIV(i_cnt - 1)
            Exit For
        End If
    Next i_cnt '윤국일자 지정
    
    i_F = False
    i_cnt = 0
    d_tmp_div = d_pre_yun
    d_tmp_num = fi_Pre_Div24(d_tmp_div)
    Do
        d_tmp_num = d_tmp_num + i_cnt
        d_tmp_yy = Year(d_tmp_div)
        If d_tmp_num >= 25 Then '1년동안의 정수기를 구한다.
            d_tmp_num = 1
            d_tmp_yy = d_tmp_yy + 1
        End If
        d_tmp_div = gDIV(d_tmp_yy, d_tmp_num)
        i_tmp_Sam = f_Cal_SamWon(f_Cal_GapJa60(f_cal_Il_Gan((d_tmp_div)), f_cal_Il_Ji((d_tmp_div))))
        If i_tmp_Sam = 0 Then
            d_jungsugi = d_tmp_div
            Exit Do
        'i_tmp_SamSu = f_Cal_SamWon(f_Cal_GapJa60(f_cal_il_gan(in_date), f_cal_il_ji(in_date)))
        End If
        i_cnt = i_cnt + 1
    Loop Until i_F = True
    
    If d_tmp_div > in_date Then '접기에 해당하면 해당 절기를 return
        f_Cal_GDiv24 = fi_Pre_Div24(in_date)
    Else '초신에 해당하면 만약 후반부 상원인 경우 +1을 return, 초반부 상원인 경우 그냥 return
        Dim d_julgi As Date
        Dim d_sang_1 As Date
        Dim i_ret_divnum As Integer
        d_julgi = f_Pre_Div24(in_date) + 1
        d_sang_1 = in_date - (f_Cal_SamWon(f_Cal_GapJa60(f_cal_Il_Gan((in_date)), f_cal_Il_Ji((in_date)))) * 5 _
                + f_Cal_SamWonSu(f_Cal_GapJa60(f_cal_Il_Gan((in_date)), f_cal_Il_Ji((in_date)))) - 1)
        If d_julgi < d_sang_1 Then
            i_ret_divnum = fi_Pre_Div24(in_date) + 1
            If i_ret_divnum > 24 Then i_ret_divnum = 1
            f_Cal_GDiv24 = i_ret_divnum
        Else
            f_Cal_GDiv24 = fi_Pre_Div24(in_date)
        End If
    End If
        
    Exit Function '1 ~ 24 값 return
End Function

Function f_Cal_EumYangDun(in_date As Date) As Integer
    Dim i_div As Integer
    i_div = f_Cal_GDiv24(in_date)
    Select Case i_div
        Case 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 24: f_Cal_EumYangDun = 1
        Case 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23: f_Cal_EumYangDun = 2
    End Select
    Exit Function '1:양둔, 2:음둔
End Function


Function f_Cal_SuRiOhaeng(in_Suri As Integer) As Integer '수리오행을 천간번호로 바꾸기
    Select Case in_Suri
        Case 1: f_Cal_SuRiOhaeng = 9 '1:壬
        Case 6: f_Cal_SuRiOhaeng = 10 '6:癸
        Case 2: f_Cal_SuRiOhaeng = 4 '2:丁
        Case 7: f_Cal_SuRiOhaeng = 3 '7:丙
        Case 3: f_Cal_SuRiOhaeng = 1 '3:甲
        Case 8: f_Cal_SuRiOhaeng = 2 '8:乙
        Case 4: f_Cal_SuRiOhaeng = 8 '4:辛
        Case 9: f_Cal_SuRiOhaeng = 7 '9:庚
        Case 5: f_Cal_SuRiOhaeng = 5 '5:戊
        Case 10: f_Cal_SuRiOhaeng = 6 '10:己
        Case Else: f_Cal_SuRiOhaeng = -1
    End Select
    Exit Function
End Function

Private Sub init_PoGuk() 'g_Sun_Po, g_Yuk_Po memory load
    g_Sun_Po(1) = 4: g_Sun_Po(2) = 9: g_Sun_Po(3) = 2
    g_Sun_Po(4) = 3: g_Sun_Po(5) = 5: g_Sun_Po(6) = 7
    g_Sun_Po(7) = 8: g_Sun_Po(8) = 1: g_Sun_Po(9) = 6
    g_Yuk_Po(1) = -4: g_Yuk_Po(2) = -9: g_Yuk_Po(3) = -2
    g_Yuk_Po(4) = -3: g_Yuk_Po(5) = -5: g_Yuk_Po(6) = -7
    g_Yuk_Po(7) = -8: g_Yuk_Po(8) = -1: g_Yuk_Po(9) = -6
    Exit Sub '낙서수 memory로 저장
End Sub


Sub p_ChunJi_Po() '천지반 포국, 세궁, 육친 저장
' 반드시 saju, palja 변수에 내용이 있어야만 사용이 가능하다.
    Dim i_Chun, i_Ji As Integer
    Dim i_cnt, i_cnt2 As Integer
    Dim i_my As Integer
    Dim i_taGan As Integer
    Dim g_SeGung As Integer ' 세궁의 구궁번호 저장
    If IsNumeric(SAJU(4)) = False Then
        MsgBox "포국 시작할 시간이 없습니다. ", vbOKOnly, "ERROR"
    End If
    
    i_Chun = (PALJA(1) + PALJA(3) + PALJA(5) + PALJA(7)) Mod 9
    If i_Chun = 0 Then
        i_Chun = 9
    End If
    
    i_Ji = (PALJA(2) + PALJA(4) + PALJA(6) + PALJA(8)) Mod 9
    If i_Ji = 0 Then
        i_Ji = 9
    End If
    
    Call init_PoGuk ' 포국 순서를 우선 부른다.
    
    GUNG(0).Chun = i_Chun ' 천반의 경우 역포하고
    GUNG(0).Ji = i_Ji '지반의 경우 순포한다.
    For i_cnt = 1 To 9 Step 1
        GUNG(i_cnt).Chun = (GUNG(0).Chun + g_Yuk_Po(i_cnt)) Mod 10
        GUNG(i_cnt).Ji = (GUNG(0).Ji + g_Sun_Po(i_cnt)) Mod 10
        If GUNG(i_cnt).Chun <= 0 Then
            GUNG(i_cnt).Chun = GUNG(i_cnt).Chun + 10
        End If
        If GUNG(i_cnt).Ji = 0 Then
            GUNG(i_cnt).Ji = GUNG(i_cnt).Ji + 10
        End If
    Next i_cnt ' 천지반 포국 완료
    GUNG(5).Chun = GUNG(0).Chun
    GUNG(5).Ji = i_Ji
    
    ' 세궁 및 육친 선택
    Select Case PALJA(6)
        Case 1: g_SeGung = 8
        Case 2, 3: g_SeGung = 7
        Case 4: g_SeGung = 4
        Case 5, 6: g_SeGung = 1
        Case 7: g_SeGung = 2
        Case 8, 9: g_SeGung = 3
        Case 10: g_SeGung = 6
        Case 11, 12: g_SeGung = 9
    End Select
    i_my = f_Cal_SuRiOhaeng(GUNG(g_SeGung).Ji)
    i_cnt2 = 1
    For i_cnt2 = 1 To 9 Step 1 '육친 포국
        i_taGan = f_Cal_SuRiOhaeng(GUNG(i_cnt2).Ji)
        GUNG(i_cnt2).YukChin = CInt(f_Cal_SipSung(i_my, i_taGan))
    Next i_cnt2 '육친 포국 완료
    Exit Sub
End Sub


Sub p_YukEui_po() '육의삼기 포국
    Dim i_SamWon As Integer
    Dim i_GDiv As Integer
    Dim i_EumYang As Integer
    Dim arr_JungGuk(1 To 24, 1 To 3) As Integer
    Dim i_JungGuk As Integer
    Dim i_cnt, i_tmp As Integer
    Dim i_BuDu As Integer
    Dim i_Save_Gon As Integer
    Dim ip_Budu, ip_Sigan, ip_Chaei As Integer
    Dim arr_BuduNum(1 To 10) As Integer  '부두 순서
    Dim arr_Gung_Num(1 To 9) As Integer '궁 순서
    Dim arr_Num_Gung(1 To 9) As Integer '궁 순서
    
    arr_BuduNum(1) = 0: arr_BuduNum(2) = 9: arr_BuduNum(3) = 8
    arr_BuduNum(4) = 7: arr_BuduNum(5) = 1: arr_BuduNum(6) = 2
    arr_BuduNum(7) = 3: arr_BuduNum(8) = 4: arr_BuduNum(9) = 5: arr_BuduNum(10) = 6
    
    arr_Gung_Num(1) = 1: arr_Gung_Num(2) = 2: arr_Gung_Num(3) = 3
    arr_Gung_Num(4) = 8: arr_Gung_Num(5) = 0: arr_Gung_Num(6) = 4
    arr_Gung_Num(7) = 7: arr_Gung_Num(8) = 6: arr_Gung_Num(9) = 5
    arr_Num_Gung(1) = 1: arr_Num_Gung(2) = 2: arr_Num_Gung(3) = 3
    arr_Num_Gung(4) = 6: arr_Num_Gung(5) = 9: arr_Num_Gung(6) = 8
    arr_Num_Gung(7) = 7: arr_Num_Gung(8) = 4: arr_Num_Gung(9) = 0
    i_SamWon = f_Cal_SamWon(SAJU(3))
    i_GDiv = f_Cal_GDiv24((BIRTHDAY))
    i_EumYang = f_Cal_EumYangDun(BIRTHDAY)
    

    '육의지반 포국 : 국수(arr_jungguk) - 기문절기+삼원수, 음양둔 구분(i_eumyang)
    arr_JungGuk(1, 1) = 2: arr_JungGuk(1, 2) = 8: arr_JungGuk(1, 3) = 5
    arr_JungGuk(2, 1) = 3: arr_JungGuk(2, 2) = 9: arr_JungGuk(2, 3) = 6
    arr_JungGuk(3, 1) = 8: arr_JungGuk(3, 2) = 5: arr_JungGuk(3, 3) = 2
    arr_JungGuk(4, 1) = 9: arr_JungGuk(4, 2) = 6: arr_JungGuk(4, 3) = 3
    arr_JungGuk(5, 1) = 1: arr_JungGuk(5, 2) = 7: arr_JungGuk(5, 3) = 4
    arr_JungGuk(6, 1) = 3: arr_JungGuk(6, 2) = 9: arr_JungGuk(6, 3) = 6
    arr_JungGuk(7, 1) = 4: arr_JungGuk(7, 2) = 1: arr_JungGuk(7, 3) = 7
    arr_JungGuk(8, 1) = 5: arr_JungGuk(8, 2) = 2: arr_JungGuk(8, 3) = 8
    arr_JungGuk(9, 1) = 4: arr_JungGuk(9, 2) = 1: arr_JungGuk(9, 3) = 7
    arr_JungGuk(10, 1) = 5: arr_JungGuk(10, 2) = 2: arr_JungGuk(10, 3) = 8
    arr_JungGuk(11, 1) = 6: arr_JungGuk(11, 2) = 3: arr_JungGuk(11, 3) = 9
    arr_JungGuk(12, 1) = 9: arr_JungGuk(12, 2) = 3: arr_JungGuk(12, 3) = 6
    arr_JungGuk(13, 1) = 8: arr_JungGuk(13, 2) = 2: arr_JungGuk(13, 3) = 5
    arr_JungGuk(14, 1) = 7: arr_JungGuk(14, 2) = 1: arr_JungGuk(14, 3) = 4
    arr_JungGuk(15, 1) = 2: arr_JungGuk(15, 2) = 5: arr_JungGuk(15, 3) = 8
    arr_JungGuk(16, 1) = 1: arr_JungGuk(16, 2) = 4: arr_JungGuk(16, 3) = 7
    arr_JungGuk(17, 1) = 9: arr_JungGuk(17, 2) = 3: arr_JungGuk(17, 3) = 6
    arr_JungGuk(18, 1) = 7: arr_JungGuk(18, 2) = 1: arr_JungGuk(18, 3) = 4
    arr_JungGuk(19, 1) = 6: arr_JungGuk(19, 2) = 9: arr_JungGuk(19, 3) = 3
    arr_JungGuk(20, 1) = 5: arr_JungGuk(20, 2) = 8: arr_JungGuk(20, 3) = 2
    arr_JungGuk(21, 1) = 6: arr_JungGuk(21, 2) = 9: arr_JungGuk(21, 3) = 3
    arr_JungGuk(22, 1) = 5: arr_JungGuk(22, 2) = 8: arr_JungGuk(22, 3) = 2
    arr_JungGuk(23, 1) = 4: arr_JungGuk(23, 2) = 7: arr_JungGuk(23, 3) = 1
    arr_JungGuk(24, 1) = 1: arr_JungGuk(24, 2) = 7: arr_JungGuk(24, 3) = 4 '음양이둔정국표 참조
    
    i_JungGuk = arr_JungGuk(i_GDiv, i_SamWon + 1)
    
    GUNG_NAME = fSS(i_GDiv, Div) & " " & fSS(i_SamWon, SamWon_name) & "元  " _
              & fSS(i_EumYang, EumYang_name) & " " & i_JungGuk & "局"
    
    Call init_PoGuk ' 포국 순서를 우선 부른다.
    GUNG(0).Yuk_Ji = i_JungGuk
    For i_cnt = 1 To 9 Step 1
        If i_EumYang = 1 Then '양국일 경우 ' err
            GUNG(i_cnt).Yuk_Ji = (3 - i_JungGuk + g_Sun_Po(i_cnt) + 7) Mod 9
            If GUNG(i_cnt).Yuk_Ji <= 0 Then
                GUNG(i_cnt).Yuk_Ji = GUNG(i_cnt).Yuk_Ji + 9
            End If
        Else '음국일 경우
            GUNG(i_cnt).Yuk_Ji = (GUNG(0).Yuk_Ji + g_Yuk_Po(i_cnt) + 9 + 1) Mod 9
            If GUNG(i_cnt).Yuk_Ji <= 0 Then
                GUNG(i_cnt).Yuk_Ji = GUNG(i_cnt).Yuk_Ji + 9
            End If
        End If
    Next i_cnt '육의지반 포국완료
    
    '육의천반 포국 - 시간, 시주의 순중부두
    '천반 포국시 예외사항 :
    ' 1.1 시간이 갑시인 경우 : 육의천반 = 육의지반
    ' 1.2 부두와 시간이 같은경우 : 육의천반 = 육의지반
    ' 2. 시간이 육의지반 중궁과 같은경우 :
    ' 3. 부두가 육의지반 중궁과 같은경우 :
    ' 모두 아닌 경우 계산에 의하여 포국
    Select Case (SAJU(4) - 1) \ 10
        Case 0: i_BuDu = 1 '戊 5
        Case 1: i_BuDu = 2 '己 6
        Case 2: i_BuDu = 3 '庚 7
        Case 3: i_BuDu = 4 '辛 8
        Case 4: i_BuDu = 5 '壬 9
        Case 5: i_BuDu = 6 '癸10
    End Select
    If (i_BuDu + 4 = PALJA(7)) Or (PALJA(7) = 1) Then
        For i_cnt = 1 To 9 Step 1
            GUNG(i_cnt).Yuk_Chun = GUNG(i_cnt).Yuk_Ji
        Next i_cnt
        Exit Sub
    End If '복음국 포국
    i_Save_Gon = -1
    If i_BuDu = GUNG(5).Yuk_Ji Then
        i_Save_Gon = GUNG(3).Yuk_Ji
        GUNG(3).Yuk_Ji = GUNG(5).Yuk_Ji
    End If
    If arr_BuduNum(PALJA(7)) = GUNG(5).Yuk_Ji Then
        i_Save_Gon = GUNG(3).Yuk_Ji
        GUNG(3).Yuk_Ji = GUNG(5).Yuk_Ji
    End If
    'ip_Budu:지반 중 부두와 같은 궁번호
    'ip_Sgan:지반 중 시간과 같은 궁번호
    'ip_ChaEi
    ip_Budu = 0
    ip_Sigan = 0
    For i_cnt = 1 To 9 Step 1
        If i_cnt <> 5 Then
            If GUNG(i_cnt).Yuk_Ji = i_BuDu Then
                ip_Budu = i_cnt
            End If
            If GUNG(i_cnt).Yuk_Ji = arr_BuduNum(PALJA(7)) Then
                ip_Sigan = i_cnt
            End If
        End If
    Next i_cnt
    If ip_Budu = 0 Or ip_Sigan = 0 Then MsgBox "육의천반 계산시 오류발생", vbOKOnly, "Error"
    'ip_Chaei = (8 + arr_Gung_Num(ip_Sigan) - arr_Gung_Num(ip_Budu)) Mod 8
    ip_Chaei = (8 - arr_Gung_Num(ip_Sigan) + arr_Gung_Num(ip_Budu)) Mod 8
    For i_cnt = 1 To 9 Step 1
        i_tmp = (i_cnt + ip_Chaei) Mod 8
        If i_tmp = 0 Then i_tmp = 8
        GUNG(arr_Num_Gung(i_cnt)).Yuk_Chun = GUNG(arr_Num_Gung(i_tmp)).Yuk_Ji
'        i_tmp = GUNG(arr_Num_Gung(i_cnt + ip_Chaei)).Yuk_Ji
'        GUNG(i_cnt).Yuk_Chun = i_tmp
    Next i_cnt
    If i_Save_Gon <> -1 Then
        GUNG(3).Yuk_Ji = i_Save_Gon
    End If
    Exit Sub
End Sub

Sub p_PalGwae_Po() '팔괘 포국, 천지반 작성 후 실행
    Select Case GUNG(5).Ji
        Case 1
            GUNG(1).PalGwae = 1: GUNG(2).PalGwae = 3: GUNG(3).PalGwae = 7
            GUNG(4).PalGwae = 6: GUNG(5).PalGwae = 0: GUNG(6).PalGwae = 5
            GUNG(7).PalGwae = 2: GUNG(8).PalGwae = 8: GUNG(9).PalGwae = 4
        Case 2
            GUNG(1).PalGwae = 2: GUNG(2).PalGwae = 4: GUNG(3).PalGwae = 8
            GUNG(4).PalGwae = 5: GUNG(5).PalGwae = 0: GUNG(6).PalGwae = 6
            GUNG(7).PalGwae = 1: GUNG(8).PalGwae = 7: GUNG(9).PalGwae = 3
        Case 3
            GUNG(1).PalGwae = 3: GUNG(2).PalGwae = 1: GUNG(3).PalGwae = 5
            GUNG(4).PalGwae = 8: GUNG(5).PalGwae = 0: GUNG(6).PalGwae = 7
            GUNG(7).PalGwae = 4: GUNG(8).PalGwae = 6: GUNG(9).PalGwae = 2
        Case 4, 5
            GUNG(1).PalGwae = 8: GUNG(2).PalGwae = 6: GUNG(3).PalGwae = 2
            GUNG(4).PalGwae = 3: GUNG(5).PalGwae = 0: GUNG(6).PalGwae = 4
            GUNG(7).PalGwae = 7: GUNG(8).PalGwae = 1: GUNG(9).PalGwae = 5
        Case 6
            GUNG(1).PalGwae = 5: GUNG(2).PalGwae = 7: GUNG(3).PalGwae = 3
            GUNG(4).PalGwae = 2: GUNG(5).PalGwae = 0: GUNG(6).PalGwae = 1
            GUNG(7).PalGwae = 6: GUNG(8).PalGwae = 4: GUNG(9).PalGwae = 8
        Case 7
            GUNG(1).PalGwae = 4: GUNG(2).PalGwae = 2: GUNG(3).PalGwae = 6
            GUNG(4).PalGwae = 7: GUNG(5).PalGwae = 0: GUNG(6).PalGwae = 8
            GUNG(7).PalGwae = 3: GUNG(8).PalGwae = 5: GUNG(9).PalGwae = 1
        Case 8
            GUNG(1).PalGwae = 7: GUNG(2).PalGwae = 5: GUNG(3).PalGwae = 1
            GUNG(4).PalGwae = 4: GUNG(5).PalGwae = 0: GUNG(6).PalGwae = 3
            GUNG(7).PalGwae = 8: GUNG(8).PalGwae = 2: GUNG(9).PalGwae = 6
        Case 9
            GUNG(1).PalGwae = 6: GUNG(2).PalGwae = 8: GUNG(3).PalGwae = 4
            GUNG(4).PalGwae = 1: GUNG(5).PalGwae = 0: GUNG(6).PalGwae = 2
            GUNG(7).PalGwae = 5: GUNG(8).PalGwae = 3: GUNG(9).PalGwae = 7
        End Select
End Sub

Sub p_PalMun_Po()
    Dim arr_SMun(1 To 8) As Integer '팔문진행 순방향
    Dim arr_YMun(1 To 8) As Integer '팔문진행 역방향
    Dim i_EumYang As Integer
    Dim i_begin As Integer
    Dim i_cnt As Integer
    Dim i_idx As Integer
    
    arr_SMun(1) = 7: arr_SMun(2) = 6: arr_SMun(3) = 1:
    arr_SMun(4) = 2: arr_SMun(5) = 8: arr_SMun(6) = 9:
    arr_SMun(7) = 4: arr_SMun(8) = 3:
    arr_YMun(1) = 7: arr_YMun(2) = 3: arr_YMun(3) = 4:
    arr_YMun(4) = 9: arr_YMun(5) = 8: arr_YMun(6) = 2:
    arr_YMun(7) = 1: arr_YMun(8) = 6:
    
    i_EumYang = f_Cal_EumYangDun(BIRTHDAY)
    i_begin = SAJU(3)
    i_begin = (((SAJU(3) - 1) \ 3) + 1) Mod 8
    If i_begin = 0 Then i_begin = 8
    For i_cnt = 1 To 8 Step 1
        i_idx = (i_cnt - 1 + i_begin) Mod 8
        If i_idx = 0 Then i_idx = 8
        If i_EumYang = 1 Then '양국은 순포
            GUNG(arr_SMun(i_idx)).PalMun = i_cnt
        Else '음국은 역포
            GUNG(arr_YMun(i_idx)).PalMun = i_cnt
        End If
    Next i_cnt
    Exit Sub
End Sub

Sub p_TaeEul_po()
    Dim arr_STae(1 To 9) As Integer
    Dim arr_YTae(1 To 9) As Integer
    Dim i_EumYang As Integer
    Dim i_cnt, i_begin As Integer
    
    arr_STae(1) = 7: arr_STae(2) = 2: arr_STae(3) = 8
    arr_STae(4) = 3: arr_STae(5) = 4: arr_STae(6) = 1
    arr_STae(7) = 5: arr_STae(8) = 9: arr_STae(9) = 6
    arr_YTae(1) = 3: arr_YTae(2) = 8: arr_YTae(3) = 2
    arr_YTae(4) = 7: arr_YTae(5) = 6: arr_YTae(6) = 9
    arr_YTae(7) = 5: arr_YTae(8) = 1: arr_YTae(9) = 4
    
    i_EumYang = f_Cal_EumYangDun(BIRTHDAY)
    i_begin = SAJU(3)
    i_begin = SAJU(3) Mod 9
    If i_begin = 0 Then i_begin = 9
    For i_cnt = 1 To 9 Step 1
    i_idx = (i_cnt - 1 + i_begin) Mod 9
    If i_idx = 0 Then i_idx = 9
    If i_EumYang = 1 Then '양국은 순포
        GUNG(arr_STae(i_idx)).TaeEul = i_cnt
    Else
        GUNG(arr_YTae(i_idx)).TaeEul = i_cnt
    End If
    Next i_cnt
    Exit Sub
End Sub
Sub p_JikBu_po()
    Dim arr_Gung_Num(1 To 9) As Integer '궁 순서
    Dim arr_Num_Gung(1 To 9) As Integer '궁 순서
    Dim i As Integer
    Dim begin As Integer '직부 시작지점 : 시간과 같은 육의지반이 속한 궁
    Dim jik_num As Integer
    Dim si_gan As Integer
    Dim i_EumYang As Integer
    
    si_gan = PALJA(7)
    If si_gan = 1 Then '갑시인 경우 시의 부두를 사용
        Select Case (SAJU(4) - 1) \ 10
            Case 0: si_gan = 5 '戊 5
            Case 1: si_gan = 6 '己 6
            Case 2: si_gan = 7 '庚 7
            Case 3: si_gan = 8 '辛 8
            Case 4: si_gan = 9 '壬 9
            Case 5: si_gan = 10 '癸10
        End Select
    End If
    
    arr_Gung_Num(1) = 1: arr_Gung_Num(2) = 2: arr_Gung_Num(3) = 3
    arr_Gung_Num(4) = 8: arr_Gung_Num(5) = 0: arr_Gung_Num(6) = 4
    arr_Gung_Num(7) = 7: arr_Gung_Num(8) = 6: arr_Gung_Num(9) = 5
    arr_Num_Gung(1) = 1: arr_Num_Gung(2) = 2: arr_Num_Gung(3) = 3
    arr_Num_Gung(4) = 6: arr_Num_Gung(5) = 9: arr_Num_Gung(6) = 8
    arr_Num_Gung(7) = 7: arr_Num_Gung(8) = 4: arr_Num_Gung(9) = 0

    For i = 1 To 9
        If f_SajuStr(si_gan, Gan) = f_SajuStr(GUNG(i).Yuk_Ji, yukeui) Then
            begin = i
        End If
    Next i '시간이 속한 궁번호를 찾음
    If begin = 5 Then begin = 3 '중궁과 같은 경우 감궁으로 뺀다.
    i_EumYang = f_Cal_EumYangDun(BIRTHDAY)
    If i_EumYang = 1 Then '양국인 경우 순포
        begin = arr_Gung_Num(begin)
        For i = 1 To 8
            jik_num = (begin + (i - 1)) Mod 8
            If jik_num <= 0 Then jik_num = jik_num + 8
            GUNG(arr_Num_Gung(jik_num)).JikBu = i
        Next i
    Else '음국인 경우 역포
        begin = arr_Gung_Num(begin)
        For i = 1 To 8
            jik_num = (begin - (i - 1)) Mod 8
            If jik_num <= 0 Then jik_num = jik_num + 8
            GUNG(arr_Num_Gung(jik_num)).JikBu = i * (-1)
        Next i
    End If
End Sub

Sub p_ChunBong_po()
    Dim arr_Gung_Num(1 To 9) As Integer '궁 순서
    Dim arr_Num_Gung(1 To 9) As Integer '궁 순서
    Dim arr_BuduNum(1 To 10) As Integer
    Dim i As Integer
    Dim begin As Integer '직부 시작지점 : 시간과 같은 육의지반이 속한 궁
    Dim BeginChun As Integer
    Dim jik_num As Integer
    Dim si_gan As Integer
    Dim chun_tmp As Integer
    
    Select Case (SAJU(4) - 1) \ 10
        Case 0: si_gan = 1 '戊 5
        Case 1: si_gan = 2 '己 6
        Case 2: si_gan = 3 '庚 7
        Case 3: si_gan = 4 '辛 8
        Case 4: si_gan = 5 '壬 9
        Case 5: si_gan = 6 '癸10
    End Select

    
    arr_Gung_Num(1) = 1: arr_Gung_Num(2) = 2: arr_Gung_Num(3) = 3
    arr_Gung_Num(4) = 8: arr_Gung_Num(5) = 0: arr_Gung_Num(6) = 4
    arr_Gung_Num(7) = 7: arr_Gung_Num(8) = 6: arr_Gung_Num(9) = 5
    arr_Num_Gung(1) = 1: arr_Num_Gung(2) = 2: arr_Num_Gung(3) = 3
    arr_Num_Gung(4) = 6: arr_Num_Gung(5) = 9: arr_Num_Gung(6) = 8
    arr_Num_Gung(7) = 7: arr_Num_Gung(8) = 4: arr_Num_Gung(9) = 0
    arr_BuduNum(1) = si_gan: arr_BuduNum(2) = 9: arr_BuduNum(3) = 8
    arr_BuduNum(4) = 7: arr_BuduNum(5) = 1: arr_BuduNum(6) = 2
    arr_BuduNum(7) = 3: arr_BuduNum(8) = 4: arr_BuduNum(9) = 5: arr_BuduNum(10) = 6


    For i = 1 To 9
        If si_gan = GUNG(i).Yuk_Ji Then
            begin = i
        End If
    Next i
    If begin = 5 Then begin = 3 '중궁과 같은 경우 감궁으로 뺀다.
    BeginChun = arr_Gung_Num(begin) + 3
    If BeginChun > 8 Then BeginChun = BeginChun - 8
    For i = 1 To 9
        If arr_BuduNum(PALJA(7)) = GUNG(i).Yuk_Ji Then
            begin = i
        End If
    Next i '시간의 육의번호와 육의지반이 같은 궁을 찾는다.
    If begin = 5 Then begin = 3 '중궁과 같은 경우 감궁으로 뺀다.
    begin = arr_Gung_Num(begin)
    For i = 1 To 8
        jik_num = (begin + (i - 1)) Mod 8
        If jik_num <= 0 Then jik_num = jik_num + 8
        
        chun_tmp = (i - 1 + BeginChun) Mod 8
        If chun_tmp <= 0 Then chun_tmp = chun_tmp + 8

        GUNG(arr_Num_Gung(jik_num)).ChunBong = chun_tmp
    Next i
End Sub
Sub p_Else_Po()
    Dim i_gong As Integer
    Dim i As Integer
    Dim i_IlMa As Integer
    Dim i_SeMa As Integer
'년, 월, 시궁, 공망, 세년, 일마, 역마 표시
'    Yun_Gung As Integer
'    Wol_Gung As Integer
'    Si_Gung As Integer
'    GongMang As Integer
'    SeGung As Integer
'    IlMa As Integer
'    SeMa As Integer
    For i = 1 To 9
        GUNG(i).Yun_Gung = 0
        GUNG(i).Wol_Gung = 0
        GUNG(i).Si_Gung = 0
        GUNG(i).GongMang = 0
        GUNG(i).IlMa = 0
        GUNG(i).SeMa = 0
    Next i
    Select Case PALJA(2) '년궁
        Case 1: GUNG(8).Yun_Gung = 1
        Case 2, 3: GUNG(7).Yun_Gung = 1
        Case 4: GUNG(4).Yun_Gung = 1
        Case 5, 6: GUNG(1).Yun_Gung = 1
        Case 7: GUNG(2).Yun_Gung = 1
        Case 8, 9: GUNG(3).Yun_Gung = 1
        Case 10: GUNG(6).Yun_Gung = 1
        Case 11, 12: GUNG(9).Yun_Gung = 1
    End Select
    Select Case PALJA(4) '월궁
        Case 1: GUNG(8).Wol_Gung = 1
        Case 2, 3: GUNG(7).Wol_Gung = 1
        Case 4: GUNG(4).Wol_Gung = 1
        Case 5, 6: GUNG(1).Wol_Gung = 1
        Case 7: GUNG(2).Wol_Gung = 1
        Case 8, 9: GUNG(3).Wol_Gung = 1
        Case 10: GUNG(6).Wol_Gung = 1
        Case 11, 12: GUNG(9).Wol_Gung = 1
    End Select
    Select Case PALJA(8) '시궁
        Case 1: GUNG(8).Si_Gung = 1
        Case 2, 3: GUNG(7).Si_Gung = 1
        Case 4: GUNG(4).Si_Gung = 1
        Case 5, 6: GUNG(1).Si_Gung = 1
        Case 7: GUNG(2).Si_Gung = 1
        Case 8, 9: GUNG(3).Si_Gung = 1
        Case 10: GUNG(6).Si_Gung = 1
        Case 11, 12: GUNG(9).Si_Gung = 1
    End Select
    i_gong = (SAJU(3) - 1) \ 10
    Select Case i_gong '공망
        Case 0: GUNG(9).GongMang = 1 '갑자시두 술해공망
        Case 1: GUNG(3).GongMang = 1: GUNG(6).GongMang = 1 '갑술시두 신유공망
        Case 2: GUNG(2).GongMang = 1: GUNG(3).GongMang = 1 '갑신시두 오미공망
        Case 3: GUNG(1).GongMang = 1 '갑오시두 진사공망
        Case 4: GUNG(7).GongMang = 1: GUNG(4).GongMang = 1 '갑진시두 인묘공망
        Case 5: GUNG(8).GongMang = 1: GUNG(7).GongMang = 1 '갑인시두 자축공망
    End Select
    Select Case PALJA(6) '일마
        Case 1, 5, 9: i_IlMa = 3 '신자진 인
        Case 2, 6, 10: i_IlMa = 6 '사유축 해
        Case 3, 7, 11: i_IlMa = 9 '인오술 신
        Case 4, 8, 12: i_IlMa = 2 '해묘미 사
    End Select
    Select Case PALJA(2) '세마
        Case 1, 5, 9: i_SeMa = 3
        Case 2, 6, 10: i_SeMa = 6
        Case 3, 7, 11: i_SeMa = 9
        Case 4, 8, 12: i_SeMa = 2
    End Select
    For i = 1 To 9
        If GUNG(i).Ji = i_SeMa Then
            GUNG(i).SeMa = 1
        End If
        If GUNG(i).Ji = i_IlMa Then
            GUNG(i).IlMa = 1
        End If
    Next i
End Sub

Public Function fGS(inG As Integer, in_Line As Integer) As String
    Select Case in_Line
        Case 1
            If GUNG(inG).Yun_Gung = 1 And GUNG(inG).Wol_Gung = 1 And GUNG(inG).Si_Gung = 1 Then
               fGS = "年月時"
            End If
            If GUNG(inG).Yun_Gung = 1 And GUNG(inG).Wol_Gung = 1 And GUNG(inG).Si_Gung <> 1 Then
               fGS = "年月　"
            End If
            If GUNG(inG).Yun_Gung = 1 And GUNG(inG).Wol_Gung <> 1 And GUNG(inG).Si_Gung = 1 Then
               fGS = "年時　"
            End If
            If GUNG(inG).Yun_Gung = 1 And GUNG(inG).Wol_Gung <> 1 And GUNG(inG).Si_Gung <> 1 Then
               fGS = "年　　"
            End If
            If GUNG(inG).Yun_Gung <> 1 And GUNG(inG).Wol_Gung = 1 And GUNG(inG).Si_Gung = 1 Then
               fGS = "月時　"
            End If
            If GUNG(inG).Yun_Gung <> 1 And GUNG(inG).Wol_Gung = 1 And GUNG(inG).Si_Gung <> 1 Then
               fGS = "月　　"
            End If
            If GUNG(inG).Yun_Gung <> 1 And GUNG(inG).Wol_Gung <> 1 And GUNG(inG).Si_Gung = 1 Then
               fGS = "時　　"
            End If
            If GUNG(inG).Yun_Gung <> 1 And GUNG(inG).Wol_Gung <> 1 And GUNG(inG).Si_Gung <> 1 Then
               fGS = "　　　"
            End If
        Case 2
            If GUNG(inG).GongMang = 1 Then
                fGS = "　空　"
            Else
                fGS = "　　　"
            End If
        Case 3
            If GUNG(inG).SeMa = 1 And GUNG(inG).IlMa = 1 Then
                fGS = "歲日"
            End If
            If GUNG(inG).SeMa = 1 And GUNG(inG).IlMa <> 1 Then
                fGS = "歲　"
            End If
            If GUNG(inG).SeMa <> 1 And GUNG(inG).IlMa = 1 Then
                fGS = "日　"
            End If
            If GUNG(inG).SeMa <> 1 And GUNG(inG).IlMa <> 1 Then
                fGS = "　　"
            End If
        Case 4
            If GUNG(inG).SeMa = 1 And GUNG(inG).IlMa = 1 Then
                fGS = "馬馬"
            End If
            If GUNG(inG).SeMa = 1 And GUNG(inG).IlMa <> 1 Then
                fGS = "馬　"
            End If
            If GUNG(inG).SeMa <> 1 And GUNG(inG).IlMa = 1 Then
                fGS = "馬　"
            End If
            If GUNG(inG).SeMa <> 1 And GUNG(inG).IlMa <> 1 Then
                fGS = "　　"
            End If
    End Select
End Function

