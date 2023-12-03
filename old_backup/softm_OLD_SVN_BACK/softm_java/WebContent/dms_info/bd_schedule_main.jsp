<%
/** 
 * <pre>
 *  설  명 :  의사 일정
 *  작성자 :  김지훈
 *  작성일 :  2012-07-09
 *
 *  기타사항 :
 *  
 * Copyrights 2012 by KOGAS. All right reserved.
 * </pre>
*/
%>
<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>
<%
String a = request.getParameter("a");
int year    =0;
int month   =0;
int day     =0;
int todayYear   =0;
int todayMonth  =0;
int todayDay    =0;
int todayHour    =0;
int todayMin    =0;
List<String[]> dataList  = new ArrayList<String[]>();
List<String[]> dataList2 = new ArrayList<String[]>();
List<String[]> dataList3 = new ArrayList<String[]>();

Calendar cal = new GregorianCalendar();
Calendar today=Calendar.getInstance();
String s_year  = StringUtils.defaultString(request.getParameter("s_year" ));
String s_month = StringUtils.defaultString(request.getParameter("s_month"));
String s_day   = StringUtils.defaultString(request.getParameter("s_day"  ));

year    = Integer.parseInt(!s_year.equals("")?s_year:String.valueOf(today.get(Calendar.YEAR)));
month   = Integer.parseInt(!s_month.equals("")?s_month:String.valueOf(today.get(Calendar.MONTH)+1));
day     = Integer.parseInt(!s_day.equals("")?s_day:String.valueOf(today.get(Calendar.DATE)));

todayYear  = today.get(Calendar.YEAR)   ;
todayMonth = today.get(Calendar.MONTH)+1;
todayDay   = today.get(Calendar.DATE)   ;

todayHour  = today.get(Calendar.HOUR_OF_DAY)   ;
todayMin  = today.get(Calendar.MINUTE)   ;

if (month<=0){
    month = 12;
    year  = year- 1;
} else if (month>=13){
    month = 1;
    year  = year+ 1;
}

cal.set(Calendar.YEAR,year);
cal.set(Calendar.MONTH,(month-1));
cal.set(Calendar.DATE,1);

/*
out.println(" a  : " + a + "<BR>" );
out.println(" year  : " + year + "<BR>" );
out.println(" month : " + String.format("%02d",month)+ "<BR>" );
out.println(" day   : " + day  + "<BR>" );
out.println(" todayYear  : " + todayYear + "<BR>" );
out.println(" todayMonth : " + todayMonth+ "<BR>" );
out.println(" todayDay   : " + todayDay  + "<BR>" );
*/
%>
        <table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
          <tr>
            <td><img src="/images/sp1_title05.gif"></td>
          </tr>

         <tr>
            <td align="right" style="padding-right:5px;"><img src="/images/btn_print.gif"></td>
          </tr>

          <tr>
            <td bgcolor="#ffffff" align="center">
            <!-----------------------------------------  테이블1 시작 --------------------------------------->
            <table width="730" border="0" cellspacing="0" cellpadding="0">
            </table>


<form name="sForm" id="sForm" method="post" onSubmit="return fSearch(0);">
<input type=hidden name=s_year   value='<%=year %>'>
<input type=hidden name=s_month  value='<%=month%>'>
<input type=hidden name=s_day    value='<%=day  %>'>
<input type=hidden name=hour    value='<%=todayHour  %>'>
<input type=hidden name=min    value='<%=todayMin  %>'>
</form>
<table width="730" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40" align="center"><table width="200" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center">
        <a href=# onclick="fSearch(<%=cal.get(Calendar.YEAR)%>,<%=((cal.get(Calendar.MONTH)+1)-1)%>);"><img src="/images/btn_arr_L.gif" width="18" height="18" /></a></td>
        <td align="center"><strong><%=cal.get(Calendar.YEAR)%>년 <%=(cal.get(Calendar.MONTH)+1)%>월</strong></td>
        <td align="center"><a href=# onclick="fSearch(<%=cal.get(Calendar.YEAR)%>,<%=((cal.get(Calendar.MONTH)+1)+1)%>);"><img src="/images/btn_arr_R.gif" width="18" height="18" /></a></td>
        </tr>
    </table></td>
  </tr>
    <tr>
    <td>
<table id=tbl_cal  width="730" border="0" cellspacing="1" cellpadding="5" bgcolor="#cccccc">
<colgroup>
    <col width=95>
    <col width=95>
    <col width=95>
    <col width=95>
    <col width=95>
    <col width=95>
    <col width=95>
</colgroup>
<thead>
<tr align="right">
<th height="30" align="center" bgcolor="#e0e0e0">  일</th><th align="center" bgcolor="#e0e0e0">  월</th><th align="center" bgcolor="#e0e0e0">  화</th><th align="center" bgcolor="#e0e0e0">  수</th><th align="center" bgcolor="#e0e0e0">  목</th><th align="center" bgcolor="#e0e0e0">  금</th><th align="center" bgcolor="#e0e0e0">  토</th>
</tr>
</thead>
<tbody>
<%
cal.set(year, month-1, 1);
int dayOfWeek = cal.get(Calendar.DAY_OF_WEEK);
    //out.println("dayOfWeek  : " + dayOfWeek+ "<BR>" );
    //out.println("dayOfWeek  : " + cal.getActualMaximum(Calendar.DAY_OF_MONTH)+ "<BR>" );
