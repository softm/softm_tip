#TITLE=해브
#INFO
New Cliptext library
#SORT=n

#T=리스트박스

#T=    대과목
<% out.print(DisplaySelLCD("S", df_lcd, "sub_lcd", "onChange='ChangeCode(0, this.options[this.selectedIndex].value.substring(1,3))'")); %>
#T=    소과목
<% out.print(DisplaySelSCD("S", df_lcd, "01", "01", "sub_scd",""));%>
#T=    중과목
<% out.print(DisplaySelMCD("S", df_lcd, "01", "sub_mcd", "onChange='ChangeCode(1, this.options[this.selectedIndex].value.substring(1,5))'")); %>
#