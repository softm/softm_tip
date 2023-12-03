package com.entropykorea.gas.main.common;

public enum PackageName {
	MAIN("도시가스","mpgas_main", "com.entropykorea.gas.main","com.entropykorea.gas.main.activity.MainActivity"),
	GUM("검침","mpgas_gum", "com.entropykorea.gas.gum","com.entropykorea.gas.gum.activity.MainActivity"),
	AS("민원","mpgas_as","com.entropykorea.gas.as","com.entropykorea.gas.as.activity.MainActivity"),
	CHG("계량기교체","mpgas_chg","com.entropykorea.gas.chg","com.entropykorea.gas.chg.activity.MainActivity"),
	CHK("안전점검","mpgas_chk","com.entropykorea.gas.chk","com.entropykorea.gas.chk.activity.MainActivity"),
	CHE("체납","mpgas_che","com.entropykorea.gas.che","com.entropykorea.gas.che.activity.MainActivity");
	
	private String packageString;
	private String packageCode;
	private String packageName;
	private String className;
	
	PackageName(String packageString, String packageCode, String packageName, String className ) {
		this.packageString = packageString;
		this.packageCode = packageCode;
		this.packageName = packageName;
		this.className = className;
	}
	
	public String getPackageString() {
		return this.packageString;
	}
	
	public String getPackageCode() {
		return this.packageCode;
	}

	public String getPackageName() {
		return this.packageName;
	}
	
	public String getClassName() {
		return this.className;
	}
}
