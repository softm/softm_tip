package kr.co.loan.dto;

import org.apache.commons.lang3.builder.ToStringBuilder;

import kr.co.loan.lib.dto.BaseDTO;

/**
 * CertMobileProc02DTO
 * @author softm 
 */
public class CertMobileProc02DTO extends BaseDTO {
	private String REGISTER_NO     ;	
	private String CERT_USER_NAME  ;	
	private String CERT_CERT_TYPE  ;	
	private String CERT_LOANREQ_SEQ;	
	private String CERT_AUTH_RESULT;	
	private String CERT_AUTH_NO    ;	

	public String getREGISTER_NO() {
		return REGISTER_NO;
	}

	public void setREGISTER_NO(String rEGISTER_NO) {
		REGISTER_NO = rEGISTER_NO;
	}

	public String getCERT_USER_NAME() {
		return CERT_USER_NAME;
	}

	public void setCERT_USER_NAME(String cERT_USER_NAME) {
		CERT_USER_NAME = cERT_USER_NAME;
	}

	public String getCERT_CERT_TYPE() {
		return CERT_CERT_TYPE;
	}

	public void setCERT_CERT_TYPE(String cERT_CERT_TYPE) {
		CERT_CERT_TYPE = cERT_CERT_TYPE;
	}

	public String getCERT_LOANREQ_SEQ() {
		return CERT_LOANREQ_SEQ;
	}

	public void setCERT_LOANREQ_SEQ(String cERT_LOANREQ_SEQ) {
		CERT_LOANREQ_SEQ = cERT_LOANREQ_SEQ;
	}

	public String getCERT_AUTH_RESULT() {
		return CERT_AUTH_RESULT;
	}

	public void setCERT_AUTH_RESULT(String cERT_AUTH_RESULT) {
		CERT_AUTH_RESULT = cERT_AUTH_RESULT;
	}

	public String getCERT_AUTH_NO() {
		return CERT_AUTH_NO;
	}

	public void setCERT_AUTH_NO(String cERT_AUTH_NO) {
		CERT_AUTH_NO = cERT_AUTH_NO;
	}

	@Override
	public String toString() {
	    return ToStringBuilder.reflectionToString(this).toString();		
	}

	public CertMobileProc02DTO() {
		super();
	}
	
}
