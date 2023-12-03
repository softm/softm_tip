
package com.kogas.dms.dao;

import java.sql.SQLException;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Sql;
import com.kogas.dms.common.Util;
import com.kogas.dms.var.TABLE;

public class DmsPropelDAO extends BaseDAO{

	public DmsPropelDAO() throws Exception {
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
	            + "     PROPEL_NO      ,"
	            + "     CHARGE_USER    ,"
	            + "     RPPEL_PROGRESS ,"
	            + "     SLIGHT_CONTENT ,"
	            + "     HENCEFORTH_PLAN,"
	            + "     ATTCHE_FILE    ,"
	            + "     ITEM_NO         "
	            + " FROM " + TABLE.TBL_DMS_PROPEL_PRESENT + " a "
	            + " WHERE 0 = 0"
//	            + (s_year.equals("") || s_month.equals("") ?"":" AND BD_START_DAY = '" + s_year + "'")
//	            + " WHERE SUBSTR(BD_START_DAY,1,6) = ?"
//	            + " OR    SUBSTR(BD_END_DAY,1,6) = ?"
	            + " ORDER BY PROPEL_NO"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
//            int sIdx = 1;
//            pstmt.setString(sIdx++, s_year + s_month);
//            pstmt.setString(sIdx++, s_year + s_month);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                JSONObject jso = new JSONObject();
                jso.put("PROPEL_NO      "          , StringUtils.defaultString(rs.getString("PROPEL_NO"                )));
                jso.put("CHARGE_USER    "          , StringUtils.defaultString(rs.getString("CHARGE_USER"              )));
                jso.put("RPPEL_PROGRESS "          , StringUtils.defaultString(rs.getString("RPPEL_PROGRESS"           )));
                jso.put("SLIGHT_CONTENT "          , StringUtils.defaultString(rs.getString("SLIGHT_CONTENT"           )));
                jso.put("HENCEFORTH_PLAN"          , StringUtils.defaultString(rs.getString("HENCEFORTH_PLAN"          )));
                jso.put("ATTCHE_FILE    "          , StringUtils.defaultString(rs.getString("ATTCHE_FILE"              )));
                jso.put("ITEM_NO        "          , StringUtils.defaultString(rs.getString("ITEM_NO"                  )));
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
	 * 페이징 list
	 * @param conn
	 * @param type
	 * @return JSONObject
	 * @throws Exception
	 */
	public JSONObject searchList( 
			int p_start,
			String s_wriet_date_frm,
			String s_wriet_date_to ,
			String s_charge_user ,
			String s_title       ,
			String s_status      ,
			String s_req_gubun   ,
			String s_dept_id     ,
			boolean paging
			)
	throws Exception{
	    JSONObject jsr = new JSONObject();
	    try {
	        int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;
	        JSONArray jsa = new JSONArray();
	
	        StringBuffer sql = new StringBuffer();
	        int totCnt = -1;
	        sql.setLength(0);
	        sql.append(
	        		(paging?PREFIX_SELECT_SQL:"")  
                    + " SELECT"
                    + "     a.PROPEL_NO            PROPEL_NO          ,"
                    + "     a.ITEM_NO           ITEM_NO         ,"
                    + "     a.MEMBER_NO         MEMBER_NO       ,"
                    + "     a.WRIET_DATE        WRIET_DATE      ,"
                    + "     a.END_DATE          END_DATE        ,"
                    + "     a.DEPT_ID           DEPT_ID         ,"
                    + "     a.REQ_CONTEXT       REQ_CONTEXT     ,"
                    + "     a.REQ_GUBUN         REQ_GUBUN       ,"
                    + "     a.CHARGE_USER       CHARGE_USER     ,"
                    + "     a.ANS_CONTEXT       ANS_CONTEXT     ,"
                    + "     a.STATUS            STATUS          ,"
                    + "     a.TITLE             TITLE           ,"
                    + "     a.REAL_ATT_FILE     REAL_ATT_FILE   ,"
                    + "     a.DISPLAY_ATT_FILE  DISPLAY_ATT_FILE,"
                    + "     b.ITEM_NAME         ITEM_NAME       ,"
                    + "     b.REAL_ATT_FILE     ITEM_REAL_ATT_FILE, "
                    + "     b.DISPLAY_ATT_FILE  ITEM_DISPLAY_ATT_FILE , "
                    + "     c.KO_NAME           KO_NAME          "
                    + " FROM "            + TABLE.TBL_DMS_PROPEL_PRESENT + " a "
                    + " LEFT OUTER JOIN " + TABLE.TBL_DMS_BD_ITEM    + " b "
                    + " ON a.ITEM_NO = b.ITEM_NO "
                    + " LEFT OUTER JOIN " + TABLE.TBL_DMS_MEMBER    + " c "
                    + " ON a.MEMBER_NO = c.MEMBER_NO "
                    + " WHERE 0 = 0"
                    + (s_wriet_date_frm.equals("") || s_wriet_date_to.equals("") ?"":" AND a.WRIET_DATE BETWEEN '" + s_wriet_date_frm + "' AND '" + s_wriet_date_to + "'")
                    + (s_charge_user.equals     ("")?"":" AND a.CHARGE_USER LIKE '" + s_charge_user   + "%'")
                    + (s_title.equals           ("")?"":" AND a.TITLE       LIKE '" + s_title         + "%'")
                    + (s_status.equals          ("")?"":" AND a.STATUS          ='" + s_status        + "'")
                    + (s_req_gubun.equals       ("")?"":" AND a.REQ_GUBUN       ='" + s_req_gubun     + "'")
                    + (s_dept_id.equals         ("")?"":" AND a.DEPT_ID         ='" + s_dept_id       + "'")
	                + " ORDER BY PROPEL_NO DESC"
	                + (paging?SURFIX_SELECT_SQL:"")
	        );
	        Log.debug(sql.toString());
	        pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
            if ( paging ) { 
		        pstmt.setInt(1, p_start - 1);
		        pstmt.setInt(2, p_start - 1 + p_page_many);
            }
            
	        rs  = pstmt.executeQuery();
	        while ( rs.next() ) {
	            JSONObject jso = new JSONObject();
                jso.put("propel_no"          , StringUtils.defaultString(rs.getString("PROPEL_NO"          )));
                jso.put("item_no"         , StringUtils.defaultString(rs.getString("ITEM_NO"         )));
                jso.put("member_no"       , StringUtils.defaultString(rs.getString("MEMBER_NO"       )));
                jso.put("wriet_date"      , StringUtils.defaultString(rs.getString("WRIET_DATE"      )));
                jso.put("end_date"        , StringUtils.defaultString(rs.getString("END_DATE"        )));
                jso.put("dept_id"         , StringUtils.defaultString(rs.getString("DEPT_ID"         )));
                jso.put("req_context"     , StringUtils.defaultString(rs.getString("REQ_CONTEXT"     )));
                jso.put("req_gubun"       , StringUtils.defaultString(rs.getString("REQ_GUBUN"       )));
                jso.put("charge_user"     , StringUtils.defaultString(rs.getString("CHARGE_USER"     )));
                jso.put("ans_context"     , StringUtils.defaultString(rs.getString("ANS_CONTEXT"     )));
                jso.put("status"          , StringUtils.defaultString(rs.getString("STATUS"          )));
                jso.put("title"           , StringUtils.defaultString(rs.getString("TITLE"           )));
                jso.put("real_att_file"   , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"   )));
                jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
                jso.put("ko_name"         , StringUtils.defaultString(rs.getString("KO_NAME"         )));
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
                    + "     PROPEL_NO          ,"
                    + "     ITEM_NO         ,"
                    + "     MEMBER_NO       ,"
                    + "     WRIET_DATE      ,"
                    + "     END_DATE        ,"
                    + "     DEPT_ID         ,"
                    + "     REQ_CONTEXT     ,"
                    + "     REQ_GUBUN       ,"
                    + "     CHARGE_USER     ,"
                    + "     ANS_CONTEXT     ,"
                    + "     STATUS          ,"
                    + "     REAL_ATT_FILE   ,"
                    + "     DISPLAY_ATT_FILE "
                    + " FROM " + TABLE.TBL_DMS_PROPEL_PRESENT + " a "
                    + " WHERE PROPEL_NO IN(" + in + ")"
					);
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
//            int sIdx = 1;
//            pstmt.setString(sIdx++, s_year + s_month);
//            pstmt.setString(sIdx++, s_year + s_month);
			rs  = pstmt.executeQuery();
			while ( rs.next() ) {
				JSONObject jso = new JSONObject();
                jso.put("propel_no"          , StringUtils.defaultString(rs.getString("PROPEL_NO"          )));
                jso.put("item_no"         , StringUtils.defaultString(rs.getString("ITEM_NO"         )));
                jso.put("member_no"       , StringUtils.defaultString(rs.getString("MEMBER_NO"       )));
                jso.put("wriet_date"      , StringUtils.defaultString(rs.getString("WRIET_DATE"      )));
                jso.put("end_date"        , StringUtils.defaultString(rs.getString("END_DATE"        )));
                jso.put("dept_id"         , StringUtils.defaultString(rs.getString("DEPT_ID"         )));
                jso.put("req_context"     , StringUtils.defaultString(rs.getString("REQ_CONTEXT"     )));
                jso.put("req_gubun"       , StringUtils.defaultString(rs.getString("REQ_GUBUN"       )));
                jso.put("charge_user"     , StringUtils.defaultString(rs.getString("CHARGE_USER"     )));
                jso.put("ans_context"     , StringUtils.defaultString(rs.getString("ANS_CONTEXT"     )));
                jso.put("status"          , StringUtils.defaultString(rs.getString("STATUS"          )));
                jso.put("real_att_file"   , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"   )));
                jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
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
	public JSONObject view(int s_propel_no) throws Exception{
        JSONObject jso = new JSONObject();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
	              " SELECT"
                + "     PROPEL_NO          ,"
                + "     ITEM_NO         ,"
                + "     MEMBER_NO       ,"
                + "     WRIET_DATE      ,"
                + "     END_DATE        ,"
                + "     DEPT_ID         ,"
                + "     REQ_CONTEXT     ,"
                + "     REQ_GUBUN       ,"
                + "     CHARGE_USER     ,"
                + "     ANS_CONTEXT     ,"
                + "     STATUS          ,"
                + "     REAL_ATT_FILE   ,"
                + "     DISPLAY_ATT_FILE,"
                + "     TITLE            "
	            + " FROM " + TABLE.TBL_DMS_PROPEL_PRESENT + " a "
	            + " WHERE PROPEL_NO = ?"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());
            int sIdx = 1;
            pstmt.setInt(sIdx++, s_propel_no);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                jso.put("propel_no"          , StringUtils.defaultString(rs.getString("PROPEL_NO"          )));
                jso.put("item_no"         , StringUtils.defaultString(rs.getString("ITEM_NO"         )));
                jso.put("member_no"       , StringUtils.defaultString(rs.getString("MEMBER_NO"       )));
                jso.put("wriet_date"      , StringUtils.defaultString(rs.getString("WRIET_DATE"      )));
                jso.put("end_date"        , StringUtils.defaultString(rs.getString("END_DATE"        )));
                jso.put("dept_id"         , StringUtils.defaultString(rs.getString("DEPT_ID"         )));
                jso.put("req_context"     , StringUtils.defaultString(rs.getString("REQ_CONTEXT"     )));
                jso.put("req_gubun"       , StringUtils.defaultString(rs.getString("REQ_GUBUN"       )));
                jso.put("charge_user"     , StringUtils.defaultString(rs.getString("CHARGE_USER"     )));
                jso.put("ans_context"     , StringUtils.defaultString(rs.getString("ANS_CONTEXT"     )));
                jso.put("status"          , StringUtils.defaultString(rs.getString("STATUS"          )));
                jso.put("real_att_file"   , StringUtils.defaultString(rs.getString("REAL_ATT_FILE"   )));
                jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
                jso.put("title"           , StringUtils.defaultString(rs.getString("TITLE"           )));
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
	public JSONObject getFileInfo(int p_propel_no) throws Exception{
		JSONObject jso = new JSONObject();
		try {
			StringBuffer sql = new StringBuffer();
			sql.append(
				" SELECT"
	            + " a.REAL_ATT_FILE      REAL_ATT_FILE,   "
	            + " a.DISPLAY_ATT_FILE   DISPLAY_ATT_FILE   "
	            + " FROM " + TABLE.TBL_DMS_PROPEL_PRESENT + " a "
	            + " WHERE a.PROPEL_NO = ?"							
			);
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());
			int sIdx = 1;
			pstmt.setInt(sIdx++, p_propel_no);
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
	
	
	/**
	 * insert
	 * @return boolean
	 * @throws Exception
	 */
	public boolean insert(JSONObject vo) throws Exception {
		try {
			 if ( 
				vo.get("ITEM_NO"     ) == null ||
				vo.get("TITLE"       ) == null
			    ) throw new Exception("정보가 부족합니다.");
			 
			StringBuffer sql = new StringBuffer();
            sql.append("INSERT INTO " + TABLE.TBL_DMS_PROPEL_PRESENT + "("
                    + "     PROPEL_NO          ,"
                    + "     ITEM_NO         ,"
                    + "     MEMBER_NO       ,"
                    + "     WRIET_DATE      ,"
                    + "     END_DATE        ,"
                    + "     DEPT_ID         ,"
                    + "     REQ_CONTEXT     ,"
                    + "     REQ_GUBUN       ,"
                    + "     CHARGE_USER     ,"
                    + "     ANS_CONTEXT     ,"
                    + "     STATUS          ,"
                    + "     REAL_ATT_FILE   ,"
                    + "     DISPLAY_ATT_FILE,"
                    + "     TITLE            "
                    + " ) "
                    + " VALUES "
                    + " ( "
                    + "     " + TABLE.TBL_DMS_PROPEL_PRESENT + "_SEQ.NEXTVAL,"		
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
            
            pstmt.setInt   (sIdx++, (Integer)vo.get("ITEM_NO"         ));
            pstmt.setString(sIdx++, (String) vo.get("MEMBER_NO"       ));
            pstmt.setString(sIdx++, (String) vo.get("WRIET_DATE"      ));
            pstmt.setString(sIdx++, (String) vo.get("END_DATE"        ));
            pstmt.setString(sIdx++, (String) vo.get("DEPT_ID"         ));
            pstmt.setString(sIdx++, (String) vo.get("REQ_CONTEXT"     ));
            pstmt.setString(sIdx++, (String) vo.get("REQ_GUBUN"       ));
            pstmt.setString(sIdx++, (String) vo.get("CHARGE_USER"     ));
            pstmt.setString(sIdx++, (String) vo.get("ANS_CONTEXT"     ));
            pstmt.setString(sIdx++, (String) vo.get("STATUS"          ));
            pstmt.setString(sIdx++, (String) vo.get("REAL_ATT_FILE"   ));
            pstmt.setString(sIdx++, (String) vo.get("DISPLAY_ATT_FILE"));
            pstmt.setString(sIdx++, (String) vo.get("TITLE"           ));
            
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
                vo.get("PROPEL_NO" ) == null ||
                vo.get("TITLE"  ) == null
                ) throw new Exception("정보가 부족합니다.");
             
            StringBuffer sql = new StringBuffer();
            sql.append("UPDATE " + TABLE.TBL_DMS_PROPEL_PRESENT + " SET"
//                    + "     PROPEL_NO          = ?,"
//                    + "     ITEM_NO         = ?,"
//                    + "     MEMBER_NO       = ?,"
//                    + "     WRIET_DATE      = ?,"
                    + "     END_DATE        = ?,"
                    + "     DEPT_ID         = ?,"
                    + "     REQ_CONTEXT     = ?,"
//                    + "     REQ_GUBUN       = ?,"
                    + "     CHARGE_USER     = ?,"
//                    + "     ANS_CONTEXT     = ?,"
//                    + "     STATUS          = ?,"
//                    + "     REAL_ATT_FILE   = ?,"
//                    + "     DISPLAY_ATT_FILE= ?,"
                    + "     TITLE           = ? "
                    + " WHERE PROPEL_NO = ?"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
            Log.debug(sql.toString());
            int sIdx = 1;
            
            pstmt.setString(sIdx++, (String) vo.get("END_DATE"        ));
            pstmt.setString(sIdx++, (String) vo.get("DEPT_ID"         ));
            pstmt.setString(sIdx++, (String) vo.get("REQ_CONTEXT"     ));
//            pstmt.setString(sIdx++, (String) vo.get("REQ_GUBUN"       ));
            pstmt.setString(sIdx++, (String) vo.get("CHARGE_USER"     ));
//            pstmt.setString(sIdx++, (String) vo.get("ANS_CONTEXT"     ));
//            pstmt.setString(sIdx++, (String) vo.get("STATUS"          ));
//            pstmt.setString(sIdx++, (String) vo.get("REAL_ATT_FILE"   ));
//            pstmt.setString(sIdx++, (String) vo.get("DISPLAY_ATT_FILE"));
            pstmt.setString(sIdx++, (String) vo.get("TITLE"           ));
            pstmt.setInt   (sIdx++, (Integer) vo.get("PROPEL_NO"          ));
            
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
            sql.append("DELETE FROM " + TABLE.TBL_DMS_PROPEL_PRESENT + " "
                    + " WHERE PROPEL_NO = ?"
            );
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());            
			Log.debug(sql.toString());
            int sIdx = 1;
            pstmt.setInt   (sIdx++, (Integer) vo.get("PROPEL_NO"));   
		    
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
            sql.append("DELETE FROM " + TABLE.TBL_DMS_PROPEL_PRESENT + " "
                    + " WHERE PROPEL_NO IN( " + in + ")"
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
     * updateAnswer
     * @return boolean
     * @throws Exception
     */
    public boolean updateAnswer(JSONObject vo) throws Exception {
        try {
             if ( 
                vo.get("REQ_GUBUN"   ) == null ||
                vo.get("ANS_CONTEXT" ) == null
                ) throw new Exception("정보가 부족합니다.");
             
            StringBuffer sql = new StringBuffer();
            sql.append("UPDATE " + TABLE.TBL_DMS_PROPEL_PRESENT + " SET"
                    + "     REQ_GUBUN       = ?,"
                    + "     ANS_CONTEXT     = ?,"
                    + "     REAL_ATT_FILE   = ?,"
                    + "     DISPLAY_ATT_FILE= ? "
                    + " WHERE PROPEL_NO = ?"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
            Log.debug("DISPLAY_ATT_FILE : " +(String) vo.get("DISPLAY_ATT_FILE"));
            Log.debug(sql.toString());
            int sIdx = 1;
            
            pstmt.setString(sIdx++, (String) vo.get("REQ_GUBUN"       ));
            pstmt.setString(sIdx++, (String) vo.get("ANS_CONTEXT"     ));
            pstmt.setString(sIdx++, (String) vo.get("REAL_ATT_FILE"   ));
            pstmt.setString(sIdx++, (String) vo.get("DISPLAY_ATT_FILE"));
            pstmt.setInt   (sIdx++, (Integer) vo.get("PROPEL_NO"          ));
            
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
     * updateStatus
     * @return boolean
     * @throws Exception
     */
    public boolean updateStatus(String p_propel_no, String p_status) throws Exception {
    	try {
    		if ( 
    				p_propel_no == null ||
    				p_status == null
    		) throw new Exception("정보가 부족합니다.");
    		
    		StringBuffer sql = new StringBuffer();
    		sql.append("UPDATE " + TABLE.TBL_DMS_PROPEL_PRESENT + " SET"
    				+ "     STATUS       = ? "
    				+ " WHERE PROPEL_NO = ?"
    				);
    		pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
    		Log.debug(sql.toString());
    		int sIdx = 1;
    		
    		pstmt.setString(sIdx++, p_status);
    		pstmt.setInt   (sIdx++, Integer.valueOf(p_propel_no));
    		
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
}