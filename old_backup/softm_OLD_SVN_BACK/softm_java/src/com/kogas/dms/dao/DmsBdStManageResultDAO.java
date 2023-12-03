package com.kogas.dms.dao;

import java.sql.SQLException;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;

public class DmsBdStManageResultDAO extends BaseDAO{

	public DmsBdStManageResultDAO() throws Exception {
		super();
	}
	
	/**
	 * getMeetingHoldNumber
	 * @return JSONObject
	 * @throws Exception
	 */
	public JSONObject getMeetingHoldNumber(String stdYear) throws Exception {
		JSONObject jso = new JSONObject();
		
		String stdYear1 = "" + (Integer.parseInt(stdYear)-4);
		String stdYear2 = "" + (Integer.parseInt(stdYear)-3);
		String stdYear3 = "" + (Integer.parseInt(stdYear)-2);
		String stdYear4 = "" + (Integer.parseInt(stdYear)-1);
		
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("      A.HOLD_NUM_STD_YEAR1 ").append("\n");
    		sql.append("     ,B.HOLD_NUM_STD_YEAR2 ").append("\n");
    		sql.append("     ,C.HOLD_NUM_STD_YEAR3 ").append("\n");
    		sql.append("     ,D.HOLD_NUM_STD_YEAR4 ").append("\n");
    		sql.append("     ,E.HOLD_NUM_STD_YEAR5 ").append("\n");
    		sql.append(" FROM ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          COUNT(*)       AS HOLD_NUM_STD_YEAR1 ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("     WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append(" ) A, ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          COUNT(*)       AS HOLD_NUM_STD_YEAR2 ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("     WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append(" ) B, ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          COUNT(*)       AS HOLD_NUM_STD_YEAR3 ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("     WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append(" ) C, ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          COUNT(*)       AS HOLD_NUM_STD_YEAR4 ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("     WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append(" ) D, ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          COUNT(*)       AS HOLD_NUM_STD_YEAR5 ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("     WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append(" ) E ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
            pstmt.setString(1, stdYear1 + "0101");
			pstmt.setString(2, stdYear1 + "1231");
			pstmt.setString(3, stdYear2 + "0101");
			pstmt.setString(4, stdYear2 + "1231");
			pstmt.setString(5, stdYear3 + "0101");
			pstmt.setString(6, stdYear3 + "1231");
			pstmt.setString(7, stdYear4 + "0101");
			pstmt.setString(8, stdYear4 + "1231");
			pstmt.setString(9, stdYear + "0101");
			pstmt.setString(10, stdYear + "1231");
			rs  = pstmt.executeQuery();
			
            if ( rs.next() ) {
            	               
                jso.put("hold_num_std_year1"	,	rs.getInt("HOLD_NUM_STD_YEAR1" ));
                jso.put("hold_num_std_year2"	,	rs.getInt("HOLD_NUM_STD_YEAR2" ));
                jso.put("hold_num_std_year3"	,	rs.getInt("HOLD_NUM_STD_YEAR3" ));
                jso.put("hold_num_std_year4"	,	rs.getInt("HOLD_NUM_STD_YEAR4" ));
                jso.put("hold_num_std_year5"	,	rs.getInt("HOLD_NUM_STD_YEAR5" ));

            }
        } catch ( SQLException e) {
			 Log.error("이사회 개최 횟수 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jso;

	}
	
	/**
	 * getItemRate
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray getItemRate(String stdYear) throws Exception {
		JSONArray jsa = new JSONArray();
		
		String stdYear1 = "" + (Integer.parseInt(stdYear)-2);
		String stdYear2 = "" + (Integer.parseInt(stdYear)-1);
		
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("     '"+ stdYear1 + "년'        AS ITEM_STD_YEAR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '1010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS ORIGINAL_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '1020'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CHANGE_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '1030'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CONDITIONAL_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '2010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS ORIGINAL_ACCEPT ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '2020'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CHANGE_ACCEPT ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '2030'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CONDITIONAL_ACCEPT ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '3010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS REJECT_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '4010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS POSTPONE_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN A.ITEM_DEVISION = '1010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS RESOLUTION_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN A.ITEM_DEVISION = '1020'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS REPORT_ITEM ").append("\n");
    		sql.append(" FROM DMS_BD_ITEM A ").append("\n");
    		sql.append("     ,DMS_BD_ITEM_RESULT B ").append("\n");
    		sql.append(" WHERE A.SCHEDULE_NO IN ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          SCHEDULE_NO ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("     WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append(" ) ").append("\n");
    		sql.append(" AND B.ITEM_NO = A.ITEM_NO ").append("\n");
    		sql.append(" UNION ALL ").append("\n");
    		sql.append(" SELECT ").append("\n");
    		sql.append("     '"+ stdYear2 + "년'        AS ITEM_STD_YEAR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '1010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS ORIGINAL_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '1020'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CHANGE_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '1030'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CONDITIONAL_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '2010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS ORIGINAL_ACCEPT ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '2020'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CHANGE_ACCEPT ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '2030'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CONDITIONAL_ACCEPT ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '3010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS REJECT_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '4010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS POSTPONE_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN A.ITEM_DEVISION = '1010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS RESOLUTION_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN A.ITEM_DEVISION = '1020'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS REPORT_ITEM ").append("\n");
    		sql.append(" FROM DMS_BD_ITEM A ").append("\n");
    		sql.append("     ,DMS_BD_ITEM_RESULT B ").append("\n");
    		sql.append(" WHERE A.SCHEDULE_NO IN ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          SCHEDULE_NO ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("     WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append(" ) ").append("\n");
    		sql.append(" AND B.ITEM_NO = A.ITEM_NO ").append("\n");
    		sql.append(" UNION ALL ").append("\n");
    		sql.append(" SELECT ").append("\n");
    		sql.append("     '"+ stdYear + "년'        AS ITEM_STD_YEAR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '1010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS ORIGINAL_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '1020'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CHANGE_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '1030'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CONDITIONAL_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '2010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS ORIGINAL_ACCEPT ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '2020'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CHANGE_ACCEPT ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '2030'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS CONDITIONAL_ACCEPT ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '3010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS REJECT_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN B.CODE = '4010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS POSTPONE_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN A.ITEM_DEVISION = '1010'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS RESOLUTION_ITEM ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("             WHEN A.ITEM_DEVISION = '1020'    THEN 1 ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("      )                                  AS REPORT_ITEM ").append("\n");
    		sql.append(" FROM DMS_BD_ITEM A ").append("\n");
    		sql.append("     ,DMS_BD_ITEM_RESULT B ").append("\n");
    		sql.append(" WHERE A.SCHEDULE_NO IN ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          SCHEDULE_NO ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("     WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append(" ) ").append("\n");
    		sql.append(" AND B.ITEM_NO = A.ITEM_NO ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
			pstmt.setString(1, stdYear1 + "0101");
			pstmt.setString(2, stdYear1 + "1231");
			pstmt.setString(3, stdYear2 + "0101");
			pstmt.setString(4, stdYear2 + "1231");
			pstmt.setString(5, stdYear + "0101");
			pstmt.setString(6, stdYear + "1231");
			rs  = pstmt.executeQuery();
			
            while ( rs.next() ) {
            	
                JSONObject jso = new JSONObject();
                
                jso.put("item_std_year",			StringUtils.defaultString(rs.getString("ITEM_STD_YEAR" )));
                jso.put("original_item",			rs.getInt("ORIGINAL_ITEM" ));
                jso.put("change_item"	,			rs.getInt("CHANGE_ITEM" ));
                jso.put("conditional_item",		rs.getInt("CONDITIONAL_ITEM" ));
                jso.put("original_accept",		rs.getInt("ORIGINAL_ACCEPT" ));
                jso.put("change_accept",			rs.getInt("CHANGE_ACCEPT" ));
                jso.put("conditional_accept"	,	rs.getInt("CONDITIONAL_ACCEPT" ));
                jso.put("reject_item",				rs.getInt("REJECT_ITEM" ));
                jso.put("postpone_item",			rs.getInt("POSTPONE_ITEM" ));
                jso.put("resolution_item",		rs.getInt("RESOLUTION_ITEM" ));
                jso.put("report_item",				rs.getInt("REPORT_ITEM" ));
                
                jsa.put(jso);
            }
        } catch ( SQLException e) {
			 Log.error("안건 비중 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
	/**
	 * getStatementRate
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray getStatementRate(String stdYear) throws Exception {
		JSONArray jsa = new JSONArray();
		
		String stdYear1 = "" + (Integer.parseInt(stdYear)-2);
		String stdYear2 = "" + (Integer.parseInt(stdYear)-1);
		
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("     '"+ stdYear1 + "년'        AS STM_RATE_STD_YEAR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("          CASE ").append("\n");
    		sql.append("             WHEN B.BD_CODE = '10' AND A.ATTEND_YN = 'Y' THEN A.COMMENT_NUMBER ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("          END ").append("\n");
    		sql.append("      )              AS STM_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("          CASE ").append("\n");
    		sql.append("             WHEN B.BD_CODE = '20' AND A.ATTEND_YN = 'Y' THEN A.COMMENT_NUMBER ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("          END ").append("\n");
    		sql.append("      )              AS STM_NON_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("          CASE ").append("\n");
    		sql.append("             WHEN A.MEMBER_NO = '99' THEN A.COMMENT_NUMBER ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("          END ").append("\n");
    		sql.append("      )              AS STM_HANDS_ON_WORKER ").append("\n");
    		sql.append(" FROM ( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              * ").append("\n");
    		sql.append("         FROM DMS_BD_ATTEND_MEMBER ").append("\n");
    		sql.append("         WHERE SCHEDULE_NO IN ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  SCHEDULE_NO ").append("\n");
    		sql.append("             FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("             WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("             AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("     ) A FULL OUTER JOIN DMS_MEMBER B ").append("\n");
    		sql.append(" ON A.MEMBER_NO = B.MEMBER_NO ").append("\n");
    		sql.append(" UNION ALL ").append("\n");
    		sql.append(" SELECT ").append("\n");
    		sql.append("     '"+ stdYear2 + "년'        AS STM_RATE_STD_YEAR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("          CASE ").append("\n");
    		sql.append("             WHEN B.BD_CODE = '10' AND A.ATTEND_YN = 'Y' THEN A.COMMENT_NUMBER ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("          END ").append("\n");
    		sql.append("      )              AS STM_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("          CASE ").append("\n");
    		sql.append("             WHEN B.BD_CODE = '20' AND A.ATTEND_YN = 'Y' THEN A.COMMENT_NUMBER ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("          END ").append("\n");
    		sql.append("      )              AS STM_NON_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("          CASE ").append("\n");
    		sql.append("             WHEN A.MEMBER_NO = '99' THEN A.COMMENT_NUMBER ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("          END ").append("\n");
    		sql.append("      )              AS STM_HANDS_ON_WORKER ").append("\n");
    		sql.append(" FROM ( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              * ").append("\n");
    		sql.append("         FROM DMS_BD_ATTEND_MEMBER ").append("\n");
    		sql.append("         WHERE SCHEDULE_NO IN ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  SCHEDULE_NO ").append("\n");
    		sql.append("             FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("             WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("             AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("     ) A FULL OUTER JOIN DMS_MEMBER B ").append("\n");
    		sql.append(" ON A.MEMBER_NO = B.MEMBER_NO ").append("\n");
    		sql.append(" UNION ALL ").append("\n");
    		sql.append(" SELECT ").append("\n");
    		sql.append("     '"+ stdYear + "년'        AS STM_RATE_STD_YEAR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("          CASE ").append("\n");
    		sql.append("             WHEN B.BD_CODE = '10' AND A.ATTEND_YN = 'Y' THEN A.COMMENT_NUMBER ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("          END ").append("\n");
    		sql.append("      )              AS STM_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("          CASE ").append("\n");
    		sql.append("             WHEN B.BD_CODE = '20' AND A.ATTEND_YN = 'Y' THEN A.COMMENT_NUMBER ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("          END ").append("\n");
    		sql.append("      )              AS STM_NON_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("     ,SUM( ").append("\n");
    		sql.append("          CASE ").append("\n");
    		sql.append("             WHEN A.MEMBER_NO = '99' THEN A.COMMENT_NUMBER ").append("\n");
    		sql.append("             ELSE 0 ").append("\n");
    		sql.append("          END ").append("\n");
    		sql.append("      )              AS STM_HANDS_ON_WORKER ").append("\n");
    		sql.append(" FROM ( ").append("\n");
    		sql.append("         SELECT ").append("\n");
    		sql.append("              * ").append("\n");
    		sql.append("         FROM DMS_BD_ATTEND_MEMBER ").append("\n");
    		sql.append("         WHERE SCHEDULE_NO IN ( ").append("\n");
    		sql.append("             SELECT ").append("\n");
    		sql.append("                  SCHEDULE_NO ").append("\n");
    		sql.append("             FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("             WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("             AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append("         ) ").append("\n");
    		sql.append("     ) A FULL OUTER JOIN DMS_MEMBER B ").append("\n");
    		sql.append(" ON A.MEMBER_NO = B.MEMBER_NO ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
			pstmt.setString(1, stdYear1 + "0101");
			pstmt.setString(2, stdYear1 + "1231");
			pstmt.setString(3, stdYear2 + "0101");
			pstmt.setString(4, stdYear2 + "1231");
			pstmt.setString(5, stdYear + "0101");
			pstmt.setString(6, stdYear + "1231");
			rs  = pstmt.executeQuery();
			
            while ( rs.next() ) {
            	
                JSONObject jso = new JSONObject();
                
                jso.put("stm_rate_std_year",				StringUtils.defaultString(rs.getString("STM_RATE_STD_YEAR" )));
                jso.put("stm_executive_director",			rs.getInt("STM_EXECUTIVE_DIRECTOR" ));
                jso.put("stm_non_executive_director",	rs.getInt("STM_NON_EXECUTIVE_DIRECTOR" ));
                jso.put("stm_hands_on_worker",			rs.getInt("STM_HANDS_ON_WORKER" ));
                
                jsa.put(jso);
            }
        } catch ( SQLException e) {
			 Log.error("발언 비중 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
	/**
	 * getAttendanceRate
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray getAttendanceRate(String stdYear) throws Exception {
		JSONArray jsa = new JSONArray();
		
		String stdYear1 = "" + (Integer.parseInt(stdYear)-2);
		String stdYear2 = "" + (Integer.parseInt(stdYear)-1);
		
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append("SELECT ").append("\n");
    		sql.append("     '"+ stdYear1 + "년'        AS ATTENDANCE_RATE_STD_YEAR ").append("\n");
    		sql.append("    ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("            WHEN B.BD_CODE = '10' AND A.ATTEND_YN = 'Y' THEN 1 ").append("\n");
    		sql.append("            ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("     )              AS ATTEND_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("    ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("            WHEN B.BD_CODE = '20' AND A.ATTEND_YN = 'Y' THEN 1 ").append("\n");
    		sql.append("            ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("     )              AS ATTEND_NON_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("    ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("            WHEN A.ATTEND_YN = 'N' THEN 1 ").append("\n");
    		sql.append("            ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("     )              AS ABSENCE ").append("\n");
    		sql.append("FROM ( ").append("\n");
    		sql.append("        SELECT ").append("\n");
    		sql.append("             * ").append("\n");
    		sql.append("        FROM DMS_BD_ATTEND_MEMBER ").append("\n");
    		sql.append("        WHERE SCHEDULE_NO IN ( ").append("\n");
    		sql.append("            SELECT ").append("\n");
    		sql.append("                 SCHEDULE_NO ").append("\n");
    		sql.append("            FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("            WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("            AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append("        ) ").append("\n");
    		sql.append("        AND MEMBER_NO <> '99' ").append("\n");
    		sql.append("    ) A FULL OUTER JOIN DMS_MEMBER B ").append("\n");
    		sql.append("ON A.MEMBER_NO = B.MEMBER_NO ").append("\n");
    		sql.append("UNION ALL ").append("\n");
    		sql.append("SELECT ").append("\n");
    		sql.append("     '"+ stdYear2 + "년'        AS ATTENDANCE_RATE_STD_YEAR ").append("\n");
    		sql.append("    ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("            WHEN B.BD_CODE = '10' AND A.ATTEND_YN = 'Y' THEN 1 ").append("\n");
    		sql.append("            ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("     )              AS ATTEND_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("    ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("            WHEN B.BD_CODE = '20' AND A.ATTEND_YN = 'Y' THEN 1 ").append("\n");
    		sql.append("            ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("     )              AS ATTEND_NON_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("    ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("            WHEN A.ATTEND_YN = 'N' THEN 1 ").append("\n");
    		sql.append("            ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("     )              AS ABSENCE ").append("\n");
    		sql.append("FROM ( ").append("\n");
    		sql.append("        SELECT ").append("\n");
    		sql.append("             * ").append("\n");
    		sql.append("        FROM DMS_BD_ATTEND_MEMBER ").append("\n");
    		sql.append("        WHERE SCHEDULE_NO IN ( ").append("\n");
    		sql.append("            SELECT ").append("\n");
    		sql.append("                 SCHEDULE_NO ").append("\n");
    		sql.append("            FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("            WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("            AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append("        ) ").append("\n");
    		sql.append("        AND MEMBER_NO <> '99' ").append("\n");
    		sql.append("    ) A FULL OUTER JOIN DMS_MEMBER B ").append("\n");
    		sql.append("ON A.MEMBER_NO = B.MEMBER_NO ").append("\n");
    		sql.append("UNION ALL ").append("\n");
    		sql.append("SELECT ").append("\n");
    		sql.append("     '"+ stdYear + "년'        AS ATTENDANCE_RATE_STD_YEAR ").append("\n");
    		sql.append("    ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("            WHEN B.BD_CODE = '10' AND A.ATTEND_YN = 'Y' THEN 1 ").append("\n");
    		sql.append("            ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("     )              AS ATTEND_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("    ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("            WHEN B.BD_CODE = '20' AND A.ATTEND_YN = 'Y' THEN 1 ").append("\n");
    		sql.append("            ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("     )              AS ATTEND_NON_EXECUTIVE_DIRECTOR ").append("\n");
    		sql.append("    ,SUM( ").append("\n");
    		sql.append("         CASE ").append("\n");
    		sql.append("            WHEN A.ATTEND_YN = 'N' THEN 1 ").append("\n");
    		sql.append("            ELSE 0 ").append("\n");
    		sql.append("         END ").append("\n");
    		sql.append("     )              AS ABSENCE ").append("\n");
    		sql.append("FROM ( ").append("\n");
    		sql.append("        SELECT ").append("\n");
    		sql.append("             * ").append("\n");
    		sql.append("        FROM DMS_BD_ATTEND_MEMBER ").append("\n");
    		sql.append("        WHERE SCHEDULE_NO IN ( ").append("\n");
    		sql.append("            SELECT ").append("\n");
    		sql.append("                 SCHEDULE_NO ").append("\n");
    		sql.append("            FROM DMS_BD_SCHEDULE ").append("\n");
    		sql.append("            WHERE BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("            AND NAME_CODE IN ('1010','1020','2010','2020') ").append("\n");
    		sql.append("        ) ").append("\n");
    		sql.append("        AND MEMBER_NO <> '99' ").append("\n");
    		sql.append("    ) A FULL OUTER JOIN DMS_MEMBER B ").append("\n");
    		sql.append("ON A.MEMBER_NO = B.MEMBER_NO ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            
			pstmt.setString(1, stdYear1 + "0101");
			pstmt.setString(2, stdYear1 + "1231");
			pstmt.setString(3, stdYear2 + "0101");
			pstmt.setString(4, stdYear2 + "1231");
			pstmt.setString(5, stdYear + "0101");
			pstmt.setString(6, stdYear + "1231");
			rs  = pstmt.executeQuery();
			
            while ( rs.next() ) {
            	
                JSONObject jso = new JSONObject();
                
                jso.put("attendance_rate_std_year",			StringUtils.defaultString(rs.getString("ATTENDANCE_RATE_STD_YEAR" )));
                jso.put("attend_executive_director",			rs.getInt("ATTEND_EXECUTIVE_DIRECTOR" ));
                jso.put("attend_non_executive_director",	rs.getInt("ATTEND_NON_EXECUTIVE_DIRECTOR" ));
                jso.put("absence",									rs.getInt("ABSENCE" ));
                
                jsa.put(jso);
            }
        } catch ( SQLException e) {
			 Log.error("참석률 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
}