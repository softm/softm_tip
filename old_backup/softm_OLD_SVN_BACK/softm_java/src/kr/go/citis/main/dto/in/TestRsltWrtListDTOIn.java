package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.TestRsltWrtListDTO;

/**
 * TestRsltWrtListDTOIn
 * 검측 결과 등록 조회
 * @author softm 
 */
public class TestRsltWrtListDTOIn extends BaseDTOIn {
	private TestRsltWrtListDTO data; 
	public TestRsltWrtListDTOIn() {
		super();
	}
	public TestRsltWrtListDTO getData() {
		return data;
	}
	public void setData(TestRsltWrtListDTO data) {
		this.data = data;
	}
	
}