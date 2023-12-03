package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;

public class DmsMemberCareerDAO extends BaseDAO {

	public DmsMemberCareerDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	protected Logger Log = Util.logger; 

	public JSONArray getList(int member_no) throws Exception {
		JSONArray jsr = new JSONArray();
		StringBuffer sql = new StringBuffer();
		
		sql.append(" SELECT MEMBER_NO ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("       ,DISPLAY_YN ").append("\n");
		sql.append("       ,JOB_START ").append("\n");
		sql.append("       ,JOB_END ").append("\n");
		sql.append("       ,JOB_NAME ").append("\n");
		sql.append("       ,DEPT_NAME ").append("\n");
		sql.append("       ,POSITION ").append("\n");
		sql.append("  FROM DMS_MEMBER_CAREER ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		sql.append("   AND DISPLAY_YN = 'Y' ").append("\n");
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
				jso.put("display_yn", StringUtils.defaultString(rs.getString("DISPLAY_YN")));
				jso.put("job_start", StringUtils.defaultString(rs.getString("JOB_START")));
				jso.put("job_end", StringUtils.defaultString(rs.getString("JOB_END")));
				jso.put("job_name", StringUtils.defaultString(rs.getString("JOB_NAME")));
				jso.put("dept_name", StringUtils.defaultString(rs.getString("DEPT_NAME")));
				jso.put("position", StringUtils.defaultString(rs.getString("POSITION")));
				jsr.put(jso);
			}
			
			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberCareerList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return null;
	}


	public boolean insertMemberCareer(int member_no, JSONArray jsa) {
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_MEMBER_CAREER(").append("\n");
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
				pstmt.setInt(2,seq);
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

		sql.append(" DELETE FROM DMS_MEMBER_CAREER ").append("\n");
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