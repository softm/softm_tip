/**
 * 진단평가 - 관리자
 * @version : 1.0
 * @author  : kim ji hun (softm@nate.com)
 */
package com.have.service;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.ws.rs.DefaultValue;
import javax.ws.rs.FormParam;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.Context;

import org.apache.commons.lang.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.have.common.Base;
import com.have.common.Sql;
import com.have.common.Util;
import com.have.var.TABLE;
import com.wfPack.util.StringUtil;

// POJO, no interface no extends

//Sets the path to base URL + /hello

@Path("leveltest")
public class LevelTest extends Base {
    public LevelTest (@Context HttpServletRequest req, @Context HttpServletResponse res) throws Exception {
		super(req, res);
    }    
  
    /**
     * 진단테스트  - 조회
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
        if ( loginInfo.loginYn.equals("") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            try {
                getConnection();
                jsr.put("return" , "1"); // 실행
                    JSONArray jsa = new JSONArray();
                    StringBuffer sql = new StringBuffer();
                    /* 반 권한일경우 
                    sql.append(" SELECT ")
                       .append(" a.P_ID                                          P_ID, ")
                       .append(" DATEDIFF(IFNULL(a.EXP_DATE,'1970-01-01'),NOW()) REMIND_DAY  ")
                       .append(" FROM " + TABLE.LEVELTEST_BAN_JOIN_GRANT + " a" )
                       .append("  WHERE a.AC_ID  = " + loginInfo.acId )
                       .append("  AND   a.BAN_ID = '" + loginInfo.banId + "'")                   
                    ;
                    */
                    
                    /* 학생 권한일경우 */                    
                    sql.append(" SELECT ")
                       .append(" a.P_ID                                          P_ID, ")
                       .append(" DATEDIFF(IFNULL(a.EXP_DATE,'1970-01-01'),NOW()) REMIND_DAY  ")
                       .append(" FROM " + TABLE.LEVELTEST_STD_JOIN_GRANT + " a" )
                       .append("  WHERE a.AC_ID = " + loginInfo.acId )
                       .append("  AND   a.ST_ID = '" + loginInfo.memId + "'")                   
                    ;                    
                    pstmt = conn.prepareStatement(sql.toString());                
                    rs  = pstmt.executeQuery();
                    if ( loginInfo.memGb.equals("4") ) { // 학생
                    	if ( rs.next() ) {
                    		jsr.put("remind_day" , rs.getInt("REMIND_DAY"));
                        	jsr.put("p_id" , rs.getString("P_ID"));                    		
                    	} else {
                    		jsr.put("remind_day" ,-1);
                        	jsr.put("p_id" , "X");                    		
                    	}
                    } else {
                        jsr.put("p_id" , "0");
                    }
                    
                    sql.setLength(0);
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
                       .append(" WHERE USE_YN ='Y'")
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

