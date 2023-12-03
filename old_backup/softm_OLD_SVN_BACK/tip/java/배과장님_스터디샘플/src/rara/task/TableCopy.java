package rara.task;

import java.sql.SQLException;
import java.util.HashMap;
import java.util.List;

import rara.util.JDBCSupport;

import com.ibatis.sqlmap.client.SqlMapClient;

public class TableCopy {

	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws SQLException {
		
		
		String[] tableNames = {"TB_S07_020DEPT010","TB_S07_020EMPL010","TB_S07_020APRV010",
				               "TB_S07_020APRV020","TB_S07_020CODE010","TB_S07_020ADMN010","TB_S07_020WEEK010"};
		
		SqlMapClient sourceClient = JDBCSupport.getSqlMapSourceInstance();
		SqlMapClient targetClient = JDBCSupport.getSqlMapTargetInstance();
		
		for(String tableName : tableNames){
			
			System.out.println();
			
			System.out.println("========== Source ["+tableName+"] ==========");
			
			List<HashMap<String, Object>> result = sourceClient.queryForList(tableName + ".findAll");
			
			for(HashMap<String, Object> row : result){
				System.out.println(row);
			}
			
			System.out.println();
			
			System.out.println("========== Target ["+tableName+"] ==========");
			
			//targetClient.delete(tableName + ".delete");
			//System.out.println("deleted : " + tableName);
			
			for(HashMap<String, Object> row : result){
				row.put("COMPANY_CODE", "POSCOICT");
				targetClient.insert(tableName + ".create", row);
				System.out.println("created : " + row);
			}
		
		}
		
	}

}
