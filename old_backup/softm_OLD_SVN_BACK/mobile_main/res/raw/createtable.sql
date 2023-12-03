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

PRAGMA user_version = 1;
