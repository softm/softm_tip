package com.entropykorea.gas.chk.dto;
/**
 * ChkBoilerDTO
 * @author softm 
 */
public class ChkBoilerDTO {
	String checkupIdx=""; // 안전점검인덱스	
	String boiIdx = ""; // 보일러인덱스(PK)
	String boiNo = ""; // 보일러번호
	String modelNm = ""; // 모델명
	String makeNo = ""; // 제조번호
	String makeYy = ""; // 제조년도
	String makerCd = ""; // 제조사코드
	String installCoCd = ""; // 시공사
	String installUserNm = ""; // 시공자명

	public void setCheckupIdx(String checkupIdx) { // 안전점검인덱스
		this.checkupIdx = checkupIdx;
	}
	public String getCheckupIdx() { // 안전점검인덱스
		return this.checkupIdx;
	}
	public void setBoiIdx(String boiIdx) { // 보일러인덱스(PK)
	    this.boiIdx = boiIdx;
	}
	public String getBoiIdx() { // 보일러인덱스(PK)
	    return this.boiIdx;
	}
	public void setBoiNo(String boiNo) { // 보일러번호
	    this.boiNo = boiNo;
	}
	public String getBoiNo() { // 보일러번호
	    return this.boiNo;
	}
	public void setModelNm(String modelNm) { // 모델명
	    this.modelNm = modelNm;
	}
	public String getModelNm() { // 모델명
	    return this.modelNm;
	}
	public void setMakeNo(String makeNo) { // 제조번호
	    this.makeNo = makeNo;
	}
	public String getMakeNo() { // 제조번호
	    return this.makeNo;
	}
	public void setMakeYy(String makeYy) { // 제조년도
	    this.makeYy = makeYy;
	}
	public String getMakeYy() { // 제조년도
	    return this.makeYy;
	}
	public void setMakerCd(String makerCd) { // 제조사코드
	    this.makerCd = makerCd;
	}
	public String getMakerCd() { // 제조사코드
	    return this.makerCd;
	}
	public void setInstallCoCd(String installCoCd) { // 시공사
	    this.installCoCd = installCoCd;
	}
	public String getInstallCoCd() { // 시공사
	    return this.installCoCd;
	}
	public void setInstallUserNm(String installUserNm) { // 시공자명
	    this.installUserNm = installUserNm;
	}
	public String getInstallUserNm() { // 시공자명
	    return this.installUserNm;
	}
	
	int count; // 갯수
	public void setCount(int count) { // 갯수
	    this.count = count;
	}
	public int getCount() { // 갯수
	    return this.count;
	}
		
}
