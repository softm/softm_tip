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

public class DmsBdItemResultDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBdItemResultList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT CODE ").append("\n");
		sql.append("       ,ITEM_NO ").append("\n");
		sql.append("       ,RESULT_REGIS ").append("\n");
		sql.append("       ,RESULT_CONTEXT ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE ").append("\n");
		sql.append("  FROM DMS_BD_ITEM_RESULT ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("code", StringUtils.defaultString(rs.getString("CODE")));
				jso.put("item_no", StringUtils.defaultString(rs.getString("ITEM_NO")));
				jso.put("result_regis", StringUtils.defaultString(rs.getString("RESULT_REGIS")));
				jso.put("result_context", StringUtils.defaultString(rs.getString("RESULT_CONTEXT")));
				jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));
				jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdItemResultList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBdItemResultDetail(String code) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT CODE ").append("\n");
		sql.append("       ,ITEM_NO ").append("\n");
		sql.append("       ,RESULT_REGIS ").append("\n");
		sql.append("       ,RESULT_CONTEXT ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE ").append("\n");
		sql.append("  FROM DMS_BD_ITEM_RESULT ").append("\n");
		sql.append(" WHERE CODE = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,code);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("code", StringUtils.defaultString(rs.getString("CODE")));
				jso.put("item_no", StringUtils.defaultString(rs.getString("ITEM_NO")));
				jso.put("result_regis", StringUtils.defaultString(rs.getString("RESULT_REGIS")));
				jso.put("result_context", StringUtils.defaultString(rs.getString("RESULT_CONTEXT")));
				jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));
				jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdItemResultDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBdItemResult(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BD_ITEM_RESULT(").append("\n");
		sql.append("        CODE ").append("\n");
		sql.append("       ,ITEM_NO ").append("\n");
		sql.append("       ,RESULT_REGIS ").append("\n");
		sql.append("       ,RESULT_CONTEXT ").append("\n");
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
		sql.append(" );  ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("code"));
			pstmt.setInt(2,jso.getInt("item_no"));
			pstmt.setString(3,jso.getString("result_regis"));
			pstmt.setString(4,jso.getString("result_context"));
			pstmt.setString(5,jso.getString("real_att_file"));
			pstmt.setString(6,jso.getString("display_att_file"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBdItemResult 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBdItemResultUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BD_ITEM_RESULT SET ").append("\n");
		sql.append("        ITEM_NO = ? ").append("\n");
		sql.append("       ,RESULT_REGIS = ? ").append("\n");
		sql.append("       ,RESULT_CONTEXT = ? ").append("\n");
		sql.append("       ,REAL_ATT_FILE = ? ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE = ? ").append("\n");
		sql.append(" WHERE CODE = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,jso.getInt("item_no"));
			pstmt.setString(2,jso.getString("result_regis"));
			pstmt.setString(3,jso.getString("result_context"));
			pstmt.setString(4,jso.getString("real_att_file"));
			pstmt.setString(5,jso.getString("display_att_file"));
			pstmt.setString(6,jso.getString("code"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBdItemResultUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBdItemResult(String code) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BD_ITEM_RESULT ").append("\n");
		sql.append(" WHERE CODE = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,code);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBdItemResult 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}