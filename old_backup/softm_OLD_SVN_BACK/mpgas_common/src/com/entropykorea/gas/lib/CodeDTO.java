package com.entropykorea.gas.lib;
/**
 * CodeDTO
 * @author softm 
 */
public class CodeDTO {
	private String cd;
	private String cdNm;
	
	public CodeDTO() {
		super();
	}
	public CodeDTO(String cd, String cdNm) {
		super();
		this.cd = cd;
		this.cdNm = cdNm;
	}
	public String getCd() {
		return cd;
	}
	public void setCd(String cd) {
		this.cd = cd;
	}
	
	public String getCdNm() {
		return cdNm;
	}
	public void setCdNm(String cdNm) {
		this.cdNm = cdNm;
	}
	
}
