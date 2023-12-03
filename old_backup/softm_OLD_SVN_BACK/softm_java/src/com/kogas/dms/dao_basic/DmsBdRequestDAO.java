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

public class DmsBdRequestDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBdRequestList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT REQ_NO ").append("\n");
		sql.append("       ,ITEM_NO ").append("\n");
		sql.append("       ,MEMBER_NO ").append("\n");
		sql.append("       ,WRIET_DATE ").append("\n");
		sql.append("       ,END_DATE ").append("\n");
		sql.append("       ,DEPT_ID ").append("\n");
		sql.append("       ,REQ_CONTEXT ").append("\n");
		sql.append("       ,REQ_GUBUN ").append("\n");
		sql.append("       ,CHARGE_USER ").append("\n");
		sql.append("       ,ANS_CONTEXT ").append("\n");
		sql.append("       ,STATUS ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE ").append("\n");
		sql.append("  FROM DMS_BD_REQUEST ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("req_no", StringUtils.defaultString(rs.getString("REQ_NO")));
				jso.put("item_no", StringUtils.defaultString(rs.getString("ITEM_NO")));
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jso.put("wriet_date", StringUtils.defaultString(rs.getString("WRIET_DATE")));
				jso.put("end_date", StringUtils.defaultString(rs.getString("END_DATE")));
				jso.put("dept_id", StringUtils.defaultString(rs.getString("DEPT_ID")));
				jso.put("req_context", StringUtils.defaultString(rs.getString("REQ_CONTEXT")));
				jso.put("req_gubun", StringUtils.defaultString(rs.getString("REQ_GUBUN")));
				jso.put("charge_user", StringUtils.defaultString(rs.getString("CHARGE_USER")));
				jso.put("ans_context", StringUtils.defaultString(rs.getString("ANS_CONTEXT")));
				jso.put("status", StringUtils.defaultString(rs.getString("STATUS")));
				jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));
				jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdRequestList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBdRequestDetail(int req_no) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT REQ_NO ").append("\n");
		sql.append("       ,ITEM_NO ").append("\n");
		sql.append("       ,MEMBER_NO ").append("\n");
		sql.append("       ,WRIET_DATE ").append("\n");
		sql.append("       ,END_DATE ").append("\n");
		sql.append("       ,DEPT_ID ").append("\n");
		sql.append("       ,REQ_CONTEXT ").append("\n");
		sql.append("       ,REQ_GUBUN ").append("\n");
		sql.append("       ,CHARGE_USER ").append("\n");
		sql.append("       ,ANS_CONTEXT ").append("\n");
		sql.append("       ,STATUS ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE ").append("\n");
		sql.append("  FROM DMS_BD_REQUEST ").append("\n");
		sql.append(" WHERE REQ_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,req_no);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("req_no", StringUtils.defaultString(rs.getString("REQ_NO")));
				jso.put("item_no", StringUtils.defaultString(rs.getString("ITEM_NO")));
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jso.put("wriet_date", StringUtils.defaultString(rs.getString("WRIET_DATE")));
				jso.put("end_date", StringUtils.defaultString(rs.getString("END_DATE")));
				jso.put("dept_id", StringUtils.defaultString(rs.getString("DEPT_ID")));
				jso.put("req_context", StringUtils.defaultString(rs.getString("REQ_CONTEXT")));
				jso.put("req_gubun", StringUtils.defaultString(rs.getString("REQ_GUBUN")));
				jso.put("charge_user", StringUtils.defaultString(rs.getString("CHARGE_USER")));
				jso.put("ans_context", StringUtils.defaultString(rs.getString("ANS_CONTEXT")));
				jso.put("status", StringUtils.defaultString(rs.getString("STATUS")));
				jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));
				jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdRequestDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBdRequest(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BD_REQUEST(").append("\n");
		sql.append("        REQ_NO ").append("\n");
		sql.append("       ,ITEM_NO ").append("\n");
		sql.append("       ,MEMBER_NO ").append("\n");
		sql.append("       ,WRIET_DATE ").append("\n");
		sql.append("       ,END_DATE ").append("\n");
		sql.append("       ,DEPT_ID ").append("\n");
		sql.append("       ,REQ_CONTEXT ").append("\n");
		sql.append("       ,REQ_GUBUN ").append("\n");
		sql.append("       ,CHARGE_USER ").append("\n");
		sql.append("       ,ANS_CONTEXT ").append("\n");
		sql.append("       ,STATUS ").append("\n");
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
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append(" );  ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,jso.getInt("req_no"));
			pstmt.setInt(2,jso.getInt("item_no"));
			pstmt.setInt(3,jso.getInt("member_no"));
			pstmt.setString(4,jso.getString("wriet_date"));
			pstmt.setString(5,jso.getString("end_date"));
			pstmt.setString(6,jso.getString("dept_id"));
			pstmt.setString(7,jso.getString("req_context"));
			pstmt.setString(8,jso.getString("req_gubun"));
			pstmt.setString(9,jso.getString("charge_user"));
			pstmt.setString(10,jso.getString("ans_context"));
			pstmt.setString(11,jso.getString("status"));
			pstmt.setString(12,jso.getString("real_att_file"));
			pstmt.setString(13,jso.getString("display_att_file"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBdRequest 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBdRequestUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BD_REQUEST SET ").append("\n");
		sql.append("        ITEM_NO = ? ").append("\n");
		sql.append("       ,MEMBER_NO = ? ").append("\n");
		sql.append("       ,WRIET_DATE = ? ").append("\n");
		sql.append("       ,END_DATE = ? ").append("\n");
		sql.append("       ,DEPT_ID = ? ").append("\n");
		sql.append("       ,REQ_CONTEXT = ? ").append("\n");
		sql.append("       ,REQ_GUBUN = ? ").append("\n");
		sql.append("       ,CHARGE_USER = ? ").append("\n");
		sql.append("       ,ANS_CONTEXT = ? ").append("\n");
		sql.append("       ,STATUS = ? ").append("\n");
		sql.append("       ,REAL_ATT_FILE = ? ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE = ? ").append("\n");
		sql.append(" WHERE REQ_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,jso.getInt("item_no"));
			pstmt.setInt(2,jso.getInt("member_no"));
			pstmt.setString(3,jso.getString("wriet_date"));
			pstmt.setString(4,jso.getString("end_date"));
			pstmt.setString(5,jso.getString("dept_id"));
			pstmt.setString(6,jso.getString("req_context"));
			pstmt.setString(7,jso.getString("req_gubun"));
			pstmt.setString(8,jso.getString("charge_user"));
			pstmt.setString(9,jso.getString("ans_context"));
			pstmt.setString(10,jso.getString("status"));
			pstmt.setString(11,jso.getString("real_att_file"));
			pstmt.setString(12,jso.getString("display_att_file"));
			pstmt.setInt(13,jso.getInt("req_no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBdRequestUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBdRequest(int req_no) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BD_REQUEST ").append("\n");
		sql.append(" WHERE REQ_NO = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,req_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBdRequest 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}