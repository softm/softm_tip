package com.entropykorea.gas.chk.common;

import org.apache.commons.lang3.StringUtils;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;

import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.chk.WApplication;
import com.entropykorea.gas.chk.dto.ChkBoilerDTO;
import com.entropykorea.gas.chk.dto.ChkCountDTO;
import com.entropykorea.gas.chk.dto.ChkDTO;
import com.entropykorea.gas.lib.AppContext;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.Util;
/**
 * DUtil
 * 데이터베이스 유틸
 * @author softm
 */
public class DUtil {

    public static Sqlite getSqlite() {
        return new Sqlite( AppContext.getSQLiteDatabase() );
    }

    /**
     * job_cd별 Data수 수신년월
     * @param Context
     * @return
     */
    public static String getCurrentChkYYYYMM(Context context,String checkupCd) {
        String whereJobCd = StringUtils.isEmpty(checkupCd)?"":" WHERE CHECKUP_CD = '" + checkupCd + "'";

        Sqlite sqlite = getSqlite();
        sqlite.rawQuery("SELECT MAX(IFNULL(CHECKUP_YM,'')) FROM "
                + WConstant.TBL_JUM
                + whereJobCd
                );
        String rtn = "";
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            rtn = WUtil.toDefault(sqlite.getValue(0));
        }
        return rtn;
    }

    /**
     * 수용가번호 얻기 By 계량기번호 ( GM_NO )
     * @param Context
     * @return
     */
    public static ChkDTO getKeyByGmNo(Context context,String gm_no) {
        String sql = "SELECT "
                + "  COUNT(*) CNT"
                + ", CHECKUP_YM "
                + ", CHECKUP_CD "
                + ", HOUSE_NO "
                + ", FAKE_HOUSE_NO "
                + " FROM " + WConstant.TBL_JUM
                + " WHERE GM_NO = '" + gm_no + "'"
                + " GROUP BY GM_NO"
        ;
        ChkDTO v = new ChkDTO();
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            v.setCount      (sqlite.getValueInteger("CNT"                   ));
            v.setCheckupYm      (WUtil.toDefault(sqlite.getValue("CHECKUP_YM"       )));
            v.setCheckupCd      (WUtil.toDefault(sqlite.getValue("CHECKUP_CD"       )));
            v.setHouseNo    (WUtil.toDefault(sqlite.getValue("HOUSE_NO"     )));
            v.setFakeHouseNo(WUtil.toDefault(sqlite.getValue("FAKE_HOUSE_NO")));
        }
        return v;
    }

