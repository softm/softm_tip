
package com.entropykorea.gas.as.database;

import android.provider.BaseColumns;

// DataBase Table
public final class DBTable_PROVIDER {

    public static final class Columns implements BaseColumns {
    public final String CO_NM = "CO_NM";// 공급자명
    public final String CEO_NM = "CEO_NM";// 대표자명
    public final String CO_NO = "CO_NO";// 사업자번호
    public final String ADDR = "ADDR";// 주소
    public final String ROAD_ADDR1 = "ROAD_ADDR1";// 도로명주소1
    public final String ROAD_ADDR2 = "ROAD_ADDR2";// 도로명주소2
    public final String TEL_NO = "TEL_NO";// 전화번호
    public final String VAN_NO = "VAN_NO";// 가맹점번호
    public final String VAN_CARD_NO = "VAN_CARD_NO";// 신용카드VAN번호
    
    public static final String _TABLENAME = "PROVIDER";

    }
}
