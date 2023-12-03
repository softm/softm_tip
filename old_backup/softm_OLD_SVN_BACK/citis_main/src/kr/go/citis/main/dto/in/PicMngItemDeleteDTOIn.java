package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.PicMngItemDeleteDTO;

/**
 * PicMngItemDeleteDTOIn
 * 사진관리삭제
 * @author softm 
 */
public class PicMngItemDeleteDTOIn extends BaseDTOIn {
	private PicMngItemDeleteDTO data; 
	
	public PicMngItemDeleteDTOIn() {
		super();
	}

	public PicMngItemDeleteDTO getData() {
		return data;
	}

	public void setData(PicMngItemDeleteDTO data) {
		this.data = data;
	}
	
	
}