package rara.task;

import java.sql.SQLException;
import java.util.HashMap;
import java.util.List;

import rara.util.JDBCSupport;

import com.ibatis.sqlmap.client.SqlMapClient;

public class TableSelect {

	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws SQLException {
		
		System.out.println("========== Table ==========");
		
		SqlMapClient client = JDBCSupport.getSqlMapTargetInstance();
		List<HashMap<String, Object>> result = client.queryForList("Common.findColumnComments");
		
		for(HashMap<String, Object> row : result){
			System.out.println(row);
		}
		
		
		
	}

}
