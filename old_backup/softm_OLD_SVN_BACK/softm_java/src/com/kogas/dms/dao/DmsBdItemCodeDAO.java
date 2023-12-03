package com.kogas.dms.dao;

import java.sql.SQLException;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.var.TABLE;


/**
 * @author softmind
 * 안건코드
 */
public class DmsBdItemCodeDAO extends BaseDAO{

	public DmsBdItemCodeDAO() throws Exception {
		super();
	}
	/**
	 * listCode
	 * @return JSONArray
	 * @throws Exception
	 */
	public JSONObject listCode(String itemClass) throws Exception{
        JSONObject jso = new JSONObject();
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
  	              " SELECT"
  	            + "     ITEM_CODE   ,"
  	            + "     ITEM_CLASS  ,"
  	            + "     ITEM_CODE_NAME   "
  	            + " FROM " + TABLE.TBL_DMS_BD_ITEM_CODE + " a "
  	            + (!itemClass.equals("ALL")?" WHERE ITEM_CLASS IN (" + itemClass + ")":"")
//  	            + (s_year.equals("") || s_month.equals("") ?"":" AND BD_START_DAY = '" + s_year + "'")
//  	            + " WHERE SUBSTR(BD_START_DAY,1,6) = ?"
  	            + " ORDER BY ITEM_CODE"
              );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
            int sIdx = 1;
//            if ( !gubunCode.equals("ALL") ) pstmt.setArray(sIdx++, gubunCode);
            rs  = pstmt.executeQuery();
            while ( rs.next() ) {
				jso.put(StringUtils.defaultString(rs.getString("ITEM_CODE")),StringUtils.defaultString(rs.getString("ITEM_CODE_NAME"    )));
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
	
	
	/**
	 * listCode
	 * @return JSONArray
	 * @throws Exception
	 */
	public String getName(String itemClass,String itemCode) throws Exception{
        String rtn = "";
        try {
            StringBuffer sql = new StringBuffer();
            sql.append(
  	              " SELECT"
  	            + "     ITEM_CODE   ,"
  	            + "     ITEM_CLASS  ,"
  	            + "     ITEM_CODE_NAME   "
  	            + " FROM " + TABLE.TBL_DMS_BD_ITEM_CODE + " a "
  	            + " WHERE ITEM_CLASS = '" + itemClass + "'"
  	            + " AND   ITEM_CODE  = '" + itemCode + "'"
  	            + " ORDER BY ITEM_CODE"
              );
            pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			Log.debug(sql.toString());            
//            int sIdx = 1;
//            if ( !gubunCode.equals("ALL") ) pstmt.setArray(sIdx++, gubunCode);
            rs  = pstmt.executeQuery();
            if ( rs.next() ) {
				rtn = StringUtils.defaultString(rs.getString("ITEM_CODE_NAME"));
            }
        } catch ( SQLException e) {
			 Log.error("조회 - Error : " + e.toString());
   			 e.printStackTrace();
        } finally {
        	releaseResource();
        }
        return rtn;
    }
}