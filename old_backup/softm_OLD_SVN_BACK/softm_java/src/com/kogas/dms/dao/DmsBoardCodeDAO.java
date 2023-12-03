package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.*;

public class DmsBoardCodeDAO extends BaseDAO {

	public DmsBoardCodeDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	public JSONObject getBoardCodeList(String board_type) throws Exception {
		JSONObject jso = new JSONObject();   
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT CODE ").append("\n");
		sql.append("       ,CODE_NAME ").append("\n");
		sql.append("       ,CODE_CONTEXT ").append("\n");
		sql.append("  FROM DMS_BOARD_CODE ").append("\n");
		sql.append(" WHERE BOARD_TYPE = ? ").append("\n");
		sql.append(" ORDER BY CODE ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setString(1, board_type);
			rs = pstmt.executeQuery();

			while(rs.next()){
				jso.put(StringUtils.defaultString(rs.getString("CODE")),StringUtils.defaultString(rs.getString("CODE_NAME"    )));
			}

		} catch(Exception ex) {
			System.out.println("getBoardCodeList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return jso;
	}

}