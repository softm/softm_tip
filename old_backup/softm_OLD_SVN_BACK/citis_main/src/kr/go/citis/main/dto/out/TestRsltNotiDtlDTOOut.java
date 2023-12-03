package kr.go.citis.main.dto.out;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.TestRsltNotiDtlDTO;

/**
 * TestRsltNotiDtlDTOOut
 * 검측 결과 통보 조회
 * @author softm 
 */
public class TestRsltNotiDtlDTOOut extends BaseDTO {
	private TestRsltNotiDtlDTO data; 
	public TestRsltNotiDtlDTOOut() {
		super();
	}
	public TestRsltNotiDtlDTO getData() {
		return data;
	}
	public void setData(TestRsltNotiDtlDTO data) {
		this.data = data;
	}

	
}