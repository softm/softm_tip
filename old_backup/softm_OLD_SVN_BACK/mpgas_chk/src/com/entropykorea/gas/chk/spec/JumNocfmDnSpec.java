package com.entropykorea.gas.chk.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;
import com.entropykorea.gas.chk.common.WConstant;

public class JumNocfmDnSpec extends BaseSpec {

	private String fileName = "jum_nocfm_dn.dat";
	private String tableName = WConstant.TBL_JUM_NOCFM;
	private FieldSpec[] fieldSpecs = {
	        new FieldSpec("CHECKUP_IDX"         ,10 ,  true , false),
	        new FieldSpec("FA_CD"               ,10 ,  true , false),
	        new FieldSpec("CHECKUP_ITEM_CD"     ,10 ,  true , false),
	        new FieldSpec("CHECKUP_REMARK_CD"   ,10 ,  true , false),
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
