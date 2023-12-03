package kr.go.citis.main.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.DrwListDTO;

/**
 * DrwListDTOOut
 * 도면조회
 * @author softm 
 */
public class DrwListDTOOut extends BaseDTO {
	private ArrayList<DrwListDTO> data;	
	public DrwListDTOOut() {
		super();
	}
	public ArrayList<DrwListDTO> getData() {
		return data;
	}
	public void setData(ArrayList<DrwListDTO> data) {
		this.data = data;
	}
	
}