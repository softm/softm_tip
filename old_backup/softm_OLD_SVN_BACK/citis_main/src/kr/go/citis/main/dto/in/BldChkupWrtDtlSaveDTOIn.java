package kr.go.citis.main.dto.in;

import java.util.ArrayList;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.BldChkupWrtDtlSaveDTO;

/**
 * BldChkupWrtDtlSaveDTOIn
 * 체크리스트마스터상세 저장
 * @author softm 
 */
public class BldChkupWrtDtlSaveDTOIn extends BaseDTOIn {
	private ArrayList<BldChkupWrtDtlSaveDTO> data; 
	public BldChkupWrtDtlSaveDTOIn() {
		super();
	}
	public ArrayList<BldChkupWrtDtlSaveDTO> getData() {
		return data;
	}

	public void setData(ArrayList<BldChkupWrtDtlSaveDTO> data) {
		this.data = data;
	}
}