package com.entropykorea.gas.gum.database;

import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.gum.AppContext;

public class DataUtil {
	
	public static Sqlite getSqlite() {
		return new Sqlite( AppContext.getSQLiteDatabase() );
	}
	
	public static boolean deleteTable( Sqlite sqlite, String table ) {
		String sql = "DELETE FROM " + table;
		return sqlite.execSql(sql);
	}

	public static boolean deleteTable( String table ) {
		Sqlite sqlite = new Sqlite( AppContext.getSQLiteDatabase() );
		String sql = "DELETE FROM " + table;
		return sqlite.execSql(sql);
	}

	public static boolean deleteAllData() {
		String[] tables = { "CODE", "PROVIDER", "AREA_CENTER", "GUM", "GUM_CUST" };

		Sqlite sqlite = getSqlite();
		for( String table : tables ) {
			if( !deleteTable( sqlite, table ) ) {
				return false;
			}
		}
		return true;
	}
	
	public static boolean isEmpty( String tableName ) {
		boolean rtn = false;
		Sqlite sqlite = getSqlite();
		Integer count = 0;
		String sql = "SELECT COUNT(*) AS COUNT FROM " + tableName;

		if( sqlite.rawQuery(sql) ) {
			count = sqlite.getValueInteger("COUNT");
			if( count == 0 ) {
				rtn = true;
			}
		}	
		sqlite.close();
		return rtn;
	}
	
	public static boolean setSended() {
		boolean rtn = false;
		Sqlite sqlite = getSqlite();
		String sql = "UPDATE GUM SET SEND_YN='Y' WHERE END_YN='Y'";

		if( sqlite.execSql(sql) ) {
			rtn = true;
		}	
		sqlite.close();
		return rtn;
	}
	
	public static boolean isSended( String read_idx ) {
		boolean rtn = false;
		Sqlite sqlite = getSqlite();
		String sql = "SELECT SEND_YN FROM GUM WHERE READ_IDX = '" + read_idx + "'";
		String string;

		if( sqlite.rawQuery(sql) ) {
			string = sqlite.getValue("SEND_YN");
			if( string.equals("Y") ) {
				rtn = true;
			}
		}	
		sqlite.close();
		return rtn;
	}

	public static boolean isEnded( String read_idx ) {
		boolean rtn = false;
		Sqlite sqlite = getSqlite();
		String sql = "SELECT END_YN FROM GUM WHERE READ_IDX = '" + read_idx + "'";
		String string;

		if( sqlite.rawQuery(sql) ) {
			string = sqlite.getValue("END_YN");
			if( string.equals("Y") ) {
				rtn = true;
			}
		}	
		sqlite.close();
		return rtn;
	}
	
	public static String findHouseNoByGmNo( String gm_no ) {
		Sqlite sqlite = getSqlite();
		String sql = "SELECT HOUSE_NO FROM GUM WHERE GM_NO = '" + gm_no + "'";
		String string = "";

		if( sqlite.rawQuery(sql) ) {
			if( sqlite.getCount() != 0 ) {
				string = sqlite.getValue("HOUSE_NO");
			}
		}	
		sqlite.close();
		return string;
	}
	
	public static String findReadIdxByGmNo( String gm_no ) {
		Sqlite sqlite = getSqlite();
		String sql = "SELECT READ_IDX FROM GUM WHERE GM_NO = '" + gm_no + "'";
		String string = "";

		if( sqlite.rawQuery(sql) ) {
			if( sqlite.getCount() != 0 ) {
				string = sqlite.getValue("READ_IDX");
			}
		}	
		sqlite.close();
		return string;
	}

}
