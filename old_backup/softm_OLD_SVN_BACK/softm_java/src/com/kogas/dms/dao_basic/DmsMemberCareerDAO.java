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

public class DmsMemberCareerDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getMemberCareerList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
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

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

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
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberCareerList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getMemberCareerDetail(int member_no, String seq) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
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
				jso.put("display_yn", StringUtils.defaultString(rs.getString("DISPLAY_YN")));
				jso.put("job_start", StringUtils.defaultString(rs.getString("JOB_START")));
				jso.put("job_end", StringUtils.defaultString(rs.getString("JOB_END")));
				jso.put("job_name", StringUtils.defaultString(rs.getString("JOB_NAME")));
				jso.put("dept_name", StringUtils.defaultString(rs.getString("DEPT_NAME")));
				jso.put("position", StringUtils.defaultString(rs.getString("POSITION")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberCareerDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertMemberCareer(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
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
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,jso.getInt("member_no"));
			pstmt.setInt(2,jso.getInt("seq"));
			pstmt.setString(3,jso.getString("display_yn"));
			pstmt.setString(4,jso.getString("job_start"));
			pstmt.setString(5,jso.getString("job_end"));
			pstmt.setString(6,jso.getString("job_name"));
			pstmt.setString(7,jso.getString("dept_name"));
			pstmt.setString(8,jso.getString("position"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertMemberCareer 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getMemberCareerUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_MEMBER_CAREER SET ").append("\n");
		sql.append("        DISPLAY_YN = ? ").append("\n");
		sql.append("       ,JOB_START = ? ").append("\n");
		sql.append("       ,JOB_END = ? ").append("\n");
		sql.append("       ,JOB_NAME = ? ").append("\n");
		sql.append("       ,DEPT_NAME = ? ").append("\n");
		sql.append("       ,POSITION = ? ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		sql.append("   AND SEQ = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("display_yn"));
			pstmt.setString(2,jso.getString("job_start"));
			pstmt.setString(3,jso.getString("job_end"));
			pstmt.setString(4,jso.getString("job_name"));
			pstmt.setString(5,jso.getString("dept_name"));
			pstmt.setString(6,jso.getString("position"));
			pstmt.setInt(7,jso.getInt("member_no"));
			pstmt.setInt(8,jso.getInt("seq"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getMemberCareerUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteMemberCareer(int member_no, String seq) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_MEMBER_CAREER ").append("\n");
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
			System.out.println("deleteMemberCareer 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}