    /**
     * 진단테스트  - 시험지 조회
     * @param page 시험지번호(p_id)
     * @return  조회데이터
     */
    @POST
    @Produces("application/json")
    @Path("paper")
    public JSONObject getPaper(
    		@FormParam("p_id") int p_id
    ) throws Exception{
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            try {
                getConnection();
                StringBuffer sql = new StringBuffer();
                /* 반 권한일경우             
                sql.append(" SELECT ")
                   .append(" DATEDIFF(IFNULL(a.EXP_DATE,'1970-01-01'),NOW()) REMIND_DAY  ")
                   .append(" FROM " + TABLE.LEVELTEST_BAN_JOIN_GRANT + " a" )
                   .append("  WHERE a.AC_ID  = " + loginInfo.acId )
                   .append("  AND   a.BAN_ID = '" + loginInfo.banId + "'")                   
                   .append("  AND   IF(a.P_ID=0,"+p_id+",a.P_ID) = " + p_id)                   
                ;
                */
                /* 학생 권한일경우 */                
                sql.append(" SELECT ")
                   .append(" DATEDIFF(IFNULL(a.EXP_DATE,'1970-01-01'),NOW()) REMIND_DAY  ")
                   .append(" FROM " + TABLE.LEVELTEST_STD_JOIN_GRANT + " a" )
                   .append("  WHERE a.AC_ID  = " + loginInfo.acId )
                   .append("  AND   a.ST_ID = '" + loginInfo.memId + "'")                   
                   .append("  AND   IF(a.P_ID=0,"+p_id+",a.P_ID) = " + p_id)                   
                ;
                
                int remindDay = Sql.getNumber(sql.toString(), this.conn);
                //System.out.print("loginInfo.memGb :" + loginInfo.memGb);
                if ( loginInfo.memGb.equals("4") && remindDay < 0 ) { // 학생이고 시험 미개방
                    jsr.put("return" , "-2"); // 시험설정 미개방 상태
                    jsr.put("data", ""); // data
                } else {
                    jsr.put("return", "1"); // 실행
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
                       .append(" WHERE P_ID = ? ")
                       .append(" AND   USE_YN ='Y'")                   
                    ; 
                    pstmt = conn.prepareStatement(sql.toString());
                    pstmt.setInt(1, p_id );

                    JSONObject jso = new JSONObject();
                    rs  = pstmt.executeQuery();
                    if ( rs.next() ) {
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
                        jsr.put("data",jso);
                    }
                	
                }
            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
                releaseConnection();
            }
        }
        return jsr;
    }
    /**
     * 진단테스트  - 레벨테스트-페이퍼-파트정보
     * @param page 시험지번호(p_id)
     * @return  조회데이터
     */
    @GET
    @Produces("application/json")
    @Path("paper_part")
    public JSONObject getPaperPart(
    		//@FormParam("p_id") int p_id
    		@QueryParam("p_id") int p_id
    ) throws Exception{
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
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
                       .append(" FROM " + TABLE.LEVELTEST_PAPER_PART)
                       .append(" WHERE P_ID = '"+p_id+"'")                       
                    ;
                    int cnt = Sql.getCount(sql.toString(), this.conn);
                jsr.put("count" , cnt); // 자료수
                    sql.setLength(0);
                    sql.append(" SELECT ")
                       .append(" P_ID       , ")
                       .append(" PART_NUM   , ")
                       .append(" START_I_NUM, ")
                       .append(" END_I_NUM  , ")
                       .append(" FILE_NM    , ")
                       .append(" FILE_EXT   , ")
                       .append(" QST_CNT    , ")
                       .append(" POINT      , ")
                       .append(" TOTAL_POINT  ")                       
                       .append(" FROM " + TABLE.LEVELTEST_PAPER_PART)
                       .append(" WHERE P_ID = ?")
                    ;
                    pstmt = conn.prepareStatement(sql.toString());
                    pstmt.setInt(1, p_id );                    
                    rs  = pstmt.executeQuery();
                    while ( rs.next() ) {
                        JSONObject jso = new JSONObject();
                        jso.put("mode"      , "V");
                        jso.put("p_id"                   , StringUtils.defaultString(rs.getString("P_ID"                   )));
                        jso.put("part_num"               , StringUtils.defaultString(rs.getString("PART_NUM"               )));
                        jso.put("start_i_num"            , StringUtils.defaultString(rs.getString("START_I_NUM"            )));
                        jso.put("end_i_num"              , StringUtils.defaultString(rs.getString("END_I_NUM"              )));
                        jso.put("file_nm"                , StringUtils.defaultString(rs.getString("FILE_NM"                )));
                        jso.put("file_ext"               , StringUtils.defaultString(rs.getString("FILE_EXT"               )));
                        jso.put("qst_cnt"                , StringUtils.defaultString(rs.getString("QST_CNT"                )));
                        jso.put("point"                  , StringUtils.defaultString(rs.getString("POINT"                  )));
                        jso.put("total_point"            , StringUtils.defaultString(rs.getString("TOTAL_POINT"            )));
                        jsa.put(jso);
                    }
                jsr.put("data",jsa);                    
            } catch ( SQLException e) {
                throw new SQLException(e.getMessage());
            } finally {
                releaseConnection();
            }
        }
        return jsr;
    }
    
    /**
     * 학생 시험지 풀기
     * @param 시험지번호
     * @param 레벨코드
     * @param 학교명
     * @param 학년
     * @param 사용자 답 ListArray
     * @param 유형번호
     * @return  json
     */
    @POST
    @Produces("application/json")
  //@Consumes("application/x-www-form-urlencoded")
    @Path("paper_solve")
    public JSONObject writeType(@FormParam("p_id"        ) int          p_id          ,
    							@FormParam("level_cd"    ) int          level_cd      ,
    							@FormParam("school_name" ) String       school_name   ,
    							@FormParam("grade_gb"    ) String       grade_gb      ,
                                @FormParam("i_num_answer") List<String> p_i_num_answer,
                                @FormParam("t_id"        ) int          t_id
    ) throws Exception{
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("N") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            //Util.logger.info(req);
            getConnection();
            conn.setAutoCommit(false);
            try {
                StringBuffer sql = new StringBuffer();
	            int newSeq = Sql.getNumber("SELECT IFNULL(MAX(SEQ ),0) + 1 " + 
	                				" FROM " + TABLE.LEVELTEST_ANSWER + 
	                				" WHERE MEM_ID= '" + loginInfo.memId + "'" + 	
	                				" AND   P_ID  =  " + p_id 	, conn);
	            sql.setLength(0);
                sql.append("INSERT INTO " + TABLE.LEVELTEST_ANSWER + "(" )
                   .append("MEM_ID   ,") // 1
                   .append("P_ID     ,") // 2
                   .append("SEQ      ,") // 4
                   .append("I_NUM    ,") // 5
                   .append("PART_NUM ,") // 5
                   .append("O_ANSWER ,") // 6
                   .append("S_ANSWER ,") // 7
                   .append("OX       ,") // 8
                   .append("POINT     ") // 9
                   .append(" ) ")
                ;
                stmt = conn.createStatement();
	    	    String i_num_answer       = "";
                StringBuffer i_sql = new StringBuffer();
                i_sql.append(" SELECT")
                    .append("'" + loginInfo.memId + "',")
                    .append(      p_id            + " ,")
                    .append(      newSeq		  + " ,")
	                .append("     c.I_NUM,")
	                .append("     d.PART_NUM,")
	                .append("     IF (QST_GB='O',d.ANSWER,'') O_ANSWER,")
	                .append("     IF (QST_GB='S',d.ANSWER,'') S_ANSWER,")
	                .append("     IF (c.CORRECT = d.ANSWER,'O','X'  ) OX   ,")
	                .append("     IF (c.CORRECT = d.ANSWER,c.POINT,0) POINT")
	                .append(" FROM")
	                .append(" (")
	                .append("     SELECT ")
	                .append("         I_NUM      ,")
	                .append("         QST_GB     ,")
	                .append("         if(QST_GB='O',O_CORRECT,S_CORRECT) CORRECT,")
	                .append("         POINT")
	                .append("     FROM leveltest_correct")
	                .append("     WHERE P_ID = " + p_id)
	                .append(" ) c,")
	                .append(" (")
	            ;
/*	    	    for(int i=1;i<p_i_num_answer.size();i++){
	    	    	i_num_answer = StringUtils.defaultString( p_i_num_answer.get(i) );
	    	    	i_num_answer = i_num_answer.equals("")?"0":i_num_answer;	    	    	
	    	    	i_sql.append("SELECT ")
                         .append(      i               + " I_NUM ,")
                         .append("'" + i_num_answer   + "' ANSWER ")
                         .append( i+1<p_i_num_answer.size()?"UNION ":"")
	    	    	;
	    	    }
*/
                LevelTest lObj1 = new LevelTest(request,response);
				// part 정보 얻기
	    		JSONObject paper_part_jsr = lObj1.getPaperPart(p_id);
	    		JSONArray  part_items     = paper_part_jsr.getJSONArray("data");
	    	    int part_num = 0;
	    	    int i_num = 0;
		    	for (int i=0;i<part_items.length();i++) {
		    		part_num = i+1;
		    		JSONObject item = part_items.getJSONObject(i);
		    	        int part_pos_min = item.getInt("start_i_num");
		    	        int part_pos_val = item.getInt("end_i_num");
		    	        for (int j=part_pos_min;j<=part_pos_val;j++) {
				    		i_num++;		    	        	
			    	    	i_num_answer = StringUtils.defaultString( p_i_num_answer.get(i_num) );
			    	    	i_num_answer = i_num_answer.equals("")?"0":i_num_answer;	    	    	
			    	    	i_sql.append("SELECT ")
		                         .append(      i_num          + " I_NUM ,")
		                         .append("'" + part_num       + "' PART_NUM,")
		                         .append("'" + i_num_answer   + "' ANSWER ")
		                         .append( i_num+1 < p_i_num_answer.size()?"UNION ":"")
			    	    	;
		    	        }
		    	}
	    	    i_sql.append(" ) d")	    	    
	    	         .append(" WHERE c.I_NUM = d.I_NUM")
	    	    ;
	    	    stmt.execute( sql.toString() + i_sql.toString() );

	    	    // paper정보 얻기
                //LevelTest lObj2 = new LevelTest(request,response);	    	    
	    	    //JSONObject paper_jsr = lObj2.getPaper(p_id);
	    	    //JSONObject paper_items  = paper_jsr.getJSONObject("data");
                sql.setLength(0);
                sql.append("INSERT INTO " + TABLE.LEVELTEST_ANSWER_RESULT + "(" )
	                .append("MEM_ID      ,") // 1
	                .append("P_ID        ,") // 2
	                .append("SEQ         ,") // 3
	                .append("CORRECT_CNT ,") // 4 
	                .append("SCORE       ,") // 5 
	                .append("TOTAL_POINT ,") // 6 
	                .append("REG_DATE    ,") // 7 
	                .append("AC_NAME     ,") // 8 
	                .append("MEM_NAME    ,") // 9 
	                .append("SCHOOL_NAME ,") // 10
	                .append("GRADE_GB    ,") // 11
	                .append("LEVEL_CD    ,") // 12
	                .append("T_ID        ,") // 13
	                .append("AC_ID       ,") // 14
	                .append("MEM_GB      ,") // 15
	                .append("BAN_ID      ,") // 16
	                .append("BAN_NAME     ") // 17
    	            .append(") ")               
	                .append("  SELECT ")
	                .append("  a.MEM_ID ,")
	                .append("  a.P_ID   ,")
	                .append("  a.SEQ    ,")                
	                .append("  sum(IF(a.OX='O',1,0)) CORRECT_CNT, ")
	                .append("  sum(a.POINT)          SCORE      , ")
	                .append("  b.TOTAL_POINT         TOTAL_POINT, ")
	                .append("  now()                            , ")
	                .append("'" + loginInfo.acName          + "',")
	                .append("'" + loginInfo.memName         + "',")
	                .append("'" + school_name               + "',")
	                .append("'" + grade_gb                  + "',")
	                .append("'" + level_cd                  + "',")
	                .append("'" + t_id                      + "',")
	                .append("" + (loginInfo.acId.equals("")?"NULL":loginInfo.acId)+ ",")
	                .append("'" + loginInfo.memGb           + "',")
	                .append("" + (loginInfo.banId.equals("")?"NULL":loginInfo.banId)+ ",")	                
	                .append("'" + loginInfo.banName         + "' ")
	                .append("  FROM " + TABLE.LEVELTEST_ANSWER + " a,leveltest_paper b ")
	                .append("  WHERE a.P_ID =" + p_id)
	                .append("  AND   a.SEQ = " + newSeq)
	                .append("  AND   a.MEM_ID = '" + loginInfo.memId + "'")
	                .append("  AND   a.P_ID = b.P_ID ")
	                .append("  GROUP BY a.MEM_ID, a.P_ID, a.SEQ ")
	            ;
                stmt.execute(sql.toString());
                sql.setLength(0);
                sql.append("INSERT INTO " + TABLE.LEVELTEST_ANSWER_RESULT_PAPER_PART + "(" )
                   .append("MEM_ID     ,") // 1
                   .append("P_ID       ,") // 2
                   .append("SEQ        ,") // 3
                   .append("PART_NUM   ,") // 4
                   .append("CORRECT_CNT,") // 5
                   .append("SCORE      ,") // 6
                   .append("TOTAL_POINT ") // 10
                   .append(") ")
                   .append("  SELECT ")
                   .append("  a.MEM_ID , ")
                   .append("  a.P_ID   , ")
                   .append("  a.SEQ    , ")
                   .append("  a.PART_NUM, ")
                   .append("  sum(IF(a.OX='O',1,0)) CORRECT_CNT,")
                   .append("  sum(a.POINT)          SCORE      ,")
                   .append("  b.TOTAL_POINT         TOTAL_POINT ")
                   .append("  FROM leveltest_answer a, leveltest_paper_part b ")
                   .append("  WHERE a.P_ID =" + p_id  )
                   .append("  AND   a.SEQ = " + newSeq)
                   .append("  AND   a.MEM_ID = '" + loginInfo.memId + "'")
                   .append("  AND   a.P_ID     = b.P_ID ")
                   .append("  AND   a.PART_NUM = b.PART_NUM ")                   
                   .append("  GROUP BY a.MEM_ID, a.P_ID, a.SEQ, a.PART_NUM ")
                ;                
                stmt.execute(sql.toString());
                //if ( true ) {
                //    Exception e = new Exception("오류발생");
                //    throw e;
                //} else {
                jsr.put("return" , "1"); // 성공
                //}
            } catch (Exception e) {
                Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
                jsr.put("return" , "-1"); // 실패
                jsr.put("error" , e.toString()); // error message
                conn.rollback();
            } finally {
                conn.commit();            	
                releaseConnection();
            }
        }
        return jsr;
    }
    
    /**
     * 진단테스트결과  - 조회
     * @param 레별코드(1,2,~~~~n)
     * @param page navi 시작 위치
     * @return  조회데이터
     */
    @POST
    @Produces("application/json")
    @Path("my_result")
    public JSONObject getPaperList(
    		@FormParam("p_level_cd" ) int p_level_cd,
    		@FormParam("p_start"    ) int p_start
    ) throws Exception{
        int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            try {
                getConnection();
                jsr.put("return" , "1"); // 실행
                    JSONArray jsa = new JSONArray();
                    StringBuffer sql = new StringBuffer();
                    StringBuffer where= new StringBuffer();
                    if ( !loginInfo.acId.equals("") ) {
                    	where.append(" AND a.AC_ID = " + loginInfo.acId + "");
                    }
                    if ( p_level_cd!=0 ) {
                        where.append(" AND a.LEVEL_CD = " + p_level_cd + "");
                    }
                    sql.append(" SELECT  ")
                       .append(" COUNT(distinct CONCAT(a.P_ID,a.SEQ))")
                       .append(" FROM " + TABLE.LEVELTEST_ANSWER_RESULT + " a," + TABLE.LEVELTEST_ANSWER_RESULT_PAPER_PART + " b")
                       .append(" WHERE a.MEM_ID   = '" + loginInfo.memId + "'")
                       .append(" AND   a.P_ID     = b.P_ID  ")
                       .append(" AND   a.SEQ      = b.SEQ   ")
                       .append( where.toString() )
                       .append(" GROUP BY a.MEM_ID ")                       
                    ;
                    int cnt = Sql.getCount(sql.toString(), this.conn);
                jsr.put("count" , cnt); // 자료수
                    sql.setLength(0);

                    sql.append(" SELECT ")
                       .append(" date_format(a.REG_DATE,'%Y-%m-%d %H:%i:%s')   REG_DATE        , ")
                       .append(" a.P_ID                             P_ID            , ")
                       .append(" p.P_TITLE                          P_TITLE         , ")                       
                       .append(" b.SEQ                              SEQ             , ")
                       .append(" a.LEVEL_CD                         LEVEL_CD        , ")
                       .append(" SUBSTRING_INDEX(GROUP_CONCAT(b.PART_NUM    ORDER BY b.PART_NUM SEPARATOR ','),',',3)        PART_NUM        , ")
                       .append(" SUBSTRING_INDEX(GROUP_CONCAT(b.CORRECT_CNT ORDER BY b.PART_NUM SEPARATOR ','),',',3)        PART_CORRECT_CNT, ")
                       .append(" SUBSTRING_INDEX(GROUP_CONCAT(b.SCORE       ORDER BY b.PART_NUM SEPARATOR ','),',',3)        PART_SCORE      , ")
                       .append(" SUBSTRING_INDEX(GROUP_CONCAT(b.TOTAL_POINT ORDER BY b.PART_NUM SEPARATOR ','),',',3)        PART_TOTAL_POINT, ")
                       .append(" a.SCORE                            TOTAL_SCORE     , ")
                       .append(" a.TOTAL_POINT                      TOTAL_POINT       ")
                       .append(" FROM " + TABLE.LEVELTEST_ANSWER_RESULT + " a") 
                       .append(" LEFT OUTER JOIN " + TABLE.LEVELTEST_PAPER + " p ON a.P_ID = p.P_ID")                    		   
                       .append("," + TABLE.LEVELTEST_ANSWER_RESULT_PAPER_PART + " b")
                       .append(" WHERE a.MEM_ID   = '" + loginInfo.memId + "'")
                       .append(" AND   a.P_ID     = b.P_ID  ")
                       .append(" AND   a.SEQ      = b.SEQ   ")
                       .append( where.toString() )
                       .append(" GROUP BY a.P_ID, a.SEQ     ")
                       .append(" ORDER BY a.REG_DATE DESC")
                       .append(" LIMIT ?, ? ")
                    ;
                    //Util.logger.info("sql.toString() : " + sql.toString());
                    pstmt = conn.prepareStatement(sql.toString());
                    pstmt.setInt(1, p_start - 1);
                    pstmt.setInt(2, p_page_many);

                    rs  = pstmt.executeQuery();
                    while ( rs.next() ) {
                        JSONObject jso = new JSONObject();
                        jso.put("reg_date"          , StringUtils.defaultString(rs.getString("REG_DATE"         )));
                        jso.put("p_id"              , StringUtils.defaultString(rs.getString("P_ID"             )));
                        jso.put("p_title"           , StringUtils.defaultString(rs.getString("P_TITLE"          )));
                        jso.put("seq"               , StringUtils.defaultString(rs.getString("SEQ"              )));
                        jso.put("level_cd"          , StringUtils.defaultString(rs.getString("LEVEL_CD"         )));
                        jso.put("part_num"          , StringUtils.defaultString(rs.getString("PART_NUM"         )));
                        jso.put("part_num"          , StringUtils.defaultString(rs.getString("PART_NUM"         )));
                        jso.put("part_correct_cnt"  , StringUtils.defaultString(rs.getString("PART_CORRECT_CNT" )));
                        jso.put("part_score"        , StringUtils.defaultString(rs.getString("PART_SCORE"       )));
                        jso.put("part_total_point"  , StringUtils.defaultString(rs.getString("PART_TOTAL_POINT" )));
                        jso.put("total_score"       , StringUtils.defaultString(rs.getString("TOTAL_SCORE"      )));
                        jso.put("total_point"       , StringUtils.defaultString(rs.getString("TOTAL_POINT"      )));
                        jsa.put(jso);
                    }
                    jsr.put("data",jsa);
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
     * 성적표  - 조회
     * @param page 시험지번호(p_id)
     * @param page 순번(p_seq)
     * @param 회원아이디 (p_mem_id) : 원장,교사가 시험지를 볼경우에만 해당됨
     * @return  조회데이터
     */
    @POST
    @Produces("application/json")
    @Path("report_card")
    public JSONObject getReportCard(
            @FormParam("p_id" ) int p_id,
            @FormParam("p_seq") int p_seq,
            @DefaultValue("") @FormParam("p_mem_id") String p_mem_id
    ) throws Exception{
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            try {
                getConnection();
                StringBuffer sql = new StringBuffer();
                // 레벨테스트-결과 & 레벨테스트-페이퍼-통계
                JSONObject jso_1 = new JSONObject();
                sql.append(" SELECT ")
                   //.append(" a.MEM_ID       MEM_ID      , ")
                   //.append(" a.P_ID         P_ID        , ")
                   //.append(" a.SEQ          SEQ         , ")
                   .append(" a.CORRECT_CNT  CORRECT_CNT , ")
                   .append(" a.SCORE        SCORE       , ")
                   .append(" a.TOTAL_POINT  TOTAL_POINT , ")
                   .append(" a.REG_DATE     REG_DATE    , ")
                   .append(" a.AC_NAME      AC_NAME     , ")
                   .append(" a.MEM_NAME     MEM_NAME    , ")
                   .append(" a.SCHOOL_NAME  SCHOOL_NAME , ")
                   .append(" a.GRADE_GB GRADE_GB, ")
                   .append(" a.LEVEL_CD     LEVEL_CD    , ")
                   .append(" a.T_ID         T_ID        , ")
                   .append(" a.AC_ID        AC_ID       , ")
                   .append(" a.MEM_GB       MEM_GB      , ")
                   .append(" IFNULL(b.AVG_SCORE,0)    AVG_SCORE ,")
                   .append(" p.P_TITLE      P_TITLE       ")
                   .append(" FROM " + TABLE.LEVELTEST_ANSWER_RESULT + " a ")
                   .append(" LEFT OUTER JOIN " + TABLE.LEVELTEST_STATISTICS_PAPER + " b ON a.P_ID = b.P_ID")
                   .append(" LEFT OUTER JOIN " + TABLE.LEVELTEST_PAPER + " p ON a.P_ID = p.P_ID")
                   .append("  WHERE a.AC_ID  " + ( Integer.parseInt(loginInfo.memGb)>=2?"= ?":"is ?" ))
                   .append("  AND   a.MEM_ID = ?")
                   .append("  AND   a.P_ID   = ?")
                   .append("  AND   a.SEQ    = ?")
                ;
                pstmt = conn.prepareStatement(sql.toString());
                if ( Integer.parseInt(loginInfo.memGb)>=2 ) {
                    pstmt.setString (1,loginInfo.acId);                
                } else {
                	pstmt.setNull  (1, java.sql.Types.NULL);                	
                }

                pstmt.setString (2, !p_mem_id.equals("") && ( loginInfo.memGb.equals("2")||loginInfo.memGb.equals("3"))?p_mem_id:loginInfo.memId );
                pstmt.setInt    (3, p_id            );
                pstmt.setInt    (4, p_seq           );
                rs  = pstmt.executeQuery();
                if ( rs.next() ) {
                	//jso_1.put("mem_id"      ,StringUtils.defaultString(rs.getString("MEM_ID"      )));
                	//jso_1.put("p_id"        ,StringUtils.defaultString(rs.getString("P_ID"        )));
                	//jso_1.put("seq"         ,StringUtils.defaultString(rs.getString("SEQ"         )));
                    jso_1.put("correct_cnt" ,StringUtils.defaultString(rs.getString("CORRECT_CNT" )));
                    jso_1.put("score"       ,StringUtils.defaultString(rs.getString("SCORE"       )));
                    jso_1.put("total_point" ,StringUtils.defaultString(rs.getString("TOTAL_POINT" )));
                    jso_1.put("reg_date"    ,StringUtils.defaultString(rs.getString("REG_DATE"    )));
                    jso_1.put("ac_name"     ,StringUtils.defaultString(rs.getString("AC_NAME"     )));
                    jso_1.put("mem_name"    ,StringUtils.defaultString(rs.getString("MEM_NAME"    )));
                    jso_1.put("school_name" ,StringUtils.defaultString(rs.getString("SCHOOL_NAME" )));
                    jso_1.put("grade_gb"    ,StringUtils.defaultString(rs.getString("GRADE_GB"    )));
                    jso_1.put("level_cd"    ,StringUtils.defaultString(rs.getString("LEVEL_CD"    )));
                    jso_1.put("t_id"        ,StringUtils.defaultString(rs.getString("T_ID"        )));
                    jso_1.put("ac_id"       ,StringUtils.defaultString(rs.getString("AC_ID"       )));
                    jso_1.put("mem_gb"      ,StringUtils.defaultString(rs.getString("MEM_GB"      )));
                    jso_1.put("avg_score"   ,StringUtils.defaultString(rs.getString("AVG_SCORE"   )));
                    jso_1.put("p_title"     ,StringUtils.defaultString(rs.getString("P_TITLE"     )));
                    
	                // 레벨테스트-답변
	                JSONArray jsa = new JSONArray();
	                sql.setLength(0);                
	                sql.append(" SELECT ")
	                   //.append(" MEM_ID  , ")
	                   //.append(" P_ID    , ")
	                   //.append(" SEQ     , ")
	                   .append(" PART_NUM, ")
	                   .append(" I_NUM   , ")
	                   .append(" O_ANSWER, ")
	                   .append(" S_ANSWER, ")
	                   .append(" OX      , ")
	                   .append(" POINT     ")
	                   .append(" FROM " + TABLE.LEVELTEST_ANSWER)
	                   .append("  WHERE MEM_ID = ?")
	                   .append("  AND   P_ID   = ?")
	                   .append("  AND   SEQ    = ?")
	                   .append("  ORDER BY I_NUM")
	                ;
	                pstmt = conn.prepareStatement(sql.toString());
	                pstmt.setString (1, !p_mem_id.equals("") && ( loginInfo.memGb.equals("2")||loginInfo.memGb.equals("3"))?p_mem_id:loginInfo.memId );
	                pstmt.setInt    (2, p_id            );
	                pstmt.setInt    (3, p_seq           );
	
	                rs  = pstmt.executeQuery();
	                while ( rs.next() ) {
	                    JSONObject jso = new JSONObject();
	                    //jso.put("mem_id"  , StringUtils.defaultString(rs.getString("MEM_ID"              )));
	                    //jso.put("p_id"    , StringUtils.defaultString(rs.getString("P_ID"                )));
	                    //jso.put("seq"     , StringUtils.defaultString(rs.getString("SEQ"                 )));
	                    jso.put("part_num", StringUtils.defaultString(rs.getString("PART_NUM"            )));
	                    jso.put("i_num"   , StringUtils.defaultString(rs.getString("I_NUM"               )));
	                    jso.put("o_answer", StringUtils.defaultString(rs.getString("O_ANSWER"            )));
	                    jso.put("s_answer", StringUtils.defaultString(rs.getString("S_ANSWER"            )));
	                    jso.put("ox"      , StringUtils.defaultString(rs.getString("OX"                  )));
	                    jso.put("point"   , StringUtils.defaultString(rs.getString("POINT"               )));
	                    jsa.put(jso);
	                }
	                jsr.put("data_leveltest_answer", jsa); // data 레벨테스트-답변
	
	                // 레벨테스트-파트별-결과 & 레벨테스트-페이퍼-파트정보-통계
	                JSONArray jsa_1 = new JSONArray();
	                sql.setLength(0);
	                sql.append(" SELECT ")
	                   //.append(" a.MEM_ID      MEM_ID     , ")
	                   //.append(" a.P_ID        P_ID       , ")
	                   //.append(" a.SEQ         SEQ        , ")
	                   .append(" a.PART_NUM    PART_NUM   , ")
	                   .append(" a.CORRECT_CNT CORRECT_CNT, ")
	                   .append(" a.SCORE       SCORE      , ")
	                   .append(" a.TOTAL_POINT TOTAL_POINT, ")
	
	                   .append(" b.START_I_NUM START_I_NUM, ")
	                   .append(" b.END_I_NUM   END_I_NUM  , ")
	                   //.append(" b.TOTAL_POINT FILE_NM    , ")
	                   //.append(" b.TOTAL_POINT FILE_EXT   , ")
	                   .append(" b.QST_CNT     QST_CNT    , ")
	                   
	                   .append(" IFNULL(c.AVG_SCORE,0)   AVG_SCORE    ")
	                   .append(" FROM " + TABLE.LEVELTEST_ANSWER_RESULT_PAPER_PART + " a," + TABLE.LEVELTEST_PAPER_PART + " b ")
	                   .append(" LEFT OUTER JOIN "+ TABLE.LEVELTEST_STATISTICS_PAPER_PART + " c ON b.P_ID = c.P_ID AND b.PART_NUM = c.PART_NUM")
	                   .append("  WHERE a.MEM_ID   = ?")
	                   .append("  AND   a.P_ID     = ?")
	                   .append("  AND   a.SEQ      = ?")
	                   .append("  AND   a.P_ID     = b.P_ID")
	                   .append("  AND   a.PART_NUM = b.PART_NUM")
	                   .append("  ORDER BY a.PART_NUM")
	                ;
	                pstmt = conn.prepareStatement(sql.toString());
	                pstmt.setString (1, !p_mem_id.equals("") && ( loginInfo.memGb.equals("2")||loginInfo.memGb.equals("3"))?p_mem_id:loginInfo.memId );
	                pstmt.setInt    (2, p_id            );
	                pstmt.setInt    (3, p_seq           );
	
	                rs  = pstmt.executeQuery();
	                while ( rs.next() ) {
	                    JSONObject jso = new JSONObject();
	                    //jso.put("mem_id"     , StringUtils.defaultString(rs.getString("MEM_ID"                   )));
	                    //jso.put("p_id"       , StringUtils.defaultString(rs.getString("P_ID"                     )));
	                    //jso.put("seq"        , StringUtils.defaultString(rs.getString("SEQ"                      )));
	                    jso.put("part_num"   , StringUtils.defaultString(rs.getString("PART_NUM"                 )));
	                    jso.put("correct_cnt", StringUtils.defaultString(rs.getString("CORRECT_CNT"              )));
	                    jso.put("score"      , StringUtils.defaultString(rs.getString("SCORE"                    )));
	                    jso.put("total_point", StringUtils.defaultString(rs.getString("TOTAL_POINT"              )));
	
	                    jso.put("start_i_num", StringUtils.defaultString(rs.getString("START_I_NUM"              )));
	                    jso.put("end_i_num"  , StringUtils.defaultString(rs.getString("END_I_NUM"                )));
	                    //jso.put("file_nm"    , StringUtils.defaultString(rs.getString("FILE_NM"                  )));
	                    //jso.put("file_ext"   , StringUtils.defaultString(rs.getString("FILE_EXT"                 )));
	                    jso.put("qst_cnt"    , StringUtils.defaultString(rs.getString("QST_CNT"                  )));
	
	                    jso.put("avg_score"  , StringUtils.defaultString(rs.getString("AVG_SCORE"                )));
	                    jsa_1.put(jso);
	                }
	                jsr.put("data_leveltest_answer_result_paper_part", jsa_1); // data 레벨테스트-답변
	
	                jsr.put("return" , "1"); // 실행                    
                }
                jsr.put("data_leveltest_answer_result", jso_1 ); // data 레벨테스트-결과
            } catch ( SQLException e) {
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
     * 레벨테스트 결과보기 - 조회 ( 원장, 교사 )
     * @param 레별코드(1,2,~~~~n)
     * @param page navi 시작 위치
     * @return  조회데이터
     */
    @POST
    @Produces("application/json")
    @Path("cap/leveltest_result_main")
    public JSONObject getLevelTestResultListMain(
    		@FormParam("p_id" ) int p_id,
    		@DefaultValue("") @FormParam("p_ban_id"   ) String p_ban_id,
    		@DefaultValue("") @FormParam("p_mem_name" ) String p_mem_name,
    		@FormParam("p_start"    ) int p_start
    ) throws Exception{
        //int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;
        int p_page_many  = 10;
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            try {
                getConnection();
                JSONArray jsa = new JSONArray();
                StringBuffer sql = new StringBuffer();
                StringBuffer where= new StringBuffer();

//////////////////////////////////////////////////////
                // 레벨테스트-파트별-결과 & 레벨테스트-페이퍼-파트정보-통계
/*
select '1' gb, ban_id, ban_name ,a.TCH_ID from ban a where a.AC_ID = 335 and a.TCH_ID = 'havetc'
union all
select '0' gb, ban_id, ban_name ,'' from leveltest_answer_result a where a.AC_ID = 335
*/
                JSONArray jsa_1 = new JSONArray();
                if ( loginInfo.memGb.equals("2") || loginInfo.memGb.equals("3") ) {
                    sql.setLength(0);
                    sql.append(" SELECT P_ID, P_TITLE  ")
                       .append(" FROM " + TABLE.LEVELTEST_PAPER )
                       .append(" WHERE USE_YN ='Y'")
                    ;
                    pstmt = conn.prepareStatement(sql.toString());
                    rs  = pstmt.executeQuery();
                    /*
                    JSONObject jso_paper = new JSONObject();
                    jso_paper.put("0", "-응시등급-");
                    while ( rs.next() ) {
                    	jso_paper.put(rs.getString("P_ID"), StringUtils.defaultString(rs.getString("P_TITLE")));
                    }
                    jsr.put("data_paper", jso_paper); // data paper
                    */
                    sql.setLength(0);
                    sql.append(" SELECT '1' GB, BAN_ID, BAN_NAME ,TCH_ID  ")
                       .append(" FROM " + TABLE.BAN )
                       .append("  WHERE AC_ID    = ?")
                    ;
                    if ( loginInfo.memGb.equals("2") ) { // 원장
                        sql.append(" UNION ")
                           .append(" SELECT '0' GB, BAN_ID, BAN_NAME ,'' FROM " + TABLE.LEVELTEST_ANSWER_RESULT +" WHERE BAN_ID is not null AND AC_ID = ?");
                        pstmt = conn.prepareStatement(sql.toString());
                        pstmt.setString (1, loginInfo.acId  );
                        pstmt.setString (2, loginInfo.acId  );
                    } else if ( loginInfo.memGb.equals("3") ) { // 교사
                        sql.append("  AND   TCH_ID   = ? ");
                        pstmt = conn.prepareStatement(sql.toString());
                        pstmt.setString (1, loginInfo.acId  );
                        pstmt.setString (2, loginInfo.memId );
                    }
                    rs  = pstmt.executeQuery();
                    List<String> inBans = new ArrayList<String>();
                    JSONObject jso_ban = new JSONObject();        
                	jso_ban.put("", "-반선택-");                    
                    while ( rs.next() ) {
                    	if ( StringUtils.defaultString(jso_ban.optString(rs.getString("BAN_ID"))).equals("") ) {
                    		if ( StringUtils.defaultString(rs.getString("GB")).equals("0") ) {
                    			jso_ban.put(rs.getString("BAN_ID"), "옛날반-" + StringUtils.defaultString(rs.getString("BAN_NAME")));
                    		} else {
                        		jso_ban.put(rs.getString("BAN_ID"), StringUtils.defaultString(rs.getString("BAN_NAME")));                    		
                    		}
                    	}
                        inBans.add(StringUtils.defaultString(rs.getString("BAN_ID")));
                    }
                    String inBan[] = inBans.toArray(new String[0]);
                    jsr.put("data_ban", jso_ban); // data 반
                    if ( loginInfo.memGb.equals("3") ) { 
                    	if ( inBan.length>0 ) {
                            where.append(" AND BAN_ID in (" + StringUtil.join(",", inBan) + ")");                    		
                    	}
                    }                    
                }
//////////////////////////////////////////////////////
                if ( p_id != 0 ) {
                    where.append(" AND P_ID = " + p_id + "");
                }
                if ( !p_ban_id.equals("") ) {
                	where.append(" AND BAN_ID = " + p_ban_id + "");
                }
                if ( !p_mem_name.equals("") ) {
                	where.append(" AND MEM_NAME LIKE '" + p_mem_name + "%'");
                }
                sql.setLength(0);                
                sql.append(" SELECT  ")
                   .append(" COUNT(DISTINCT MEM_ID) ")
                   .append(" FROM " + TABLE.LEVELTEST_ANSWER_RESULT + "")
                   .append(" WHERE AC_ID   = '" + loginInfo.acId + "'")
                   .append( where.toString() )
                ;
                int cnt = Sql.getCount(sql.toString(), this.conn);
                System.out.println("cnt : " + cnt);
                jsr.put("count" , cnt); // 자료수
                sql.setLength(0);
                sql.append(" SELECT                                                ")
                .append("     MEM_ID                           MEM_ID          ,")
                .append("     MEM_NAME                         MEM_NAME        ,")
                .append("     BAN_ID                           BAN_ID          ,")
                .append("     BAN_NAME                         BAN_NAME        ,")
                .append("     MAX(date_format(REG_DATE,'%Y-%m-%d %H:%i:%s'))                    REG_DATE        ,")
                .append("     COUNT(P_ID)                      P_CNT           ,")
                .append("     AVG(SCORE)                       AVG_SCORE       ,")
                .append("     AVG(TOTAL_POINT)                 AVG_TOTAL_POINT  ")
                .append(" FROM " + TABLE.LEVELTEST_ANSWER_RESULT + "")
                .append(" WHERE AC_ID    = '" + loginInfo.acId + "'")
                .append( where.toString() )
                .append(" GROUP BY MEM_ID ")
              //.append(" ORDER BY a.REG_DATE DESC")
                .append(" LIMIT ?, ? ")
             ;
             pstmt = conn.prepareStatement(sql.toString());
             pstmt.setInt(1, p_start - 1);
             pstmt.setInt(2, p_page_many);

             rs  = pstmt.executeQuery();
             while ( rs.next() ) {
                 JSONObject jso = new JSONObject();
                 jso.put("mem_id"                   , StringUtils.defaultString(rs.getString("MEM_ID"                  )));
                 jso.put("mem_name"                 , StringUtils.defaultString(rs.getString("MEM_NAME"                )));
                 jso.put("ban_id"                   , StringUtils.defaultString(rs.getString("BAN_ID"                  )));
                 jso.put("ban_name"                 , StringUtils.defaultString(rs.getString("BAN_NAME"                )));
                 jso.put("reg_date"                 , StringUtils.defaultString(rs.getString("REG_DATE"                )));
                 jso.put("p_cnt"                    , StringUtils.defaultString(rs.getString("P_CNT"                   )));
                 jso.put("avg_score"                , StringUtils.defaultString(rs.getString("AVG_SCORE"               )));
                 jso.put("avg_total_point"          , StringUtils.defaultString(rs.getString("AVG_TOTAL_POINT"         )));
                 jsa.put(jso);
             }
                jsr.put("data",jsa);
	            // Page Navi
	            jsr.put("page_navi", Sql.pageTab(p_start, cnt, p_page_many, p_page_many, Sql.page_navi_limit, "fListMain") );	            
                jsr.put("return" , "1"); // 실행
            } catch ( SQLException e) {
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
     * 레벨테스트 결과보기 - 조회 ( 원장, 교사 )
     * @param 레별코드(1,2,~~~~n)
     * @param page navi 시작 위치
     * @return  조회데이터
     */
    @POST
    @Produces("application/json")
    @Path("cap/leveltest_result_detail")
    public JSONObject getLevelTestResultListDetail(
    		@FormParam("p_mem_id" ) String p_mem_id,
    		@FormParam("p_start"  ) int p_start
    ) throws Exception{
        //int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;
        int p_page_many  = 10;
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            try {
                getConnection();
                JSONArray jsa = new JSONArray();
                StringBuffer sql = new StringBuffer();
                StringBuffer where= new StringBuffer();

//////////////////////////////////////////////////////
                // 레벨테스트-파트별-결과 & 레벨테스트-페이퍼-파트정보-통계
/*
select '1' gb, ban_id, ban_name ,a.TCH_ID from ban a where a.AC_ID = 335 and a.TCH_ID = 'havetc'
union all
select '0' gb, ban_id, ban_name ,'' from leveltest_answer_result a where a.AC_ID = 335
*/
                where.append(" AND a.MEM_ID = '" + p_mem_id + "'");
                
                JSONArray jsa_1 = new JSONArray();
                sql.setLength(0);                
                sql.append(" SELECT  ")
                   .append(" COUNT(distinct CONCAT(a.P_ID,a.SEQ))")
                   .append(" FROM " + TABLE.LEVELTEST_ANSWER_RESULT + " a," + TABLE.LEVELTEST_ANSWER_RESULT_PAPER_PART + " b")
                   .append(" WHERE a.AC_ID   = '" + loginInfo.acId + "'")
                   .append(" AND   a.P_ID     = b.P_ID  ")
                   .append(" AND   a.SEQ      = b.SEQ   ")
                   .append( where.toString() )
                   .append(" GROUP BY a.AC_ID ")                       
                ;
                int cnt = Sql.getCount(sql.toString(), this.conn);
                jsr.put("count" , cnt); // 자료수
                sql.setLength(0);

                sql.append(" SELECT ")
                   .append(" date_format(a.REG_DATE,'%Y-%m-%d %H:%i:%s')   REG_DATE        , ")
                   .append(" a.P_ID                             P_ID            , ")
                   .append(" p.P_TITLE                          P_TITLE         , ")
                   .append(" b.SEQ                              SEQ             , ")
                   .append(" a.LEVEL_CD                         LEVEL_CD        , ")
                   .append(" a.MEM_ID                           MEM_ID          , ")
                   .append(" a.MEM_NAME                         MEM_NAME        , ")
                   .append(" a.BAN_ID                           BAN_ID          , ")
                   .append(" a.BAN_NAME                         BAN_NAME        , ")
                   .append(" SUBSTRING_INDEX(GROUP_CONCAT(b.PART_NUM    ORDER BY b.PART_NUM SEPARATOR ','),',',3)        PART_NUM        , ")
                   .append(" SUBSTRING_INDEX(GROUP_CONCAT(b.CORRECT_CNT ORDER BY b.PART_NUM SEPARATOR ','),',',3)        PART_CORRECT_CNT, ")
                   .append(" SUBSTRING_INDEX(GROUP_CONCAT(b.SCORE       ORDER BY b.PART_NUM SEPARATOR ','),',',3)        PART_SCORE      , ")
                   .append(" SUBSTRING_INDEX(GROUP_CONCAT(b.TOTAL_POINT ORDER BY b.PART_NUM SEPARATOR ','),',',3)        PART_TOTAL_POINT, ")
                   .append(" a.SCORE                            TOTAL_SCORE     , ")
                   .append(" a.TOTAL_POINT                      TOTAL_POINT       ")
                   .append(" FROM " + TABLE.LEVELTEST_ANSWER_RESULT + " a") 
                   .append(" LEFT OUTER JOIN " + TABLE.LEVELTEST_PAPER + " p ON a.P_ID = p.P_ID")
                   .append("," + TABLE.LEVELTEST_ANSWER_RESULT_PAPER_PART + " b")
                   .append(" WHERE a.AC_ID    = '" + loginInfo.acId + "'")
                   .append(" AND   a.P_ID     = b.P_ID  ")
                   .append(" AND   a.SEQ      = b.SEQ   ")
                   .append(" AND   a.MEM_ID = b.MEM_ID  ")                   
                   .append( where.toString() )
                   .append(" GROUP BY a.P_ID, a.SEQ, a.MEM_ID ")
                   .append(" ORDER BY a.REG_DATE DESC")
                   .append(" LIMIT ?, ? ")
                ;
                pstmt = conn.prepareStatement(sql.toString());
                pstmt.setInt(1, p_start - 1);
                pstmt.setInt(2, p_page_many);

                rs  = pstmt.executeQuery();
                while ( rs.next() ) {
                    JSONObject jso = new JSONObject();
                    jso.put("reg_date"          , StringUtils.defaultString(rs.getString("REG_DATE"         )));
                    jso.put("p_id"              , StringUtils.defaultString(rs.getString("P_ID"             )));
                    jso.put("p_title"           , StringUtils.defaultString(rs.getString("P_TITLE"          )));                    
                    jso.put("seq"               , StringUtils.defaultString(rs.getString("SEQ"              )));
                    jso.put("level_cd"          , StringUtils.defaultString(rs.getString("LEVEL_CD"         )));
                    jso.put("mem_id"            , StringUtils.defaultString(rs.getString("MEM_ID"           )));
                    jso.put("mem_name"          , StringUtils.defaultString(rs.getString("MEM_NAME"         )));
                    jso.put("ban_id"            , StringUtils.defaultString(rs.getString("BAN_ID"           )));
                    jso.put("ban_name"          , StringUtils.defaultString(rs.getString("BAN_NAME"         )));
                    jso.put("part_num"          , StringUtils.defaultString(rs.getString("PART_NUM"         )));
                    jso.put("part_correct_cnt"  , StringUtils.defaultString(rs.getString("PART_CORRECT_CNT" )));
                    jso.put("part_score"        , StringUtils.defaultString(rs.getString("PART_SCORE"       )));
                    jso.put("part_total_point"  , StringUtils.defaultString(rs.getString("PART_TOTAL_POINT" )));
                    jso.put("total_score"       , StringUtils.defaultString(rs.getString("TOTAL_SCORE"      )));
                    jso.put("total_point"       , StringUtils.defaultString(rs.getString("TOTAL_POINT"      )));
                    jsa.put(jso);
                }
                jsr.put("data",jsa);
	            // Page Navi
	            jsr.put("page_navi", Sql.pageTab(p_start, cnt, p_page_many, p_page_many, Sql.page_navi_limit, "fListDetail") );	            
                jsr.put("return" , "1"); // 실행
            } catch ( SQLException e) {
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
     * 레벨테스트 반테스트 권한 - 조회 ( 원장, 교사 )
     * @param 레별코드(1,2,~~~~n)
     * @param page navi 시작 위치
     * @return  조회데이터
     */
    @POST
    @Produces("application/json")
    @Path("cap/leveltest_ban_join_grant")
    public JSONObject getLevelTestBanJoinGrant(
    		@FormParam("p_level_cd" ) int p_level_cd,
    		@DefaultValue("") @FormParam("p_ban_id"   ) String p_ban_id,
    		@DefaultValue("") @FormParam("p_mem_name" ) String p_mem_name,
    		@FormParam("p_start"    ) int p_start
    ) throws Exception{
        //int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;
        int p_page_many  = 30;
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            try {
                getConnection();
                JSONArray jsa = new JSONArray();
                StringBuffer sql = new StringBuffer();
                StringBuffer where= new StringBuffer();

                if ( loginInfo.memGb.equals("2") || loginInfo.memGb.equals("3") ) {
                	
                    sql.setLength(0);
                    sql.append(" SELECT P_ID, P_TITLE  ")
                       .append(" FROM " + TABLE.LEVELTEST_PAPER )
                       .append(" WHERE USE_YN ='Y'")                       
                    ;
                    pstmt = conn.prepareStatement(sql.toString());                    
                    rs  = pstmt.executeQuery();
                    List<String> inBans = new ArrayList<String>();
                    JSONObject jso_paper = new JSONObject();        
                    jso_paper.put("0", "전체등급 응시가능");                    
                    while ( rs.next() ) {
                    	jso_paper.put(rs.getString("P_ID"), StringUtils.defaultString(rs.getString("P_TITLE")));                    		
                    }
                    jsr.put("data_paper", jso_paper); // data paper 
                    
                    sql.setLength(0);
                    sql.append(" SELECT  ")
                       .append(" COUNT(a.BAN_ID)")
                       .append(" FROM " + TABLE.BAN + " a ")
                       .append(" LEFT OUTER JOIN " + TABLE.LEVELTEST_BAN_JOIN_GRANT + " b" )
                       .append(" ON a.AC_ID = b.AC_ID AND a.BAN_ID = b.BAN_ID")
                       .append(" WHERE a.AC_ID   = '" + loginInfo.acId + "'")
                       .append(loginInfo.memGb.equals("3")?" AND   a.TCH_ID = '"+loginInfo.memId+"' ":"")
                       .append( where.toString() )
                       .append(" GROUP BY a.AC_ID ")
                    ;
                    int cnt = Sql.getCount(sql.toString(), this.conn);
                    jsr.put("count" , cnt); // 자료수
                    String cur_date = Sql.simpleQuery("SELECT date_format(now(),'%Y-%m-%d') CUR_DATE", this.conn);
                    jsr.put("cur_date" , cur_date); // 자료수                    
                    sql.setLength(0);
                    sql.append(" SELECT ")
                       .append(" a.BAN_ID                                        BAN_ID      ,")
                       .append(" a.BAN_NAME                                      BAN_NAME    ,")
                       .append(" a.TCH_ID                                        TCH_ID      ,")
                       .append(" IFNULL(b.P_ID,0)                                P_ID        ,")
                       .append(" p.P_TITLE                          			 P_TITLE     ,")
                     //.append(" DATEDIFF(NOW(),DATE_ADD(IFNULL(b.EXP_DATE,NOW()), INTERVAL 1 DAY))   					REMIND_DAY  ,")
                       .append(" DATEDIFF(IFNULL(b.EXP_DATE,'1970-01-01'),NOW()) REMIND_DAY  ,")
                       .append(" date_format(b.EXP_DATE,'%Y-%m-%d')     EXP_DATE     ")
                       .append(" FROM " + TABLE.BAN + " a ")
                       .append(" LEFT OUTER JOIN " + TABLE.LEVELTEST_BAN_JOIN_GRANT + " b" )
                       .append(" ON a.AC_ID = b.AC_ID AND a.BAN_ID = b.BAN_ID")
                       .append(" LEFT OUTER JOIN " + TABLE.LEVELTEST_PAPER + " p ON b.P_ID = p.P_ID")                       
                       .append("  WHERE a.AC_ID    = ?")
                       .append(loginInfo.memGb.equals("3")?" AND   a.TCH_ID = ?":"")                       
                       .append( where.toString() )
                       .append(" ORDER BY a.BAN_ID ASC")
                       .append(" LIMIT ?, ? ")
                    ;
                    int idx = 1;
                    if ( loginInfo.memGb.equals("2") ) { // 원장
                        pstmt = conn.prepareStatement(sql.toString());
                        pstmt.setString (idx++, loginInfo.acId  );
                    } else if ( loginInfo.memGb.equals("3") ) { // 교사
                        pstmt = conn.prepareStatement(sql.toString());
                        pstmt.setString (idx++, loginInfo.acId  );
                        pstmt.setString (idx++, loginInfo.memId );
                    }
                    pstmt.setInt(idx++, p_start - 1);
                    pstmt.setInt(idx++, p_page_many);

                    rs  = pstmt.executeQuery();
                    while ( rs.next() ) {
                        JSONObject jso = new JSONObject();
                        jso.put("ban_id"            , StringUtils.defaultString(rs.getString("BAN_ID"     )));
                        jso.put("ban_name"          , StringUtils.defaultString(rs.getString("BAN_NAME"   )));
                        jso.put("tch_id"            , StringUtils.defaultString(rs.getString("TCH_ID"     )));
                        jso.put("p_id"              , StringUtils.defaultString(rs.getString("P_ID"       )));
                        jso.put("p_title"           , StringUtils.defaultString(rs.getString("P_TITLE"    )));
                        jso.put("remind_day"        , StringUtils.defaultString(rs.getString("REMIND_DAY" )));
                        jso.put("exp_date"          , StringUtils.defaultString(rs.getString("EXP_DATE"   )));
                        jsa.put(jso);
                    }
                    jsr.put("data",jsa);
                    // Page Navi
                    jsr.put("page_navi", Sql.pageTab(p_start, cnt, p_page_many, p_page_many, Sql.page_navi_limit, "fList") );
                    jsr.put("return" , "1"); // 실행

                } else {
                    jsr.put("return" , "-2"); // 권한없음
                    jsr.put("data", ""); // data
                }
            } catch ( SQLException e) {
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
     * 	리스닝 인증시험 관리  - 권한입력&수정(EXPIRE_DATE 갱신)
     * @param 데이터상태
     * @param 반ID
     * @param 시험지ID
     * @param 만료일자
     * @return  데이터 저장 처리
     */
    @POST
    @Produces("application/json")
  //@Consumes("application/x-www-form-urlencoded")
    @Path("cap/leveltest_ban_join_grant_exec")
    public JSONObject updateExpireDate( 
    									@FormParam("p_mode"  ) List<String> p_mode        ,
    									@FormParam("ban_id"  ) List<String> p_ban_id      ,
                                        @FormParam("p_id"    ) List<String> p_p_id        ,
                                        @FormParam("exp_date") List<String> p_exp_date
    ) throws Exception{
        JSONObject jsr = new JSONObject();
        if ( !loginInfo.memGb.equals("2") && !loginInfo.memGb.equals("3") ) {        	
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            //Util.logger.info(req);
            getConnection();
            try {
                String mode     = "";
                String ban_id   = "";
                String p_id     = "";
                String exp_date = "";
                //System.out.println(" 1step" );
                //System.out.println(" ban_id.length     : " +p_ban_id.size());
                for(int i=1;i<p_ban_id.size();i++){
	    	        mode     = StringUtils.defaultString(p_mode.get(i)   );                	
                	ban_id   = StringUtils.defaultString(p_ban_id.get(i)   );
                	p_id     = StringUtils.defaultString(p_p_id.get(i)     );
                	exp_date = StringUtils.defaultString(p_exp_date.get(i));
                  //out.println(" mode : " + mode+ "<BR>" );
            /**/
                    //System.out.println(" ban_id   : " + ban_id  + "<BR>" );
                    //System.out.println(" p_id     : " + p_id    + "<BR>" );
                    //System.out.println(" exp_date : " + exp_date+ "<BR>" );

                    int sIdx = 1;
                    if ( mode.equals("U") ) {
	                    StringBuffer sql = new StringBuffer();
	                    sql.append("REPLACE INTO " + TABLE.LEVELTEST_BAN_JOIN_GRANT + "(" )
	                    .append("AC_ID   ,") // 1
	                    .append("BAN_ID  ,") // 2
	                    .append("P_ID    ,") // 3
	                    .append("EXP_DATE ") // 4
	                    .append(" ) VALUES (")
	                    .append("?,")   // 1
	                    .append("?,")   // 2
	                    .append("?,")   // 3
	                    .append("? ")   // 4
	                    .append(")")
	                    ;
	                    pstmt = conn.prepareStatement( sql.toString() );
	
	                    pstmt.setString(sIdx++ , loginInfo.acId);
	                    pstmt.setString(sIdx++ , ban_id        );
	                    pstmt.setString(sIdx++ , p_id          );
	                    if (exp_date.equals("")) {
	                    	pstmt.setNull(sIdx++,java.sql.Types.TIMESTAMP);	                    	
	                    } else {
	                    	pstmt.setString(sIdx++ , exp_date      );
	                    }
	                    pstmt.executeUpdate();
                    } else if ( mode.equals("D") ) {
	                    StringBuffer sql = new StringBuffer();
	                    sql.append("DELETE FROM " + TABLE.LEVELTEST_BAN_JOIN_GRANT + "" )
	                    .append(" WHERE AC_ID = ?") // 1
	                    .append(" AND   BAN_ID = ?") // 2
	                    ;
	                    pstmt = conn.prepareStatement( sql.toString() );
	                    pstmt.setString(sIdx++ , loginInfo.acId);
	                    pstmt.setString(sIdx++ , ban_id        );
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
     * 레벨테스트 반테스트 권한 - 조회 ( 원장, 교사 )
     * @param 레별코드(1,2,~~~~n)
     * @param page navi 시작 위치
     * @return  조회데이터
     */
    @POST
    @Produces("application/json")
    @Path("cap/leveltest_std_join_grant")
    public JSONObject getLevelTestStdJoinGrant(
    		@FormParam("p_level_cd" ) int p_level_cd,
    		@DefaultValue("") @FormParam("p_ban_id"   ) String p_ban_id,
    		@DefaultValue("") @FormParam("p_mem_name" ) String p_mem_name,
    		@FormParam("p_start"    ) int p_start
    ) throws Exception{
        //int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;
        int p_page_many  = 30;
        JSONObject jsr = new JSONObject();
        if ( loginInfo.loginYn.equals("") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            try {
                getConnection();
                JSONArray jsa = new JSONArray();
                StringBuffer sql = new StringBuffer();
                StringBuffer where= new StringBuffer();

                if ( loginInfo.memGb.equals("2") || loginInfo.memGb.equals("3") ) {
                    // 반선택 JSON --------------------------------------------------------
                    sql.setLength(0);
                    sql.append(" SELECT '1' GB, BAN_ID, BAN_NAME ,TCH_ID  ")
                       .append(" FROM " + TABLE.BAN )
                       .append("  WHERE AC_ID = ?")
                    ;
                    if ( loginInfo.memGb.equals("2") ) { // 원장
                        pstmt = conn.prepareStatement(sql.toString());
                        pstmt.setString (1, loginInfo.acId  );
                    } else if ( loginInfo.memGb.equals("3") ) { // 교사
                        sql.append("  AND   TCH_ID   = ? ");
                        pstmt = conn.prepareStatement(sql.toString());
                        pstmt.setString (1, loginInfo.acId  );
                        pstmt.setString (2, loginInfo.memId );
                    }
                    rs  = pstmt.executeQuery();
                    JSONObject jso_ban = new JSONObject();
                    jso_ban.put("", "-반선택-");
                    while ( rs.next() ) {
                        if ( StringUtils.defaultString(jso_ban.optString(rs.getString("BAN_ID"))).equals("") ) {
                            jso_ban.put(rs.getString("BAN_ID"), StringUtils.defaultString(rs.getString("BAN_NAME")));
                        }
                    }
                    jsr.put("data_ban", jso_ban); // data 반
                    // -------------------------------------------------------- 반선택 JSON

                    // 시험지 종류 JSON --------------------------------------------------------
                    sql.setLength(0);
                    sql.append(" SELECT P_ID, P_TITLE  ")
                       .append(" FROM " + TABLE.LEVELTEST_PAPER )
                       .append(" WHERE USE_YN ='Y'")
                    ;
                    pstmt = conn.prepareStatement(sql.toString());
                    rs  = pstmt.executeQuery();
                    List<String> inBans = new ArrayList<String>();
                    JSONObject jso_paper = new JSONObject();
                    jso_paper.put("0", "전체등급 응시가능");
                    while ( rs.next() ) {
                    	jso_paper.put(rs.getString("P_ID"), StringUtils.defaultString(rs.getString("P_TITLE")));
                    }
                    jsr.put("data_paper", jso_paper); // data paper
                    // -------------------------------------------------------- 시험지 종류 JSON

                    // 학생목록 조회 COUNT --------------------------------------------------------
                    if ( !p_ban_id.equals("") ) {
                        where.append(" AND b.BAN_ID = '" + p_ban_id + "'");
                    }
                    sql.setLength(0);
                    sql.append(" SELECT ")
                       .append(" COUNT(*) ")
                       .append(" FROM " + TABLE.STUDENT + " AS s, " + TABLE.ATTEND + " a, " + TABLE.BAN + " b")
                       .append(" WHERE s.AC_ID = '" + loginInfo.acId + "'")
                       .append(" AND   s.AC_ID = a.AC_ID ")
                       .append(" AND   s.ST_ID = a.ST_ID ")
                       .append(" AND   a.AC_ID = b.AC_ID ")
                       .append(" AND   a.BAN_ID= b.BAN_ID ")
                       .append(loginInfo.memGb.equals("3")?" AND   b.TCH_ID = '"+loginInfo.memId+"' ":"")
                       .append( where.toString() )
                    ;
                    int cnt = Sql.getCount(sql.toString(), this.conn);
                    jsr.put("count" , cnt); // 자료수
                    // -------------------------------------------------------- 학생목록 조회 COUNT

                    String cur_date = Sql.simpleQuery("SELECT date_format(now(),'%Y-%m-%d') CUR_DATE", this.conn);
                    jsr.put("cur_date" , cur_date); // 오늘날짜
                    sql.setLength(0);

                    // 학생목록 조회 --------------------------------------------------------
                    sql.append(" SELECT ")
                       .append("   m.AC_ID                                           AC_ID       , ")
                       .append("   m.ST_ID                                           ST_ID       , ")
                       .append("   m.BAN_NAME                                        BAN_NAME    , ")
                       .append("   m.MEM_NAME                                        MEM_NAME    , ")
                       .append("   IFNULL(g.P_ID,0)                                  P_ID        , ")
                       .append("   DATEDIFF(IFNULL(g.EXP_DATE,'1970-01-01'),NOW())   REMIND_DAY  , ")
                       .append("   date_format(g.EXP_DATE,'%Y-%m-%d')                EXP_DATE      ")
                       .append(" FROM ")
                       .append(" ( ")
                       .append("     SELECT ")
                       .append("       s.AC_ID     AC_ID   , ")
                       .append("       s.ST_ID     ST_ID   , ")
                       .append("       b.BAN_NAME  BAN_NAME, ")
                       .append("       mb.MEM_NAME MEM_NAME  ")
                       .append("     FROM " + TABLE.STUDENT + " AS s, " + TABLE.ATTEND + " a, " + TABLE.BAN + " b , " + TABLE.MEMBER + " mb ")
                       .append("     WHERE s.AC_ID    = ?")
                       .append(loginInfo.memGb.equals("3")?" AND   b.TCH_ID = ?":"")
                       .append("     AND   s.AC_ID = a.AC_ID ")
                       .append("     AND   s.ST_ID = a.ST_ID ")
                       .append("     AND   a.AC_ID = b.AC_ID ")
                       .append("     AND   a.BAN_ID= b.BAN_ID ")
                       .append("     AND   s.ST_ID = mb.MEM_ID")
                       .append( where.toString() )
                       .append(" ) m LEFT OUTER JOIN " + TABLE.LEVELTEST_STD_JOIN_GRANT + " g ON m.AC_ID = g.AC_ID AND m.ST_ID = g.ST_ID")
                       .append(" LIMIT ?, ? ")
                    ;
                    int idx = 1;
                    if ( loginInfo.memGb.equals("2") ) { // 원장
                        pstmt = conn.prepareStatement(sql.toString());
                        pstmt.setString (idx++, loginInfo.acId  );
                    } else if ( loginInfo.memGb.equals("3") ) { // 교사
                        pstmt = conn.prepareStatement(sql.toString());
                        pstmt.setString (idx++, loginInfo.acId  );
                        pstmt.setString (idx++, loginInfo.memId );
                    }
                    pstmt.setInt(idx++, p_start - 1);
                    pstmt.setInt(idx++, p_page_many);

                    rs  = pstmt.executeQuery();
                    while ( rs.next() ) {
                        JSONObject jso = new JSONObject();
                        jso.put("ac_id"     , StringUtils.defaultString(rs.getString("AC_ID"          )));
                        jso.put("st_id"     , StringUtils.defaultString(rs.getString("ST_ID"          )));
                        jso.put("ban_name"  , StringUtils.defaultString(rs.getString("BAN_NAME"       )));
                        jso.put("mem_name"  , StringUtils.defaultString(rs.getString("MEM_NAME"       )));
                        jso.put("p_id"      , StringUtils.defaultString(rs.getString("P_ID"           )));
                        jso.put("remind_day", StringUtils.defaultString(rs.getString("REMIND_DAY"     )));
                        jso.put("exp_date"  , StringUtils.defaultString(rs.getString("EXP_DATE"       )));
                        jsa.put(jso);
                    }
                    jsr.put("data",jsa);
                    // -------------------------------------------------------- 학생목록 조회

                    // Page Navi
                    jsr.put("page_navi", Sql.pageTab(p_start, cnt, p_page_many, p_page_many, Sql.page_navi_limit, "fList") );
                    jsr.put("return" , "1"); // 실행

                } else {
                    jsr.put("return" , "-2"); // 권한없음
                    jsr.put("data", ""); // data
                }
            } catch ( SQLException e) {
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
     * 	리스닝 인증시험 관리  - 권한입력&수정(EXPIRE_DATE 갱신)
     * @param 데이터상태
     * @param 반ID
     * @param 시험지ID
     * @param 만료일자
     * @return  데이터 저장 처리
     */
    @POST
    @Produces("application/json")
  //@Consumes("application/x-www-form-urlencoded")
    @Path("cap/leveltest_std_join_grant_exec")
    public JSONObject updateStdExpireDate(
    									@FormParam("p_mode"  ) List<String> p_mode        ,
    									@FormParam("st_id"   ) List<String> p_st_id       ,
                                        @FormParam("p_id"    ) List<String> p_p_id        ,
                                        @FormParam("exp_date") List<String> p_exp_date
    ) throws Exception{
        JSONObject jsr = new JSONObject();
        if ( !loginInfo.memGb.equals("2") && !loginInfo.memGb.equals("3") ) {
            jsr.put("return" , "-1"); // 로그인되있지 않음
            jsr.put("data", ""); // data
        } else {
            //Util.logger.info(req);
            getConnection();
            try {
                String mode     = "";
                String std_id   = "";
                String p_id     = "";
                String exp_date = "";
                //System.out.println(" 1step" );
                //System.out.println(" ban_id.length     : " +p_ban_id.size());
                for(int i=1;i<p_st_id.size();i++){
	    	        mode     = StringUtils.defaultString(p_mode.get(i)    );
                	std_id   = StringUtils.defaultString(p_st_id.get(i)   );
                	p_id     = StringUtils.defaultString(p_p_id.get(i)    );
                	exp_date = StringUtils.defaultString(p_exp_date.get(i));
                  //out.println(" mode : " + mode+ "<BR>" );
            /**/
                    //System.out.println(" std_id   : " + std_id  + "<BR>" );
                    //System.out.println(" p_id     : " + p_id    + "<BR>" );
                    //System.out.println(" exp_date : " + exp_date+ "<BR>" );

                    int sIdx = 1;
                    if ( mode.equals("U") ) {
	                    StringBuffer sql = new StringBuffer();
	                    sql.append("REPLACE INTO " + TABLE.LEVELTEST_STD_JOIN_GRANT + "(" )
	                    .append("AC_ID   ,") // 1
	                    .append("ST_ID   ,") // 2
	                    .append("P_ID    ,") // 3
	                    .append("EXP_DATE ") // 4
	                    .append(" ) VALUES (")
	                    .append("?,")   // 1
	                    .append("?,")   // 2
	                    .append("?,")   // 3
	                    .append("? ")   // 4
	                    .append(")")
	                    ;
	                    pstmt = conn.prepareStatement( sql.toString() );

	                    pstmt.setString(sIdx++ , loginInfo.acId);
	                    pstmt.setString(sIdx++ , std_id        );
	                    pstmt.setString(sIdx++ , p_id          );
	                    if (exp_date.equals("")) {
	                    	pstmt.setNull(sIdx++,java.sql.Types.TIMESTAMP);
	                    } else {
	                    	pstmt.setString(sIdx++ , exp_date      );
	                    }
	                    pstmt.executeUpdate();
                    } else if ( mode.equals("D") ) {
	                    StringBuffer sql = new StringBuffer();
	                    sql.append("DELETE FROM " + TABLE.LEVELTEST_STD_JOIN_GRANT + "" )
	                    .append(" WHERE AC_ID = ?") // 1
	                    .append(" AND   ST_ID = ?") // 2
	                    ;
	                    pstmt = conn.prepareStatement( sql.toString() );
	                    pstmt.setString(sIdx++ , loginInfo.acId);
	                    pstmt.setString(sIdx++ , std_id        );
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

    
}