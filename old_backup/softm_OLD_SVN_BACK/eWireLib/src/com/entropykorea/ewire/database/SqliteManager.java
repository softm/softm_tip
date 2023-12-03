// upgarde
// 1. Get table list
// 2. for( number of tables )
//    ALTER TABLE tablename RENAME TO tablename_old;
// 3. Create Table
// 4. for( number of tables )
//    // get column names
//    PRAGMA table_info(tablename_old);
//    // insert into
//    INSERT INTO tablename ( talbename_old.field, ... )
//    SELECT * FROM talbename_old;
// 5. DROP talbename_old;
// 6. VACUUM

package com.entropykorea.ewire.database;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;

public class SqliteManager extends Sqlite {
	
	private final static String SQLITE_UPGRADE_TABLE_LIST = "SELECT name FROM sqlite_master WHERE type = 'table' AND name NOT IN ('android_metadata','sqlite_sequence') UNION SELECT name FROM SQLITE_TEMP_MASTER WHERE type = 'table'";
	private final static String SQLITE_UPGRADE_COLUMN_LIST = "PRAGMA table_info( %s )";
	private final static String SQLITE_UPGRADE_COLUMN_LIST_OLD = "PRAGMA table_info( %s_OLD )";
	private final static String SQLITE_UPGRADE_ALTER_TABLE = "ALTER TABLE %s RENAME TO %s_OLD";
	private final static String SQLITE_UPGRADE_DROP_TABLE = "DROP TABLE %s_OLD";
	private final static String SQLITE_UPGRADE_INSERT_TABLE_PRE = "INSERT INTO %s ( ";
	private final static String SQLITE_UPGRADE_INSERT_TABLE_POST = ") SELECT * FROM %s_OLD";
	private final static String SQLITE_UPGRADE_VACUUM = "VACUUM";
	
	private Context ctx = null;

	public SqliteManager( Context ctx, SQLiteDatabase sqliteDatabase ) {
		super( sqliteDatabase );
		this.ctx = ctx;
	}
	
	public int getVersion() {
		if( !rawQuery( "PRAGMA user_version" ) ){
			return 0;
		}
		return getValueInteger( "user_version" );
	}
	
	public boolean setVersion( int version ) {
		return execSql( "PRAGMA user_version = " + version );
	}
	
	public boolean setVersion( String version ) {
		return execSql( "PRAGMA user_version = " + version );
	}
	
	public boolean isVersionDiff( int version ) {
		int userVersion = getVersion();
		
		if( version == userVersion ) {
			return false;
		}
		return true;
	}
	
	public boolean isVersionDiff( String version ) {
		int nversion;
		try {
			nversion = Integer.parseInt(version);
		} catch (NumberFormatException e) {
			nversion = 0;
		}
		
		return isVersionDiff( nversion );
	}

	public boolean importSql( int resId ) {
		String[] sqlcommands = readRawTextFile( this.ctx, resId ).split("\\;");
		if( sqlcommands == null )
			return false;
		
		for( String sqlcommand : sqlcommands ) {
			execSql( sqlcommand );
		}
		return true;
	}
	
	public boolean importSql( String str ) {
		String[] sqlcommands = str.split("\\;");
		if( sqlcommands == null )
			return false;
		
		for( String sqlcommand : sqlcommands ) {
			execSql( sqlcommand );
		}
		return true;
	}

	// upgrade 
	private List<String> getTableList() {
		if( !rawQuery( SQLITE_UPGRADE_TABLE_LIST ) )
			return null;
		
		List<String> list = new ArrayList<String>();
		
		if( moveToFirst() ) {
			do {
				list.add( getValue("name") );
			} while ( moveToNext() );
		}
		
		return list;
	}

	private List<String> getColumnName( String table ) {
		
		String sql = String.format(SQLITE_UPGRADE_COLUMN_LIST_OLD, table );
		
		if( !rawQuery( sql ) )
			return null;
		
		List<String> list = new ArrayList<String>();
		
		if( moveToFirst() ) {
			do {
				list.add( getValue("name") );
			} while ( moveToNext() );
		}
		return list;
	}
	
	private boolean insertTableFromOldTable( List<String> tables ) {
		
		String sql = new String();
		List<String> fields;
		int len;
		
		for( String table : tables ) {			
			sql += String.format(SQLITE_UPGRADE_INSERT_TABLE_PRE, table );
			fields = getColumnName( table );
			len = fields.size();
			for( int i=0 ; i<len ; i++ ) {
				sql += fields.get(i);
				if( i<len-1 ) {
					sql += ",";
				}
			}
			sql += String.format(SQLITE_UPGRADE_INSERT_TABLE_POST, table );
			if( !execSql( sql ) ) {
				return false;
			}
			sql = "";
		}
		
		return true;
	}
	
	private boolean renameTables( List<String> list ) {
		String sql = new String();
		
		for( String str : list ) {
			sql = String.format(SQLITE_UPGRADE_ALTER_TABLE, str, str );
			if( !execSql( sql ) )
				return false;
		}
		
		return true;
	}
	
	private boolean dropTables( List<String> list ) {
		String sql = new String();
		
		for( String str : list ) {
			sql = String.format(SQLITE_UPGRADE_DROP_TABLE, str );
			if( !execSql( sql ) )
				return false;
		}
		
		return true;
	}

	public boolean upgradeTables( int resId, String user_version ) {
		if( upgradeTables( resId ) ) {
			return setVersion( user_version );
		}
		return false;
	}
	
	public boolean upgradeTables( int resId ) {
		boolean rtn;
		
		beginTransaction();
		
		rtn = _upgradeTables( resId );
		
		if( rtn ) {
			commit();
		} else {
			rollBack();
		}
		
		// 6. VACUUM
		if( !execSql( SQLITE_UPGRADE_VACUUM ) ) {
			return false;
		}
			
		return rtn;
	}

	private boolean _upgradeTables( int resId ) {
		
		// 1. Get table list
		List<String> tables = getTableList();
		
		// 2. for( number of tables )
		//    ALTER TABLE tablename RENAME TO tablename_old;
		if( !renameTables( tables ) ) {
			return false;
		}
		// 3. Create Table
		if( !importSql(resId) ) {
			return false;
		}
		// 4. for( number of tables )
		//    // get column names
		//    PRAGMA table_info(tablename_old);
		//    // insert into
		//    INSERT INTO tablename ( talbename_old.field, ... )
		//    SELECT * FROM talbename_old;
		if( !insertTableFromOldTable( tables ) ) {
			return false;
		}
		// 5. DROP talbename_old;
		if( !dropTables( tables ) ) {
			return false;
		}

		// move to after transaction
//		// 6. VACUUM
//		if( !execSql( SQLITE_UPGRADE_VACUUM ) ) {
//			return false;
//		}
		
		return true;
	}

	// util
	private String readRawTextFile(Context ctx, int resId )	{
		InputStream inputStream = ctx.getResources().openRawResource(resId);

		InputStreamReader inputreader = new InputStreamReader(inputStream);
		BufferedReader buffreader = new BufferedReader(inputreader);
		String line;
		StringBuilder text = new StringBuilder();

		try {
			while (( line = buffreader.readLine()) != null) {
				text.append(line);
				text.append('\n');
			}
		} catch (IOException e) {
			return null;
		}
		return text.toString();
	}	
}
