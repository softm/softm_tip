package kr.co.gscaltex.gsnpoint.dao;

public class StoreInfoModel {
	private String frch_cd;
	private String frch_dtl_cd;
	private String busi_cd;
	private String frch_nm;	
	private String tphn_no;	
	private String cco_cd;	
	private String zip_addr;
	private String dtl_addr;
	private String open_yn;
	private String lat;
	private String longi;
	private String busi_cd_ord;
	
	public String getFrch_cd() {
		return frch_cd;
	}
	public void setFrch_cd(String frch_cd) {
		this.frch_cd = frch_cd;
	}
	public String getFrch_dtl_cd() {
		return frch_dtl_cd;
	}
	public void setFrch_dtl_cd(String frch_dtl_cd) {
		this.frch_dtl_cd = frch_dtl_cd;
	}
	public String getBusi_cd() {
		return busi_cd;
	}
	public void setBusi_cd(String busi_cd) {
		this.busi_cd = busi_cd;
	}
	public String getFrch_nm() {
		return frch_nm;
	}
	public void setFrch_nm(String frch_nm) {
		this.frch_nm = frch_nm;
	}
	public String getTphn_no() {
		if(tphn_no==null){
			return " ";
		}else{
			return tphn_no;
		}
	}
	public void setTphn_no(String tphn_no) {
		this.tphn_no = tphn_no;
	}
	public String getCco_cd() {
		return cco_cd;
	}
	public void setCco_cd(String cco_cd) {
		this.cco_cd = cco_cd;
	}
	public String getZip_addr() {
		return zip_addr;
		/*
		if(zip_addr.length()>13){
			return zip_addr.substring(0, 13)+"...";
		}else{
			return zip_addr;
		}	
		*/	
	}
	public void setZip_addr(String zip_addr) {
		this.zip_addr = zip_addr;
	}
	public String getDtl_addr() {
		if(dtl_addr==null){
			return " ";
		}else{
			return dtl_addr;
		}		
	}
	public void setDtl_addr(String dtl_addr) {
		this.dtl_addr = dtl_addr;
	}
	public String getOpen_yn() {
		return open_yn;
	}
	public void setOpen_yn(String open_yn) {
		this.open_yn = open_yn;
	}
	public String getLat() {
		return lat;
	}
	public void setLat(String lat) {
		this.lat = lat;
	}
	public String getLongi() {
		return longi;
	}
	public void setLongi(String longi) {
		this.longi = longi;
	}

	public String getBusiCdOrd() {
		return busi_cd_ord;
	}

	public void setBusiCdOrd(String busiCdOrd) {
		busi_cd_ord = busiCdOrd;
	}

	public StoreInfoModel copy(){
		StoreInfoModel info = new StoreInfoModel();
		info.frch_cd = frch_cd;
		info.frch_dtl_cd = frch_dtl_cd;
		info.busi_cd = busi_cd;
		info.frch_nm = frch_nm;
		info.tphn_no = tphn_no;
		info.cco_cd = cco_cd;
		info.zip_addr = zip_addr;
		info.dtl_addr = dtl_addr;
		info.open_yn = open_yn;
		info.lat = lat;
		info.longi = longi;
		return info;
	}
}
