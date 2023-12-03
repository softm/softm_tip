package kr.go.citis.main.dto.out;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.CarRprtDtlDTO;

/**
 * CarRprtDtlDTOOut
 * 시정조치 보고서 조회(상세)
 * @author softm 
 */
public class CarRprtDtlDTOOut extends BaseDTO {
	private CarRprtDtlDTO data; 
	public CarRprtDtlDTOOut() {
		super();
	}
	public CarRprtDtlDTO getData() {
		return data;
	}
	public void setData(CarRprtDtlDTO data) {
		this.data = data;
	}

	
}