package kr.go.citis.main.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.SampleListDTO;

/**
 * SampleListDTO
 * @author softm 
 */
public class SampleListDTOOut extends BaseDTO {
	private ArrayList<SampleListDTO> data; 
	public SampleListDTOOut() {
		super();
	}
	public ArrayList<SampleListDTO> getData() {
		return data;
	}

	public void setData(ArrayList<SampleListDTO> data) {
		this.data = data;
	}
}