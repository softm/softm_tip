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

public class DmsBoardBasicDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBoardBasicList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT NO ").append("\n");
		sql.append("       ,CODE ").append("\n");
		sql.append("       ,SUBJECT ").append("\n");
		sql.append("       ,CONTEXT ").append("\n");
		sql.append("       ,WRITER ").append("\n");
		sql.append("       ,WRITE_DATE ").append("\n");
		sql.append("       ,READ_COUNT ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE ").append("\n");
		sql.append("  FROM DMS_BOARD_BASIC ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("no", StringUtils.defaultString(rs.getString("NO")));
				jso.put("code", StringUtils.defaultString(rs.getString("CODE")));
				jso.put("subject", StringUtils.defaultString(rs.getString("SUBJECT")));
				jso.put("context", StringUtils.defaultString(rs.getString("CONTEXT")));
				jso.put("writer", StringUtils.defaultString(rs.getString("WRITER")));
				jso.put("write_date", StringUtils.defaultString(rs.getString("WRITE_DATE")));
				jso.put("read_count", StringUtils.defaultString(rs.getString("READ_COUNT")));
				jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));
				jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBoardBasicList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBoardBasicDetail(int no) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT NO ").append("\n");
		sql.append("       ,CODE ").append("\n");
		sql.append("       ,SUBJECT ").append("\n");
		sql.append("       ,CONTEXT ").append("\n");
		sql.append("       ,WRITER ").append("\n");
		sql.append("       ,WRITE_DATE ").append("\n");
		sql.append("       ,READ_COUNT ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE ").append("\n");
		sql.append("  FROM DMS_BOARD_BASIC ").append("\n");
		sql.append(" WHERE NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,no);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("no", StringUtils.defaultString(rs.getString("NO")));
				jso.put("code", StringUtils.defaultString(rs.getString("CODE")));
				jso.put("subject", StringUtils.defaultString(rs.getString("SUBJECT")));
				jso.put("context", StringUtils.defaultString(rs.getString("CONTEXT")));
				jso.put("writer", StringUtils.defaultString(rs.getString("WRITER")));
				jso.put("write_date", StringUtils.defaultString(rs.getString("WRITE_DATE")));
				jso.put("read_count", StringUtils.defaultString(rs.getString("READ_COUNT")));
				jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));
				jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBoardBasicDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBoardBasic(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BOARD_BASIC(").append("\n");
		sql.append("        NO ").append("\n");
		sql.append("       ,CODE ").append("\n");
		sql.append("       ,SUBJECT ").append("\n");
		sql.append("       ,CONTEXT ").append("\n");
		sql.append("       ,WRITER ").append("\n");
		sql.append("       ,WRITE_DATE ").append("\n");
		sql.append("       ,READ_COUNT ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE ").append("\n");
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
			pstmt.setInt(1,jso.getInt("no"));
			pstmt.setString(2,jso.getString("code"));
			pstmt.setString(3,jso.getString("subject"));
			pstmt.setString(4,jso.getString("context"));
			pstmt.setString(5,jso.getString("writer"));
			pstmt.setString(6,jso.getString("write_date"));
			pstmt.setInt(7,jso.getInt("read_count"));
			pstmt.setString(8,jso.getString("real_att_file"));
			pstmt.setString(9,jso.getString("display_att_file"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBoardBasic 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBoardBasicUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BOARD_BASIC SET ").append("\n");
		sql.append("        CODE = ? ").append("\n");
		sql.append("       ,SUBJECT = ? ").append("\n");
		sql.append("       ,CONTEXT = ? ").append("\n");
		sql.append("       ,WRITER = ? ").append("\n");
		sql.append("       ,WRITE_DATE = ? ").append("\n");
		sql.append("       ,READ_COUNT = ? ").append("\n");
		sql.append("       ,REAL_ATT_FILE = ? ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE = ? ").append("\n");
		sql.append(" WHERE NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("code"));
			pstmt.setString(2,jso.getString("subject"));
			pstmt.setString(3,jso.getString("context"));
			pstmt.setString(4,jso.getString("writer"));
			pstmt.setString(5,jso.getString("write_date"));
			pstmt.setInt(6,jso.getInt("read_count"));
			pstmt.setString(7,jso.getString("real_att_file"));
			pstmt.setString(8,jso.getString("display_att_file"));
			pstmt.setInt(9,jso.getInt("no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBoardBasicUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBoardBasic(int no) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BOARD_BASIC ").append("\n");
		sql.append(" WHERE NO = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBoardBasic 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}