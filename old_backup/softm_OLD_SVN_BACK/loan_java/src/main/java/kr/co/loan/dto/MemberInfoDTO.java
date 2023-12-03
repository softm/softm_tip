package kr.co.loan.dto;

import org.apache.commons.lang3.builder.ToStringBuilder;

import kr.co.loan.lib.dto.BaseDTO;

/**
 * MemberInfoDTO
 * @author softm 
 */
public class MemberInfoDTO extends BaseDTO {
	private String MEMBER_NO;	
	private String ROLE_CD;	
	private String MEMBER_STATE;	
	private String TEAM_CD;	
	private String DEPT_NM;	
	private String USER_NAME;	

	public String getMEMBER_NO() {
		return MEMBER_NO;
	}

	public void setMEMBER_NO(String mEMBER_NO) {
		MEMBER_NO = mEMBER_NO;
	}

	public String getROLE_CD() {
		return ROLE_CD;
	}

	public void setROLE_CD(String rOLE_CD) {
		ROLE_CD = rOLE_CD;
	}

	public String getMEMBER_STATE() {
		return MEMBER_STATE;
	}

	public void setMEMBER_STATE(String mEMBER_STATE) {
		MEMBER_STATE = mEMBER_STATE;
	}

	public String getTEAM_CD() {
		return TEAM_CD;
	}

	public void setTEAM_CD(String tEAM_CD) {
		TEAM_CD = tEAM_CD;
	}

	public String getDEPT_NM() {
		return DEPT_NM;
	}

	public void setDEPT_NM(String dEPT_NM) {
		DEPT_NM = dEPT_NM;
	}

	public String getUSER_NAME() {
		return USER_NAME;
	}

	public void setUSER_NAME(String uSER_NAME) {
		USER_NAME = uSER_NAME;
	}

	@Override
	public String toString() {
	    return ToStringBuilder.reflectionToString(this).toString();		
	}

	public MemberInfoDTO() {
		super();
	}
}
