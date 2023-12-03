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

public class DmsBdGroupDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBdGroupList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT GROUP_NO ").append("\n");
		sql.append("       ,GROUP_NM ").append("\n");
		sql.append("       ,GROUP_MEMBER ").append("\n");
		sql.append("       ,MAJOR_FUNCTION ").append("\n");
		sql.append("  FROM DMS_BD_GROUP ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("group_no", StringUtils.defaultString(rs.getString("GROUP_NO")));
				jso.put("group_nm", StringUtils.defaultString(rs.getString("GROUP_NM")));
				jso.put("group_member", StringUtils.defaultString(rs.getString("GROUP_MEMBER")));
				jso.put("major_function", StringUtils.defaultString(rs.getString("MAJOR_FUNCTION")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdGroupList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBdGroupDetail(String group_no) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT GROUP_NO ").append("\n");
		sql.append("       ,GROUP_NM ").append("\n");
		sql.append("       ,GROUP_MEMBER ").append("\n");
		sql.append("       ,MAJOR_FUNCTION ").append("\n");
		sql.append("  FROM DMS_BD_GROUP ").append("\n");
		sql.append(" WHERE GROUP_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,group_no);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("group_no", StringUtils.defaultString(rs.getString("GROUP_NO")));
				jso.put("group_nm", StringUtils.defaultString(rs.getString("GROUP_NM")));
				jso.put("group_member", StringUtils.defaultString(rs.getString("GROUP_MEMBER")));
				jso.put("major_function", StringUtils.defaultString(rs.getString("MAJOR_FUNCTION")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdGroupDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBdGroup(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BD_GROUP(").append("\n");
		sql.append("        GROUP_NO ").append("\n");
		sql.append("       ,GROUP_NM ").append("\n");
		sql.append("       ,GROUP_MEMBER ").append("\n");
		sql.append("       ,MAJOR_FUNCTION ").append("\n");
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
			pstmt.setString(1,jso.getString("group_no"));
			pstmt.setString(2,jso.getString("group_nm"));
			pstmt.setString(3,jso.getString("group_member"));
			pstmt.setString(4,jso.getString("major_function"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBdGroup 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBdGroupUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BD_GROUP SET ").append("\n");
		sql.append("        GROUP_NM = ? ").append("\n");
		sql.append("       ,GROUP_MEMBER = ? ").append("\n");
		sql.append("       ,MAJOR_FUNCTION = ? ").append("\n");
		sql.append(" WHERE GROUP_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("group_nm"));
			pstmt.setString(2,jso.getString("group_member"));
			pstmt.setString(3,jso.getString("major_function"));
			pstmt.setString(4,jso.getString("group_no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBdGroupUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBdGroup(String group_no) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BD_GROUP ").append("\n");
		sql.append(" WHERE GROUP_NO = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,group_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBdGroup 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}