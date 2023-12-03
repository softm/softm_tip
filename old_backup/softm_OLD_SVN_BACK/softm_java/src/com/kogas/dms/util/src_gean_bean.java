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

public class src_gean_bean {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		src_gean_bean start = new src_gean_bean();
		//start.genBEAN("ACL_INFO");
		start.genFullBean();
	}
	
	public void genFullBean() {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		StringBuffer sql = new StringBuffer();
		
		try{
			sql.append("SELECT TABLE_NAME FROM USER_TABLES WHERE TABLE_NAME LIKE 'DMS_BD_SCHEDULE'");

			con = connect();
			pstmt = con.prepareStatement(sql.toString());
			rs = pstmt.executeQuery();

			while(rs.next()){
				String table_name = rs.getString("TABLE_NAME");
				genBEAN(table_name);
			}
            
		}catch(Exception ex){
			System.out.println("aaaa 에러 :" + ex);
		}finally{
			if(rs!=null) try{rs.close();}catch(SQLException ex){}
			if(pstmt!=null) try{pstmt.close();}catch(SQLException ex){}
			if(con!=null) try{con.close();}catch(SQLException ex){}
		}
	}
	
	public void genDAO(String table_name) {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		StringBuffer sql = new StringBuffer();
		StringBuffer sb1 = new StringBuffer();
		StringBuffer sb2 = new StringBuffer();
		StringBuffer sbFull = new StringBuffer();
		
		try{
			sql.append("SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE ").append("\n");
			sql.append("  FROM USER_TAB_COLS ").append("\n");
			sql.append(" WHERE TABLE_NAME = ?");

			con = connect();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1, table_name);
			rs = pstmt.executeQuery();

			while(rs.next()){
				String col_name = rs.getString("COLUMN_NAME");
				String data_type = rs.getString("DATA_TYPE");
				
				if(data_type.equals("NUMBER")) {
					sb1.append("\t").append("private int ").append(col_name).append(";\n");
					
					sb2.append("\t").append("public void set").append(col_name).append("(int ").append(col_name.toLowerCase()).append(") {\n");
					sb2.append("\t\t").append(col_name).append(" = ").append(col_name.toLowerCase()).append(";\n");
					sb2.append("\t").append("}\n\n");
					sb2.append("\t").append("public int get").append(col_name).append("() { \n");
					sb2.append("\t\t").append("return ").append(col_name).append(";").append("\n");
					sb2.append("\t").append("}").append("\n\n");
				} else {
					sb1.append("\t").append("private String ").append(col_name).append(";\n");
					
					sb2.append("\t").append("public void set").append(col_name).append("(String ").append(col_name.toLowerCase()).append(") {\n");
					sb2.append("\t\t").append(col_name).append(" = ").append(col_name.toLowerCase()).append(";\n");
					sb2.append("\t").append("}\n\n");
					sb2.append("\t").append("public String get").append(col_name).append("() { \n");
					sb2.append("\t\t").append("return ").append(col_name).append(";").append("\n");
					sb2.append("\t").append("}").append("\n\n");
				}
			}
			
			String[] tokens = table_name.toString().split("_");
			String bean_name = "";
            for (int i = 0; i < tokens.length; i++) {
                  System.out.println(i + " :: " + tokens[i]);
                  String tmpStr =  tokens[i];
                  bean_name = bean_name + tmpStr.substring(0, 1) + tmpStr.substring(1, tmpStr.length()).toLowerCase();
            }
            bean_name = bean_name + "Bean";
            
            sbFull.append("package com.gims.db;\n\n");
            sbFull.append("public class ").append(bean_name).append(" {\n");
            sbFull.append(sb1.toString());
            sbFull.append("\n\n");
            sbFull.append(sb2.toString());
            sbFull.append("}");
            
            writeFile(bean_name+".java", sbFull);
            
		}catch(Exception ex){
			System.out.println("aaaa 에러 :" + ex);
		}finally{
			if(rs!=null) try{rs.close();}catch(SQLException ex){}
			if(pstmt!=null) try{pstmt.close();}catch(SQLException ex){}
			if(con!=null) try{con.close();}catch(SQLException ex){}
		}
	}
	
	public void genBEAN(String table_name) {
		Connection con = null;
		PreparedStatement pstmt = null;
		ResultSet rs = null;

		StringBuffer sql = new StringBuffer();
		StringBuffer sb1 = new StringBuffer();
		StringBuffer sb2 = new StringBuffer();
		StringBuffer sbFull = new StringBuffer();
		
		try{
			sql.append("SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE ").append("\n");
			sql.append("  FROM USER_TAB_COLS ").append("\n");
			sql.append(" WHERE TABLE_NAME = ?");

			con = connect();
			pstmt = con.prepareStatement(sql.toString());
			pstmt.setString(1, table_name);
			rs = pstmt.executeQuery();

			while(rs.next()){
				String col_name = rs.getString("COLUMN_NAME");
				String data_type = rs.getString("DATA_TYPE");
				
				System.out.println("col_name ===> " + col_name);
				System.out.println("data_type ===> " + data_type);
				
				if(data_type.equals("NUMBER")) {
					sb1.append("\t").append("private int ").append(col_name).append(";\n");
					
					sb2.append("\t").append("public void set").append(col_name).append("(int ").append(col_name.toLowerCase()).append(") {\n");
					sb2.append("\t\t").append(col_name).append(" = ").append(col_name.toLowerCase()).append(";\n");
					sb2.append("\t").append("}\n\n");
					sb2.append("\t").append("public int get").append(col_name).append("() { \n");
					sb2.append("\t\t").append("return ").append(col_name).append(";").append("\n");
					sb2.append("\t").append("}").append("\n\n");
				} else {
					sb1.append("\t").append("private String ").append(col_name).append(";\n");
					
					sb2.append("\t").append("public void set").append(col_name).append("(String ").append(col_name.toLowerCase()).append(") {\n");
					sb2.append("\t\t").append(col_name).append(" = ").append(col_name.toLowerCase()).append(";\n");
					sb2.append("\t").append("}\n\n");
					sb2.append("\t").append("public String get").append(col_name).append("() { \n");
					sb2.append("\t\t").append("return ").append(col_name).append(";").append("\n");
					sb2.append("\t").append("}").append("\n\n");
				}
			}
			
			String[] tokens = table_name.toString().split("_");
			String bean_name = "";
            for (int i = 0; i < tokens.length; i++) {
                  System.out.println(i + " :: " + tokens[i]);
                  String tmpStr =  tokens[i];
                  bean_name = bean_name + tmpStr.substring(0, 1) + tmpStr.substring(1, tmpStr.length()).toLowerCase();
            }
            bean_name = bean_name + "Bean";
            
            sbFull.append("package com.kogas.dms.bean;\n\n");
            sbFull.append("public class ").append(bean_name).append(" {\n");
            sbFull.append(sb1.toString());
            sbFull.append("\n\n");
            sbFull.append(sb2.toString());
            sbFull.append("}");
            
            writeFile(bean_name+".java", sbFull);
            
		}catch(Exception ex){
			System.out.println("aaaa 에러 :" + ex);
		}finally{
			if(rs!=null) try{rs.close();}catch(SQLException ex){}
			if(pstmt!=null) try{pstmt.close();}catch(SQLException ex){}
			if(con!=null) try{con.close();}catch(SQLException ex){}
		}
	}
	
	
	public void writeFile(String file_name, StringBuffer sb) {
    	FileOutputStream fos = null;
        
        try {
           	fos = new FileOutputStream(new File("D:/WEB_APP/eclipse_workspace/work/gen_data/bean/" + file_name));
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
		
		String CM_JDBC_URL = "jdbc:oracle:thin:@localhost:1521:KOGAS";
		String user = "system";
		String pwd = "1234";
		
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