%>
<tr align="right" >
<%
    for(int i=1;i<dayOfWeek;i++) {
%>
        <td height="100" align="right" valign="top" bgcolor="#FFFFFF" class=col<%=i%>>&nbsp;</td>
<%
    }
%>
<%
int s = dayOfWeek;

for(int i=1;i<=cal.getActualMaximum(Calendar.DAY_OF_MONTH);i++) {
    String toDayTag = "";
    if ( cal.get(Calendar.YEAR)     == todayYear  &&
         cal.get(Calendar.MONTH)+1  == todayMonth &&
         i                          == todayDay    ) {
        toDayTag = "style='background-color:#c1ffff' today=true";
    } else {
        toDayTag = "style='' today=false";
    }
    String tagId = cal.get(Calendar.YEAR) + "" + String.format("%02d",cal.get(Calendar.MONTH)+1) + "" + String.format("%02d",i);
%>
    <td height="100" align="right" valign="top" bgcolor="#FFFFFF" <%=toDayTag%> onclick="fDaySelect(this);" id="<%=tagId%>"><b style='font-size:11pt'><%=i%></b><div style="height:90px;overflow:hidden"></div>
    <!-- <input type=text value="<%=i%> / <%=todayDay%>">
    <input type=text value="<%=toDayTag%>"> -->
    </td>
<%
    if((dayOfWeek-1+i)%7==0) {
%>
        </tr>
        <tr align="right" >
<%
    }
%>
<%
    if ( s % 7  == 0 ) {
        s=0;
    }
    s++;
}
%>
<%
    if ( s < 7 ) {
        for(int i=s;i<=7;i++) {
%>
            <td height="100" align="right" valign="top" bgcolor="#FFFFFF" class=col<%=s%>>&nbsp;</td>
<%
        }
    }
%>
</tr>
</tbody>
</table>
    </td>
  </tr>
</table>
<form name="wForm" id="wForm" method="post" onSubmit="return fExec();">
<input type="hidden" name="p_mode" value="I" />
<input type="hidden" name="p_schedule_no" value="" />
<!-------------------------------------------- 일정등록 레이어 부분 ------------------------------------->
<!--div id="apDiv1"-->
<div id='add_area' style='position:absolute;border:1px solid gray;display:none'>
  <table width="300" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
    <tr>
      <td><table width="300" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
        <tr>
          <td><img src="/images/sp1_title05_1.gif" width="250" height="36" /></td>
        </tr>
        <tr>
          <td><table width="300" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="25" style="padding-left:5px;">구분</td>
              <td>: <span id="tag_gubun_code">-구분-</span></td>
            </tr>
            <tr>
              <td height="25" style="padding-left:5px;">회의명</td>
              <td>: <span id="tag_name_code">-구분-</span></td>
            </tr>
            <tr>
              <td height="25" style="padding-left:5px;">개최일</td>
              <td>:
                <label for="textfield4"></label>
<input type='text' name='bd_start_day' id='bd_start_day' value='' readonly  size="15" maxlength= />&nbsp;<img src="/images/btn_cal.gif" onclick='displayCalendar(document.wForm.bd_start_day,"yyyy-mm-dd",this)'>
                </td>
            </tr>
            <tr>
              <td height="25" style="padding-left:5px;">마감일</td>
              <td>:
                <label for="textfield5"></label>
<input type='text' name='bd_end_day' id='bd_end_day' value='' readonly  size="15" maxlength= />&nbsp;<img src="/images/btn_cal.gif" onclick='displayCalendar(document.wForm.bd_end_day,"yyyy-mm-dd",this)'>
            </tr>
            <tr>
              <td height="25" style="padding-left:5px;">개최시간</td>
              <td>:
                <select name="bd_time_h">
                    <option value="00">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                </select>
                    :
                <select name="bd_time_m">
                    <option value="00">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                    <option value="51">51</option>
                    <option value="52">52</option>
                    <option value="53">53</option>
                    <option value="54">54</option>
                    <option value="55">55</option>
                    <option value="56">56</option>
                    <option value="57">57</option>
                    <option value="58">58</option>
                    <option value="59">59</option>
                </select>
             </td>
            </tr>
            <tr>
              <td height="25" style="padding-left:5px;">개최장소</td>
              <td>:
                <label for="textfield6"></label>
<input type='text' name='bd_place' id='bd_place' value=""  size="20"  class='required trim focus alert' maxlength=100 message='개최장소를 입력해주세요.' />
                &nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30" align="center"><input type="image" src="/images/btn_save.gif" width="56" height="31" />&nbsp;<a href=# onclick="fDelExec();" id="btn_delete"><img src="/images/btn_del.gif" width="56" height="31" /></a>
		  </td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
</form>
            </td>
          </tr>

          <tr>
            <td>&nbsp;</td>
          </tr>
<!--           <tr>
            <td align="right" style="padding-right:5px;"><img src="/images/btn_reg_1.gif"></td>
          </tr> -->
          <tr>
            <td><img src="/images/sp_bottom.gif"></td>
          </tr>
        </table>
