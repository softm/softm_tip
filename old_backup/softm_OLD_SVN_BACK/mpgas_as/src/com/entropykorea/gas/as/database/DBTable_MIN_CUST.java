
package com.entropykorea.gas.as.database;

import android.provider.BaseColumns;

// DataBase Table
public final class DBTable_MIN_CUST {

    public static final class Columns implements BaseColumns {
    public final String REQUIRE_IDX = "REQUIRE_IDX";// (PK)(FK) 민원인덱스(PK)(FK)
    public final String HOUSE_NO = "HOUSE_NO";// (PK) 수용가번호
    public final String FAKE_HOUSE_NO = "FAKE_HOUSE_NO";// (PK) 가수용가번호
    public final String CUST_NO = "CUST_NO";// (PK) 고객번호
    public final String CUST_NM = "CUST_NM";// 고객명
    public final String TEL_NO = "TEL_NO";// 전화번호
    public final String WORK_TEL_NO = "WORK_TEL_NO";// 직장전화번호
    public final String HP_NO = "HP_NO";// 핸드폰번호
    public final String TEL_CD = "TEL_CD";// 주전화번호구분코드
    public final String SEND_YN = "SEND_YN";// 송신여부
    
    public static final String _TABLENAME = "MIN_CUST";
    }
}
