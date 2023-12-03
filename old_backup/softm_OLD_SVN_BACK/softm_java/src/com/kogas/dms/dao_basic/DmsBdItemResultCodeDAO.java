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

public class DmsBdItemResultCodeDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBdItemResultCodeList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT CODE ").append("\n");
		sql.append("       ,CODE_NAME ").append("\n");
		sql.append("       ,CODE_CONTEXT ").append("\n");
		sql.append("  FROM DMS_BD_ITEM_RESULT_CODE ").append("\n");

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
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdItemResultCodeList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBdItemResultCodeDetail(String code) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT CODE ").append("\n");
		sql.append("       ,CODE_NAME ").append("\n");
		sql.append("       ,CODE_CONTEXT ").append("\n");
		sql.append("  FROM DMS_BD_ITEM_RESULT_CODE ").append("\n");
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
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdItemResultCodeDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBdItemResultCode(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BD_ITEM_RESULT_CODE(").append("\n");
		sql.append("        CODE ").append("\n");
		sql.append("       ,CODE_NAME ").append("\n");
		sql.append("       ,CODE_CONTEXT ").append("\n");
		sql.append(" )  ").append("\n");
		sql.append(" VALUES (").append("\n");
		sql.append("         ? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append(" );  ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("code"));
			pstmt.setString(2,jso.getString("code_name"));
			pstmt.setString(3,jso.getString("code_context"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBdItemResultCode 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBdItemResultCodeUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BD_ITEM_RESULT_CODE SET ").append("\n");
		sql.append("        CODE_NAME = ? ").append("\n");
		sql.append("       ,CODE_CONTEXT = ? ").append("\n");
		sql.append(" WHERE CODE = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("code_name"));
			pstmt.setString(2,jso.getString("code_context"));
			pstmt.setString(3,jso.getString("code"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBdItemResultCodeUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBdItemResultCode(String code) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BD_ITEM_RESULT_CODE ").append("\n");
		sql.append(" WHERE CODE = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,code);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBdItemResultCode 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}