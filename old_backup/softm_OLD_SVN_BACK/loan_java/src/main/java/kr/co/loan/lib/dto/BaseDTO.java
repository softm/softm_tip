package kr.co.loan.lib.dto;

import org.apache.commons.lang3.builder.ToStringBuilder;

/**
 * BaseDTO
 * @author softm
 */
public class BaseDTO {
	private String RESULT_CD;
	private String RESULT_MSG;
	
	public BaseDTO() {
		super();
	}


	public String getRESULT_CD() {
		return RESULT_CD;
	}


	public void setRESULT_CD(String rESULT_CD) {
		RESULT_CD = rESULT_CD;
	}


	public String getRESULT_MSG() {
		return RESULT_MSG;
	}


	public void setRESULT_MSG(String rESULT_MSG) {
		RESULT_MSG = rESULT_MSG;
	}


	@Override
	public String toString() {
       return ToStringBuilder.reflectionToString(this).toString();		
	}
//	
}
