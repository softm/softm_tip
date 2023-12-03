/* 코드 */
CREATE TABLE CODE (
	TYPE_CD TEXT DEFAULT '', /* 구분코드 */
	CD TEXT DEFAULT '', /* 코드 */
	CD_NM TEXT DEFAULT '', /* 코드명 */
	MGT_CHAR1 TEXT, /* 관리문자1 */
	MGT_CHAR2 TEXT, /* 관리문자2 */
	MGT_CHAR3 TEXT, /* 관리문자3 */
	MGT_CHAR4 TEXT, /* 관리문자4 */
	MGT_CHAR5 TEXT, /* 관리문자5 */
	MGT_CHAR6 TEXT, /* 관리문자6 */
	MGT_NUM1 NUMERIC, /* 관리숫자1 */
	MGT_NUM2 NUMERIC, /* 관리숫자2 */
	ORD INT DEFAULT 0, /* 정렬 */
	REMARK TEXT, /* 비고 */

	PRIMARY KEY (
		TYPE_CD, 
		CD
	)
);

/* 고객센터 */
CREATE TABLE AREA_CENTER (
	AREA_CENTER_CD TEXT DEFAULT '', /* 고객센터코드 */
	AREA_CENTER_NM TEXT DEFAULT '', /* 고객센터명 */
	TEL_NO TEXT, /* 전화번호 */

	PRIMARY KEY (
		AREA_CENTER_CD
	)
);

/* 공급자 */
CREATE TABLE PROVIDER (
	CO_NM TEXT, /* 공급자명 */
	CO_NO TEXT, /* 사업자번호 */
	CEO_NM TEXT, /* 대표자명 */
	ADDR TEXT, /* 주소 */
	ROAD_ADDR1 TEXT, /* 도로명주소1 */
	ROAD_ADDR2 TEXT, /* 도로명주소2 */
	TEL_NO TEXT, /* 전화번호 */
	VAN_NO  TEXT, /* 단말기번호 */
	VAN_CARD_NO TEXT /* 신용카드VAN번호 */
);

