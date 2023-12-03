package kr.go.citis.main.dto.out;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.PicMngItemDeleteDTO;

/**
 * PicMngItemDeleteDTOOut
 * 사진관리삭제
 * @author softm 
 */
public class PicMngItemDeleteDTOOut extends BaseDTO {
	private PicMngItemDeleteDTO data; 
	public PicMngItemDeleteDTOOut() {
		super();
	}
	public PicMngItemDeleteDTO getData() {
		return data;
	}
	public void setData(PicMngItemDeleteDTO data) {
		this.data = data;
	}
	
}