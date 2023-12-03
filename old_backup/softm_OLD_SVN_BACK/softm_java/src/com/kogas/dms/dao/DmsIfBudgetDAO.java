package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.*;

public class DmsIfBudgetDAO extends BaseDAO {

	public DmsIfBudgetDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	public JSONArray list(String s_mode, String s_context) throws Exception {
		JSONArray jsa = new JSONArray();  
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT BUDGET_CD,BUDGET_NAME ").append("\n");
		sql.append("   FROM DMS_IF_BUDGET ").append("\n");
		if(s_mode.equals("")) sql.append(" WHERE BUDGET_CD LIKE '%"+s_context+"%' OR BUDGET_NAME LIKE '%"+s_context+"%'");
		if(s_mode.equals("CODE")) sql.append(" WHERE BUDGET_CD LIKE '%"+s_context+"%'");
		if(s_mode.equals("CONTEXT")) sql.append(" WHERE BUDGET_NAME LIKE '%"+s_context+"%'");
		sql.append(" ORDER BY BUDGET_CD ").append("\n");
		
		Log.debug(sql.toString());
		Log.debug("s_mode : " + s_mode);
		Log.debug("s_context : " + s_context);
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("budget_cd", StringUtils.defaultString(rs.getString("BUDGET_CD")));
				jso.put("budget_name", StringUtils.defaultString(rs.getString("BUDGET_NAME")));
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