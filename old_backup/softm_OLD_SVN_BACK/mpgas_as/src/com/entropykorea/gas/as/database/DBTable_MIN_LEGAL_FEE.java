
package com.entropykorea.gas.as.database;

import android.provider.BaseColumns;

// DataBase Table
public final class DBTable_MIN_LEGAL_FEE {

    public static final class Columns implements BaseColumns {
    public final String REQUIRE_IDX = "REQUIRE_IDX";// (PK)(FK) 수용가번호(PK)(FK)
    public final String CUST_NO = "CUST_NO";// (PK)(FK) 고객번호(PK)(FK)
    public final String LEGAL_JOB = "LEGAL_JOB";// 법적조치내용
    public final String LEGAL_PRICE = "LEGAL_PRICE";// 법적금액
    
    public static final String _TABLENAME = "MIN_LEGAL_FEE";

    }
}
