Attribute VB_Name = "mDate"
Option Explicit

'24절기: the  divisions of the year :div24
'  24절기 순서: 1월 1일부터 12월 31일까지
'  1. 小寒: 1월 6일, 2. 大寒: 1월 20일, 3. 立春: 2월 4일, 4. 雨水: 2월 19일,
'  5. 驚蟄: 3월 6일, 6. 春分: 3월 21일, 7. 淸明: 4월 5일, 8. 穀雨: 4월 20일,
'  9. 立夏: 5월 6일, 10.小瀟: 5월 21일,11.芒種: 6월 6일, 12.夏至: 6월 22일,
'  13.所暑: 7월 7일, 14.大署: 7월 23일,15.立秋: 8월 8일, 16.處署: 8월 23일,
'  17.白露: 9월 8일, 18.秋分: 9월 23일,19.寒露:10월 9일, 20.霜降:10월 24일,
'  21.立冬:11월 8일, 22.小雪:11월 23일,23.大雪:12월 7일, 24.冬至:12월 22일
'24절기 처리 순서 :
'OPTION 1 :
'  계산값 기준으로 24절기 처리
'  1년 = 525948.75 .=' 525948분 45초? .=' 8765시 48분 45초?
'  실지 사용한 seed값 :
'  기준점 : 2000년 소한 (2000.1.5 15:49 (무진일))
'  기준점에서 평균 절입 시간을 반영하여 24절기를 계산
'  평균 절입시 까지 경과시간 :
'  1 = TIMESERIAL(0,0,0)    :2 = TIMESERIAL(353,20,0)
'  3 = TIMESERIAL(707,36,0) :4 = TIMESERIAL(1063,31,0)
'  5 = TIMESERIAL(1421,39,0):6 = TIMESERIAL(1782,34,0)
'  7 = TIMESERIAL(2146,31,0):8 = TIMESERIAL(2513,42,0)
'  9 = TIMESERIAL(2883,54,0):10= TIMESERIAL(3256,54,0)
'  11= TIMESERIAL(3632,07,0):12= TIMESERIAL(4008,53,0)
'  13= TIMESERIAL(4386,24,0):14= TIMESERIAL(4763,46,0)
'  15= TIMESERIAL(5140,11,0):16= TIMESERIAL(5514,48,0)
'  17= TIMESERIAL(5887,03,0):18= TIMESERIAL(6256,24,0)
'  19= TIMESERIAL(6622,39,0):20= TIMESERIAL(6985,41,0)
'  21= TIMESERIAL(7345,46,0):22= TIMESERIAL(7703,12,0)
'  23= TIMESERIAL(8058,36,0):24= TIMESERIAL(8412,31,0)
'OPTION 2 :
'  계산값 기준으로 24절기 처리 후 FILE에서 24절기 DATA 읽음
'  FILE 읽을 때 같이 읽을 정보 :
'    (1). 24절기 입력 기간FROM, TO
'    (2). 읽을 FILE 이 존재하는지 여부
'    (3). 읽을 FILE 의 DATA가 합당한지 여부'모든 DATA에 대해서 CHECK
'         CHECK 방법 : 계산값과의 차이가 48시간 이상인 경우 ERROR

Global Const CY_MIN As Integer = 1881
Global Const CY_MAX As Integer = 2050
Global Const CY_NUM As Integer = CY_MAX - CY_MIN
Global gDIV(CY_MIN To CY_MAX, 1 To 24) As Date '계산 24절기

Private mstLTBL(0 To CY_NUM) As String '음양력 변환 table
Private miDT(0 To CY_NUM) As Integer '음양력 계산에서 내부사용 변수
Private miLDAY(0 To 11) As Integer
Private mgDIV_INTERVAL(1 To 24) As Date
Private Type fdiv24_in
    YearNo As String * 4
    DivNo As String * 3
    in_date As String * 24
    cr_lf As String * 2
End Type

