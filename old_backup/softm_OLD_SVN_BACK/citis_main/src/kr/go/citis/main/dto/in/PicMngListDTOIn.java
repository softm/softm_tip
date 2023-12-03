package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.PicMngListDTO;

/**
 * PicMngListDTOIn
 * 사진관리조회
 * @author softm 
 */
public class PicMngListDTOIn extends BaseDTOIn {
	private PicMngListDTO data; 
	
	public PicMngListDTOIn() {
		super();
	}

	public PicMngListDTO getData() {
		return data;
	}

	public void setData(PicMngListDTO data) {
		this.data = data;
	}
	
	
}