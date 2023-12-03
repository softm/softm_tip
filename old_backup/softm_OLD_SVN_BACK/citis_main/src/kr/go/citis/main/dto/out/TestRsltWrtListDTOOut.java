package kr.go.citis.main.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.TestRsltWrtListDTO;

/**
 * TestRsltWrtListDTOOut
 * 검측 결과 등록 조회
 * @author softm 
 */
public class TestRsltWrtListDTOOut extends BaseDTO {
	private ArrayList<TestRsltWrtListDTO> data; 
	public TestRsltWrtListDTOOut() {
		super();
	}
	public ArrayList<TestRsltWrtListDTO> getData() {
		return data;
	}

	public void setData(ArrayList<TestRsltWrtListDTO> data) {
		this.data = data;
	}
}