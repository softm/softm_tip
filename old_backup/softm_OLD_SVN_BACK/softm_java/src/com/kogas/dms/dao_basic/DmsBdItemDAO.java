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

public class DmsBdItemDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBdItemList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT ITEM_NO ").append("\n");
		sql.append("       ,SCHEDULE_NO ").append("\n");
		sql.append("       ,COL ").append("\n");
		sql.append("       ,ITEM_DEVISION ").append("\n");
		sql.append("       ,ITEM_CODE2 ").append("\n");
		sql.append("       ,ITEM_CODE3 ").append("\n");
		sql.append("       ,ITEM_CODE4 ").append("\n");
		sql.append("       ,ITEM_NAME ").append("\n");
		sql.append("       ,APPROVAL_REQUEST ").append("\n");
		sql.append("       ,DEPT_CODE ").append("\n");
		sql.append("       ,COAST_CENTER ").append("\n");
		sql.append("       ,FUNDS_DEPT ").append("\n");
		sql.append("       ,AVAIABLE_BUDGET ").append("\n");
		sql.append("       ,BUDGET_AMOUNT ").append("\n");
		sql.append("       ,REFERENCE ").append("\n");
		sql.append("       ,IS_RESULT ").append("\n");
		sql.append("       ,CRE_USER ").append("\n");
		sql.append("       ,CRE_DATE ").append("\n");
		sql.append("       ,READ_COUNT ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE ").append("\n");
		sql.append("  FROM DMS_BD_ITEM ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("item_no", StringUtils.defaultString(rs.getString("ITEM_NO")));
				jso.put("schedule_no", StringUtils.defaultString(rs.getString("SCHEDULE_NO")));
				jso.put("col", StringUtils.defaultString(rs.getString("COL")));
				jso.put("item_devision", StringUtils.defaultString(rs.getString("ITEM_DEVISION")));
				jso.put("item_code2", StringUtils.defaultString(rs.getString("ITEM_CODE2")));
				jso.put("item_code3", StringUtils.defaultString(rs.getString("ITEM_CODE3")));
				jso.put("item_code4", StringUtils.defaultString(rs.getString("ITEM_CODE4")));
				jso.put("item_name", StringUtils.defaultString(rs.getString("ITEM_NAME")));
				jso.put("approval_request", StringUtils.defaultString(rs.getString("APPROVAL_REQUEST")));
				jso.put("dept_code", StringUtils.defaultString(rs.getString("DEPT_CODE")));
				jso.put("coast_center", StringUtils.defaultString(rs.getString("COAST_CENTER")));
				jso.put("funds_dept", StringUtils.defaultString(rs.getString("FUNDS_DEPT")));
				jso.put("avaiable_budget", StringUtils.defaultString(rs.getString("AVAIABLE_BUDGET")));
				jso.put("budget_amount", StringUtils.defaultString(rs.getString("BUDGET_AMOUNT")));
				jso.put("reference", StringUtils.defaultString(rs.getString("REFERENCE")));
				jso.put("is_result", StringUtils.defaultString(rs.getString("IS_RESULT")));
				jso.put("cre_user", StringUtils.defaultString(rs.getString("CRE_USER")));
				jso.put("cre_date", StringUtils.defaultString(rs.getString("CRE_DATE")));
				jso.put("read_count", StringUtils.defaultString(rs.getString("READ_COUNT")));
				jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));
				jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdItemList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBdItemDetail(int item_no) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT ITEM_NO ").append("\n");
		sql.append("       ,SCHEDULE_NO ").append("\n");
		sql.append("       ,COL ").append("\n");
		sql.append("       ,ITEM_DEVISION ").append("\n");
		sql.append("       ,ITEM_CODE2 ").append("\n");
		sql.append("       ,ITEM_CODE3 ").append("\n");
		sql.append("       ,ITEM_CODE4 ").append("\n");
		sql.append("       ,ITEM_NAME ").append("\n");
		sql.append("       ,APPROVAL_REQUEST ").append("\n");
		sql.append("       ,DEPT_CODE ").append("\n");
		sql.append("       ,COAST_CENTER ").append("\n");
		sql.append("       ,FUNDS_DEPT ").append("\n");
		sql.append("       ,AVAIABLE_BUDGET ").append("\n");
		sql.append("       ,BUDGET_AMOUNT ").append("\n");
		sql.append("       ,REFERENCE ").append("\n");
		sql.append("       ,IS_RESULT ").append("\n");
		sql.append("       ,CRE_USER ").append("\n");
		sql.append("       ,CRE_DATE ").append("\n");
		sql.append("       ,READ_COUNT ").append("\n");
		sql.append("       ,REAL_ATT_FILE ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE ").append("\n");
		sql.append("  FROM DMS_BD_ITEM ").append("\n");
		sql.append(" WHERE ITEM_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,item_no);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("item_no", StringUtils.defaultString(rs.getString("ITEM_NO")));
				jso.put("schedule_no", StringUtils.defaultString(rs.getString("SCHEDULE_NO")));
				jso.put("col", StringUtils.defaultString(rs.getString("COL")));
				jso.put("item_devision", StringUtils.defaultString(rs.getString("ITEM_DEVISION")));
				jso.put("item_code2", StringUtils.defaultString(rs.getString("ITEM_CODE2")));
				jso.put("item_code3", StringUtils.defaultString(rs.getString("ITEM_CODE3")));
				jso.put("item_code4", StringUtils.defaultString(rs.getString("ITEM_CODE4")));
				jso.put("item_name", StringUtils.defaultString(rs.getString("ITEM_NAME")));
				jso.put("approval_request", StringUtils.defaultString(rs.getString("APPROVAL_REQUEST")));
				jso.put("dept_code", StringUtils.defaultString(rs.getString("DEPT_CODE")));
				jso.put("coast_center", StringUtils.defaultString(rs.getString("COAST_CENTER")));
				jso.put("funds_dept", StringUtils.defaultString(rs.getString("FUNDS_DEPT")));
				jso.put("avaiable_budget", StringUtils.defaultString(rs.getString("AVAIABLE_BUDGET")));
				jso.put("budget_amount", StringUtils.defaultString(rs.getString("BUDGET_AMOUNT")));
				jso.put("reference", StringUtils.defaultString(rs.getString("REFERENCE")));
				jso.put("is_result", StringUtils.defaultString(rs.getString("IS_RESULT")));
				jso.put("cre_user", StringUtils.defaultString(rs.getString("CRE_USER")));
				jso.put("cre_date", StringUtils.defaultString(rs.getString("CRE_DATE")));
				jso.put("read_count", StringUtils.defaultString(rs.getString("READ_COUNT")));
				jso.put("real_att_file", StringUtils.defaultString(rs.getString("REAL_ATT_FILE")));
				jso.put("display_att_file", StringUtils.defaultString(rs.getString("DISPLAY_ATT_FILE")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdItemDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBdItem(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BD_ITEM(").append("\n");
		sql.append("        ITEM_NO ").append("\n");
		sql.append("       ,SCHEDULE_NO ").append("\n");
		sql.append("       ,COL ").append("\n");
		sql.append("       ,ITEM_DEVISION ").append("\n");
		sql.append("       ,ITEM_CODE2 ").append("\n");
		sql.append("       ,ITEM_CODE3 ").append("\n");
		sql.append("       ,ITEM_CODE4 ").append("\n");
		sql.append("       ,ITEM_NAME ").append("\n");
		sql.append("       ,APPROVAL_REQUEST ").append("\n");
		sql.append("       ,DEPT_CODE ").append("\n");
		sql.append("       ,COAST_CENTER ").append("\n");
		sql.append("       ,FUNDS_DEPT ").append("\n");
		sql.append("       ,AVAIABLE_BUDGET ").append("\n");
		sql.append("       ,BUDGET_AMOUNT ").append("\n");
		sql.append("       ,REFERENCE ").append("\n");
		sql.append("       ,IS_RESULT ").append("\n");
		sql.append("       ,CRE_USER ").append("\n");
		sql.append("       ,CRE_DATE ").append("\n");
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
			pstmt.setInt(1,jso.getInt("item_no"));
			pstmt.setInt(2,jso.getInt("schedule_no"));
			pstmt.setInt(3,jso.getInt("col"));
			pstmt.setString(4,jso.getString("item_devision"));
			pstmt.setString(5,jso.getString("item_code2"));
			pstmt.setString(6,jso.getString("item_code3"));
			pstmt.setString(7,jso.getString("item_code4"));
			pstmt.setString(8,jso.getString("item_name"));
			pstmt.setString(9,jso.getString("approval_request"));
			pstmt.setString(10,jso.getString("dept_code"));
			pstmt.setString(11,jso.getString("coast_center"));
			pstmt.setString(12,jso.getString("funds_dept"));
			pstmt.setInt(13,jso.getInt("avaiable_budget"));
			pstmt.setInt(14,jso.getInt("budget_amount"));
			pstmt.setString(15,jso.getString("reference"));
			pstmt.setString(16,jso.getString("is_result"));
			pstmt.setString(17,jso.getString("cre_user"));
			pstmt.setString(18,jso.getString("cre_date"));
			pstmt.setInt(19,jso.getInt("read_count"));
			pstmt.setString(20,jso.getString("real_att_file"));
			pstmt.setString(21,jso.getString("display_att_file"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBdItem 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBdItemUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BD_ITEM SET ").append("\n");
		sql.append("        SCHEDULE_NO = ? ").append("\n");
		sql.append("       ,COL = ? ").append("\n");
		sql.append("       ,ITEM_DEVISION = ? ").append("\n");
		sql.append("       ,ITEM_CODE2 = ? ").append("\n");
		sql.append("       ,ITEM_CODE3 = ? ").append("\n");
		sql.append("       ,ITEM_CODE4 = ? ").append("\n");
		sql.append("       ,ITEM_NAME = ? ").append("\n");
		sql.append("       ,APPROVAL_REQUEST = ? ").append("\n");
		sql.append("       ,DEPT_CODE = ? ").append("\n");
		sql.append("       ,COAST_CENTER = ? ").append("\n");
		sql.append("       ,FUNDS_DEPT = ? ").append("\n");
		sql.append("       ,AVAIABLE_BUDGET = ? ").append("\n");
		sql.append("       ,BUDGET_AMOUNT = ? ").append("\n");
		sql.append("       ,REFERENCE = ? ").append("\n");
		sql.append("       ,IS_RESULT = ? ").append("\n");
		sql.append("       ,CRE_USER = ? ").append("\n");
		sql.append("       ,CRE_DATE = ? ").append("\n");
		sql.append("       ,READ_COUNT = ? ").append("\n");
		sql.append("       ,REAL_ATT_FILE = ? ").append("\n");
		sql.append("       ,DISPLAY_ATT_FILE = ? ").append("\n");
		sql.append(" WHERE ITEM_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,jso.getInt("schedule_no"));
			pstmt.setInt(2,jso.getInt("col"));
			pstmt.setString(3,jso.getString("item_devision"));
			pstmt.setString(4,jso.getString("item_code2"));
			pstmt.setString(5,jso.getString("item_code3"));
			pstmt.setString(6,jso.getString("item_code4"));
			pstmt.setString(7,jso.getString("item_name"));
			pstmt.setString(8,jso.getString("approval_request"));
			pstmt.setString(9,jso.getString("dept_code"));
			pstmt.setString(10,jso.getString("coast_center"));
			pstmt.setString(11,jso.getString("funds_dept"));
			pstmt.setInt(12,jso.getInt("avaiable_budget"));
			pstmt.setInt(13,jso.getInt("budget_amount"));
			pstmt.setString(14,jso.getString("reference"));
			pstmt.setString(15,jso.getString("is_result"));
			pstmt.setString(16,jso.getString("cre_user"));
			pstmt.setString(17,jso.getString("cre_date"));
			pstmt.setInt(18,jso.getInt("read_count"));
			pstmt.setString(19,jso.getString("real_att_file"));
			pstmt.setString(20,jso.getString("display_att_file"));
			pstmt.setInt(21,jso.getInt("item_no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBdItemUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBdItem(int item_no) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BD_ITEM ").append("\n");
		sql.append(" WHERE ITEM_NO = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,item_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBdItem 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}