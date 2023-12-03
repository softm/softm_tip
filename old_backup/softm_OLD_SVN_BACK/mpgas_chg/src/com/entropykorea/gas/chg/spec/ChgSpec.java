package com.entropykorea.gas.chg.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class ChgSpec extends BaseSpec {

	private String fileName = "chg.dat";
	private String tableName = "CHG";
	private FieldSpec[] fieldSpecs = {
	        new FieldSpec("GM_CHG_YM"           ,   6  , true , false),
	        new FieldSpec("HOUSE_NO"            ,   13 , true , false),
	        new FieldSpec("CUST_NO"             ,   10 , true , false),
	        new FieldSpec("EQUIP_CD"            ,   20 , false, false),
	        new FieldSpec("AREA_CD"             ,   1  , false, false),
	        new FieldSpec("SECTOR_CD"           ,   3  , false, false),
	        new FieldSpec("COMPLEX_CD"          ,   7  , false, false),
	        new FieldSpec("BLDG_CD"             ,   10 , false, false),
	        new FieldSpec("HOUSE_ORD"           ,   10 , false, false),
	        new FieldSpec("AREA_NM"             ,   50 , false, false),
	        new FieldSpec("SECTOR_NM"           ,   50 , false, false),
	        new FieldSpec("COMPLEX_NM"          ,   50 , false, false),
	        new FieldSpec("BLDG_NM"             ,   50 , false, false),
	        new FieldSpec("BLDG_NO"             ,   50 , false, false),
	        new FieldSpec("ROOM_NO"             ,   50 , false, false),
	        new FieldSpec("ROAD_NM"             ,   80 , false, false),
	        new FieldSpec("CUST_NM"             ,   50 , false, false),
	        new FieldSpec("CO_NM"               ,   50 , false, false),
	        new FieldSpec("TEL_NO"              ,   20 , false, false),
	        new FieldSpec("HP_NO"               ,   20 , false, false),
	        new FieldSpec("WORK_TEL_NO"         ,   30 , false, false),
	        new FieldSpec("TEL_CD"              ,   20 , false, false),
	        new FieldSpec("STATUS_CD"           ,   20 , false, false),
	        new FieldSpec("CLAIM_CUST_YN"       ,   1  , false, false),
	        new FieldSpec("CLAIM_CONTENT"       ,   500, false, false),
	        new FieldSpec("CHE_MONTH_CNT"       ,   10 , false, false),
	        new FieldSpec("CHE_PRICE_SUM"       ,   10 , false, false),
	        new FieldSpec("GM_ERROR_YN"         ,   1  , false, false),
	        new FieldSpec("BF_GM_NO"            ,   20 , false, false),
	        new FieldSpec("BF_MODEL"            ,   100, false, false),
	        new FieldSpec("BF_KIND_CD"          ,   20 , false, false),
	        new FieldSpec("BF_TYPE_CD"          ,   20 , false, false),
	        new FieldSpec("BF_MAKER_CD"         ,   20 , false, false),
	        new FieldSpec("BF_INSTALL_LOC_CD"   ,   20 , false, false),
	        new FieldSpec("BF_MAKE_YY"          ,   4  , false, false),
	        new FieldSpec("BF_UNION_CNT"        ,   10 , false, false),
	        new FieldSpec("BF_SEAL_NO"          ,   30 , false, false),
	        new FieldSpec("BF_REPAIR_CD"        ,   20 , false, false),
	        new FieldSpec("BF_SEAL_CD"          ,   20 , false, false),
	        new FieldSpec("BF_INSTALL_DT"       ,   19 , false, false),
	        new FieldSpec("AF_GM_NO"            ,   20 , false, false),
	        new FieldSpec("AF_MODEL"            ,   100, false, false),
	        new FieldSpec("AF_KIND_CD"          ,   20 , false, false),
	        new FieldSpec("AF_TYPE_CD"          ,   20 , false, false),
	        new FieldSpec("AF_MAKER_CD"         ,   20 , false, false),
	        new FieldSpec("AF_INSTALL_LOC_CD"   ,   20 , false, false),
	        new FieldSpec("AF_MAKE_YY"          ,   4  , false, false),
	        new FieldSpec("AF_UNION_CNT"        ,   10 , false, false),
	        new FieldSpec("AF_SEAL_NO"          ,   30 , false, false),
	        new FieldSpec("AF_REPAIR_CD"        ,   20 , false, false),
	        new FieldSpec("AF_SEAL_CD"          ,   20 , false, false),
	        new FieldSpec("CHG_REMOVE_METER"    ,   10 , false, false),
	        new FieldSpec("CHG_INSTALL_METER"   ,   10 , false, false),
	        new FieldSpec("CHG_DT"              ,   19 , false, false),
	        new FieldSpec("CHG_USER_CD"         ,   20 , false, false),
	        new FieldSpec("SIGN_FILE_NM"        ,   50 , false, false),
	        new FieldSpec("PHOTO_FILE_NM"       ,   50 , false, false),
	        new FieldSpec("END_YN"              ,   1  , false, false),
	        new FieldSpec("SEND_YN"             ,   1  , false, false),
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
