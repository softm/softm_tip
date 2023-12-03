package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.BldChkupWrtDupChkDTO;

/**
 * BldChkupWrtDupChkDTOIn
 * 검측마스터체크리스트 유무조회(신규작성시 세부공종, 점검일자에대한 중복확인 시 "완료"버튼 처리에서만 체크되게.)
 * @author softm 
 */
public class BldChkupWrtDupChkDTOIn extends BaseDTOIn {
	private BldChkupWrtDupChkDTO data; 
	public BldChkupWrtDupChkDTOIn() {
		super();
	}
	public BldChkupWrtDupChkDTO getData() {
		return data;
	}
	public void setData(BldChkupWrtDupChkDTO data) {
		this.data = data;
	}
	
	
}