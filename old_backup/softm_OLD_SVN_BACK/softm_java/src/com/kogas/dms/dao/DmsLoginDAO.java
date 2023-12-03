package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;

public class DmsLoginDAO extends BaseDAO {

	public DmsLoginDAO() throws Exception {
		super();
	}

	protected Logger Log = Util.logger; 

	public JSONObject login(String p_user_id) throws Exception {
		JSONObject jsr = new JSONObject();

		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT TRIM(T1.PERNR) EMP_NO ").append("\n");
		sql.append("       ,TRIM(T1.ENAME) EMP_NM ").append("\n");
		sql.append("       ,DECODE(T2.AUTH_DIVIDE,NULL,'',AUTH_DIVIDE) AUTH_DIVIDE ").append("\n");
		sql.append("       ,DECODE(T2.EMP_NO, NULL,'N','Y') ADMIN_YN ").append("\n");
		sql.append("   FROM ZHR0010S T1, ").append("\n");
		sql.append("        DMS_ADMIN T2 ").append("\n");
		sql.append("  WHERE TRIM(T1.PERNR) = T2.EMP_NO(+) ").append("\n");
		sql.append("    AND TRIM(T1.PERNR) = ? ").append("\n");
		
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setString(1, p_user_id);
			rs = pstmt.executeQuery();
			
			if(rs.next()) {
				jsr.put("emp_no", StringUtils.defaultString(rs.getString("EMP_NO")));
				jsr.put("emp_nm", StringUtils.defaultString(rs.getString("EMP_NM")));
				jsr.put("auth_divide", StringUtils.defaultString(rs.getString("AUTH_DIVIDE")));
				jsr.put("admin_yn", StringUtils.defaultString(rs.getString("ADMIN_YN")));
				jsr.put("return" , "200");
	            jsr.put("message" , "사용자 정보 조회 성공."); // error message
			} else {
				jsr.put("emp_no", "");
				jsr.put("emp_nm", "");
				jsr.put("auth_divide", "");
				jsr.put("admin_yn", "");
				jsr.put("return" , "404");
	            jsr.put("message" , "사용자아이디가 없습니다."); // error message
			}
		} catch(Exception ex) {
			jsr.put("return" , "500"); // 실패, 
    		jsr.put("message" , "데이터 조회 실패"); 
		} finally {
			releaseResource();
		}

		return jsr;
	}
}