//    /**
//     * 상태별 Data수
//     * @param Context
//     * @return ChkCountDTO
//     */
    public static ChkCountDTO getChkCount(Context context,String checkupCd) {
        String whereJobCd = StringUtils.isEmpty(checkupCd)?"":" AND CHECKUP_CD = '" + checkupCd + "'";

        String sql = " SELECT "
                + "       MAX( CASE GB WHEN 'C'  THEN CNT ELSE 0 END) V1 "
                + "     , MAX( CASE GB WHEN 'NC' THEN CNT ELSE 0 END) V2 "
                + "     , MAX( CASE GB WHEN 'NS' THEN CNT ELSE 0 END) V3 "
                + " FROM "
                + " ( "
//              + "     SELECT 'C' GB, COUNT(*) CNT FROM " + WConstant.TBL_JUM + " WHERE END_YN = 'Y' AND SEND_YN = 'Y'" + whereJobCd
                + "     SELECT 'C' GB, COUNT(*) CNT FROM " + WConstant.TBL_JUM + " WHERE END_YN = 'Y' " + whereJobCd
                + "     UNION "
//                + "     SELECT 'NC', COUNT(*) FROM " + WConstant.TBL_JUM + " WHERE END_YN = 'N' AND SEND_YN = 'N' " + whereJobCd
                + "     SELECT 'NC', COUNT(*) FROM " + WConstant.TBL_JUM + " WHERE END_YN = 'N' " + whereJobCd
                + "     UNION "
                + "     SELECT 'NS', COUNT(*) FROM " + WConstant.TBL_JUM + " WHERE END_YN = 'Y' AND SEND_YN = 'N' " + whereJobCd
                + " ) a "
        ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        ChkCountDTO v = new ChkCountDTO();
        int v1 = 0, v2 = 0, v3 = 0;
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            v1 = sqlite.getValueInteger("V1");
            v2 = sqlite.getValueInteger("V2");
            v3 = sqlite.getValueInteger("V3");
            v.setCompleteCount(v1);
            v.setNotCompleteCount(v2);
            v.setNotSendCount(v3);
        }
        Util.d(WConstant.LOG_TAG,"C : "+ v1 +" / NC : " + v2 + " / NS : "+ v3);
        return v;
    }

    /**
     * job_cd별 송신가능수
     * @param Context
     * @return
     */
    public static int getSendableCount(Context context,String checkupCd) {
        // END_YN = 'Y' AND SEND_YN = 'N'
        return getDataCount(context,checkupCd,"Y","N");
    }

    /**
     * Data수 송신상태별
     * @param Context
     * @return
     */
    public static int getDataCount(Context context,String checkupCd, String endYn,String sendYn) {
        String sql = "SELECT COUNT(*) FROM "
                + WConstant.TBL_JUM
                + " WHERE 1 = 1"
                + ( !StringUtils.isEmpty(checkupCd ) ? " AND CHECKUP_CD  = '"+checkupCd +"'" : "" )
                + ( !StringUtils.isEmpty(endYn ) ? " AND END_YN  = '"+endYn +"'" : "" )
                + ( !StringUtils.isEmpty(sendYn) ? " AND SEND_YN = '"+sendYn+"'" : "" )
        ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        int cnt = 0;
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            cnt = Integer.parseInt(sqlite.getValue(0),10);
            Util.d(WConstant.LOG_TAG,""+cnt);
        }
        return cnt;
    }

    /**
     * job_cd별 Data수 송신상태별
     * @param context
     * @return
     */
    public static int getDataCount(Context context,String checkupCd) {
        return getDataCount(context,checkupCd,null,null);
    }

    /**
     * 전체 Data수 송신상태별
     * @param context
     * @return
     */
    public static int getDataCount(Context context) {
        return getDataCount(context,null,null,null);
    }

    /**
     * Data수 조건절 지정.
     * @param Context
     * @return
     */
    public static int getDataCountByWhere(Context context,String where) {
        String sql = "SELECT COUNT(*) FROM "
                + WConstant.TBL_JUM
                + where
        ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        int cnt = 0;
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            cnt = Integer.parseInt(sqlite.getValue(0),10);
            Util.d(WConstant.LOG_TAG,""+cnt);
        }
        return cnt;
    }

    /**
     * 방문이력 Data수
     * @param Context
     * @return
     */
    public static int getVisitDataCount(Context context,String checkupYm,String checkupCd,String houseNo,String fakeHouseNo) {
        String sql = "SELECT COUNT(*) FROM "
                + WConstant.TBL_JUM_VISIT
                + " JOIN " + WConstant.TBL_JUM
                + "   ON JUM_VISIT.CHECKUP_IDX = JUM.CHECKUP_IDX "
                + " WHERE JUM.CHECKUP_YM  = '"+checkupYm +"'"
                + ( !StringUtils.isEmpty(checkupCd ) ? " AND JUM.CHECKUP_CD  = '"+checkupCd +"'" : "" )
                + " AND JUM.HOUSE_NO  = '"+houseNo +"'"
                + " AND IFNULL(JUM.FAKE_HOUSE_NO,'') = '"+fakeHouseNo +"'"
        ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        int cnt = 0;
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            cnt = Integer.parseInt(sqlite.getValue(0),10);
            Util.d(WConstant.LOG_TAG,""+cnt);
        }
        return cnt;
    }

    /**
     * 방문이력 Data수
     * @param Context
     * @return
     */
    public static int getVisitDataCount(Context context,String checkupYm,String houseNo,String fakeHouseNo) {
        return DUtil.getVisitDataCount(context, checkupYm, null, houseNo, fakeHouseNo);
    }

    /**
     * Data수 송신상태별 삭제
     * @param Context
     * @return
     */
    public static boolean deleteData(Context context,String checkupCd,String endYn,String sendYn) {
        WApplication mApp = (WApplication) context;
        SQLiteDatabase db = mApp.getDatabase();
        boolean rtn = false;
        try {
            db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM_PHOTO + " WHERE CHECKUP_IDX IN ( SELECT CHECKUP_IDX FROM " + WConstant.TBL_JUM+" WHERE CHECKUP_CD   = '" + checkupCd   + "')");
            db.execSQL("DELETE FROM " + WConstant.TBL_JUM_VISIT       + " WHERE CHECKUP_IDX IN ( SELECT CHECKUP_IDX FROM " + WConstant.TBL_JUM+" WHERE CHECKUP_CD   = '" + checkupCd   + "')");
            db.execSQL("DELETE FROM " + WConstant.TBL_JUM_BOILER      + " WHERE CHECKUP_IDX IN ( SELECT CHECKUP_IDX FROM " + WConstant.TBL_JUM+" WHERE CHECKUP_CD   = '" + checkupCd   + "')");
            db.execSQL("DELETE FROM " + WConstant.TBL_JUM_CUST        + " WHERE CHECKUP_IDX IN ( SELECT CHECKUP_IDX FROM " + WConstant.TBL_JUM+" WHERE CHECKUP_CD   = '" + checkupCd   + "')");
            db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOCFM       + " WHERE CHECKUP_IDX IN ( SELECT CHECKUP_IDX FROM " + WConstant.TBL_JUM+" WHERE CHECKUP_CD   = '" + checkupCd   + "')");
            db.execSQL("DELETE FROM " + WConstant.TBL_JUM_NOIMP       + " WHERE CHECKUP_IDX IN ( SELECT CHECKUP_IDX FROM " + WConstant.TBL_JUM+" WHERE CHECKUP_CD   = '" + checkupCd   + "')");
            db.execSQL("DELETE FROM " + WConstant.TBL_JUM_EXCEPTION   + " WHERE CHECKUP_IDX IN ( SELECT CHECKUP_IDX FROM " + WConstant.TBL_JUM+" WHERE CHECKUP_CD   = '" + checkupCd   + "')");
