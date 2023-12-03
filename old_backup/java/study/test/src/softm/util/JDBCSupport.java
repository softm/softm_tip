package softm.util;

import java.io.Reader;

import com.ibatis.common.resources.Resources;
import com.ibatis.sqlmap.client.SqlMapClient;
import com.ibatis.sqlmap.client.SqlMapClientBuilder;


public class JDBCSupport {

	private static final SqlMapClient sqlMapLocal;

	static {
		try {
			String resourceLocal  = "softm/config/local-SqlMapConfig.xml";
			Reader readerLocal = Resources.getResourceAsReader(resourceLocal);
			sqlMapLocal  = SqlMapClientBuilder.buildSqlMapClient(readerLocal);
		} catch (Exception e) {
			e.printStackTrace();
			throw new RuntimeException("Error initializing class. Cause:" + e);
		}
	}

	public static SqlMapClient getSqlMapLocalInstance() {
		return sqlMapLocal;
	}
	
}
