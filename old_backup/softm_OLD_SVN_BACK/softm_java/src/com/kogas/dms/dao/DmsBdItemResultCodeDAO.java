package com.kogas.dms.dao;

import java.sql.SQLException;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.var.TABLE;

public class DmsBdItemResultCodeDAO extends BaseDAO{

	public DmsBdItemResultCodeDAO() throws Exception {
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
  	            + "     CODE  ,"
  	            + "     CODE_NAME  ,"
  	            + "     CODE_CONTEXT   "
  	            + " FROM " + TABLE.TBL_DMS_BD_ITEM_RESULT_CODE + " a "
  	            + " ORDER BY CODE"
              );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            int sIdx = 1;
//            if ( !gubunCode.equals("ALL") ) pstmt.setArray(sIdx++, gubunCode);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
				jso.put(StringUtils.defaultString(rs.getString("CODE")),StringUtils.defaultString(rs.getString("CODE_NAME"    )));
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
  	            + "     CODE  ,"
  	            + "     CODE_NAME  ,"
  	            + "     CODE_CONTEXT   "
  	            + " FROM " + TABLE.TBL_DMS_BD_ITEM_RESULT_CODE + " a "
  	            + " ORDER BY CODE"	            
            );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
//            int sIdx = 1;
//            pstmt.setString(sIdx++, s_year + s_month);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
                JSONObject jso = new JSONObject();
                jso.put("name_code" , StringUtils.defaultString(rs.getString("NAME_CODE" )));
                jso.put("code_name" , StringUtils.defaultString(rs.getString("CODE_NAME" )));
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