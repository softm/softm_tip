package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.TestReqDocSaveDTO;

/**
 * TestReqDocSaveDTOIn
 * 검측요청서 저장
 * @author softm 
 */
public class TestReqDocSaveDTOIn extends BaseDTOIn {
	private TestReqDocSaveDTO data; 
	public TestReqDocSaveDTOIn() {
		super();
	}
	public TestReqDocSaveDTO getData() {
		return data;
	}
	public void setData(TestReqDocSaveDTO data) {
		this.data = data;
	}
	
}