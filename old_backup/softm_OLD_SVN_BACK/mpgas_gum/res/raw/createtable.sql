/* 사용자 */
CREATE TABLE USER (
	USER_ID TEXT NOT NULL, /* 아이디 */
	USER_NM TEXT NOT NULL, /* 사용자명 */
	PW TEXT NOT NULL, /* 비밀번호 */
	DEPT_CD TEXT, /* 부서코드 */
	HP_NO TEXT, /* 휴대전화번호 */
	LEVEL_CD TEXT, /* 관리레벨코드 */
	PW_CHANGE_DT TEXT, /* 비밀번호갱신일자 */
	PDA_USER_YN TEXT NOT NULL, /* 현장지원사용자여부 */
	AREA_CENTER_CD TEXT, /* 고객센터코드 */
	GUM_AUTH_YN TEXT NOT NULL, /* 검침권한여부 */
	CHG_AUTH_YN TEXT NOT NULL, /* 교체권한여부 */
	CHK_AUTH_YN TEXT NOT NULL, /* 점검권한여부 */
	REQ_AUTH_YN TEXT NOT NULL, /* 민원권한여부 */
	DEF_AUTH_YN TEXT NOT NULL, /* 체납권한여부 */

	PRIMARY KEY (
		USER_ID
	)
);

/* 코드 */
CREATE TABLE CODE (
	TYPE_CD TEXT NOT NULL, /* 구분코드 */
	CD TEXT NOT NULL, /* 코드 */
	CD_NM TEXT NOT NULL, /* 코드명 */
	MGT_CHAR1 TEXT, /* 관리문자1 */
	MGT_CHAR2 TEXT, /* 관리문자2 */
	MGT_CHAR3 TEXT, /* 관리문자3 */
	MGT_CHAR4 TEXT, /* 관리문자4 */
	MGT_CHAR5 TEXT, /* 관리문자5 */
	MGT_CHAR6 TEXT, /* 관리문자6 */
	MGT_NUM1 NUMERIC, /* 관리숫자1 */
	MGT_NUM2 NUMERIC, /* 관리숫자2 */
	ORD INTEGER, /* 정렬 */
	REMARK TEXT, /* 비고 */

	PRIMARY KEY (
		TYPE_CD, 
		CD
	)
);

/* 고객센터 */
CREATE TABLE AREA_CENTER (
	AREA_CENTER_CD TEXT NOT NULL, /* 고객센터코드 */
	AREA_CENTER_NM TEXT NOT NULL, /* 고객센터명 */
	TEL_NO TEXT, /* 전화번호 */

	PRIMARY KEY (
		AREA_CENTER_CD
	)
);

/* 공급자 */
CREATE TABLE PROVIDER (
	CO_NM TEXT, /* 공급자명 */
	CO_NO TEXT NOT NULL, /* 사업자번호 */
	CEO_NM TEXT NOT NULL, /* 대표자명 */
	ADDR TEXT, /* 주소 */
	ROAD_ADDR1 TEXT, /* 도로명주소1 */
	ROAD_ADDR2 TEXT, /* 도로명주소2 */
	TEL_NO TEXT, /* 전화번호 */
	VAN_NO  TEXT, /* 단말기번호 */
	VAN_CARD_NO TEXT /* 신용카드VAN번호 */
);

