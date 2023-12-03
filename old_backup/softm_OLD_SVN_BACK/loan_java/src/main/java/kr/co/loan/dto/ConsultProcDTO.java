package kr.co.loan.dto;

import org.apache.commons.lang3.builder.ToStringBuilder;

import kr.co.loan.lib.dto.BaseDTO;

/**
 * ConsultProcDTO
 * @author softm 
 */
public class ConsultProcDTO extends BaseDTO {
	private String LOANREQ_SEQ  ;	
	private String PT_CUST_NO   ;	
	private String LOAN_STATE_CD;	
	private String ADMIN_NO     ;	

	public String getLOANREQ_SEQ() {
		return LOANREQ_SEQ;
	}

	public void setLOANREQ_SEQ(String lOANREQ_SEQ) {
		LOANREQ_SEQ = lOANREQ_SEQ;
	}

	public String getPT_CUST_NO() {
		return PT_CUST_NO;
	}

	public void setPT_CUST_NO(String pT_CUST_NO) {
		PT_CUST_NO = pT_CUST_NO;
	}

	public String getLOAN_STATE_CD() {
		return LOAN_STATE_CD;
	}

	public void setLOAN_STATE_CD(String lOAN_STATE_CD) {
		LOAN_STATE_CD = lOAN_STATE_CD;
	}

	public String getADMIN_NO() {
		return ADMIN_NO;
	}

	public void setADMIN_NO(String aDMIN_NO) {
		ADMIN_NO = aDMIN_NO;
	}

	@Override
	public String toString() {
	    return ToStringBuilder.reflectionToString(this).toString();		
	}

	public ConsultProcDTO() {
		super();
	}
	
}
