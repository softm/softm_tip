package kr.go.citis.main.common;

/**
 * WConstant
 * @author softm 
 */
public class WConstant {
	public static final String LOG_TAG = "CITIS" ;
	public static final String TAG = "CITIS";
	public static String SERVER_URL = "";

//	public static final boolean REALESE 					= false; //	
	public static final boolean REALESE 					= true; //
	
	public static final String LIST_DATA_MODE_INSERT = "I"; // 입력	
	public static final String LIST_DATA_MODE_UPDATE = "U"; // 수정
	public static final String LIST_DATA_MODE_DELETE = "D"; // 삭제
	public static final String LIST_DATA_MODE_READ   = "R"; // 읽기

	public static final String WRITE_MODE_FISRT  = "W" ; // 작성
	public static final String WRITE_MODE_SECOND = "RW"; // 재작성
	public static final String WRITE_MODE_UPDATE = "U" ; // 수정
	
	public final static int PROC_ID_BLD_CHKUP_WRT_FIRST               = 102; // 시공사점검 작성
	public final static int PROC_ID_BLD_CHKUP_WRT_SECOND              = 103; // 시공사점검 재작성
	public final static int PROC_ID_BLD_CHKUP_WRT_VIEW                = 104; // 시공사점검 상세보기-수정.

	public static final int PROC_ID_TEST_CHK_LIST                     = 201; // 검측 체크리스트 목록 조회
	
	public static final int PROC_ID_TEST_REQ_DOC_SAVE_TYPE_SAVE       = 301; // 검측요청문서 작성 [임시저장]
	public static final int PROC_ID_TEST_REQ_DOC_SAVE_TYPE_COMPLETE   = 302; // 검측요청문서 작성 [확정]
	
	public static final int PROC_ID_TEST_REQ_DOC_DTL                  = 401; // 검측요청서 조회(상세)
	public static final int PROC_ID_TEST_REQ_DOC_SAVE                 = 402; // 검측요청서 저장
	
	public static final int PROC_ID_TEST_RSLT_WRT_LIST                = 500; // 검측결과서등록 조회
	public static final int PROC_ID_TEST_RSLT_WRT_SAVE_TYPE_SAVE      = 501; // 검측결과서등록 저장  [임시저장]
	public static final int PROC_ID_TEST_RSLT_WRT_SAVE_TYPE_COMPLETE  = 502; // 검측결과서등록 저장  [확정]
	
	public static final int PROC_ID_TEST_RSLT_NOTI_DTL                = 600; // 검측 결과 통보 조회
	public static final int PROC_ID_TEST_RSLT_NOTI_DTL_TYPE_SAVE      = 601; // 검측 결과 통보 저장  [임시저장]
	public static final int PROC_ID_TEST_RSLT_NOTI_DTL_TYPE_COMPLETE  = 602; // 검측 결과 통보 저장 [확정]
	
	public static final int PROC_ID_NCR_RPRT                          = 701; // 부적합  보고서
	public static final int PROC_ID_CAR_RPRT                          = 702; // 시정조치 보고서
	
	public final static int PROC_ID_PHOTO_MNG_LIST                    = 800; // 사진관리 조회
	public final static int PROC_ID_PHOTO_MNG_WRT_FIRST               = 802; // 사진관리 작성
	public final static int PROC_ID_PHOTO_MNG_WRT_UPDATE              = 804; // 사진관리 수정
	public final static int PROC_ID_PHOTO_MNG_DTL_DELETE              = 805; // 사진관리 삭제
}
