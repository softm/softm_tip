package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * TestReqDocSaveDTOData
 * 검측요청서 저장
 * @author softm 
 */
public class TestReqDocSaveDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String pIspnChkMgntSeq; // 검측마스터번호
public String ispnRqstsNo; // 검측요청서번호
public String rqstsDt; // 검측요청일
public String cusr; // 받음
public String cnsttypenm; // 공종
public String dtlcnsttypenm; // 세부공종
public String plcPrt; // 위치
public String ispnPrt; // 검측부위
public String ispnCalltm; // 검측요구일시
public String ispnDtls; // 검측사항
public String chkUserNm; // 점검직원
public String susr; // 현장대리인
public String saveType; // 저장상태[임시저장,확정][S,C]

	public TestReqDocSaveDTO() {
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
	public String getIspnRqstsNo() {
		return ispnRqstsNo;
	}
	public void setIspnRqstsNo(String ispnRqstsNo) {
		this.ispnRqstsNo = ispnRqstsNo;
	}
	public String getRqstsDt() {
		return rqstsDt;
	}
	public void setRqstsDt(String rqstsDt) {
		this.rqstsDt = rqstsDt;
	}
	public String getCnsttypenm() {
		return cnsttypenm;
	}
	public void setCnsttypenm(String cnsttypenm) {
		this.cnsttypenm = cnsttypenm;
	}
	public String getDtlcnsttypenm() {
		return dtlcnsttypenm;
	}
	public void setDtlcnsttypenm(String dtlcnsttypenm) {
		this.dtlcnsttypenm = dtlcnsttypenm;
	}
	public String getPlcPrt() {
		return plcPrt;
	}
	public void setPlcPrt(String plcPrt) {
		this.plcPrt = plcPrt;
	}
	public String getIspnPrt() {
		return ispnPrt;
	}
	public void setIspnPrt(String ispnPrt) {
		this.ispnPrt = ispnPrt;
	}
	public String getIspnCalltm() {
		return ispnCalltm;
	}
	public void setIspnCalltm(String ispnCalltm) {
		this.ispnCalltm = ispnCalltm;
	}
	public String getIspnDtls() {
		return ispnDtls;
	}
	public void setIspnDtls(String ispnDtls) {
		this.ispnDtls = ispnDtls;
	}
	public String getCusr() {
		return cusr;
	}
	public String getChkUserNm() {
		return chkUserNm;
	}
	public String getSusr() {
		return susr;
	}
	public String getSaveType() {
		return saveType;
	}
	public void setCusr(String cusr) {
		this.cusr = cusr;
	}
	public void setChkUserNm(String chkUserNm) {
		this.chkUserNm = chkUserNm;
	}
	public void setSusr(String susr) {
		this.susr = susr;
	}
	public void setSaveType(String saveType) {
		this.saveType = saveType;
	}

	
	
}