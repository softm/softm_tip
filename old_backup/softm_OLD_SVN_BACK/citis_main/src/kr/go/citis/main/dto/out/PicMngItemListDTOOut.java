package kr.go.citis.main.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.PicMngItemListDTO;

/**
 * PicMngItemListDTOOut
 * 사진관리사진정보조회
 * @author softm 
 */
public class PicMngItemListDTOOut extends BaseDTO {
	private ArrayList<PicMngItemListDTO> data; 
	public PicMngItemListDTOOut() {
		super();
	}
	public ArrayList<PicMngItemListDTO> getData() {
		return data;
	}

	public void setData(ArrayList<PicMngItemListDTO> data) {
		this.data = data;
	}
}