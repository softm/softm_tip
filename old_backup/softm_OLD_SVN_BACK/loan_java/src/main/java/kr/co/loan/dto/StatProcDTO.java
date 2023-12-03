package kr.co.loan.dto;

import org.apache.commons.lang3.builder.ToStringBuilder;

import kr.co.loan.lib.dto.BaseDTO;

/**
 * StatProcDTO
 * @author softm 
 */
public class StatProcDTO extends BaseDTO {
	private String UNDEFINED;	

	public String getUNDEFINED() {
		return UNDEFINED;
	}

	public void setUNDEFINED(String uNDEFINED) {
		UNDEFINED = uNDEFINED;
	}

	@Override
	public String toString() {
	    return ToStringBuilder.reflectionToString(this).toString();		
	}

	public StatProcDTO() {
		super();
	}
	
}
