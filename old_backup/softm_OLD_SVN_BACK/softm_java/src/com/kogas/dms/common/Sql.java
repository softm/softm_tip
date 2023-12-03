package com.kogas.dms.common;
/*
 * @(#)Utility.java        1.0   2002/10/02
 * Copyright (c) 1997-2002 Taeul C & C, Inc.
 * Bong Chun 11 Dong, Gwanakgu, Seoul, Korea.
 * All rights reserved.
*/

import java.io.IOException;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

/**
* Class Sql관련
*
*/
@SuppressWarnings("unused")
public class Sql
{
	public static int page_navi_how_many   = 10;
	public static int page_navi_more_many  = 10;
	public static int page_navi_limit = 10;

	private Connection con = null;
	private PreparedStatement pstmt = null;
	private Statement stmt = null;
	private ResultSet rs = null;

    /**
	    * 오직 한 Row , 한 Column 의 자료를 조회 합니다.
	    * @param SQL the String
	    * @param conn the Connection
	    * @return java.lang.String
	    */
	    public static int getCount ( String SQL, Connection conn) {
	        Statement   stmt        = null;
	        ResultSet   ReV         = null;
	        int         _rtV        = -1  ;

	        try {
	            stmt = conn.createStatement();
	            ReV  = stmt.executeQuery(SQL);
	            while ( ReV.next() ){
	                int i = 0;
	                _rtV  = ReV.getInt(1);
	            }
	        }
	        catch ( SQLException e ) {
                e.printStackTrace();
            } finally {
	            try {
	                if ( ReV  != null ) { ReV.close();  }
	                if ( stmt != null ) { stmt.close(); }
	            }
	            catch ( SQLException e ) {
                    e.printStackTrace();
                }
	        }
//	        System.out.print("조회 값 : " + _rtV );
	        return _rtV;
	    }

    /**
    * 오직 한 Row , 한 Column 의 자료를 조회 합니다.
    * @param SQL the String
    * @param conn the Connection
    * @return java.lang.String
    */
//    public static String simpleQuery ( String SQL, Connection conn) {
   	public static String getOne ( String SQL) {
        Statement   stmt        = null;
        ResultSet   rs         = null;
        String      _rtV        = null;

        try {
            stmt = DBUtil.getConnection().createStatement();
            rs   = stmt.executeQuery(SQL);
            while ( rs.next() ){
                int i = 0;
                _rtV  = rs.getString(1);
            }
        }
        catch ( SQLException e ) {
            e.printStackTrace();
        } finally {
            try {
                if ( rs   != null ) { rs.close();  }
                if ( stmt != null ) { stmt.close(); }
            }
            catch ( SQLException e ) {
                e.printStackTrace();
            }
        }
//        System.out.print("조회 값 : " + _rtV );
        return _rtV;
    }

  /**
    * 갱신 처리.
    * @param SQL the String
    * @param conn the Connection
    * @return java.lang.String
    */
//    public static int simpleQueryExecute ( String SQL, Connection conn) {
    	public static int exec ( String SQL, Connection conn) {
        Statement   stmt     = null;
        int      _rtV        = 0;

        try {
            stmt = DBUtil.getConnection().createStatement();
            _rtV  = stmt.executeUpdate(SQL);

        }
        catch ( SQLException e ) {
            e.printStackTrace();
        } finally {
            try {
                if ( stmt != null ) { stmt.close(); }
            }
            catch ( SQLException e ) {
                e.printStackTrace();
            }
        }
//        System.out.print("조회 값 : " + _rtV );
        return _rtV;
    }

    /**
    * 현재 페이지를 계산 합니다.
    * @param start the int  시작 위치
    * @param howMany the int  한페이지에 보여질 자료수
    * @return int
    */
    public static int currentPage ( int start, int howMany ) {
        int _rtV = 1;
        if( start == 1 ) {
            _rtV = 1;
        } else {
            _rtV = ( (start - 1) / howMany ) + 1;
        }
        if (_rtV <= 0 ) _rtV = 1;
        return _rtV;
    }

    /**
    * 현재 페이지를 계산 합니다.
    * @param start the int  시작 위치
    * @param howMany  the int  첫  페이지에   보여질 자료수
    * @param moreMany the int  첫  페이지이후 보여질 자료수
    * @return int
    */
    public static int currentPage ( int start, int howMany, int moreMany ) {
        int _rtV = 0;
        int curstart = 0;
        int li_interval = howMany - moreMany;

        if( start == 1 )      {   // 시작위치 Default Set
            _rtV = 1;
        } else                  {   // 시작 위치 지정
            curstart   = start - li_interval;   // 현재 위치
            _rtV = ( ( curstart - 1 ) / moreMany ) + 1;  // 현재 탭의 위치
        }
        return _rtV;
    }


