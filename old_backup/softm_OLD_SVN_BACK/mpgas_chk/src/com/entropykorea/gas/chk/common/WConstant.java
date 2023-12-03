package com.entropykorea.gas.chk.common;

import java.util.LinkedHashMap;

import com.entropykorea.gas.lib.Constant;

/**
 * ConstantChg
 * @author softm
 */
public class WConstant extends Constant{
    public final static int PROC_ID_SEND_DATA    = 102; // 송신
    public final static int PROC_ID_RECEIVE_DATA = 103; // 수신

    // 고정-- 건들지 마시오. ------------------------------------------------------- //
    public static final String LOG_TAG = "MPGAS" ;
    /** 공통코드 */
    public static String TBL_CODE = "CODE"; // 공통코드
    /** 지역 */
    public static String TBL_AREA_CENTER = "AREA_CENTER"; // 지역
    /** 제조사 */
    public static String TBL_PROVIDER    = "PROVIDER"; // 제조사

    /** 점검 */
    public static String TBL_JUM             = "JUM"             ; // 점검
    /** 중계점검부적합사진파일 */
    public static String TBL_JUM_NOCFM_PHOTO = "JUM_NOCFM_PHOTO" ; // 중계점검부적합사진파일
    /** 점검방문이력 */
    public static String TBL_JUM_VISIT       = "JUM_VISIT"       ; // 점검방문이력
    /** 점검보일러정보 */
    public static String TBL_JUM_BOILER      = "JUM_BOILER"      ; // 점검보일러정보
    /** 점검고객정보수정 */
    public static String TBL_JUM_CUST        = "JUM_CUST"        ; // 점검고객정보수정
    /** 점검부적합내용 */
    public static String TBL_JUM_NOCFM       = "JUM_NOCFM"       ; // 점검부적합내용
    /** 점검전회부적합미개선내역 */
    public static String TBL_JUM_NOIMP       = "JUM_NOIMP"       ; // 점검전회부적합미개선내역
    /** 점검제외 */
    public static String TBL_JUM_EXCEPTION   = "JUM_EXCEPTION"   ; // 점검제외
    
    public static final String TAG = "MPGAS";
//  public static final String SERVER_NAME = "192.168.0.163";
//  public static final String SERVER_NAME = "192.168.0.21";
//  public static final String SERVER_NAME = "110.8.124.30";
//  public static final boolean REALESE                     = true; //
    public static final boolean REALESE                     = false; //

    public final static int ZBAR_SCANNER_REQUEST2 = 902; // 수용가정보 교체시작시 바코드 스캔
    // 고정-- 건들지 마시오. ------------------------------------------------------- //

    /** 정기정검 '1' */
    public static String CODE_CHECKUP_CD_1 = "1"; // 정기정검
    /** 미정검 ( 이월점검 ) '2' */
    public static String CODE_CHECKUP_CD_2 = "2"; // 미정검 ( 이월점검 )
    /** 특별정검 '3' */
    public static String CODE_CHECKUP_CD_3 = "3"; // 특별정검

    /** 점검구분(업무코드) **/
    public static LinkedHashMap<String, String> CODE_CHECKUP_CD = new LinkedHashMap<String, String>();

    /** QR코드 인식 'Y' */
    public static String CODE_QR_Y = "Y"; // 인식
    /** QR코드 미인식 'N' */
    public static String CODE_QR_READ_N = "N"; // 미인식

    /** QR코드 인식여부 **/
    public static LinkedHashMap<String, String> CODE_QR_YN = new LinkedHashMap<String, String>();

    // 공백:미점검, Y: 적합, N: 부적합 , X: 기기없음
    /** 시설물 점검결과 : 미점검 '' */
    public static String CODE_CHECK_OK_NONE = ""; // 미점검
    /** 시설물 점검결과 : 적합 'Y' */
    public static String CODE_CHECK_OK_Y    = "Y"; // 적합
    /** 시설물 점검결과 : 부적합 'N' */
    public static String CODE_CHECK_OK_N    = "N"; // 부적합
    /** 시설물 점검결과 : 기기없음 'X' */
    public static String CODE_CHECK_OK_X    = "X"; // 기기없음

    /** 시설물 점검결과 : 공백:미점검, Y: 적합, N: 부적합 , X: 기기없음 */
    public static LinkedHashMap<String, String> CODE_CHECK_OK = new LinkedHashMap<String, String>();
    // FA040
    /** 점검결과 : 미점검 '0' */
    public static String CODE_CHECKUP_RESULT_CD_0 = "0"; // 미점검
    /** 점검결과 : 적합 '1' */
    public static String CODE_CHECKUP_RESULT_CD_1 = "1"; // 적합
    /** 점검결과 : 부적합 '2' */
    public static String CODE_CHECKUP_RESULT_CD_2 = "2"; // 부적합
    /** 점검결과 : 거부    '3' */
    public static String CODE_CHECKUP_RESULT_CD_3 = "3"; // 거부

    static {
        CODE_CHECKUP_CD.put(CODE_CHECKUP_CD_1, "정기점검");
        CODE_CHECKUP_CD.put(CODE_CHECKUP_CD_2, "이월점검");
        CODE_CHECKUP_CD.put(CODE_CHECKUP_CD_3, "특별점검");

        CODE_QR_YN.put(CODE_QR_Y, "인식");
        CODE_QR_YN.put(CODE_QR_READ_N, "미인식");

        CODE_CHECK_OK.put(CODE_CHECK_OK_NONE, "미점검");
        CODE_CHECK_OK.put(CODE_CHECK_OK_Y   , "적합");
        CODE_CHECK_OK.put(CODE_CHECK_OK_N   , "부적합");
        CODE_CHECK_OK.put(CODE_CHECK_OK_X   , "기기없음");
    }
    
    /** 시설물코드 : 가스차단기 : 01 */
    public static String CODE_FA_CD_BREAKER = "01"; // 가스차단기
    /** 시설물코드 : 계량기 : 01 */    
    public static String CODE_FA_CD_GM      = "02"; // 계량기
    /** 시설물코드 : 배관 : 01 */    
    public static String CODE_FA_CD_PIPE    = "03"; // 배관
    /** 시설물코드 : 보일러 : 01 */    
    public static String CODE_FA_CD_BOILER  = "04"; // 보일러
    /** 시설물코드 : 연소기 : 01 */    
    public static String CODE_FA_CD_BURNER  = "05"; // 연소기
}
