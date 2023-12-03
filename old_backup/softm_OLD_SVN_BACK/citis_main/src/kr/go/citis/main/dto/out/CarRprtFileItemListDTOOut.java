package kr.go.citis.main.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.CarRprtFileItemListDTO;
import kr.go.citis.main.dto.CsrBslListDTO;

/**
 * CarRprtFileItemListDTOOut
 * 시정조치 보고서 파일 조회
 * @author softm 
 */
public class CarRprtFileItemListDTOOut extends BaseDTO {
	private ArrayList<CarRprtFileItemListDTO> data;	
	public CarRprtFileItemListDTOOut() {
		super();
	}
	public ArrayList<CarRprtFileItemListDTO> getData() {
		return data;
	}
	public void setData(ArrayList<CarRprtFileItemListDTO> data) {
		this.data = data;
	}
}