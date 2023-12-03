package com.entropykorea.gas.gum.database;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map.Entry;

import android.database.sqlite.SQLiteDatabase;

import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.gum.common.DLog;

public class BaseCode extends Sqlite {

	private final static String SQLITE_SELECT_TYPE_CD = "SELECT * FROM CODE WHERE TYPE_CD = '%s' ORDER BY CD";
	private final static String SQLITE_SELECT_TYPE_CD_CD = "SELECT * FROM CODE WHERE TYPE_CD = '%s' AND CD = '%s'";
	private final static String SQLITE_SELECT_TYPE_CD_NM = "SELECT * FROM CODE WHERE TYPE_CD = '%s' AND CD_NM = '%s'";
	private final static String BLANK_TEXT = "선택없음";

	private HashMap<Integer,Object> mDataHashMap = null;

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
	
	public ArrayList<String> getArrayList() {
		CodeData codeData;
		ArrayList<String> arrayList = new ArrayList<String>();
		int i;
		int count = getCount();
		
		for( i=0 ; i<count ; i++ ) {
			codeData = (CodeData) mDataHashMap.get(i);
			arrayList.add( codeData.CD_NM );
			//DLog.d( codeData.CD_NM );
		}
		return arrayList;
	}

	public String[] getStrings() {
		CodeData codeData;
		int i = 0;
		int count = getCount();

		String[] strings = new String[count];
		
		for( i=0 ; i<count ; i++ ) {
			codeData = (CodeData) mDataHashMap.get(i);
			strings[i++] = codeData.CD_NM;
		}
		return strings;
	}

	public int getIndex( String value, int type ) {
		CodeData codeData;
		int i = 0;
		int count = getCount();

		if( mDataHashMap == null || value == null ) {
			return -1;
		}
		if( value.length() == 0 ) {
			return -1;
		}

		for( i=0 ; i<count ; i++ ) {
			codeData = (CodeData)mDataHashMap.get(i);
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
		if( index < 0 ) {
			return code;
		}
		return getName( index );
	}

	public String getCode( String name ) {
		int index = getIndex( name, CodeData.TYPE_NM );
		if( index < 0 ) {
			return name;
		}
		return getCode( index );
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

	// util 
	public static String getNameByCode( SQLiteDatabase sqliteDatabase, String type_cd, String code ) {
		
		Sqlite sqlite = new Sqlite( sqliteDatabase );
		String sql = String.format(SQLITE_SELECT_TYPE_CD_CD, type_cd, code );
		String value = "";

		DLog.d( sql );
		
		if( !sqlite.rawQuery( sql ) ) {
			return NULLVALUE;
		}
		
		if( sqlite.getCount() == 0 ) {
			return code;
		}
		
		value = sqlite.getValue( "CD_NM" );
		
		sqlite.close();
		
		return value;
	}

	// util 
	public static String getCodeByName( SQLiteDatabase sqliteDatabase, String type_cd, String name ) {
		
		Sqlite sqlite = new Sqlite( sqliteDatabase );
		String sql = String.format(SQLITE_SELECT_TYPE_CD_NM, type_cd, name );
		String value = "";

		if( !sqlite.rawQuery( sql ) )
			return NULLVALUE;
		
		if( sqlite.getCount() == 0 ) {
			return name;
		}

		value = sqlite.getValue( "CD" );
		sqlite.close();
		
		return value;
	}
	
}
