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

public class DmsBdScheduleDAO extends BaseDAO{

	public DmsBdScheduleDAO() throws Exception {
		super();
	}

	/**
	 * list
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray list(String s_year,String s_month) throws Exception{
        JSONArray jsa = new JSONArray();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
	              " SELECT"
	            + "     SCHEDULE_NO ,"
	            + "     BD_NO       ,"
	            + "     GUBUN_CODE  ,"
	            + "     NAME_CODE   ,"
	            + "     BD_START_DAY,"
	            + "     BD_END_DAY  ,"
	            + "     BD_TIME     ,"
	            + "     BD_PLACE     "
	            + " FROM " + TABLE.TBL_DMS_BD_SCHEDULE + " a "
//	            + " WHERE 0 = 0"
//	            + (s_year.equals("") || s_month.equals("") ?"":" AND BD_START_DAY = '" + s_year + "'")
	            + " WHERE SUBSTR(BD_START_DAY,1,6) = ?"
	            + " OR    SUBSTR(BD_END_DAY,1,6) = ?"
	            + " ORDER BY SCHEDULE_NO"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            int sIdx = 1;
            pstmt.setString(sIdx++, s_year + s_month);
            pstmt.setString(sIdx++, s_year + s_month);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                JSONObject jso = new JSONObject();
                jso.put("schedule_no"           , StringUtils.defaultString(rs.getString("SCHEDULE_NO" )));
                jso.put("bd_no"                 , StringUtils.defaultString(rs.getString("BD_NO"       )));
                jso.put("gubun_code"            , StringUtils.defaultString(rs.getString("GUBUN_CODE"  )));
                jso.put("name_code"             , StringUtils.defaultString(rs.getString("NAME_CODE"   )));
                jso.put("bd_start_day"          , StringUtils.defaultString(rs.getString("BD_START_DAY")));
                jso.put("bd_end_day"            , StringUtils.defaultString(rs.getString("BD_END_DAY"  )));
                jso.put("bd_time"               , StringUtils.defaultString(rs.getString("BD_TIME"     )));
                jso.put("bd_place"              , StringUtils.defaultString(rs.getString("BD_PLACE"    )));
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
	public JSONObject listPaging( int p_start,int p_how_many )
	throws Exception{
        JSONObject jsr = new JSONObject();
        try {
            int p_page_many  = p_how_many;
//            int p_page_many  = ( p_start >= Sql.page_navi_how_many + 1 ) ? Sql.page_navi_more_many : Sql.page_navi_how_many ;
            JSONArray jsa = new JSONArray();

            StringBuffer sql = new StringBuffer();
            int totCnt = -1;
            sql.setLength(0);
            sql.append(
            		PREFIX_SELECT_SQL
                    + " SELECT"
                    + "     SCHEDULE_NO ,"
                    + "     BD_NO       ,"
                    + "     GUBUN_CODE  ,"
                    + "     NAME_CODE   ,"
                    + "     BD_START_DAY,"
                    + "     BD_END_DAY  ,"
                    + "     BD_TIME     ,"
                    + "     BD_PLACE     "
                    + " FROM " + TABLE.TBL_DMS_BD_SCHEDULE + " a "
                    + " WHERE 0 = 0"
                  //+ (s_code.equals("")?"":" AND CODE = '" + s_code + "'")
                  //+ (s_subject.equals("")?"":" AND SUBJECT LIKE '" + s_subject + "%'")
                    + "         ORDER BY SCHEDULE_NO DESC"
                    + SURFIX_SELECT_SQL
            );
            Log.debug(sql.toString());
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
            pstmt.setInt(1, p_start - 1);
            pstmt.setInt(2, p_start - 1 + p_page_many);

            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                JSONObject jso = new JSONObject();
                jso.put("schedule_no"           , StringUtils.defaultString(rs.getString("SCHEDULE_NO" )));
                jso.put("bd_no"                 , StringUtils.defaultString(rs.getString("BD_NO"       )));
                jso.put("gubun_code"            , StringUtils.defaultString(rs.getString("GUBUN_CODE"  )));
                jso.put("name_code"             , StringUtils.defaultString(rs.getString("NAME_CODE"   )));
                jso.put("bd_start_day"          , StringUtils.defaultString(rs.getString("BD_START_DAY")));
                jso.put("bd_end_day"            , StringUtils.defaultString(rs.getString("BD_END_DAY"  )));
                jso.put("bd_time"               , StringUtils.defaultString(rs.getString("BD_TIME"     )));
                jso.put("bd_place"              , StringUtils.defaultString(rs.getString("BD_PLACE"    )));

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
            jsr.put("page_navi", Sql.pageTab(p_start, totCnt, p_page_many, p_page_many, Sql.page_navi_limit, "fList") );
        } catch ( SQLException e) {
   			 Util.logger.error("e.toString() : " + e.toString()+ "<BR>");
   			 e.printStackTrace();
        } finally {
            releaseResource();
        }
        return jsr;
    }


	/**
	 * list
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONArray gets(String in) throws Exception{
        JSONArray jsa = new JSONArray();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
	              " SELECT"
	            + "     SCHEDULE_NO ,"
	            + "     BD_NO       ,"
	            + "     GUBUN_CODE  ,"
	            + "     NAME_CODE   ,"
	            + "     BD_START_DAY,"
	            + "     BD_END_DAY  ,"
	            + "     BD_TIME     ,"
	            + "     BD_PLACE     "
	            + " FROM " + TABLE.TBL_DMS_BD_SCHEDULE + " a "
//	            + " WHERE 0 = 0"
//	            + (s_year.equals("") || s_month.equals("") ?"":" AND BD_START_DAY = '" + s_year + "'")
	            + " WHERE = IN(" + in + ")" 
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                JSONObject jso = new JSONObject();
                jso.put("schedule_no"           , StringUtils.defaultString(rs.getString("SCHEDULE_NO" )));
                jso.put("bd_no"                 , StringUtils.defaultString(rs.getString("BD_NO"       )));
                jso.put("gubun_code"            , StringUtils.defaultString(rs.getString("GUBUN_CODE"  )));
                jso.put("name_code"             , StringUtils.defaultString(rs.getString("NAME_CODE"   )));
                jso.put("bd_start_day"          , StringUtils.defaultString(rs.getString("BD_START_DAY")));
                jso.put("bd_end_day"            , StringUtils.defaultString(rs.getString("BD_END_DAY"  )));
                jso.put("bd_time"               , StringUtils.defaultString(rs.getString("BD_TIME"     )));
                jso.put("bd_place"              , StringUtils.defaultString(rs.getString("BD_PLACE"    )));
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
	public JSONObject view(String s_schedule_no) throws Exception{
        JSONObject jso = new JSONObject();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
	              " SELECT"
	            + "     SCHEDULE_NO ,"
	            + "     BD_NO       ,"
	            + "     GUBUN_CODE  ,"
	            + "     NAME_CODE   ,"
	            + "     BD_START_DAY,"
	            + "     BD_END_DAY  ,"
	            + "     BD_TIME     ,"
	            + "     BD_PLACE     "
	            + " FROM " + TABLE.TBL_DMS_BD_SCHEDULE + " a "
	            + " WHERE SCHEDULE_NO = ?"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());
            int sIdx = 1;
            pstmt.setString(sIdx++, s_schedule_no);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                jso.put("schedule_no"           , StringUtils.defaultString(rs.getString("SCHEDULE_NO" )));
                jso.put("bd_no"                 , StringUtils.defaultString(rs.getString("BD_NO"       )));
                jso.put("gubun_code"            , StringUtils.defaultString(rs.getString("GUBUN_CODE"  )));
                jso.put("name_code"             , StringUtils.defaultString(rs.getString("NAME_CODE"   )));
                jso.put("bd_start_day"          , StringUtils.defaultString(rs.getString("BD_START_DAY")));
                jso.put("bd_end_day"            , StringUtils.defaultString(rs.getString("BD_END_DAY"  )));
                jso.put("bd_time"               , StringUtils.defaultString(rs.getString("BD_TIME"     )));
                jso.put("bd_place"              , StringUtils.defaultString(rs.getString("BD_PLACE"    )));
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
	 * 최대 회차 + 1 - 조회 
	 * @return JSONObject
	 * @throws Exception
	 */
	public int getMaxBdNo(String gubun_code, String name_code) throws Exception{
		int maxBdNo = 0;
		try {
			StringBuffer sql = new StringBuffer();
			sql.append(
					" SELECT"
							+ " NVL(MAX(BD_NO),0) + 1 BD_NO"
							+ " FROM " + TABLE.TBL_DMS_BD_SCHEDULE + " a "
							+ " WHERE GUBUN_CODE = ?"
							+ " AND   NAME_CODE  = ?"
					);
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());
			int sIdx = 1;
			pstmt.setString(sIdx++, gubun_code);
			pstmt.setString(sIdx++, name_code );
			rs  = pstmt.executeQuery();
			while ( rs.next() ) {
				maxBdNo = Integer.parseInt(StringUtils.defaultString(rs.getString("BD_NO")));
			}
		} catch ( SQLException e) {
			Log.error("보기 - Error : " + e.toString());
			e.printStackTrace();
		} finally {
			releaseResource();
		}
		return maxBdNo;
	}
	
	/**
	 * insert
	 * @return boolean
	 * @throws Exception
	 */
	public boolean insert(JSONObject vo) throws Exception {
		try {
			 if ( 
				vo.get("GUBUN_CODE") == null ||
				vo.get("BD_PLACE"  ) == null
			    ) throw new Exception("정보가 부족합니다.");
			 
			StringBuffer sql = new StringBuffer();
            sql.append("INSERT INTO " + TABLE.TBL_DMS_BD_SCHEDULE + "("
                    + "     SCHEDULE_NO ,"
                    + "     BD_NO       ,"
                    + "     GUBUN_CODE  ,"
                    + "     NAME_CODE   ,"
                    + "     BD_START_DAY,"
                    + "     BD_END_DAY  ,"
                    + "     BD_TIME     ,"
                    + "     BD_PLACE     "
                    + " ) "
                    + " VALUES "
                    + " ( "
                    + "     " + TABLE.TBL_DMS_BD_SCHEDULE + "_SEQ.NEXTVAL,"
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
            
            pstmt.setInt   (sIdx++, (Integer) vo.get("BD_NO"         ));
            pstmt.setString(sIdx++, (String) vo.get("GUBUN_CODE"    ));
            pstmt.setString(sIdx++, (String) vo.get("NAME_CODE"     ));
            pstmt.setString(sIdx++, (String) vo.get("BD_START_DAY"  ));
            pstmt.setString(sIdx++, (String) vo.get("BD_END_DAY"    ));
            pstmt.setString(sIdx++, (String) vo.get("BD_TIME"       ));
            pstmt.setString(sIdx++, (String) vo.get("BD_PLACE"      ));
            
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
                vo.get("GUBUN_CODE")  == null ||
                vo.get("BD_PLACE"  ) == null
                ) throw new Exception("정보가 부족합니다.");
             
            StringBuffer sql = new StringBuffer();
            sql.append("UPDATE " + TABLE.TBL_DMS_BD_SCHEDULE + " SET"
                    + "     GUBUN_CODE  = ?,"
                    + "     NAME_CODE   = ?,"
                    + "     BD_START_DAY= ?,"
                    + "     BD_END_DAY  = ?,"
                    + "     BD_TIME     = ?,"
                    + "     BD_PLACE    = ? "
                    + " WHERE SCHEDULE_NO = ?"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());            
            Log.debug(sql.toString());
            int sIdx = 1;
            
            pstmt.setString(sIdx++, (String) vo.get("GUBUN_CODE"    ));
            pstmt.setString(sIdx++, (String) vo.get("NAME_CODE"     ));
            pstmt.setString(sIdx++, (String) vo.get("BD_START_DAY"  ));
            pstmt.setString(sIdx++, (String) vo.get("BD_END_DAY"    ));
            pstmt.setString(sIdx++, (String) vo.get("BD_TIME"       ));
            pstmt.setString(sIdx++, (String) vo.get("BD_PLACE"      ));
            pstmt.setString(sIdx++, (String) vo.get("SCHEDULE_NO"   ));
            
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
            sql.append("DELETE FROM " + TABLE.TBL_DMS_BD_SCHEDULE + " "
                    + " WHERE SCHEDULE_NO = ?"
            );
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());            
			Log.debug(sql.toString());
            int sIdx = 1;
            pstmt.setInt   (sIdx++, (Integer) vo.get("SCHEDULE_NO"));            
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
}