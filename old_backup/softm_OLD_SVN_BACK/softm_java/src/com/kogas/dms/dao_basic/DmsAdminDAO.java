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

public class DmsAdminDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getAdminList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT EMP_NO ").append("\n");
		sql.append("       ,AUTH_DIVIDE ").append("\n");
		sql.append("       ,AUTH_DT ").append("\n");
		sql.append("  FROM DMS_ADMIN ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("emp_no", StringUtils.defaultString(rs.getString("EMP_NO")));
				jso.put("auth_divide", StringUtils.defaultString(rs.getString("AUTH_DIVIDE")));
				jso.put("auth_dt", StringUtils.defaultString(rs.getString("AUTH_DT")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getAdminList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getAdminDetail() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT EMP_NO ").append("\n");
		sql.append("       ,AUTH_DIVIDE ").append("\n");
		sql.append("       ,AUTH_DT ").append("\n");
		sql.append("  FROM DMS_ADMIN ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("emp_no", StringUtils.defaultString(rs.getString("EMP_NO")));
				jso.put("auth_divide", StringUtils.defaultString(rs.getString("AUTH_DIVIDE")));
				jso.put("auth_dt", StringUtils.defaultString(rs.getString("AUTH_DT")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getAdminDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertAdmin(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_ADMIN(").append("\n");
		sql.append("        EMP_NO ").append("\n");
		sql.append("       ,AUTH_DIVIDE ").append("\n");
		sql.append("       ,AUTH_DT ").append("\n");
		sql.append(" )  ").append("\n");
		sql.append(" VALUES (").append("\n");
		sql.append("         ? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append(" );  ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("emp_no"));
			pstmt.setString(2,jso.getString("auth_divide"));
			pstmt.setString(3,jso.getString("auth_dt"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertAdmin 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getAdminUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_ADMIN SET ").append("\n");
		sql.append("        EMP_NO = ? ").append("\n");
		sql.append("       ,AUTH_DIVIDE = ? ").append("\n");
		sql.append("       ,AUTH_DT = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("emp_no"));
			pstmt.setString(2,jso.getString("auth_divide"));
			pstmt.setString(3,jso.getString("auth_dt"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getAdminUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteAdmin() {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_ADMIN ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteAdmin 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}