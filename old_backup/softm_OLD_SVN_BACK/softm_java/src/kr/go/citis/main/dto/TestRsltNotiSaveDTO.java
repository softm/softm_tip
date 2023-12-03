package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * TestRsltNotiSaveDTO
 * 검측 결과 통보 저장
 * @author softm 
 */
public class TestRsltNotiSaveDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String ispnChkMgntSeq; // 검측마스터번호
public String ispnChkSeq; // 검측체크번호
public String ispnRqstsNo; // 검측요청서번호
public String cusr; // 받음
public String rsltStatus; // 검측결과상태
public String rsltDtls; // 검측결과내용
public String rsltInstr; // 지시사항
public String engNm1; // 검측건설사업관리기술자
public String engNm2; // 책임건설사업관리기술자
public String saveType; // 저장상태[임시저장,확정][S,C]

	public TestRsltNotiSaveDTO() {
		super();
	}

	public String getMode() {
		return mode;
	}

	public void setMode(String mode) {
		this.mode = mode;
	}

	public String getIspnChkMgntSeq() {
		return ispnChkMgntSeq;
	}

	public void setIspnChkMgntSeq(String ispnChkMgntSeq) {
		this.ispnChkMgntSeq = ispnChkMgntSeq;
	}

	public String getIspnChkSeq() {
		return ispnChkSeq;
	}

	public void setIspnChkSeq(String ispnChkSeq) {
		this.ispnChkSeq = ispnChkSeq;
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

	public String getSaveType() {
		return saveType;
	}

	public void setSaveType(String saveType) {
		this.saveType = saveType;
	}

	public String getCusr() {
		return cusr;
	}

	public void setCusr(String cusr) {
		this.cusr = cusr;
	}
	
	
}