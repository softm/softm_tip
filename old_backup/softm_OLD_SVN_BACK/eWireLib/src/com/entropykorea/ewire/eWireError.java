package com.entropykorea.ewire;


// Server Error number 와 같지 않음
public enum eWireError {
	NONE_ERROR("0000","OK",""),
	// eWire error
	CONNECT_ERROR("7001","서버에 연결할 수 없습니다.",""),
	SEND_ERROR("7002","자료 전송 실패입니다.",""),
	RECV_ERROR("7003","자료 수신 실패입니다.",""),
	RECV2_ERROR("7004","자료 수신 실패입니다.",""), // "전문에 오류가 있습니다."
	CRC_ERROR("7005","CRC 오류 입니다.",""),
	FILE_OPEN_ERROR("7006","파일을 열수 없습니다.",""),
	FILE_READ_ERROR("7007","파일을 읽을 수 없습니다.",""),
	FILE_WRITE_ERROR("7008","파일을 쓸수 없습니다.",""),
	FILE_SIZE_ERROR("7009","파일 사이즈가 틀립니다.",""),
	// zip error
	ZIP_NOZIP_ERROR("7100","파일이 없습니다.",""),
	ZIP_UNZIP_ERROR("7101","압축을 풀 수 없습니다.",""),
	ZIP_MAKEZIP_ERROR("7102","압축 할 수 없습니다.",""),
	// db error
	SQL_ERROR_ERROR("7201","데이타베이스 에러 입니다.",""),
	SQL_INSERT_ERROR("7202","데이타베이스에 추가 할 수 없습니다.",""),
	SQL_SELECT_ERROR("7203","데이타베이스 에러 입니다.",""),
	// etc
	ETC_ERROR("9999","기타 오류 입니다.",""),
	MEMORY_ERROR("9998","메모리가 부족합니다.","");
	
	private String code;
	private String desc;
	private String detail;
	
	eWireError(String code, String desc, String detail) {
		this.code = code;
		this.desc = desc;
		this.detail = detail;
	}
	
	public String getError() {
		String str = this.code + "|" + this.desc + ( this.detail.length() > 0 ? "|" + this.detail : "" );
		return str;
	}
	
	public String getCode() {
		return this.code;
	}
	
	public void setCode(String code) {
		this.code = code;
	}
	
	public String getDesc() {
		return this.desc;
	}
	
	public void setDesc(String desc) {
		this.desc = desc;
	}
	
	public String getDetail() {
		return this.detail;
	}
	
	public void setDetail(String detail) {
		this.detail = detail;
	}
}
