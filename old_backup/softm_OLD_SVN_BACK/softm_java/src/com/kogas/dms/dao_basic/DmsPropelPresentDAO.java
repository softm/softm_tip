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

public class DmsPropelPresentDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getPropelPresentList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT PROPEL_NO ").append("\n");
		sql.append("       ,CHARGE_USER ").append("\n");
		sql.append("       ,RPPEL_PROGRESS ").append("\n");
		sql.append("       ,SLIGHT_CONTENT ").append("\n");
		sql.append("       ,HENCEFORTH_PLAN ").append("\n");
		sql.append("       ,ATTCHE_FILE ").append("\n");
		sql.append("       ,ITEM_NO ").append("\n");
		sql.append("  FROM DMS_PROPEL_PRESENT ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("propel_no", StringUtils.defaultString(rs.getString("PROPEL_NO")));
				jso.put("charge_user", StringUtils.defaultString(rs.getString("CHARGE_USER")));
				jso.put("rppel_progress", StringUtils.defaultString(rs.getString("RPPEL_PROGRESS")));
				jso.put("slight_content", StringUtils.defaultString(rs.getString("SLIGHT_CONTENT")));
				jso.put("henceforth_plan", StringUtils.defaultString(rs.getString("HENCEFORTH_PLAN")));
				jso.put("attche_file", StringUtils.defaultString(rs.getString("ATTCHE_FILE")));
				jso.put("item_no", StringUtils.defaultString(rs.getString("ITEM_NO")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getPropelPresentList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getPropelPresentDetail(int propel_no) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT PROPEL_NO ").append("\n");
		sql.append("       ,CHARGE_USER ").append("\n");
		sql.append("       ,RPPEL_PROGRESS ").append("\n");
		sql.append("       ,SLIGHT_CONTENT ").append("\n");
		sql.append("       ,HENCEFORTH_PLAN ").append("\n");
		sql.append("       ,ATTCHE_FILE ").append("\n");
		sql.append("       ,ITEM_NO ").append("\n");
		sql.append("  FROM DMS_PROPEL_PRESENT ").append("\n");
		sql.append(" WHERE PROPEL_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,propel_no);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("propel_no", StringUtils.defaultString(rs.getString("PROPEL_NO")));
				jso.put("charge_user", StringUtils.defaultString(rs.getString("CHARGE_USER")));
				jso.put("rppel_progress", StringUtils.defaultString(rs.getString("RPPEL_PROGRESS")));
				jso.put("slight_content", StringUtils.defaultString(rs.getString("SLIGHT_CONTENT")));
				jso.put("henceforth_plan", StringUtils.defaultString(rs.getString("HENCEFORTH_PLAN")));
				jso.put("attche_file", StringUtils.defaultString(rs.getString("ATTCHE_FILE")));
				jso.put("item_no", StringUtils.defaultString(rs.getString("ITEM_NO")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getPropelPresentDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertPropelPresent(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_PROPEL_PRESENT(").append("\n");
		sql.append("        PROPEL_NO ").append("\n");
		sql.append("       ,CHARGE_USER ").append("\n");
		sql.append("       ,RPPEL_PROGRESS ").append("\n");
		sql.append("       ,SLIGHT_CONTENT ").append("\n");
		sql.append("       ,HENCEFORTH_PLAN ").append("\n");
		sql.append("       ,ATTCHE_FILE ").append("\n");
		sql.append("       ,ITEM_NO ").append("\n");
		sql.append(" )  ").append("\n");
		sql.append(" VALUES (").append("\n");
		sql.append("         ? ").append("\n");
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
			pstmt.setInt(1,jso.getInt("propel_no"));
			pstmt.setString(2,jso.getString("charge_user"));
			pstmt.setString(3,jso.getString("rppel_progress"));
			pstmt.setString(4,jso.getString("slight_content"));
			pstmt.setString(5,jso.getString("henceforth_plan"));
			pstmt.setString(6,jso.getString("attche_file"));
			pstmt.setInt(7,jso.getInt("item_no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertPropelPresent 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getPropelPresentUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_PROPEL_PRESENT SET ").append("\n");
		sql.append("        CHARGE_USER = ? ").append("\n");
		sql.append("       ,RPPEL_PROGRESS = ? ").append("\n");
		sql.append("       ,SLIGHT_CONTENT = ? ").append("\n");
		sql.append("       ,HENCEFORTH_PLAN = ? ").append("\n");
		sql.append("       ,ATTCHE_FILE = ? ").append("\n");
		sql.append("       ,ITEM_NO = ? ").append("\n");
		sql.append(" WHERE PROPEL_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("charge_user"));
			pstmt.setString(2,jso.getString("rppel_progress"));
			pstmt.setString(3,jso.getString("slight_content"));
			pstmt.setString(4,jso.getString("henceforth_plan"));
			pstmt.setString(5,jso.getString("attche_file"));
			pstmt.setInt(6,jso.getInt("item_no"));
			pstmt.setInt(7,jso.getInt("propel_no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getPropelPresentUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deletePropelPresent(int propel_no) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_PROPEL_PRESENT ").append("\n");
		sql.append(" WHERE PROPEL_NO = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,propel_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deletePropelPresent 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}