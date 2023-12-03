package com.entropykorea.gas.as.database;

import android.provider.BaseColumns;

// DataBase Table
public final class DBTable_AREA_CENTER {
  
  public static final class Columns implements BaseColumns {
    public final String AREA_CENTER_CD = "AREA_CENTER_CD";// 고객센터코드(PK)
    public final String AREA_CENTER_NM = "AREA_CENTER_NM";// 고객센터명
    public final String TEL_NO = "TEL_NO";// 전화번호
    
    public static final String _TABLENAME = "AREA_CENTER";
    
  }
}
