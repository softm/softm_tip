package com.kogas.dms.dao_basic;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.dao.BaseDAO;
import com.kogas.dms.var.TABLE;

public class DmsCommonDAO extends BaseDAO {
	public DmsCommonDAO() throws Exception {
		super();
	}

	/**
	 * 보드코드 타입
	 * @param conn
	 * @param type
	 * @return JSONObject
	 * @throws Exception
	 */
	public JSONObject getBoardCode(String type)
	throws Exception{
        JSONObject jso = new JSONObject();     
        try {    	
            StringBuffer sql = new StringBuffer();
	        sql.setLength(0);
	        sql.append(" SELECT ")
	           .append(" CODE        , ")
	           .append(" CODE_NAME   , ")
	           .append(" CODE_CONTEXT, ")
	           .append(" BOARD_TYPE  ")
	           .append(" FROM " + TABLE.TBL_DMS_BOARD_CODE)
	           .append(type!=null&&!type.equals("")?" WHERE BOARD_TYPE = '" +type+ "'":"")
	        ;
//	    	PreparedStatement pstmt = null;
	        stmt = DBUtil.getConnection().createStatement();
	        rs  = stmt.executeQuery( sql.toString() );
	        while ( rs.next() ) {
                jso.put(StringUtils.defaultString(rs.getString("CODE")),StringUtils.defaultString(rs.getString("CODE_NAME"    )));
	        }
        } catch ( SQLException e) {
            throw new SQLException(e.getMessage());
        } finally {
        	releaseResource();
        }
        return jso;        
    }	
}