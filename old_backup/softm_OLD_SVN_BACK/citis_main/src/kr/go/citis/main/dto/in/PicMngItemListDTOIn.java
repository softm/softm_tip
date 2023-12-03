package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.PicMngItemListDTO;

/**
 * PicMngItemListDTOIn
 * 사진관리사진정보조회
 * @author softm 
 */
public class PicMngItemListDTOIn extends BaseDTOIn {
	private PicMngItemListDTO data; 
	
	public PicMngItemListDTOIn() {
		super();
	}

	public PicMngItemListDTO getData() {
		return data;
	}

	public void setData(PicMngItemListDTO data) {
		this.data = data;
	}
	
	
}