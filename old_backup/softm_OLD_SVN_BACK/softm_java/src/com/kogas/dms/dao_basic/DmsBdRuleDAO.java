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

public class DmsBdRuleDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBdRuleList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT BY_NO ").append("\n");
		sql.append("       ,SUBJECT ").append("\n");
		sql.append("       ,CONTEXT ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("  FROM DMS_BD_RULE ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("by_no", StringUtils.defaultString(rs.getString("BY_NO")));
				jso.put("subject", StringUtils.defaultString(rs.getString("SUBJECT")));
				jso.put("context", StringUtils.defaultString(rs.getString("CONTEXT")));
				jso.put("seq", StringUtils.defaultString(rs.getString("SEQ")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdRuleList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBdRuleDetail(int by_no) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT BY_NO ").append("\n");
		sql.append("       ,SUBJECT ").append("\n");
		sql.append("       ,CONTEXT ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("  FROM DMS_BD_RULE ").append("\n");
		sql.append(" WHERE BY_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,by_no);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("by_no", StringUtils.defaultString(rs.getString("BY_NO")));
				jso.put("subject", StringUtils.defaultString(rs.getString("SUBJECT")));
				jso.put("context", StringUtils.defaultString(rs.getString("CONTEXT")));
				jso.put("seq", StringUtils.defaultString(rs.getString("SEQ")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdRuleDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBdRule(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BD_RULE(").append("\n");
		sql.append("        BY_NO ").append("\n");
		sql.append("       ,SUBJECT ").append("\n");
		sql.append("       ,CONTEXT ").append("\n");
		sql.append("       ,SEQ ").append("\n");
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
			pstmt.setInt(1,jso.getInt("by_no"));
			pstmt.setString(2,jso.getString("subject"));
			pstmt.setString(3,jso.getString("context"));
			pstmt.setInt(4,jso.getInt("seq"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBdRule 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBdRuleUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BD_RULE SET ").append("\n");
		sql.append("        SUBJECT = ? ").append("\n");
		sql.append("       ,CONTEXT = ? ").append("\n");
		sql.append("       ,SEQ = ? ").append("\n");
		sql.append(" WHERE BY_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("subject"));
			pstmt.setString(2,jso.getString("context"));
			pstmt.setInt(3,jso.getInt("seq"));
			pstmt.setInt(4,jso.getInt("by_no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBdRuleUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBdRule(int by_no) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BD_RULE ").append("\n");
		sql.append(" WHERE BY_NO = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,by_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBdRule 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}