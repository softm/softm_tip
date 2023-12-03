package com.kogas.dms.dao;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
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
	public static JSONObject getBoardCode( String type)
	throws Exception{
        JSONObject jso = new JSONObject();     
//    	PreparedStatement pstmt = null;
    	Statement stmt = null;
    	ResultSet rs   = null;
    	
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
	        stmt = DBUtil.getConnection().createStatement();
	        rs  = stmt.executeQuery( sql.toString() );
	        while ( rs.next() ) {
                jso.put(StringUtils.defaultString(rs.getString("CODE")),StringUtils.defaultString(rs.getString("CODE_NAME"    )));
	        }
        } catch ( SQLException e) {
            throw new SQLException(e.getMessage());
        } finally {
            if ( rs   != null ) { rs.close();   }   // ResultSet의  소멸
            if ( stmt != null ) { stmt.close(); }   // Statement의  소멸        	
        }
        return jso;        
    }	
}