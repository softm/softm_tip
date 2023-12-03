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

public class DmsBdItemCodeDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBdItemCodeList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT ITEM_CODE ").append("\n");
		sql.append("       ,ITEM_CLASS ").append("\n");
		sql.append("       ,ITEM_CODE_NAME ").append("\n");
		sql.append("  FROM DMS_BD_ITEM_CODE ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("item_code", StringUtils.defaultString(rs.getString("ITEM_CODE")));
				jso.put("item_class", StringUtils.defaultString(rs.getString("ITEM_CLASS")));
				jso.put("item_code_name", StringUtils.defaultString(rs.getString("ITEM_CODE_NAME")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdItemCodeList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBdItemCodeDetail(String item_code) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT ITEM_CODE ").append("\n");
		sql.append("       ,ITEM_CLASS ").append("\n");
		sql.append("       ,ITEM_CODE_NAME ").append("\n");
		sql.append("  FROM DMS_BD_ITEM_CODE ").append("\n");
		sql.append(" WHERE ITEM_CODE = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,item_code);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("item_code", StringUtils.defaultString(rs.getString("ITEM_CODE")));
				jso.put("item_class", StringUtils.defaultString(rs.getString("ITEM_CLASS")));
				jso.put("item_code_name", StringUtils.defaultString(rs.getString("ITEM_CODE_NAME")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdItemCodeDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBdItemCode(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BD_ITEM_CODE(").append("\n");
		sql.append("        ITEM_CODE ").append("\n");
		sql.append("       ,ITEM_CLASS ").append("\n");
		sql.append("       ,ITEM_CODE_NAME ").append("\n");
		sql.append(" )  ").append("\n");
		sql.append(" VALUES (").append("\n");
		sql.append("         ? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append(" );  ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("item_code"));
			pstmt.setString(2,jso.getString("item_class"));
			pstmt.setString(3,jso.getString("item_code_name"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBdItemCode 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBdItemCodeUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BD_ITEM_CODE SET ").append("\n");
		sql.append("        ITEM_CLASS = ? ").append("\n");
		sql.append("       ,ITEM_CODE_NAME = ? ").append("\n");
		sql.append(" WHERE ITEM_CODE = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("item_class"));
			pstmt.setString(2,jso.getString("item_code_name"));
			pstmt.setString(3,jso.getString("item_code"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBdItemCodeUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBdItemCode(String item_code) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BD_ITEM_CODE ").append("\n");
		sql.append(" WHERE ITEM_CODE = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,item_code);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBdItemCode 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}