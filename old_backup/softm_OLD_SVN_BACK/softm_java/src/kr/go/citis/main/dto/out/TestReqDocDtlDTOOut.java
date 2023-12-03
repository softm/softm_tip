package kr.go.citis.main.dto.out;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.TestReqDocDtlDTO;

/**
 * TestReqDocDtlDTOOut
 * 검측요청서 조회(상세)
 * @author softm 
 */
public class TestReqDocDtlDTOOut extends BaseDTO {
	private TestReqDocDtlDTO data; 
	public TestReqDocDtlDTOOut() {
		super();
	}
	public TestReqDocDtlDTO getData() {
		return data;
	}
	public void setData(TestReqDocDtlDTO data) {
		this.data = data;
	}
	
}