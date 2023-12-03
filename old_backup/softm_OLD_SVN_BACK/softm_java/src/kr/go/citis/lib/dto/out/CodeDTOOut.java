package kr.go.citis.lib.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.lib.dto.CodeDTO;

/**
 * CodeDTOOut
 * 코드 조회
 * @author softm 
 */
public class CodeDTOOut extends BaseDTO {
	private ArrayList<CodeDTO> data; 
	public CodeDTOOut() {
		super();
	}
	public ArrayList<CodeDTO> getData() {
		return data;
	}

	public void setData(ArrayList<CodeDTO> data) {
		this.data = data;
	}
}