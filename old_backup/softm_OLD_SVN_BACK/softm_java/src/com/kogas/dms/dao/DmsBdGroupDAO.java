package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.*;

public class DmsBdGroupDAO extends BaseDAO {

	public DmsBdGroupDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	/**
	 * 이사회조직코드 리스트 
	 * @return
	 * @throws Exception
	 */
	public JSONObject codeList() throws Exception {
		JSONObject jso = new JSONObject();   
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT GROUP_NO,GROUP_NM ").append("\n");
		sql.append("   FROM DMS_BD_GROUP ").append("\n");
		sql.append(" ORDER BY GROUP_NO ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				jso.put(StringUtils.defaultString(rs.getString("GROUP_NO")),StringUtils.defaultString(rs.getString("GROUP_NM")));
			}

		} catch(Exception ex) {
			System.out.println("getBdCodeList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return jso;
	}
	
	public JSONArray list() throws Exception {
		JSONArray jsr = new JSONArray();   
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT GROUP_NO ").append("\n");
		sql.append("       ,GROUP_NM ").append("\n");
		sql.append("       ,GROUP_MEMBER ").append("\n");
		sql.append("       ,MAJOR_FUNCTION ").append("\n");
		sql.append("   FROM DMS_BD_GROUP ").append("\n");
		sql.append(" ORDER BY GROUP_NO ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("group_no", StringUtils.defaultString(rs.getString("GROUP_NO")));
				jso.put("group_nm", StringUtils.defaultString(rs.getString("GROUP_NM")));
				jso.put("group_member", StringUtils.defaultString(rs.getString("GROUP_MEMBER")));
				jso.put("major_function", StringUtils.defaultString(rs.getString("MAJOR_FUNCTION")));
				jsr.put(jso);
			}

		} catch(Exception ex) {
			System.out.println("getBdCodeList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return jsr;
	}
}