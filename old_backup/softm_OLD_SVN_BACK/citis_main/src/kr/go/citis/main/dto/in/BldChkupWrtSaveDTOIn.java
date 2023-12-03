package kr.go.citis.main.dto.in;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.BldChkupWrtDtlSaveDTO;
import kr.go.citis.main.dto.BldChkupWrtItemSaveDTO;

/**
 * BldChkupWrtSaveDTOIn
 * 체크리스트항목 저장
 * 체크리스트마스터상세 저장
 * 일괄저장.
 * @author softm 
 */
public class BldChkupWrtSaveDTOIn extends BaseDTOIn {
	private ArrayList<BldChkupWrtItemSaveDTO> itemData;  
	private BldChkupWrtDtlSaveDTO dtlData;  
	   
	public BldChkupWrtSaveDTOIn() {
		super();
	}

	public ArrayList<BldChkupWrtItemSaveDTO> getItemData() {
		return itemData;
	}

	public void setItemData(ArrayList<BldChkupWrtItemSaveDTO> itemData) {
		this.itemData = itemData;
	}

	public BldChkupWrtDtlSaveDTO getDtlData() {
		return dtlData;
	}

	public void setDtlData(BldChkupWrtDtlSaveDTO dtlData) {
		this.dtlData = dtlData;
	}
}