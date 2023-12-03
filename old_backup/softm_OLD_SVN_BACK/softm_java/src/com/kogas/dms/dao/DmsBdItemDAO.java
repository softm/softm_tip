
package com.kogas.dms.dao;

import java.sql.Connection;
import java.sql.SQLException;

import javax.xml.bind.JAXBElement;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Sql;
import com.kogas.dms.common.Util;
import com.kogas.dms.var.TABLE;

public class DmsBdItemDAO extends BaseDAO{

	public DmsBdItemDAO() throws Exception {
		super();
	}

	/**
	 * list
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray list() throws Exception{
        JSONArray jsa = new JSONArray();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
	              " SELECT"
	            + "     ITEM_NO         ,"
	            + "     SCHEDULE_NO     ,"
	            + "     COL             ,"
	            + "     ITEM_DEVISION   ,"
	            + "     ITEM_CODE2      ,"
	            + "     ITEM_CODE3      ,"
	            + "     ITEM_CODE4      ,"
	            + "     ITEM_NAME       ,"
	            + "     APPROVAL_REQUEST,"
	            + "     DEPT_CODE       ,"
	            + "     COAST_CENTER    ,"
	            + "     FUNDS_DEPT      ,"
	            + "     AVAIABLE_BUDGET ,"
	            + "     BUDGET_AMOUNT   ,"
	            + "     REFERENCE       ,"
	            + "     IS_RESULT       ,"
	            + "     CRE_USER        ,"
	            + "     CRE_DATE        ,"
	            + "     READ_COUNT      ,"
	            + "     REAL_ATT_FILE   ,"
	            + "     DISPLAY_ATT_FILE,"
	            + "     STATUS           "
	            + " FROM " + TABLE.TBL_DMS_BD_ITEM + " a "
	            + " WHERE 0 = 0"
//	            + (s_year.equals("") || s_month.equals("") ?"":" AND BD_START_DAY = '" + s_year + "'")
//	            + " WHERE SUBSTR(BD_START_DAY,1,6) = ?"
//	            + " OR    SUBSTR(BD_END_DAY,1,6) = ?"
	            + " ORDER BY ITEM_NO"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
//            int sIdx = 1;
//            pstmt.setString(sIdx++, s_year + s_month);
//            pstmt.setString(sIdx++, s_year + s_month);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                JSONObject jso = new JSONObject();
                jso.put("item_no"                    , StringUtils.defaultString(rs.getString("ITEM_NO"          )));
                jso.put("schedule_no"                , StringUtils.defaultString(rs.getString("SCHEDULE_NO"      )));
                jso.put("col"                        , StringUtils.defaultString(rs.getString("COL"              )));
                jso.put("item_devision"              , StringUtils.defaultString(rs.getString("ITEM_DEVISION"    )));
                jso.put("item_code2"                 , StringUtils.defaultString(rs.getString("ITEM_CODE2"       )));
                jso.put("item_code3"                 , StringUtils.defaultString(rs.getString("ITEM_CODE3"       )));
                jso.put("item_code4"                 , StringUtils.defaultString(rs.getString("ITEM_CODE4"       )));
                jso.put("item_name"                  , StringUtils.defaultString(rs.getString("ITEM_NAME"        )));
                jso.put("approval_request"           , StringUtils.defaultString(rs.getString("APPROVAL_REQUEST" )));
                jso.put("dept_code"                  , StringUtils.defaultString(rs.getString("DEPT_CODE"        )));
                jso.put("coast_center"               , StringUtils.defaultString(rs.getString("COAST_CENTER"     )));
                jso.put("funds_dept"                 , StringUtils.defaultString(rs.getString("FUNDS_DEPT"       )));
                jso.put("avaiable_budget"            , StringUtils.defaultString(rs.getString("AVAIABLE_BUDGET"  )));
                jso.put("budget_amount"              , StringUtils.defaultString(rs.getString("BUDGET_AMOUNT"    )));
                jso.put("reference"                  , StringUtils.defaultString(rs.getString("REFERENCE"        )));
                jso.put("is_result"                  , StringUtils.defaultString(rs.getString("IS_RESULT"        )));
                jso.put("cre_user"                   , StringUtils.defaultString(rs.getString("CRE_USER"         )));
                jso.put("cre_date"                   , StringUtils.defaultString(rs.getString("CRE_DATE"         )));
                jso.put("read_count"                 , StringUtils.defaultString(rs.getString("READ_COUNT"       )));
                jso.put("real_att_file"              , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"    )));
                jso.put("display_att_file"           , StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE" )));
                jso.put("status"                     , StringUtils.defaultString(rs.getString("STATUS"           )));
                jsa.put(jso);
            }
        } catch ( SQLException e) {
			 Log.error("조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;
    }
	
    /**
     * 의안정보 조회
     * searchList
     * @return JSONArray
     * @throws Exception
     */
    public JSONObject searchList(
    		int p_start,
    		String s_bd_start_day_frm,
    		String s_bd_start_day_to,
    		String s_name_code,
    		String s_bd_no,
    		String s_item_name,
    		String s_dept_code,
    		String s_result_code ,
    		boolean paging
    		
   	) throws Exception{
        JSONObject jsr = new JSONObject();
        try {
	        int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;        	
	        JSONArray jsa = new JSONArray();        	
	        int totCnt = -1;
            StringBuffer sql = new StringBuffer();
            sql.append(
	        		(paging?PREFIX_SELECT_SQL:"")            		
                    + " SELECT"
                    + "     a.SCHEDULE_NO         SCHEDULE_NO ,"
                    + "     a.BD_NO               BD_NO       ,"
                    + "     a.BD_START_DAY        BD_START_DAY,"
                    + "     b.ITEM_NO             ITEM_NO     ,"
                    + "     b.COL                 COL         ,"
                    + "     b.ITEM_NAME           ITEM_NAME   ,"
                    + "     b.DEPT_CODE           DEPT_CODE   ,"
                    + "     b.DISPLAY_ATT_FILE    DISPLAY_ATT_FILE,"
                    + "     b.REAL_ATT_FILE       REAL_ATT_FILE   ,"
                    + "     d.CODE_NAME           RESULT_NAME ,"
                    + "     b.READ_COUNT          READ_COUNT   "
                    + " FROM            "+TABLE.TBL_DMS_BD_SCHEDULE         + " a                                    "
                    + " LEFT OUTER JOIN "+TABLE.TBL_DMS_BD_ITEM             + " b ON a.SCHEDULE_NO = b.SCHEDULE_NO   "
                    + " LEFT OUTER JOIN "+TABLE.TBL_DMS_BD_ITEM_RESULT      + " c ON b.ITEM_NO     = c.ITEM_NO       "
                    + " LEFT OUTER JOIN "+TABLE.TBL_DMS_BD_ITEM_RESULT_CODE + " d ON c.CODE        = d.CODE          "
                    + " WHERE 0 = 0"
                    + (s_bd_start_day_frm.equals("") || s_bd_start_day_to.equals("") ?"":" AND a.BD_START_DAY BETWEEN '" + s_bd_start_day_frm + "' AND '" + s_bd_start_day_to + "'")
                    + (s_name_code.equals       ("")?"":" AND a.NAME_CODE     ='" + s_name_code   + "'")
                    + (s_bd_no.equals           ("")?"":" AND a.BD_NO     LIKE '" + s_name_code   + "%'")
                    + (s_item_name.equals       ("")?"":" AND b.ITEM_NAME LIKE '" + s_name_code   + "%'")
                    + (s_dept_code.equals       ("")?"":" AND b.DEPT_CODE     ='" + s_dept_code   + "'")
                    + (s_result_code.equals     ("")?"":" AND c.CODE          ='" + s_result_code + "'")
//              + " WHERE SUBSTR(BD_START_DAY,1,6) = ?"
//              + " OR    SUBSTR(BD_END_DAY,1,6) = ?"
                            + " ORDER BY b.ITEM_NO"
        	                + (paging?SURFIX_SELECT_SQL:"")
                    );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
            Log.debug(sql.toString());
            int sIdx = 1;
            if ( paging ) {
    	        pstmt.setInt(1, p_start - 1);
    	        pstmt.setInt(2, p_start - 1 + p_page_many);
            }
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                JSONObject jso = new JSONObject();
                jso.put("schedule_no"  , StringUtils.defaultString(rs.getString("SCHEDULE_NO" )));
                jso.put("bd_no"        , StringUtils.defaultString(rs.getString("BD_NO"       )));
                jso.put("bd_start_day" , StringUtils.defaultString(rs.getString("BD_START_DAY")));
                jso.put("item_no"      , StringUtils.defaultString(rs.getString("ITEM_NO"     )));
                jso.put("col"          , StringUtils.defaultString(rs.getString("COL"         )));
                jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE" )));
                jso.put("real_att_file"   , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"    )));
                jso.put("item_name"    , StringUtils.defaultString(rs.getString("ITEM_NAME"   )));
                jso.put("dept_code"    , StringUtils.defaultString(rs.getString("DEPT_CODE"   )));
                jso.put("result_name"  , StringUtils.defaultString(rs.getString("RESULT_NAME" )));
                jso.put("read_count"   , StringUtils.defaultString(rs.getString("READ_COUNT"  )));
                if ( paging ) {                
		            if ( totCnt == -1 ) {
		                totCnt = rs.getInt("TOTCNT");
		                jsr.put("total", totCnt);
		            }
                }
	            jsa.put(jso);
	        }
	
	        if ( totCnt == -1 ) {
	            totCnt = 0;
	            jsr.put("total", totCnt);
	        }
	
	        jsr.put("data", jsa); // data
	
	        // Page Navi
	        jsr.put("page_navi", Sql.pageTab(p_start, totCnt, Sql.page_navi_how_many, Sql.page_navi_more_many, Sql.page_navi_limit, "fList") );

        } catch ( SQLException e) {
            Log.error("조회 - Error : " + e.toString());
            e.printStackTrace();
        } finally {
            releaseResource();
        }
        return jsr;
    }
	
