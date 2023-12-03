package com.entropykorea.gas.chk.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;
import com.entropykorea.gas.chk.common.WConstant;

public class ProviderSpec extends BaseSpec {

	private String fileName = "provider.dat";
	private String tableName = WConstant.TBL_PROVIDER;
	private FieldSpec[] fieldSpecs = {
	        new FieldSpec("CO_NM"                    ,100   , false , false),
	        new FieldSpec("CEO_NM"                   ,50    , false , false),
	        new FieldSpec("CO_NO"                    ,20    , false , false),
	        new FieldSpec("ADDR"                     ,255   , false , false),
	        new FieldSpec("ROAD_ADDR1"               ,255   , false , false),
	        new FieldSpec("ROAD_ADDR2"               ,255   , false , false),
	        new FieldSpec("TEL_NO"                   ,30    , false , false),
	        new FieldSpec("VAN_NO"                   ,20    , false , false),
	        new FieldSpec("VAN_CARD_NO"              ,20    , false , false),
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
