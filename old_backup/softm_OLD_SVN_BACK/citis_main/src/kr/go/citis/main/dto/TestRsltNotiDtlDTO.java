package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * TestRsltNotiDtlDTO
 * 검측 결과 통보 조회
 * @author softm 
 */
public class TestRsltNotiDtlDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String pIspnChkMgntSeq; // 검측마스터번호
public String pIspnChkSeq; // 검측체크번호
public String ispnRqstsNo; // 검측요청서번호
public String cusr; // 받음
public String rsltStatus; // 검측결과상태
public String rsltDtls; // 검측결과내용
public String rsltInstr; // 지시사항
public String engNm1; // 검측건설사업관리기술자
public String engNm2; // 책임건설사업관리기술자
public String rsltNotiDt; // 통보일자
	public TestRsltNotiDtlDTO() {
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
	public String getpIspnChkSeq() {
		return pIspnChkSeq;
	}
	public void setpIspnChkSeq(String pIspnChkSeq) {
		this.pIspnChkSeq = pIspnChkSeq;
	}
	public String getIspnRqstsNo() {
		return ispnRqstsNo;
	}
	public void setIspnRqstsNo(String ispnRqstsNo) {
		this.ispnRqstsNo = ispnRqstsNo;
	}
	public String getRsltStatus() {
		return rsltStatus;
	}
	public void setRsltStatus(String rsltStatus) {
		this.rsltStatus = rsltStatus;
	}
	public String getRsltDtls() {
		return rsltDtls;
	}
	public void setRsltDtls(String rsltDtls) {
		this.rsltDtls = rsltDtls;
	}
	public String getRsltInstr() {
		return rsltInstr;
	}
	public void setRsltInstr(String rsltInstr) {
		this.rsltInstr = rsltInstr;
	}
	public String getEngNm1() {
		return engNm1;
	}
	public void setEngNm1(String engNm1) {
		this.engNm1 = engNm1;
	}
	public String getEngNm2() {
		return engNm2;
	}
	public void setEngNm2(String engNm2) {
		this.engNm2 = engNm2;
	}
	public String getCusr() {
		return cusr;
	}
	public void setCusr(String cusr) {
		this.cusr = cusr;
	}
	public String getRsltNotiDt() {
		return rsltNotiDt;
	}
	public void setRsltNotiDt(String rsltNotiDt) {
		this.rsltNotiDt = rsltNotiDt;
	}
	
	
}