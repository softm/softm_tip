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

public class DmsBoardCodeDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBoardCodeList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT CODE ").append("\n");
		sql.append("       ,CODE_NAME ").append("\n");
		sql.append("       ,CODE_CONTEXT ").append("\n");
		sql.append("       ,BOARD_TYPE ").append("\n");
		sql.append("  FROM DMS_BOARD_CODE ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("code", StringUtils.defaultString(rs.getString("CODE")));
				jso.put("code_name", StringUtils.defaultString(rs.getString("CODE_NAME")));
				jso.put("code_context", StringUtils.defaultString(rs.getString("CODE_CONTEXT")));
				jso.put("board_type", StringUtils.defaultString(rs.getString("BOARD_TYPE")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBoardCodeList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBoardCodeDetail(String code) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT CODE ").append("\n");
		sql.append("       ,CODE_NAME ").append("\n");
		sql.append("       ,CODE_CONTEXT ").append("\n");
		sql.append("       ,BOARD_TYPE ").append("\n");
		sql.append("  FROM DMS_BOARD_CODE ").append("\n");
		sql.append(" WHERE CODE = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,code);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("code", StringUtils.defaultString(rs.getString("CODE")));
				jso.put("code_name", StringUtils.defaultString(rs.getString("CODE_NAME")));
				jso.put("code_context", StringUtils.defaultString(rs.getString("CODE_CONTEXT")));
				jso.put("board_type", StringUtils.defaultString(rs.getString("BOARD_TYPE")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBoardCodeDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBoardCode(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BOARD_CODE(").append("\n");
		sql.append("        CODE ").append("\n");
		sql.append("       ,CODE_NAME ").append("\n");
		sql.append("       ,CODE_CONTEXT ").append("\n");
		sql.append("       ,BOARD_TYPE ").append("\n");
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
			pstmt.setString(1,jso.getString("code"));
			pstmt.setString(2,jso.getString("code_name"));
			pstmt.setString(3,jso.getString("code_context"));
			pstmt.setString(4,jso.getString("board_type"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBoardCode 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBoardCodeUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BOARD_CODE SET ").append("\n");
		sql.append("        CODE_NAME = ? ").append("\n");
		sql.append("       ,CODE_CONTEXT = ? ").append("\n");
		sql.append("       ,BOARD_TYPE = ? ").append("\n");
		sql.append(" WHERE CODE = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("code_name"));
			pstmt.setString(2,jso.getString("code_context"));
			pstmt.setString(3,jso.getString("board_type"));
			pstmt.setString(4,jso.getString("code"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBoardCodeUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBoardCode(String code) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BOARD_CODE ").append("\n");
		sql.append(" WHERE CODE = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,code);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBoardCode 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}