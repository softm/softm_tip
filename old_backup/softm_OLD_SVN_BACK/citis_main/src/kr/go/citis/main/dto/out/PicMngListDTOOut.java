package kr.go.citis.main.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.PicMngListDTO;

/**
 * PicMngListDTOOut
 * 사진관리조회
 * @author softm 
 */
public class PicMngListDTOOut extends BaseDTO {
	private ArrayList<PicMngListDTO> data; 
	public PicMngListDTOOut() {
		super();
	}
	public ArrayList<PicMngListDTO> getData() {
		return data;
	}

	public void setData(ArrayList<PicMngListDTO> data) {
		this.data = data;
	}
}