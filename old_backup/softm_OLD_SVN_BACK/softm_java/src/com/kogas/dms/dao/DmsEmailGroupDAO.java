package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.*;

public class DmsEmailGroupDAO extends BaseDAO {

	public DmsEmailGroupDAO() throws Exception {
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

		sql.append(" SELECT EMAIL_CODE,DOMAIN_NAME ").append("\n");
		sql.append("   FROM DMS_EMAIL_GROUP ").append("\n");
		sql.append(" ORDER BY EMAIL_CODE ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				jso.put(StringUtils.defaultString(rs.getString("EMAIL_CODE")),StringUtils.defaultString(rs.getString("DOMAIN_NAME")));
			}

		} catch(Exception ex) {
			System.out.println("getBdCodeList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return jso;
	}
}