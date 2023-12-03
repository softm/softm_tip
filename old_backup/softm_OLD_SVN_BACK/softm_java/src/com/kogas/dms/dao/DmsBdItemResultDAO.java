package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;

public class DmsBdItemResultDAO extends BaseDAO {

	public DmsBdItemResultDAO() throws Exception {
		super();
	}

	protected Logger Log = Util.logger; 

	public JSONObject searchList(int p_start,
			int p_page_many,
    		String s_bd_start_day_frm,
    		String s_bd_start_day_to,
    		String s_proceed_yn,
    		String s_bd_no,
    		String s_name_code) throws Exception {
		JSONObject jsr = new JSONObject();

		StringBuffer sql = new StringBuffer();
		int totCnt = -1;

		sql.append("SELECT * ").append("\n");
		sql.append("  FROM ( ").append("\n");
		sql.append("        SELECT ROWNUM RNUM, AA.* ").append("\n");
		sql.append("          FROM ( ").append("\n");
		sql.append("                SELECT A.SCHEDULE_NO, ").append("\n");
		sql.append("                       A.BD_NO, ").append("\n");
		sql.append("                       A.GUBUN_CODE, ").append("\n");
		sql.append("                       C.GUBUN_NAME, ").append("\n");
		sql.append("                       A.NAME_CODE, ").append("\n");
		sql.append("                       D.CODE_NAME, ").append("\n");
		sql.append("                       TO_CHAR(TO_DATE(A.BD_START_DAY||A.BD_TIME,'YYYYMMDDHH24MI'),'YYYY-MM-DD') BD_START_DAY, ").append("\n");
		sql.append("                       TO_CHAR(TO_DATE(A.BD_START_DAY||A.BD_TIME,'YYYYMMDDHH24MI'),'HH24:MI') BD_TIME, ").append("\n");
		sql.append("                       A.BD_PLACE, ").append("\n");
		sql.append("                       DECODE(BB.ITEM_NO,NULL,'미등록',DECODE(BB.RESULT_REGIS,'Y','등록','미등록')) RESULT_REGIS, ").append("\n");
		sql.append("                       COUNT(*) OVER() AS TOTCNT ").append("\n");
		sql.append("                  FROM DMS_BD_SCHEDULE A, ").append("\n");
		sql.append("                       DMS_BD_ITEM B, ").append("\n");
		sql.append("                       DMS_BD_ITEM_RESULT BB, ").append("\n");
		sql.append("                       DMS_BD_GUBUN_CODE C, ").append("\n");
		sql.append("                       DMS_BD_NAME_CODE D ").append("\n");
		sql.append("                 WHERE A.SCHEDULE_NO = B.SCHEDULE_NO(+) ").append("\n");
		sql.append("                   AND B.ITEM_NO = BB.ITEM_NO(+) ").append("\n");
		sql.append("                   AND A.GUBUN_CODE = C.GUBUN_CODE ").append("\n");
		sql.append("                   AND A.NAME_CODE = D.NAME_CODE ").append("\n");
		if(!s_bd_start_day_frm.equals("") && !s_bd_start_day_to.equals("")) {
			sql.append("                   AND A.BD_START_DAY  BETWEEN '").append(s_bd_start_day_frm).append("' AND '").append(s_bd_start_day_to).append("' ").append("\n");
		}
		if(s_proceed_yn.equals("Y")) sql.append("                   AND B.PROCEED_NO IS NOT NULL ").append("\n");
		if(s_proceed_yn.equals("N")) sql.append("                   AND B.PROCEED_NO IS NULL ").append("\n");
		if(!s_bd_no.equals("")) sql.append("                   AND A.BD_NO LIKE '").append(s_bd_no).append("%' ").append("\n");
		if(!s_name_code.equals("")) sql.append("                   AND A.NAME_CODE = '").append(s_name_code).append("' ").append("\n");
		sql.append("                 ORDER BY A.BD_NO DESC ").append("\n");
		sql.append("               ) AA ").append("\n");
		sql.append("       )  ").append("\n");
		sql.append("WHERE RNUM BETWEEN ? AND ? ").append("\n");
        
        Log.info(sql.toString());
        
		try {
			JSONArray jsa = new JSONArray();
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1, p_start - 1);
            pstmt.setInt(2, p_start - 1 + p_page_many);
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("schedule_no",StringUtils.defaultString(rs.getString("SCHEDULE_NO")));
				jso.put("bd_no",StringUtils.defaultString(rs.getString("BD_NO")));
				jso.put("gubun_code",StringUtils.defaultString(rs.getString("GUBUN_CODE")));
				jso.put("gubun_name",StringUtils.defaultString(rs.getString("GUBUN_NAME")));
				jso.put("name_code",StringUtils.defaultString(rs.getString("NAME_CODE")));
				jso.put("code_name",StringUtils.defaultString(rs.getString("CODE_NAME")));
				jso.put("bd_start_day",StringUtils.defaultString(rs.getString("BD_START_DAY")));
				jso.put("bd_time",StringUtils.defaultString(rs.getString("BD_TIME")));
				jso.put("bd_place",StringUtils.defaultString(rs.getString("BD_PLACE")));
				jso.put("result_regis",StringUtils.defaultString(rs.getString("RESULT_REGIS")));

                if ( totCnt == -1 ) {
                    totCnt = rs.getInt("TOTCNT");
                    jsr.put("total", totCnt);
                }
                jsa.put(jso);
            }
            
