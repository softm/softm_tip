
package com.entropykorea.gas.as.database;

import android.provider.BaseColumns;

// DataBase Table
public final class DBTable_MIN_CUR_PRICE {

  public static final class Columns implements BaseColumns {
    public final String REQUIRE_IDX = "REQUIRE_IDX";//민원인덱스(PK)(FK)
    public final String BF_METER    = "BF_METER";//전월지침
    public final String USE_AMOUNT  = "USE_AMOUNT";//사용량
    public final String USE_PRICE   = "USE_PRICE";//사용요금
    public final String BASE_PRICE  = "BASE_PRICE";//기본요금
               
    public static final String _TABLENAME = "MIN_CUR_PRICE";
  }
}