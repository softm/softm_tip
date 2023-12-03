package kr.go.citis.lib.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.lib.dto.CodeDTO;

/**
 * CodeDTOIn
 * 코드 조회
 * @author softm 
 */
public class CodeDTOIn extends BaseDTOIn {
	private CodeDTO data; 
	
	public CodeDTOIn() {
		super();
	}

	public CodeDTO getData() {
		return data;
	}

	public void setData(CodeDTO data) {
		this.data = data;
	}
	
	
}