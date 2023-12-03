package kr.go.citis.main.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.TestChkMainDTO;

/**
 * TestChkMainDTO
 * 검측 체크리스트 메인 조회
 * @author softm 
 */
public class TestChkMainDTOOut extends BaseDTO {
	private ArrayList<TestChkMainDTO> data; 
	public TestChkMainDTOOut() {
		super();
	}
	public ArrayList<TestChkMainDTO> getData() {
		return data;
	}

	public void setData(ArrayList<TestChkMainDTO> data) {
		this.data = data;
	}
}