    /**
    * 총 페이지를 계산 합니다.
    * @param totcount the int  시작 위치
    * @param howMany the int  한페이지에 보여질 자료수
    * @return int
    */
    public static int totalPage ( int totcount, int howMany ) {
        int _rtV = 0;
        Double dbtotcount = new Double( totcount );
        Double dbhowMany  = new Double( howMany  );
        Double dbvalue    = new Double( ( dbtotcount.doubleValue() / dbhowMany.doubleValue() ) + 0.9 );
        _rtV = dbvalue.intValue();
        if (_rtV <= 0 ) _rtV = 1;
        return _rtV;
    }

    /**
    * 총 페이지를 계산 합니다.
    * @param totcount the int  시작 위치
    * @param howMany  the int  첫  페이지에   보여질 자료수
    * @param moreMany the int  첫  페이지이후 보여질 자료수
    * @return int
    */
    public static int totalPage ( int totcount, int howMany, int moreMany ) {
        int _rtV = 1;

        if ( totcount <= howMany || howMany == 0 || moreMany == 0 ) {
            _rtV = 1;
        } else {
            int tmpTotcnt     = 0;
            tmpTotcnt   = totcount - howMany + moreMany;
            Double dbtotcount = new Double( tmpTotcnt  );
            Double dbhowMany  = new Double( howMany  );
            Double dbmoreMany = new Double( moreMany );
            Double dbvalue    = new Double( ( dbtotcount.doubleValue() / dbmoreMany.doubleValue() ) + 0.9 );
            _rtV = dbvalue.intValue();
        }
        return _rtV;
    }
    
