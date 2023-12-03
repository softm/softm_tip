/**
 * 진단평가 - 관리자
 * @version : 1.0
 * @author  : kim ji hun (softm@nate.com)
 */
package com.have.service.admin;

import java.sql.SQLException;
import java.util.List;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.ws.rs.FormParam;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;

import org.apache.commons.lang.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.have.common.Base;
import com.have.common.Sql;
import com.have.common.Util;
import com.have.var.TABLE;

// POJO, no interface no extends

//Sets the path to base URL + /hello

@Path("/admin/leveltest")
public class LevelTest extends Base {
    public LevelTest (@Context HttpServletRequest req, @Context HttpServletResponse res) throws Exception {
		super(req, res);
    }    
    
    /**
     * 유형관리  -조회
     * @param page navi 시작 위치
     * @return  조회데이터
     */
    @POST
    @Produces("application/json")
    @Path("type_list")
    public JSONObject getTypeList(
    		@FormParam("p_start") int p_start    		
    ) throws Exception{
        int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;    	
        JSONObject jsr = new JSONObject();
        if ( loginInfo.adminYn.equals("N") ) {        
        	jsr.put("return" , "-1"); // 로그인되있지 않음
        	jsr.put("data", ""); // data        	
        } else {
            try {        	
            	getConnection();            	
	        	jsr.put("return" , "1"); // 실행
	            	JSONArray jsa = new JSONArray();
	                StringBuffer sql = new StringBuffer();
	                sql.append(" SELECT  ")
	                   .append(" COUNT(*)")
	                   .append(" FROM " + TABLE.LEVELTEST_TYPE)
	                ;
	                int cnt = Sql.getCount(sql.toString(), this.conn);
	                System.out.print(this.conn);
	            jsr.put("count" , cnt); // 자료수                
	                sql.setLength(0);
	                sql.append(" SELECT ")
	                   .append(" T_ID    , ")
	                   .append(" T_TITLE , ")
	                   .append(" USE_YN  , ")
	                   .append(" date_format(REG_DATE,'%Y-%m-%d') REG_DATE, ")
	                   .append(" date_format(MOD_DATE,'%Y-%m-%d') MOD_DATE  ")                
	                   .append(" FROM " + TABLE.LEVELTEST_TYPE)
                       .append(" LIMIT ?, ? ")
                    ;
                    pstmt = conn.prepareStatement(sql.toString());
                    pstmt.setInt(1, p_start - 1);
                    pstmt.setInt(2, p_page_many);	                   
System.out.print("p_page_many : " + p_page_many);
	                rs  = pstmt.executeQuery( );
	                while ( rs.next() ) {
	    	            JSONObject jso = new JSONObject();		
	    	            jso.put("mode" 		, "V");
	    	            jso.put("t_id" 		, StringUtils.defaultString(rs.getString("T_ID"		)));
	    	            jso.put("t_title"  	, StringUtils.defaultString(rs.getString("T_TITLE"	)));
	    	            jso.put("use_yn"   	, StringUtils.defaultString(rs.getString("USE_YN"	)));
	    	            jso.put("reg_date" 	, StringUtils.defaultString(rs.getString("REG_DATE"	)));
	    	            jso.put("mod_date" 	, StringUtils.defaultString(rs.getString("MOD_DATE"	)));
	    	            jsa.put(jso);        	
	                }
		        jsr.put("data", jsa); // data
	            // Page Navi
	            jsr.put("page_navi", Sql.pageTab(p_start, cnt, Sql.page_navi_how_many, Sql.page_navi_more_many, Sql.page_navi_limit, "fList") );
            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
            	releaseConnection();                	
            }		        
        }
        return jsr;
    }
    
