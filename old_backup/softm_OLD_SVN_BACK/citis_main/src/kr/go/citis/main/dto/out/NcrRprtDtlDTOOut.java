package kr.go.citis.main.dto.out;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.NcrRprtDtlDTO;

/**
 * NcrRprtDtlDTOOut
 * 부적합 보고서 조회(상세)
 * @author softm 
 */
public class NcrRprtDtlDTOOut extends BaseDTO {
	private NcrRprtDtlDTO data; 
	public NcrRprtDtlDTOOut() {
		super();
	}
	public NcrRprtDtlDTO getData() {
		return data;
	}
	public void setData(NcrRprtDtlDTO data) {
		this.data = data;
	}

	
}