package com.kogas.dms.dao_basic;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Sql;
import com.kogas.dms.common.Util;

public class DmsBdAttendMemberDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBdAttendMemberList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT SCHEDULE_NO ").append("\n");
		sql.append("       ,MEMBER_NO2 ").append("\n");
		sql.append("       ,ATTEND_YN ").append("\n");
		sql.append("       ,COMMENT_NUMBER ").append("\n");
		sql.append("  FROM DMS_BD_ATTEND_MEMBER ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("schedule_no", StringUtils.defaultString(rs.getString("SCHEDULE_NO")));
				jso.put("member_no2", StringUtils.defaultString(rs.getString("MEMBER_NO2")));
				jso.put("attend_yn", StringUtils.defaultString(rs.getString("ATTEND_YN")));
				jso.put("comment_number", StringUtils.defaultString(rs.getString("COMMENT_NUMBER")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdAttendMemberList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBdAttendMemberDetail(int schedule_no, String member_no2) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT SCHEDULE_NO ").append("\n");
		sql.append("       ,MEMBER_NO2 ").append("\n");
		sql.append("       ,ATTEND_YN ").append("\n");
		sql.append("       ,COMMENT_NUMBER ").append("\n");
		sql.append("  FROM DMS_BD_ATTEND_MEMBER ").append("\n");
		sql.append(" WHERE SCHEDULE_NO = ? ").append("\n");
		sql.append("   AND MEMBER_NO2 = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,schedule_no);
//			pstmt.setInt(2,member_no2);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("schedule_no", StringUtils.defaultString(rs.getString("SCHEDULE_NO")));
				jso.put("member_no2", StringUtils.defaultString(rs.getString("MEMBER_NO2")));
				jso.put("attend_yn", StringUtils.defaultString(rs.getString("ATTEND_YN")));
				jso.put("comment_number", StringUtils.defaultString(rs.getString("COMMENT_NUMBER")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdAttendMemberDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBdAttendMember(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BD_ATTEND_MEMBER(").append("\n");
		sql.append("        SCHEDULE_NO ").append("\n");
		sql.append("       ,MEMBER_NO2 ").append("\n");
		sql.append("       ,ATTEND_YN ").append("\n");
		sql.append("       ,COMMENT_NUMBER ").append("\n");
		sql.append(" )  ").append("\n");
		sql.append(" VALUES (").append("\n");
		sql.append("         ? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append(" );  ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,jso.getInt("schedule_no"));
			pstmt.setInt(2,jso.getInt("member_no2"));
			pstmt.setString(3,jso.getString("attend_yn"));
			pstmt.setInt(4,jso.getInt("comment_number"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBdAttendMember 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBdAttendMemberUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BD_ATTEND_MEMBER SET ").append("\n");
		sql.append("        ATTEND_YN = ? ").append("\n");
		sql.append("       ,COMMENT_NUMBER = ? ").append("\n");
		sql.append(" WHERE SCHEDULE_NO = ? ").append("\n");
		sql.append("   AND MEMBER_NO2 = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("attend_yn"));
			pstmt.setInt(2,jso.getInt("comment_number"));
			pstmt.setInt(3,jso.getInt("schedule_no"));
			pstmt.setInt(4,jso.getInt("member_no2"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBdAttendMemberUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBdAttendMember(int schedule_no, String member_no2) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BD_ATTEND_MEMBER ").append("\n");
		sql.append(" WHERE SCHEDULE_NO = ? ").append("\n");
		sql.append("   AND MEMBER_NO2 = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,schedule_no);
//			pstmt.setInt(2,member_no2);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBdAttendMember 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}