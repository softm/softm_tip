package com.kogas.dms.dao;

import java.sql.SQLException;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.var.TABLE;

public class DmsBdGubunCodeDAO extends BaseDAO{

	public DmsBdGubunCodeDAO() throws Exception {
		super();
	}

	/**
	 * listCode
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONObject listCode() throws Exception{
        JSONObject jso = new JSONObject();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
	              " SELECT"
	            + "     GUBUN_CODE  ,"
	            + "     GUBUN_NAME   "
	            + " FROM " + TABLE.TBL_DMS_BD_GUBUN_CODE + " a "
//	            + " WHERE 0 = 0"
//	            + (s_year.equals("") || s_month.equals("") ?"":" AND BD_START_DAY = '" + s_year + "'")
//	            + " WHERE SUBSTR(BD_START_DAY,1,6) = ?"
	            + " ORDER BY GUBUN_CODE"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
//            int sIdx = 1;
//            pstmt.setString(sIdx++, s_year + s_month);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
				jso.put(StringUtils.defaultString(rs.getString("GUBUN_CODE")),StringUtils.defaultString(rs.getString("GUBUN_NAME"    )));
            }
        } catch ( SQLException e) {
			 Log.error("조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return jso;
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
	            + "     GUBUN_CODE  ,"
	            + "     GUBUN_NAME   "
	            + " FROM " + TABLE.TBL_DMS_BD_GUBUN_CODE + " a "
//	            + " WHERE 0 = 0"
//	            + (s_year.equals("") || s_month.equals("") ?"":" AND BD_START_DAY = '" + s_year + "'")
//	            + " WHERE SUBSTR(BD_START_DAY,1,6) = ?"
	            + " ORDER BY GUBUN_CODE"
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
//            int sIdx = 1;
//            pstmt.setString(sIdx++, s_year + s_month);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                JSONObject jso = new JSONObject();
                jso.put("gubun_code" , StringUtils.defaultString(rs.getString("GUBUN_CODE" )));
                jso.put("gubun_name" , StringUtils.defaultString(rs.getString("GUBUN_NAME" )));
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
}