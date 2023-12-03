package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.TestRsltNotiDtlDTO;

/**
 * TestRsltNotiDtlDTOIn
 * 검측 결과 통보 조회
 * @author softm 
 */
public class TestRsltNotiDtlDTOIn extends BaseDTOIn {
	private TestRsltNotiDtlDTO data; 
	public TestRsltNotiDtlDTOIn() {
		super();
	}
	public TestRsltNotiDtlDTO getData() {
		return data;
	}
	public void setData(TestRsltNotiDtlDTO data) {
		this.data = data;
	}
	
	
}