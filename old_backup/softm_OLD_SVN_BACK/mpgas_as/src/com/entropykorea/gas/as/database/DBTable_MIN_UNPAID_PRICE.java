
package com.entropykorea.gas.as.database;

import android.provider.BaseColumns;

// DataBase Table
public final class DBTable_MIN_UNPAID_PRICE {

    public static final class Columns implements BaseColumns {
    public final String REQUIRE_IDX = "REQUIRE_IDX";// (PK)(FK) 수용가번호(PK)(FK)
    public final String CHE_MONTH = "CHE_MONTH";// 미납월
    public final String CHE_PRICE = "CHE_PRICE";// 미납금액
    
    public static final String _TABLENAME = "MIN_UNPAID_PRICE";

    }
}
