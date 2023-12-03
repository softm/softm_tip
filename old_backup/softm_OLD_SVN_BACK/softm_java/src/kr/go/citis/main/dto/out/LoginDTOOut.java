package kr.go.citis.main.dto.out;

import kr.go.citis.lib.dto.BaseDTO;
import kr.go.citis.main.dto.LoginDTO;

/**
 * LoginDTO
 * @author softm 
 */
public class LoginDTOOut extends BaseDTO{
//	private ArrayList<CodeDTOData> data; 
	private LoginDTO data; 
	public LoginDTOOut() {
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
