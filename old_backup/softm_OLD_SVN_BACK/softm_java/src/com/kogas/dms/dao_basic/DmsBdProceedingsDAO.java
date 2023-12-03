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

public class DmsBdProceedingsDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBdProceedingsList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT PROCEED_NO ").append("\n");
		sql.append("       ,SCHEDULE_NO ").append("\n");
		sql.append("       ,REAL_PROCEED_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_PROCEED_ATT_FILE ").append("\n");
		sql.append("       ,REAL_DECIDE_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_DECIDE_ATT_FILE ").append("\n");
		sql.append("       ,WRITE_DATE ").append("\n");
		sql.append("       ,READ_COUNT ").append("\n");
		sql.append("  FROM DMS_BD_PROCEEDINGS ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("proceed_no", StringUtils.defaultString(rs.getString("PROCEED_NO")));
				jso.put("schedule_no", StringUtils.defaultString(rs.getString("SCHEDULE_NO")));
				jso.put("real_proceed_att_file", StringUtils.defaultString(rs.getString("REAL_PROCEED_ATT_FILE")));
				jso.put("display_proceed_att_file", StringUtils.defaultString(rs.getString("DISPLAY_PROCEED_ATT_FILE")));
				jso.put("real_decide_att_file", StringUtils.defaultString(rs.getString("REAL_DECIDE_ATT_FILE")));
				jso.put("display_decide_att_file", StringUtils.defaultString(rs.getString("DISPLAY_DECIDE_ATT_FILE")));
				jso.put("write_date", StringUtils.defaultString(rs.getString("WRITE_DATE")));
				jso.put("read_count", StringUtils.defaultString(rs.getString("READ_COUNT")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdProceedingsList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBdProceedingsDetail(int proceed_no) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT PROCEED_NO ").append("\n");
		sql.append("       ,SCHEDULE_NO ").append("\n");
		sql.append("       ,REAL_PROCEED_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_PROCEED_ATT_FILE ").append("\n");
		sql.append("       ,REAL_DECIDE_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_DECIDE_ATT_FILE ").append("\n");
		sql.append("       ,WRITE_DATE ").append("\n");
		sql.append("       ,READ_COUNT ").append("\n");
		sql.append("  FROM DMS_BD_PROCEEDINGS ").append("\n");
		sql.append(" WHERE PROCEED_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,proceed_no);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("proceed_no", StringUtils.defaultString(rs.getString("PROCEED_NO")));
				jso.put("schedule_no", StringUtils.defaultString(rs.getString("SCHEDULE_NO")));
				jso.put("real_proceed_att_file", StringUtils.defaultString(rs.getString("REAL_PROCEED_ATT_FILE")));
				jso.put("display_proceed_att_file", StringUtils.defaultString(rs.getString("DISPLAY_PROCEED_ATT_FILE")));
				jso.put("real_decide_att_file", StringUtils.defaultString(rs.getString("REAL_DECIDE_ATT_FILE")));
				jso.put("display_decide_att_file", StringUtils.defaultString(rs.getString("DISPLAY_DECIDE_ATT_FILE")));
				jso.put("write_date", StringUtils.defaultString(rs.getString("WRITE_DATE")));
				jso.put("read_count", StringUtils.defaultString(rs.getString("READ_COUNT")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdProceedingsDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBdProceedings(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BD_PROCEEDINGS(").append("\n");
		sql.append("        PROCEED_NO ").append("\n");
		sql.append("       ,SCHEDULE_NO ").append("\n");
		sql.append("       ,REAL_PROCEED_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_PROCEED_ATT_FILE ").append("\n");
		sql.append("       ,REAL_DECIDE_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_DECIDE_ATT_FILE ").append("\n");
		sql.append("       ,WRITE_DATE ").append("\n");
		sql.append("       ,READ_COUNT ").append("\n");
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
			pstmt.setInt(1,jso.getInt("proceed_no"));
			pstmt.setInt(2,jso.getInt("schedule_no"));
			pstmt.setString(3,jso.getString("real_proceed_att_file"));
			pstmt.setString(4,jso.getString("display_proceed_att_file"));
			pstmt.setString(5,jso.getString("real_decide_att_file"));
			pstmt.setString(6,jso.getString("display_decide_att_file"));
			pstmt.setString(7,jso.getString("write_date"));
			pstmt.setInt(8,jso.getInt("read_count"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBdProceedings 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBdProceedingsUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BD_PROCEEDINGS SET ").append("\n");
		sql.append("        SCHEDULE_NO = ? ").append("\n");
		sql.append("       ,REAL_PROCEED_ATT_FILE = ? ").append("\n");
		sql.append("       ,DISPLAY_PROCEED_ATT_FILE = ? ").append("\n");
		sql.append("       ,REAL_DECIDE_ATT_FILE = ? ").append("\n");
		sql.append("       ,DISPLAY_DECIDE_ATT_FILE = ? ").append("\n");
		sql.append("       ,WRITE_DATE = ? ").append("\n");
		sql.append("       ,READ_COUNT = ? ").append("\n");
		sql.append(" WHERE PROCEED_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,jso.getInt("schedule_no"));
			pstmt.setString(2,jso.getString("real_proceed_att_file"));
			pstmt.setString(3,jso.getString("display_proceed_att_file"));
			pstmt.setString(4,jso.getString("real_decide_att_file"));
			pstmt.setString(5,jso.getString("display_decide_att_file"));
			pstmt.setString(6,jso.getString("write_date"));
			pstmt.setInt(7,jso.getInt("read_count"));
			pstmt.setInt(8,jso.getInt("proceed_no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBdProceedingsUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBdProceedings(int proceed_no) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BD_PROCEEDINGS ").append("\n");
		sql.append(" WHERE PROCEED_NO = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,proceed_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBdProceedings 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}