Dim div24_in As fdiv24_in
Function init_gDIV(Optional f_name As String = "ERR", _
                Optional load_from As Date, _
                Optional load_to As Date)
    On Error GoTo init_gDIV_ERR
    Dim f_LoadErr As Boolean
    Dim i_from As Date
    Dim i_to As Date
        
    i_from = load_from
    i_to = load_to
    If f_name = "ERR" Then
        Call init_gDIV_Cal
        init_gDIV = True
        Exit Function
    Else
        Call init_gDIV_Cal
        f_LoadErr = init_gDIV_Load(f_name, i_from, i_to)
        load_from = i_from: load_to = i_to
        If f_LoadErr = False Then GoTo init_gDIV_ERR
    End If
    init_gDIV = True
    Exit Function
init_gDIV_ERR:
    Call init_gDIV_Cal
    init_gDIV = False
    Exit Function
End Function

Private Sub init_gDIV_Cal()
    mgDIV_INTERVAL(1) = TimeSerial(0, 0, 0)
    mgDIV_INTERVAL(2) = TimeSerial(353, 20, 0)
    mgDIV_INTERVAL(3) = TimeSerial(707, 36, 0)
    mgDIV_INTERVAL(4) = TimeSerial(1063, 31, 0)
    mgDIV_INTERVAL(5) = TimeSerial(1421, 39, 0)
    mgDIV_INTERVAL(6) = TimeSerial(1782, 34, 0)
    mgDIV_INTERVAL(7) = TimeSerial(2146, 31, 0)
    mgDIV_INTERVAL(8) = TimeSerial(2513, 42, 0)
    mgDIV_INTERVAL(9) = TimeSerial(2883, 54, 0)
    mgDIV_INTERVAL(10) = TimeSerial(3256, 54, 0)
    mgDIV_INTERVAL(11) = TimeSerial(3632, 7, 0)
    mgDIV_INTERVAL(12) = TimeSerial(4008, 53, 0)
    mgDIV_INTERVAL(13) = TimeSerial(4386, 24, 0)
    mgDIV_INTERVAL(14) = TimeSerial(4763, 46, 0)
    mgDIV_INTERVAL(15) = TimeSerial(5140, 11, 0)
    mgDIV_INTERVAL(16) = TimeSerial(5514, 48, 0)
    mgDIV_INTERVAL(17) = TimeSerial(5887, 3, 0)
    mgDIV_INTERVAL(18) = TimeSerial(6256, 24, 0)
    mgDIV_INTERVAL(19) = TimeSerial(6622, 39, 0)
    mgDIV_INTERVAL(20) = TimeSerial(6985, 41, 0)
    mgDIV_INTERVAL(21) = TimeSerial(7345, 46, 0)
    mgDIV_INTERVAL(22) = TimeSerial(7703, 12, 0)
    mgDIV_INTERVAL(23) = TimeSerial(8058, 36, 0)
    mgDIV_INTERVAL(24) = TimeSerial(8412, 31, 0)

    Dim d_date As Date
    Dim seed As Date
    Dim result As Date
    Dim i, j, i_year, iy_k As Integer
    Dim d_tmp As Date
    Dim iDEBUG As Integer
    Dim dDEBUG As Date

'  기준점 : 2000년 소한 (2000.1.6 10:00 (계해일))
    i = 0
    j = 1
    i_year = CY_MIN
    iy_k = 2000
    seed = TimeSerial(8765, 49, 35)
    d_date = DateSerial(iy_k, 1, 6) + TimeSerial(10, 0, 0)
    For i = 0 To CY_NUM Step 1
        
        iDEBUG = ((i_year + i) - iy_k)
        dDEBUG = seed * ((i_year + i) - iy_k)
        d_tmp = d_date + (seed * ((i_year + i) - iy_k))
        For j = 1 To 24 Step 1
            gDIV(i + CY_MIN, j) = d_tmp + mgDIV_INTERVAL(j)
        Next j
    Next i
End Sub

