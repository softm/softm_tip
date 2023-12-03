package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.BldChkupWrtItemListDTO;

/**
 * BldChkupWrtItemListDTOIn
 * 체크리스트항목조회
 * @author softm 
 */
public class BldChkupWrtItemListDTOIn extends BaseDTOIn {
	private BldChkupWrtItemListDTO data; 
	public BldChkupWrtItemListDTOIn() {
		super();
	}
	public BldChkupWrtItemListDTO getData() {
		return data;
	}
	public void setData(BldChkupWrtItemListDTO data) {
		this.data = data;
	}
	
	
}