/* 중계검침 */
CREATE TABLE GUM (
	READ_IDX NUMBER NOT NULL, /*검침인덱스(PK) */
	BILL_YM TEXT NOT NULL, /* 작업년월 */
	TURN TEXT NOT NULL, /* 차수 */
	METER_CREATE_DT TEXT NOT NULL, /* 검침생성일자 */
	HOUSE_NO TEXT NOT NULL, /* 수용가번호 */
	EQUIP_CD TEXT, /* 기기번호코드 */
	HOUSE_ORD INTEGER, /* 세대순로  */
	AREA_CD TEXT NOT NULL, /* 지역코드 */
	SECTOR_CD TEXT NOT NULL, /* 구역코드 */
	COMPLEX_CD TEXT NOT NULL, /* 단지코드 */
	BLDG_CD TEXT NOT NULL, /* 건물코드 */
	AREA_NM TEXT, /* 지역명 */
	SECTOR_NM TEXT, /* 구역명 */
	COMPLEX_NM TEXT, /* 단지명 */
	BLDG_NM TEXT, /* 건물명 */
	BLDG_NO TEXT, /* 번지 */
	ROOM_NO TEXT, /* 호수 */
	ROAD_ADDR TEXT, /* 도로명 */
	CUST_NO TEXT, /* 고객번호 */
	CUST_NM TEXT, /* 성명 */
	CO_NM TEXT, /* 상호 */
	TEL_NO TEXT, /* 전화번호 */
	HP_NO TEXT, /* 핸드폰번호 */
	WORK_TEL_NO TEXT, /* 직장전화번호 */
	TEL_CD TEXT, /* 주전화번호구분코드 */
	CLAIM_CUST_YN TEXT, /* 클레임고객여부 */
	CLAIM_CONTENT TEXT, /* 클레임내용 */
	GM_NO TEXT, /* 계량기번호 */
	CHE_MONTH NUMBER, /* 체납개월 */
	CHE_PRICE NUMBER, /* 체납금액 */
	KIND_CD TEXT, /* 계량기종류코드 */
	INSTALL_METER INTEGER, /* 설치지침 */
	STATUS_DT TEXT, /* 중지일자 */
	STATUS_METER INTEGER, /* 중지지침 */
	MV_IN_DATE TEXT, /* 전입일자  */
	MV_IN_METER INTEGER, /* 전입지침  */
	CHG_DT TEXT, /* 교체일자  */
	CHG_REMOVE_METER INTEGER, /* 교체철거지침  */
	CHG_INSTALL_METER INTEGER, /* 교체설치지침  */
	USE_BGM_YN TEXT DEFAULT 'N', /* 보정기사용여부 */
	INSTALL_LOC_CD TEXT, /* 설치위치코드  GM060 */
	STATUS_CD TEXT, /*	수용가상태코드 */
	STATUS_DTL_CD TEXT, /* 수용가상태상세코드 */
	BF_YY_USE_AMT NUMBER, /* 전년동월사용량 */
	BF_MM_METER_CD TEXT, /* 전월검침코드 */
	BF_MM_METER TEXT, /* 전월검침지침  */
	BF_MM_USE_AMT  NUMBER, /* 전월사용량  */
	BF_MM_ADJ_METER INTEGER, /* 전월보정지침 */
	BF_MM_UN_ADJ_METER INTEGER, /* 전월비보정지침 */
	BF_MM_TEMPER NUMERIC, /* 전월온도 */
	BF_MM_PRESSURE NUMERIC, /* 전월압력 */
	BF_MM_REV_FACTOR NUMERIC, /* 전월보정계수 */
	BF_MM_COMP_FACTOR NUMERIC, /* 전월압축계수 */
	BF_MM_OIL_YN TEXT, /* 전월오일이상유무 */
	BF_MM_BATTERY_YN TEXT, /* 전월보정기배터리이상유무 */
	METER_CD TEXT, /* 당월검침코드 */
	METER INTEGER, /* 당월검침지침 */
	ADJ_METER INTEGER, /* 당월보정지침 */
	UN_ADJ_METER INTEGER, /* 당월비보정지침 */
	TEMPER NUMERIC, /* 당월온도 */
	PRESSURE NUMERIC, /* 당월압력 */
	REV_FACTOR NUMERIC, /* 당월보정계수 */
	COMP_FACTOR NUMERIC, /* 당월압축계수 */
	OIL_YN TEXT, /* 당월오일이상유무 */
	BATTERY_YN TEXT, /* 당월보정기배터리이상유무 */
	PDA_METER_ERROR_YN TEXT, /* 계량기이상유무 */
	METER_USER_CD TEXT, /* 검침작업자 */
	METER_DT TEXT, /* 당월검침일자 */
	METER_TIME TEXT, /* 당월검침시간 */
	END_YN TEXT DEFAULT 'N', /* 완료여부 */
	SEND_YN TEXT DEFAULT 'N', /* 송신여부 */

	PRIMARY KEY (
		READ_IDX ,
		BILL_YM ,
		TURN ,
		METER_CREATE_DT ,
		BLDG_CD,
		HOUSE_NO 
		/*HOUSE_ORD*/  
	)
);

CREATE INDEX GUM_HOUSE_ORD_INDEX ON GUM (HOUSE_ORD);

/* 검침생성일자 */
CREATE TABLE GUM_CREATE_DT (
	METER_CREATE_DT TEXT NOT NULL ,/* 검침생성일자 */

	PRIMARY KEY (
		METER_CREATE_DT
	)
);

/* 중계검침고객정보수정 */
CREATE TABLE GUM_CUST (
	READ_IDX NUMBER NOT NULL, /* 검침인덱스 */
	BILL_YM TEXT NOT NULL, /* 작업년월 */
	TURN TEXT NOT NULL, /* 차수 */
	METER_CREATE_DT TEXT NOT NULL, /* 검침생성일자 */
	HOUSE_NO TEXT NOT NULL, /* 수용가번호 */
	CUST_NO TEXT, /* 고객번호 */
	CUST_NM TEXT, /* 고객명 */
	TEL_NO TEXT, /* 전화번호 */
	WORK_TEL_NO TEXT, /* 직장전화번호 */
	HP_NO TEXT, /* 핸드폰번호 */
	TEL_CD TEXT, /* 주전화번호구분코드 */
	SEND_YN TEXT DEFAULT 'N' ,/* 송신여부 */

	PRIMARY KEY (
		READ_IDX,
		BILL_YM ,
		TURN ,
		METER_CREATE_DT ,
		HOUSE_NO
	)
);

PRAGMA user_version = 3;
