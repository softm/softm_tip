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

public class DmsMemberDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getMemberList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT MEMBER_NO ").append("\n");
		sql.append("       ,KO_NAME ").append("\n");
		sql.append("       ,CH_NAME ").append("\n");
		sql.append("       ,EN_NAME ").append("\n");
		sql.append("       ,SCO_NO1 ").append("\n");
		sql.append("       ,SCO_NO2 ").append("\n");
		sql.append("       ,SEX ").append("\n");
		sql.append("       ,PLACE_BIRTH ").append("\n");
		sql.append("       ,TENURE_START ").append("\n");
		sql.append("       ,TENURE_END ").append("\n");
		sql.append("       ,MEMBER_PHOTO ").append("\n");
		sql.append("       ,BD_CODE ").append("\n");
		sql.append("       ,BD_CODE_ORDER ").append("\n");
		sql.append("       ,GROUP_NO ").append("\n");
		sql.append("       ,GROUP_NO_ORDER ").append("\n");
		sql.append("       ,OFFICE_ADDRESS ").append("\n");
		sql.append("       ,OFFICE_PHONE ").append("\n");
		sql.append("       ,OFFICE_FAX ").append("\n");
		sql.append("       ,HOME_ADDRESS ").append("\n");
		sql.append("       ,HOME_PHONE ").append("\n");
		sql.append("       ,CELLPHONE ").append("\n");
		sql.append("       ,EMAIL_CODE ").append("\n");
		sql.append("       ,EMAIL ").append("\n");
		sql.append("       ,BD_POSITION ").append("\n");
		sql.append("       ,GROUP_POSITION ").append("\n");
		sql.append("  FROM DMS_MEMBER ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jso.put("ko_name", StringUtils.defaultString(rs.getString("KO_NAME")));
				jso.put("ch_name", StringUtils.defaultString(rs.getString("CH_NAME")));
				jso.put("en_name", StringUtils.defaultString(rs.getString("EN_NAME")));
				jso.put("sco_no1", StringUtils.defaultString(rs.getString("SCO_NO1")));
				jso.put("sco_no2", StringUtils.defaultString(rs.getString("SCO_NO2")));
				jso.put("sex", StringUtils.defaultString(rs.getString("SEX")));
				jso.put("place_birth", StringUtils.defaultString(rs.getString("PLACE_BIRTH")));
				jso.put("tenure_start", StringUtils.defaultString(rs.getString("TENURE_START")));
				jso.put("tenure_end", StringUtils.defaultString(rs.getString("TENURE_END")));
				jso.put("member_photo", StringUtils.defaultString(rs.getString("MEMBER_PHOTO")));
				jso.put("bd_code", StringUtils.defaultString(rs.getString("BD_CODE")));
				jso.put("bd_code_order", StringUtils.defaultString(rs.getString("BD_CODE_ORDER")));
				jso.put("group_no", StringUtils.defaultString(rs.getString("GROUP_NO")));
				jso.put("group_no_order", StringUtils.defaultString(rs.getString("GROUP_NO_ORDER")));
				jso.put("office_address", StringUtils.defaultString(rs.getString("OFFICE_ADDRESS")));
				jso.put("office_phone", StringUtils.defaultString(rs.getString("OFFICE_PHONE")));
				jso.put("office_fax", StringUtils.defaultString(rs.getString("OFFICE_FAX")));
				jso.put("home_address", StringUtils.defaultString(rs.getString("HOME_ADDRESS")));
				jso.put("home_phone", StringUtils.defaultString(rs.getString("HOME_PHONE")));
				jso.put("cellphone", StringUtils.defaultString(rs.getString("CELLPHONE")));
				jso.put("email_code", StringUtils.defaultString(rs.getString("EMAIL_CODE")));
				jso.put("email", StringUtils.defaultString(rs.getString("EMAIL")));
				jso.put("bd_position", StringUtils.defaultString(rs.getString("BD_POSITION")));
				jso.put("group_position", StringUtils.defaultString(rs.getString("GROUP_POSITION")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getMemberDetail(int member_no) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT MEMBER_NO ").append("\n");
		sql.append("       ,KO_NAME ").append("\n");
		sql.append("       ,CH_NAME ").append("\n");
		sql.append("       ,EN_NAME ").append("\n");
		sql.append("       ,SCO_NO1 ").append("\n");
		sql.append("       ,SCO_NO2 ").append("\n");
		sql.append("       ,SEX ").append("\n");
		sql.append("       ,PLACE_BIRTH ").append("\n");
		sql.append("       ,TENURE_START ").append("\n");
		sql.append("       ,TENURE_END ").append("\n");
		sql.append("       ,MEMBER_PHOTO ").append("\n");
		sql.append("       ,BD_CODE ").append("\n");
		sql.append("       ,BD_CODE_ORDER ").append("\n");
		sql.append("       ,GROUP_NO ").append("\n");
		sql.append("       ,GROUP_NO_ORDER ").append("\n");
		sql.append("       ,OFFICE_ADDRESS ").append("\n");
		sql.append("       ,OFFICE_PHONE ").append("\n");
		sql.append("       ,OFFICE_FAX ").append("\n");
		sql.append("       ,HOME_ADDRESS ").append("\n");
		sql.append("       ,HOME_PHONE ").append("\n");
		sql.append("       ,CELLPHONE ").append("\n");
		sql.append("       ,EMAIL_CODE ").append("\n");
		sql.append("       ,EMAIL ").append("\n");
		sql.append("       ,BD_POSITION ").append("\n");
		sql.append("       ,GROUP_POSITION ").append("\n");
		sql.append("  FROM DMS_MEMBER ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,member_no);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jso.put("ko_name", StringUtils.defaultString(rs.getString("KO_NAME")));
				jso.put("ch_name", StringUtils.defaultString(rs.getString("CH_NAME")));
				jso.put("en_name", StringUtils.defaultString(rs.getString("EN_NAME")));
				jso.put("sco_no1", StringUtils.defaultString(rs.getString("SCO_NO1")));
				jso.put("sco_no2", StringUtils.defaultString(rs.getString("SCO_NO2")));
				jso.put("sex", StringUtils.defaultString(rs.getString("SEX")));
				jso.put("place_birth", StringUtils.defaultString(rs.getString("PLACE_BIRTH")));
				jso.put("tenure_start", StringUtils.defaultString(rs.getString("TENURE_START")));
				jso.put("tenure_end", StringUtils.defaultString(rs.getString("TENURE_END")));
				jso.put("member_photo", StringUtils.defaultString(rs.getString("MEMBER_PHOTO")));
				jso.put("bd_code", StringUtils.defaultString(rs.getString("BD_CODE")));
				jso.put("bd_code_order", StringUtils.defaultString(rs.getString("BD_CODE_ORDER")));
				jso.put("group_no", StringUtils.defaultString(rs.getString("GROUP_NO")));
				jso.put("group_no_order", StringUtils.defaultString(rs.getString("GROUP_NO_ORDER")));
				jso.put("office_address", StringUtils.defaultString(rs.getString("OFFICE_ADDRESS")));
				jso.put("office_phone", StringUtils.defaultString(rs.getString("OFFICE_PHONE")));
				jso.put("office_fax", StringUtils.defaultString(rs.getString("OFFICE_FAX")));
				jso.put("home_address", StringUtils.defaultString(rs.getString("HOME_ADDRESS")));
				jso.put("home_phone", StringUtils.defaultString(rs.getString("HOME_PHONE")));
				jso.put("cellphone", StringUtils.defaultString(rs.getString("CELLPHONE")));
				jso.put("email_code", StringUtils.defaultString(rs.getString("EMAIL_CODE")));
				jso.put("email", StringUtils.defaultString(rs.getString("EMAIL")));
				jso.put("bd_position", StringUtils.defaultString(rs.getString("BD_POSITION")));
				jso.put("group_position", StringUtils.defaultString(rs.getString("GROUP_POSITION")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertMember(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_MEMBER(").append("\n");
		sql.append("        MEMBER_NO ").append("\n");
		sql.append("       ,KO_NAME ").append("\n");
		sql.append("       ,CH_NAME ").append("\n");
		sql.append("       ,EN_NAME ").append("\n");
		sql.append("       ,SCO_NO1 ").append("\n");
		sql.append("       ,SCO_NO2 ").append("\n");
		sql.append("       ,SEX ").append("\n");
		sql.append("       ,PLACE_BIRTH ").append("\n");
		sql.append("       ,TENURE_START ").append("\n");
		sql.append("       ,TENURE_END ").append("\n");
		sql.append("       ,MEMBER_PHOTO ").append("\n");
		sql.append("       ,BD_CODE ").append("\n");
		sql.append("       ,BD_CODE_ORDER ").append("\n");
		sql.append("       ,GROUP_NO ").append("\n");
		sql.append("       ,GROUP_NO_ORDER ").append("\n");
		sql.append("       ,OFFICE_ADDRESS ").append("\n");
		sql.append("       ,OFFICE_PHONE ").append("\n");
		sql.append("       ,OFFICE_FAX ").append("\n");
		sql.append("       ,HOME_ADDRESS ").append("\n");
		sql.append("       ,HOME_PHONE ").append("\n");
		sql.append("       ,CELLPHONE ").append("\n");
		sql.append("       ,EMAIL_CODE ").append("\n");
		sql.append("       ,EMAIL ").append("\n");
		sql.append("       ,BD_POSITION ").append("\n");
		sql.append("       ,GROUP_POSITION ").append("\n");
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
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append("        ,? ").append("\n");
		sql.append(" );  ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,jso.getInt("member_no"));
			pstmt.setString(2,jso.getString("ko_name"));
			pstmt.setString(3,jso.getString("ch_name"));
			pstmt.setString(4,jso.getString("en_name"));
			pstmt.setString(5,jso.getString("sco_no1"));
			pstmt.setString(6,jso.getString("sco_no2"));
			pstmt.setString(7,jso.getString("sex"));
			pstmt.setString(8,jso.getString("place_birth"));
			pstmt.setString(9,jso.getString("tenure_start"));
			pstmt.setString(10,jso.getString("tenure_end"));
			pstmt.setString(11,jso.getString("member_photo"));
			pstmt.setString(12,jso.getString("bd_code"));
			pstmt.setInt(13,jso.getInt("bd_code_order"));
			pstmt.setString(14,jso.getString("group_no"));
			pstmt.setInt(15,jso.getInt("group_no_order"));
			pstmt.setString(16,jso.getString("office_address"));
			pstmt.setString(17,jso.getString("office_phone"));
			pstmt.setString(18,jso.getString("office_fax"));
			pstmt.setString(19,jso.getString("home_address"));
			pstmt.setString(20,jso.getString("home_phone"));
			pstmt.setString(21,jso.getString("cellphone"));
			pstmt.setString(22,jso.getString("email_code"));
			pstmt.setString(23,jso.getString("email"));
			pstmt.setString(24,jso.getString("bd_position"));
			pstmt.setString(25,jso.getString("group_position"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertMember 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getMemberUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_MEMBER SET ").append("\n");
		sql.append("        KO_NAME = ? ").append("\n");
		sql.append("       ,CH_NAME = ? ").append("\n");
		sql.append("       ,EN_NAME = ? ").append("\n");
		sql.append("       ,SCO_NO1 = ? ").append("\n");
		sql.append("       ,SCO_NO2 = ? ").append("\n");
		sql.append("       ,SEX = ? ").append("\n");
		sql.append("       ,PLACE_BIRTH = ? ").append("\n");
		sql.append("       ,TENURE_START = ? ").append("\n");
		sql.append("       ,TENURE_END = ? ").append("\n");
		sql.append("       ,MEMBER_PHOTO = ? ").append("\n");
		sql.append("       ,BD_CODE = ? ").append("\n");
		sql.append("       ,BD_CODE_ORDER = ? ").append("\n");
		sql.append("       ,GROUP_NO = ? ").append("\n");
		sql.append("       ,GROUP_NO_ORDER = ? ").append("\n");
		sql.append("       ,OFFICE_ADDRESS = ? ").append("\n");
		sql.append("       ,OFFICE_PHONE = ? ").append("\n");
		sql.append("       ,OFFICE_FAX = ? ").append("\n");
		sql.append("       ,HOME_ADDRESS = ? ").append("\n");
		sql.append("       ,HOME_PHONE = ? ").append("\n");
		sql.append("       ,CELLPHONE = ? ").append("\n");
		sql.append("       ,EMAIL_CODE = ? ").append("\n");
		sql.append("       ,EMAIL = ? ").append("\n");
		sql.append("       ,BD_POSITION = ? ").append("\n");
		sql.append("       ,GROUP_POSITION = ? ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("ko_name"));
			pstmt.setString(2,jso.getString("ch_name"));
			pstmt.setString(3,jso.getString("en_name"));
			pstmt.setString(4,jso.getString("sco_no1"));
			pstmt.setString(5,jso.getString("sco_no2"));
			pstmt.setString(6,jso.getString("sex"));
			pstmt.setString(7,jso.getString("place_birth"));
			pstmt.setString(8,jso.getString("tenure_start"));
			pstmt.setString(9,jso.getString("tenure_end"));
			pstmt.setString(10,jso.getString("member_photo"));
			pstmt.setString(11,jso.getString("bd_code"));
			pstmt.setInt(12,jso.getInt("bd_code_order"));
			pstmt.setString(13,jso.getString("group_no"));
			pstmt.setInt(14,jso.getInt("group_no_order"));
			pstmt.setString(15,jso.getString("office_address"));
			pstmt.setString(16,jso.getString("office_phone"));
			pstmt.setString(17,jso.getString("office_fax"));
			pstmt.setString(18,jso.getString("home_address"));
			pstmt.setString(19,jso.getString("home_phone"));
			pstmt.setString(20,jso.getString("cellphone"));
			pstmt.setString(21,jso.getString("email_code"));
			pstmt.setString(22,jso.getString("email"));
			pstmt.setString(23,jso.getString("bd_position"));
			pstmt.setString(24,jso.getString("group_position"));
			pstmt.setInt(25,jso.getInt("member_no"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getMemberUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteMember(int member_no) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_MEMBER ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,member_no);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteMember 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}