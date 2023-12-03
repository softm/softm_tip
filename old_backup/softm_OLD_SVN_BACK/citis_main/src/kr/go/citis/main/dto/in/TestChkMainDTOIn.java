package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.TestChkMainDTO;

/**
 * TestChkMainDTOIn
 * 검측 체크리스트 메인 조회
 * @author softm 
 */
public class TestChkMainDTOIn extends BaseDTOIn {
	private TestChkMainDTO data; 
	
	public TestChkMainDTOIn() {
		super();
	}

	public TestChkMainDTO getData() {
		return data;
	}

	public void setData(TestChkMainDTO data) {
		this.data = data;
	}
	
	
}