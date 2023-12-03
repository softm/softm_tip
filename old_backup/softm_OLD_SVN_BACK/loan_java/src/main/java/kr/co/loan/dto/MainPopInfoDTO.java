package kr.co.loan.dto;

import org.apache.commons.lang3.builder.ToStringBuilder;

import kr.co.loan.lib.dto.BaseDTO;

/**
 * MainPopInfoDTO
 * @author softm 
 */
public class MainPopInfoDTO extends BaseDTO {
	private String CNT1;	
	private String CNT2;	
	private String CNT3;	
	private String CNT4;	

	public String getCNT1() {
		return CNT1;
	}

	public void setCNT1(String cNT1) {
		CNT1 = cNT1;
	}

	public String getCNT2() {
		return CNT2;
	}

	public void setCNT2(String cNT2) {
		CNT2 = cNT2;
	}

	public String getCNT3() {
		return CNT3;
	}

	public void setCNT3(String cNT3) {
		CNT3 = cNT3;
	}

	public String getCNT4() {
		return CNT4;
	}

	public void setCNT4(String cNT4) {
		CNT4 = cNT4;
	}

	@Override
	public String toString() {
	    return ToStringBuilder.reflectionToString(this).toString();		
	}

	public MainPopInfoDTO() {
		super();
	}
}
