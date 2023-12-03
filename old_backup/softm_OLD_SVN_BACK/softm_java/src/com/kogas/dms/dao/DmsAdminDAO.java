package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.*;

public class DmsAdminDAO extends BaseDAO {

	public DmsAdminDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	public JSONArray popup_list(String s_mode, String s_context) throws Exception {
		JSONArray jsa = new JSONArray();  
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT TRIM(T1.PERNR)         EMP_NO                                                 ").append("\n");
		sql.append("      , TRIM(T1.ENAME)         EMP_NM                                                 ").append("\n");
		sql.append("      , TRIM(T1.PLACE)         POS_CD                                                 ").append("\n");
		sql.append("      , TRIM(T1.PLACETX)       POS_NM  --직위(차장)                                   ").append("\n");
		sql.append("      , TRIM(T1.LRPOS)         RNK_CD                                                 ").append("\n");
		sql.append("      , TRIM(T1.LRPOSTX)       RNK_NM  --직급(1급)                                    ").append("\n");
		sql.append("      , TRIM(T2.OBJID)         DEP_CD                                                 ").append("\n");
		sql.append("      , TRIM(T2.STEXT)         DEP_NM  --부서(통영기지본부 토건팀)                    ").append("\n");
		sql.append("   FROM ZHR0010S T1                                                                   ").append("\n");
		sql.append("      , ZHR0020S T2,                                                                  ").append("\n");
		sql.append("      DMS_ADMIN T3                                                                    ").append("\n");
		sql.append("  WHERE 1 = 1                                                                         ").append("\n");
		sql.append("    AND T1.ORGEH = T2.OBJID                                                           ").append("\n");
		sql.append("    AND T1.ZDATE = (SELECT MAX(ZDATE) FROM ZHR0010S WHERE PERNR = T1.PERNR)           ").append("\n");
		sql.append("    AND T2.ZDATE = (SELECT MAX(ZDATE) FROM ZHR0020S WHERE OBJID = T2.OBJID)           ").append("\n");
		sql.append("    AND T1.I_EAI_DATE = (SELECT MAX(I_EAI_DATE) FROM ZHR0010S WHERE PERNR = T1.PERNR) ").append("\n");
		sql.append("    AND T2.I_EAI_DATE = (SELECT MAX(I_EAI_DATE) FROM ZHR0020S WHERE OBJID = T2.OBJID) ").append("\n");
		sql.append("    AND T3.EMP_NO = TRIM(T1.PERNR)                                                    ").append("\n");
		if(s_mode.equals("EMP_NM")) sql.append(" WHERE TRIM(T1.ENAME) LIKE '%"+s_context+"%'");
		if(s_mode.equals("DEP_NM")) sql.append(" WHERE TRIM(T2.STEXT) LIKE '%"+s_context+"%'");
		sql.append(" ORDER BY EMP_NM ").append("\n");
		
		Log.debug(sql.toString());
		Log.debug("s_mode : " + s_mode);
		Log.debug("s_context : " + s_context);
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("emp_no", StringUtils.defaultString(rs.getString("EMP_NO")));
				jso.put("emp_nm", StringUtils.defaultString(rs.getString("EMP_NM")));
				jso.put("pos_cd", StringUtils.defaultString(rs.getString("POS_CD")));
				jso.put("pos_nm", StringUtils.defaultString(rs.getString("POS_NM")));
				jso.put("rnk_cd", StringUtils.defaultString(rs.getString("RNK_CD")));
				jso.put("rnk_nm", StringUtils.defaultString(rs.getString("RNK_NM")));
				jso.put("dep_cd", StringUtils.defaultString(rs.getString("DEP_CD")));
				jso.put("dep_nm", StringUtils.defaultString(rs.getString("DEP_NM"))); 
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