package kr.co.loan.dto;

import kr.co.loan.lib.dto.BaseDTO;

/**
 * CodeListItemDTO
 * @author softm 
 */
public class CodeListItemDTO extends BaseDTO {
	
		private String CODE;	
		private String NAME;
		public String getCODE() {
			return CODE;
		}
		public void setCODE(String cODE) {
			CODE = cODE;
		}
		public String getNAME() {
			return NAME;
		}
		public void setNAME(String nAME) {
			NAME = nAME;
		}
		public CodeListItemDTO(String cODE, String nAME) {
			super();
			CODE = cODE;
			NAME = nAME;
		}
		
		
}
