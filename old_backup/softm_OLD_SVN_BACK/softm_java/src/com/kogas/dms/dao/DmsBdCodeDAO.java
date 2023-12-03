package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.*;

public class DmsBdCodeDAO extends BaseDAO {

	public DmsBdCodeDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	/**
	 * 이사회코드정보 리스트 
	 * @return
	 * @throws Exception
	 */
	public JSONObject codeList() throws Exception {
		JSONObject jso = new JSONObject();   
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT BD_CODE,BD_NAME ").append("\n");
		sql.append("   FROM DMS_BD_CODE ").append("\n");
		sql.append(" ORDER BY BD_CODE ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				jso.put(StringUtils.defaultString(rs.getString("BD_CODE")),StringUtils.defaultString(rs.getString("BD_NAME")));
			}

		} catch(Exception ex) {
			System.out.println("getBdCodeList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return jso;
	}
}