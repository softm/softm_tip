package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.*;

public class DmsIfMeasureDAO extends BaseDAO {

	public DmsIfMeasureDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	public JSONArray list(String s_mode, String s_context) throws Exception {
		JSONArray jsa = new JSONArray();  
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT FIELD_CD,      ").append("\n");
		sql.append("        FIELD_NAME,    ").append("\n");
		sql.append("	    SECTION_CD,    ").append("\n");
		sql.append("	    SECTION_NAME,  ").append("\n");
		sql.append("	    PROGRAM_CD,    ").append("\n");
		sql.append("	    PROGRAM_NAME,  ").append("\n");
		sql.append("	    BUSINESS_CD,   ").append("\n");
		sql.append("	    BUSINESS_NAME, ").append("\n");
		sql.append("	    MEASURE_CD,    ").append("\n");
		sql.append("	    MEASURE_NAME   ").append("\n");
		sql.append("   FROM DMS_IF_MEASURE ").append("\n");
		if(s_mode.equals("CONTEXT")) sql.append(" WHERE MEASURE_NAME LIKE '%"+s_context+"%'");
		sql.append("ORDER BY FIELD_CD ").append("\n");
		
		Log.debug(sql.toString());
		Log.debug("s_mode : " + s_mode);
		Log.debug("s_context : " + s_context);
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("field_cd", StringUtils.defaultString(rs.getString("FIELD_CD")));
				jso.put("field_name", StringUtils.defaultString(rs.getString("FIELD_NAME")));
				jso.put("section_cd", StringUtils.defaultString(rs.getString("SECTION_CD")));
				jso.put("section_name", StringUtils.defaultString(rs.getString("SECTION_NAME")));
				jso.put("program_cd", StringUtils.defaultString(rs.getString("PROGRAM_CD")));
				jso.put("program_name", StringUtils.defaultString(rs.getString("PROGRAM_NAME")));
				jso.put("business_cd", StringUtils.defaultString(rs.getString("BUSINESS_CD")));
				jso.put("business_name", StringUtils.defaultString(rs.getString("BUSINESS_NAME")));
				jso.put("measure_cd", StringUtils.defaultString(rs.getString("MEASURE_CD")));
				jso.put("measure_name", StringUtils.defaultString(rs.getString("MEASURE_NAME")));
				jsa.put(jso);
			}
			return jsa;
		} catch(Exception ex) {
			System.out.println("list 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return null;
	}
}