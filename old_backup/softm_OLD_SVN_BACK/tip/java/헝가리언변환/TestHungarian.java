package softm.test;

import java.sql.SQLException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.commons.lang.StringUtils;

import softm.util.JDBCSupport;

import com.ibatis.sqlmap.client.SqlMapClient;

public class TestHungarian {
	
	@SuppressWarnings("unchecked")
	public static void main(String[] args) throws SQLException {
		
		System.out.println("========== Source ==========");
		String str = "AA_BB";
		String arr[] = str.split("_");
		String rtn[] = new String[arr.length];
		int idx = -1;
		for( String data : arr ) {
			rtn[++idx] = (idx==0?data.toLowerCase().charAt(0):data.toUpperCase().charAt(0)) + data.toLowerCase().substring(1);
		}
		System.out.println(StringUtils.join(rtn, ""));
	}
}
