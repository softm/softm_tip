package com.kogas.dms.dao;

import java.sql.SQLException;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;

public class DmsBdStBusinessDAO extends BaseDAO{

	public DmsBdStBusinessDAO() throws Exception {
		super();
	}
	
	/**
	 * getBusinseeItemNumber
	 * @return JSONObject
	 * @throws Exception
	 */
	public JSONObject getBusinseeItemNumber(String stdYear, String businessType, String fieldName) throws Exception {
		JSONObject jso = new JSONObject();
		
		String stdYear1 = "" + (Integer.parseInt(stdYear)-4);
		String stdYear2 = "" + (Integer.parseInt(stdYear)-3);
		String stdYear3 = "" + (Integer.parseInt(stdYear)-2);
		String stdYear4 = "" + (Integer.parseInt(stdYear)-1);
		
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("      A.ITEM_NUM_STD_YEAR1 ").append("\n");
    		sql.append("     ,B.ITEM_NUM_STD_YEAR2 ").append("\n");
    		sql.append("     ,C.ITEM_NUM_STD_YEAR3 ").append("\n");
    		sql.append("     ,D.ITEM_NUM_STD_YEAR4 ").append("\n");
    		sql.append("     ,E.ITEM_NUM_STD_YEAR5 ").append("\n");
    		sql.append(" FROM ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          COUNT(*)           AS ITEM_NUM_STD_YEAR1 ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE A ").append("\n");
    		sql.append("         ,DMS_BD_ITEM B ").append("\n");
    		sql.append("         ,DMS_IF_MEASURE C ").append("\n");
    		sql.append("     WHERE A.BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND A.SCHEDULE_NO = B.SCHEDULE_NO ").append("\n");
    		if(!"0000".equals(businessType)){
    			sql.append("     AND B.ITEM_CODE3 = '"+businessType+"' ").append("\n");
    		}
    		sql.append("     AND B.FUNDS_DEPT = TRIM(C.MEASURE_CD) ").append("\n");
    		if(!"0".equals(fieldName)){
    			sql.append("     AND C.FIELD_CD = '"+fieldName+"' ").append("\n");
    		}
    		sql.append(" ) A, ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          COUNT(*)           AS ITEM_NUM_STD_YEAR2 ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE A ").append("\n");
    		sql.append("         ,DMS_BD_ITEM B ").append("\n");
    		sql.append("         ,DMS_IF_MEASURE C ").append("\n");
    		sql.append("     WHERE A.BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND A.SCHEDULE_NO = B.SCHEDULE_NO ").append("\n");
    		if(!"0000".equals(businessType)){
    			sql.append("     AND B.ITEM_CODE3 = '"+businessType+"' ").append("\n");
    		}
    		sql.append("     AND B.FUNDS_DEPT = TRIM(C.MEASURE_CD) ").append("\n");
    		if(!"0".equals(fieldName)){
    			sql.append("     AND C.FIELD_CD = '"+fieldName+"' ").append("\n");
    		}
    		sql.append(" ) B, ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          COUNT(*)           AS ITEM_NUM_STD_YEAR3 ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE A ").append("\n");
    		sql.append("         ,DMS_BD_ITEM B ").append("\n");
    		sql.append("         ,DMS_IF_MEASURE C ").append("\n");
    		sql.append("     WHERE A.BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND A.SCHEDULE_NO = B.SCHEDULE_NO ").append("\n");
    		if(!"0000".equals(businessType)){
    			sql.append("     AND B.ITEM_CODE3 = '"+businessType+"' ").append("\n");
    		}
    		sql.append("     AND B.FUNDS_DEPT = TRIM(C.MEASURE_CD) ").append("\n");
    		if(!"0".equals(fieldName)){
    			sql.append("     AND C.FIELD_CD = '"+fieldName+"' ").append("\n");
    		}
    		sql.append(" ) C, ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          COUNT(*)           AS ITEM_NUM_STD_YEAR4 ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE A ").append("\n");
    		sql.append("         ,DMS_BD_ITEM B ").append("\n");
    		sql.append("         ,DMS_IF_MEASURE C ").append("\n");
    		sql.append("     WHERE A.BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND A.SCHEDULE_NO = B.SCHEDULE_NO ").append("\n");
    		if(!"0000".equals(businessType)){
    			sql.append("     AND B.ITEM_CODE3 = '"+businessType+"' ").append("\n");
    		}
    		sql.append("     AND B.FUNDS_DEPT = TRIM(C.MEASURE_CD) ").append("\n");
    		if(!"0".equals(fieldName)){
    			sql.append("     AND C.FIELD_CD = '"+fieldName+"' ").append("\n");
    		}
    		sql.append(" ) D, ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          COUNT(*)           AS ITEM_NUM_STD_YEAR5 ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE A ").append("\n");
    		sql.append("         ,DMS_BD_ITEM B ").append("\n");
    		sql.append("         ,DMS_IF_MEASURE C ").append("\n");
    		sql.append("     WHERE A.BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		sql.append("     AND A.SCHEDULE_NO = B.SCHEDULE_NO ").append("\n");
    		if(!"0000".equals(businessType)){
    			sql.append("     AND B.ITEM_CODE3 = '"+businessType+"' ").append("\n");
    		}
    		sql.append("     AND B.FUNDS_DEPT = TRIM(C.MEASURE_CD) ").append("\n");
    		if(!"0".equals(fieldName)){
    			sql.append("     AND C.FIELD_CD = '"+fieldName+"' ").append("\n");
    		}
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
            	
                jso.put("item_num_std_year1"	,	rs.getInt("ITEM_NUM_STD_YEAR1" ));
                jso.put("item_num_std_year2"	,	rs.getInt("ITEM_NUM_STD_YEAR2" ));
                jso.put("item_num_std_year3"	,	rs.getInt("ITEM_NUM_STD_YEAR3" ));
                jso.put("item_num_std_year4"	,	rs.getInt("ITEM_NUM_STD_YEAR4" ));
                jso.put("item_num_std_year5"	,	rs.getInt("ITEM_NUM_STD_YEAR5" ));

            }
        } catch ( SQLException e) {
			 Log.error("사업별 안건 수 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jso;

	}
	
	/**
	 * getRequestNumberList
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray getRequestNumberList(String stdYear, String businessType, String fieldName) throws Exception {
		JSONArray jsa = new JSONArray();
				
        try {
            StringBuffer sql = new StringBuffer();
            
            sql.append(" SELECT ").append("\n");
    		sql.append("      A.KO_NAME ").append("\n");
    		sql.append("     ,A.BD_CODE_ORDER ").append("\n");
    		sql.append("     ,COUNT(B.REQ_NO)    AS REQ_NO ").append("\n");
    		sql.append(" FROM ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          MEMBER_NO ").append("\n");
    		sql.append("         ,KO_NAME ").append("\n");
    		sql.append("         ,BD_CODE_ORDER ").append("\n");
    		sql.append("     FROM DMS_MEMBER ").append("\n");
    		sql.append("     WHERE BD_CODE = '20' ").append("\n");
    		sql.append(" ) A, ( ").append("\n");
    		sql.append("     SELECT ").append("\n");
    		sql.append("          D.REQ_NO ").append("\n");
    		sql.append("         ,D.MEMBER_NO ").append("\n");
    		sql.append("     FROM DMS_BD_SCHEDULE A ").append("\n");
    		sql.append("         ,DMS_BD_ITEM B ").append("\n");
    		sql.append("         ,DMS_IF_MEASURE C ").append("\n");
    		sql.append("         ,DMS_BD_REQUEST D ").append("\n");
    		sql.append("     WHERE A.BD_START_DAY BETWEEN ? AND ? ").append("\n");
    		if(!"0000".equals(businessType)){
    			sql.append("     AND B.ITEM_CODE3 = '"+businessType+"' ").append("\n");
    		}
    		sql.append("     AND B.SCHEDULE_NO = A.SCHEDULE_NO ").append("\n");
    		sql.append("     AND B.FUNDS_DEPT = TRIM(C.MEASURE_CD) ").append("\n");
    		if(!"0".equals(fieldName)){
    			sql.append("     AND C.FIELD_CD = '"+fieldName+"' ").append("\n");
    		}
    		sql.append("     AND D.ITEM_NO = B.ITEM_NO ").append("\n");
    		sql.append(" ) B ").append("\n");
    		sql.append(" WHERE A.MEMBER_NO = B.MEMBER_NO (+) ").append("\n");
    		sql.append(" GROUP BY A.KO_NAME, A.BD_CODE_ORDER ").append("\n");
    		sql.append(" ORDER BY A.BD_CODE_ORDER ").append("\n");
    		
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
			pstmt.setString(1, stdYear + "0101");
			pstmt.setString(2, stdYear + "1231");
			rs  = pstmt.executeQuery();
			
            while ( rs.next() ) {
            	
                JSONObject jso = new JSONObject();
                
                jso.put("ko_name",			StringUtils.defaultString(rs.getString("KO_NAME" )));
                jso.put("req_no",			rs.getInt("REQ_NO" ));
                
                jsa.put(jso);
            }
        } catch ( SQLException e) {
			 Log.error("이사별 요청자료 건수 조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;

	}
	
}