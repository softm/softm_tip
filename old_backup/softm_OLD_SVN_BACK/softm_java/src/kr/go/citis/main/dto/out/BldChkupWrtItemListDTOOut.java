package kr.go.citis.main.dto.out;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.BldChkupWrtItemListDTO;

/**
 * BldChkupWrtItemListDTOOut
 * 체크리스트항목조회
 * @author softm 
 */
public class BldChkupWrtItemListDTOOut extends BaseDTO {
	private ArrayList<BldChkupWrtItemListDTO> data; 
	public BldChkupWrtItemListDTOOut() {
		super();
	}
	public ArrayList<BldChkupWrtItemListDTO> getData() {
		return data;
	}

	public void setData(ArrayList<BldChkupWrtItemListDTO> data) {
		this.data = data;
	}
}