package com.entropykorea.gas.gum.database;

import com.entropykorea.ewire.eWireSound;
import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.gum.AppContext;
import com.entropykorea.gas.gum.common.DLog;
import com.entropykorea.gas.gum.common.Utils;

public class Var {
	
	public String USER_ID = ""; // 사용자 아이디
	public String EQUIP_CD = ""; // 기기번호
	
	public String READ_IDX = ""; // 검침인덱스
	public String BILL_YM = ""; // 작업년월
	public String TURN = ""; // 차수
	public String METER_CREATE_DT = ""; // 검침생성일자
	
	public String BLDG_CD = ""; // 건물코드
	public String HOUSE_NO = ""; // 수용가번호
	public String CUST_NO = ""; // 고객번호
	
	public String BARCD_EQUIP_USE_YN = "N";
	
	public String EWIRE_SERVER_IP = ""; // EWIRE
	public String EWIRE_SERVER_PORT = ""; // EWIRE
	public String UPDATE_SERVER_URL = ""; // UPDATE
	
	public String ADDRESS_1 = ""; // 지번
	public String ADDRESS_2 = ""; // 도로명
	
	public Integer total_count = 0;
	public Integer current_count = 0;
	
	public boolean address_type = true; // 지번/도로명 
	
	public static final int ADDRESSTYPE_1 = 0; // 지번
	public static final int ADDRESSTYPE_2 = 1; // 도로명
	
	public static String getAddress( int addressType, Sqlite sqlite, int position ) {

		String SECTOR_NM,BLDG_NO,COMPLEX_NM,BLDG_NM,ROAD_ADDR;
		
		SECTOR_NM = sqlite.getValue("SECTOR_NM", position);
		BLDG_NO = sqlite.getValue("BLDG_NO", position);
		COMPLEX_NM = sqlite.getValue("COMPLEX_NM", position);
		BLDG_NM = sqlite.getValue("BLDG_NM", position);
		ROAD_ADDR = sqlite.getValue("ROAD_ADDR", position);

		// fix address 
		if( BLDG_NO.equals( COMPLEX_NM ) || BLDG_NO.equals( BLDG_NM ) ) {
			BLDG_NO = "";
		}

		if( COMPLEX_NM.equals( BLDG_NM ) ) {
			BLDG_NM = "";
		}
		
		String address_1, address_2;
		
		// 지번
		address_1 = "";
		address_1 = Utils.stringAppend( address_1, SECTOR_NM );
		address_1 = Utils.stringAppend( address_1, BLDG_NO );
		address_1 = Utils.stringAppend( address_1, COMPLEX_NM );
		address_1 = Utils.stringAppend( address_1, BLDG_NM );

		// 도로명
		address_2 = "";
		address_2 = Utils.stringAppend( address_2, ROAD_ADDR );
		address_2 = Utils.stringAppend( address_2, COMPLEX_NM );
		address_2 = Utils.stringAppend( address_2, BLDG_NM );
		
		switch( addressType ) {
		case ADDRESSTYPE_1:
			return address_1;
		case ADDRESSTYPE_2:
			return address_2;
		}
		
		return "";
	}
	
	private void setAddress( Sqlite sqlite ) {
		// 지번
		ADDRESS_1 = getAddress( ADDRESSTYPE_1, sqlite, 0 );
		// 도로명
		ADDRESS_2 = getAddress( ADDRESSTYPE_2, sqlite, 0 );
	}

	public boolean setByReadIdx() {
		
		String str = "" +
				"SELECT READ_IDX,BILL_YM,TURN,BLDG_CD,METER_CREATE_DT,CUST_NO, " +
				"       SECTOR_NM,BLDG_NO,COMPLEX_NM,BLDG_NM,ROAD_ADDR " + 
				"  FROM GUM WHERE READ_IDX = '" + this.READ_IDX + "' LIMIT 1";
		
		Sqlite sqlite = new Sqlite( AppContext.getSQLiteDatabase() );
		
		DLog.d( str );
		
		if( !sqlite.rawQuery(str) ) {
			sqlite.close();
			return false;
		}
		if( sqlite.getCount() < 1 ) {
			sqlite.close();
			return false;
		}
		
		DLog.d( "setByReadIdx OK");
		
		this.READ_IDX = sqlite.getValue("READ_IDX");
		this.BILL_YM = sqlite.getValue("BILL_YM");
		this.TURN = sqlite.getValue("TURN");
		this.METER_CREATE_DT = sqlite.getValue("METER_CREATE_DT");
		this.BLDG_CD = sqlite.getValue("BLDG_CD");
		this.CUST_NO = sqlite.getValue("CUST_NO");
		
		setAddress( sqlite );
		sqlite.close();
		
		return true;
	}
	
