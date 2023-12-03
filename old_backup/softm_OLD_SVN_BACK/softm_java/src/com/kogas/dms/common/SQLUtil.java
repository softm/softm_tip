package com.kogas.dms.common;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import javax.naming.InitialContext;
import javax.naming.NamingException;
import javax.sql.DataSource;

public class SQLUtil{

	private Connection con = null;
	private PreparedStatement pstmt = null;
	private Statement stmt = null;
	private ResultSet rs = null;

	// connection을 가져옵니다.
	public SQLUtil() throws SQLException, NamingException{
        try {
            InitialContext ic = new InitialContext();
            javax.naming.Context envContext = (javax.naming.Context)ic.lookup("java:/comp/env");
            DataSource ds = (DataSource) envContext.lookup("jdbc/kogas");
            con = ds.getConnection();
        } catch (SQLException ex) {
            Util.logger.fatal(Base.class.getName());
        }		
	}

	// PreparedStatement에 쿼리문을 넣어줍니다.
	public void setQuery(String query) throws SQLException{
		pstmt = con.prepareStatement(query);
	}
	// PreparedStatement 이용시 Data Type이 int 형일 경우
	public void setInt(int index, int value) throws SQLException{
		pstmt.setInt(index, value);
	}
	// PreparedStatement 이용시 Data Type이 String 형일 경우
	public void setString(int index, String value) throws SQLException{
		pstmt.setString(index, value);
	}
	// PreparedStatement 에서 Delete, Update, Insert 쿼리를 수행할 경우
	public int executeUpdate() throws SQLException{
		return(pstmt.executeUpdate());
	}
	// PreparedStatement 에서 Select 쿼리를 수행하는 경우 Rs형 객체 리턴
	public ResultSet executeQuery() throws SQLException{
		rs = pstmt.executeQuery();
		return rs;
	}
	// Statement 객체 사용시 Delete, Update, Insert  쿼리 수행
	public int executeUpdate(String  query) throws SQLException{
		stmt=con.createStatement();
		return (stmt.executeUpdate(query));
	}
	// Statement 객체의 Select 쿼리 수행시
	public ResultSet executeQuery(String query) throws SQLException{
		stmt = con.createStatement();
		rs = stmt.executeQuery(query);
		return rs;
	}
	public void subclose(){
		if(rs != null){
			try{
				rs.close();
			}catch(SQLException e){
				e.printStackTrace();
			}
		}
		if(pstmt != null){
			try{	
				pstmt.close();
			}catch(SQLException e){
				e.printStackTrace();
			}
		}
		if(stmt != null){
			try{
				stmt.close();
			}catch(SQLException e){
				e.printStackTrace();
			}
		}
	}
	public void close(){
		subclose();
		if(con != null){
			try{
				con.close();
			}catch(SQLException e){
				e.printStackTrace();
			}
		}
	}
}
