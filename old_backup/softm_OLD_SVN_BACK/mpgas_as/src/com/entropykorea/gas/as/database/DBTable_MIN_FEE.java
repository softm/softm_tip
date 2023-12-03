
package com.entropykorea.gas.as.database;

import android.provider.BaseColumns;

// DataBase Table
public final class DBTable_MIN_FEE {

  public static final class Columns implements BaseColumns {
    public final String AREA_CD = "AREA_CD";// 물품코드(PK)
    public final String ITEM_CD = "ITEM_CD";// 물품코드(PK)
    public final String ITEM_NM = "ITEM_NM";// 물품
    public final String PROC_UNIT_PRICE = "PROC_UNIT_PRICE";// 단가
               
    public static final String _TABLENAME = "MIN_FEE";
  }
}