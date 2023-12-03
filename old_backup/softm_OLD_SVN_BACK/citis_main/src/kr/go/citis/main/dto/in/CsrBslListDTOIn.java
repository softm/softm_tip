package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.CsrBslListDTO;

/**
 * CsrBslListDTOIn
 * 공사기준조회
 * @author softm 
 */
public class CsrBslListDTOIn extends BaseDTOIn {
	private CsrBslListDTO data; 
	public CsrBslListDTOIn() {
		super();
	}
	public CsrBslListDTO getData() {
		return data;
	}
	public void setData(CsrBslListDTO data) {
		this.data = data;
	}
}