Private Function init_gDIV_Load(f_name As String, load_from As Date, load_to As Date) As Boolean
On Error GoTo fdiv_load_err
    Dim f_buf As String
    Dim t_i, t_j As Integer
    Dim t_date As Date
    Dim f_Begin_Flag As Boolean
    Dim s_from, s_to As String
    
    f_Begin_Flag = True
    
    Open f_name For Input As #1
    Do While Not EOF(1)
        Line Input #1, f_buf
        t_i = CInt(Val(Mid(f_buf, 1, 4)))
        t_j = CInt(Val(Mid(f_buf, 5, 3)))
        t_date = CDate(Mid(f_buf, 8, Len(f_buf) - 8))
        If f_Begin_Flag = True Then
            load_from = t_date
        End If
        f_Begin_Flag = False
        load_to = t_date
        If t_i <= CY_MIN Or t_i >= CY_MAX Or t_j <= 0 Or t_j >= 25 Then
            init_gDIV_Load = False
            Exit Function
        End If
        gDIV(t_i, t_j) = t_date
    Loop
    Close #1
    
    init_gDIV_Load = True
    Exit Function
fdiv_load_err:
    init_gDIV_Load = False
End Function

Private Function init_gDIV_Save(f_name As String)
On Error GoTo fDIV_Save_ERR
    Dim i, j As Integer
    
    div24_in.YearNo = 0
    div24_in.DivNo = 1
    div24_in.in_date = gDIV(1, 1)
    div24_in.cr_lf = vbCrLf
    
    Open f_name For Random As #1 Len = Len(div24_in)

    For i = 0 To 100
        For j = 1 To 24 Step 1
            div24_in.YearNo = (i + CY_MIN)
            div24_in.DivNo = j
            div24_in.in_date = gDIV(i, j)
            div24_in.cr_lf = vbCrLf
            Put #1, (i - 1) * 24 + j, div24_in
        Next j
    Next i
    Close #1
    init_gDIV_Save = True
fDIV_Save_ERR:
    init_gDIV_Save = False
End Function

Function fi_Pre_Div24(in_date As Date) As Integer
    Dim yyyy As Integer
    Dim wol_cnt As Integer
        
    yyyy = Year(in_date)
    If gDIV(yyyy, 1) > in_date Then '만일 일자가 1월 6일보다 작으면
        fi_Pre_Div24 = 24
         Exit Function
    End If
    
    wol_cnt = 1
    Do While wol_cnt < 25   ' Inner loop.
        If gDIV(yyyy, wol_cnt) > in_date Then
            fi_Pre_Div24 = CInt(wol_cnt - 1)
            Exit Function
        End If
        wol_cnt = wol_cnt + 1
    Loop
    If gDIV(yyyy, 24) < in_date Then ' 만일 일자가 12월 24일보다 크면 금년 제일 큰 절기를 반환한다.
        fi_Pre_Div24 = 24
         Exit Function
    End If
    Exit Function
End Function

Function f_Pre_Div24(in_date As Date) As Date
    Dim yyyy As Integer
    Dim wol_cnt As Integer
   
    yyyy = Year(in_date)
    If gDIV(yyyy, 1) > in_date Then '만일 일자가 1월 6일보다 작으면
        f_Pre_Div24 = gDIV(yyyy - 1, 24) '전년도 12월 제일 큰 절기를 반환한다.
         Exit Function
    End If
    wol_cnt = 1
    Do While wol_cnt < 25   ' Inner loop.
        If gDIV(yyyy, wol_cnt) > in_date Then
            wol_cnt = wol_cnt - 1
            f_Pre_Div24 = gDIV(yyyy, wol_cnt)
            Exit Function
        End If
        wol_cnt = wol_cnt + 1
    Loop
    If gDIV(yyyy, 24) < in_date Then ' 만일 일자가 12월 24일보다 크면 금년 제일 큰 절기를 반환한다.
        f_Pre_Div24 = gDIV(yyyy, 24)  '전년도 12월 제일 큰 절기를 반환한다.
        Exit Function
    End If
    Exit Function
