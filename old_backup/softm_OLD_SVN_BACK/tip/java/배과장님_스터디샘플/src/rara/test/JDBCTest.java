package rara.test;

import java.sql.SQLException;
import java.util.HashMap;
import java.util.List;

import rara.util.JDBCSupport;

import com.ibatis.sqlmap.client.SqlMapClient;

public class JDBCTest {
	
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws SQLException {
		
		System.out.println("========== Source ==========");
		
		SqlMapClient sourceClient = JDBCSupport.getSqlMapSourceInstance();
		List<HashMap<String, Object>> result = sourceClient.queryForList("Common.findColumnInfo","TB_S07_020DEPT010");
		
		for(HashMap<String, Object> row : result){
			System.out.println(row);
		}
		
		System.out.println();
		
		System.out.println("========== Target ==========");
		
		SqlMapClient targetClient = JDBCSupport.getSqlMapTargetInstance();
		List<HashMap<String, Object>> result2 = targetClient.queryForList("Common.findColumnInfo","TB_S07_020DEPT010");
		
		for(HashMap<String, Object> row : result2){
			System.out.println(row);
		}
	}
	
}
