package com.entropykorea.gas.chk.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;
import com.entropykorea.gas.chk.common.WConstant;

public class AreaCenterSpec extends BaseSpec {

	private String fileName = "area_center.dat";
	private String tableName = WConstant.TBL_AREA_CENTER;
	private FieldSpec[] fieldSpecs = {
	        new FieldSpec("AREA_CENTER_CD"              , 20   , true  , false),
	        new FieldSpec("AREA_CENTER_NM"              , 100  , false , false),
	        new FieldSpec("TEL_NO"                      , 30   , false , false),
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
