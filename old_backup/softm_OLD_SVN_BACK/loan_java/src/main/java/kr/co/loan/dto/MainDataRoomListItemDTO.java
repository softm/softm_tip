package kr.co.loan.dto;

import java.util.ArrayList;

import org.apache.commons.lang3.builder.ToStringBuilder;

import kr.co.loan.lib.dto.BaseDTO;

/**
 * MainDataRoomListItemDTO
 * @author softm 
 */
public class MainDataRoomListItemDTO extends BaseDTO {
	
		private String TITLE;	
		private String REG_DATE;
		public String getTITLE() {
			return TITLE;
		}
		public void setTITLE(String tITLE) {
			TITLE = tITLE;
		}
		public String getREG_DATE() {
			return REG_DATE;
		}
		public void setREG_DATE(String rEG_DATE) {
			REG_DATE = rEG_DATE;
		}
		
		
}
