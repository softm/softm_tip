package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;

public class DmsMemberRewardDAO extends BaseDAO {

	public DmsMemberRewardDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	protected Logger Log = Util.logger; 

	public JSONArray getList(int member_no) throws Exception {
		JSONArray jsr = new JSONArray();
		StringBuffer sql = new StringBuffer();
		
		sql.append(" SELECT MEMBER_NO ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("       ,TO_CHAR(TO_DATE(REWARD_DATE,'YYYYMMDD'),'YYYY-MM-DD') REWARD_DATE").append("\n");
		sql.append("       ,REWARD_CONTEXT ").append("\n");
		sql.append("       ,REWARD_ORGAN ").append("\n");
		sql.append("       ,REWARD_DIVISION ").append("\n");
		sql.append("  FROM DMS_MEMBER_REWARD ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		sql.append(" ORDER BY SEQ ").append("\n");
		Log.debug(sql.toString());
		
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1, member_no);
			rs = pstmt.executeQuery();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jso.put("seq", StringUtils.defaultString(rs.getString("SEQ")));
				jso.put("reward_date", StringUtils.defaultString(rs.getString("REWARD_DATE")));
				jso.put("reward_context", StringUtils.defaultString(rs.getString("REWARD_CONTEXT")));
				jso.put("reward_organ", StringUtils.defaultString(rs.getString("REWARD_ORGAN")));
				jso.put("reward_division", StringUtils.defaultString(rs.getString("REWARD_DIVISION")));
				jsr.put(jso);
			}
			
			return jsr;
		} catch(Exception ex) {
			System.out.println("getList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return null;
	}



	public boolean insertMemberCareer(int member_no, JSONArray jsa) {
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_MEMBER_REWARD(").append("\n");
		sql.append("        MEMBER_NO ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("       ,DISPLAY_YN ").append("\n");
		sql.append("       ,JOB_START ").append("\n");
		sql.append("       ,JOB_END ").append("\n");
		sql.append("       ,JOB_NAME ").append("\n");
		sql.append("       ,DEPT_NAME ").append("\n");
		sql.append("       ,POSITION ").append("\n");
		sql.append(" )  ").append("\n");
		sql.append(" VALUES (").append("\n");
		sql.append("         ? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append(" );  ").append("\n");

		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			int seq = 0;
			for(int i=0; i<jsa.length();i++) {
				seq++;
				JSONObject jso = jsa.getJSONObject(i);
				pstmt.setInt(1,jso.getInt("member_no"));
				pstmt.setInt(2,jso.getInt("seq"));
				pstmt.setString(3,jso.getString("display_yn"));
				pstmt.setString(4,jso.getString("job_start"));
				pstmt.setString(5,jso.getString("job_end"));
				pstmt.setString(6,jso.getString("job_name"));
				pstmt.setString(7,jso.getString("dept_name"));
				pstmt.setString(8,jso.getString("position"));
				result = pstmt.executeUpdate();
			}
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertMemberCareer 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}


	public boolean deleteMemberCareer(int member_no) {
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_MEMBER_REWARD ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1,member_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteMemberCareer 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}


}