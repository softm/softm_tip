package rara.task;

import java.sql.SQLException;
import java.util.HashMap;
import java.util.List;

import rara.util.JDBCSupport;

import com.ibatis.sqlmap.client.SqlMapClient;

public class TB_S07_020EMPL010 {

	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws SQLException {
		
		System.out.println("========== Source ==========");
		
		SqlMapClient sourceClient = JDBCSupport.getSqlMapSourceInstance();
		List<HashMap<String, Object>> result = sourceClient.queryForList("TB_S07_020EMPL010.findAll");
		
		for(HashMap<String, Object> row : result){
			System.out.println(row);
		}
		
		System.out.println();
		
		System.out.println("========== Target ==========");
		
		SqlMapClient targetClient = JDBCSupport.getSqlMapTargetInstance();
		
		for(HashMap<String, Object> row : result){
			targetClient.insert("TB_S07_020EMPL010.create", row);
			System.out.println("created : " + row);
		}
		
		
	}

}