End Function

Function f_Next_Div24(in_date As Date) As Date
    Dim wh_cnt As Integer
    Dim wh_yy As Integer
    
    wh_yy = 0
    wh_cnt = fi_Pre_Div24(in_date)
    If wh_cnt = 0 Then
        f_Next_Div24 = gDIV(Year(in_date), 1)
    Else
        If wh_cnt > 23 Then
            If in_date > gDIV(Year(in_date), 24) Then '만약 24절기가 전년도 이면
                f_Next_Div24 = gDIV(Year(in_date) + 1, 1) '다음해 절기로 표기함
                Exit Function
            Else: f_Next_Div24 = gDIV(Year(in_date), 1)
            End If
        Else
            f_Next_Div24 = gDIV(Year(in_date), wh_cnt + 1)
        End If
    End If

End Function

Function gs_Init_Lunar(f_name As String) As Boolean
On Error GoTo init_LTBL_ERR
    Dim f_buf As String
    Dim t_y As Integer
    Dim t_str As String
    Dim i As Integer
    
    i = 0
    Open f_name For Input As #1
    Do While Not EOF(1)
        Line Input #1, f_buf
        t_y = CInt(Val(Mid(f_buf, 1, 4)))
        t_str = Mid(f_buf, 6, 13)
        mstLTBL(i) = t_str
        i = i + 1
        If i > CY_NUM Then Exit Do
    Loop
    Close #1
    miLDAY(0) = 31:    miLDAY(1) = 0:    miLDAY(2) = 31:    miLDAY(3) = 30
    miLDAY(4) = 31:    miLDAY(5) = 30:   miLDAY(6) = 31:    miLDAY(7) = 31
    miLDAY(8) = 30:    miLDAY(9) = 31:   miLDAY(10) = 30:   miLDAY(11) = 31
    gs_Init_Lunar = True
    Exit Function
init_LTBL_ERR:
    gs_Init_Lunar = False
End Function

Function gf_Is_Yun(gf_Year As Integer, gf_Month As Integer) As Boolean
    On Error GoTo Is_Yun_END
    Dim TD As Long
    Dim M1 As Integer

    If gf_Year <= CY_MIN Or gf_Year >= CY_MAX Then
       gf_Is_Yun = False
       Exit Function
    End If '년수가 해당일자를 넘는 경우 false
    If gf_Month + 1 > 13 Then
       gf_Is_Yun = False
       Exit Function
    End If '달수가 13이 넘는 경우 false
    M1 = gf_Year - CY_MIN
    If Val(Mid(mstLTBL(M1), 13, 1)) = 0 Then '윤달이 없는 해임
        gf_Is_Yun = False
        Exit Function
    Else
        If Val(Mid(mstLTBL(M1), gf_Month + 1, 1)) > 2 Then
            gf_Is_Yun = True
            Exit Function
        Else
            gf_Is_Yun = False
            Exit Function
        End If
    End If
    Exit Function
Is_Yun_END:
    gf_Is_Yun = False
    Exit Function
End Function

