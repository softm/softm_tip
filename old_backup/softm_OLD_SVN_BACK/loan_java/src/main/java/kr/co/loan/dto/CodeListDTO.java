package kr.co.loan.dto;

import java.util.ArrayList;

import org.apache.commons.lang3.builder.ToStringBuilder;

import kr.co.loan.lib.dto.BaseDTO;

/**
 * CodeListItemDTO
 * @author softm 
 */
public class CodeListDTO extends BaseDTO {
	
	private ArrayList<CodeListItemDTO> LIST;	
	public CodeListDTO() {
		super();
	}

	public ArrayList<CodeListItemDTO> getLIST() {
		return LIST;
	}

	public void setLIST(ArrayList<CodeListItemDTO> lIST) {
		LIST = lIST;
	}

	@Override
	public String toString() {
	    return ToStringBuilder.reflectionToString(this).toString();		
	}
}
