package softm.test;

import java.sql.SQLException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import softm.util.JDBCSupport;

import com.ibatis.sqlmap.client.SqlMapClient;

public class JDBCTest {
	
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws SQLException {
		
		System.out.println("========== Source ==========");
		
		SqlMapClient sourceClient = JDBCSupport.getSqlMapLocalInstance();
//		Map<String, String> params = new HashMap<String, String>(); 
		HashMap<String, String> params = new HashMap<String, String>(); 
		params.put("value", "TB_S07_020DEPT010");
		List<HashMap<String, Object>> result = sourceClient.queryForList("Common.findColumnInfo",params);
		
		for(HashMap<String, Object> row : result){
//			System.out.println(row);
			System.out.println(row.get("COLUMN_NAME"));
		}
	}
	
}
