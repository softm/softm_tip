package com.entropykorea.gas.as.common.base;

import java.util.HashMap;
import java.util.Map.Entry;

import android.database.sqlite.SQLiteDatabase;

import com.entropykorea.ewire.database.Sqlite;

public class BaseCode extends Sqlite {

	private final static String SQLITE_SELECT_TYPE_CD = "SELECT * FROM CODE WHERE TYPE_CD = '%s' ORDER BY CD";
	private final static String SQLITE_SELECT_TYPE_CD_CD = "SELECT * FROM CODE WHERE TYPE_CD = '%s' AND CD = '%s'";
	private final static String SQLITE_SELECT_TYPE_CD_NM = "SELECT * FROM CODE WHERE TYPE_CD = '%s' AND CD_NM = '%s'";
	private final static String BLANK_TEXT = "선택없음";

	private HashMap<Integer,Object> mDataHashMap = null;
	//private HashMap<String,String> codelisthashmapS = null;
	private String mTypeCd = new String();
	private boolean mBlank = false;

	public BaseCode( SQLiteDatabase sqliteDatabase, String typeCd ) {
		super( sqliteDatabase );

		init( typeCd, false );
	}

	public BaseCode( SQLiteDatabase sqliteDatabase, String typeCd, boolean blank ) {
		super( sqliteDatabase );

		init( typeCd, blank );
	}
	
	private void init( String typeCd, boolean blank ) {
		this.mTypeCd = typeCd;

		if( typeCd == null )
			mDataHashMap = new HashMap<Integer,Object>();
		else
			mDataHashMap = makeData( typeCd );
	}

	public class CodeData {
		public final static int TYPE_CD = 0;
		public final static int TYPE_NM = 1;
		
		public String CD = new String();
		public String CD_NM = new String();
		//...
	}

	private HashMap<Integer,Object> makeData( String mainCode ) {
		String sql = String.format(SQLITE_SELECT_TYPE_CD, mainCode );
		int i = 0;
		CodeData codeData;

		if( !rawQuery( sql ) )
			return null;

		HashMap<Integer,Object> hashmap = new HashMap<Integer,Object>();

		if( moveToFirst() ) {
			if( this.mBlank ) {
				codeData = new CodeData();
				codeData.CD = "";
				codeData.CD_NM = BLANK_TEXT;
				//...
				hashmap.put( i++, codeData );
			}
			do {
				codeData = new CodeData();
				codeData.CD = getValue( "CD" );
				codeData.CD_NM = getValue( "CD_NM" );
				//...
				hashmap.put( i++, codeData );
			} while ( moveToNext() );
		}
		return hashmap;
	}

	public int getIndex( String value, int type ) {
		CodeData codeData;
		int i = 0;

		if( mDataHashMap == null || value == null )
			return -1;

		for( Entry<Integer,Object> entry : mDataHashMap.entrySet() ) {
			codeData = (CodeData)entry.getValue();
			switch( type ) {
			case CodeData.TYPE_CD:
				if( codeData.CD.equals( value ) )
					return i;
				break;
			case CodeData.TYPE_NM:
				if( codeData.CD_NM.equals( value ) )
					return i;
				break;
			}
			i++;
		}

		return -1;
	}

	public String getCode( int index ) {
		if( mDataHashMap == null || index < 0 || index >= size() ) {
			return NULLVALUE;
		}
		CodeData codeData = (CodeData)mDataHashMap.get(index);
		return codeData.CD;
	}	

	public String getName( int index ) {
		if( mDataHashMap == null || index < 0 || index >= size() ) {
			return NULLVALUE;
		}
		CodeData codeData = (CodeData)mDataHashMap.get(index);
		return codeData.CD_NM;
	}	

	public String getName( String code ) {
		int index = getIndex( code, CodeData.TYPE_CD );
		return getCode( index );
	}

	public String getCode( String name ) {
		int index = getIndex( name, CodeData.TYPE_NM );
		return getName( index );
	}

	public int size() {
		if( mDataHashMap == null )
			return 0;

		return mDataHashMap.size();
	}

	public Object get( int key ) {
		if( mDataHashMap == null )
			return null;

		return mDataHashMap.get(key);
	}

	public String getNameByCode( String type_cd, String code ) {
		String sql = String.format(SQLITE_SELECT_TYPE_CD_CD, type_cd, code );

		if( !rawQuery( sql ) )
			return NULLVALUE;
		
		return getValue( "CD_NM" );
	}

	public String getCodeByName( String type_cd, String name ) {
		String sql = String.format(SQLITE_SELECT_TYPE_CD_NM, type_cd, name );

		if( !rawQuery( sql ) )
			return NULLVALUE;
		
		return getValue( "CD" );
	}
	
}
