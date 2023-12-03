package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.*;

public class DmsBdSchoolCodeDAO extends BaseDAO {

	public DmsBdSchoolCodeDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	public JSONObject codeList() throws Exception {
		JSONObject jso = new JSONObject();   
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT SCHOOL_CODE,SCHOOL_CODE_NAME ").append("\n");
		sql.append("   FROM DMS_BD_SCHOOL_CODE ").append("\n");
		sql.append(" ORDER BY SCHOOL_CODE ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				jso.put(StringUtils.defaultString(rs.getString("SCHOOL_CODE")),StringUtils.defaultString(rs.getString("SCHOOL_CODE_NAME")));
			}

		} catch(Exception ex) {
			System.out.println("getBdCodeList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return jso;
	}
	
	public JSONArray schoolCodeList() throws Exception {
		JSONArray jsr = new JSONArray();   
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT SCHOOL_CODE,SCHOOL_CODE_NAME ").append("\n");
		sql.append("   FROM DMS_BD_SCHOOL_CODE ").append("\n");
		sql.append(" ORDER BY SCHOOL_CODE ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("school_code", StringUtils.defaultString(rs.getString("SCHOOL_CODE")));
				jso.put("school_code_name", StringUtils.defaultString(rs.getString("SCHOOL_CODE_NAME")));
				jsr.put(jso);
			}
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdCodeList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return jsr;
	}
}