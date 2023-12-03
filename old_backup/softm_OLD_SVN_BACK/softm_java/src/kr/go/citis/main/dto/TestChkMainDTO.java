package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * TestChkMainDTO
 * 검측 체크리스트 메인 조회
 * @author softm 
 */
public class TestChkMainDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String pSiteNo; // 현장번호[담당,관할]
public String pCnsttypecd; // 공종
public String pChkDtYyyymm; // 년월
public String pIspnPrgrs; // 진행상태
public String ispnChkMgntSeq; // 검측마스터번호
public String dtlcnsttypecd; // 세부공종코드
public String dtlcnsttypenm; // 세부공종명
public String chkDt; // 점검일자
public String rqstsDt; // 검측요청일
public String ispnDt; // 검측일자
public String ispnPrgrs; // 진행상태코드
public String ispnPrgrsNm; // 진행상태명
public String rsltStatus; // 검측결과코드
public String rsltStatusNm; // 검측결과명
	public TestChkMainDTO() {
		super();
	}
	public String getMode() {
		return mode;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public String getpSiteNo() {
		return pSiteNo;
	}
	public void setpSiteNo(String pSiteNo) {
		this.pSiteNo = pSiteNo;
	}
	public String getpCnsttypecd() {
		return pCnsttypecd;
	}
	public void setpCnsttypecd(String pCnsttypecd) {
		this.pCnsttypecd = pCnsttypecd;
	}
	public String getpChkDtYyyymm() {
		return pChkDtYyyymm;
	}
	public void setpChkDtYyyymm(String pChkDtYyyymm) {
		this.pChkDtYyyymm = pChkDtYyyymm;
	}
	public String getpIspnPrgrs() {
		return pIspnPrgrs;
	}
	public void setpIspnPrgrs(String pIspnPrgrs) {
		this.pIspnPrgrs = pIspnPrgrs;
	}
	public String getIspnChkMgntSeq() {
		return ispnChkMgntSeq;
	}
	public void setIspnChkMgntSeq(String ispnChkMgntSeq) {
		this.ispnChkMgntSeq = ispnChkMgntSeq;
	}
	public String getDtlcnsttypecd() {
		return dtlcnsttypecd;
	}
	public void setDtlcnsttypecd(String dtlcnsttypecd) {
		this.dtlcnsttypecd = dtlcnsttypecd;
	}
	public String getDtlcnsttypenm() {
		return dtlcnsttypenm;
	}
	public void setDtlcnsttypenm(String dtlcnsttypenm) {
		this.dtlcnsttypenm = dtlcnsttypenm;
	}
	public String getChkDt() {
		return chkDt;
	}
	public void setChkDt(String chkDt) {
		this.chkDt = chkDt;
	}
	public String getRqstsDt() {
		return rqstsDt;
	}
	public void setRqstsDt(String rqstsDt) {
		this.rqstsDt = rqstsDt;
	}
	public String getIspnDt() {
		return ispnDt;
	}
	public void setIspnDt(String ispnDt) {
		this.ispnDt = ispnDt;
	}
	public String getIspnPrgrs() {
		return ispnPrgrs;
	}
	public void setIspnPrgrs(String ispnPrgrs) {
		this.ispnPrgrs = ispnPrgrs;
	}
	public String getIspnPrgrsNm() {
		return ispnPrgrsNm;
	}
	public void setIspnPrgrsNm(String ispnPrgrsNm) {
		this.ispnPrgrsNm = ispnPrgrsNm;
	}
	public String getRsltStatus() {
		return rsltStatus;
	}
	public void setRsltStatus(String rsltStatus) {
		this.rsltStatus = rsltStatus;
	}
	public String getRsltStatusNm() {
		return rsltStatusNm;
	}
	public void setRsltStatusNm(String rsltStatusNm) {
		this.rsltStatusNm = rsltStatusNm;
	}
	
	
}