	/**
	 * 페이징 list
	 * @param conn
	 * @param type
	 * @return JSONObject
	 * @throws Exception
	 */
	public JSONObject listPaging( int p_start )
	throws Exception{
	    JSONObject jsr = new JSONObject();
	    try {
	        int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;
	        JSONArray jsa = new JSONArray();
	
	        StringBuffer sql = new StringBuffer();
	        int totCnt = -1;
	        sql.setLength(0);
	        sql.append(
	        		PREFIX_SELECT_SQL
	                + " SELECT"
	                + "     ITEM_NO         ,"
	                + "     SCHEDULE_NO     ,"
	                + "     COL             ,"
	                + "     ITEM_DEVISION   ,"
	                + "     ITEM_CODE2      ,"
	                + "     ITEM_CODE3      ,"
	                + "     ITEM_CODE4      ,"
	                + "     ITEM_NAME       ,"
	                + "     APPROVAL_REQUEST,"
	                + "     DEPT_CODE       ,"
	                + "     COAST_CENTER    ,"
	                + "     FUNDS_DEPT      ,"
	                + "     AVAIABLE_BUDGET ,"
	                + "     BUDGET_AMOUNT   ,"
	                + "     REFERENCE       ,"
	                + "     IS_RESULT       ,"
	                + "     CRE_USER        ,"
	                + "     CRE_DATE        ,"
	                + "     READ_COUNT      ,"
	                + "     REAL_ATT_FILE   ,"
	                + "     DISPLAY_ATT_FILE,"
	                + "     STATUS           "
	                + " FROM " + TABLE.TBL_DMS_BD_ITEM + " a "
	                + " WHERE 0 = 0"
	              //+ (s_code.equals("")?"":" AND CODE = '" + s_code + "'")
	              //+ (s_subject.equals("")?"":" AND SUBJECT LIKE '" + s_subject + "%'")
	                + "         ORDER BY NO DESC"
	                + SURFIX_SELECT_SQL
	        );
	        Log.debug(sql.toString());
	        pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
	        pstmt.setInt(1, p_start - 1);
	        pstmt.setInt(2, p_start - 1 + p_page_many);
	
	        rs  = pstmt.executeQuery();
	        while ( rs.next() ) {
	            JSONObject jso = new JSONObject();
	            jso.put("item_no"                    , StringUtils.defaultString(rs.getString("ITEM_NO"          )));
	            jso.put("schedule_no"                , StringUtils.defaultString(rs.getString("SCHEDULE_NO"      )));
	            jso.put("col"                        , StringUtils.defaultString(rs.getString("COL"              )));
	            jso.put("item_devision"              , StringUtils.defaultString(rs.getString("ITEM_DEVISION"    )));
	            jso.put("item_code2"                 , StringUtils.defaultString(rs.getString("ITEM_CODE2"       )));
	            jso.put("item_code3"                 , StringUtils.defaultString(rs.getString("ITEM_CODE3"       )));
	            jso.put("item_code4"                 , StringUtils.defaultString(rs.getString("ITEM_CODE4"       )));
	            jso.put("item_name"                  , StringUtils.defaultString(rs.getString("ITEM_NAME"        )));
	            jso.put("approval_request"           , StringUtils.defaultString(rs.getString("APPROVAL_REQUEST" )));
	            jso.put("dept_code"                  , StringUtils.defaultString(rs.getString("DEPT_CODE"        )));
	            jso.put("coast_center"               , StringUtils.defaultString(rs.getString("COAST_CENTER"     )));
	            jso.put("funds_dept"                 , StringUtils.defaultString(rs.getString("FUNDS_DEPT"       )));
	            jso.put("avaiable_budget"            , StringUtils.defaultString(rs.getString("AVAIABLE_BUDGET"  )));
	            jso.put("budget_amount"              , StringUtils.defaultString(rs.getString("BUDGET_AMOUNT"    )));
	            jso.put("reference"                  , StringUtils.defaultString(rs.getString("REFERENCE"        )));
	            jso.put("is_result"                  , StringUtils.defaultString(rs.getString("IS_RESULT"        )));
	            jso.put("cre_user"                   , StringUtils.defaultString(rs.getString("CRE_USER"         )));
	            jso.put("cre_date"                   , StringUtils.defaultString(rs.getString("CRE_DATE"         )));
	            jso.put("read_count"                 , StringUtils.defaultString(rs.getString("READ_COUNT"       )));
	            jso.put("real_att_file"              , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"    )));
	            jso.put("display_att_file"           , StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE" )));
	            jso.put("status"                     , StringUtils.defaultString(rs.getString("STATUS"           )));
	
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
	
	        // Page Navi
	        jsr.put("page_navi", Sql.pageTab(p_start, totCnt, Sql.page_navi_how_many, Sql.page_navi_more_many, Sql.page_navi_limit, "fList") );
	    } catch ( SQLException e) {
			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
			 e.printStackTrace();
	    } finally {
	        releaseResource();
	    }
	    return jsr;
	}

	/**
	 * gets
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray gets(String in) throws Exception{
		JSONArray jsa = new JSONArray();
		try {
			StringBuffer sql = new StringBuffer();
			sql.append(
					" SELECT"
							+ "     ITEM_NO         ,"
							+ "     SCHEDULE_NO     ,"
							+ "     COL             ,"
							+ "     ITEM_DEVISION   ,"
							+ "     ITEM_CODE2      ,"
							+ "     ITEM_CODE3      ,"
							+ "     ITEM_CODE4      ,"
							+ "     ITEM_NAME       ,"
							+ "     APPROVAL_REQUEST,"
							+ "     DEPT_CODE       ,"
							+ "     COAST_CENTER    ,"
							+ "     FUNDS_DEPT      ,"
							+ "     AVAIABLE_BUDGET ,"
							+ "     BUDGET_AMOUNT   ,"
							+ "     REFERENCE       ,"
							+ "     IS_RESULT       ,"
							+ "     CRE_USER        ,"
							+ "     CRE_DATE        ,"
							+ "     READ_COUNT      ,"
							+ "     REAL_ATT_FILE   ,"
							+ "     DISPLAY_ATT_FILE,"
							+ "     STATUS           "
							+ " FROM " + TABLE.TBL_DMS_BD_ITEM + " a "
							+ " WHERE ITEM_NO IN(" + in + ")"
					);
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
//            int sIdx = 1;
//            pstmt.setString(sIdx++, s_year + s_month);
//            pstmt.setString(sIdx++, s_year + s_month);
			rs  = pstmt.executeQuery();
			while ( rs.next() ) {
				JSONObject jso = new JSONObject();
				jso.put("item_no"                    , StringUtils.defaultString(rs.getString("ITEM_NO"          )));
				jso.put("schedule_no"                , StringUtils.defaultString(rs.getString("SCHEDULE_NO"      )));
				jso.put("col"                        , StringUtils.defaultString(rs.getString("COL"              )));
				jso.put("item_devision"              , StringUtils.defaultString(rs.getString("ITEM_DEVISION"    )));
				jso.put("item_code2"                 , StringUtils.defaultString(rs.getString("ITEM_CODE2"       )));
				jso.put("item_code3"                 , StringUtils.defaultString(rs.getString("ITEM_CODE3"       )));
				jso.put("item_code4"                 , StringUtils.defaultString(rs.getString("ITEM_CODE4"       )));
				jso.put("item_name"                  , StringUtils.defaultString(rs.getString("ITEM_NAME"        )));
				jso.put("approval_request"           , StringUtils.defaultString(rs.getString("APPROVAL_REQUEST" )));
				jso.put("dept_code"                  , StringUtils.defaultString(rs.getString("DEPT_CODE"        )));
				jso.put("coast_center"               , StringUtils.defaultString(rs.getString("COAST_CENTER"     )));
				jso.put("funds_dept"                 , StringUtils.defaultString(rs.getString("FUNDS_DEPT"       )));
				jso.put("avaiable_budget"            , StringUtils.defaultString(rs.getString("AVAIABLE_BUDGET"  )));
				jso.put("budget_amount"              , StringUtils.defaultString(rs.getString("BUDGET_AMOUNT"    )));
				jso.put("reference"                  , StringUtils.defaultString(rs.getString("REFERENCE"        )));
				jso.put("is_result"                  , StringUtils.defaultString(rs.getString("IS_RESULT"        )));
				jso.put("cre_user"                   , StringUtils.defaultString(rs.getString("CRE_USER"         )));
				jso.put("cre_date"                   , StringUtils.defaultString(rs.getString("CRE_DATE"         )));
				jso.put("read_count"                 , StringUtils.defaultString(rs.getString("READ_COUNT"       )));
				jso.put("real_att_file"              , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"    )));
				jso.put("display_att_file"           , StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE" )));
				jso.put("status"                     , StringUtils.defaultString(rs.getString("STATUS"           )));
				jsa.put(jso);
			}
		} catch ( SQLException e) {
			Log.error("조회 - Error : " + e.toString());
			e.printStackTrace();
		} finally {
			releaseResource();
		}
		return jsa;
	}
	
	/**
	 * schView 회의에대한 안건 조회
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray schView(int s_schedule_no) throws Exception{
        JSONArray jsa = new JSONArray();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
	              " SELECT"
	            + "     ITEM_NO         ,"
	            + "     SCHEDULE_NO     ,"
	            + "     COL             ,"
	            + "     ITEM_DEVISION   ,"
	            + "     ITEM_CODE2      ,"
	            + "     ITEM_CODE3      ,"
	            + "     ITEM_CODE4      ,"
	            + "     ITEM_NAME       ,"
	            + "     APPROVAL_REQUEST,"
	            + "     DEPT_CODE       ,"
	            + "     COAST_CENTER    ,"
	            + "     FUNDS_DEPT      ,"
	            + "     AVAIABLE_BUDGET ,"
	            + "     BUDGET_AMOUNT   ,"
	            + "     REFERENCE       ,"
	            + "     IS_RESULT       ,"
	            + "     CRE_USER        ,"
	            + "     CRE_DATE        ,"
	            + "     READ_COUNT      ,"
	            + "     REAL_ATT_FILE   ,"
	            + "     DISPLAY_ATT_FILE,"
	            + "     STATUS           "
	            + " FROM " + TABLE.TBL_DMS_BD_ITEM + " a "
	            + " WHERE SCHEDULE_NO = ?"
	            + " ORDER BY ITEM_NO"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            int sIdx = 1;
            pstmt.setInt(sIdx++, s_schedule_no);
//            pstmt.setString(sIdx++, s_year + s_month);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                JSONObject jso = new JSONObject();
                jso.put("item_no"                    , StringUtils.defaultString(rs.getString("ITEM_NO"          )));
                jso.put("schedule_no"                , StringUtils.defaultString(rs.getString("SCHEDULE_NO"      )));
                jso.put("col"                        , StringUtils.defaultString(rs.getString("COL"              )));
                jso.put("item_devision"              , StringUtils.defaultString(rs.getString("ITEM_DEVISION"    )));
                jso.put("item_code2"                 , StringUtils.defaultString(rs.getString("ITEM_CODE2"       )));
                jso.put("item_code3"                 , StringUtils.defaultString(rs.getString("ITEM_CODE3"       )));
                jso.put("item_code4"                 , StringUtils.defaultString(rs.getString("ITEM_CODE4"       )));
                jso.put("item_name"                  , StringUtils.defaultString(rs.getString("ITEM_NAME"        )));
                jso.put("approval_request"           , StringUtils.defaultString(rs.getString("APPROVAL_REQUEST" )));
                jso.put("dept_code"                  , StringUtils.defaultString(rs.getString("DEPT_CODE"        )));
                jso.put("coast_center"               , StringUtils.defaultString(rs.getString("COAST_CENTER"     )));
                jso.put("funds_dept"                 , StringUtils.defaultString(rs.getString("FUNDS_DEPT"       )));
                jso.put("avaiable_budget"            , StringUtils.defaultString(rs.getString("AVAIABLE_BUDGET"  )));
                jso.put("budget_amount"              , StringUtils.defaultString(rs.getString("BUDGET_AMOUNT"    )));
                jso.put("reference"                  , StringUtils.defaultString(rs.getString("REFERENCE"        )));
                jso.put("is_result"                  , StringUtils.defaultString(rs.getString("IS_RESULT"        )));
                jso.put("cre_user"                   , StringUtils.defaultString(rs.getString("CRE_USER"         )));
                jso.put("cre_date"                   , StringUtils.defaultString(rs.getString("CRE_DATE"         )));
                jso.put("read_count"                 , StringUtils.defaultString(rs.getString("READ_COUNT"       )));
                jso.put("real_att_file"              , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"    )));
                jso.put("display_att_file"           , StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE" )));
                jso.put("status"                     , StringUtils.defaultString(rs.getString("STATUS"           )));
                jsa.put(jso);
            }
        } catch ( SQLException e) {
			 Log.error("조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jsa;
    }
	
	/**
	 * 한건조회
	 * @return JSONObject
	 * @throws Exception
	 */
	public JSONObject view(int s_item_no) throws Exception{
        JSONObject jso = new JSONObject();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
	              " SELECT"
                + "     ITEM_NO         ,"
                + "     SCHEDULE_NO     ,"
                + "     COL             ,"
                + "     ITEM_DEVISION   ,"
                + "     ITEM_CODE2      ,"
                + "     ITEM_CODE3      ,"
                + "     ITEM_CODE4      ,"
                + "     ITEM_NAME       ,"
                + "     APPROVAL_REQUEST,"
                + "     DEPT_CODE       ,"
                + "     COAST_CENTER    ,"
                + "     FUNDS_DEPT      ,"
                + "     AVAIABLE_BUDGET ,"
                + "     BUDGET_AMOUNT   ,"
                + "     REFERENCE       ,"
                + "     IS_RESULT       ,"
                + "     CRE_USER        ,"
                + "     CRE_DATE        ,"
                + "     READ_COUNT      ,"
                + "     REAL_ATT_FILE   ,"
                + "     DISPLAY_ATT_FILE,"
                + "     STATUS           "
	            + " FROM " + TABLE.TBL_DMS_BD_ITEM + " a "
	            + " WHERE ITEM_NO = ?"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());
            int sIdx = 1;
            pstmt.setInt(sIdx++, s_item_no);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                jso.put("item_no"                    , StringUtils.defaultString(rs.getString("ITEM_NO"          )));
                jso.put("schedule_no"                , StringUtils.defaultString(rs.getString("SCHEDULE_NO"      )));
                jso.put("col"                        , StringUtils.defaultString(rs.getString("COL"              )));
                jso.put("item_devision"              , StringUtils.defaultString(rs.getString("ITEM_DEVISION"    )));
                jso.put("item_code2"                 , StringUtils.defaultString(rs.getString("ITEM_CODE2"       )));
                jso.put("item_code3"                 , StringUtils.defaultString(rs.getString("ITEM_CODE3"       )));
                jso.put("item_code4"                 , StringUtils.defaultString(rs.getString("ITEM_CODE4"       )));
                jso.put("item_name"                  , StringUtils.defaultString(rs.getString("ITEM_NAME"        )));
                jso.put("approval_request"           , StringUtils.defaultString(rs.getString("APPROVAL_REQUEST" )));
                jso.put("dept_code"                  , StringUtils.defaultString(rs.getString("DEPT_CODE"        )));
                jso.put("coast_center"               , StringUtils.defaultString(rs.getString("COAST_CENTER"     )));
                jso.put("funds_dept"                 , StringUtils.defaultString(rs.getString("FUNDS_DEPT"       )));
                jso.put("avaiable_budget"            , StringUtils.defaultString(rs.getString("AVAIABLE_BUDGET"  )));
                jso.put("budget_amount"              , StringUtils.defaultString(rs.getString("BUDGET_AMOUNT"    )));
                jso.put("reference"                  , StringUtils.defaultString(rs.getString("REFERENCE"        )));
                jso.put("is_result"                  , StringUtils.defaultString(rs.getString("IS_RESULT"        )));
                jso.put("cre_user"                   , StringUtils.defaultString(rs.getString("CRE_USER"         )));
                jso.put("cre_date"                   , StringUtils.defaultString(rs.getString("CRE_DATE"         )));
                jso.put("read_count"                 , StringUtils.defaultString(rs.getString("READ_COUNT"       )));
                jso.put("real_att_file"              , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"    )));
                jso.put("display_att_file"           , StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE" )));
                jso.put("status"                     , StringUtils.defaultString(rs.getString("STATUS"           )));
            }
        } catch ( SQLException e) {
			 Log.error("보기 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jso;
    }
	
	/**
	 * 파일정보조회
	 * @return JSONObject
	 * @throws Exception
	 */
	public JSONObject getFileInfo(int p_item_no) throws Exception{
		JSONObject jso = new JSONObject();
		try {
			StringBuffer sql = new StringBuffer();
			sql.append(
				" SELECT"
	            + " a.REAL_ATT_FILE      REAL_ATT_FILE,   "
	            + " a.DISPLAY_ATT_FILE   DISPLAY_ATT_FILE   "
	            + " FROM " + TABLE.TBL_DMS_BD_ITEM + " a "
	            + " WHERE a.ITEM_NO = ?"							
			);
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());
			int sIdx = 1;
			pstmt.setInt(sIdx++, p_item_no);
			rs  = pstmt.executeQuery();
			while ( rs.next() ) {
				jso.put("real_att_file"              , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"    )));
				jso.put("display_att_file"           , StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE" )));
			}
		} catch ( SQLException e) {
			Log.error("보기 - Error : " + e.toString());
			e.printStackTrace();
		} finally {
			releaseResource();
		}
		return jso;
	}
	
//	/**
//	 * 최대 회차 + 1 - 조회 
//	 * @return JSONObject
//	 * @throws Exception
//	 */
//	public int getMaxBdNo(String gubun_code, String name_code) throws Exception{
//		int maxBdNo = 0;
//		try {
//			StringBuffer sql = new StringBuffer();
//			sql.append(
//					" SELECT"
//							+ " NVL(MAX(BD_NO),0) + 1 BD_NO"
//							+ " FROM " + TABLE.TBL_DMS_BD_ITEM + " a "
//							+ " WHERE GUBUN_CODE = ?"
//							+ " AND   NAME_CODE  = ?"
//					);
//			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
//			Log.debug(sql.toString());
//			int sIdx = 1;
//			pstmt.setString(sIdx++, gubun_code);
//			pstmt.setString(sIdx++, name_code );
//			rs  = pstmt.executeQuery();
//			while ( rs.next() ) {
//				maxBdNo = Integer.parseInt(StringUtils.defaultString(rs.getString("BD_NO")));
//			}
//		} catch ( SQLException e) {
//			Log.error("보기 - Error : " + e.toString());
//			e.printStackTrace();
//		} finally {
//			releaseResource();
//		}
//		return maxBdNo;
//	}
	
	/**
	 * insert
	 * @return boolean
	 * @throws Exception
	 */
	public boolean insert(JSONObject vo) throws Exception {
		try {
			 if ( 
				vo.get("SCHEDULE_NO" ) == null ||
				vo.get("COL"         ) == null
			    ) throw new Exception("정보가 부족합니다.");
			 
			StringBuffer sql = new StringBuffer();
            sql.append("INSERT INTO " + TABLE.TBL_DMS_BD_ITEM + "("
                    + "     ITEM_NO         ,"
                    + "     SCHEDULE_NO     ,"
                    + "     COL             ,"
                    + "     ITEM_DEVISION   ,"
                    + "     ITEM_CODE2      ,"
                    + "     ITEM_CODE3      ,"
                    + "     ITEM_CODE4      ,"
                    + "     ITEM_NAME       ,"
                    + "     APPROVAL_REQUEST,"
                    + "     DEPT_CODE       ,"
                    + "     COAST_CENTER    ,"
                    + "     FUNDS_DEPT      ,"
                    + "     AVAIABLE_BUDGET ,"
                    + "     BUDGET_AMOUNT   ,"
                    + "     REFERENCE       ,"
                    + "     IS_RESULT       ,"
                    + "     CRE_USER        ,"
                    + "     CRE_DATE        ,"
                    + "     READ_COUNT      ,"
                    + "     REAL_ATT_FILE   ,"
                    + "     DISPLAY_ATT_FILE,"
                    + "     STATUS           "
                    + " ) "
                    + " VALUES "
                    + " ( "
                    + "     " + TABLE.TBL_DMS_BD_ITEM + "_SEQ.NEXTVAL,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ?,"
                    + "     ? "
                    + " )"
            );
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());
            int sIdx = 1;
            
            pstmt.setInt   (sIdx++, (Integer) vo.get("SCHEDULE_NO"        ));
            pstmt.setInt   (sIdx++, (Integer) vo.get("COL"                ));
            pstmt.setString(sIdx++, (String) vo.get("ITEM_DEVISION"       ));
            pstmt.setString(sIdx++, (String) vo.get("ITEM_CODE2"          ));
            pstmt.setString(sIdx++, (String) vo.get("ITEM_CODE3"          ));
            pstmt.setString(sIdx++, (String) vo.get("ITEM_CODE4"          ));
            pstmt.setString(sIdx++, (String) vo.get("ITEM_NAME"           ));
            pstmt.setString(sIdx++, (String) vo.get("APPROVAL_REQUEST"    ));
            pstmt.setString(sIdx++, (String) vo.get("DEPT_CODE"           ));
            pstmt.setString(sIdx++, (String) vo.get("COAST_CENTER"        ));
            pstmt.setString(sIdx++, (String) vo.get("FUNDS_DEPT"          ));
            pstmt.setString(sIdx++, (String) vo.get("AVAIABLE_BUDGET"     ));
            pstmt.setString(sIdx++, (String) vo.get("BUDGET_AMOUNT"       ));
            pstmt.setString(sIdx++, (String) vo.get("REFERENCE"           ));
            pstmt.setString(sIdx++, (String) vo.get("IS_RESULT"           ));
            pstmt.setString(sIdx++, (String) vo.get("CRE_USER"            ));
            pstmt.setString(sIdx++, (String) vo.get("CRE_DATE"            ));
            pstmt.setString(sIdx++, (String) vo.get("READ_COUNT"          ));
            pstmt.setString(sIdx++, (String) vo.get("REAL_ATT_FILE"       ));
            pstmt.setString(sIdx++, (String) vo.get("DISPLAY_ATT_FILE"    ));
            pstmt.setString(sIdx++, (String) vo.get("STATUS"              ));
            
            if( pstmt.executeUpdate() == 0 ) throw new Exception("입력중 에러가 발생하였습니다.");
		} catch ( SQLException e) {
			Log.error("입력 - Error : " + e.toString());
			e.printStackTrace();
			releaseResource();			
			return false;
		} finally {
			releaseResource();
		}
		return true;
	}
	
    /**
     * update
     * @return boolean
     * @throws Exception
     */
    public boolean update(JSONObject vo) throws Exception {
        try {
             if ( 
                vo.get("ITEM_NO") == null ||
                vo.get("COL"    ) == null
                ) throw new Exception("정보가 부족합니다.");
             
            StringBuffer sql = new StringBuffer();
            sql.append("UPDATE " + TABLE.TBL_DMS_BD_ITEM + " SET"
//                    + "     ITEM_NO         = ?,"
//                    + "     SCHEDULE_NO     = ?,"
//                    + "     COL             = ?,"
                    + "     ITEM_DEVISION   = ?,"
                    + "     ITEM_CODE2      = ?,"
                    + "     ITEM_CODE3      = ?,"
                    + "     ITEM_CODE4      = ?,"
                    + "     ITEM_NAME       = ?,"
                    + "     APPROVAL_REQUEST= ?,"
                    + "     DEPT_CODE       = ?,"
                    + "     COAST_CENTER    = ?,"
                    + "     FUNDS_DEPT      = ?,"
                    + "     AVAIABLE_BUDGET = ?,"
                    + "     BUDGET_AMOUNT   = ?,"
                    + "     REFERENCE       = ?,"
                    + "     IS_RESULT       = ?,"
//                    + "     CRE_USER        = ?,"
//                    + "     CRE_DATE        = ?,"
//                    + "     READ_COUNT      = ?,"
                    + "     REAL_ATT_FILE   = ?,"
                    + "     DISPLAY_ATT_FILE= ? "
//                    + "     STATUS          = ? "
                    + " WHERE ITEM_NO = ?"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
            Log.debug(sql.toString());
            int sIdx = 1;
            
//            pstmt.setString(sIdx++, (String) vo.get("SCHEDULE_NO"         ));
//            pstmt.setInt   (sIdx++, (Integer)vo.get("COL"                 ));
            pstmt.setString(sIdx++, (String) vo.get("ITEM_DEVISION"       ));
            pstmt.setString(sIdx++, (String) vo.get("ITEM_CODE2"          ));
            pstmt.setString(sIdx++, (String) vo.get("ITEM_CODE3"          ));
            pstmt.setString(sIdx++, (String) vo.get("ITEM_CODE4"          ));
            pstmt.setString(sIdx++, (String) vo.get("ITEM_NAME"           ));
            pstmt.setString(sIdx++, (String) vo.get("APPROVAL_REQUEST"    ));
            pstmt.setString(sIdx++, (String) vo.get("DEPT_CODE"           ));
            pstmt.setString(sIdx++, (String) vo.get("COAST_CENTER"        ));
            pstmt.setString(sIdx++, (String) vo.get("FUNDS_DEPT"          ));
            pstmt.setString(sIdx++, (String) vo.get("AVAIABLE_BUDGET"     ));
            pstmt.setString(sIdx++, (String) vo.get("BUDGET_AMOUNT"       ));
            pstmt.setString(sIdx++, (String) vo.get("REFERENCE"           ));
            pstmt.setString(sIdx++, (String) vo.get("IS_RESULT"           ));
//            pstmt.setString(sIdx++, (String) vo.get("CRE_USER"            ));
//            pstmt.setString(sIdx++, (String) vo.get("CRE_DATE"            ));
//            pstmt.setString(sIdx++, (String) vo.get("READ_COUNT"          ));
            pstmt.setString(sIdx++, (String) vo.get("REAL_ATT_FILE"       ));
            pstmt.setString(sIdx++, (String) vo.get("DISPLAY_ATT_FILE"    ));
//            pstmt.setString(sIdx++, (String) vo.get("STATUS"              ));
            pstmt.setInt   (sIdx++, (Integer)vo.get("ITEM_NO"             ));
            
            if( pstmt.executeUpdate() == 0 ) throw new Exception("수정중 에러가 발생하였습니다.");
            
        } catch ( SQLException e) {
            Log.error("수정 - Error : " + e.toString());
            e.printStackTrace();
			releaseResource();			
			return false;
        } finally {
            releaseResource();
        }
        return true;
    }
    
	/**
	 * delete
	 * @return boolean
	 * @throws Exception
	 */
	public boolean delete(JSONObject vo) throws Exception {
		try {
			StringBuffer sql = new StringBuffer();
            sql.append("DELETE FROM " + TABLE.TBL_DMS_BD_ITEM + " "
                    + " WHERE ITEM_NO = ?"
            );
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());            
			Log.debug(sql.toString());
            int sIdx = 1;
            pstmt.setInt   (sIdx++, (Integer) vo.get("ITEM_NO"));   
		    
            if( pstmt.executeUpdate() == 0 ) throw new Exception("삭제중 에러가 발생하였습니다.");
            
		} catch ( SQLException e) {
			Log.error("삭제 - Error : " + e.toString());
			e.printStackTrace();
			releaseResource();			
			return false;
		} finally {
			releaseResource();
		}
		return true;
	}
	
	/**
	 * deletes
	 * @return boolean
	 * @throws Exception
	 */
	public boolean deletes(String in) throws Exception {
		try {
			StringBuffer sql = new StringBuffer();
            sql.append("DELETE FROM " + TABLE.TBL_DMS_BD_ITEM + " "
                    + " WHERE ITEM_NO IN( " + in + ")"
            );
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());            
			Log.debug(sql.toString());
		    
            if( pstmt.executeUpdate() == 0 ) throw new Exception("삭제중 에러가 발생하였습니다.");
            
		} catch ( SQLException e) {
			Log.error("삭제 - Error : " + e.toString());
			e.printStackTrace();
			releaseResource();			
			return false;
		} finally {
			releaseResource();
		}
		return true;
	}
	
	/**
	 * 일괄 처리상태 수정
	 * @return boolean
	 * @throws Exception
	 */
	public boolean updateStatus(String in,String status,String returnReason) throws Exception {
		try {
			StringBuffer sql = new StringBuffer();
			sql.append("UPDATE " + TABLE.TBL_DMS_BD_ITEM + " "
					+ " SET STATUS = '" + status + "'"
					+ ( status.equals("2")?", RETURN_REASON= '" + returnReason + "'":"")
					+ " WHERE ITEM_NO IN( " + in + ")"
			);
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());            
			Log.debug(sql.toString());
			
			if( pstmt.executeUpdate() == 0 ) throw new Exception("수정중 에러가 발생하였습니다.");
			
		} catch ( SQLException e) {
			Log.error("삭제 - Error : " + e.toString());
			e.printStackTrace();
			releaseResource();			
			return false;
		} finally {
			releaseResource();
		}
		return true;
	}
	
	/**
	 * 조회수 증가
	 * @return boolean
	 * @throws Exception
	 */
	public boolean updateReadCount(int itemNo) throws Exception {
		try {
			StringBuffer sql = new StringBuffer();
			sql.append("UPDATE " + TABLE.TBL_DMS_BD_ITEM + " "
					+ " SET READ_COUNT = READ_COUNT + 1"
					+ " WHERE ITEM_NO = ?"
					);
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());            
			Log.debug(sql.toString());
            int sIdx = 1;
            pstmt.setInt   (sIdx++, itemNo);   
			if( pstmt.executeUpdate() == 0 ) throw new Exception("수정중 에러가 발생하였습니다.");
			
		} catch ( SQLException e) {
			Log.error("삭제 - Error : " + e.toString());
			e.printStackTrace();
			releaseResource();			
			return false;
		} finally {
			releaseResource();
		}
		return true;
	}
	
	/**
	 * 의안번호 + 1 - 조회 
	 * @return JSONObject
	 * @throws Exception
	 */
	public int getMaxCol() throws Exception{
		int maxCol = 0;
		try {
			StringBuffer sql = new StringBuffer();
			sql.append(
					" SELECT"
							+ " NVL(MAX(COL),0) + 1 COL"
							+ " FROM " + TABLE.TBL_DMS_BD_ITEM + " a "
//							+ " WHERE GUBUN_CODE = ?"
//							+ " AND   NAME_CODE  = ?"
					);
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());
//			int sIdx = 1;
//			pstmt.setString(sIdx++, gubun_code);
//			pstmt.setString(sIdx++, name_code );
			rs  = pstmt.executeQuery();
			while ( rs.next() ) {
				maxCol = Integer.parseInt(StringUtils.defaultString(rs.getString("COL")));
			}
		} catch ( SQLException e) {
			Log.error("보기 - Error : " + e.toString());
			e.printStackTrace();
		} finally {
			releaseResource();
		}
		return maxCol;
	}
		
}