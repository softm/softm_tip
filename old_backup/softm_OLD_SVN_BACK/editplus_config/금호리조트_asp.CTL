#TITLE=금호리조트_asp
#INFO
New Cliptext library
#SORT=n

#T=<%=rsList(0,arrno)%>
<%=rsList(0,arrno)%>
#T=sql_count
        sql="select count(BOARD_IDX)  "
        sql = sql & " FROM NKH_BOARD A "
        sql = sql & " WHERE (TITLE  like '%"&strQuryCont&"%' "
        sql = sql & " OR CONTENT like '%"&strQuryCont&"%' ) "
        IF  strMyCont= "" THEN
            sql = sql & " AND UP_YN ='Y'  "
        ElseIf strMyCont = "Y"  THEN
            sql = sql & " AND USER_ID ='"&Session("userid")&"'  "
        End If
        sql = sql & " AND BOARD_TYPE ='"&strBoardType&"'  "
        sql = sql & add_sql
        'RESPONSE.WRITE "sql = "&sql&"<BR>"

        set rs = cn.execute(sql)
            rs_cnt = rs(0)
            rs.close
        set rs = nothing
        if rs_cnt mod pagesize = 0 then
            pagecount = (rs_cnt \ pagesize)
        else
            pagecount = (rs_cnt \ pagesize)+1
        end if
        if clng(pageno) > clng(pagecount) then
            pageno = pagecount
        end if
#T=communityMonitor.URL.write_proc;
communityMonitor.URL.write_proc;
#T= title = str_cut(rsList(1,arrno),25)  '문자열 길이 제한
																		 title = str_cut(rsList(1,arrno),25)  '문자열 길이 제한
																		 title = Replace(title, "<","&lt;")
																		 title = Replace(title, ">","&gt;")
#T=$(document).ready(function() {
<script type="text/javascript">
$(document).ready(function() {
    document.searchFrm.pQuryFlag.value= "<%=strQuryFlag%>";
});
</script>
#T=userid : <%=session("userid")%><bR>
userid : <%=session("userid")%><bR>
#T=<%=FormatDateTime(strWriteday)%>
<%=FormatDateTime(strWriteday)%>
#T=제목 Replace
            strWritSubj = Replace(strWritSubj, "'","''")
            strWritSubj = Replace(strWritSubj, "<","&lt;")
            strWritSubj = Replace(strWritSubj, ">","&gt;")
#T=내용 Replace
            strRepyCont = Trim(rsView(15))
            strRepyCont = Replace(strRepyCont, "'","''")
            strRepyCont = Replace(strRepyCont, "<","&lt;")
            strRepyCont = Replace(strRepyCont, ">","&gt;")
            strRepyCont = Replace(strRepyCont,Chr(13) & Chr(10), "<br>")

#T=GetTextParam
GetTextParam
#T=<!--#include virtual = "/include/BasicHead.asp"-->
<!--#include virtual = "/include/BasicHead.asp"-->

#T=<!--#include virtual="/kradmin/library/pms_dbcon.asp"-->
<!--#include virtual="/kradmin/library/pms_dbcon.asp"-->

#T=<!--#include virtual="/kradmin/library/pms_common.asp"-->
<!--#include virtual="/kradmin/library/pms_common.asp"-->

#T=<!--#include virtual="/kradmin/library/dbcon.asp"-->
<!--#include virtual="/kradmin/library/dbcon.asp"-->

#T=<!--#include virtual="/kradmin/library/common.asp"-->
<!--#include virtual="/kradmin/library/common.asp"-->

#T=<!--#include virtual="/kradmin/library/function.asp"-->
<!--#include virtual="/kradmin/library/function.asp"-->

#T=<!--#include virtual="/kradmin/library/2008_board_library.asp"-->
<!--#include virtual="/kradmin/library/2008_board_library.asp"-->

#T=<!--#include virtual="/kradmin/library/etc_library.asp"-->
<!--#include virtual="/kradmin/library/etc_library.asp"-->

#T=<!--#include virtual="/kradmin/fckeditor/fckeditor.asp" -->
<!--#include virtual="/kradmin/fckeditor/fckeditor.asp" -->

#T=<!--#include virtual = "/kradmin/adminLoginCheck.asp" -->
<!--#include virtual = "/kradmin/adminLoginCheck.asp" -->

#T=<!--#include virtual="/kradmin/library/function2.inc"-->
<!--#include virtual="/kradmin/library/function2.inc"-->
#T=<!--#include virtual="/kradmin/library/function2_2.inc"-->
<!--#include virtual="/kradmin/library/function2_2.inc"-->

#T=<!--#include virtual="/kradmin/library/function2_3.inc"-->
<!--#include virtual="/kradmin/library/function2_3.inc"-->

#T=<!--#include virtual="/kradmin/library/function3.inc"-->
<!--#include virtual="/kradmin/library/function3.inc"-->

#T=<!-- #include virtual="/lib/common/custLibrary.asp" -->
<!-- #include virtual="/lib/common/custLibrary.asp" -->

#T=<!-- #include virtual="/kradmin/event_gallery/config.asp" -->
<!-- #include virtual="/kradmin/event_gallery/config.asp" -->

#T=<!--#include virtual="/kradmin/library/sub_head.asp"-->
<!--#include virtual="/kradmin/library/sub_head.asp"-->

#T=<!--#include virtual="/kradmin/library/sub_right.asp"-->
<!--#include virtual="/kradmin/library/sub_right.asp"-->

#T=<!--#include virtual="/kradmin/library/sub_copyright.asp"-->
<!--#include virtual="/kradmin/library/sub_copyright.asp"-->

#T=<!--#include virtual="/kradmin/library/funzone_left.asp"-->
<!--#include virtual="/kradmin/library/funzone_left.asp"-->

#