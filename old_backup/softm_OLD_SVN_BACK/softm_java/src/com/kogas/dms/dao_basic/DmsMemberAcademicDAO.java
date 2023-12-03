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

public class DmsMemberAcademicDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getMemberAcademicList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT MEMBER_NO ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("       ,SCOOL_CODE ").append("\n");
		sql.append("       ,DISPLAY_YN ").append("\n");
		sql.append("       ,SCHOOL_START ").append("\n");
		sql.append("       ,SCHOOL_END ").append("\n");
		sql.append("       ,SCHOOL_NAME ").append("\n");
		sql.append("       ,SCHOOL_DEPARTMENT ").append("\n");
		sql.append("       ,SCHOOL_LOCATION ").append("\n");
		sql.append("  FROM DMS_MEMBER_ACADEMIC ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jso.put("seq", StringUtils.defaultString(rs.getString("SEQ")));
				jso.put("scool_code", StringUtils.defaultString(rs.getString("SCOOL_CODE")));
				jso.put("display_yn", StringUtils.defaultString(rs.getString("DISPLAY_YN")));
				jso.put("school_start", StringUtils.defaultString(rs.getString("SCHOOL_START")));
				jso.put("school_end", StringUtils.defaultString(rs.getString("SCHOOL_END")));
				jso.put("school_name", StringUtils.defaultString(rs.getString("SCHOOL_NAME")));
				jso.put("school_department", StringUtils.defaultString(rs.getString("SCHOOL_DEPARTMENT")));
				jso.put("school_location", StringUtils.defaultString(rs.getString("SCHOOL_LOCATION")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberAcademicList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getMemberAcademicDetail(int member_no, String seq) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT MEMBER_NO ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("       ,SCOOL_CODE ").append("\n");
		sql.append("       ,DISPLAY_YN ").append("\n");
		sql.append("       ,SCHOOL_START ").append("\n");
		sql.append("       ,SCHOOL_END ").append("\n");
		sql.append("       ,SCHOOL_NAME ").append("\n");
		sql.append("       ,SCHOOL_DEPARTMENT ").append("\n");
		sql.append("       ,SCHOOL_LOCATION ").append("\n");
		sql.append("  FROM DMS_MEMBER_ACADEMIC ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		sql.append("   AND SEQ = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,member_no);
//			pstmt.setInt(2,seq);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jso.put("seq", StringUtils.defaultString(rs.getString("SEQ")));
				jso.put("scool_code", StringUtils.defaultString(rs.getString("SCOOL_CODE")));
				jso.put("display_yn", StringUtils.defaultString(rs.getString("DISPLAY_YN")));
				jso.put("school_start", StringUtils.defaultString(rs.getString("SCHOOL_START")));
				jso.put("school_end", StringUtils.defaultString(rs.getString("SCHOOL_END")));
				jso.put("school_name", StringUtils.defaultString(rs.getString("SCHOOL_NAME")));
				jso.put("school_department", StringUtils.defaultString(rs.getString("SCHOOL_DEPARTMENT")));
				jso.put("school_location", StringUtils.defaultString(rs.getString("SCHOOL_LOCATION")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberAcademicDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertMemberAcademic(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_MEMBER_ACADEMIC(").append("\n");
		sql.append("        MEMBER_NO ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("       ,SCOOL_CODE ").append("\n");
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
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,jso.getInt("member_no"));
			pstmt.setInt(2,jso.getInt("seq"));
			pstmt.setString(3,jso.getString("scool_code"));
			pstmt.setString(4,jso.getString("display_yn"));
			pstmt.setString(5,jso.getString("school_start"));
			pstmt.setString(6,jso.getString("school_end"));
			pstmt.setString(7,jso.getString("school_name"));
			pstmt.setString(8,jso.getString("school_department"));
			pstmt.setString(9,jso.getString("school_location"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertMemberAcademic 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getMemberAcademicUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_MEMBER_ACADEMIC SET ").append("\n");
		sql.append("        SCOOL_CODE = ? ").append("\n");
		sql.append("       ,DISPLAY_YN = ? ").append("\n");
		sql.append("       ,SCHOOL_START = ? ").append("\n");
		sql.append("       ,SCHOOL_END = ? ").append("\n");
		sql.append("       ,SCHOOL_NAME = ? ").append("\n");
		sql.append("       ,SCHOOL_DEPARTMENT = ? ").append("\n");
		sql.append("       ,SCHOOL_LOCATION = ? ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		sql.append("   AND SEQ = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("scool_code"));
			pstmt.setString(2,jso.getString("display_yn"));
			pstmt.setString(3,jso.getString("school_start"));
			pstmt.setString(4,jso.getString("school_end"));
			pstmt.setString(5,jso.getString("school_name"));
			pstmt.setString(6,jso.getString("school_department"));
			pstmt.setString(7,jso.getString("school_location"));
			pstmt.setInt(8,jso.getInt("member_no"));
			pstmt.setInt(9,jso.getInt("seq"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getMemberAcademicUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteMemberAcademic(int member_no, String seq) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_MEMBER_ACADEMIC ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		sql.append("   AND SEQ = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,member_no);
//			pstmt.setInt(2,seq);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteMemberAcademic 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}