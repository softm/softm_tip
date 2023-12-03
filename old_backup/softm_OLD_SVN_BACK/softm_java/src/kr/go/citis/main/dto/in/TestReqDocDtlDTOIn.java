package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.TestReqDocDtlDTO;

/**
 * TestReqDocDtlDTOIn
 * 검측요청서 조회(상세)
 * @author softm 
 */
public class TestReqDocDtlDTOIn extends BaseDTOIn {
	private TestReqDocDtlDTO data; 
	public TestReqDocDtlDTOIn() {
		super();
	}
	public TestReqDocDtlDTO getData() {
		return data;
	}
	public void setData(TestReqDocDtlDTO data) {
		this.data = data;
	}
	
}