package com.entropykorea.gas.chg.common;

/**
 * ConstantChg
 * @author softm 
 */
public class WConstant {
	public final static int PROC_ID_SEND_DATA    = 102; // 송신
	public final static int PROC_ID_RECEIVE_DATA = 103; // 수신
	
	// 고정-- 건들지 마시오. ------------------------------------------------------- //
	public static final String LOG_TAG = "MPGAS" ;
	/** 공통코드 */	
	public static String TBL_CODE = "CODE"; // 공통코드
	/** 교체 */	
	public static String TBL_CHG  = "CHG" ; // 교체
	/** 교체 사용자 */	
	public static String TBL_CHG_CUST  = "CHG_CUST" ; // 교체 사용자
	public static final String TAG = "MPGAS";
//	public static final String SERVER_NAME = "192.168.0.163";	
//	public static final String SERVER_NAME = "192.168.0.21";	
//	public static final String SERVER_NAME = "110.8.124.30";	
	// 고정-- 건들지 마시오. ------------------------------------------------------- //	

	public final static int ZBAR_SCANNER_REQUEST2 = 902; // 수용가정보 교체시작시 바코드 스캔
	
//	public static final boolean REALESE 					= false; //	
	public static final boolean REALESE 					= true; //	
}
