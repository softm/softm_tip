package com.entropykorea.gas.chk.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;
import com.entropykorea.gas.chk.common.WConstant;

public class JumVisitDnSpec extends BaseSpec {

	private String fileName = "jum_visit_dn.dat";
	private String tableName = WConstant.TBL_JUM_VISIT;
	private FieldSpec[] fieldSpecs = {
	        new FieldSpec("CHECKUP_IDX    " ,10,   true , false),
	        new FieldSpec("VISIT_SEQ      " ,10,   true , false),
	        new FieldSpec("VISIT_DT       " ,8 ,  false , false),
	        new FieldSpec("VISIT_TM       " ,6 ,  false , false),
	        new FieldSpec("VISIT_RESULT_CD" ,10,  false , false),
	        new FieldSpec("SEND_YN        " ,1 ,  false , false),
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