Function gf_Lun2Sun(gf_Year As Integer, gf_Month As Integer, gf_Day As Integer, GF_YUN As Boolean) As Boolean
    gf_Lun2Sun = False
    Dim i As Integer
    Dim j As Integer
    Dim M1 As Integer
    Dim M2 As Integer
    Dim N2 As Integer
    Dim W As Integer
    'Dim LEAP As Integer '2월의 28/29일 값
    Dim TD As Long
    Dim Y As Long
    
    Dim SYEAR As Integer
    Dim SMONTH As Integer
    Dim SDAY As Integer
    
    If gf_Is_Yun(gf_Year, gf_Month) = False And GF_YUN = True Then
        gf_Lun2Sun = False
        Exit Function
    End If
    
    
    If gf_Month > 13 Then
        gf_Lun2Sun = False
        Exit Function
    End If
    
   'MsgBox "(음력)=" & gf_Year & "년" & gf_Month & "월" & gf_Day & "일" & "(윤?)" & GF_YUN, vbOKOnly, "유성"
    
    M1 = -1
    TD = 0
    
    If gf_Year > CY_MIN And gf_Year < CY_MAX Then
       M1 = gf_Year - 1882
       For i = 0 To M1
           For j = 1 To 13
              TD = TD + CLng(Val(Mid(mstLTBL(i), j, 1)))
           Next j
       If Val(Mid(mstLTBL(i), 13, 1)) = 0 Then
          TD = TD + 336
       Else
          TD = TD + 362
       End If
       Next i
    Else
        gf_Lun2Sun = False
        Exit Function
    End If
    
    M1 = M1 + 1
    N2 = gf_Month - 1
    M2 = -1
    
    Do
       M2 = M2 + 1
       If Val(Mid(mstLTBL(M1), M2 + 1, 1)) > 2 Then
          TD = TD + 26 + CLng(Val(Mid(mstLTBL(M1), M2 + 1, 1)))
          N2 = N2 + 1
       Else
          If M2 = N2 Then
            If GF_YUN = True Then
                TD = TD + 28 + CLng(Val(Mid(mstLTBL(M1), M2 + 1, 1)))
            End If
            Exit Do
          Else
             TD = TD + 28 + CLng(Val(Mid(mstLTBL(M1), M2 + 1, 1)))
          End If
       End If
     Loop
     
     TD = TD + CLng(gf_Day) + 29
     M1 = 1880
     Do
          M1 = M1 + 1
          If M1 Mod 400 = 0 Or M1 Mod 100 <> 0 And M1 Mod 4 = 0 Then
             'LEAP = 1
             M2 = 366
          Else
             'LEAP = 0
             M2 = 365
          End If

          If TD < CLng(M2) Then
             Exit Do
          End If
          TD = TD - CLng(M2)
     Loop
    
     
     SYEAR = M1
     miLDAY(1) = M2 - 337
     M1 = 0
     
     Do
          M1 = M1 + 1
          If TD <= CLng(miLDAY(M1 - 1)) Then
             Exit Do
          End If
          TD = TD - CLng(miLDAY(M1 - 1))
     Loop
     SMONTH = M1
     SDAY = CInt(TD)
     Y = CLng(SYEAR - 1)
     TD = CLng(Y * 365) + CLng(Y \ 4) - CLng(Y \ 100) + CLng(Y \ 400)
     
     If SYEAR Mod 400 = 0 Or SYEAR Mod 100 <> 0 And SYEAR Mod 4 = 0 Then
        'LEAP = 1
        miLDAY(1) = 29  ' 陽曆 2월은 29일까지임.
     Else
        'LEAP = 0
        miLDAY(1) = 28  ' 陽曆 2월은 28일 까지임
     End If
 
     For i = 0 To SMONTH - 2
         TD = TD + CLng(miLDAY(i))
     Next
     TD = TD + CLng(SDAY)
     W = CInt(TD Mod 7)
     
     gf_Year = SYEAR
     gf_Month = SMONTH
     If SDAY = 0 Then SDAY = 31   '말일계산 例) 陰. 1966.11.20  --> 陽. 1966. 12. 31 <2000.11.6 추가>
     gf_Day = SDAY
     'GF_WEEK = WEEK(W) (by usung73)
     GF_YUN = W
     gf_Lun2Sun = True
     
     'MsgBox "(양력)=" & gf_Year & "년" & gf_Month & "월" & gf_Day & "일" & "(윤?)" & GF_YUN, vbOKOnly, "유성"
     
End Function

