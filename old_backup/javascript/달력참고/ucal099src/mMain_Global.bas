Attribute VB_Name = "mMain_Global"
'--------------------------------------------------------------------------------
' ���������� ������ҿ� ���� ocx ȭ���� �߰��Ѵ�.
' Microsoft Common Dialog Control 6.0          --> c:\windows\system\comdlg32.ocx
' Microsoft Rich Textbox Control 6.0           --> c:\windows\system\richtx32.ocx
' Microsoft Windows Common Controls 6.0        --> c:\windows\system\mscomctl.ocx
' Microsoft Windows Common Controls-2 5.0(SP2) --> c:\windows\system\comct232.ocx


'���α׷� ����� ����ϴ� ��������
Global gitxt_Result_Use As Integer '������ button ���� ���¸� ����. 0:�ʱⰪ, 1:��, 2:�⹮, 3: ������
' �ð����� ȯ�漳��
Global gsLong As Single '��������
Global giYajaSi As Integer '���ڽ� ��뿩��
Global giSummer As Integer '����Ÿ�� ��뿩��
Global giKTime As Integer '�ѱ�ǥ�ؽð� ���Ⱓ �ݿ�
Global gfDivCal As Boolean '�ð��ɼǿ��� 24���� ��� opt button ����
Global gfDivLoad As Boolean '�ð��ɼǿ��� 24���� ���� opt button ����
Global gstInDivFromTo As String '�ð��ɼǿ��� 24���� ���� �Ⱓ lbl caption

Global GV_sCalendarDate As String           '�޷� ���� ����
Global GV_bCalendarDateSelect As Boolean    '�޷� ���� ����
Global GC_SelColor As Integer   '�޷� Į�� ���� ����
Global bYun As Integer '���� ����
'Global uWeek As Integer '����(1~7 : ��~��)

'Global gstResultFontName As String
'Global giResultFontSize As Integer
'Global gfResultSelBold As Boolean
'Global gfResultSelItalic As Boolean
'Global gfResultSelUnderline As Boolean
'Global gfResultSelStrikeThru As Boolean
'Global fiColorUse As Integer
Sub gp_Save_Option()
    SaveSetting "u_cal", "�ð�����", "���ذ浵", gsLong
    SaveSetting "u_cal", "�ð�����", "���ڽ�", giYajaSi
    SaveSetting "u_cal", "�ð�����", "����Ÿ��", giSummer
    SaveSetting "u_cal", "�ð�����", "�ѱ�ǥ�ؽ�", giKTime
    SaveSetting "u_cal", "�ð�����", "24������", gfDivCal
    SaveSetting "u_cal", "�ð�����", "24��������", gfDivLoad
End Sub
Sub gp_Load_Option()
    Dim settings As Variant
    If GetSetting("u_cal", "�ð�����", "���ذ浵") <> Empty Then
        settings = GetAllSettings("u_cal", "�ð�����")
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
            .SelFontName = "����ü"
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


