package com.kogas.dms.util;

import java.io.FileOutputStream;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;

import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.codehaus.jettison.json.JSONArray;
import org.codehaus.jettison.json.JSONObject;

import com.kogas.dms.common.DBUtil;
import com.kogas.dms.common.Util;

public class src_gean_dao2 {
	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		src_gean_dao2 start = new src_gean_dao2();
		String[] table_names = {"DMS_ADMIN",
				"DMS_BD_ATTEND_MEMBER",
				"DMS_BD_CODE",
				"DMS_BD_GROUP",
				"DMS_BD_GUBUN_CODE",
				"DMS_BD_HISTORY",
				"DMS_BD_ITEM",
				"DMS_BD_ITEM_CODE",
				"DMS_BD_ITEM_RESULT",
				"DMS_BD_ITEM_RESULT_CODE",
				"DMS_BD_NAME_CODE",
				"DMS_BD_PROCEEDINGS",
				"DMS_BD_REQUEST",
				"DMS_BD_RULE",
				"DMS_BD_SCHEDULE",
				"DMS_BD_SCHOOL_CODE",
				"DMS_BOARD_BASIC",
				"DMS_BOARD_CODE",
				"DMS_BOARD_LAW",
				"DMS_BOARD_NOTICE",
				"DMS_EMAIL_GROUP",
				"DMS_IF_BUDGET",
				"DMS_IF_MEASURE",
				"DMS_MEMBER",
				"DMS_MEMBER_ACADEMIC",
				"DMS_MEMBER_CAREER",
				"DMS_MEMBER_REWARD",
				"DMS_PROPEL_PRESENT"};
		//String[] table_names = {"DMS_BD_GROUP"};
		
