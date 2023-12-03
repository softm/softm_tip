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

public class DmsIfMeasureDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getIfMeasureList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT FIELD_CD ").append("\n");
		sql.append("       ,FIELD_NAME ").append("\n");
		sql.append("       ,SECTION_CD ").append("\n");
		sql.append("       ,SECTION_NAME ").append("\n");
		sql.append("       ,PROGRAM_CD ").append("\n");
		sql.append("       ,PROGRAM_NAME ").append("\n");
		sql.append("       ,BUSINESS_CD ").append("\n");
		sql.append("       ,BUSINESS_NAME ").append("\n");
		sql.append("       ,MEASURE_CD ").append("\n");
		sql.append("       ,MEASURE_NAME ").append("\n");
		sql.append("  FROM DMS_IF_MEASURE ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("field_cd", StringUtils.defaultString(rs.getString("FIELD_CD")));
				jso.put("field_name", StringUtils.defaultString(rs.getString("FIELD_NAME")));
				jso.put("section_cd", StringUtils.defaultString(rs.getString("SECTION_CD")));
				jso.put("section_name", StringUtils.defaultString(rs.getString("SECTION_NAME")));
				jso.put("program_cd", StringUtils.defaultString(rs.getString("PROGRAM_CD")));
				jso.put("program_name", StringUtils.defaultString(rs.getString("PROGRAM_NAME")));
				jso.put("business_cd", StringUtils.defaultString(rs.getString("BUSINESS_CD")));
				jso.put("business_name", StringUtils.defaultString(rs.getString("BUSINESS_NAME")));
				jso.put("measure_cd", StringUtils.defaultString(rs.getString("MEASURE_CD")));
				jso.put("measure_name", StringUtils.defaultString(rs.getString("MEASURE_NAME")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getIfMeasureList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getIfMeasureDetail() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT FIELD_CD ").append("\n");
		sql.append("       ,FIELD_NAME ").append("\n");
		sql.append("       ,SECTION_CD ").append("\n");
		sql.append("       ,SECTION_NAME ").append("\n");
		sql.append("       ,PROGRAM_CD ").append("\n");
		sql.append("       ,PROGRAM_NAME ").append("\n");
		sql.append("       ,BUSINESS_CD ").append("\n");
		sql.append("       ,BUSINESS_NAME ").append("\n");
		sql.append("       ,MEASURE_CD ").append("\n");
		sql.append("       ,MEASURE_NAME ").append("\n");
		sql.append("  FROM DMS_IF_MEASURE ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("field_cd", StringUtils.defaultString(rs.getString("FIELD_CD")));
				jso.put("field_name", StringUtils.defaultString(rs.getString("FIELD_NAME")));
				jso.put("section_cd", StringUtils.defaultString(rs.getString("SECTION_CD")));
				jso.put("section_name", StringUtils.defaultString(rs.getString("SECTION_NAME")));
				jso.put("program_cd", StringUtils.defaultString(rs.getString("PROGRAM_CD")));
				jso.put("program_name", StringUtils.defaultString(rs.getString("PROGRAM_NAME")));
				jso.put("business_cd", StringUtils.defaultString(rs.getString("BUSINESS_CD")));
				jso.put("business_name", StringUtils.defaultString(rs.getString("BUSINESS_NAME")));
				jso.put("measure_cd", StringUtils.defaultString(rs.getString("MEASURE_CD")));
				jso.put("measure_name", StringUtils.defaultString(rs.getString("MEASURE_NAME")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getIfMeasureDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertIfMeasure(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_IF_MEASURE(").append("\n");
		sql.append("        FIELD_CD ").append("\n");
		sql.append("       ,FIELD_NAME ").append("\n");
		sql.append("       ,SECTION_CD ").append("\n");
		sql.append("       ,SECTION_NAME ").append("\n");
		sql.append("       ,PROGRAM_CD ").append("\n");
		sql.append("       ,PROGRAM_NAME ").append("\n");
		sql.append("       ,BUSINESS_CD ").append("\n");
		sql.append("       ,BUSINESS_NAME ").append("\n");
		sql.append("       ,MEASURE_CD ").append("\n");
		sql.append("       ,MEASURE_NAME ").append("\n");
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
		sql.append(" );  ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("field_cd"));
			pstmt.setString(2,jso.getString("field_name"));
			pstmt.setString(3,jso.getString("section_cd"));
			pstmt.setString(4,jso.getString("section_name"));
			pstmt.setString(5,jso.getString("program_cd"));
			pstmt.setString(6,jso.getString("program_name"));
			pstmt.setString(7,jso.getString("business_cd"));
			pstmt.setString(8,jso.getString("business_name"));
			pstmt.setString(9,jso.getString("measure_cd"));
			pstmt.setString(10,jso.getString("measure_name"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertIfMeasure 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getIfMeasureUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_IF_MEASURE SET ").append("\n");
		sql.append("        FIELD_CD = ? ").append("\n");
		sql.append("       ,FIELD_NAME = ? ").append("\n");
		sql.append("       ,SECTION_CD = ? ").append("\n");
		sql.append("       ,SECTION_NAME = ? ").append("\n");
		sql.append("       ,PROGRAM_CD = ? ").append("\n");
		sql.append("       ,PROGRAM_NAME = ? ").append("\n");
		sql.append("       ,BUSINESS_CD = ? ").append("\n");
		sql.append("       ,BUSINESS_NAME = ? ").append("\n");
		sql.append("       ,MEASURE_CD = ? ").append("\n");
		sql.append("       ,MEASURE_NAME = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("field_cd"));
			pstmt.setString(2,jso.getString("field_name"));
			pstmt.setString(3,jso.getString("section_cd"));
			pstmt.setString(4,jso.getString("section_name"));
			pstmt.setString(5,jso.getString("program_cd"));
			pstmt.setString(6,jso.getString("program_name"));
			pstmt.setString(7,jso.getString("business_cd"));
			pstmt.setString(8,jso.getString("business_name"));
			pstmt.setString(9,jso.getString("measure_cd"));
			pstmt.setString(10,jso.getString("measure_name"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getIfMeasureUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteIfMeasure() {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_IF_MEASURE ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteIfMeasure 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}