    /** 페이지 Tab을 구성합니다.
     * @param P_start the String
     * @param P_Totcount the String
     * @param P_HowMany the String
     * @param P_limit the String
     * @param P_jsFunc the String
     */
     public static String pageTab ( int P_start , int P_Totcount,int P_HowMany, int P_limit,String P_jsFunc  )
         throws IOException
     {
         String rtValue = "";
         int curpage;
         int li_curpage  = 0;
         int li_HowMany  = 0;
         int li_Totcount = 0;
         int li_totpage  = 0;
         int li_limit    = P_limit;
         String URL = "";

             li_Totcount = P_Totcount;
             if ( li_Totcount > P_HowMany ) {
                 if ( P_HowMany != 0 ) {
                     li_HowMany = P_HowMany;
                 } else {
                     li_HowMany = 10;
                 }
//                 out.print("li_HowMany : " + li_HowMany);
                 if( P_start == 1 ) {
                     li_curpage=1;
                 }
                 else {
                     curpage = P_start;
                     li_curpage = ( (curpage-1) / li_HowMany ) + 1;
                 }
//                 out.println("<BR>li_curpage : " + li_curpage +"<BR>");
                 //      <!-- 총 페이지수 산출 -->
                 li_totpage = (li_Totcount / li_HowMany);
                 // <!-- 페이수중에 여분의 레코드들을 출력하기위해  총페이지에 한페이지를 더함 -->
                 if(li_totpage * li_HowMany < li_Totcount ) {
         //        out.print("탄다");
                     li_totpage = li_totpage + 1;
                 }
//                 out.println("<BR>li_totpage : " + li_totpage +"<BR>");

                 int Tstart=0;
                 double tmp = li_curpage;
                 tmp = Math.ceil( tmp / li_limit );
//                 out.println("tmp : " + tmp +"<BR>");
                 Double ld_tmp = new Double(tmp);
//                 out.println("ld_tmp : " + ld_tmp);

                 int li_curarea = ld_tmp.intValue();

                 if  ( li_curarea == 0 ) li_curarea = 1;
//                 out.println(" li_curarea : " + li_curarea);

                 int spage =  ( li_limit * ( li_curarea - 1 ) ) + 1;

//                 out.println(" spage : " + spage + "<BR>");
                 int epage;
                 if ( ( li_limit * li_curarea ) >= li_totpage ) {
                     epage = li_totpage;
                 } else {
                     epage = ( li_limit * li_curarea );
                 }
//                 out.println(" epage : " + epage + "<BR>");
                 String leftBt  = "<img src='/zzook/image/left_bt.gif' border='0'>";
                 String rightBt = "<img src='/zzook/image/right_bt.gif' border='0'>";
//                 String leftBt = "◀ 이전&nbsp;";
                 if ( spage - 1 < 1) {
//                  out.print("[이전 " + li_limit + " 개]&nbsp;");
//                     rtValue += "◀ 이전&nbsp;";
                     rtValue += leftBt;
                 }
                 else {
                     Tstart = ( ( li_HowMany * ( spage - li_limit - 1 ) ) + 1 );
//                     rtValue += "<a href='#' onclick='PageTab(" + Tstart + "," + li_Totcount + ",\"" + P_target + "\");return false;'>◀ 이전&nbsp;</a>";
                     rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + li_Totcount + ");return false;'>" + leftBt + "</a>";
//                     out.print( "<a href='#' onclick='PageTab(" + Tstart + "," + li_Totcount + ",\"" + P_target + "\");return false;'>◀ 이전&nbsp;</a>" );
                 }
                 // <!-- 여기부터는 다음페이지와 이전페이지를 넘나들기위해서................... -->
                 if ( li_curpage > 1 ) {
                    Tstart = ( ( li_HowMany * ( li_curpage - 2 ) ) + 1 );
//                     rtValue += "<a href='#' onclick='PageTab(" + Tstart + "," + li_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>";
//                      out.print("<a href='#' onclick='PageTab(" + Tstart + "," + li_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>");
                 }
                 else {
//                     rtValue += "◀&nbsp;";
//                      out.print("◀&nbsp;");
                 }

                  for( int a = spage ; a <= epage; a++) {
                     rtValue += " |";
//                     out.print(" |");
                     if ( a == li_curpage ) {
                         rtValue += a;
//                         out.print(a);
                     }
                     else {
//                      out.print("<FONT size='1'>[</FONT>");
                      Tstart = ( ( li_HowMany * ( a - 1 ) ) + 1 );
                      rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + li_Totcount + ");return false;'>" + a + "</a>";
//                      out.print("<a href='#' onclick='PageTab(" + Tstart + "," + li_Totcount + ",\"" + P_target + "\");return false;'>" + a + "</a>");
//                      out.print("<FONT size='1'>]</FONT>");
                     }
                 }
                 rtValue += " | ";
//                 out.print(" | ");
         //        out.print("li_totpage : li_totpage / li_curpage  : li_curpage ");
                 if ( li_totpage > li_curpage ) {
                     Tstart = ( ( li_HowMany * li_curpage ) + 1);
//                     rtValue += "<a href='#' onclick='PageTab(" + Tstart + "," + li_Totcount + ",\"" + P_target + "\");return false;'>&nbsp;▶</a>";
//                     out.print("<a href='#' onclick='PageTab(" + Tstart + "," + li_Totcount + ",\"" + P_target + "\");return false;'>&nbsp;▶</a>");
                 }
                 else{
//                      out.print("&nbsp;▶");
                 }
                 if ( epage == li_totpage ) {
//                  out.print("[다음 " + li_limit + " 개]&nbsp;");
//                     rtValue += "다음&nbsp;▶";
                       rtValue += rightBt;
//                     out.print( "다음&nbsp;▶" );
                 }
                 else {
                      Tstart = ( ( li_HowMany * ( epage + 1 - 1 ) ) + 1 );
//                      out.print("다음시작 : " + Tstart + "<BR>");
//                      out.print("<a href='#' onclick='PageTab(" + Tstart + "," + li_Totcount + ",\"" + P_target + "\");return false;'>[다음 " + li_limit + " 개]&nbsp;</a>");
//                     rtValue += "다음&nbsp;▶";
//                     rtValue += "<a href='#' onclick='PageTab(" + Tstart + "," + li_Totcount + ",\"" + P_target + "\");return false;'>다음&nbsp;▶</a>";
                         rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + li_Totcount + ");return false;'>" + rightBt + "</a>";
//                     out.print(  "다음&nbsp;▶" );
                 }
             }
             return rtValue;
     }
     /** 페이지 Tab을 구성합니다.
     * @param P_start the String
     * @param P_Totcount the String
     * @param P_HowMany the String
     * @param P_MoreMany the String
     * @param P_limit the String
     * @param P_jsFunc the String
     */
     public static String pageTab ( int P_start , int P_Totcount, int P_HowMany, int P_MoreMany, int P_limit,String P_jsFunc  )
         throws IOException
     {
         String rtValue = "";
         int curpage     = 0;    // 현재 위치
         int li_curpage  = 0;    // 현재 탭의 위치
         int li_HowMany  = 0;    // 첫번째 탭      에서 화면에 보여질 자료의 갯수
         int li_MoreMany = 0;    // 두번째 탭 이후 에서 화면에 보여질 자료의 갯수
         int li_Totcount = 0;    // 총 조회수
         int li_totpage  = 0;    // 총 탭의 갯수
         int li_limit    = P_limit;
         int li_interval = 0;

         String URL = "";
         li_HowMany  = P_HowMany;
         li_Totcount = P_Totcount;
             if ( li_Totcount > P_HowMany && P_HowMany != 0 ) {

//                 if ( P_Totcount <= P_HowMany + P_MoreMany ) { li_Totcount += li_HowMany; out.println ( "탄다" ) ;}

                 if ( P_MoreMany != 0 )   {   // 첫 페이지에 보여질 자료수
                     li_MoreMany = P_MoreMany;
                 } else                   {   // 첫 페이지 Default Set
                     li_MoreMany = 10;
                 }

                 li_Totcount = li_Totcount - li_HowMany + li_MoreMany;

 // ---- Start ------ HowMany만큼으로 첫번째 탭을 구성합니다.----------------------- //
 /*  총 잘 갯수는 첫 페이지에 보여질 갯수 즉 li_HowMany 값 을 뺀 값을 사용합니다.
 // 만약 총 100 개의 자료 ( li_Totcount ) 가 있고
 // 첫 페이지에 보여질 자료수 ( P_HowMany ) 가 11 개
 // 두번째 페이지 부터 보여질 자료수가 ( P_MoreMany) 가 존재 한다면.
 // li_Totcount - P_HowMany 값을 총 조회수로 사용하여 페이지 Tab을 구성하고
 // 첫번째 그룹을 출력하는 경우
//       시작탭 + 1 ~ 종료탭 까지 출력 합니다.
//       시작탭             의 start : 무조건 1
//       시작탭 + 1 ~ 종료탭의 start : start + li_interval
 // 두번재 이후의 그룹일 경우
//       시작탭     ~ 종료탭
//       시작탭     ~ 종료탭의 start : start + li_interval
 // li_interval값은
 // 아래와 같이 설정 됩니다.
 -----------------------------------------------------------
                     li_HowMany  li_MoreMany  li_interval
 -----------------------------------------------------------
                         10          5           5
 -----------------------------------------------------------
                         3           5           3
                         3           5          -2
 -----------------------------------------------------------
 첫페이지에 보여질 자료와 그 다음 페이지의 자료수가 틀리게 설정되어 있지 않다면
 시작 위치는 1 , 6 , 11 , 16 , 21 ... 입니다. ( 실제 시작 위치 )
 하지만
             1 , 11 , 16 , 21 , 26 ...        ( 재계산된 시작 위치 )
             1 ,  4 ,  9 , 14 , 19 ...        ( 재계산된 시작 위치 )
 의 구성이 되어야 합니다.
 여기서 발생되는 5 와 -2 이라는 차이가 발생합니다. ( li_interval )

 재 계산된 시작위치가 넘어오면 실제 시작위치 + li_interval start값 ( curpage )을 재지정하면 됩니다.
 */
//                 if ( li_HowMany >= li_MoreMany ) {
                     li_interval = li_HowMany - li_MoreMany;
//                 } else {
//                     li_interval = li_HowMany;
//                 }

 // ---- Start ------ 총 페이지수 산출 ------------------------------------------ //

                 if( P_start == 1 )      {   // 시작위치 Default Set
                     li_curpage=1;
                 } else                  {   // 시작 위치 지정
//                     if ( li_HowMany >= li_MoreMany ) {
                         curpage   = P_start - li_interval;   // 현재 위치
//                     } else {
//                         curpage   = P_start + li_interval + 2;
//                         out.println ( "2 : "  + curpage );
//                     }
                     li_curpage = ( ( curpage - 1 ) / li_MoreMany ) + 1;  // 현재 탭의 위치
                 }

//                 if ( li_HowMany < li_MoreMany ) {
//                     li_interval = ( li_interval * -1 ) + 1;
//                 }

 // ---- Start ------ 총 페이지수 산출 ------------------------------------------ //
                 li_totpage = ( li_Totcount / li_MoreMany );
                 // 페이수중에 여분의 레코드들을 출력하기위해  총페이지에 한페이지를 더함
                 if ( li_totpage * li_MoreMany < li_Totcount ) {          // 총 탭의 갯수
                     li_totpage = li_totpage + 1;
                 }
 // ---- End   ------ 총 페이지수 산출 ------------------------------------------ //

                 int     Tstart  = 0;
 // ---- Start ------ 현재 Group의 계산 ----------------------------------------- //
                 double  tmp     = li_curpage;

                 tmp = Math.ceil( tmp / li_limit );
                 Double ld_tmp = new Double ( tmp  );

                 int li_curarea = ld_tmp.intValue();

                 if  ( li_curarea == 0 ) li_curarea = 1;
//                 out.println(" 현재 Group의 계산 : li_curarea : " + li_curarea + "<BR>");
 // ---- End   ------ 현재 Group의 계산 ----------------------------------------- //

                 int tmpTot = li_Totcount - li_HowMany;

                 int spage =  ( li_limit * ( li_curarea - 1 ) ) + 1; // 시작 탭 위치

                 int epage;                                          // 종료 탭 위치
                 if ( ( li_limit * li_curarea ) >= li_totpage ) {
                     epage = li_totpage;
                 } else {
                     epage = ( li_limit * li_curarea );
                 }
 // ---- Start ------ ◀ 이전 몇 개 Tab ----------------------------------------- //
                 if ( spage - 1 < 1)         {
//                     out.print("[이전 " + li_limit + " 개]&nbsp;");
                		 
                     rtValue += "<img src='/images/btn_arr_LL.gif' style='filter:alpha(opacity=50);opacity:0.5;' align='absmiddle'>&nbsp;";
//                     out.print("◀ &nbsp;");
                 } else                      {
                     Tstart = ( ( li_MoreMany * ( spage - li_limit - 1 ) ) + 1 );
                     Tstart += li_interval;
                     if  ( li_curarea == 2 ) {
//                             out.print("<a href='" + P_target + "?p_start=1'>◀ 이전&nbsp;</a>");
                             rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event,1," + P_Totcount + ");return false;'><img src='/images/btn_arr_LL.gif' align='absmiddle'>&nbsp;</a>";
//                             out.print("<a href='#' onclick='PageTab(1," + P_Totcount + ",\"" + P_target + "\");return false;'>◀ &nbsp;</a>");
                     } else {
//                             out.print("<a href='" + P_target + "?p_start=" + Tstart + "'>◀ 이전&nbsp;</a>");
                             rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + P_Totcount + ");return false;'><img src='/images/btn_arr_LL.gif' align='absmiddle'>&nbsp;</a>";
//                             out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>◀ &nbsp;</a>");
                     }
                 }
 // ---- End   ------ ◀ 이전 몇 개 Tab ----------------------------------------- //

 // ---- Start ------ ◀ 한 Tab 씩 이동 ----------------------------------------- //
                 // <!-- 여기부터는 다음페이지와 이전페이지를 넘나들기위해서................... -->
                 if ( li_curpage > 1 ) {
                     Tstart = ( ( li_MoreMany * ( li_curpage - 2 ) ) + 1 );
                     Tstart += li_interval;
                     if  ( li_curarea == 1 ) {
                         if ( li_curpage == 2 ) {
                             rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event,1," + P_Totcount + ");return false;'><img src='/images/btn_arr_L.gif' align='absmiddle'>&nbsp;</a>";
//                             out.print("<a href='#' onclick='PageTab(1," + P_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>");
                         } else {
                             rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + P_Totcount + ");return false;'><img src='/images/btn_arr_L.gif' align='absmiddle'>&nbsp;</a>";
//                             out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>");
                         }
                     } else {
                             rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + P_Totcount + ");return false;'><img src='/images/btn_arr_L.gif' align='absmiddle'>&nbsp;</a>";
//                           out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>");
                     }
                 }
                 else {
                     rtValue += "<img src='/images/btn_arr_L.gif' style='filter:alpha(opacity=50);opacity:0.5;' align='absmiddle'>&nbsp;";                	 
//                      out.print("◀&nbsp;");
                 }
 // ---- End   ------ ◀ 한 Tab 씩 이동 ---------------------------------------- //