	public boolean setByBldgCd() {
		
		String sql = "" +
				"SELECT READ_IDX,BILL_YM,TURN,METER_CREATE_DT.BLDG_CD,CUST_NO " +
				"       SECTOR_NM,BLDG_NO,COMPLEX_NM,BLDG_NO,ROAD_ADDR " + 
				"  FROM GUM WHERE BLDG_CD = '" + BLDG_CD + "' LIMIT 1";
		
		Sqlite sqlite = new Sqlite( AppContext.getSQLiteDatabase() );
		if( !sqlite.rawQuery(sql) ) {
			sqlite.close();
			return false;
		}
		if( sqlite.getCount() < 1 ) {
			sqlite.close();
			return false;
		}
		
		this.READ_IDX = "";
		this.BILL_YM = sqlite.getValue("BILL_YM");
		this.TURN = sqlite.getValue("TURN");
		this.METER_CREATE_DT = sqlite.getValue("METER_CREATE_DT");
		this.HOUSE_NO = "";
		this.CUST_NO = "";
		//this.BLDG_CD = sqlite.getValue("BLDG_CD");
		//this.CUST_NO = sqlite.getValue("CUST_NO");
		
		setAddress( sqlite );
		sqlite.close();
		
		return true;
	}
	
	public boolean setTotalCurrentCount() {
		
		String sql = "SELECT COUNT(READ_IDX) AS TCOUNT FROM GUM";
		
		Sqlite sqlite = new Sqlite( AppContext.getSQLiteDatabase() );
		if( !sqlite.rawQuery(sql) ) {
			sqlite.close();
			return false;
		}
		
		total_count = sqlite.getValueInteger("TCOUNT");
		
		sql = "SELECT COUNT(READ_IDX) AS CCOUNT FROM GUM "
				+ "WHERE HOUSE_ORD < (SELECT HOUSE_ORD FROM GUM WHERE READ_IDX = '"
				+ READ_IDX + "')";
		
		if( !sqlite.rawQuery(sql) ) {
			return false;
		}
		
		current_count = sqlite.getValueInteger("CCOUNT");
		DLog.d( sql );
		DLog.d( "POSITION: " + current_count + "/" + total_count );
		
		sqlite.close();
		return true;
	}
	
	public boolean isFirst() {
		if( current_count == 0 ) {
			return true;
		}
		return false;
	}
	
	public boolean isLast() {
		if( total_count == current_count+1 ) {
			return true;
		}
		return false;
	}
	
	public boolean setPrev() {
		
		if( isFirst() ) {
			return true;
		}
		String sql = "SELECT READ_IDX,HOUSE_NO,BLDG_CD FROM GUM "
				+ "WHERE HOUSE_ORD < (SELECT HOUSE_ORD FROM GUM WHERE READ_IDX = '"
				+ READ_IDX + "') ORDER BY HOUSE_ORD DESC LIMIT 1";
		
		Sqlite sqlite = new Sqlite( AppContext.getSQLiteDatabase() );
		if( !sqlite.rawQuery(sql) ) {
			return false;
		}
		
		if( sqlite.getCount() == 0 ) {
			return false;
		}
		
		this.READ_IDX = sqlite.getValue("READ_IDX");
		this.HOUSE_NO = sqlite.getValue("HOUSE_NO");

		if( this.BLDG_CD.compareTo( sqlite.getValue("BLDG_CD")) != 0 ) {
			eWireSound.playBeep( AppContext.getContext() );
		}
		
		this.BLDG_CD = sqlite.getValue("BLDG_CD");

		DLog.d( sql );
		
		sqlite.close();
		
		//setByReadIdx();
		
		return true;
	}
	
	public boolean setNext() {
		
		if( isLast() ) {
			return true;
		}
		
		String sql = "SELECT READ_IDX,HOUSE_NO,BLDG_CD FROM GUM "
				+ "WHERE HOUSE_ORD > (SELECT HOUSE_ORD FROM GUM WHERE READ_IDX = '"
				+ READ_IDX + "') ORDER BY HOUSE_ORD LIMIT 1"; 
		
		Sqlite sqlite = new Sqlite( AppContext.getSQLiteDatabase() );
		if( !sqlite.rawQuery(sql) ) {
			return false;
		}
		
		if( sqlite.getCount() == 0 ) {
			return false;
		}
		this.READ_IDX = sqlite.getValue("READ_IDX");
		this.HOUSE_NO = sqlite.getValue("HOUSE_NO");
		
		if( this.BLDG_CD.compareTo( sqlite.getValue("BLDG_CD")) != 0 ) {
			eWireSound.playBeep( AppContext.getContext() );
		}
		
		this.BLDG_CD = sqlite.getValue("BLDG_CD");
		
		DLog.d( sql );

		sqlite.close();
		
		//setByReadIdx();
		
		return true;
	}
	
	
}
