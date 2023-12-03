package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.PicMngSaveDTO;

/**
 * PicMngSaveDTOIn
 * 사진관리저장
 * @author softm 
 */
public class PicMngSaveDTOIn extends BaseDTOIn {
	private PicMngSaveDTO data; 
	
	public PicMngSaveDTOIn() {
		super();
	}

	public PicMngSaveDTO getData() {
		return data;
	}

	public void setData(PicMngSaveDTO data) {
		this.data = data;
	}
	
	
}