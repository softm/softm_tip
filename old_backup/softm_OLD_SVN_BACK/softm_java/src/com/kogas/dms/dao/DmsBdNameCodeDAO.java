package com.kogas.dms.dao;

import java.sql.SQLException;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.var.TABLE;

public class DmsBdNameCodeDAO extends BaseDAO{

	public DmsBdNameCodeDAO() throws Exception {
		super();
	}
	/**
	 * listCode
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONObject listCode(String gubunCode) throws Exception{
        JSONObject jso = new JSONObject();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
  	              " SELECT"
  	            + "     NAME_CODE  ,"
  	            + "     CODE_NAME   "
  	            + " FROM " + TABLE.TBL_DMS_BD_NAME_CODE + " a "
  	            + (!gubunCode.equals("ALL")?" WHERE GUBUN_CODE IN (" + gubunCode + ")":"")
//  	            + (s_year.equals("") || s_month.equals("") ?"":" AND BD_START_DAY = '" + s_year + "'")
//  	            + " WHERE SUBSTR(BD_START_DAY,1,6) = ?"
  	            + " ORDER BY NAME_CODE"
              );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            int sIdx = 1;
//            if ( !gubunCode.equals("ALL") ) pstmt.setArray(sIdx++, gubunCode);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
				jso.put(StringUtils.defaultString(rs.getString("NAME_CODE")),StringUtils.defaultString(rs.getString("CODE_NAME"    )));
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
	public JSONArray list(String gubunCode) throws Exception{
        JSONArray jsa = new JSONArray();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
	              " SELECT"
	            + "     NAME_CODE  ,"
	            + "     CODE_NAME   "
	            + " FROM " + TABLE.TBL_DMS_BD_NAME_CODE + " a "
	            + " WHERE GUBUN_CODE = '" +gubunCode+ "'"
//	            + (s_year.equals("") || s_month.equals("") ?"":" AND BD_START_DAY = '" + s_year + "'")
//	            + " WHERE SUBSTR(BD_START_DAY,1,6) = ?"
	            + " ORDER BY NAME_CODE"
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