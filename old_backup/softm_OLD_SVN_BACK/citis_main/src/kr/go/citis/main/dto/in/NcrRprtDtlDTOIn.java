package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.NcrRprtDtlDTO;

/**
 * NcrRprtDtlDTOIn
 * 부적합 보고서 조회(상세)
 * @author softm 
 */
public class NcrRprtDtlDTOIn extends BaseDTOIn {
	private NcrRprtDtlDTO data; 
	public NcrRprtDtlDTOIn() {
		super();
	}
	public NcrRprtDtlDTO getData() {
		return data;
	}
	public void setData(NcrRprtDtlDTO data) {
		this.data = data;
	}
}