    /**
     * 유형관리  - 입력,수정,삭제
     * @param 실행 모드 ( I/U/D )
     * @param key
     * @param 유형명
     * @param 사용여부
     * @param 작성일자
     * @param 수정일자
     * @return  데이터 저장 처리
     */
    @POST
    @Produces("application/json")
  //@Consumes("application/x-www-form-urlencoded")
    @Path("type_write")
    public JSONObject writeType(@FormParam("p_mode"  ) List<String> p_mode    , 
					    		@FormParam("t_id"    ) List<String> p_t_id    ,
					    		@FormParam("t_title" ) List<String> p_t_title ,
					    		@FormParam("use_yn"  ) List<String> p_use_yn  ,
					    		@FormParam("reg_date") List<String> p_reg_date,
					    		@FormParam("mod_date") List<String> p_mod_date
    ) throws Exception{
        JSONObject jsr = new JSONObject();
        if ( loginInfo.adminYn.equals("N") ) {
        	jsr.put("return" , "-1"); // 로그인되있지 않음
        	jsr.put("data", ""); // data
        } else {
        	//Util.logger.info(req);
        	getConnection();  
        	try {
	    	    String mode       = "";
	    	    String t_id       = "";
	    	    String t_title    = "";
	    	    String use_yn     = "";
	    	    String reg_date   = "";
	    	    String mod_date   = "";
    	        System.out.println(" 1step" );	    	    
//    	        System.out.println(" p_mode_s : " + p_mode_s );	    	    
    	        System.out.println(" p_mode.length     : " +p_mode.size());	    	    
	    	    for(int i=1;i<p_mode.size();i++){
	    	        mode        = StringUtils.defaultString(p_mode.get(i)   );
	    	        t_id        = StringUtils.defaultString(p_t_id.get(i)	);
	    	        t_title     = StringUtils.defaultString(p_t_title.get(i));
	    	        use_yn      = StringUtils.defaultString(p_use_yn.get(i));
	    	        reg_date    = StringUtils.defaultString(p_reg_date.get(i));
	    	        mod_date    = StringUtils.defaultString(p_mod_date.get(i));
	    	      //out.println(" mode : " + mode+ "<BR>" );
	    	/**/
	    	        System.out.println(" mode     : " + mode    + "<BR>" );
	    	        System.out.println(" t_id     : " + t_id    + "<BR>" );
	    	        System.out.println(" t_title  : " + t_title + "<BR>" );
	    	        System.out.println(" use_yn   : " + use_yn  + "<BR>" );
	    	        System.out.println(" reg_date : " + reg_date+ "<BR>" );
	    	        System.out.println(" mod_date : " + mod_date+ "<BR>" );
	    	        
	    	        int sIdx = 0;
	
	    	        if ( mode.equals("I") ) {
	    	            sIdx++;
	    	            StringBuffer sql = new StringBuffer();
	    	            sql.append("INSERT INTO " + TABLE.LEVELTEST_TYPE + "(" )
	    	          //.append("T_ID    ,") // 1
	    	            .append("T_TITLE ,") // 2
	    	            .append("USE_YN  ,") // 3
	    	            .append("REG_DATE,") // 4
	    	          //gsbSQL.append("MOD_DATE,") // 5
	    	            .append("AC_ID    ") // 6
	    	            .append(" ) VALUES (")
	    	          //gsbSQL.append("?,")    // 1 
	    	            .append("?,")    // 2 
	    	            .append("?,")    // 3 
	    	            .append("now(),")// 4 
	    	          //.append("now(),")// 5 
	    	            .append("? ")    // 6 
	    	            .append(")")
	    	            ;
	    	            pstmt = conn.prepareStatement( sql.toString() );	            	            
	    	            
	    	          //pstmt.setString(sIdx++ , t_id      );
	    	            pstmt.setString(sIdx++ , t_title   );
	    	            pstmt.setString(sIdx++ , use_yn    );
	    	          //pstmt.setString(sIdx++ , reg_date  );
	    	          //pstmt.setString(sIdx++ , mod_date  );
	    	            pstmt.setInt(sIdx++ , Integer.parseInt((loginInfo.acId.equals("")?"0":loginInfo.acId))  );
	    	            pstmt.executeUpdate();
	    	        } else if ( mode.equals("U") ) {
	    	            sIdx++;
	    	            StringBuffer sql = new StringBuffer();
	    	            sql.append("UPDATE " + TABLE.LEVELTEST_TYPE + " SET " )
	    	             //.append("T_ID     = ?,") // 
	    	               .append("T_TITLE  = ?,") // 1
	    	               .append("USE_YN   = ?,") // 2
	    	             //.append("REG_DATE = ?,") // 3
	    	               .append("MOD_DATE = now() ") // 4
	    	               .append("WHERE T_ID  = ?") // 5
	    	            ; 
	    	          //out.println("gsbSQL.toString()  : " + gsbSQL.toString()+ "<BR>" );
	    	            pstmt = conn.prepareStatement( sql.toString() );
	    	            pstmt.setString(sIdx++ , t_title   );
	    	            pstmt.setString(sIdx++ , use_yn    );
	    	            pstmt.setString(sIdx++ , t_id      );
	
	    	          //pstmt.setString(sIdx++ , reg_date  );
	    	          //pstmt.setString(sIdx++ , mod_date  );
	    	            pstmt.executeUpdate();
	    	        } else if ( mode.equals("D") ) {
	    	            sIdx++;
	    	            StringBuffer sql = new StringBuffer();
	    	            sql.append("DELETE FROM " + TABLE.LEVELTEST_TYPE + "" )
	    	               .append(" WHERE T_ID  = ?") // 1
	    	            ; 
	    	            pstmt = conn.prepareStatement( sql.toString() );
	    	            pstmt.setString(sIdx++ , t_id         );
	    	            pstmt.executeUpdate();
	    	        }
	    	    }
	        	jsr.put("return" , "1"); // 성공
	    	} catch (Exception e) {
	    		Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
	        	jsr.put("return" , "-1"); // 실패	    		
	        	jsr.put("error" , e.toString()); // error message	    		
	    	} finally {
	    	    releaseConnection();
	    	}
        }
        return jsr;
    }
    