 // ---- Start ------ -------------- ------------------------------------------- //
 // 첫번째 Group의 첫번째 탭일 경우
 // 시작 탭위치를 1만큼 증가 시키고
 // 화면상에는 무조건 1을 출력 시킵니다.
                 if  ( li_curarea == 1 ) {
//                     rtValue += " |";
                     rtValue += " &nbsp;";                     
//                     out.print(" |");
                     spage++;
                     if ( li_curpage == 1 ) {
                         rtValue += "<B>1</B>";
//                         out.print("1");
                     } else {
                         rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event,1," + P_Totcount + ");return false;'>1</a>";
//                         out.print("<a href='#' onclick='PageTab( 1," + P_Totcount + ",\"" + P_target + "\");return false;'>1</a>");
                     }
                 }
 // ---- End   ------ -------------- ------------------------------------------- //

 // ---- Start ------ 숫자 Display Tab ----------------------------------------- //
                 for( int a = spage ; a <= epage; a++) {
//                     rtValue += " |";
                     rtValue += " &nbsp;";
//                     out.print(" |");
                     if ( a == li_curpage ) {
                         rtValue += "<B>" + a + "</B>";
                         //out.print(a);
                     }
                     else {
                     Tstart  = ( ( li_MoreMany * ( a - 1 ) ) + 1 );
                     Tstart += li_interval;
                         rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + P_Totcount + ");return false;'>" + a + "</a>";
//                         out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>" + a + "</a>");
                     }
                 }
 // ---- End   ------ 숫자 Display Tab ----------------------------------------- //

 // ---- Start ------ ▶ 한 Tab 씩 이동 ---------------------------------------- //