/* 민원 */
CREATE TABLE MIN (                
	REQUIRE_IDX                   INT  NOT NULL,         /*  민원인덱스(PK)           */
	REQUIRE_CD                    TEXT NOT NULL,         /*  민원구분                */
	HOUSE_NO                      TEXT NOT NULL,         /*  수용가번호               */
	FAKE_HOUSE_NO                 TEXT NOT NULL,         /*  가수용가번호              */
	AREA_CD                       TEXT DEFAULT '',       /*  지역코드                */
	SECTOR_CD                     TEXT DEFAULT '',       /*  구역코드                */
	COMPLEX_CD                    TEXT DEFAULT '',       /*  단지코드                */
	BLDG_CD                       TEXT DEFAULT '',       /*  건물코드                */
	AREA_NM                       TEXT DEFAULT '',       /*  지역명                 */
	SECTOR_NM                     TEXT DEFAULT '',       /*  구역명                 */
	COMPLEX_NM                    TEXT DEFAULT '',       /*  단지명                 */
	BLDG_NM                       TEXT DEFAULT '',       /*  건물명                 */
	BLDG_NO                       TEXT DEFAULT '',       /*  번지                  */
	ROOM_NO                       TEXT DEFAULT '',       /*  호수                  */
	ROAD_NM                       TEXT DEFAULT '',       /*  도로명                 */
	CO_NM                         TEXT DEFAULT '',       /*  상호                  */
	PURPOSE_CD                    TEXT DEFAULT '',       /*  용도코드                */
	HOUSE_STATUS_CD               TEXT DEFAULT '',     /*  수용가상태코드             */
	HOUSE_LIVING_CD               TEXT DEFAULT '',       /*  수용가주거구분             */
	CUST_NO                       TEXT DEFAULT '',       /*  고객번호                */
	CUST_NM                       TEXT DEFAULT '',       /*  고객명                 */
	TEL_NO                        TEXT DEFAULT '',       /*  전화번호                */
	WORK_TEL_NO                   TEXT DEFAULT '',       /*  직장전화번호              */
	HP_NO                         TEXT DEFAULT '',       /*  핸드폰번호               */
	TEL_CD                        TEXT DEFAULT '',       /*  주전화번호구분코드           */
	GM_NO                         TEXT DEFAULT '',       /*  계량기번호               */
	ACCEPT_DT                     TEXT DEFAULT '',       /*  접수일시                */
	REQUEST_REQUIRE_DT            TEXT DEFAULT '',       /*  요청일자                */
	REQUEST_BEGIN_DT              TEXT DEFAULT '',       /*  방문요청시작시각            */
	REQUEST_REMARK                TEXT DEFAULT '',       /*  요청메모                */
	PUSH_REQ_YN                   TEXT DEFAULT '',       /*  독촉여부                */
	VIR_ACC_NO_IBK                TEXT DEFAULT '',      /*  기업은행가상계좌번호          */
	VIR_ACC_NO_NH                 TEXT DEFAULT '',      /*  농협가상계좌번호            */
	PROC_RESULT_CD                TEXT DEFAULT '',       /*  처리결과코드              */
	PROC_USER_CD                  TEXT DEFAULT '',       /*  처리자                 */
	PROC_DT                       TEXT DEFAULT '',       /*  처리일시                */
	PROC_REMARK                   TEXT DEFAULT '',       /*  처리메모                */
	PAID_GAS_PRICE                INT DEFAULT 0,       /*  요금수납금액              */
	PAID_FEE_PRICE                INT DEFAULT 0,       /*  수수료수납금액             */
	BASE_PRICE                    INT DEFAULT 0,       /*  전출-기본요금             */
	USE_AMOUNT                    INT DEFAULT 0,       /*  전출-사용량              */
	USE_PRICE                     INT DEFAULT 0,       /*  전출-사용요금             */
	PENALTY_PRICE                 INT DEFAULT 0,       /*  위약금                 */
	UNSEAL_PRICE                  INT DEFAULT 0,       /*  봉인해제비용             */
	BF_METER                      INT DEFAULT 0,       /*  전월지침                */
	METER                         INT DEFAULT 0,       /*  현재지침                */
	MV_IN_CUST_NM                 TEXT DEFAULT '',       /*  전입-고객명              */
	MV_IN_TEL_NO                  TEXT DEFAULT '',       /*  전입-전화번호             */
	MV_IN_WORK_TEL_NO             TEXT DEFAULT '',       /*  전입-직장전화번호           */
	MV_IN_HP_NO                   TEXT DEFAULT '',       /*  전입-핸드폰번호            */
	MV_IN_TEL_CD                  TEXT DEFAULT '',       /*  전입-주전화번호구분코드        */
	CARD_COMPANY                  TEXT DEFAULT '',       /*  카드사(매입사)            */
	CARD_NUM                      TEXT DEFAULT '',       /*  카드번호                */
	CARD_YM                       TEXT DEFAULT '',       /*  카드유효년월              */
	CARD_AMT                      TEXT DEFAULT '',       /*  카드승인금액              */
	CARD_MONTHS                   TEXT DEFAULT '',       /*  카드할부개월              */
	CARD_TRANS_NUM                TEXT DEFAULT '',       /*  카드승인번호              */
	CARD_TRANS_DATE               TEXT DEFAULT '',       /*  카드승인일시              */
	CARD_STATUS                   TEXT DEFAULT '',       /*  카드승인상태              */
	CARD_CANCEL_TRANS_NUM         TEXT DEFAULT '',       /*  카드취소승인번호            */
	CARD_CANCEL_TRANS_DATE        TEXT DEFAULT '',       /*  카드취소승인일시            */
	CASH_AMT                      TEXT DEFAULT '',       /*  현금수납액               */
	SEAL_CD                       TEXT DEFAULT '',       /*  봉인방법                */
	LAST_CALC_TIME                TEXT DEFAULT '',       /*  최종요금계산일시            */
	PAY_INFO_SMS_REQ_YN           TEXT DEFAULT '',       /*  입금정보문자발송요청여부        */
	READ_SMS_RECV_YN              TEXT DEFAULT '',   /*  검침SMS수신동의여부         */
	CHG_SMS_RECV_YN               TEXT DEFAULT '',   /*  교체SMS수신동의여부         */
	CHECKUP_SMS_RECV_YN           TEXT DEFAULT '',   /*  점검SMS수신동의여부         */
    BILL_SMS_RECV_YN              TEXT DEFAULT '',   /*  고지SMS수신동의여부         */
	UNPAID_SMS_RECV_YN            TEXT DEFAULT '',   /*  체납SMS수신동의여부         */
	SIGN_FILE_NM                  TEXT DEFAULT '',       /*  서명파일명               */
	PHOTO_FILE_NM                 TEXT DEFAULT '',       /*  사진파일명               */
	PHOTO_FILE_NM2                TEXT DEFAULT '',       /*  사진파일명2              */
	END_YN                        TEXT DEFAULT 'N',       /*  완료여부                */
	SEND_YN                       TEXT DEFAULT 'N',       /*  송신여부                */
	
	PRIMARY KEY (
		REQUIRE_IDX
	)
);

