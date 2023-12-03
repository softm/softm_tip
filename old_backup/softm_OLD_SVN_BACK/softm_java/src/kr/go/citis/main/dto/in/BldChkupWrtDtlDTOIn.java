package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.BldChkupWrtDtlDTO;

/**
 * BldChkupWrtDtlDTOIn
 * 체크리스트마스터상세 : 수정시 조회필요
 * @author softm 
 */
public class BldChkupWrtDtlDTOIn extends BaseDTOIn {
	private BldChkupWrtDtlDTO data; 
	
	public BldChkupWrtDtlDTOIn() {
		super();
	}

	public BldChkupWrtDtlDTO getData() {
		return data;
	}

	public void setData(BldChkupWrtDtlDTO data) {
		this.data = data;
	}
	
	
}