/*            
            String sql2 = "SELECT "
                    + " CHECKUP_YM "
                    + ",CHECKUP_CD "
                    + ",HOUSE_NO "
                    + ",FAKE_HOUSE_NO "
                    + " FROM " + WConstant.TBL_JUM
                    + " WHERE CHECKUP_CD   = '" + checkupCd + "'"
            ;
            Sqlite sqlite = getSqlite();
            sqlite.rawQuery(sql2);
            int i = -1;
            sqlite.moveToFirst();
            do {
                i++;
                String checkupYm = sqlite.getValue("CHECKUP_YM", i);
                String houseNo = sqlite.getValue("HOUSE_NO", i);
                String fakeHouseNo = sqlite.getValue("FAKE_HOUSE_NO", i);
                try { // 사진 삭제
                    // 부적합
                    // 방문 (3회시촬영)
                    Util.deleteFilesWithPrefix(Constant.PIC_DIR, "P_"+checkupYm+checkupCd+houseNo+fakeHouseNo);
                } catch ( Exception ex ) {}
                try { // 서명삭제
                    Util.deleteFilesWithPrefix(Constant.SIGN_DIR, "S_"+checkupYm+checkupCd+houseNo+fakeHouseNo);
                } catch ( Exception ex ) {}
            } while (sqlite.moveToNext());
            
*/
            WUtil.deleteFiles(Constant.PIC_DIR , "P_?????"+checkupCd+"*");
            WUtil.deleteFiles(Constant.SIGN_DIR, "S_?????"+checkupCd+"*");
            
            String sql = "DELETE FROM "
                    + WConstant.TBL_JUM
                    + " WHERE 1 = 1"
                    + ( !StringUtils.isEmpty(checkupCd ) ? " AND CHECKUP_CD  = '"+checkupCd +"'" : "" )
                    + ( !StringUtils.isEmpty(endYn ) ? " AND END_YN  = '"+endYn +"'" : "" )
                    + ( !StringUtils.isEmpty(sendYn) ? " AND SEND_YN = '"+sendYn+"'" : "" )
            ;
            db.execSQL(sql);
