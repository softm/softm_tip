package kr.go.citis.main.dto.in;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.BldChkupWrtItemSaveDTO;

/**
 * BldChkupWrtItemSaveDTOIn
 * 체크리스트항목 저장
 * @author softm 
 */
public class BldChkupWrtItemSaveDTOIn extends BaseDTOIn {
	private ArrayList<BldChkupWrtItemSaveDTO> data;  
	public BldChkupWrtItemSaveDTOIn() {
		super();
	}
	public ArrayList<BldChkupWrtItemSaveDTO> getData() {
		return data;
	}
	public void setData(ArrayList<BldChkupWrtItemSaveDTO> data) {
		this.data = data;
	}
	
	
}