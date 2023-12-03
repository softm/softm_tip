
package com.entropykorea.gas.as.database;

import android.provider.BaseColumns;

// DataBase Table
public final class DBTable_MIN_FEE_PAY {

  public static final class Columns implements BaseColumns {
    public final String REQUIRE_IDX = "REQUIRE_IDX";// (PK)(FK) 민원인덱스(PK)(FK)
    public final String AREA_CD = "AREA_CD";// (PK) 지역코드(PK)
    public final String ITEM_CD = "ITEM_CD";// (PK) 물품코드(PK)
    public final String PROC_UNIT_PRICE = "PROC_UNIT_PRICE";// 처리단가
    public final String PROC_QTY = "PROC_QTY";// 처리수량
               
    public static final String _TABLENAME = "MIN_FEE_PAY";

    }
}
