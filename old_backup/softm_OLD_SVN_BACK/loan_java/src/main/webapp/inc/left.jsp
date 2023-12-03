<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%
	StringBuffer sbMenu = new StringBuffer();
	
	// 이사회 정보 LEFT 메뉴
	if( "dms_info".equals(dir) ) {
		String[] menus = { "bd_history", "bd_bylaw", "bd_members", "bd_group_members", "bd_schedule_main", "bd_item_search_list", "bd_proc_search_list" };
		String[] onImg = { "smenu1_s1_O.gif", "smenu1_s2_O.gif","smenu1_s3_O.gif","smenu1_s4_O.gif","smenu1_2_O.gif","smenu1_3_O.gif","smenu1_4_O.gif"	};
		String[] offImg = { "smenu1_s1.gif", "smenu1_s2.gif","smenu1_s3.gif","smenu1_s4.gif","smenu1_2.gif","smenu1_3.gif","smenu1_4.gif"	};
		
		sbMenu.append("<table width=\"187\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">").append("\n");
		sbMenu.append("<tr>").append("\n");
		sbMenu.append("    <td><img src=\"/images/s_menu1_top.gif\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");
		sbMenu.append("<tr>").append("\n");
		sbMenu.append("    <td><img src=\"/images/smenu1_1.gif\" border=\"0\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");
		if( "index".equals(pg) ) {
			sbMenu.append("<tr>").append("\n");
			sbMenu.append("<td><img src='/images/").append(onImg[0]).append("'></td>").append("\n");
			for (int i = 1; i < menus.length; i++) {
				sbMenu.append("<tr>").append("\n");
				sbMenu.append("<td><a href=\"/service.jsp?p_prg=").append(dir).append("/").append(menus[i]).append("\"><img src=\"/images/").append(offImg[i]).append("\" border=\"0\" onMouseOver=\"this.src='/images/").append(onImg[i]).append("'\" onMouseOut=\"this.src='/images/").append(offImg[i]).append("'\"></a></td>").append("\n");
				sbMenu.append("</tr>").append("\n");
			}
		} else {
			for (int i = 0; i < menus.length; i++) {
				if(menus[i].equals(pg)) {
					sbMenu.append("<tr>").append("\n");
					sbMenu.append("<td><img src='/images/").append(onImg[i]).append("'></td>").append("\n");
					sbMenu.append("</tr>").append("\n");
				} else {
					sbMenu.append("<tr>").append("\n");
					sbMenu.append("<td><a href=\"/service.jsp?p_prg=").append(dir).append("/").append(menus[i]).append("\"><img src=\"/images/").append(offImg[i]).append("\" border=\"0\" onMouseOver=\"this.src='/images/").append(onImg[i]).append("'\" onMouseOut=\"this.src='/images/").append(offImg[i]).append("'\"></a></td>").append("\n");
					sbMenu.append("</tr>").append("\n");
				}
			}
		}	
		sbMenu.append("<tr>").append("\n");
		sbMenu.append("    <td><img src=\"/images/smenu1_bottom.gif\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");
        sbMenu.append("</table>").append("\n");	

	// 켜뮤니티 LEFT 메뉴
	} else if ( "dms_board".equals(dir) ) {
		String[] menus = { "board_notice_list", "board_basic_list", "board_law_list" };
		String[] onImg = { "smenu2_1_O.gif", "smenu2_2_O.gif","smenu2_3_O.gif"	};
		String[] offImg = { "smenu2_1.gif", "smenu2_2.gif","smenu2_3.gif"};
		
		sbMenu.append("<table width=\"187\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">").append("\n");
		sbMenu.append("<tr>").append("\n");
		sbMenu.append("    <td><img src=\"/images/s_menu2_top.gif\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");
		if( "index".equals(pg) ) {
			sbMenu.append("<tr>").append("\n");
			sbMenu.append("<td><img src='/images/").append(onImg[0]).append("'></td>").append("\n");
			for (int i = 1; i < menus.length; i++) {
				sbMenu.append("<tr>").append("\n");
				sbMenu.append("<td><a href=\"/service.jsp?p_prg=").append(dir).append("/").append(menus[i]).append("\"><img src=\"/images/").append(offImg[i]).append("\" border=\"0\" onMouseOver=\"this.src='/images/").append(onImg[i]).append("'\" onMouseOut=\"this.src='/images/").append(offImg[i]).append("'\"></a></td>").append("\n");
				sbMenu.append("</tr>").append("\n");
			}
		} else {
			for (int i = 0; i < menus.length; i++) {
				if(menus[i].equals(pg)) {
					sbMenu.append("<tr>").append("\n");
					sbMenu.append("<td><img src='/images/").append(onImg[i]).append("'></td>").append("\n");
					sbMenu.append("</tr>").append("\n");
				} else {
					sbMenu.append("<tr>").append("\n");
					sbMenu.append("<td><a href=\"/service.jsp?p_prg=").append(dir).append("/").append(menus[i]).append("\"><img src=\"/images/").append(offImg[i]).append("\" border=\"0\" onMouseOver=\"this.src='/images/").append(onImg[i]).append("'\" onMouseOut=\"this.src='/images/").append(offImg[i]).append("'\"></a></td>").append("\n");
					sbMenu.append("</tr>").append("\n");
				}
			}
		}
		sbMenu.append("<tr>").append("\n");
		sbMenu.append("<td><a href=\"http://www.moleg.go.kr/main.html\" target=\"_blank\" onfocus='blur()'><img src=\"/images/btn_bubje.gif\" border=\"0\"></a></td>").append("\n");
 		sbMenu.append("</tr>").append("\n");	
		sbMenu.append("<tr>").append("\n");
		sbMenu.append(" <td><img src=\"/images/smenu2_bottom.gif\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");
        sbMenu.append("</table>").append("\n");

	// 업무처리 LEFT 메뉴
	} else if ( "dms_biz".equals(dir) ) {
		String[] menus = { "bd_item_list", "bd_request_list", "propel_list" };
		String[] onImg = { "smenu3_1_O.gif", "smenu3_2_O.gif","smenu3_3_O.gif"	};
		String[] offImg = { "smenu3_1.gif", "smenu3_2.gif","smenu3_3.gif"};
		
		sbMenu.append("<table width=\"187\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">").append("\n");
		sbMenu.append("<tr>").append("\n");
		sbMenu.append("    <td><img src=\"/images/s_menu3_top.gif\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");
		if( "index".equals(pg) ) {
			sbMenu.append("<tr>").append("\n");
			sbMenu.append("<td><img src='/images/").append(onImg[0]).append("'></td>").append("\n");
			for (int i = 1; i < menus.length; i++) {
				sbMenu.append("<tr>").append("\n");
				sbMenu.append("<td><a href=\"/service.jsp?p_prg=").append(dir).append("/").append(menus[i]).append("\"><img src=\"/images/").append(offImg[i]).append("\" border=\"0\" onMouseOver=\"this.src='/images/").append(onImg[i]).append("'\" onMouseOut=\"this.src='/images/").append(offImg[i]).append("'\"></a></td>").append("\n");
				sbMenu.append("</tr>").append("\n");
			}
		} else {
			for (int i = 0; i < menus.length; i++) {
				if(menus[i].equals(pg)) {
					sbMenu.append("<tr>").append("\n");
					sbMenu.append("<td><img src='/images/").append(onImg[i]).append("'></td>").append("\n");
					sbMenu.append("</tr>").append("\n");
				} else {
					sbMenu.append("<tr>").append("\n");
					sbMenu.append("<td><a href=\"/service.jsp?p_prg=").append(dir).append("/").append(menus[i]).append("\"><img src=\"/images/").append(offImg[i]).append("\" border=\"0\" onMouseOver=\"this.src='/images/").append(onImg[i]).append("'\" onMouseOut=\"this.src='/images/").append(offImg[i]).append("'\"></a></td>").append("\n");
					sbMenu.append("</tr>").append("\n");
				}
			}
		}
		sbMenu.append("<tr>").append("\n");
		sbMenu.append(" <td><img src=\"/images/smenu3_bottom.gif\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");
        sbMenu.append("</table>").append("\n");

	// 통계 LEFT 메뉴
	} else if ( "dms_stat".equals(dir) ) {
		String[] menus = { "bd_st_manage_result", "bd_st_business" };
		String[] onImg = { "smenu4_1_O.gif", "smenu4_2_O.gif"	};
		String[] offImg = { "smenu4_1.gif", "smenu4_2.gif"};
		
		sbMenu.append("<table width=\"187\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">").append("\n");
		sbMenu.append("<tr>").append("\n");
		sbMenu.append("    <td><img src=\"/images/s_menu4_top.gif\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");
		if( "index".equals(pg) ) {
			sbMenu.append("<tr>").append("\n");
			sbMenu.append("<td><img src='/images/").append(onImg[0]).append("'></td>").append("\n");
			for (int i = 1; i < menus.length; i++) {
				sbMenu.append("<tr>").append("\n");
				sbMenu.append("<td><a href=\"/service.jsp?p_prg=").append(dir).append("/").append(menus[i]).append("\"><img src=\"/images/").append(offImg[i]).append("\" border=\"0\" onMouseOver=\"this.src='/images/").append(onImg[i]).append("'\" onMouseOut=\"this.src='/images/").append(offImg[i]).append("'\"></a></td>").append("\n");
				sbMenu.append("</tr>").append("\n");
			}
		} else {
			for (int i = 0; i < menus.length; i++) {
				if(menus[i].equals(pg)) {
					sbMenu.append("<tr>").append("\n");
					sbMenu.append("<td><img src='/images/").append(onImg[i]).append("'></td>").append("\n");
					sbMenu.append("</tr>").append("\n");
				} else {
					sbMenu.append("<tr>").append("\n");
					sbMenu.append("<td><a href=\"/service.jsp?p_prg=").append(dir).append("/").append(menus[i]).append("\"><img src=\"/images/").append(offImg[i]).append("\" border=\"0\" onMouseOver=\"this.src='/images/").append(onImg[i]).append("'\" onMouseOut=\"this.src='/images/").append(offImg[i]).append("'\"></a></td>").append("\n");
					sbMenu.append("</tr>").append("\n");
				}
			}
		}
		sbMenu.append("<tr>").append("\n");
		sbMenu.append(" <td><img src=\"/images/smenu4_bottom.gif\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");
        sbMenu.append("</table>").append("\n");

	// 관리자 LEFT 메뉴
	} else if ( "dms_admin".equals(dir) ) {
		String[] menus = { "bd_member_list","bd_proceedings_write","bd_item_result_write","bd_item_result_print","reference_admin ","bd_call_notice" };
		String[] onImg = { "smenu5_1.gif","smenu5_2.gif","smenu5_3.gif","smenu5_4.gif","smenu5_5.gif","smenu5_6.gif"	};
		String[] offImg = { "smenu5_1_O.gif","smenu5_2_O.gif","smenu5_3_O.gif","smenu5_4_O.gif","smenu5_5_O.gif","smenu5_6_O.gif"};
		
		sbMenu.append("<table width=\"187\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">").append("\n");
		sbMenu.append("<tr>").append("\n");
		sbMenu.append("    <td><img src=\"/images/s_menu5_top.gif\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");

		if( "index".equals(pg) ) {
			sbMenu.append("<tr>").append("\n");
			sbMenu.append("<td><img src='/images/").append(onImg[0]).append("'></td>").append("\n");
			for (int i = 1; i < menus.length; i++) {
				sbMenu.append("<tr>").append("\n");
				sbMenu.append("<td><a href=\"/service.jsp?p_prg=").append(dir).append("/").append(menus[i]).append("\"><img src=\"/images/").append(offImg[i]).append("\" border=\"0\" onMouseOver=\"this.src='/images/").append(onImg[i]).append("'\" onMouseOut=\"this.src='/images/").append(offImg[i]).append("'\"></a></td>").append("\n");
				sbMenu.append("</tr>").append("\n");
			}
		} else {
			for (int i = 0; i < menus.length; i++) {
				if(menus[i].equals(pg)) {
					sbMenu.append("<tr>").append("\n");
					sbMenu.append("<td><img src='/images/").append(onImg[i]).append("'></td>").append("\n");
					sbMenu.append("</tr>").append("\n");
				} else {
					sbMenu.append("<tr>").append("\n");
					sbMenu.append("<td><a href=\"/service.jsp?p_prg=").append(dir).append("/").append(menus[i]).append("\"><img src=\"/images/").append(offImg[i]).append("\" border=\"0\" onMouseOver=\"this.src='/images/").append(onImg[i]).append("'\" onMouseOut=\"this.src='/images/").append(offImg[i]).append("'\"></a></td>").append("\n");
					sbMenu.append("</tr>").append("\n");
				}
			}
		}	
		sbMenu.append("<tr>").append("\n");
		sbMenu.append("    <td><img src=\"/images/smenu5_bottom.gif\"></td>").append("\n");
		sbMenu.append("</tr>").append("\n");
        sbMenu.append("</table>").append("\n");	
%>

<%
} else if ( "sample".equals(dir) ) {
%>
<pre>
▣  sample
<a href="/service.jsp?p_prg=<%=dir+"/sample"%>" style='color:<%="sample".indexOf(pg)>-1?"#f00":"#000"%>'>▣ sample</a>
</pre>
<table width="187" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td><img src="/images/s_menu3_top.gif"></td>
    </tr>
    <tr>
        <td><img src="/images/smenu3_1_O.gif"></td>
    </tr>
    <tr>
        <td><a href="#"><img src="/images/smenu3_2.gif" border="0"
                onMouseOver="this.src='/images/smenu3_2_O.gif'"
                onMouseOut="this.src='/images/smenu3_2.gif'"></a></td>
    </tr>
    <tr>
        <td><a href="#"><img src="/images/smenu3_3.gif" border="0"
                onMouseOver="this.src='/images/smenu3_3_O.gif'"
                onMouseOut="this.src='/images/smenu3_3.gif'"></a></td>
    </tr>
    <tr>
        <td><img src="/images/smenu3_bottom.gif"></td>
    </tr>
</table>
<%
}
%>
<%=sbMenu.toString()%>
