package kr.co.loan.dto;

import java.util.ArrayList;

import org.apache.commons.lang3.builder.ToStringBuilder;

import kr.co.loan.lib.dto.BaseDTO;

/**
 * MainDataRoomListDTO
 * @author softm 
 */
public class MainDataRoomListDTO extends BaseDTO {
	
	private ArrayList<MainDataRoomListItemDTO> LIST;	
	public MainDataRoomListDTO() {
		super();
	}

	public ArrayList<MainDataRoomListItemDTO> getLIST() {
		return LIST;
	}

	public void setLIST(ArrayList<MainDataRoomListItemDTO> lIST) {
		LIST = lIST;
	}

	@Override
	public String toString() {
	    return ToStringBuilder.reflectionToString(this).toString();		
	}
}
