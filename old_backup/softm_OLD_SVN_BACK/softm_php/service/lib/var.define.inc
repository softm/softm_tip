<?
define('SERVICE_DIR',HOME_DIR . '/service'); // SERVICE_DIR
define('DB_KIND','MYSQL'); // db kind

//define ("SERVER_NAME", "softm.net" );
if ( !defined("SERVER_NAME") ) {
    define ("SERVER_NAME", $_SERVER['SERVER_NAME']);
}
define ("DATA_DIR"   , HOME_DIR . "/data" );
define ("IMAGE_BASE" , HOME_DIR . '/data/prod/images'          );

//define ("HTTP_URL", 'http://local-framework.com'          );
//define ("HTTP_URL", 'http://lioness.kr'          );
if ( !defined("HTTP_URL") ) {
    define ("HTTP_URL", 'http://'.$_SERVER['SERVER_NAME']);
}
define ("SERVICE_BASE", '/service');
define ("UI_BASE", SERVICE_BASE .'/ui'      );
define ("ROOT_URL", HTTP_URL . '/'          );
define ("SERVICE_URL", HTTP_URL . SERVICE_BASE);
define ("UI_URL", HTTP_URL . UI_BASE);
define ("FRONT_URL", SERVICE_URL . '/index.php');
define ("ADMIN_URL", SERVICE_URL . '/admin.php');

define ("LOGIN_URL"     , '/index.php?sub=member&mode=login'  );
define ("LOGOUT_URL"    , SERVICE_URL . '/logout.php'         );
define ("MEMBER_REG_URL", '/index.php?sub=member&mode=reg'         );
define ("MEMBER_UPD_URL", '/index.php?sub=mypage&mode=member_upd'         );

define ("DIR_SEP", DIRECTORY_SEPARATOR);

/**
 * @var 비회원
 */
define ("MEMBER_TYPE_NON", "0" ); // @var 비회원
/**
 * @var 회원
 */define ("MEMBER_TYPE_STD" , "1" ); // @var 일반회원

/**
 * @var 관리자
 */define ("MEMBER_TYPE_ADM"  , "Z" ); // @var 관리자

/**
 * 프로그램시 처리 형태 : PROC_TYPE
 */
/** 공정코드 - 1 */ define ("PROC_TYPE_PROC_CODE", "1" );
/** 등록정보 - 2 */ define ("PROC_TYPE_REGINFO"  , "2" );
/** 회원     - 3 */ define ("PROC_TYPE_MEMBER"   , "3" );
/** 공지사항 - 4 */ define ("PROC_TYPE_BBSNOTICE", "4" );
/** QNA      - 5 */ define ("PROC_TYPE_QNA"      , "5" );

/**
 * 문의유형 형태 : QNA_TYPE
 */
/** 일반 - 1 */ define ("QNA_TYPE_1"      , "1" );
/** 기타 - 2 */ define ("QNA_TYPE_2"      , "2" );

/**
 * 답변상태 : QNA_STATE 답변상태 : 질문[Q] / 답변완료[A]
 */
/** 질문        - Q */ define ("QNA_STATE_Q"      , "Q" );
/** 답변완료    - A */ define ("QNA_STATE_A"      , "A" );

/** Y/N - Y */ define ("YN_Y", "Y" );
/** Y/N - N */ define ("YN_N", "N" );

/** 등록정보 승인상태 상태 - 접수   - R */ define ("STATE_REGINFO_START"    , "R" );
/** 등록정보 승인상태 상태 - 승인   - A */ define ("STATE_REGINFO_APPROVAL" , "A" );
/** 등록정보 승인상태 상태 - 취소   - C */ define ("STATE_REGINFO_CANCEL"   , "C" );

/**
 * @var 리턴값 - 성공
 */
define ("C_RETURN_CODE_SUCCESS", 200 );
/**
 * @var 리턴값 - 실패
 */
define ("C_RETURN_CODE_FAILURE", 500 );

/**
 * @var 조회 - DATABASE 처리 형태
 */
define ("C_DB_PROCESS_MODE_SELECT", "R")   ; // 조회
/**
 * @var 입력 - DATABASE 처리 형태
 */
define ("C_DB_PROCESS_MODE_INSERT", "I")   ; // 입력
/**
 * @var 수정 - DATABASE 처리 형태
 */
define ("C_DB_PROCESS_MODE_UPDATE", "U")   ; // 수정
/**
 * @var 삭제 - DATABASE 처리 형태
 */
define ("C_DB_PROCESS_MODE_DELETE", "D")   ; // 삭제

/**
 * @var 저장- DATABASE 처리 형태 ( 입력, 수정, 삭제를 포함함 )
 */
define ("C_DB_PROCESS_MODE_SAVE"  , "S")   ; // 저장

/**
 * @var 조회 - DATABASE 처리 형태
 */
define ("C_DB_PROCESS_MODE_PROC", "P")   ; // 단순처리

/**
 * @var 데이터 타입 JSON
 */
define ("DATA_TYPE_JSON", "json")   ; // json
/**
 * @var 데이터 타입 XML
 */
define ("DATA_TYPE_XML", "xml")   ; // xml
/**
 * @var 데이터 타입 TEXT
 */
define ("DATA_TYPE_TEXT", "text")   ; // text
?>