            if ( totCnt == -1 ) {
                totCnt = 0;
                jsr.put("total", totCnt);
            }
            
            jsr.put("data", jsa); // data
            
            jsr.put("return" , "200"); // 성공
            jsr.put("message" , "조회되었습니다."); // error message	
            return jsr;
		} catch(Exception ex) {
			 Util.logger.error("e.toString() : " + ex.toString()+ "<BR>");
   			 jsr.put("return" , "500"); // 실패
   			 jsr.put("message" , ex.toString()); // error message
   			 ex.printStackTrace();
		} finally {
			releaseResource();
		}

		return null;
	}
	
	public JSONObject searchList2(int p_start,
			int p_page_many,
    		String s_bd_start_day_frm,
    		String s_bd_start_day_to,
    		String s_bd_no,
    		String s_name_code) throws Exception {
		JSONObject jsr = new JSONObject();

		StringBuffer sql = new StringBuffer();
		int totCnt = -1;

		sql.append("SELECT * ").append("\n");
		sql.append("  FROM ( ").append("\n");
		sql.append("        SELECT ROWNUM RNUM, AA.* ").append("\n");
		sql.append("          FROM ( ").append("\n");
		sql.append("                SELECT A.SCHEDULE_NO, ").append("\n");
		sql.append("                       A.BD_NO, ").append("\n");
		sql.append("                       A.GUBUN_CODE, ").append("\n");
		sql.append("                       C.GUBUN_NAME, ").append("\n");
		sql.append("                       A.NAME_CODE, ").append("\n");
		sql.append("                       D.CODE_NAME, ").append("\n");
		sql.append("                       TO_CHAR(TO_DATE(A.BD_START_DAY||A.BD_TIME,'YYYYMMDDHH24MI'),'YYYY-MM-DD') BD_START_DAY, ").append("\n");
		sql.append("                       TO_CHAR(TO_DATE(A.BD_START_DAY||A.BD_TIME,'YYYYMMDDHH24MI'),'HH24:MI') BD_TIME, ").append("\n");
		sql.append("                       A.BD_PLACE, ").append("\n");
		sql.append("                       TO_CHAR(TO_DATE(A.BD_END_DAY,'YYYYMMDD'),'YYYY-MM-DD') BD_END_DAY, ").append("\n");
		sql.append("                       COUNT(*) OVER() AS TOTCNT ").append("\n");
		sql.append("                  FROM DMS_BD_SCHEDULE A, ").append("\n");
		sql.append("                       DMS_BD_GUBUN_CODE C, ").append("\n");
		sql.append("                       DMS_BD_NAME_CODE D ").append("\n");
		sql.append("                 WHERE A.SCHEDULE_NO = B.SCHEDULE_NO(+) ").append("\n");
		sql.append("                   AND B.ITEM_NO = BB.ITEM_NO(+) ").append("\n");
		sql.append("                   AND A.GUBUN_CODE = C.GUBUN_CODE ").append("\n");
		sql.append("                   AND A.NAME_CODE = D.NAME_CODE ").append("\n");
		if(!s_bd_start_day_frm.equals("") && !s_bd_start_day_to.equals("")) {
			sql.append("                   AND A.BD_START_DAY  BETWEEN '").append(s_bd_start_day_frm).append("' AND '").append(s_bd_start_day_to).append("' ").append("\n");
		}
		if(!s_bd_no.equals("")) sql.append("                   AND A.BD_NO LIKE '").append(s_bd_no).append("%' ").append("\n");
		if(!s_name_code.equals("")) sql.append("                   AND A.NAME_CODE = '").append(s_name_code).append("' ").append("\n");
		sql.append("                 ORDER BY A.BD_NO DESC ").append("\n");
		sql.append("               ) AA ").append("\n");
		sql.append("       )  ").append("\n");
		sql.append("WHERE RNUM BETWEEN ? AND ? ").append("\n");
        
        Log.info(sql.toString());
        
		try {
			JSONArray jsa = new JSONArray();
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1, p_start - 1);
            pstmt.setInt(2, p_start - 1 + p_page_many);
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("schedule_no",StringUtils.defaultString(rs.getString("SCHEDULE_NO")));
				jso.put("bd_no",StringUtils.defaultString(rs.getString("BD_NO")));
				jso.put("gubun_code",StringUtils.defaultString(rs.getString("GUBUN_CODE")));
				jso.put("gubun_name",StringUtils.defaultString(rs.getString("GUBUN_NAME")));
				jso.put("name_code",StringUtils.defaultString(rs.getString("NAME_CODE")));
				jso.put("code_name",StringUtils.defaultString(rs.getString("CODE_NAME")));
				jso.put("bd_start_day",StringUtils.defaultString(rs.getString("BD_START_DAY")));
				jso.put("bd_time",StringUtils.defaultString(rs.getString("BD_TIME")));
				jso.put("bd_place",StringUtils.defaultString(rs.getString("BD_PLACE")));
				jso.put("bd_end_day",StringUtils.defaultString(rs.getString("BD_END_DAY")));

                if ( totCnt == -1 ) {
                    totCnt = rs.getInt("TOTCNT");
                    jsr.put("total", totCnt);
                }
                jsa.put(jso);
            }
            
            if ( totCnt == -1 ) {
                totCnt = 0;
                jsr.put("total", totCnt);
            }
            
            jsr.put("data", jsa); // data
            
            jsr.put("return" , "200"); // 성공
            jsr.put("message" , "조회되었습니다."); // error message	
            return jsr;
		} catch(Exception ex) {
			 Util.logger.error("e.toString() : " + ex.toString()+ "<BR>");
   			 jsr.put("return" , "500"); // 실패
   			 jsr.put("message" , ex.toString()); // error message
   			 ex.printStackTrace();
		} finally {
			releaseResource();
		}

		return null;
	}
	public JSONObject list(int schedule_no) throws Exception {
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append("SELECT A.MEMBER_NO, ").append("\n");
		sql.append("       A.KO_NAME, ").append("\n");
		sql.append("       A.BD_NAME, ").append("\n");
		sql.append("       DECODE(B.ATTEND_YN,NULL,'N',B.ATTEND_YN) ATTEND_YN, ").append("\n");
		sql.append("       DECODE(B.COMMENT_NUMBER,NULL,0,B.COMMENT_NUMBER) COMMENT_NUMBER,").append("\n");
		sql.append("       C.REAL_PROCEED_ATT_FILE, ").append("\n");
		sql.append("       C.DISPLAY_PROCEED_ATT_FILE, ").append("\n");
		sql.append("       C.REAL_DECIDE_ATT_FILE, ").append("\n");
		sql.append("       C.DISPLAY_DECIDE_ATT_FILE, ").append("\n");
		sql.append("       A.SCHEDULE_NO ").append("\n");
		sql.append("  FROM ( ").append("\n");
		sql.append("        SELECT AA.MEMBER_NO, AA.KO_NAME, BB.SCHEDULE_NO, CC.BD_NAME ").append("\n");
		sql.append("          FROM DMS_MEMBER AA, DMS_BD_SCHEDULE BB, DMS_BD_CODE CC ").append("\n");
		sql.append("         WHERE AA.BD_CODE = CC.BD_CODE ").append("\n");
		sql.append("       ) A, ").append("\n");
		sql.append("       DMS_BD_ATTEND_MEMBER B, ").append("\n");
		sql.append("       DMS_BD_PROCEEDINGS C ").append("\n");
		sql.append(" WHERE A.MEMBER_NO = B.MEMBER_NO2(+) ").append("\n");
		sql.append("   AND A.SCHEDULE_NO = B.SCHEDULE_NO(+) ").append("\n");
		sql.append("   AND A.SCHEDULE_NO = C.SCHEDULE_NO(+) ").append("\n");
		sql.append("   AND A.SCHEDULE_NO = ? ").append("\n");
        
        Log.info(sql.toString());
        
		try {
			JSONArray jsa = new JSONArray();
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1, schedule_no);
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("member_no",StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jso.put("ko_name",StringUtils.defaultString(rs.getString("KO_NAME")));
				jso.put("bd_name",StringUtils.defaultString(rs.getString("BD_NAME")));
				jso.put("attend_yn",StringUtils.defaultString(rs.getString("ATTEND_YN")));
				jso.put("comment_number",StringUtils.defaultString(rs.getString("COMMENT_NUMBER")));
				
				jsr.put("real_proceed_att_file",StringUtils.defaultString(rs.getString("REAL_PROCEED_ATT_FILE")));
				jsr.put("display_proceed_att_file",StringUtils.defaultString(rs.getString("DISPLAY_PROCEED_ATT_FILE")));
				jsr.put("real_decide_att_file",StringUtils.defaultString(rs.getString("REAL_DECIDE_ATT_FILE")));
				jsr.put("display_decide_att_file",StringUtils.defaultString(rs.getString("DISPLAY_DECIDE_ATT_FILE")));

                jsa.put(jso);
            }
            
            jsr.put("data", jsa); // data
            
            jsr.put("return" , "200"); // 성공
            jsr.put("message" , "조회되었습니다."); // error message	
            return jsr;
		} catch(Exception ex) {
			 Util.logger.error("e.toString() : " + ex.toString()+ "<BR>");
   			 jsr.put("return" , "500"); // 실패
   			 jsr.put("message" , ex.toString()); // error message
   			 ex.printStackTrace();
		} finally {
			releaseResource();
		}

		return null;
	}

	public boolean insProceedingd(
			int schedule_no, String real_proceed_att_file, String display_proceed_att_file,
			String real_decide_att_file, String display_decide_att_file  ) {
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append("INSERT INTO DMS_BD_PROCEEDINGS ( ").append("\n");
		sql.append("       PROCEED_NO").append("\n");
		sql.append("      ,SCHEDULE_NO").append("\n");
		sql.append("      ,REAL_PROCEED_ATT_FILE").append("\n");
		sql.append("      ,DISPLAY_PROCEED_ATT_FILE").append("\n");
		sql.append("      ,REAL_DECIDE_ATT_FILE").append("\n");
		sql.append("      ,DISPLAY_DECIDE_ATT_FILE").append("\n");
		sql.append("      ,WRITE_DATE").append("\n");
		sql.append("      ,READ_COUNT").append("\n");
		sql.append(")").append("\n");
		sql.append("VALUES (").append("\n");
		sql.append("       DMS_BD_PROCEEDINGS.NEXTVAL").append("\n");
		sql.append("      ,?").append("\n");
		sql.append("      ,?").append("\n");
		sql.append("      ,?").append("\n");
		sql.append("      ,?").append("\n");
		sql.append("      ,?").append("\n");
		sql.append("      ,TO_CHAR(SYSDATE,'YYYYMMDD')").append("\n");
		sql.append("      ,0").append("\n");
		sql.append(") ");
		
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1,schedule_no);
			pstmt.setString(2,real_proceed_att_file);
			pstmt.setString(3,display_proceed_att_file);
			pstmt.setString(4,real_decide_att_file);
			pstmt.setString(5,display_decide_att_file);
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("writeAttendMember 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}
	
	public boolean updateProceedingd(
			int proceed_no, String real_proceed_att_file, String display_proceed_att_file,
			String real_decide_att_file, String display_decide_att_file  ) {
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append("UPDATE DMS_BD_PROCEEDINGS SET ").append("\n");
		sql.append("       REAL_PROCEED_ATT_FILE = ?").append("\n");
		sql.append("      ,DISPLAY_PROCEED_ATT_FILE = ?").append("\n");
		sql.append("      ,REAL_DECIDE_ATT_FILE = ? ").append("\n");
		sql.append("      ,DISPLAY_DECIDE_ATT_FILE = ? ").append("\n");
		sql.append(" WHERE PROCEED_NO = ? ").append("\n");
		
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setString(1,real_proceed_att_file);
			pstmt.setString(2,display_proceed_att_file);
			pstmt.setString(3,real_decide_att_file);
			pstmt.setString(4,display_decide_att_file);
			pstmt.setInt(5,proceed_no);
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("writeAttendMember 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}
	
	public void setReadCountUpdate(int no) throws Exception {
		StringBuffer sql = new StringBuffer();
		sql.append(" UPDATE DMS_BD_PROCEEDINGS SET READ_COUNT = READ_COUNT+1 WHERE PROCEED_NO = ? ");
		try{
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1, no);
			pstmt.executeUpdate();
		}catch(Exception ex){
			System.out.println("setReadCountUpdate 에러 : "+ex);
		}
		finally{
			releaseResource();
		}
	}
}