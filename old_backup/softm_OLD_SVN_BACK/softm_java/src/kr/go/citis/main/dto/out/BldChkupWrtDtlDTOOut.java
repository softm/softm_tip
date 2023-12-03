package kr.go.citis.main.dto.out;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.BldChkupWrtDtlDTO;

/**
 * BldChkupWrtDtlDTOOut
 * 체크리스트마스터상세 : 수정시 조회필요
 * @author softm 
 */
public class BldChkupWrtDtlDTOOut extends BaseDTO {
	private BldChkupWrtDtlDTO data; 
	public BldChkupWrtDtlDTOOut() {
		super();
	}
	public BldChkupWrtDtlDTO getData() {
		return data;
	}
	public void setData(BldChkupWrtDtlDTO data) {
		this.data = data;
	}
	
	
}