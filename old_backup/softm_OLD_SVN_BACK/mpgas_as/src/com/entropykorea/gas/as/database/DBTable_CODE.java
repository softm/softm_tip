
package com.entropykorea.gas.as.database;

import android.provider.BaseColumns;

// DataBase Table
public final class DBTable_CODE {

    public static final class Columns implements BaseColumns {
    public final String TYPE_CD = "TYPE_CD";// (PK) 구분코드(PK)
    public final String CD = "CD";// (PK) 코드(PK)
    public final String CD_NM = "CD_NM";// 코드명
    public final String MGT_CHAR1 = "MGT_CHAR1";// 관리문자1
    public final String MGT_CHAR2 = "MGT_CHAR2";// 관리문자2
    public final String MGT_CHAR3 = "MGT_CHAR3";// 관리문자3
    public final String MGT_CHAR4 = "MGT_CHAR4";// 관리문자4
    public final String MGT_CHAR5 = "MGT_CHAR5";// 관리문자5
    public final String MGT_CHAR6 = "MGT_CHAR6";// 관리문자6
    public final String MGT_NUM1 = "MGT_NUM1";// 관리숫자1
    public final String MGT_NUM2 = "MGT_NUM2";// 관리숫자2
    public final String ORD = "ORD";// 정렬
    public final String REMARK = "REMARK";// 비고
    
    public static final String _TABLENAME = "CODE";
       
    }
}
