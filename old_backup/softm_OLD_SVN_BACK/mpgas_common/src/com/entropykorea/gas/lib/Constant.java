package com.entropykorea.gas.lib;

import java.io.File;
import java.util.LinkedHashMap;

import android.os.Environment;
/**
 * Constant
 * @author softm 
 */
/**
 * Constant
 * @author softm 
 */
public class Constant {
	public static final boolean DEBUG 					= BuildConfig.DEBUG; // > ADT r17
	public final static String SD_DIR = Environment.getExternalStorageDirectory().getAbsolutePath()+ File.separator+(Constant.DEBUG?"":".")+"mpgas";
	// DefaultApplication에서 초기화. ------------
	public static String WORK_DIR     = ""; 
	public static String DB_CODE_PATH = ""; // DB
	// ------------ DefaultApplication에서 초기화.
	public static String PIC_DIR    = ""; // 사진
	public static String SIGN_DIR   = ""; // 서명
	
	// 공통 코드 정의
	public static String CODE_JSON_COM01 = "[{\"Y\":\"완료\",\"N\":\"미완료\"}]";
	/** 완료여부 **/
	public static LinkedHashMap<String, String> CODE_END_YN = new LinkedHashMap<String, String>();
	/** 송신여부 **/	
	public static LinkedHashMap<String, String> CODE_SEND_YN = new LinkedHashMap<String, String>();
	
	static {
		CODE_END_YN.put("Y", "완료" );
		CODE_END_YN.put("N", "미완료");
		
		CODE_SEND_YN.put("Y", "송신" );
		CODE_SEND_YN.put("N", "미송신");
	}
	
	// 고정-- 건들지 마시오. ------------------------------------------------------- //
	// 처리 상수
	// TODO
	/** Y 'Y' */	
	public static String CODE_Y = "Y"; // 'Y'
	/** N 'N' */	
	public static String CODE_N = "N"; // 'N'
	
	/** 완료여부 'Y' */	
	public static String CODE_END_Y = "Y"; // 완료여부 'Y'
	/** 완료여부 'N' */	
	public static String CODE_END_N = "N"; // 완료여부 'N'
	
	/** 송신여부 'Y' */	
	public static String CODE_SEND_Y = "Y"; // 송신여부 'Y'
	/** 송신여부 'N' */	
	public static String CODE_SEND_N = "N"; // 송신여부 'N'
	
	/** 도로/지번 구분 : 지번 */	
	public static String CODE_GUBUN_ADDRESS = "A"; // 도로/지번 구분 : 지번
	/** 도로/지번 구분 : 도로 */
	public static String CODE_GUBUN_STREET  = "S"; // 도로/지번 구분 : 도로	

	/** 주전화번호구분코드  전화번호 */	
	public static String CODE_TEL_CD_HOME = "H"; // 전화번호
	/** 주전화번호구분코드 핸드폰번호 */	
	public static String CODE_TEL_CD_HP   = "M"; // 핸드폰번호
	/** 주전화번호구분코드  직장전화번호	 */
	public static String CODE_TEL_CD_WORK = "C"; // 직장전화번호
	
	/** 불회확인여부 'Y' */	
	public static String CODE_GM_ERROR_Y= "Y"; // 불회확인여부 'Y'
	/** 불회확인여부  'N' */	
	public static String CODE_GM_ERROR_N = "N"; // 불회확인여부  'N'

	/** 바코드스케너타입 : 블루투스'1' */	
	public static String CODE_BARCODE_BLUETOOTH = "Y"; // 블루투스바코드 '1'
	/** 바코드스케너타입 : 자체스캐너 '2' */	
	public static String CODE_BARCODE_SELF= "N"      ; // 자체바코드 '2'
	
	public final static int PROC_ID_TEST    		 = 999; // 테스트
	public final static int PROC_ID_LOAD_COMMON_CODE = 100; // 공통코드조회
	public final static int PROC_ID_SELECT_SQLITE    = 101; // SQL라이트 조회
	
	public static final int ZBAR_SCANNER_REQUEST = 900;
	public static final int ZBAR_QR_SCANNER_REQUEST = 901;
	public final static int PROC_ID_TAKE_CAMERA = 1; // 사진 촬영.
	public final static int PROC_ID_PIC_VIWER   = 2; // 사진뷰어 오픈.
	
	public static final String LOG_TAG = "MPGAS" ;
	// 고정-- 건들지 마시오. ------------------------------------------------------- //	
}