Function gf_Sun2Lun(gf_Year As Integer, gf_Month As Integer, gf_Day As Integer, GF_YUN As Boolean) As Boolean
    Dim M1 As Integer
    Dim M2 As Integer
    Dim i As Integer
    Dim j As Integer
    Dim I1 As Integer
    Dim J1 As Integer
    Dim JCOUNT As Integer
    Dim LL As Integer
    Dim W As Integer
    Dim M0 As Integer
    Dim TD As Long
    Dim TD0 As Long
    Dim TD1 As Long
    Dim TD2 As Long
    Dim K11 As Long
    
    If gf_Month > 13 Then
        gf_Sun2Lun = False
        Exit Function
    End If
    
    
'MsgBox "(양력)=" & gf_Year & "년" & gf_Month & "월" & gf_Day & "일" & "(윤?)" & GF_YUN, vbOKOnly, "유성"
    
    GF_YUN = False
    
    For i = 0 To CY_NUM
        miDT(i) = 0
        For j = 1 To 12
            Select Case Val(Mid(mstLTBL(i), j, 1))
               Case 1, 3
                    miDT(i) = miDT(i) + 29
                    
               Case 2, 4
                    miDT(i) = miDT(i) + 30
            End Select
        Next j
        
        Select Case Val(Mid(mstLTBL(i), 13, 1))
               Case 0
               Case 1, 3
                    miDT(i) = miDT(i) + 29
               Case 2, 4
                    miDT(i) = miDT(i) + 30
        End Select
    Next i
    TD1 = CLng(CLng(1880) * CLng(365)) + 1880 \ 4 - 1880 \ 100 + 1880 \ 400 + 30
    K11 = CLng(gf_Year - 1)
    TD2 = K11 * CLng(365) + K11 \ 4 - K11 \ 100 + K11 \ 400
    
    If gf_Year Mod 400 = 0 Or gf_Year Mod 100 <> 0 And gf_Year Mod 4 = 0 Then
        miLDAY(1) = 29
    Else
        miLDAY(1) = 28
    End If
    
    If gf_Day > miLDAY(gf_Month - 1) Then
        gf_Sun2Lun = False
        Exit Function

    End If
    
    For i = 0 To gf_Month - 2
        TD2 = TD2 + CLng(miLDAY(i))
    Next i
    TD2 = TD2 + CLng(gf_Day)
    TD = TD2 - TD1 + 1
    TD0 = CLng(miDT(0))

    For i = 0 To CY_NUM
        If TD <= TD0 Then
           Exit For
        End If
        TD0 = TD0 + CLng(miDT(i + 1))
    Next i
    
    gf_Year = i + CY_MIN
    TD0 = TD0 - CLng(miDT(i))
    TD = TD - TD0
    
    If Val(Mid(mstLTBL(i), 13, 1)) = 0 Then
       JCOUNT = 11
    Else
       JCOUNT = 12
    End If
    M2 = 0
    
    For j = 0 To JCOUNT '달수 check, 윤달 > 2 (by usung73)
        If Val(Mid(mstLTBL(i), j + 1, 1)) <= 2 Then  '(suntolun.dat)가 1,2의 값일 때
            M2 = M2 + 1                              '1+28=29일(작은달) 2+28=30(큰달)
            M1 = Val(Mid(mstLTBL(i), j + 1, 1)) + 28
            GF_YUN = False
            bYun = 0          '평달 표시 전역변수
        Else                                        '(suntolun.dat) 3,4의 값일 때 (윤월)
            M1 = Val(Mid(mstLTBL(i), j + 1, 1)) + 26 '3+26=29일(작은 달) 4+26=30일(큰달)
            GF_YUN = True
            bYun = 1          '윤달 표시 전역변수
        End If
        
        If TD <= CLng(M1) Then
           Exit For
        End If
        TD = TD - CLng(M1)
    Next j
    
    gf_Month = M2
    gf_Day = TD
    gf_Sun2Lun = True
   'MsgBox "(음력)=" & gf_Year & "년" & gf_Month & "월" & gf_Day & "일" & "(윤?)" & GF_YUN, vbOKOnly, "유성"
    
End Function
