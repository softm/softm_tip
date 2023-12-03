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

public class DmsBdScheduleDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getBdScheduleList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT SCHEDULE_NO ").append("\n");
		sql.append("       ,BD_NO ").append("\n");
		sql.append("       ,GUBUN_CODE ").append("\n");
		sql.append("       ,NAME_CODE ").append("\n");
		sql.append("       ,BD_START_DAY ").append("\n");
		sql.append("       ,BD_END_DAY ").append("\n");
		sql.append("       ,BD_TIME ").append("\n");
		sql.append("       ,BD_PLACE ").append("\n");
		sql.append("  FROM DMS_BD_SCHEDULE ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("schedule_no", StringUtils.defaultString(rs.getString("SCHEDULE_NO")));
				jso.put("bd_no", StringUtils.defaultString(rs.getString("BD_NO")));
				jso.put("gubun_code", StringUtils.defaultString(rs.getString("GUBUN_CODE")));
				jso.put("name_code", StringUtils.defaultString(rs.getString("NAME_CODE")));
				jso.put("bd_start_day", StringUtils.defaultString(rs.getString("BD_START_DAY")));
				jso.put("bd_end_day", StringUtils.defaultString(rs.getString("BD_END_DAY")));
				jso.put("bd_time", StringUtils.defaultString(rs.getString("BD_TIME")));
				jso.put("bd_place", StringUtils.defaultString(rs.getString("BD_PLACE")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdScheduleList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getBdScheduleDetail(int schedule_no) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT SCHEDULE_NO ").append("\n");
		sql.append("       ,BD_NO ").append("\n");
		sql.append("       ,GUBUN_CODE ").append("\n");
		sql.append("       ,NAME_CODE ").append("\n");
		sql.append("       ,BD_START_DAY ").append("\n");
		sql.append("       ,BD_END_DAY ").append("\n");
		sql.append("       ,BD_TIME ").append("\n");
		sql.append("       ,BD_PLACE ").append("\n");
		sql.append("  FROM DMS_BD_SCHEDULE ").append("\n");
		sql.append(" WHERE SCHEDULE_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,schedule_no);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("schedule_no", StringUtils.defaultString(rs.getString("SCHEDULE_NO")));
				jso.put("bd_no", StringUtils.defaultString(rs.getString("BD_NO")));
				jso.put("gubun_code", StringUtils.defaultString(rs.getString("GUBUN_CODE")));
				jso.put("name_code", StringUtils.defaultString(rs.getString("NAME_CODE")));
				jso.put("bd_start_day", StringUtils.defaultString(rs.getString("BD_START_DAY")));
				jso.put("bd_end_day", StringUtils.defaultString(rs.getString("BD_END_DAY")));
				jso.put("bd_time", StringUtils.defaultString(rs.getString("BD_TIME")));
				jso.put("bd_place", StringUtils.defaultString(rs.getString("BD_PLACE")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getBdScheduleDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertBdSchedule(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_BD_SCHEDULE(").append("\n");
		sql.append("        SCHEDULE_NO ").append("\n");
		sql.append("       ,BD_NO ").append("\n");
		sql.append("       ,GUBUN_CODE ").append("\n");
		sql.append("       ,NAME_CODE ").append("\n");
		sql.append("       ,BD_START_DAY ").append("\n");
		sql.append("       ,BD_END_DAY ").append("\n");
		sql.append("       ,BD_TIME ").append("\n");
		sql.append("       ,BD_PLACE ").append("\n");
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
			pstmt.setInt(1,jso.getInt("schedule_no"));
			pstmt.setInt(2,jso.getInt("bd_no"));
			pstmt.setString(3,jso.getString("gubun_code"));
			pstmt.setString(4,jso.getString("name_code"));
			pstmt.setString(5,jso.getString("bd_start_day"));
			pstmt.setString(6,jso.getString("bd_end_day"));
			pstmt.setString(7,jso.getString("bd_time"));
			pstmt.setString(8,jso.getString("bd_place"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertBdSchedule 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getBdScheduleUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_BD_SCHEDULE SET ").append("\n");
		sql.append("        BD_NO = ? ").append("\n");
		sql.append("       ,GUBUN_CODE = ? ").append("\n");
		sql.append("       ,NAME_CODE = ? ").append("\n");
		sql.append("       ,BD_START_DAY = ? ").append("\n");
		sql.append("       ,BD_END_DAY = ? ").append("\n");
		sql.append("       ,BD_TIME = ? ").append("\n");
		sql.append("       ,BD_PLACE = ? ").append("\n");
		sql.append(" WHERE SCHEDULE_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,jso.getInt("bd_no"));
			pstmt.setString(2,jso.getString("gubun_code"));
			pstmt.setString(3,jso.getString("name_code"));
			pstmt.setString(4,jso.getString("bd_start_day"));
			pstmt.setString(5,jso.getString("bd_end_day"));
			pstmt.setString(6,jso.getString("bd_time"));
			pstmt.setString(7,jso.getString("bd_place"));
			pstmt.setInt(8,jso.getInt("schedule_no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getBdScheduleUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteBdSchedule(int schedule_no) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_BD_SCHEDULE ").append("\n");
		sql.append(" WHERE SCHEDULE_NO = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,schedule_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteBdSchedule 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}