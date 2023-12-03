Attribute VB_Name = "mMain_Global"
'--------------------------------------------------------------------------------
' 도구상자의 구성요소에 다음 ocx 화일을 추가한다.
' Microsoft Common Dialog Control 6.0          --> c:\windows\system\comdlg32.ocx
' Microsoft Rich Textbox Control 6.0           --> c:\windows\system\richtx32.ocx
' Microsoft Windows Common Controls 6.0        --> c:\windows\system\mscomctl.ocx
' Microsoft Windows Common Controls-2 5.0(SP2) --> c:\windows\system\comct232.ocx


'프로그램 실행시 사용하는 전역변수
Global gitxt_Result_Use As Integer '마지막 button 누른 상태를 가짐. 0:초기값, 1:명리, 2:기문, 3: 만세력
' 시간관련 환경설정
Global gsLong As Single '현재위도
Global giYajaSi As Integer '야자시 사용여부
Global giSummer As Integer '섬머타임 사용여부
Global giKTime As Integer '한국표준시간 사용기간 반영
Global gfDivCal As Boolean '시간옵션에서 24절기 계산 opt button 상태
Global gfDivLoad As Boolean '시간옵션에서 24절기 읽음 opt button 상태
Global gstInDivFromTo As String '시간옵션에서 24절기 읽은 기간 lbl caption

Global GV_sCalendarDate As String           '달력 변수 선언
Global GV_bCalendarDateSelect As Boolean    '달력 변수 선언
Global GC_SelColor As Integer   '달력 칼라 변수 선언
Global bYun As Integer '윤달 변수
'Global uWeek As Integer '요일(1~7 : 월~일)

'Global gstResultFontName As String
'Global giResultFontSize As Integer
'Global gfResultSelBold As Boolean
'Global gfResultSelItalic As Boolean
'Global gfResultSelUnderline As Boolean
'Global gfResultSelStrikeThru As Boolean
'Global fiColorUse As Integer
Sub gp_Save_Option()
    SaveSetting "u_cal", "시간설정", "기준경도", gsLong
    SaveSetting "u_cal", "시간설정", "야자시", giYajaSi
    SaveSetting "u_cal", "시간설정", "섬머타임", giSummer
    SaveSetting "u_cal", "시간설정", "한국표준시", giKTime
    SaveSetting "u_cal", "시간설정", "24절기계산", gfDivCal
    SaveSetting "u_cal", "시간설정", "24절기읽음", gfDivLoad
End Sub
Sub gp_Load_Option()
    Dim settings As Variant
    If GetSetting("u_cal", "시간설정", "기준경도") <> Empty Then
        settings = GetAllSettings("u_cal", "시간설정")
        gsLong = CSng(settings(0, 1))
        giYajaSi = CInt(settings(1, 1))
        giSummer = CInt(settings(2, 1))
        giKTime = CInt(settings(3, 1))
        gfDivCal = CBool(settings(4, 1))
        gfDivLoad = CBool(settings(5, 1))
    Else
        Call gp_Default_option
        Call gp_Save_Option
    End If
End Sub
Sub gp_Default_option()
    gsLong = 127.5
    giYajaSi = 0
    giSummer = 0
    giKTime = 0
    gfDivCal = True
    gfDivLoad = False
End Sub

Sub gp_Set_Default_Font()
    With US_main.txt_Result
            .SelFontName = "굴림체"
            .SelFontSize = 12
            .SelBold = False
            .SelItalic = False
            .SelUnderline = False
            .SelStrikeThru = False
            .SelColor = vbBlack
    End With
End Sub

Sub gp_Save_Main()
    SaveSetting "u_cal", "Main", "Main_PX", US_main.Top
    SaveSetting "u_cal", "Main", "Main_PY", US_main.Left
    SaveSetting "u_cal", "Main", "BColor", US_main.txt_Result.BackColor
    SaveSetting "u_cal", "Main", "Opt_Sex_Man", US_main.Opt_Sex_Man.Value
    SaveSetting "u_cal", "Main", "Opt_Sex_Woman", US_main.Opt_Sex_Woman.Value
    SaveSetting "u_cal", "Main", "Opt_Cal_Sun", US_main.Opt_Cal_Sun.Value
    SaveSetting "u_cal", "Main", "Opt_Cal_Lun", US_main.Opt_Cal_Lun.Value
    SaveSetting "u_cal", "Main", "Opt_Yun_False", US_main.Opt_Yun_False.Value
    SaveSetting "u_cal", "Main", "Opt_Yun_True", US_main.Opt_Yun_True.Value
    SaveSetting "u_cal", "Main", "txt_Name", US_main.txt_Name.Text
    SaveSetting "u_cal", "Main", "Text1", US_main.Text1.Text
    SaveSetting "u_cal", "Main", "Text2", US_main.Text2.Text
    SaveSetting "u_cal", "Main", "Text3", US_main.Text3.Text
    SaveSetting "u_cal", "Main", "Text4", US_main.Text4.Text
    SaveSetting "u_cal", "Main", "Text5", US_main.Text5.Text
    SaveSetting "u_cal", "Main", "chk_mode", US_main.chk_mode.Value
End Sub
Sub gp_load_Main()

    Dim settings As Variant

    If GetSetting("u_cal", "Main", "Main_Px") <> Empty Then
        settings = GetAllSettings("u_cal", "Main")
        
        US_main.Top = settings(0, 1)
        US_main.Left = settings(1, 1)
        US_main.txt_Result.BackColor = settings(2, 1)
        US_main.Opt_Sex_Man.Value = settings(3, 1)
        US_main.Opt_Sex_Woman.Value = settings(4, 1)
        US_main.Opt_Cal_Sun.Value = settings(5, 1)
        US_main.Opt_Cal_Lun.Value = settings(6, 1)
        US_main.Opt_Yun_False.Value = settings(7, 1)
        US_main.Opt_Yun_True.Value = settings(8, 1)
        US_main.txt_Name.Text = settings(9, 1)
        US_main.Text1.Text = settings(10, 1)
        US_main.Text2.Text = settings(11, 1)
        US_main.Text3.Text = settings(12, 1)
        US_main.Text4.Text = settings(13, 1)
        US_main.Text5.Text = settings(14, 1)
        US_main.chk_mode.Value = settings(15, 1)
    End If
End Sub


