package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.TestChkListDTO;

/**
 * TestChkListDTOIn
 * 검측 체크리스트 목록 조회
 * @author softm 
 */
public class TestChkListDTOIn extends BaseDTOIn {
	private TestChkListDTO data; 
	
	public TestChkListDTOIn() {
		super();
	}

	public TestChkListDTO getData() {
		return data;
	}

	public void setData(TestChkListDTO data) {
		this.data = data;
	}
	
	
}