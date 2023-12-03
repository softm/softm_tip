package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.CarRprtDtlDTO;

/**
 * NcrRprtDtlDTOIn
 * 시정조치 보고서 조회(상세)
 * @author softm 
 */
public class CarRprtDtlDTOIn extends BaseDTOIn {
	private CarRprtDtlDTO data; 
	public CarRprtDtlDTOIn() {
		super();
	}
	public CarRprtDtlDTO getData() {
		return data;
	}
	public void setData(CarRprtDtlDTO data) {
		this.data = data;
	}
}