package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * BldChkupWrtDupChkDTOData
 * 검측마스터체크리스트 유무조회(신규작성시 세부공종, 점검일자에대한 중복확인 시 "완료"버튼 처리에서만 체크되게.)
 * @author softm 
 */
public class BldChkupWrtDupChkDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
public String pDtlcnsttypecd; // 세부공종코드
public String pChkDt; // 점검일자
public String pSiteNo; // 현장번호[담당,관할]
public String ispnChkMgntSeq; // 검측마스터번호
public String ispnChkSeq; // 검측체크번호

    public BldChkupWrtDupChkDTO() {
		super();
	}

	public String getMode() {
		return mode;
	}

	public void setMode(String mode) {
		this.mode = mode;
	}

	public String getpDtlcnsttypecd() {
		return pDtlcnsttypecd;
	}

	public void setpDtlcnsttypecd(String pDtlcnsttypecd) {
		this.pDtlcnsttypecd = pDtlcnsttypecd;
	}

	public String getpChkDt() {
		return pChkDt;
	}

	public void setpChkDt(String pChkDt) {
		this.pChkDt = pChkDt;
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

	public String getpSiteNo() {
		return pSiteNo;
	}

	public void setpSiteNo(String pSiteNo) {
		this.pSiteNo = pSiteNo;
	}
    
}