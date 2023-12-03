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

public class DmsMemberRewardDAO{

	protected Logger Log = Util.logger; 

	public JSONObject getMemberRewardList() throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;
		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT MEMBER_NO ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("       ,REWARD_DATE ").append("\n");
		sql.append("       ,REWARD_CONTEXT ").append("\n");
		sql.append("       ,REWARD_ORGAN ").append("\n");
		sql.append("       ,REWARD_DIVISION ").append("\n");
		sql.append("  FROM DMS_MEMBER_REWARD ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			JSONArray jsa = new JSONArray();

			while(rs.next()){
				JSONObject jso = new JSONObject();
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jso.put("seq", StringUtils.defaultString(rs.getString("SEQ")));
				jso.put("reward_date", StringUtils.defaultString(rs.getString("REWARD_DATE")));
				jso.put("reward_context", StringUtils.defaultString(rs.getString("REWARD_CONTEXT")));
				jso.put("reward_organ", StringUtils.defaultString(rs.getString("REWARD_ORGAN")));
				jso.put("reward_division", StringUtils.defaultString(rs.getString("REWARD_DIVISION")));
				jsa.put(jso);
			}

			jsr.put("data", jsa);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberRewardList 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public JSONObject getMemberRewardDetail(int member_no, String seq) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		JSONObject jsr = new JSONObject();
		StringBuffer sql = new StringBuffer();

		sql.append(" SELECT MEMBER_NO ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("       ,REWARD_DATE ").append("\n");
		sql.append("       ,REWARD_CONTEXT ").append("\n");
		sql.append("       ,REWARD_ORGAN ").append("\n");
		sql.append("       ,REWARD_DIVISION ").append("\n");
		sql.append("  FROM DMS_MEMBER_REWARD ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		sql.append("   AND SEQ = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,member_no);
//			pstmt.setInt(2,seq);
			rs = pstmt.executeQuery();

			JSONObject jso = new JSONObject();

			if(rs.next()){
				jso.put("member_no", StringUtils.defaultString(rs.getString("MEMBER_NO")));
				jso.put("seq", StringUtils.defaultString(rs.getString("SEQ")));
				jso.put("reward_date", StringUtils.defaultString(rs.getString("REWARD_DATE")));
				jso.put("reward_context", StringUtils.defaultString(rs.getString("REWARD_CONTEXT")));
				jso.put("reward_organ", StringUtils.defaultString(rs.getString("REWARD_ORGAN")));
				jso.put("reward_division", StringUtils.defaultString(rs.getString("REWARD_DIVISION")));
			}

			jsr.put("data", jso);
			return jsr;
		} catch(Exception ex) {
			System.out.println("getMemberRewardDetail 에러 : " + ex);
		} finally {
			if(rs != null)try{rs.close();}catch(SQLException ex){}
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return null;
	}


	public boolean insertMemberReward(JSONObject jso) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" INSERT INTO DMS_MEMBER_REWARD(").append("\n");
		sql.append("        MEMBER_NO ").append("\n");
		sql.append("       ,SEQ ").append("\n");
		sql.append("       ,REWARD_DATE ").append("\n");
		sql.append("       ,REWARD_CONTEXT ").append("\n");
		sql.append("       ,REWARD_ORGAN ").append("\n");
		sql.append("       ,REWARD_DIVISION ").append("\n");
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
			pstmt.setInt(1,jso.getInt("member_no"));
			pstmt.setInt(2,jso.getInt("seq"));
			pstmt.setString(3,jso.getString("reward_date"));
			pstmt.setString(4,jso.getString("reward_context"));
			pstmt.setString(5,jso.getString("reward_organ"));
			pstmt.setString(6,jso.getString("reward_division"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("insertMemberReward 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean getMemberRewardUpdate( JSONObject jso ) throws Exception {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;
		StringBuffer sql = new StringBuffer();

		sql.append(" UPDATE DMS_MEMBER_REWARD SET ").append("\n");
		sql.append("        REWARD_DATE = ? ").append("\n");
		sql.append("       ,REWARD_CONTEXT = ? ").append("\n");
		sql.append("       ,REWARD_ORGAN = ? ").append("\n");
		sql.append("       ,REWARD_DIVISION = ? ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		sql.append("   AND SEQ = ? ").append("\n");

		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1,jso.getString("reward_date"));
			pstmt.setString(2,jso.getString("reward_context"));
			pstmt.setString(3,jso.getString("reward_organ"));
			pstmt.setString(4,jso.getString("reward_division"));
			pstmt.setInt(5,jso.getInt("member_no"));
			pstmt.setInt(6,jso.getInt("seq"));
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("getMemberRewardUpdate 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


	public boolean deleteMemberReward(int member_no, String seq) {
		Connection con = null;
		PreparedStatement pstmt = null;
		int result = 0;

		StringBuffer sql = new StringBuffer();

		sql.append(" DELETE FROM DMS_MEMBER_REWARD ").append("\n");
		sql.append(" WHERE MEMBER_NO = ? ").append("\n");
		sql.append("   AND SEQ = ? ").append("\n");
		try {
			con = DBUtil.getConnection();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setInt(1,member_no);
//			pstmt.setInt(2,seq);
			result = pstmt.executeUpdate();
			if(result == 0) return false;

			return true;

		} catch(Exception ex) {
			System.out.println("deleteMemberReward 에러 : " + ex);
		} finally {
			if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}
			if(con != null)try{con.close();}catch(SQLException ex){}
		}

		return false;
	}


}