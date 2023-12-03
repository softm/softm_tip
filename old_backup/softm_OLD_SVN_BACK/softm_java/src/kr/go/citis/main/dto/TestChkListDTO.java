package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * TestChkListDTO
 * 검측 체크리스트 목록 조회
 * @author softm 
 */
public class TestChkListDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String pIspnChkMgntSeq; // 검측마스터번호
public String ispnChkSeq; // 검측체크번호
public String chkDt; // 점검일자
public String dtlcnsttypecd; // 세부공종코드
public String dtlcnsttypenm; // 세부공종명
public String dtlcnsttypeNm; // 전체공종명-세부공종명
public String ispnDt; // 검측일자
public String rsltStatus; // 검측결과코드
public String rsltStatusNm; // 검측결과명
public String rqstsDt; // 검측요청일자
public String rsltNotiDt; // 통보일자
public String siteNo; // 담당현장번호

	public TestChkListDTO() {
		super();
	}

	public String getMode() {
		return mode;
	}

	public void setMode(String mode) {
		this.mode = mode;
	}

	public String getpIspnChkMgntSeq() {
		return pIspnChkMgntSeq;
	}

	public void setpIspnChkMgntSeq(String pIspnChkMgntSeq) {
		this.pIspnChkMgntSeq = pIspnChkMgntSeq;
	}

	public String getIspnChkSeq() {
		return ispnChkSeq;
	}

	public void setIspnChkSeq(String ispnChkSeq) {
		this.ispnChkSeq = ispnChkSeq;
	}

	public String getChkDt() {
		return chkDt;
	}

	public void setChkDt(String chkDt) {
		this.chkDt = chkDt;
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

	public String getIspnDt() {
		return ispnDt;
	}

	public void setIspnDt(String ispnDt) {
		this.ispnDt = ispnDt;
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

	public String getDtlcnsttypeNm() {
		return dtlcnsttypeNm;
	}

	public void setDtlcnsttypeNm(String dtlcnsttypeNm) {
		this.dtlcnsttypeNm = dtlcnsttypeNm;
	}

	public String getRqstsDt() {
		return rqstsDt;
	}

	public void setRqstsDt(String rqstsDt) {
		this.rqstsDt = rqstsDt;
	}

	public String getRsltNotiDt() {
		return rsltNotiDt;
	}

	public void setRsltNotiDt(String rsltNotiDt) {
		this.rsltNotiDt = rsltNotiDt;
	}

	public String getSiteNo() {
		return siteNo;
	}

	public void setSiteNo(String siteNo) {
		this.siteNo = siteNo;
	}
}