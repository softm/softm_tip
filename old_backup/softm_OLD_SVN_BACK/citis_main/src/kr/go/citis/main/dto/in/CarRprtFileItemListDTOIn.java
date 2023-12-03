package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.CarRprtFileItemListDTO;

/**
 * CarRprtFileItemListDTOIn
 * 시정조치 보고서 파일 조회
 * @author softm 
 */
public class CarRprtFileItemListDTOIn extends BaseDTOIn {
	private CarRprtFileItemListDTO data; 
	public CarRprtFileItemListDTOIn() {
		super();
	}
	public CarRprtFileItemListDTO getData() {
		return data;
	}
	public void setData(CarRprtFileItemListDTO data) {
		this.data = data;
	}
}