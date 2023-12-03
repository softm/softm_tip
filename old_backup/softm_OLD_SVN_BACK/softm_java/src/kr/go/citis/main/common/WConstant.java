package kr.go.citis.main.common;

/**
 * ConstantChg
 * @author softm 
 */
public class WConstant {
	// 고정-- 건들지 마시오. ------------------------------------------------------- //
	public static final String LOG_TAG = "CITIS" ;
	/** 공통코드 */	
	public static String TBL_CODE = "CODE"; // 공통코드
	/** 교체 */	
	public static String TBL_CHG  = "CHG" ; // 교체
	/** 교체 사용자 */	
	public static String TBL_CHG_CUST  = "CHG_CUST" ; // 교체 사용자
	public static final String TAG = "CITIS";
//	public static final String SERVER_NAME = "192.168.0.163";	
//	public static final String SERVER_NAME = "192.168.0.21";	
//	public static final String SERVER_NAME = "110.8.124.30";
	public static String SERVER_URL = "";
	// 고정-- 건들지 마시오. ------------------------------------------------------- //	

	public final static int ZBAR_SCANNER_REQUEST2 = 902; // 수용가정보 교체시작시 바코드 스캔
	
//	public static final boolean REALESE 					= false; //	
	public static final boolean REALESE 					= true; //
	
	public static final String LIST_DATA_MODE_INSERT = "I"; // 입력	
	public static final String LIST_DATA_MODE_UPDATE = "U"; // 수정
	public static final String LIST_DATA_MODE_DELETE = "D"; // 삭제
	public static final String LIST_DATA_MODE_READ   = "R"; // 읽기

	public static final String WRITE_MODE_FISRT  = "W" ; // 작성
	public static final String WRITE_MODE_SECOND = "RW"; // 재작성
	public static final String WRITE_MODE_UPDATE = "U" ; // 수정
	
	
	public final static int PROC_ID_BLD_CHKUP_WRT_FIRST  = 102; // 시공사점검 작성
	public final static int PROC_ID_BLD_CHKUP_WRT_SECOND = 103; // 시공사점검 재작성
	public final static int PROC_ID_BLD_CHKUP_WRT_VIEW   = 104; // 시공사점검 상세보기-수정.

	public static final int PROC_ID_TEST_CHK_LIST        = 201; // 검측 체크리스트 목록 조회
	
	public static final int PROC_ID_TEST_REQ_DOC_SAVE_TYPE_SAVE     = 301; // 검측요청문서 작성 [임시저장]
	public static final int PROC_ID_TEST_REQ_DOC_SAVE_TYPE_COMPLETE = 302; // 검측요청문서 작성 [확정]
	
	public static final int PROC_ID_TEST_REQ_DOC_DTL  = 401; // 검측요청서 조회(상세)
	public static final int PROC_ID_TEST_REQ_DOC_SAVE = 402; // 검측요청서 저장
	
	public static final int PROC_ID_TEST_RSLT_WRT_LIST  = 500; // 검측결과서등록 조회
	public static final int PROC_ID_TEST_RSLT_WRT_SAVE_TYPE_SAVE  = 501; // 검측결과서등록 저장  [임시저장]
	public static final int PROC_ID_TEST_RSLT_WRT_SAVE_TYPE_COMPLETE  = 502; // 검측결과서등록 저장  [확정]
	
	public static final int PROC_ID_TEST_RSLT_NOTI_DTL  = 600; // 검측 결과 통보 조회
	public static final int PROC_ID_TEST_RSLT_NOTI_DTL_TYPE_SAVE  = 601; // 검측 결과 통보 저장  [임시저장]
	public static final int PROC_ID_TEST_RSLT_NOTI_DTL_TYPE_COMPLETE  = 602; // 검측 결과 통보 저장 [확정]
}
