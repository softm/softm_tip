package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.DrwListDTO;

/**
 * DrwListDTOIn
 * 도면조회
 * @author softm 
 */
public class DrwListDTOIn extends BaseDTOIn {
	private DrwListDTO data; 
	public DrwListDTOIn() {
		super();
	}
	public DrwListDTO getData() {
		return data;
	}
	public void setData(DrwListDTO data) {
		this.data = data;
	}
}