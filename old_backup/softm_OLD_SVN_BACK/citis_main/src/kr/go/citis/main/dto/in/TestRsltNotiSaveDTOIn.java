package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.TestRsltNotiSaveDTO;

/**
 * TestRsltNotiSaveDTOIn
 * 검측 결과 통보 저장
 * @author softm 
 */
public class TestRsltNotiSaveDTOIn extends BaseDTOIn {
	private TestRsltNotiSaveDTO data; 
	public TestRsltNotiSaveDTOIn() {
		super();
	}
	public TestRsltNotiSaveDTO getData() {
		return data;
	}
	public void setData(TestRsltNotiSaveDTO data) {
		this.data = data;
	}
	
}