//            Util.d("MPGAS",sql);
            rtn = true;
        } catch( Exception ex ) {
            Util.d("MPGAS",ex.toString());
        } finally {
        }
        return rtn;
    }

    /**
     * job_cd별 Data수 송신상태별 삭제
     * @param context
     * @return
     */
    public static boolean deleteData(Context context,String checkupCd) {
        return deleteData(context,checkupCd,null,null);
    }
    /**
     * 전체 Data수 송신상태별 삭제
     * @param context
     * @return
     */
    public static boolean deleteData(Context context) {
        return deleteData(context,null,null,null);
    }

    /**
     * 교체정보등록이 안된 수.
     * 교체후계량기번호가 등록안된수.
     * @param Context
     * @return
     */
    public static int getChgInfoNotRegCountByBldgCd(Context context,String bldgCd) {
        String sql = "SELECT COUNT(*) FROM "
                + WConstant.TBL_JUM
                + " WHERE BLDG_CD = '" + bldgCd + "'"
                + "   AND IFNULL(AF_GM_NO,'') IS NULL"
         ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        int cnt = 0;
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            cnt = Integer.parseInt(sqlite.getValue(0),10);
            Util.d(WConstant.LOG_TAG,""+cnt);
        }
        return cnt;
    }

    /**
     * 교체정보등록이 된 수.
     * 교체후계량기번호가 등록된수.
     * @param Context
     * @return
     */
    public static int getChgInfoRegCountByBldgCd(Context context,String bldgCd) {
        String sql = "SELECT COUNT(*) FROM "
                + WConstant.TBL_JUM
                + " WHERE BLDG_CD = '" + bldgCd + "'"
                + "   AND IFNULL(AF_GM_NO,'') IS NOT NULL"
        ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        int cnt = 0;
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            cnt = Integer.parseInt(sqlite.getValue(0),10);
            Util.d(WConstant.LOG_TAG,""+cnt);
        }
        return cnt;
    }

    /**
     * BLD_CD기준한 송신완료수
     * @param Context
     * @return
     */
    public static int getChgInfoSendYCountByBldgCd(Context context,String bldgCd) {
        return getChgInfoSendCountByBldgCd(context,bldgCd,Constant.CODE_SEND_Y);
    }

    /**
     * BLD_CD기준한 송신미완료수
     * @param Context
     * @return
     */
    public static int getChgInfoSendNCountByBldgCd(Context context,String bldgCd) {
        return getChgInfoSendCountByBldgCd(context,bldgCd,Constant.CODE_SEND_N);
    }

    /**
     * BLD_CD기준한 송신수
     * @param Context
     * @return
     */
    public static int getChgInfoSendCountByBldgCd(Context context,String bldgCd,String sendYn) {
        String sql = "SELECT COUNT(*) CNT FROM "
                + WConstant.TBL_JUM
                + " WHERE BLDG_CD = '" + bldgCd + "'"
                + "   AND SEND_YN = '" + sendYn + "'"
         ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        sqlite.moveToFirst();
        int cnt = Integer.parseInt(sqlite.getValue("CNT"),10);
        Util.d(WConstant.LOG_TAG,""+cnt);
        return cnt;
    }


    /**
     * BLD_CD기준한 봉인수
     * @param Context
     * @return
     */
    public static int getChgInfoSealCountByBldgCd(Context context,String bldgCd) {
        String sql = "SELECT COUNT(*) CNT FROM "
                + WConstant.TBL_JUM
                + " WHERE BLDG_CD = '" + bldgCd + "'"
                + "   AND IFNULL(AF_SEAL_CD,'') IS NOT NULL"
         ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        sqlite.moveToFirst();
        int cnt = Integer.parseInt(sqlite.getValue("CNT"),10);
        Util.d(WConstant.LOG_TAG,""+cnt);
        return cnt;
    }

    /**
     * 수용건물명(예옥암동 1023 하당부영1차) BLDG_CD를 이용해 조회합니다. in 수용가목록
     * @param context
     * @param bldgCd
     * @param gb : ConstantW.CODE_GUBUN_ADDRESS / ConstantW.CODE_GUBUN_STREET
     * @return
     */
    public static String getHouseGroupNmByBldgCd(Context context,String bldgCd,String gb) {
        String sql = "SELECT "
                +
                (
                        gb.equals(Constant.CODE_GUBUN_ADDRESS)
                        ? " JUM.SECTOR_NM || ' ' || JUM.BLDG_NO || ' ' || JUM.COMPLEX_NM || ' ' || IFNULL(JUM.BLDG_NM,'') AS BLD_NM"  // 지번
                        : " JUM.ROAD_NM || ' ' || JUM.COMPLEX_NM || ' ' || IFNULL(JUM.BLDG_NM,'') AS BLD_NM "  // 도로명
                )
                + " FROM "
                + WConstant.TBL_JUM  + " JUM "
                + " WHERE BLDG_CD = '" + bldgCd + "'"
                ;
        Util.d(WConstant.LOG_TAG," sql : "+sql);
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);

        String rtn = "";
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            rtn = StringUtils.defaultString(sqlite.getValue(0));
        }
        return rtn;
    }

    /**
     * 교체시작 여부 ( 계량기번호가 입력되면 교체시작됨 : true, 없으면 : false )
     * 교체정보 등록여부 : 교체후계량기번호 입력으로 판단함.
     * @param context
     * @param checkup_ym
     * @param house_no
     * @param cust_no
     * @return
     */
    public static boolean isInputAfGmNo(Context context,String checkup_ym,String house_no,String cust_no) {
        String sql = "SELECT "
                + " AF_GM_NO " // 교체후계량기번호
                + " FROM " + WConstant.TBL_JUM
                + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
                + "   AND HOUSE_NO = '" + house_no + "'"
                + "   AND CUST_NO  = '" + cust_no  + "'"
        ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        boolean rtn = false;
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            String afGmNo = WUtil.toDefault(sqlite.getValue(0));
            rtn = !"".equals(afGmNo)?Boolean.TRUE:Boolean.FALSE;
            Util.d(WConstant.LOG_TAG,"isInputAfGmNo - sql : "+sql);
            Util.d(WConstant.LOG_TAG,"isInputAfGmNo : "+rtn);
        }
        return rtn;
    }

    /**
     * 점검취소시 값 초기화
     * @param Context
     * @return
     */
    public static boolean clearChKDataByKey(Context context, String checkupResultCd , String checkup_ym,String checkup_cd,String house_no,String fake_house_no) {
        WApplication mApp = (WApplication) context;
        SQLiteDatabase db = mApp.getDatabase();
        boolean rtn = false;
        try {
            String sql = "UPDATE "
                    + WConstant.TBL_JUM
                    + " SET END_YN              = '" + Constant.CODE_END_N +"'" // 완료여부
            ;
                sql +="   , BOILER_OK_YN        = '" +WConstant.CODE_CHECK_OK_NONE+ "'" // 보일러점검결과                 공백:미점검, Y: 적합, N: 부적합 , X: 기기없음
                    + "   , BURNER_OK_YN        = '" +WConstant.CODE_CHECK_OK_NONE+ "'" // 연소기점검결과                 공백:미점검, Y: 적합, N: 부적합 , X: 기기없음
                    + "   , PIPE_OK_YN          = '" +WConstant.CODE_CHECK_OK_NONE+ "'" // 배관점검결과                   공백:미점검, Y: 적합, N: 부적합 , X: 기기없음
                    + "   , GM_OK_YN            = '" +WConstant.CODE_CHECK_OK_NONE+ "'" // 계량기점검결과                 공백:미점검, Y: 적합, N: 부적합 , X: 기기없음
                    + "   , BREAKER_OK_YN       = '" +WConstant.CODE_CHECK_OK_NONE+ "'" // 차단기보일러점검결과           공백:미점검, Y: 적합, N: 부적합 , X: 기기없음
            ;
            if ( WConstant.CODE_CHECKUP_RESULT_CD_3.equals(checkupResultCd) ) { // 거부
//                sql +="   , CHECKUP_DT         = date()" // 점검일자                       점검일자
//                    + "   , CHECKUP_BEGIN_DT    = time()" // 점검시작시간                   점검시작시간
                sql +="   , CHECKUP_DT       = strftime('%Y%m%d','now','localtime')" // 점검일자
                    + "   , CHECKUP_BEGIN_DT = strftime('%H%M%S','now','localtime')" // 점검시작시간
                    + "   , CHECKUP_END_DT      = ''" // 점검종료시간                   점검종료시간
                ;
            } else { // 점검취소
                sql += "   , CHECKUP_DT         = ''" // 점검일자                       점검일자
                    + "   , CHECKUP_BEGIN_DT    = ''" // 점검시작시간                   점검시작시간
                    + "   , CHECKUP_END_DT      = ''" // 점검종료시간                   점검종료시간
                 ;
            }
            sql +="   , CHECKUP_USER_CD     = ''" // 점검작업자                     점검작업자
                + "   , CHECKUP_RESULT_CD   = '" + checkupResultCd + "'" // 점검결과                       점검결과 : 미점검 : 0
                                                                         // FA040   0   미점검
                                                                         // FA040   1   적합
                                                                         // FA040   2   부적합
                                                                         // FA040   3   거부
            ;
            sql +="   , CHECKUP_METER       = ''" // 점검지침                       점검지침
                + "   , GM_NO_CFM           = ''" // 확인계량기번호                 확인계량기번호
                + "   , QR_YN               = '" + Constant.CODE_N +"'" // 건물내부QR코드인식여부         건물내부QR코드인식여부
                + "   , PHOTO_FILE_NM       = ''" // 사진파일명                     3회차 방문
                + "   , SIGN_FILE_NM        = ''" // 서명파일명                     N/A
                + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
                + "   AND CHECKUP_CD   = '" + checkup_cd   + "'"
                + "   AND HOUSE_NO = '" + house_no + "'"
                + "   AND IFNULL(FAKE_HOUSE_NO,'')  = '" + fake_house_no  + "'"
            ;
            db.execSQL(sql);
            rtn = true;
        } catch( Exception ex ) {
            Util.d("MPGAS",ex.toString());
        } finally {
        }
        return rtn;
    }

    /**
     * 불회체납 정보 수정.
     * @param Context
     * @return
     */
    public static boolean updateChe(Context context,String checkup_ym,String house_no,String cust_no,int che_month_cnt, int che_price_sum) {
        WApplication mApp = (WApplication) context;
        SQLiteDatabase db = mApp.getDatabase();
        boolean rtn = false;
        try {
            String sql = "UPDATE "
                    + WConstant.TBL_JUM
                    + " SET CHE_MONTH_CNT   = '" + che_month_cnt   + "'" // 체납개월
                    + "   , CHE_PRICE_SUM   = '" + che_price_sum   + "'" // 체납금액
                    + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
                    + "   AND HOUSE_NO = '" + house_no + "'"
                    + "   AND CUST_NO  = '" + cust_no  + "'"
            ;
            db.execSQL(sql);
            rtn = true;
        } catch( Exception ex ) {
            Util.d("MPGAS",ex.toString());
        } finally {
        }
        return rtn;
    }

    /**
     * 점검정보 By Key
     * @param context
     * @param where
     * @return
     */
    public static ChkDTO getDataByWhere(Context context,String where) {
        String sql = "SELECT "
                + "    CHECKUP_IDX       "    // 안전점검인덱스
                + "  , CHECKUP_YM        "    // 작업년월
                + "  , CHECKUP_CD        "    // 업무코드
                + "  , HOUSE_NO          "    // 수용가번호
                + "  , FAKE_HOUSE_NO     "    // 가수용가번호
                + "  , EQUIP_CD          "    // 기기번호코드
                + "  , BLDG_ORD          "    // 건물순로
                + "  , HOUSE_ORD         "    // 세대순로
                + "  , AREA_CD           "    // 지역코드
                + "  , SECTOR_CD         "    // 구역코드
                + "  , COMPLEX_CD        "    // 단지코드
                + "  , BLDG_CD           "    // 건물코드
                + "  , AREA_NM           "    // 지역명
                + "  , SECTOR_NM         "    // 구역명
                + "  , COMPLEX_NM        "    // 단지명
                + "  , BLDG_NO           "    // 번지
                + "  , BLDG_NM           "    // 빌딩명
                + "  , ROOM_NO           "    // 동호수
                + "  , FAKE_ROOM_NO      "    // 가수용가명
                + "  , ROAD_NM           "    // 도로명
                + "  , CUST_NO           "    // 고객번호
                + "  , CUST_NM           "    // 고객명
                + "  , CO_NM             "    // 상호
                + "  , TEL_NO            "    // 고객전화번호
                + "  , HP_NO             "    // 고객핸드폰번호
                + "  , WORK_TEL_NO       "    // 직장전화번호
                + "  , TEL_CD            "    // 주전화번호구분코드
                + "  , STATUS_CD         "    // 수용가상태코드
                + "  , GM_NO             "    // 계량기번호
                + "  , INSTALL_LOC_CD    "    // 설치위치구분
                + "  , PURPOSE_CD        "    // 용도코드
                + "  , CHG_DT            "    // 교체일자
                + "  , CHG_METER         "    // 교체지침
                + "  , BF_METER          "    // 전월지침
                + "  , LAST_CHECKUP_DT   "    // 전점검일자
                + "  , LAST_CHECKUP_CD   "    // 전점검결과
                + "  , LAST_USER_CD      "    // 전점검작업자
                + "  , CHE_YN            "    // 체납여부
                + "  , GM_ERROR_YN       "    // 불회확인여부
                + "  , LONG_NO_CHECKUP_YN"    // 장기미점검여부
                + "  , LONG_ACCEPT_YN    "    // 장기인정고지세대여부
                + "  , BOILER_OK_YN      "    // 보일러점검결과
                + "  , BURNER_OK_YN      "    // 연소기점검결과
                + "  , PIPE_OK_YN        "    // 배관점검결과
                + "  , GM_OK_YN          "    // 계량기점검결과
                + "  , BREAKER_OK_YN     "    // 차단기보일러점검결과
                + "  , CHECKUP_DT        "    // 점검일자
                + "  , CHECKUP_BEGIN_DT  "    // 점검시작시간
                + "  , CHECKUP_END_DT    "    // 점검종료시간
                + "  , CHECKUP_USER_CD   "    // 점검작업자
                + "  , CHECKUP_RESULT_CD "    // 점검결과
                + "  , CHECKUP_METER     "    // 점검지침
                + "  , GM_NO_CFM         "    // 확인계량기번호
                + "  , QR_YN             "    // 건물내부QR코드인식여부
                + "  , PHOTO_FILE_NM     "    // 사진파일명
                + "  , SIGN_FILE_NM      "    // 서명파일명
                + "  , END_YN            "    // 완료여부
                + "  , SEND_YN           "    // 전송여부
                + "FROM " + WConstant.TBL_JUM
                + where
//                + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
//                + "   AND HOUSE_NO = '" + house_no + "'"
//                + "   AND CUST_NO  = '" + cust_no  + "'"
        ;
        Util.d("test",sql);
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        ChkDTO v = new ChkDTO();
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            v.setCount(sqlite.getCount());
            v.setCheckupIdx     (WUtil.toDefault(sqlite.getValue("CHECKUP_IDX"       )));            
            v.setCheckupYm      (WUtil.toDefault(sqlite.getValue("CHECKUP_YM"        )));
            v.setCheckupCd      (WUtil.toDefault(sqlite.getValue("CHECKUP_CD"        )));
            v.setHouseNo        (WUtil.toDefault(sqlite.getValue("HOUSE_NO"          )));
            v.setFakeHouseNo    (WUtil.toDefault(sqlite.getValue("FAKE_HOUSE_NO"     )));
            v.setEquipCd        (WUtil.toDefault(sqlite.getValue("EQUIP_CD"          )));
            v.setBldgOrd        (WUtil.toDefault(sqlite.getValue("BLDG_ORD"          )));
            v.setHouseOrd       (WUtil.toDefault(sqlite.getValue("HOUSE_ORD"         )));
            v.setAreaCd         (WUtil.toDefault(sqlite.getValue("AREA_CD"           )));
            v.setSectorCd       (WUtil.toDefault(sqlite.getValue("SECTOR_CD"         )));
            v.setComplexCd      (WUtil.toDefault(sqlite.getValue("COMPLEX_CD"        )));
            v.setBldgCd         (WUtil.toDefault(sqlite.getValue("BLDG_CD"           )));
            v.setAreaNm         (WUtil.toDefault(sqlite.getValue("AREA_NM"           )));
            v.setSectorNm       (WUtil.toDefault(sqlite.getValue("SECTOR_NM"         )));
            v.setComplexNm      (WUtil.toDefault(sqlite.getValue("COMPLEX_NM"        )));
            v.setBldgNo         (WUtil.toDefault(sqlite.getValue("BLDG_NO"           )));
            v.setBldgNm         (WUtil.toDefault(sqlite.getValue("BLDG_NM"           )));
            v.setRoomNo         (WUtil.toDefault(sqlite.getValue("ROOM_NO"           )));
            v.setFakeRoomNo     (WUtil.toDefault(sqlite.getValue("FAKE_ROOM_NO"      )));
            v.setRoadNm         (WUtil.toDefault(sqlite.getValue("ROAD_NM"           )));
            v.setCustNo         (WUtil.toDefault(sqlite.getValue("CUST_NO"           )));
            v.setCustNm         (WUtil.toDefault(sqlite.getValue("CUST_NM"           )));
            v.setCoNm           (WUtil.toDefault(sqlite.getValue("CO_NM"             )));
            v.setTelNo          (WUtil.toDefault(sqlite.getValue("TEL_NO"            )));
            v.setHpNo           (WUtil.toDefault(sqlite.getValue("HP_NO"             )));
            v.setWorkTelNo      (WUtil.toDefault(sqlite.getValue("WORK_TEL_NO"       )));
            v.setTelCd          (WUtil.toDefault(sqlite.getValue("TEL_CD"            )));
            v.setStatusCd       (WUtil.toDefault(sqlite.getValue("STATUS_CD"         )));
            v.setGmNo           (WUtil.toDefault(sqlite.getValue("GM_NO"             )));
            v.setInstallLocCd   (WUtil.toDefault(sqlite.getValue("INSTALL_LOC_CD"    )));
            v.setPurposeCd      (WUtil.toDefault(sqlite.getValue("PURPOSE_CD"        )));
            v.setChgDt          (WUtil.toDefault(sqlite.getValue("CHG_DT"            )));
            v.setChgMeter       (WUtil.toDefault(sqlite.getValue("CHG_METER"         )));
            v.setBfMeter        (WUtil.toDefault(sqlite.getValue("BF_METER"          )));
            v.setLastCheckupDt  (WUtil.toDefault(sqlite.getValue("LAST_CHECKUP_DT"   )));
            v.setLastCheckupCd  (WUtil.toDefault(sqlite.getValue("LAST_CHECKUP_CD"   )));
            v.setLastUserCd     (WUtil.toDefault(sqlite.getValue("LAST_USER_CD"      )));
            v.setCheYn          (WUtil.toDefault(sqlite.getValue("CHE_YN"            )));
            v.setGmErrorYn      (WUtil.toDefault(sqlite.getValue("GM_ERROR_YN"       )));
            v.setLongNoCheckupYn(WUtil.toDefault(sqlite.getValue("LONG_NO_CHECKUP_YN")));
            v.setLongAcceptYn   (WUtil.toDefault(sqlite.getValue("LONG_ACCEPT_YN"    )));
            v.setBoilerOkYn     (WUtil.toDefault(sqlite.getValue("BOILER_OK_YN"      )));
            v.setBurnerOkYn     (WUtil.toDefault(sqlite.getValue("BURNER_OK_YN"      )));
            v.setPipeOkYn       (WUtil.toDefault(sqlite.getValue("PIPE_OK_YN"        )));
            v.setGmOkYn         (WUtil.toDefault(sqlite.getValue("GM_OK_YN"          )));
            v.setBreakerOkYn    (WUtil.toDefault(sqlite.getValue("BREAKER_OK_YN"     )));
//          v.setCheckupYn      (WUtil.toDefault(sqlite.getValue("CHECKUP_YN"        )));
            v.setCheckupDt      (WUtil.toDefault(sqlite.getValue("CHECKUP_DT"        )));
            v.setCheckupBeginDt (WUtil.toDefault(sqlite.getValue("CHECKUP_BEGIN_DT"  )));
            v.setCheckupEndDt   (WUtil.toDefault(sqlite.getValue("CHECKUP_END_DT"    )));
            v.setCheckupUserCd  (WUtil.toDefault(sqlite.getValue("CHECKUP_USER_CD"   )));
            v.setCheckupResultCd(WUtil.toDefault(sqlite.getValue("CHECKUP_RESULT_CD" )));
            v.setCheckupMeter   (WUtil.toDefault(sqlite.getValue("CHECKUP_METER"     )));
            v.setGmNoCfm        (WUtil.toDefault(sqlite.getValue("GM_NO_CFM"         )));
            v.setQrReadYn       (WUtil.toDefault(sqlite.getValue("QR_YN"             )));
            v.setPhotoFileNm    (WUtil.toDefault(sqlite.getValue("PHOTO_FILE_NM"     )));
            v.setSignFileNm     (WUtil.toDefault(sqlite.getValue("SIGN_FILE_NM"      )));
            v.setEndYn          (WUtil.toDefault(sqlite.getValue("END_YN"            )));
            v.setSendYn         (WUtil.toDefault(sqlite.getValue("SEND_YN"           )));
        }
        return v;
    }

    /**
     * 코드명 조회 By CD
     * @param Context
     * @return
     */
    public static String getCodeNm(Context context,String typeCd, String cd) {
        String sql = "SELECT CD_NM FROM "
                + WConstant.TBL_CODE
                + " WHERE TYPE_CD = '"+typeCd+"'"
                + "   AND CD = '"+cd+"'"
        ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        String rtn = "";
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            rtn = sqlite.getValue(0);
        }
        return rtn;
    }
    /**
     * 점검정보 By Key
     * @param context
     * @param where
     * @return
     */
    public static ChkBoilerDTO getBoilerDataByWhere(Context context,String where) {
        String sql = "SELECT "
                + "    CHECKUP_IDX    "    // 안전점검인덱스(PK)
                + "  , BOI_IDX        "    // 보일러인덱스(PK)
                + "  , BOI_NO         "    // 보일러번호
                + "  , MODEL_NM       "    // 모델명
                + "  , MAKE_NO        "    // 제조번호
                + "  , MAKE_YY        "    // 제조년도
                + "  , MAKER_CD       "    // 제조사코드
                + "  , INSTALL_CO_CD  "    // 시공사
                + "  , INSTALL_USER_NM"    // 시공자명
                + " FROM " + WConstant.TBL_JUM_BOILER
                + where
//                + " WHERE CHECKUP_YM   = '" + checkup_ym   + "'"
//                + "   AND HOUSE_NO = '" + house_no + "'"
//                + "   AND CUST_NO  = '" + cust_no  + "'"
        ;
        Util.d("MPGAS",sql);
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        ChkBoilerDTO v = new ChkBoilerDTO();
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            v.setCount(sqlite.getCount());
            v.setCheckupIdx   (WUtil.toDefault(sqlite.getValue("CHECKUP_IDX"     )));    // 안전점검인덱스(PK)
            v.setBoiIdx       (WUtil.toDefault(sqlite.getValue("BOI_IDX"         )));    // 보일러인덱스(PK)
            v.setBoiNo        (WUtil.toDefault(sqlite.getValue("BOI_NO"          )));    // 보일러번호
            v.setModelNm      (WUtil.toDefault(sqlite.getValue("MODEL_NM"        )));    // 모델명
            v.setMakeNo       (WUtil.toDefault(sqlite.getValue("MAKE_NO"         )));    // 제조번호
            v.setMakeYy       (WUtil.toDefault(sqlite.getValue("MAKE_YY"         )));    // 제조년도
            v.setMakerCd      (WUtil.toDefault(sqlite.getValue("MAKER_CD"        )));    // 제조사코드
            v.setInstallCoCd  (WUtil.toDefault(sqlite.getValue("INSTALL_CO_CD"   )));    // 시공사
            v.setInstallUserNm(WUtil.toDefault(sqlite.getValue("INSTALL_USER_NM" )));    // 시공자명
        }
        return v;
    }
    /**
     * 점검보일러정보 Data수 조건절 지정.
     * @param Context
     * @return
     */
    public static int getBoilerDataCountByWhere(Context context,String where) {
        String sql = "SELECT COUNT(*) FROM "
                + WConstant.TBL_JUM_BOILER
                + " JOIN " + WConstant.TBL_JUM
                + "   ON JUM_BOILER.CHECKUP_IDX = JUM.CHECKUP_IDX "
                + where                
        ;
        
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        Util.i("test",sql);
        int cnt = 0;
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            cnt = Integer.parseInt(sqlite.getValue(0),10);
            Util.d(WConstant.LOG_TAG,""+cnt);
        }
        return cnt;
    }

    /**
     * 점검제외내용(기기없음) Data수 송신상태별
     * @param Context
     * @return
     */
    public static int getExceptionDataCountByWhere(Context context,String where) {
        String sql = "SELECT COUNT(*) FROM "
                + WConstant.TBL_JUM_EXCEPTION
                + where
        ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        Util.i("test",sql);
        int cnt = 0;
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            cnt = Integer.parseInt(sqlite.getValue(0),10);
            Util.d(WConstant.LOG_TAG,""+cnt);
        }
        return cnt;
    }

    /**
     * 점검방문이력 Data수 송신상태별
     * @param Context
     * @return
     */
    public static int getVisitDataCountByWhere(Context context,String where) {
//      String sql = "SELECT COUNT(DISTINCT CHECKUP_YM||CHECKUP_CD||HOUSE_NO||FAKE_HOUSE_NO) FROM "
        String sql = "SELECT COUNT(*) FROM "
                + WConstant.TBL_JUM_VISIT
                + " JOIN " + WConstant.TBL_JUM
                + "   ON JUM_VISIT.CHECKUP_IDX = JUM.CHECKUP_IDX "
                + where
                ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        Util.i("test",sql);
        int cnt = 0;
        if ( sqlite.getCount() > 0 ) {
            sqlite.moveToFirst();
            cnt = Integer.parseInt(sqlite.getValue(0),10);
            Util.d(WConstant.LOG_TAG,""+cnt);
        }
        return cnt;
    }

    /**
     * 송신가능 방문이력 Data수
     * @param Context
     * @return
     */
    public static int getSendableVisitDataCount(Context context,String checkupCd) {
        return DUtil.getVisitDataCountByWhere(context," WHERE JUM.SEND_YN  = '"+Constant.CODE_SEND_N+"'"
                                              + ( !StringUtils.isEmpty(checkupCd ) ? " AND JUM.CHECKUP_CD  = '"+checkupCd +"'" : "" )
                                              + "   AND JUM_VISIT.SEND_YN  = '" + Constant.CODE_SEND_N+ "'"                                              
                                              );
        
    }
}