/* 민원수수료 */
CREATE TABLE MIN_FEE (
	AREA_CD     TEXT NOT NULL,/* 물품코드(PK) */
	ITEM_CD     TEXT NOT NULL,/* 물품코드(PK) */
	ITEM_NM     TEXT DEFAULT '',    /* 물품명      */
	PROC_UNIT_PRICE  INT DEFAULT 0, /* 단가       */
	

	PRIMARY KEY (
		AREA_CD,
		ITEM_CD
	)
);

/* 민원수수료수납 (MIN_FEE 수신후 수수료 수신목록 업데이트) */
CREATE TABLE MIN_FEE_PAY (
	REQUIRE_IDX        INT NOT NULL,    /*민원인덱스(PK)(FK) */
	AREA_CD            TEXT DEFAULT '', /*지역코드(PK)      */
	ITEM_CD            TEXT DEFAULT '', /*물품코드(PK)      */
	PROC_UNIT_PRICE    TEXT DEFAULT '', /*처리단가          */
    PROC_QTY           INT DEFAULT 0, /*처리수량          */
    
	PRIMARY KEY (
		REQUIRE_IDX,
		AREA_CD    ,
		ITEM_CD
	)
);

/* 민원고객정보수정 */
CREATE TABLE MIN_CUST (
	REQUIRE_IDX   INT  NOT NULL , /*  민원인덱스(PK)(FK)    */
	HOUSE_NO      TEXT NOT NULL , /*  수용가번호            */
	FAKE_HOUSE_NO TEXT NOT NULL , /*  가수용가번호           */
	CUST_NO       TEXT NOT NULL , /*  고객번호             */
	CUST_NM       TEXT NULL , /*  고객명              */
	TEL_NO        TEXT NULL , /*  전화번호             */
	WORK_TEL_NO   TEXT NULL , /*  직장전화번호           */
	HP_NO         TEXT NULL , /*  핸드폰번호            */
	TEL_CD        TEXT NULL , /*  주전화번호구분코드        */

	PRIMARY KEY (
		REQUIRE_IDX
	)
);

/* 민원요금계산  (데이터 수신후 MIN Tabel update) */
CREATE TABLE MIN_CUR_PRICE (
	REQUIRE_IDX  	INT NOT NULL,  /* 민원인덱스(PK)(FK)*/
	BF_METER  		TEXT DEFAULT '',  /* 전월지침         */
	USE_AMOUNT  	TEXT DEFAULT '',  /* 사용량          */
	USE_PRICE       TEXT DEFAULT '',  /* 사용요금         */
    BASE_PRICE      TEXT DEFAULT '',  /* 기본요금         */
    PENALTY_PRICE   TEXT DEFAULT '',  /* 기본요금         */
    UNSEAL_PRICE    TEXT DEFAULT '',  /* 기본요금         */
    
	PRIMARY KEY (
		REQUIRE_IDX
	)
);

/* 민원미납요금 */
CREATE TABLE MIN_UNPAID_PRICE (
	REQUIRE_IDX   	 INT NOT NULL , /*  민원인덱스(PK)(FK)    */
	CHE_MONTH   	 TEXT '' , 		/*  미납월    */
	CHE_PRICE    	 TEXT '' , 			/*  미납금액    */

	PRIMARY KEY (
		REQUIRE_IDX
	)
);

/* 민원법적비용 */
CREATE TABLE MIN_LEGAL_FEE (
	REQUIRE_IDX  INT NOT NULL, /* 수민원인덱스(PK)(FK) */
	LEGAL_JOB    TEXT DEFAULT '', 		/* 법적조치내용  */
	LEGAL_PRICE  TEXT DEFAULT '', 		/* 법적금액  */

	PRIMARY KEY (
		REQUIRE_IDX
	)
);

PRAGMA user_version = 4;
