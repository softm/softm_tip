package kr.go.citis.main.dto;

/**
 * LoginDTOData
 * @author softm 
 */
public class LoginDTO {
	private String userid;
	private String passwd;
	private String usernm;
	private String siteType;
	public LoginDTO() {
		super();
	}

	public String getUserid() {
		return userid;
	}

	public void setUserid(String userid) {
		this.userid = userid;
	}

	public String getUsernm() {
		return usernm;
	}

	public void setUsernm(String usernm) {
		this.usernm = usernm;
	}

	public String getPasswd() {
		return passwd;
	}

	public void setPasswd(String passwd) {
		this.passwd = passwd;
	}

	public String getSiteType() {
		return siteType;
	}

	public void setSiteType(String siteType) {
		this.siteType = siteType;
	}
	
	
	
}
