package com.entropykorea.gas.chg.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class ChgResultSpec extends BaseSpec {

	private String fileName = "chg_result.dat";
	private String tableName = "CHG";
	private FieldSpec[] fieldSpecs = {
	        new FieldSpec("GM_CHG_YM"                         ,   6  , true , false),
	        new FieldSpec("HOUSE_NO"                       ,   13 , true , false),
	        new FieldSpec("CUST_NO"                        ,   10 , true , false),
	        new FieldSpec("AF_GM_NO"                       ,   20 , false , false),
	        new FieldSpec("AF_MODEL"                       ,   100, false , false),
	        new FieldSpec("AF_KIND_CD"                     ,   20 , false , false),
	        new FieldSpec("AF_TYPE_CD"                     ,   20 , false , false),
	        new FieldSpec("AF_MAKER_CD"                    ,   20 , false , false),
	        new FieldSpec("AF_INSTALL_LOC_CD"              ,   20 , false , false),
	        new FieldSpec("AF_MAKE_YY"                     ,   4  , false , false),
	        new FieldSpec("AF_UNION_CNT"                   ,   10 , false , false),
	        new FieldSpec("AF_SEAL_NO"                     ,   30 , false , false),
	        new FieldSpec("AF_REPAIR_CD"                   ,   20 , false , false),
	        new FieldSpec("AF_SEAL_CD"                     ,   20 , false , false),
	        new FieldSpec("CHG_REMOVE_METER"               ,   10 , false , false),
	        new FieldSpec("CHG_INSTALL_METER"              ,   10 , false , false),
	        new FieldSpec("CHG_DT"                         ,   19 , false , false),
	        new FieldSpec("CHG_USER_CD"                    ,   20 , false , false),
	        new FieldSpec("SIGN_FILE_NM"                   ,   50 , false , false),
	        new FieldSpec("PHOTO_FILE_NM"                  ,   50 , false , false),
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
