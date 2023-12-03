package com.entropykorea.gas.chg.common;

import org.apache.commons.lang3.StringUtils;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;

import com.entropykorea.ewire.database.Sqlite;
import com.entropykorea.gas.chg.WApplication;
import com.entropykorea.gas.chg.dto.ChgDTO;
import com.entropykorea.gas.chg.dto.MeterCountDTO;
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
     * Data수 송신상태별
     * @param Context
     * @return
     */
    public static String getCurrentChgYYYYMM(Context context) {

        Sqlite sqlite = getSqlite();
        sqlite.rawQuery("SELECT MAX(IFNULL(GM_CHG_YM,'')) FROM "
                + WConstant.TBL_CHG);   
        String rtn = "";        
        if ( sqlite.getCount() > 0 ) {
        	sqlite.moveToFirst();        	
        	rtn = WUtil.toDefault(sqlite.getValue(0));
        }
        return rtn;
    }
    
    /**
     * 수용가번호 얻기 By 교체계량기번호 ( BF_GM_NO )
     * @param Context
     * @return
     */
    public static String getHouseNoByBfGmNo(Context context,String bf_gm_no) {
        String sql = "SELECT HOUSE_NO FROM "
                + WConstant.TBL_CHG
                + " WHERE BF_GM_NO = '" + bf_gm_no + "'"
                //BF_GM_NO   교체전계량기번호    VARCHAR2(20)    NULL    교체전계량기번호
        ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);   
        String houseNo = "";        
        if ( sqlite.getCount() > 0 ) {
        	sqlite.moveToFirst();
	        houseNo = StringUtils.defaultString(sqlite.getValue(0));
        }
        return houseNo;
    }

    /**
     * 상태별 Data수
     * @param Context
     * @return MeterCountDTO
     */
    public static MeterCountDTO getMeterCount(Context context) {
        String sql = " SELECT "
                + "       MAX( CASE GB WHEN 'C'  THEN CNT ELSE 0 END) V1 "
                + "     , MAX( CASE GB WHEN 'NC' THEN CNT ELSE 0 END) V2 "
                + "     , MAX( CASE GB WHEN 'NS' THEN CNT ELSE 0 END) V3 "
                + " FROM "
                + " ( "
//              + "     SELECT 'C' GB, COUNT(*) CNT FROM " + WConstant.TBL_CHG + " WHERE END_YN = 'Y' AND SEND_YN = 'Y'"
                + "     SELECT 'C' GB, COUNT(*) CNT FROM " + WConstant.TBL_CHG + " WHERE END_YN = 'Y' "
                + "     UNION "
//                + "     SELECT 'NC', COUNT(*) FROM " + WConstant.TBL_CHG + " WHERE END_YN = 'N' AND SEND_YN = 'N' "
                + "     SELECT 'NC', COUNT(*) FROM " + WConstant.TBL_CHG + " WHERE END_YN = 'N' "
                + "     UNION "
                + "     SELECT 'NS', COUNT(*) FROM " + WConstant.TBL_CHG + " WHERE END_YN = 'Y' AND SEND_YN = 'N' "
                + " ) a "
        ;
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);  
        MeterCountDTO v = new MeterCountDTO();
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
     * 송신가능수
     * @param Context
     * @return
     */
    public static int getSendableCount(Context context) {
    	// END_YN = 'Y' AND SEND_YN = 'N'
        return getDataCount(context,"Y","N");
    }

    /**
     * Data수 송신상태별
     * @param Context
     * @return
     */
    public static int getDataCount(Context context,String endYn,String sendYn) {
        String sql = "SELECT COUNT(*) FROM "
                + WConstant.TBL_CHG
                + " WHERE 1 = 1"
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
     * 전체 Data수 송신상태별
     * @param context
     * @return
     */
    public static int getDataCount(Context context) {
        return getDataCount(context,null,null);
    }

    /**
     * Data수 송신상태별 삭제
     * @param Context
     * @return
     */
    public static boolean deleteData(Context context,String endYn,String sendYn) {
        WApplication mApp = (WApplication) context;
        SQLiteDatabase db = mApp.getDatabase();
        boolean rtn = false;
        try {
            db.execSQL("DELETE FROM " + WConstant.TBL_CHG_CUST + " ");
/*            
			String sql2 = "SELECT " 
					+ " GM_CHG_YM " 
					+ ",JOB_CD " 
					+ ",HOUSE_NO "
					+ ",FAKE_HOUSE_NO " 
					+ " FROM " + WConstant.TBL_CHG
			;
			Sqlite sqlite = getSqlite();
			sqlite.rawQuery(sql2);
			int i = -1;
			sqlite.moveToFirst();
			do {
				i++;
				String jobYm = sqlite.getValue("GM_CHG_YM", i);
				String houseNo = sqlite.getValue("HOUSE_NO", i);
				String custNo = sqlite.getValue("CUST_NO", i);
                try { // 사진 삭제
                    Util.deleteFilesWithPrefix(Constant.PIC_DIR, "P_"+jobYm+houseNo+custNo);
                } catch ( Exception ex ) {}
                try { // 서명삭제
                    Util.deleteFilesWithPrefix(Constant.SIGN_DIR, "S_"+jobYm+houseNo+custNo);
                } catch ( Exception ex ) {}
			} while (sqlite.moveToNext());
*/
            WUtil.deleteFiles(Constant.PIC_DIR, "P_*");
            WUtil.deleteFiles(Constant.SIGN_DIR, "S_*");
            
        	String sql = "DELETE FROM "
                    + WConstant.TBL_CHG
                    + " WHERE 1 = 1"
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
     * 전체 Data수 송신상태별 삭제
     * @param context
     * @return
     */
    public static boolean deleteData(Context context) {
        return deleteData(context,null,null);
    }

    /**
     * 교체정보등록이 안된 수.
     * 교체후계량기번호가 등록안된수.
     * @param Context
     * @return
     */
    public static int getChgInfoNotRegCountByBldgCd(Context context,String bldgCd) {
        String sql = "SELECT COUNT(*) FROM "
                + WConstant.TBL_CHG
                + " WHERE BLDG_CD = '" + bldgCd + "'"
                + "   AND IFNULL(AF_GM_NO,'') =''"
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
                + WConstant.TBL_CHG
                + " WHERE BLDG_CD = '" + bldgCd + "'"
                + "   AND IFNULL(AF_GM_NO,'') <> ''"
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
                + WConstant.TBL_CHG
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
                + WConstant.TBL_CHG
                + " WHERE BLDG_CD = '" + bldgCd + "'"
                + "   AND IFNULL(AF_SEAL_CD,'') <> ''"
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
     * @param gb : ConstantChg.CODE_GUBUN_ADDRESS / ConstantChg.CODE_GUBUN_STREET
     * @return
     */
    public static String getHouseGroupNmByBldgCd(Context context,String bldgCd,String gb) {
        String sql = "SELECT "
                +
                (
                        gb.equals(Constant.CODE_GUBUN_ADDRESS)
                        ? " CHG.SECTOR_NM || ' ' || CHG.BLDG_NO || ' ' || CHG.COMPLEX_NM || ' ' || CHG.BLDG_NM AS BLD_NM"  // 지번
                        : " CHG.ROAD_NM || ' ' || CHG.COMPLEX_NM || ' ' || CHG.BLDG_NM AS BLD_NM "  // 도로명
                )
                + " FROM "
                + WConstant.TBL_CHG  + " CHG "
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
     * @param gm_chg_ym
     * @param house_no
     * @param cust_no
     * @return
     */
    public static boolean isInputAfGmNo(Context context,String gm_chg_ym,String house_no,String cust_no) {
        String sql = "SELECT "
                + " AF_GM_NO " // 교체후계량기번호
                + " FROM " + WConstant.TBL_CHG
                + " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
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
     * 교체취소시 교체정보 초기화
     * @param Context
     * @return
     */
    public static boolean clearChgDataByKey(Context context,String gm_chg_ym,String house_no,String cust_no) {
        WApplication mApp = (WApplication) context;
        SQLiteDatabase db = mApp.getDatabase();
        boolean rtn = false;
        try {
            db.execSQL("UPDATE "
                    + WConstant.TBL_CHG
                    + " SET AF_GM_NO            = ''" // 교체후계량기번호    
                    + "   , AF_MODEL            = ''" // 교체후모델명        
                    + "   , AF_KIND_CD          = ''" // 교체후종류코드      
                    + "   , AF_TYPE_CD          = ''" // 교체후타입코드      
                    + "   , AF_MAKER_CD         = ''" // 교체후제조사코드    
                    + "   , AF_INSTALL_LOC_CD   = ''" // 교체후설치위치코드  
                    + "   , AF_MAKE_YY          = ''" // 교체후제조년도      
                    + "   , AF_UNION_CNT        = ''" // 교체후유니온갯수    
                    + "   , AF_SEAL_NO          = ''" // 교체후유니온키퍼번호
                    + "   , AF_REPAIR_CD        = ''" // 교체후검정품구분코드
                    + "   , AF_SEAL_CD          = ''" // 교체후봉인방법      
                    + "   , CHG_REMOVE_METER    = ''" // 교체철거지침        
                    + "   , CHG_INSTALL_METER   = ''" // 교체설치지침        
                    + "   , CHG_DT              = ''" // 교체일자        
                    + " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
                    + "   AND HOUSE_NO = '" + house_no + "'"
                    + "   AND CUST_NO  = '" + cust_no  + "'"
            );
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
    public static boolean updateChe(Context context,String gm_chg_ym,String house_no,String cust_no,int che_month_cnt, int che_price_sum) {
        WApplication mApp = (WApplication) context;
        SQLiteDatabase db = mApp.getDatabase();
        boolean rtn = false;
        try {
        	String sql = "UPDATE "
                    + WConstant.TBL_CHG
                    + " SET CHE_MONTH_CNT   = '" + che_month_cnt   + "'" // 체납개월
                    + "   , CHE_PRICE_SUM   = '" + che_price_sum   + "'" // 체납금액
                    + " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
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
     * 교체정보 By Key
     * @param context
     * @param where
     * @return
     */
    public static ChgDTO getDataByWhere(Context context,String where) {
        String sql = "SELECT "
                + "    GM_CHG_YM              "    // 작업년월
                + "  , HOUSE_NO            "    // 수용가번호
                + "  , CUST_NO             "    // 고객번호
                + "  , EQUIP_CD            "    // 기기번호코드(GW010)
                + "  , AREA_CD             "    // 지역코드
                + "  , SECTOR_CD           "    // 구역코드
                + "  , COMPLEX_CD          "    // 단지코드
                + "  , BLDG_CD             "    // 건물코드
                + "  , HOUSE_ORD           "    // 세대순로
                + "  , AREA_NM             "    // 지역명
                + "  , SECTOR_NM           "    // 구역명
                + "  , COMPLEX_NM          "    // 단지명
                + "  , BLDG_NM             "    // 건물명
                + "  , BLDG_NO             "    // 번지명
                + "  , ROOM_NO             "    // 호수명
                + "  , ROAD_NM             "    // 도로명
                + "  , CUST_NM             "    // 고객명
                + "  , CO_NM               "    // 상호
                + "  , TEL_NO              "    // 전화번호
                + "  , HP_NO               "    // 핸드폰
                + "  , WORK_TEL_NO         "    // 직장전화번호
                + "  , TEL_CD              "    // 주전화번호구분코드(MA290)
                + "  , STATUS_CD           "    // 수용가상태코드(MA090
                + "  , CLAIM_CUST_YN       "    // N/A
                + "  , CLAIM_CONTENT       "    // N/A
                + "  , CHE_MONTH_CNT       "    // N/A
                + "  , CHE_PRICE_SUM       "    // N/A
                + "  , GM_ERROR_YN         "    // N/A
                + "  , BF_GM_NO            "    // 교체전계량기번호
                + "  , BF_MODEL            "    // 교체전모델
                + "  , BF_KIND_CD          "    // 교체전종류코드(GM030)
                + "  , BF_TYPE_CD          "    // 교체전타입코드(GM050)
                + "  , BF_MAKER_CD         "    // 교체전제조사코드(GM070)
                + "  , BF_INSTALL_LOC_CD   "    // 교체전설치위치구분(GM130)
                + "  , BF_MAKE_YY          "    // 교체전제조년도
                + "  , BF_UNION_CNT        "    // 교체전유니온갯수
                + "  , BF_SEAL_NO          "    // 교체전유니온키퍼번호,봉인번호
                + "  , BF_REPAIR_CD        "    // 교체전검정품구분코드(GM110)
                + "  , BF_SEAL_CD          "    // 교체전봉인방법(MA220)
                + "  , AF_GM_NO            "    // 교체후계량기번호
                + "  , AF_MODEL            "    // 교체후모델
                + "  , AF_KIND_CD          "    // 교체후종류코드(GM030)
                + "  , AF_TYPE_CD          "    // 교체후타입코드(GM050)
                + "  , AF_MAKER_CD         "    // 교체후제조사코드(GM070)
                + "  , AF_INSTALL_LOC_CD   "    // 교체후설치위치코드(GM060)
                + "  , AF_MAKE_YY          "    // 교체후제조년도
                + "  , AF_UNION_CNT        "    // 교체후유니온갯수
                + "  , AF_SEAL_NO          "    // 교체후유니온키퍼번호,봉인번호
                + "  , AF_REPAIR_CD        "    // 교체후검정품구분코드(GM110)
                + "  , AF_SEAL_CD          "    // 교체전봉인방법(MA220)
                + "  , CHG_REMOVE_METER    "    // 교체철거지침
                + "  , CHG_INSTALL_METER   "    // 교체설치지침
                + "  , CHG_DT              "    // 교체일자
                + "  , BF_INSTALL_DT       "    // 이전교체일자
//                + "  , BF_CHG_DT       "    // 이전교체일자
                + "  , CHG_USER_CD         "    // 교체자
                + "  , SIGN_FILE_NM        "    // N/A
                + "  , PHOTO_FILE_NM       "    // N/A
                + "  , END_YN              "    // 완료여부
                + "  , SEND_YN             "    // 송신여부
                + "FROM " + WConstant.TBL_CHG
                + where
//                + " WHERE GM_CHG_YM   = '" + gm_chg_ym   + "'"
//                + "   AND HOUSE_NO = '" + house_no + "'"
//                + "   AND CUST_NO  = '" + cust_no  + "'"
        ;
        Util.d("MPGAS",sql);
        Sqlite sqlite = getSqlite();
        sqlite.rawQuery(sql);
        ChgDTO v = new ChgDTO();        
        if ( sqlite.getCount() > 0 ) {
        	sqlite.moveToFirst();
	        v.setJobYm            (WUtil.toDefault(sqlite.getValue(0 )));
	        v.setHouseNo          (WUtil.toDefault(sqlite.getValue(1 )));
	        v.setCustNo           (WUtil.toDefault(sqlite.getValue(2 )));
	        v.setEquipCd          (WUtil.toDefault(sqlite.getValue(3 )));
	        v.setAreaCd           (WUtil.toDefault(sqlite.getValue(4 )));
	        v.setSectorCd         (WUtil.toDefault(sqlite.getValue(5 )));
	        v.setComplexCd        (WUtil.toDefault(sqlite.getValue(6 )));
	        v.setBldgCd           (WUtil.toDefault(sqlite.getValue(7 )));
	        v.setHouseOrd         (WUtil.toDefault(sqlite.getValue(8 )));
	        v.setAreaNm           (WUtil.toDefault(sqlite.getValue(9 )));
	        v.setSectorNm         (WUtil.toDefault(sqlite.getValue(10)));
	        v.setComplexNm        (WUtil.toDefault(sqlite.getValue(11)));
	        v.setBldgNm           (WUtil.toDefault(sqlite.getValue(12)));
	        v.setBldgNo           (WUtil.toDefault(sqlite.getValue(13)));
	        v.setRoomNo           (WUtil.toDefault(sqlite.getValue(14)));
	        v.setRoadNm           (WUtil.toDefault(sqlite.getValue(15)));
	        v.setCustNm           (WUtil.toDefault(sqlite.getValue(16)));
	        v.setCoNm             (WUtil.toDefault(sqlite.getValue(17)));
	        v.setTelNo            (WUtil.toDefault(sqlite.getValue(18)));
	        v.setHpNo             (WUtil.toDefault(sqlite.getValue(19)));
	        v.setWorkTelNo        (WUtil.toDefault(sqlite.getValue(20)));
	        v.setTelCd            (WUtil.toDefault(sqlite.getValue(21)));
	        v.setHouseStatusCd    (WUtil.toDefault(sqlite.getValue(22)));
	        v.setClaimCustYn      (WUtil.toDefault(sqlite.getValue(23)));
	        v.setClaimContent     (WUtil.toDefault(sqlite.getValue(24)));
	        v.setCheMonthCnt      (WUtil.toDefault(sqlite.getValue(25)));
	        v.setChePriceSum      (WUtil.toDefault(sqlite.getValue(26)));
	        v.setGmErrorYn        (WUtil.toDefault(sqlite.getValue(27)));
	        v.setBfGmNo           (WUtil.toDefault(sqlite.getValue(28)));
	        v.setBfModel          (WUtil.toDefault(sqlite.getValue(29)));
	        v.setBfKindCd         (WUtil.toDefault(sqlite.getValue(30)));
	        v.setBfTypeCd         (WUtil.toDefault(sqlite.getValue(31)));
	        v.setBfMakerCd        (WUtil.toDefault(sqlite.getValue(32)));
	        v.setBfInstallLocGbCd (WUtil.toDefault(sqlite.getValue(33)));
	        v.setBfMakeYy         (WUtil.toDefault(sqlite.getValue(34)));
	        v.setBfUnionCnt       (WUtil.toDefault(sqlite.getValue(35)));
	        v.setBfSealNo         (WUtil.toDefault(sqlite.getValue(36)));
	        v.setBfRepairCd       (WUtil.toDefault(sqlite.getValue(37)));
	        v.setBfSealCd         (WUtil.toDefault(sqlite.getValue(38)));
	        v.setAfGmNo           (WUtil.toDefault(sqlite.getValue(39)));
	        v.setAfModel          (WUtil.toDefault(sqlite.getValue(40)));
	        v.setAfKindCd         (WUtil.toDefault(sqlite.getValue(41)));
	        v.setAfTypeCd         (WUtil.toDefault(sqlite.getValue(42)));
	        v.setAfMakerCd        (WUtil.toDefault(sqlite.getValue(43)));
	        v.setAfInstallLocCd   (WUtil.toDefault(sqlite.getValue(44)));
	        v.setAfMakeYy         (WUtil.toDefault(sqlite.getValue(45)));
	        v.setAfUnionCnt       (WUtil.toDefault(sqlite.getValue(46)));
	        v.setAfSealNo         (WUtil.toDefault(sqlite.getValue(47)));
	        v.setAfRepairCd       (WUtil.toDefault(sqlite.getValue(48)));
	        v.setAfSealCd         (WUtil.toDefault(sqlite.getValue(49)));
	        v.setChgRemoveMeter   (WUtil.toDefault(sqlite.getValue(50)));
	        v.setChgInstallMeter  (WUtil.toDefault(sqlite.getValue(51)));
	        v.setChgDt            (WUtil.toDefault(sqlite.getValue(52)));
	        v.setBfChgDt          (WUtil.toDefault(sqlite.getValue(53)));
	        v.setChgUserCd        (WUtil.toDefault(sqlite.getValue(54)));
	        v.setSignFileNm       (WUtil.toDefault(sqlite.getValue(55)));
	        v.setPhotoFileNm      (WUtil.toDefault(sqlite.getValue(56)));
	        v.setEndYn            (WUtil.toDefault(sqlite.getValue(57)));
	        v.setSendYn           (WUtil.toDefault(sqlite.getValue(58)));
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
}