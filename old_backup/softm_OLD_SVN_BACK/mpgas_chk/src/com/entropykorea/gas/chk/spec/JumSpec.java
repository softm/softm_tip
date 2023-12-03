package com.entropykorea.gas.chk.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;
import com.entropykorea.gas.chk.common.WConstant;

public class JumSpec extends BaseSpec {

	private String fileName = "jum.dat";
	private String tableName = WConstant.TBL_JUM;
	private FieldSpec[] fieldSpecs = {
	        new FieldSpec("CHECKUP_IDX       "            , 10,  true, false),
	        new FieldSpec("CHECKUP_YM        "            , 6 , false, false),
	        new FieldSpec("CHECKUP_CD        "            , 20, false, false),
	        new FieldSpec("HOUSE_NO          "            , 13, false, false),
	        new FieldSpec("FAKE_HOUSE_NO     "            , 10, false, false),
	        new FieldSpec("EQUIP_CD          "            , 20, false, false),
	        new FieldSpec("BLDG_ORD          "            , 10, false, false),
	        new FieldSpec("HOUSE_ORD         "            , 10, false, false),
	        new FieldSpec("AREA_CD           "            , 1 , false, false),
	        new FieldSpec("SECTOR_CD         "            , 3 , false, false),
	        new FieldSpec("COMPLEX_CD        "            , 7 , false, false),
	        new FieldSpec("BLDG_CD           "            , 10, false, false),
	        new FieldSpec("AREA_NM           "            , 50, false, false),
	        new FieldSpec("SECTOR_NM         "            , 50, false, false),
	        new FieldSpec("COMPLEX_NM        "            , 50, false, false),
	        new FieldSpec("BLDG_NM           "            , 50, false, false),
	        new FieldSpec("BLDG_NO           "            , 50, false, false),
	        new FieldSpec("ROOM_NO           "            , 50, false, false),
	        new FieldSpec("FAKE_ROOM_NO      "            , 50, false, false),
	        new FieldSpec("ROAD_NM           "            , 80, false, false),
	        new FieldSpec("CUST_NO           "            , 10, false, false),
	        new FieldSpec("CUST_NM           "            , 50, false, false),
	        new FieldSpec("CO_NM             "            , 50, false, false),
	        new FieldSpec("TEL_NO            "            , 30, false, false),
	        new FieldSpec("HP_NO             "            , 30, false, false),
	        new FieldSpec("WORK_TEL_NO       "            , 30, false, false),
	        new FieldSpec("TEL_CD            "            , 20, false, false),
	        new FieldSpec("STATUS_CD         "            , 20, false, false),
	        new FieldSpec("GM_NO             "            , 20, false, false),
	        new FieldSpec("INSTALL_LOC_CD    "            , 20, false, false),
	        new FieldSpec("PURPOSE_CD        "            , 20, false, false),
	        new FieldSpec("CHG_DT            "            , 8 , false, false),
	        new FieldSpec("CHG_METER         "            , 10, false, false),
	        new FieldSpec("BF_METER          "            , 10, false, false),
	        new FieldSpec("LAST_CHECKUP_DT   "            , 8 , false, false),
	        new FieldSpec("LAST_CHECKUP_CD   "            , 20, false, false),
	        new FieldSpec("LAST_USER_CD      "            , 20, false, false),
	        new FieldSpec("CHE_YN            "            , 1 , false, false),
	        new FieldSpec("GM_ERROR_YN       "            , 1 , false, false),
	        new FieldSpec("LONG_NO_CHECKUP_YN"            , 1 , false, false),
	        new FieldSpec("LONG_ACCEPT_YN    "            , 1 , false, false),
	        new FieldSpec("BOILER_OK_YN      "            , 1 , false, false),
	        new FieldSpec("BURNER_OK_YN      "            , 1 , false, false),
	        new FieldSpec("PIPE_OK_YN        "            , 1 , false, false),
	        new FieldSpec("GM_OK_YN          "            , 1 , false, false),
	        new FieldSpec("BREAKER_OK_YN     "            , 1 , false, false),
	        new FieldSpec("CHECKUP_DT        "            , 8 , false, false),
	        new FieldSpec("CHECKUP_BEGIN_DT  "            , 6 , false, false),
	        new FieldSpec("CHECKUP_END_DT    "            , 6 , false, false),
	        new FieldSpec("CHECKUP_USER_CD   "            , 20, false, false),
	        new FieldSpec("CHECKUP_RESULT_CD "            , 20, false, false),
	        new FieldSpec("CHECKUP_METER     "            , 10, false, false),
	        new FieldSpec("GM_NO_CFM         "            , 20, false, false),
	        new FieldSpec("QR_YN             "            , 1 , false, false),
	        new FieldSpec("PHOTO_FILE_NM     "            , 50, false, false),
	        new FieldSpec("SIGN_FILE_NM      "            , 50, false, false),
	        new FieldSpec("END_YN            "            , 1 , false, false),
	        new FieldSpec("SEND_YN           "            , 1 , false, false),
	};
	
	public String whereClause = null;
	
	@Override
	public String getFileName() {
		return fileName;
	}
	
	@Override
	public String getTableName() {
		return tableName;
	}
	
	@Override
	public FieldSpec[] getFieldSpecs() {
		return fieldSpecs;
	}

	@Override
	public String getWhereClause() {
		return whereClause;
	}

	@Override
	public String getSelectClause() {
		// TODO Auto-generated method stub
		return null;
	}

}
