package kr.go.citis.main.dto;

import kr.go.citis.main.common.WConstant;

/**
 * NcrRprtDtlDTO
 * 부적합 보고서 조회(상세)
 * @author softm 
 */
public class NcrRprtDtlDTO {
	private String mode = WConstant.LIST_DATA_MODE_READ;
	public String pRprtSeq     ; // 보고서 일련번호                 
	public String pRprtType    ; // 보고서 구분                  
	public String ispnRqstsNo  ; // 검측요청서번호                 
	public String rprtNo       ; // 보고서번호                   
	public String dtlcnsttypeNm; // 전체공종명-세부공종명[공종]         
	public String issDt        ; // 발행일자                    
	public String title        ; // 제목                      
	public String actDl        ; // 조치기한                    
	public String ncrDtls      ; // 부적합내용                   
	public String ncrImgUrl    ; // 부적합내용 이미지
	
	public String chrgSprv     ; // 담당감리원                   
	public String rspnSprv     ; // 책임감리원                   
	public String actRslt      ; // 조치결과                    
	public String actRsltImgUrl; // 조치결과 이미지                
	public String actDtls      ; // 조치결과 내용                 
	public String actRspn      ; // 조치책임자                   
	public String siteMngr     ; // 현장소장                    
	public String actRsltChk   ; // 조치결과확인
	
	public String ncrImgFileName ; // 부적합내용 이미지 파일명
	public String actRsltImgFileName; // 조치결과 내용 이미지 실제파일명
	
	public String getMode() {
		return mode;
	}
	public String getpRprtSeq() {
		return pRprtSeq;
	}
	public String getpRprtType() {
		return pRprtType;
	}
	public String getIspnRqstsNo() {
		return ispnRqstsNo;
	}
	public String getRprtNo() {
		return rprtNo;
	}
	public String getDtlcnsttypeNm() {
		return dtlcnsttypeNm;
	}
	public String getIssDt() {
		return issDt;
	}
	public String getTitle() {
		return title;
	}
	public String getActDl() {
		return actDl;
	}
	public String getNcrDtls() {
		return ncrDtls;
	}
	public String getNcrImgUrl() {
		return ncrImgUrl;
	}
	public String getChrgSprv() {
		return chrgSprv;
	}
	public String getRspnSprv() {
		return rspnSprv;
	}
	public String getActRslt() {
		return actRslt;
	}
	public String getActRsltImgUrl() {
		return actRsltImgUrl;
	}
	public String getActDtls() {
		return actDtls;
	}
	public String getActRspn() {
		return actRspn;
	}
	public String getSiteMngr() {
		return siteMngr;
	}
	public void setMode(String mode) {
		this.mode = mode;
	}
	public void setpRprtSeq(String pRprtSeq) {
		this.pRprtSeq = pRprtSeq;
	}
	public void setpRprtType(String pRprtType) {
		this.pRprtType = pRprtType;
	}
	public void setIspnRqstsNo(String ispnRqstsNo) {
		this.ispnRqstsNo = ispnRqstsNo;
	}
	public void setRprtNo(String rprtNo) {
		this.rprtNo = rprtNo;
	}
	public void setDtlcnsttypeNm(String dtlcnsttypeNm) {
		this.dtlcnsttypeNm = dtlcnsttypeNm;
	}
	public void setIssDt(String issDt) {
		this.issDt = issDt;
	}
	public void setTitle(String title) {
		this.title = title;
	}
	public void setActDl(String actDl) {
		this.actDl = actDl;
	}
	public void setNcrDtls(String ncrDtls) {
		this.ncrDtls = ncrDtls;
	}
	public void setNcrImgUrl(String ncrImgUrl) {
		this.ncrImgUrl = ncrImgUrl;
	}
	public void setChrgSprv(String chrgSprv) {
		this.chrgSprv = chrgSprv;
	}
	public void setRspnSprv(String rspnSprv) {
		this.rspnSprv = rspnSprv;
	}
	public void setActRslt(String actRslt) {
		this.actRslt = actRslt;
	}
	public void setActRsltImgUrl(String actRsltImgUrl) {
		this.actRsltImgUrl = actRsltImgUrl;
	}
	public void setActDtls(String actDtls) {
		this.actDtls = actDtls;
	}
	public void setActRspn(String actRspn) {
		this.actRspn = actRspn;
	}
	public void setSiteMngr(String siteMngr) {
		this.siteMngr = siteMngr;
	}
	public String getActRsltChk() {
		return actRsltChk;
	}
	public void setActRsltChk(String actRsltChk) {
		this.actRsltChk = actRsltChk;
	}
	public String getNcrImgFileName() {
		return ncrImgFileName;
	}
	public void setNcrImgFileName(String ncrImgFileName) {
		this.ncrImgFileName = ncrImgFileName;
	}
	public String getActRsltImgFileName() {
		return actRsltImgFileName;
	}
	public void setActRsltImgFileName(String actRsltImgFileName) {
		this.actRsltImgFileName = actRsltImgFileName;
	}

	
}