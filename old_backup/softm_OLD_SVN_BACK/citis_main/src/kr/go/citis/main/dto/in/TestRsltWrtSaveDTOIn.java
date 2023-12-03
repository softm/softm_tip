package kr.go.citis.main.dto.in;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.BldChkupWrtDtlSaveDTO;
import kr.go.citis.main.dto.TestRsltWrtDtlSaveDTO;
import kr.go.citis.main.dto.TestRsltWrtItemSaveDTO;

/**
 * TestRsltWrtSaveDTOIn
 * 검측 결과 등록 저장
 * @author softm 
 */
public class TestRsltWrtSaveDTOIn extends BaseDTOIn {
	private ArrayList<TestRsltWrtItemSaveDTO> itemData;  
	private BldChkupWrtDtlSaveDTO dtlData;
	
	public TestRsltWrtSaveDTOIn() {
		super();
	}

	public ArrayList<TestRsltWrtItemSaveDTO> getItemData() {
		return itemData;
	}


	public void setItemData(ArrayList<TestRsltWrtItemSaveDTO> itemData) {
		this.itemData = itemData;
	}

	public BldChkupWrtDtlSaveDTO getDtlData() {
		return dtlData;
	}

	public void setDtlData(BldChkupWrtDtlSaveDTO dtlData) {
		this.dtlData = dtlData;
	}


	
}