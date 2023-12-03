package rara.util;

import java.io.Reader;

import com.ibatis.common.resources.Resources;
import com.ibatis.sqlmap.client.SqlMapClient;
import com.ibatis.sqlmap.client.SqlMapClientBuilder;


public class JDBCSupport {

	private static final SqlMapClient sqlMapSource;
	private static final SqlMapClient sqlMapTarget;

	static {
		try {
			
			String resourceSource = "rara/config/source-SqlMapConfig.xml";
			String resourceTarget = "rara/config/target-SqlMapConfig.xml";
			
			Reader readerSource = Resources.getResourceAsReader(resourceSource);
			Reader readerTarget = Resources.getResourceAsReader(resourceTarget);
			
			sqlMapSource = SqlMapClientBuilder.buildSqlMapClient(readerSource);
			sqlMapTarget = SqlMapClientBuilder.buildSqlMapClient(readerTarget);
			
		} catch (Exception e) {
			e.printStackTrace();
			throw new RuntimeException("Error initializing class. Cause:" + e);
		}
	}

	public static SqlMapClient getSqlMapSourceInstance() {
		return sqlMapSource;
	}
	
	public static SqlMapClient getSqlMapTargetInstance() {
		return sqlMapTarget;
	}
	
}
