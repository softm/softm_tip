package kr.go.citis.main.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.TestChkListDTO;

/**
 * TestChkListDTOOut
 * 검측 체크리스트 목록 조회
 * @author softm 
 */
public class TestChkListDTOOut extends BaseDTO {
	private ArrayList<TestChkListDTO> data; 
	public TestChkListDTOOut() {
		super();
	}
	public ArrayList<TestChkListDTO> getData() {
		return data;
	}

	public void setData(ArrayList<TestChkListDTO> data) {
		this.data = data;
	}
}