		for(int i = 0; i < table_names.length;i++) {
			start.genProcess(table_names[i]);
		}
	}
	
	public void genProcess(String table_name) {
		StringBuffer sb = new StringBuffer();
		List<String[]> col_list = new ArrayList<String[]>();
		List<String[]> pk_list = new ArrayList<String[]>();
		String bean_name = null;
		
		sb.append("package com.kogas.dms.dao;").append("\n\n");
		sb.append("import java.sql.Connection;").append("\n");
		sb.append("import java.sql.PreparedStatement;").append("\n");
		sb.append("import java.sql.ResultSet;").append("\n");
		sb.append("import java.sql.SQLException;").append("\n\n");
		sb.append("import org.apache.commons.lang3.StringUtils;").append("\n");
		sb.append("import org.apache.log4j.Logger;").append("\n");
		sb.append("import org.codehaus.jettison.json.JSONArray;").append("\n");
		sb.append("import org.codehaus.jettison.json.JSONObject;").append("\n\n");
		sb.append("import com.kogas.dms.common.DBUtil;").append("\n");
		sb.append("import com.kogas.dms.common.Sql;").append("\n");
		sb.append("import com.kogas.dms.common.Util;").append("\n\n");
		col_list = getColsInfo(table_name);
		pk_list = getPkInfo(table_name);
		bean_name = getBeanName(table_name);
		String dao_name = bean_name.substring(0, bean_name.indexOf("Bean")) + "DAO";
		String file_name = dao_name + ".java";
		sb.append("public class ").append(dao_name).append("{\n\n");
		sb.append("\tprotected Logger Log = Util.logger; ").append("\n\n");
		sb.append(getListMethod(table_name, bean_name, col_list, pk_list)).append("\n\n");
		sb.append(getDetailMethod(table_name, bean_name, col_list, pk_list)).append("\n\n");
		sb.append(getinsMethod(table_name, bean_name, col_list, pk_list)).append("\n\n");
		sb.append(getupMethod(table_name, bean_name, col_list, pk_list)).append("\n\n");
		sb.append(getdelMethod(table_name, bean_name, col_list, pk_list)).append("\n\n");
		sb.append("}");
		
		System.out.println(sb.toString());
		writeFile(file_name, sb);
	}
	
	public List<String[]> getColsInfo(String table_name) {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		StringBuffer sql = new StringBuffer();
		List<String[]> list = new ArrayList<String[]>();

		try{
			sql.append("SELECT COLUMN_NAME, DATA_TYPE ").append("\n");
			sql.append("  FROM USER_TAB_COLS ").append("\n");
			sql.append(" WHERE TABLE_NAME = ?");

			con = connect();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1, table_name);
			rs = pstmt.executeQuery();

			while(rs.next()){
				String col_name = rs.getString("COLUMN_NAME");
				String data_type = rs.getString("DATA_TYPE");
				
				String[] info = {col_name, data_type};
				list.add(info);
			}
			return list;
		}catch(Exception ex){
			System.out.println("aaaa 에러 :" + ex);
		}finally{
			if(rs!=null) try{rs.close();}catch(SQLException ex){}
			if(pstmt!=null) try{pstmt.close();}catch(SQLException ex){}
			if(con!=null) try{con.close();}catch(SQLException ex){}
		}
		return list;
	}
	
	public List<String[]> getPkInfo(String table_name) {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		StringBuffer sql = new StringBuffer();
		List<String[]> list = new ArrayList<String[]>();

		try{
			sql.append("SELECT A.COLUMN_NAME, A.DATA_TYPE ").append("\n");
			sql.append("  FROM USER_TAB_COLS A, USER_CONS_COLUMNS B ").append("\n");
			sql.append(" WHERE A.TABLE_NAME = B.TABLE_NAME");
			sql.append("   AND A.COLUMN_NAME = B.COLUMN_NAME");
			sql.append("   AND A.TABLE_NAME = ?");
			sql.append("   AND B.CONSTRAINT_NAME LIKE 'PK_%'");

			con = connect();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1, table_name);
			rs = pstmt.executeQuery();

			while(rs.next()){
				String col_name = rs.getString("COLUMN_NAME");
				String data_type = rs.getString("DATA_TYPE");
				
				String[] info = {col_name, data_type};
				list.add(info);
			}
			return list;
		}catch(Exception ex){
			System.out.println("aaaa 에러 :" + ex);
		}finally{
			if(rs!=null) try{rs.close();}catch(SQLException ex){}
			if(pstmt!=null) try{pstmt.close();}catch(SQLException ex){}
			if(con!=null) try{con.close();}catch(SQLException ex){}
		}
		return list;
	}
	
	public String getBeanName(String table_name) {
		String[] tokens = table_name.toString().split("_");
		String bean_name = "";
		for (int i = 0; i < tokens.length; i++) {
			String tmpStr =  tokens[i];
			bean_name = bean_name + tmpStr.substring(0, 1) + tmpStr.substring(1, tmpStr.length()).toLowerCase();
		}
		bean_name = bean_name + "Bean";
		return bean_name;
	}
    
 
	public String getListMethod(String table_name, String bean_name, List<String[]> col_list, List<String[]> pk_list) {
		StringBuffer sb = new StringBuffer();
		
		String method_name = "get" + bean_name.substring(3, bean_name.indexOf("Bean")) + "List";
		
		sb.append("\t").append("public JSONObject ").append(method_name).append("() throws Exception {").append("\n");
		sb.append("\t\t").append("Connection con = null;").append("\n");
		sb.append("\t\t").append("PreparedStatement pstmt = null;").append("\n");
		sb.append("\t\t").append("ResultSet rs = null;").append("\n");
		sb.append("\t\t").append("JSONObject jsr = new JSONObject();").append("\n");
		sb.append("\t\t").append("StringBuffer sql = new StringBuffer();").append("\n\n");

		StringBuffer tmp1 = new StringBuffer();
		StringBuffer tmp2 = new StringBuffer();
		int col_seq = 0;
			
		tmp1.append("\t\t").append("sql.append(\" SELECT "); 
		
		for(int i = 0; i < col_list.size(); i++) {
			String[] info = (String[]) col_list.get(i);
	
			if(i == 0) tmp1.append(info[0]).append(" \").append(\"\\n\");").append("\n");
			else tmp1.append("\t\t").append("sql.append(\"       ," + info[0]).append(" \").append(\"\\n\");").append("\n");
			
			tmp2.append("\t\t\t\t").append("jso.put(\"").append(info[0].toLowerCase()).append("\", StringUtils.defaultString(rs.getString(\"").append(info[0]).append("\")));").append("\n");   
		}

		tmp1.append("\t\t").append("sql.append(\"  FROM ").append(table_name).append(" \").append(\"\\n\");").append("\n\n");
			
		sb.append(tmp1.toString());
		sb.append("\t\t").append("try {").append("\n");
		sb.append("\t\t\t").append("con = DBUtil.getConnection();").append("\n");
		sb.append("\t\t\t").append("pstmt = con.prepareStatement(sql.toString());").append("\n");
		sb.append("\t\t\t").append("rs = pstmt.executeQuery();").append("\n\n");
		sb.append("\t\t\t").append("JSONArray jsa = new JSONArray();").append("\n\n");
		sb.append("\t\t\t").append("while(rs.next()){").append("\n");
		sb.append("\t\t\t\t").append("JSONObject jso = new JSONObject();").append("\n");
		sb.append(tmp2.toString());
		sb.append("\t\t\t\t").append("jsa.put(jso);").append("\n");
		sb.append("\t\t\t").append("}").append("\n\n");
		sb.append("\t\t\t").append("jsr.put(\"data\", jsa);").append("\n");
		sb.append("\t\t\t").append("return jsr;").append("\n");
		sb.append("\t\t").append("} catch(Exception ex) {").append("\n");
		sb.append("\t\t\t").append("System.out.println(\"").append(method_name).append(" 에러 : \" + ex);").append("\n");
		sb.append("\t\t").append("} finally {").append("\n");
		sb.append("\t\t\t").append("if(rs != null)try{rs.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t\t").append("if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t\t").append("if(con != null)try{con.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t").append("}").append("\n");
		sb.append("\n");
		sb.append("\t\t").append("return null;").append("\n");
		sb.append("\t").append("}").append("\n");
		return sb.toString();
	}
	
	public String getDetailMethod(String table_name, String bean_name, List<String[]> col_list, List<String[]> pk_list) {
		StringBuffer sb = new StringBuffer();
		
		String method_name = "get" + bean_name.substring(3, bean_name.indexOf("Bean")) + "Detail";
		
		sb.append("\t").append("public JSONObject ").append(method_name).append("(");
	
		for(int i = 0; i < pk_list.size(); i++) {
			String[] pk = (String[]) pk_list.get(i);
			if(i == 0) {
				if(pk[1].equals("NUMBER")) sb.append("int ").append(pk[0].toLowerCase());
				else sb.append("String ").append(pk[0].toLowerCase());
			} else {
				if(pk[1].equals(", NUMBER")) sb.append("Int ").append(pk[0].toLowerCase());
				else sb.append(", String ").append(pk[0].toLowerCase());
			}
		}
		sb.append(") throws Exception {").append("\n");
		
		sb.append("\t\t").append("Connection con = null;").append("\n");
		sb.append("\t\t").append("PreparedStatement pstmt = null;").append("\n");
		sb.append("\t\t").append("ResultSet rs = null;").append("\n\n");
		sb.append("\t\t").append("JSONObject jsr = new JSONObject();").append("\n");
		sb.append("\t\t").append("StringBuffer sql = new StringBuffer();").append("\n\n");
		

		StringBuffer tmp1 = new StringBuffer();
		StringBuffer tmp2 = new StringBuffer();
		int col_seq = 0;
			
		tmp1.append("\t\t").append("sql.append(\" SELECT "); 
		
		for(int i = 0; i < col_list.size(); i++) {
			String[] info = (String[]) col_list.get(i);
	
			if(i == 0) tmp1.append(info[0]).append(" \").append(\"\\n\");").append("\n");
			else tmp1.append("\t\t").append("sql.append(\"       ," + info[0]).append(" \").append(\"\\n\");").append("\n");
				
			tmp2.append("\t\t\t\tjso.put(\"").append(info[0].toLowerCase()).append("\", StringUtils.defaultString(rs.getString(\"").append(info[0]).append("\")));").append("\n");
		}

		tmp1.append("\t\t").append("sql.append(\"  FROM ").append(table_name).append(" \").append(\"\\n\");").append("\n");
		
		for(int i = 0; i < pk_list.size(); i++) {
			String[] pk = (String[]) pk_list.get(i);
			if(i == 0) {
				tmp1.append("\t\t").append("sql.append(\" WHERE ").append(pk[0]).append(" = ? \").append(\"\\n\");").append("\n");
			} else {
				tmp1.append("\t\t").append("sql.append(\"   AND ").append(pk[0]).append(" = ? \").append(\"\\n\");").append("\n");
			}
		}
		tmp1.append("\n");
		
		sb.append(tmp1.toString());
		sb.append("\t\t").append("try {").append("\n");
		sb.append("\t\t\t").append("con = DBUtil.getConnection();").append("\n");
		sb.append("\t\t\t").append("pstmt = con.prepareStatement(sql.toString());").append("\n");
		
		for(int i = 0; i < pk_list.size(); i++) {
			String[] pk = (String[]) pk_list.get(i);
			if(pk[1].equals("NUMBER")) sb.append("\t\t\t").append("pstmt.setInt(").append(i+1).append(",").append(pk[0].toLowerCase()).append(");").append("\n");
			else sb.append("\t\t\t").append("pstmt.setString(").append(i+1).append(",").append(pk[0].toLowerCase()).append(");").append("\n");
		}
		sb.append("\t\t\t").append("rs = pstmt.executeQuery();").append("\n\n");
		sb.append("\t\t\t").append("JSONObject jso = new JSONObject();").append("\n\n");
		sb.append("\t\t\t").append("if(rs.next()){").append("\n");
		sb.append(tmp2.toString());
		sb.append("\t\t\t").append("}").append("\n\n");
		sb.append("\t\t\t").append("jsr.put(\"data\", jso);").append("\n") ;
		sb.append("\t\t\t").append("return jsr;").append("\n");
		sb.append("\t\t").append("} catch(Exception ex) {").append("\n");
		sb.append("\t\t\t").append("System.out.println(\"").append(method_name).append(" 에러 : \" + ex);").append("\n");
		sb.append("\t\t").append("} finally {").append("\n");
		sb.append("\t\t\t").append("if(rs != null)try{rs.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t\t").append("if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t\t").append("if(con != null)try{con.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t").append("}").append("\n");
		sb.append("\n");
		sb.append("\t\t").append("return null;").append("\n");
		sb.append("\t").append("}").append("\n");
		
		return sb.toString();
	}
	
	
	public String getinsMethod(String table_name, String bean_name, List<String[]> col_list, List<String[]> pk_list) {
		StringBuffer sb = new StringBuffer();
		
		String method_name = "insert" + bean_name.substring(3, bean_name.indexOf("Bean"));
		
		sb.append("\t").append("public boolean ").append(method_name).append("(JSONObject jso) {").append("\n");
		sb.append("\t\t").append("Connection con = null;").append("\n");
		sb.append("\t\t").append("PreparedStatement pstmt = null;").append("\n");
		sb.append("\t\t").append("int result = 0;").append("\n\n");
		sb.append("\t\t").append("StringBuffer sql = new StringBuffer();").append("\n\n");
		
		StringBuffer tmp1 = new StringBuffer();
		StringBuffer tmp2 = new StringBuffer();
		
		tmp1.append("\t\t").append("sql.append(\" INSERT INTO ").append(table_name).append("(\").append(\"\\n\");").append("\n");
		tmp2.append("\t\t").append("sql.append(\" VALUES (\").append(\"\\n\");").append("\n");
		
		for(int i = 0; i < col_list.size(); i++) {
			String[] info = (String[]) col_list.get(i);
	
			if(i == 0) {
				tmp1.append("\t\t").append("sql.append(\"        ").append(info[0]).append(" \").append(\"\\n\");").append("\n");
				tmp2.append("\t\t").append("sql.append(\"         ?").append(" \").append(\"\\n\");").append("\n");
			} else {
				tmp1.append("\t\t").append("sql.append(\"       ,").append(info[0]).append(" \").append(\"\\n\");").append("\n");
				tmp2.append("\t\t").append("sql.append(\"        ,?").append(" \").append(\"\\n\");").append("\n");
			}
		}
		sb.append(tmp1.toString());
		sb.append("\t\t").append("sql.append(\" ) ").append(" \").append(\"\\n\");").append("\n");
		sb.append(tmp2.toString());
		sb.append("\t\t").append("sql.append(\" ); ").append(" \").append(\"\\n\");").append("\n\n");
		
		sb.append("\t\t").append("try {").append("\n");
		sb.append("\t\t\t").append("con = DBUtil.getConnection();").append("\n");
		sb.append("\t\t\t").append("pstmt = con.prepareStatement(sql.toString());").append("\n");
		
		for(int i = 0; i < col_list.size(); i++) {
			String[] info = (String[]) col_list.get(i);
			if(info[1].equals("NUMBER")) sb.append("\t\t\t").append("pstmt.setInt(").append(i+1).append(",jso.getInt(\"").append(info[0].toLowerCase()).append("\"));").append("\n");
			else sb.append("\t\t\t").append("pstmt.setString(").append(i+1).append(",jso.getString(\"").append(info[0].toLowerCase()).append("\"));").append("\n");
		}
		
		sb.append("\t\t\t").append("result = pstmt.executeUpdate();").append("\n");
		sb.append("\t\t\t").append("if(result == 0) return false;").append("\n\n");
		sb.append("\t\t\t").append("return true;").append("\n\n");
		sb.append("\t\t").append("} catch(Exception ex) {").append("\n");
		sb.append("\t\t\t").append("System.out.println(\"").append(method_name).append(" 에러 : \" + ex);").append("\n");
		sb.append("\t\t").append("} finally {").append("\n");
		sb.append("\t\t\t").append("if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t\t").append("if(con != null)try{con.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t").append("}").append("\n");
		sb.append("\n");
		sb.append("\t\t").append("return false;").append("\n");
		sb.append("\t").append("}").append("\n");
		
		return sb.toString();
	}
	
	
	public String getupMethod(String table_name, String bean_name, List<String[]> col_list, List<String[]> pk_list) {
		StringBuffer sb = new StringBuffer();
		
		String method_name = "get" + bean_name.substring(3, bean_name.indexOf("Bean")) + "Update";
		
		sb.append("\t").append("public boolean ").append(method_name).append("( JSONObject jso ) throws Exception {").append("\n");
		
		sb.append("\t\t").append("Connection con = null;").append("\n");
		sb.append("\t\t").append("PreparedStatement pstmt = null;").append("\n");
		sb.append("\t\t").append("int result = 0;").append("\n");
		sb.append("\t\t").append("StringBuffer sql = new StringBuffer();").append("\n\n");
		

		StringBuffer tmp1 = new StringBuffer();
		StringBuffer tmp2 = new StringBuffer();
		int col_seq = 0;
			
		tmp1.append("\t\t").append("sql.append(\" UPDATE ").append(table_name).append(" SET \").append(\"\\n\");").append("\n");
		
		int startCol = 0;
		for(int i = 0; i < col_list.size(); i++) {
			String[] info = (String[]) col_list.get(i);
			
			boolean ispk = false;
			for(int j = 0; j < pk_list.size(); j++) {
				String[] pk = (String[]) pk_list.get(j);
				if(info[0].equals(pk[0])) ispk = true;
			}
			
			if(!ispk) {
				startCol++;
				col_seq++;
				if(startCol == 1) tmp1.append("\t\t").append("sql.append(\"        ").append(info[0]).append(" = ? \").append(\"\\n\");").append("\n"); 
				else tmp1.append("\t\t").append("sql.append(\"       ,").append(info[0]).append(" = ? \").append(\"\\n\");").append("\n");
				
				if(info[1].equals("NUMBER")) tmp2.append("\t\t\t").append("pstmt.setInt(").append(col_seq).append(",jso.getInt(\"").append(info[0].toLowerCase()).append("\"));").append("\n");
				else tmp2.append("\t\t\t").append("pstmt.setString(").append(col_seq).append(",jso.getString(\"").append(info[0].toLowerCase()).append("\"));").append("\n");
			}
		}
		
		for(int i = 0; i < pk_list.size(); i++) {
			String[] pk = (String[]) pk_list.get(i);
			if(i == 0) {
				tmp1.append("\t\t").append("sql.append(\" WHERE ").append(pk[0]).append(" = ? \").append(\"\\n\");").append("\n");
			} else {
				tmp1.append("\t\t").append("sql.append(\"   AND ").append(pk[0]).append(" = ? \").append(\"\\n\");").append("\n");
			}
		}
		tmp1.append("\n");
		
		sb.append(tmp1.toString());
		sb.append("\t\t").append("try {").append("\n");
		sb.append("\t\t\t").append("con = DBUtil.getConnection();").append("\n");
		sb.append("\t\t\t").append("pstmt = con.prepareStatement(sql.toString());").append("\n");
		sb.append(tmp2.toString());
		for(int i = 0; i < pk_list.size(); i++) {
			String[] pk = (String[]) pk_list.get(i);
			col_seq++;
			if(pk[1].equals("NUMBER")) sb.append("\t\t\t").append("pstmt.setInt(").append(col_seq).append(",jso.getInt(\"").append(pk[0].toLowerCase()).append("\"));").append("\n");
			else sb.append("\t\t\t").append("pstmt.setString(").append(col_seq).append(",jso.getString(\"").append(pk[0].toLowerCase()).append("\"));").append("\n");
		}
		sb.append("\t\t\t").append("result = pstmt.executeUpdate();").append("\n");
		sb.append("\t\t\t").append("if(result == 0) return false;").append("\n\n");
		sb.append("\t\t\t").append("return true;").append("\n\n");
		sb.append("\t\t").append("} catch(Exception ex) {").append("\n");
		sb.append("\t\t\t").append("System.out.println(\"").append(method_name).append(" 에러 : \" + ex);").append("\n");
		sb.append("\t\t").append("} finally {").append("\n");
		sb.append("\t\t\t").append("if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t\t").append("if(con != null)try{con.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t").append("}").append("\n");
		sb.append("\n");
		sb.append("\t\t").append("return false;").append("\n");
		sb.append("\t").append("}").append("\n");
		
		return sb.toString();
	}
	
	public String getdelMethod(String table_name, String bean_name, List<String[]> col_list, List<String[]> pk_list) {
		StringBuffer sb = new StringBuffer();
		
		String method_name = "delete" + bean_name.substring(3, bean_name.indexOf("Bean"));
		
		sb.append("\t").append("public boolean ").append(method_name).append("(");
		
		for(int i = 0; i < pk_list.size(); i++) {
			String[] pk = (String[]) pk_list.get(i);
			if(i == 0) {
				if(pk[1].equals("NUMBER")) sb.append("int ").append(pk[0].toLowerCase());
				else sb.append("String ").append(pk[0].toLowerCase());
			} else {
				if(pk[1].equals(", NUMBER")) sb.append("Int ").append(pk[0].toLowerCase());
				else sb.append(", String ").append(pk[0].toLowerCase());
			}
		}
		sb.append(") {").append("\n");
		
		sb.append("\t\t").append("Connection con = null;").append("\n");
		sb.append("\t\t").append("PreparedStatement pstmt = null;").append("\n");
		sb.append("\t\t").append("int result = 0;").append("\n\n");
		sb.append("\t\t").append("StringBuffer sql = new StringBuffer();").append("\n\n");
		
		StringBuffer tmp1 = new StringBuffer();
		StringBuffer tmp2 = new StringBuffer();
		
		tmp1.append("\t\t").append("sql.append(\" DELETE FROM ").append(table_name).append(" \").append(\"\\n\");").append("\n");
		
		for(int i = 0; i < pk_list.size(); i++) {
			String[] pk = (String[]) pk_list.get(i);
			if(i == 0) {
				tmp1.append("\t\t").append("sql.append(\" WHERE ").append(pk[0]).append(" = ? \").append(\"\\n\");").append("\n");
			} else {
				tmp1.append("\t\t").append("sql.append(\"   AND ").append(pk[0]).append(" = ? \").append(\"\\n\");").append("\n");
			}
		}
		sb.append(tmp1.toString());
		sb.append(tmp2.toString());
		sb.append("\t\t").append("try {").append("\n");
		sb.append("\t\t\t").append("con = DBUtil.getConnection();").append("\n");
		sb.append("\t\t\t").append("pstmt = con.prepareStatement(sql.toString());").append("\n");
		
		for(int i = 0; i < pk_list.size(); i++) {
			String[] pk = (String[]) pk_list.get(i);
			if(pk[1].equals("NUMBER")) sb.append("\t\t\t").append("pstmt.setInt(").append(i+1).append(",").append(pk[0].toLowerCase()).append(");").append("\n");
			else sb.append("\t\t\t").append("pstmt.setString(").append(i+1).append(",").append(pk[0].toLowerCase()).append(");").append("\n");
		}
		
		sb.append("\t\t\t").append("result = pstmt.executeUpdate();").append("\n");
		sb.append("\t\t\t").append("if(result == 0) return false;").append("\n\n");
		sb.append("\t\t\t").append("return true;").append("\n\n");
		sb.append("\t\t").append("} catch(Exception ex) {").append("\n");
		sb.append("\t\t\t").append("System.out.println(\"").append(method_name).append(" 에러 : \" + ex);").append("\n");
		sb.append("\t\t").append("} finally {").append("\n");
		sb.append("\t\t\t").append("if(pstmt != null)try{pstmt.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t\t").append("if(con != null)try{con.close();}catch(SQLException ex){}").append("\n");
		sb.append("\t\t").append("}").append("\n");
		sb.append("\n");
		sb.append("\t\t").append("return false;").append("\n");
		sb.append("\t").append("}").append("\n");
		
		return sb.toString();
	}
	

	public void writeFile(String file_name, StringBuffer sb) {
    	FileOutputStream fos = null;
        
        try {
           	fos = new FileOutputStream(new File("E:/98.PROJECT/KOGAS2/SRC_WORK/work/gen_src/" + file_name));
//           	fos = new FileOutputStream(new File("E:/98.PROJECT/KOGAS2/SRC_WORK/dao/" + file_name));
           	fos.write(sb.toString().getBytes());
        }
        catch (Exception e) {
        	e.printStackTrace();
        }
        finally {
        	try {
        		fos.close();
        	}
        	catch (IOException ex) {
        	}
        }
    }
	
	private Connection connect() {
		String CM_JDBC_DRIVER = "oracle.jdbc.driver.OracleDriver";
		
		String CM_JDBC_URL = "jdbc:oracle:thin:@localhost:1521:ORCL";
		String user = "oradms";
		String pwd = "oradms";
		
		try {
			Class.forName(CM_JDBC_DRIVER);

			Connection conn;
			conn = DriverManager.getConnection(CM_JDBC_URL, user, pwd);

			return conn;

		} catch (Exception e) {
			System.out.println("111===> " + e.getMessage());
			return null;
		}
	}
}
