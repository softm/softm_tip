package kr.go.citis.main.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.CsrBslListDTO;

/**
 * CsrBslListDTOOut
 * 공사기준조회
 * @author softm 
 */
public class CsrBslListDTOOut extends BaseDTO {
	private ArrayList<CsrBslListDTO> data;
	public CsrBslListDTOOut() {
		super();
	}
	public ArrayList<CsrBslListDTO> getData() {
		return data;
	}
	public void setData(ArrayList<CsrBslListDTO> data) {
		this.data = data;
	}
}