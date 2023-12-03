package com.entropykorea.ewire.database;

import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;

public class Sqlite {
	
	public final static String NULLVALUE = "";
	private SQLiteDatabase sqliteDatabase = null;
	private Cursor cursor = null;
	private int totalCount = 0;
	private String errorMessage;
	
	public Sqlite( SQLiteDatabase sqliteDatabase ) {
		this.sqliteDatabase = sqliteDatabase;
	}

	public void finalize() {
		close();
	}

	public String getErrorMessage() {
		return this.errorMessage;
	}
	
	public boolean open( String filename ) {
		try {
			if( sqliteDatabase == null ) {
				sqliteDatabase = SQLiteDatabase.openOrCreateDatabase( filename, null );
			}
		} catch (Exception e) {
			e.printStackTrace();
			errorMessage = e.getMessage();
			return false;
		}
		return true;
	}
	
	public void close() {
		closeCursor();
		//if( sqliteDatabase != null ) {
		//	sqliteDatabase.close();
		//}
	}
	
	// sql
	public boolean execSql( String... sqls ) {
		for( String sql : sqls ) {
			if( !execSql( sql ) ) {
				return false;
			}
		}
		return true;
	}
	
	public boolean execSql( String sql ) {
		try {
			closeCursor();
			sqliteDatabase.execSQL(sql);
		} catch (SQLException e) {
			e.printStackTrace();
			errorMessage = e.getMessage();
			return false;
		}
		return true;
	}
	
	public Cursor getCursor() {
		return this.cursor;
	}
	
	// cursor 
	public boolean rawQuery( String sql ) {
		try {
			closeCursor();
			cursor = sqliteDatabase.rawQuery(sql, null);
			totalCount = cursor.getCount();
		} catch (SQLException e) {
			e.printStackTrace();
			errorMessage = e.getMessage();
			cursor = null;
			return false;
		}
		return true;
	}
	
	public void closeCursor() {
		if( cursor != null ) {
			cursor.close();
		}
		totalCount = 0;
	}
	
	public int getCount() {
		if( cursor != null ) {
			return cursor.getCount();
		}
		return 0;
	}
	
	public boolean moveToFirst() {
		if( cursor != null ) {
			return cursor.moveToFirst();
		}
		return false;
	}
	
	public boolean moveToNext() {
		if( cursor != null ) {
			return cursor.moveToNext();
		}
		return false;
	}
	
	public boolean moveToIndex( int index) {
		if( cursor != null ) {
			return cursor.moveToPosition(index);
		}
		return false;
	}
	
	// get String
	public String getValueString( Integer index ) {
		if( cursor == null ) {
			return NULLVALUE;
		}
		if( cursor.isBeforeFirst() ) {
			if( !cursor.moveToFirst() ) {
				return NULLVALUE;
			}
		}
		String value = new String();
		try {
			value = cursor.getString(index);
		} catch (Exception e) {
			e.printStackTrace();
			errorMessage = e.getMessage();
			value = NULLVALUE;
		}
		if( value == null ) {
			value = NULLVALUE;
		}
		return value;
	}

	public String getValueString( String fieldName ) {
		if( cursor == null ) {
			return NULLVALUE;
		}
		if( cursor.isBeforeFirst() ) {
			if( !cursor.moveToFirst() ) {
				return NULLVALUE;
			}
		}
		String value = new String();
		try {
			value = cursor.getString(cursor.getColumnIndex(fieldName));
		} catch (Exception e) {
			e.printStackTrace();
			errorMessage = e.getMessage();
			value = NULLVALUE;
		}
		if( value == null ) {
			value = NULLVALUE;
		}
		return value;
	}

	public String getValue( Integer index ) {
		return getValueString( index );
	}

	public String getValue( String fieldName ) {
		return getValueString( fieldName );
	}

	public String getValueString( Integer index, int pos ) {
		if( pos < 0 || pos > totalCount+1 ) {
			return NULLVALUE;
		}
		moveToIndex( pos );
		return getValueString( index );
	}

	public String getValueString( String fieldName, int pos ) {
		if( pos < 0 || pos > totalCount+1 ) {
			return NULLVALUE;
		}
		moveToIndex( pos );
		return getValueString( fieldName );
	}

	public String getValue( String fieldName, int pos ) {
		return getValueString( fieldName, pos );
	}
	
	// get Integer
	public Integer getValueInteger( String fieldName ) {
		if( cursor == null ) {
			return 0;
		}
		if( cursor.isBeforeFirst() ) {
			if( !cursor.moveToFirst() ) {
				return 0;
			}
		}
		int value = 0;
		try {
			value = cursor.getInt(cursor.getColumnIndex(fieldName));
		} catch (Exception e) {
			e.printStackTrace();
			errorMessage = e.getMessage();
			value = 0;
		}
		return value;
	}
	
	public Integer getValueInteger( String fieldName, int pos ) {
		if( pos < 0 || pos > totalCount+1 ) {
			return 0;
		}
		moveToIndex( pos );
		return getValueInteger( fieldName );
	}
	
	// get Numeric
	public float getValueNumeric( String fieldName ) {
		if( cursor == null ) {
			return (float)0;
		}
		if( cursor.isBeforeFirst() ) {
			if( !cursor.moveToFirst() ) {
				return (float)0;
			}
		}
		float value = 0;
		try {
			value = cursor.getFloat(cursor.getColumnIndex(fieldName));
		} catch (Exception e) {
			e.printStackTrace();
			errorMessage = e.getMessage();
			value = 0;
		}
		return value;
	}
	
	public float getValueNumeric( String fieldName, int pos ) {
		if( pos < 0 || pos > totalCount+1 ) {
			return 0;
		}
		moveToIndex( pos );
		return getValueNumeric( fieldName );
	}
	
	// transaction
	public boolean beginTransaction() {
		return execSql( "BEGIN TRANSACTION" );
	}
	
	public boolean endTransaction() {
		return execSql( "END TRANSACTION" );
	}
	
	public boolean rollBack() {
		return execSql( "ROLLBACK" );
	}
	
	public boolean commit() {
		return execSql( "COMMIT" );
	}

	
}
