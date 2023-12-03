package com.kogas.dms.dao;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;

public class DmsMemberAcademicDAO extends BaseDAO {

	public DmsMemberAcademicDAO() throws Exception {
		super();
		// TODO Auto-generated constructor stub
	}

	protected Logger Log = Util.logger; 

	public JSONArray getList(int member_no) throws Exception {
		JSONArray jsr = new JSONArray();
		StringBuffer sql = new StringBuffer();
		
		sql.append(" SELECT SEQ ").append("\n");
		sql.append("       ,SCHOOL_CODE ").append("\n");
		sql.append("       ,DISPLAY_YN ").append("\n");
		sql.append("       ,TO_CHAR(TO_DATE(SCHOOL_START,'YYYYMMDD'),'YYYY-MM') SCHOOL_START").append("\n");
		sql.append("       ,TO_CHAR(TO_DATE(SCHOOL_END,'YYYYMMDD'),'YYYY-MM') SCHOOL_END ").append("\n");
		sql.append("       ,SCHOOL_NAME ").append("\n");
		sql.append("       ,SCHOOL_DEPARTMENT ").append("\n");
		sql.append("       ,SCHOOL_LOCATION ").append("\n");
		sql.append("  FROM DMS_MEMBER_ACADEMIC ").append("\n");
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
				jso.put("seq", StringUtils.defaultString(rs.getString("SEQ")));
				jso.put("school_code", StringUtils.defaultString(rs.getString("SCHOOL_CODE")));
				jso.put("display_yn", StringUtils.defaultString(rs.getString("DISPLAY_YN")));
				jso.put("school_start", StringUtils.defaultString(rs.getString("SCHOOL_START")));
				jso.put("school_end", StringUtils.defaultString(rs.getString("SCHOOL_END")));
				jso.put("school_name", StringUtils.defaultString(rs.getString("SCHOOL_NAME")));
				jso.put("school_department", StringUtils.defaultString(rs.getString("SCHOOL_DEPARTMENT")));
				jso.put("school_location", StringUtils.defaultString(rs.getString("SCHOOL_LOCATION")));
				jsr.put(jso);
			}
			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberAcademicList 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return null;
	}


	public boolean insertMemberAcademic(int member_no, JSONArray jsa) {
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_MEMBER_ACADEMIC(").append("\n");
		sql.append("        MEMBER_NO ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("       ,SCHOOL_CODE ").append("\n");
		sql.append("       ,DISPLAY_YN ").append("\n");
		sql.append("       ,SCHOOL_START ").append("\n");
		sql.append("       ,SCHOOL_END ").append("\n");
		sql.append("       ,SCHOOL_NAME ").append("\n");
		sql.append("       ,SCHOOL_DEPARTMENT ").append("\n");
		sql.append("       ,SCHOOL_LOCATION ").append("\n");
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
				pstmt.setString(3,jso.getString("school_code"));
				pstmt.setString(4,jso.getString("display_yn"));
				pstmt.setString(5,jso.getString("school_start"));
				pstmt.setString(6,jso.getString("school_end"));
				pstmt.setString(7,jso.getString("school_name"));
				pstmt.setString(8,jso.getString("school_department"));
				pstmt.setString(9,jso.getString("school_location"));
				result = pstmt.executeUpdate();
			}
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertMemberAcademic 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}


	/**
	 * 학력사항 삭제
	 * @param member_no
	 * @return
	 */
	public boolean deleteMemberAcademic(int member_no) {
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_MEMBER_ACADEMIC ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		try {
			pstmt = DBUtil.getConnection().prepareStatement(sql.toString());
			pstmt.setInt(1,member_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;
			return true;
		} catch(Exception ex) {
			System.out.println("deleteMemberAcademic 에러 : " + ex);
		} finally {
			releaseResource();
		}

		return false;
	}


}