package com.entropykorea.gas.main.database;

import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.main.AppContext;
import com.entropykorea.gas.main.common.DLog;

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
		String[] tables = { "USER", "CODE", "PROVIDER", "AREA_CENTER" };

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
	
	public static boolean getAuth( String user_id, String authName ) {
		boolean rtn = false;
		Sqlite sqlite = getSqlite();
		String sql = "SELECT * FROM USER WHERE USER_ID = '" + user_id + "'";
		String string;
		
		DLog.d(sql);
		if( sqlite.rawQuery(sql) ) {
			string = sqlite.getValue(authName);
			if( string.equals("Y") ) {
				rtn = true;
			}
		}	
		sqlite.close();
		return rtn;
	}
	
	public static boolean existUser( String user_id, String user_pw ) {
		boolean rtn = false;
		Sqlite sqlite = getSqlite();
		String sql = "SELECT * FROM USER WHERE USER_ID = '" + user_id + "' AND PW = '" + user_pw + "'" ;

		DLog.d(sql);
		if( sqlite.rawQuery(sql) ) {
			if( sqlite.getCount() > 0 ) {
				rtn = true;
			}
		}	
		sqlite.close();
		return rtn;
	}
	
	public static boolean existUser( String user_id ) {
		boolean rtn = false;
		Sqlite sqlite = getSqlite();
		String sql = "SELECT * FROM USER WHERE USER_ID = '" + user_id + "'" ;

		if( sqlite.rawQuery(sql) ) {
			if( sqlite.getCount() > 0 ) {
				rtn = true;
			}
		}	
		sqlite.close();
		return rtn;
	}

	public static boolean isSended( String house_no ) {
		boolean rtn = false;
		Sqlite sqlite = getSqlite();
		String sql = "SELECT SEND_YN FROM GUM WHERE HOUSE_NO = '" + house_no + "'";
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

	public static boolean isEnded( String house_no ) {
		boolean rtn = false;
		Sqlite sqlite = getSqlite();
		String sql = "SELECT END_YN FROM GUM WHERE HOUSE_NO = '" + house_no + "'";
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
	
}
