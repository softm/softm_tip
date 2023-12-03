package com.entropykorea.gas.gum.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;


public class GumSpec extends BaseSpec {

	private String fileName = "gum.dat";
	private String tableName = "GUM";
	private FieldSpec[] fieldSpecs = {
		new FieldSpec("READ_IDX",            10 , true, false), // 검침인덱스(PK)
		new FieldSpec("BILL_YM",             6  , true, false), // 작업년월(PK)
		new FieldSpec("TURN",                10 , true, false), // 차수(PK)
		new FieldSpec("METER_CREATE_DT",     8  , true, false), // 검침생성일자(PK)
		new FieldSpec("HOUSE_NO",            13 , true, false), // 수용가번호(PK)
		new FieldSpec("EQUIP_CD",            20 , false, false), // 기기번호코드
		new FieldSpec("HOUSE_ORD",           10 , false, false), // 세대순로 
		new FieldSpec("AREA_CD",             1  , false, false), // 지역코드
		new FieldSpec("SECTOR_CD",           3  , false, false), // 구역코드
		new FieldSpec("COMPLEX_CD",          7  , false, false), // 단지코드
		new FieldSpec("BLDG_CD",             10 , false, false), // 건물코드
		new FieldSpec("AREA_NM",             50 , false, false), // 지역명
		new FieldSpec("SECTOR_NM",           50 , false, false), // 구역명
		new FieldSpec("COMPLEX_NM",          50 , false, false), // 단지명
		new FieldSpec("BLDG_NM",             50 , false, false), // 건물명
		new FieldSpec("BLDG_NO",             50 , false, false), // 번지
		new FieldSpec("ROOM_NO",             50 , false, false), // 호수
		new FieldSpec("ROAD_ADDR",           50 , false, false), // 도로명
		new FieldSpec("CUST_NO",             10 , false, false), // 고객번호
		new FieldSpec("CUST_NM",             50 , false, false), // 성명
		new FieldSpec("CO_NM",               50 , false, false), // 상호
		new FieldSpec("TEL_NO",              30 , false, false), // 전화번호
		new FieldSpec("HP_NO",               30 , false, false), // 핸드폰번호
		new FieldSpec("WORK_TEL_NO",         30 , false, false), // 직장전화번호
		new FieldSpec("TEL_CD",              20 , false, false), // 주전화번호구분코드
		new FieldSpec("CLAIM_CUST_YN",       1  , false, false), // 클레임고객여부
		new FieldSpec("CLAIM_CONTENT",       500, false, false), // 클레임내용
		new FieldSpec("GM_NO",               20 , false, false), // 계량기번호
		new FieldSpec("CHE_MONTH",           10 , false, false), // 체납개월
		new FieldSpec("CHE_PRICE",           10 , false, false), // 체납금액
		new FieldSpec("KIND_CD",             20 , false, false), // 계량기종류코드
		new FieldSpec("INSTALL_METER",       10 , false, false), // 설치지침
		new FieldSpec("STATUS_DT",           8  , false, false), // 중지일자
		new FieldSpec("STATUS_METER",        10 , false, false), // 중지지침
		new FieldSpec("MV_IN_DATE",          8  , false, false), // 전입일자 
		new FieldSpec("MV_IN_METER",         10 , false, false), // 전입지침 
		new FieldSpec("CHG_DT",              8  , false, false), // 교체일자 
		new FieldSpec("CHG_REMOVE_METER",    10 , false, false), // 교체철거지침 
		new FieldSpec("CHG_INSTALL_METER",   10 , false, false), // 교체설치지침 
		new FieldSpec("USE_BGM_YN",          1  , false, false), // 보정기사용여부
		new FieldSpec("INSTALL_LOC_CD",      20 , false, false), // 설치위치구분
		new FieldSpec("STATUS_CD",           20 , false, false), // 수용가상태코드
		new FieldSpec("STATUS_DTL_CD",       20 , false, false), // 수용가상태상세코드
		new FieldSpec("BF_YY_USE_AMT",       10 , false, false), // 전년동월사용량
		new FieldSpec("BF_MM_METER_CD",      20 , false, false), // 전월검침코드
		new FieldSpec("BF_MM_METER",         10 , false, false), // 전월검침지침 
		new FieldSpec("BF_MM_USE_AMT",       10 , false, false), // 전월사용량 
		new FieldSpec("BF_MM_ADJ_METER",     10 , false, false), // 전월보정지침
		new FieldSpec("BF_MM_UN_ADJ_METER",  10 , false, false), // 전월비보정지침
		new FieldSpec("BF_MM_TEMPER",        10 , false, false), // 전월온도
		new FieldSpec("BF_MM_PRESSURE",      10 , false, false), // 전월압력
		new FieldSpec("BF_MM_REV_FACTOR",    10 , false, false), // 전월보정계수
		new FieldSpec("BF_MM_COMP_FACTOR",   10 , false, false), // 전월압축계수
		new FieldSpec("BF_MM_OIL_YN",        1  , false, false), // 전월오일이상유무
		new FieldSpec("BF_MM_BATTERY_YN",    1  , false, false), // 전월보정기배터리이상유무
		new FieldSpec("METER_CD",            20 , false, false), // 당월검침코드
		new FieldSpec("METER",               10 , false, false), // 당월검침지침
		new FieldSpec("ADJ_METER",           10 , false, false), // 당월보정지침
		new FieldSpec("UN_ADJ_METER",        10 , false, false), // 당월비보정지침
		new FieldSpec("TEMPER",              10 , false, false), // 당월온도
		new FieldSpec("PRESSURE",            10 , false, false), // 당월압력
		new FieldSpec("REV_FACTOR",          10 , false, false), // 당월보정계수
		new FieldSpec("COMP_FACTOR",         10 , false, false), // 당월압축계수
		new FieldSpec("OIL_YN",              1  , false, false), // 당월오일이상유무
		new FieldSpec("BATTERY_YN",          1  , false, false), // 당월보정기배터리이상유무
		new FieldSpec("PDA_METER_ERROR_YN",  1  , false, false), // 계량기이상유무
		new FieldSpec("METER_USER_CD",       20 , false, false), // 검침작업자
		new FieldSpec("METER_DT",            8  , false, false), // 당월검침일자
		new FieldSpec("METER_TIME",          6  , false, false), // 당월검침시간
		new FieldSpec("END_YN",              1  , false, false), // 완료여부
		new FieldSpec("SEND_YN",	         1  , false, false), // 송신여부
		
	};
	
	public String whereClause = null;//"WHERE USER_ID = 'test'";
	public String selectClause = null;
	
	@Override
	public String getFileName() {
		return fileName;
	}
	
	@Override
	public String getTableName() {
		return tableName;
	}
	
	@Override
	public FieldSpec[] getFieldSpecs() {
		return fieldSpecs;
	}

	@Override
	public String getWhereClause() {
		return whereClause;
	}

	@Override
	public String getSelectClause() {
		return selectClause;
	}

}
