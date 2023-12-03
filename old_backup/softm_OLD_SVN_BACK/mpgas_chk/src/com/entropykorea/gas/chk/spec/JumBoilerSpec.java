package com.entropykorea.gas.chk.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;
import com.entropykorea.gas.chk.common.WConstant;

public class JumBoilerSpec extends BaseSpec {

	private String fileName = "jum_boiler.dat";
	private String tableName = WConstant.TBL_JUM_BOILER;
	private FieldSpec[] fieldSpecs = {
			new FieldSpec("CHECKUP_IDX"         ,10    ,  true , false),
			new FieldSpec("BOI_IDX"             ,10    ,  true , false),
			new FieldSpec("BOI_NO"              ,40    , false , false),
			new FieldSpec("MODEL_NM"            ,100   , false , false),
			new FieldSpec("MAKE_NO"             ,20    , false , false),
			new FieldSpec("MAKE_YY"             ,4     , false , false),
			new FieldSpec("MAKER_CD"            ,20    , false , false),
			new FieldSpec("INSTALL_CO_CD"       ,20    , false , false),
			new FieldSpec("INSTALL_USER_NM"     ,50    , false , false),
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