    /**
     * 시험지관리  - 조회
     * @param page navi 시작 위치
     * @return  조회데이터
     */
    @POST
    @Produces("application/json")
    @Path("paper_list")
    public JSONObject getPaperList(
    		@FormParam("p_start") int p_start 
    ) throws Exception{
        int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;        
        JSONObject jsr = new JSONObject();
        if ( loginInfo.adminYn.equals("N") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            try {
                getConnection();
                jsr.put("return" , "1"); // 실행
                    JSONArray jsa = new JSONArray();
                    StringBuffer sql = new StringBuffer();
                    sql.append(" SELECT  ")
                       .append(" COUNT(*)")
                       .append(" FROM " + TABLE.LEVELTEST_PAPER)
                    ;
                    int cnt = Sql.getCount(sql.toString(), this.conn);
                jsr.put("count" , cnt); // 자료수
                    sql.setLength(0);
                    sql.append(" SELECT ")
                       .append(" P_ID            , ")
                       .append(" P_TITLE         , ")
                       .append(" LEVEL_CD        , ")
                       .append(" GRADE_GB        , ")
                       .append(" STANDARD        , ")
                       .append(" PERIOD_TIME     , ")
                       .append(" TOTAL_CNT       , ")
                       .append(" PART_CNT        , ")
                       .append(" PASS_POINT      , ")
                       .append(" TOTAL_POINT     , ")                       
                       .append(" FILE_EXAM_NM    , ")
                       .append(" FILE_EXAM_EXT   , ")
                       .append(" FILE_CORRECT_NM , ")
                       .append(" FILE_CORRECT_EXT, ")
                       .append(" USE_YN          , ")
                       .append(" date_format(REG_DATE,'%Y-%m-%d') REG_DATE, ")
                       .append(" date_format(MOD_DATE,'%Y-%m-%d') MOD_DATE, ")
                       .append(" T_ID              ")
                       .append(" FROM " + TABLE.LEVELTEST_PAPER)
                       .append(" LIMIT ?, ? ")
                    ;
                    pstmt = conn.prepareStatement(sql.toString());
                    pstmt.setInt(1, p_start - 1);
                    pstmt.setInt(2, p_page_many);
                    
                    rs  = pstmt.executeQuery();
                    while ( rs.next() ) {
                        JSONObject jso = new JSONObject();
                        jso.put("mode"      , "V");
                        jso.put("p_id"            , StringUtils.defaultString(rs.getString("P_ID"            )));
                        jso.put("p_title"         , StringUtils.defaultString(rs.getString("P_TITLE"         )));
                        jso.put("level_cd"        , StringUtils.defaultString(rs.getString("LEVEL_CD"        )));
                        jso.put("grade_gb"        , StringUtils.defaultString(rs.getString("GRADE_GB"        )));
                        jso.put("standard"        , StringUtils.defaultString(rs.getString("STANDARD"        )));
                        jso.put("period_time"     , StringUtils.defaultString(rs.getString("PERIOD_TIME"     )));
                        jso.put("total_cnt"       , StringUtils.defaultString(rs.getString("TOTAL_CNT"       )));
                        jso.put("part_cnt"        , StringUtils.defaultString(rs.getString("PART_CNT"        )));
                        jso.put("pass_point"      , StringUtils.defaultString(rs.getString("PASS_POINT"      )));
                        jso.put("total_point"     , StringUtils.defaultString(rs.getString("TOTAL_POINT"     )));
                        jso.put("file_exam_nm"    , StringUtils.defaultString(rs.getString("FILE_EXAM_NM"    )));
                        jso.put("file_exam_ext"   , StringUtils.defaultString(rs.getString("FILE_EXAM_EXT"   )));
                        jso.put("file_correct_nm" , StringUtils.defaultString(rs.getString("FILE_CORRECT_NM" )));
                        jso.put("file_correct_ext", StringUtils.defaultString(rs.getString("FILE_CORRECT_EXT")));
                        jso.put("use_yn"          , StringUtils.defaultString(rs.getString("USE_YN"          )));
                        jso.put("reg_date"        , StringUtils.defaultString(rs.getString("REG_DATE"        )));
                        jso.put("mod_date"        , StringUtils.defaultString(rs.getString("MOD_DATE"        )));
                        jso.put("t_id"            , StringUtils.defaultString(rs.getString("T_ID"            )));
                        jsa.put(jso);
                    }
                jsr.put("data", jsa); // data
                    JSONObject jso_i_1 = new JSONObject();                    
                    // 유형
                    sql.setLength(0);
                    sql.append(" SELECT ")
                       .append(" T_ID    , ")
                       .append(" T_TITLE , ")
                       .append(" USE_YN  , ")
                       .append(" REG_DATE, ")
                       .append(" MOD_DATE, ")
                       .append(" AC_ID     ")
                       .append(" FROM " + TABLE.LEVELTEST_TYPE)
                    ;
                    stmt = conn.createStatement();
                    rs  = stmt.executeQuery( sql.toString() );
                    while ( rs.next() ) {
                    	jso_i_1.put(StringUtils.defaultString(rs.getString("T_ID"   )),StringUtils.defaultString(rs.getString("T_TITLE")));
                    }
                jsr.put("item_type", jso_i_1 ); // data 유형
                
                    JSONObject jso_i_2 = new JSONObject();                        
                    jso_i_2.put("K0","유치원" );
                    jso_i_2.put("E1","초1" );
                    jso_i_2.put("E2","초2" );
                    jso_i_2.put("E3","초3" );
                    jso_i_2.put("E4","초4" );
                    jso_i_2.put("E5","초5" );
                    jso_i_2.put("E6","초6" );
                    jso_i_2.put("M1","중1" );
                    jso_i_2.put("M2","중2" );
                    jso_i_2.put("M3","중3" );
                    jso_i_2.put("H1","고1" );
                    jso_i_2.put("H2","고2" );
                    jso_i_2.put("H3","고3" );
                    jso_i_2.put("G0","일반" );
                jsr.put("item_grade", jso_i_2 ); // 학년
                
	            // Page Navi
	            jsr.put("page_navi", Sql.pageTab(p_start, cnt, Sql.page_navi_how_many, Sql.page_navi_more_many, Sql.page_navi_limit, "fList") );
            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
                releaseConnection();
            }
        }
        return jsr;
    }

}