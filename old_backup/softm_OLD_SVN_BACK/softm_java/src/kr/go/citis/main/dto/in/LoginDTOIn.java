package kr.go.citis.main.dto.in;

import kr.go.citis.lib.dto.BaseDTOIn;
import kr.go.citis.main.dto.LoginDTO;

/**
 * LoginDTO
 * @author softm 
 */
public class LoginDTOIn extends BaseDTOIn {
//	private ArrayList<CodeDTOData> data; 
	private LoginDTO data; 
	public LoginDTOIn() {
		super();
	}
//	public ArrayList<CodeDTOData> getData() {
	public LoginDTO getData() {
		return data;
	}

//	public void setData(ArrayList<CodeDTOData> data) {
	public void setData(LoginDTO data) {
		this.data = data;
	}
}