//                 rtValue += " | ";
                 rtValue += " &nbsp;";
//                 out.print(" | ");
         //        out.print("li_totpage : li_totpage / li_curpage  : li_curpage ");
                 if ( li_totpage > li_curpage ) {
                     Tstart = ( ( li_MoreMany * li_curpage ) + 1);
                     Tstart += li_interval;
                     rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + P_Totcount + ");return false;'>&nbsp;<img src='/images/btn_arr_R.gif' align='absmiddle'></a>";                     
//                   rtValue += "<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>&nbsp;▶</a>";
//                   out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>&nbsp;▶</a>");
                 }
                 else{
                     rtValue += "&nbsp;<img src='/images/btn_arr_R.gif' style='filter:alpha(opacity=50);opacity:0.5;' align='absmiddle'>";                	 
//                      out.print("&nbsp;▶");
                 }
 // ---- End   ------ ▶ 한 Tab 씩 이동 ---------------------------------------- //

 // ---- Start ------ ▶ 다음 몇 개 Tab ---------------------------------------- //
                 if ( epage == li_totpage ) {
//                  out.print("[다음 " + li_limit + " 개]&nbsp;");
                     rtValue += "&nbsp;<img src='/images/btn_arr_RR.gif' style='filter:alpha(opacity=50);opacity:0.5;' align='absmiddle'>";
//                     out.print("&nbsp;▶");
                 }
                 else {
                     Tstart = ( ( li_MoreMany * ( epage + 1 - 1 ) ) + 1 );
                     Tstart += li_interval;
//                      out.print("<a href='" + P_target + "?p_start=" + Tstart + "'>다음&nbsp;▶</a>");
                     rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + P_Totcount + ");return false;'>&nbsp;<img src='/images/btn_arr_RR.gif' align='absmiddle'></a>";
//                     out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>&nbsp;▶</a>");
                 }
 // ---- End   ------ ▶ 다음 몇 개 Tab ---------------------------------------- //
             }
         return rtValue;
     }
     /*
      페이지 Tab을 구성합니다.
     * @param P_start the String
     * @param P_Totcount the String
     * @param P_HowMany the String
     * @param P_MoreMany the String
     * @param P_limit the String
     * @param P_jsFunc the String
     public static String pageTab ( int P_start , int P_Totcount, int P_HowMany, int P_MoreMany, int P_limit,String P_jsFunc  )
         throws IOException
     {
         String rtValue = "";
         int curpage     = 0;    // 현재 위치
         int li_curpage  = 0;    // 현재 탭의 위치
         int li_HowMany  = 0;    // 첫번째 탭      에서 화면에 보여질 자료의 갯수
         int li_MoreMany = 0;    // 두번째 탭 이후 에서 화면에 보여질 자료의 갯수
         int li_Totcount = 0;    // 총 조회수
         int li_totpage  = 0;    // 총 탭의 갯수
         int li_limit    = P_limit;
         int li_interval = 0;

         String URL = "";
         li_HowMany  = P_HowMany;
         li_Totcount = P_Totcount;
             if ( li_Totcount > P_HowMany && P_HowMany != 0 ) {

//                 if ( P_Totcount <= P_HowMany + P_MoreMany ) { li_Totcount += li_HowMany; out.println ( "탄다" ) ;}

                 if ( P_MoreMany != 0 )   {   // 첫 페이지에 보여질 자료수
                     li_MoreMany = P_MoreMany;
                 } else                   {   // 첫 페이지 Default Set
                     li_MoreMany = 10;
                 }

                 li_Totcount = li_Totcount - li_HowMany + li_MoreMany;

 // ---- Start ------ HowMany만큼으로 첫번째 탭을 구성합니다.----------------------- //
   총 잘 갯수는 첫 페이지에 보여질 갯수 즉 li_HowMany 값 을 뺀 값을 사용합니다.
 // 만약 총 100 개의 자료 ( li_Totcount ) 가 있고
 // 첫 페이지에 보여질 자료수 ( P_HowMany ) 가 11 개
 // 두번째 페이지 부터 보여질 자료수가 ( P_MoreMany) 가 존재 한다면.
 // li_Totcount - P_HowMany 값을 총 조회수로 사용하여 페이지 Tab을 구성하고
 // 첫번째 그룹을 출력하는 경우
//       시작탭 + 1 ~ 종료탭 까지 출력 합니다.
//       시작탭             의 start : 무조건 1
//       시작탭 + 1 ~ 종료탭의 start : start + li_interval
 // 두번재 이후의 그룹일 경우
//       시작탭     ~ 종료탭
//       시작탭     ~ 종료탭의 start : start + li_interval
 // li_interval값은
 // 아래와 같이 설정 됩니다.
 -----------------------------------------------------------
                     li_HowMany  li_MoreMany  li_interval
 -----------------------------------------------------------
                         10          5           5
 -----------------------------------------------------------
                         3           5           3
                         3           5          -2
 -----------------------------------------------------------
 첫페이지에 보여질 자료와 그 다음 페이지의 자료수가 틀리게 설정되어 있지 않다면
 시작 위치는 1 , 6 , 11 , 16 , 21 ... 입니다. ( 실제 시작 위치 )
 하지만
             1 , 11 , 16 , 21 , 26 ...        ( 재계산된 시작 위치 )
             1 ,  4 ,  9 , 14 , 19 ...        ( 재계산된 시작 위치 )
 의 구성이 되어야 합니다.
 여기서 발생되는 5 와 -2 이라는 차이가 발생합니다. ( li_interval )

 재 계산된 시작위치가 넘어오면 실제 시작위치 + li_interval start값 ( curpage )을 재지정하면 됩니다.
 
//                 if ( li_HowMany >= li_MoreMany ) {
                     li_interval = li_HowMany - li_MoreMany;
//                 } else {
//                     li_interval = li_HowMany;
//                 }

 // ---- Start ------ 총 페이지수 산출 ------------------------------------------ //

                 if( P_start == 1 )      {   // 시작위치 Default Set
                     li_curpage=1;
                 } else                  {   // 시작 위치 지정
//                     if ( li_HowMany >= li_MoreMany ) {
                         curpage   = P_start - li_interval;   // 현재 위치
//                     } else {
//                         curpage   = P_start + li_interval + 2;
//                         out.println ( "2 : "  + curpage );
//                     }
                     li_curpage = ( ( curpage - 1 ) / li_MoreMany ) + 1;  // 현재 탭의 위치
                 }

//                 if ( li_HowMany < li_MoreMany ) {
//                     li_interval = ( li_interval * -1 ) + 1;
//                 }

 // ---- Start ------ 총 페이지수 산출 ------------------------------------------ //
                 li_totpage = ( li_Totcount / li_MoreMany );
                 // 페이수중에 여분의 레코드들을 출력하기위해  총페이지에 한페이지를 더함
                 if ( li_totpage * li_MoreMany < li_Totcount ) {          // 총 탭의 갯수
                     li_totpage = li_totpage + 1;
                 }
 // ---- End   ------ 총 페이지수 산출 ------------------------------------------ //

                 int     Tstart  = 0;
 // ---- Start ------ 현재 Group의 계산 ----------------------------------------- //
                 double  tmp     = li_curpage;

                 tmp = Math.ceil( tmp / li_limit );
                 Double ld_tmp = new Double ( tmp  );

                 int li_curarea = ld_tmp.intValue();

                 if  ( li_curarea == 0 ) li_curarea = 1;
//                 out.println(" 현재 Group의 계산 : li_curarea : " + li_curarea + "<BR>");
 // ---- End   ------ 현재 Group의 계산 ----------------------------------------- //

                 int tmpTot = li_Totcount - li_HowMany;

                 int spage =  ( li_limit * ( li_curarea - 1 ) ) + 1; // 시작 탭 위치

                 int epage;                                          // 종료 탭 위치
                 if ( ( li_limit * li_curarea ) >= li_totpage ) {
                     epage = li_totpage;
                 } else {
                     epage = ( li_limit * li_curarea );
                 }
 // ---- Start ------ ◀ 이전 몇 개 Tab ----------------------------------------- //
                 if ( spage - 1 < 1)         {
//                     out.print("[이전 " + li_limit + " 개]&nbsp;");
                     rtValue += "◀ &nbsp;";
//                     out.print("◀ &nbsp;");
                 } else                      {
                     Tstart = ( ( li_MoreMany * ( spage - li_limit - 1 ) ) + 1 );
                     Tstart += li_interval;
                     if  ( li_curarea == 2 ) {
//                             out.print("<a href='" + P_target + "?p_start=1'>◀ 이전&nbsp;</a>");
                             rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event,1," + P_Totcount + ");return false;'>◀ &nbsp;</a>";
//                             out.print("<a href='#' onclick='PageTab(1," + P_Totcount + ",\"" + P_target + "\");return false;'>◀ &nbsp;</a>");
                     } else {
//                             out.print("<a href='" + P_target + "?p_start=" + Tstart + "'>◀ 이전&nbsp;</a>");
                             rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + P_Totcount + ");return false;'>◀ &nbsp;</a>";
//                             out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>◀ &nbsp;</a>");
                     }
                 }
 // ---- End   ------ ◀ 이전 몇 개 Tab ----------------------------------------- //

 // ---- Start ------ ◀ 한 Tab 씩 이동 ----------------------------------------- //
                 // <!-- 여기부터는 다음페이지와 이전페이지를 넘나들기위해서................... -->
                 if ( li_curpage > 1 ) {
                     Tstart = ( ( li_MoreMany * ( li_curpage - 2 ) ) + 1 );
                     Tstart += li_interval;
                     if  ( li_curarea == 1 ) {
                         if ( li_curpage == 2 ) {
//                             rtValue += "<a href='#' onclick='PageTab(1," + P_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>";
//                             out.print("<a href='#' onclick='PageTab(1," + P_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>");
                         } else {
//                             rtValue += "<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>";
//                             out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>");
                         }
                     } else {
//                             rtValue += "<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>";
//                             out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>◀&nbsp;</a>");
                     }
                 }
                 else {
//                      out.print("◀&nbsp;");
                 }
 // ---- End   ------ ◀ 한 Tab 씩 이동 ---------------------------------------- //

 // ---- Start ------ -------------- ------------------------------------------- //
 // 첫번째 Group의 첫번째 탭일 경우
 // 시작 탭위치를 1만큼 증가 시키고
 // 화면상에는 무조건 1을 출력 시킵니다.
                 if  ( li_curarea == 1 ) {
                     rtValue += " |";
//                     out.print(" |");
                     spage++;
                     if ( li_curpage == 1 ) {
                         rtValue += "<B>1</B>";
//                         out.print("1");
                     } else {
                         rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event,1," + P_Totcount + ");return false;'>1</a>";
//                         out.print("<a href='#' onclick='PageTab( 1," + P_Totcount + ",\"" + P_target + "\");return false;'>1</a>");
                     }
                 }
 // ---- End   ------ -------------- ------------------------------------------- //

 // ---- Start ------ 숫자 Display Tab ----------------------------------------- //
                 for( int a = spage ; a <= epage; a++) {
                     rtValue += " |";
//                     out.print(" |");
                     if ( a == li_curpage ) {
                         rtValue += "<B>" + a + "</B>";
                         //out.print(a);
                     }
                     else {
                     Tstart  = ( ( li_MoreMany * ( a - 1 ) ) + 1 );
                     Tstart += li_interval;
                         rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + P_Totcount + ");return false;'>" + a + "</a>";
//                         out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>" + a + "</a>");
                     }
                 }
 // ---- End   ------ 숫자 Display Tab ----------------------------------------- //

 // ---- Start ------ ▶ 한 Tab 씩 이동 ---------------------------------------- //
                 rtValue += " | ";
//                 out.print(" | ");
         //        out.print("li_totpage : li_totpage / li_curpage  : li_curpage ");
                 if ( li_totpage > li_curpage ) {
                     Tstart = ( ( li_MoreMany * li_curpage ) + 1);
                     Tstart += li_interval;
//                   rtValue += "<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>&nbsp;▶</a>";
//                   out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>&nbsp;▶</a>");
                 }
                 else{
//                      out.print("&nbsp;▶");
                 }
 // ---- End   ------ ▶ 한 Tab 씩 이동 ---------------------------------------- //

 // ---- Start ------ ▶ 다음 몇 개 Tab ---------------------------------------- //
                 if ( epage == li_totpage ) {
//                  out.print("[다음 " + li_limit + " 개]&nbsp;");
                     rtValue += "&nbsp;▶";
//                     out.print("&nbsp;▶");
                 }
                 else {
                     Tstart = ( ( li_MoreMany * ( epage + 1 - 1 ) ) + 1 );
                     Tstart += li_interval;
//                      out.print("<a href='" + P_target + "?p_start=" + Tstart + "'>다음&nbsp;▶</a>");
                     rtValue += "<a href='#' class='page_navi_item' onclick='" + P_jsFunc + "(event," + Tstart + "," + P_Totcount + ");return false;'>&nbsp;▶</a>";
//                     out.print("<a href='#' onclick='PageTab(" + Tstart + "," + P_Totcount + ",\"" + P_target + "\");return false;'>&nbsp;▶</a>");
                 }
 // ---- End   ------ ▶ 다음 몇 개 Tab ---------------------------------------- //
             }
         return rtValue;
     }*/
}
