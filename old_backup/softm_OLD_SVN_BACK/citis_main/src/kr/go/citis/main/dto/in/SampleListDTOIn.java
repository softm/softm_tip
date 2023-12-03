package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.SampleListDTO;

/**
 * SampleListDTOIn
 * 검측 체크리스트 메인 조회
 * @author softm 
 */
public class SampleListDTOIn extends BaseDTOIn {
	private SampleListDTO data; 
	
	public SampleListDTOIn() {
		super();
	}

	public SampleListDTO getData() {
		return data;
	}

	public void setData(SampleListDTO data) {
		this.data = data;
	}
	
	
}