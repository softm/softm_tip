package com.entropykorea.gas.chk.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;
import com.entropykorea.gas.chk.common.WConstant;

public class JumResultSpec extends BaseSpec {

	private String fileName = "jum_result.dat";
	private String tableName = WConstant.TBL_JUM;
	private FieldSpec[] fieldSpecs = {
	        new FieldSpec("CHECKUP_IDX      "        ,10   ,  true , false),
	        new FieldSpec("BOILER_OK_YN     "        ,1    ,  false, false),
	        new FieldSpec("BURNER_OK_YN     "        ,1    ,  false, false),
	        new FieldSpec("PIPE_OK_YN       "        ,1    ,  false, false),
	        new FieldSpec("GM_OK_YN         "        ,1    ,  false, false),
	        new FieldSpec("BREAKER_OK_YN    "        ,1    ,  false, false),
	        new FieldSpec("CHECKUP_DT       "        ,8    ,  false, false),
	        new FieldSpec("CHECKUP_BEGIN_DT "        ,6    ,  false, false),
	        new FieldSpec("CHECKUP_END_DT   "        ,6    ,  false, false),
	        new FieldSpec("CHECKUP_USER_CD  "        ,20   ,  false, false),
	        new FieldSpec("CHECKUP_RESULT_CD"        ,20   ,  false, false),
	        new FieldSpec("CHECKUP_METER    "        ,10   ,  false, false),
	        new FieldSpec("GM_NO_CFM        "        ,20   ,  false, false),
	        new FieldSpec("QR_YN            "        ,1    ,  false, false),
	        new FieldSpec("PHOTO_FILE_NM    "        ,50   ,  false, false),
	        new FieldSpec("SIGN_FILE_NM     "        ,50   ,  false, false),
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
