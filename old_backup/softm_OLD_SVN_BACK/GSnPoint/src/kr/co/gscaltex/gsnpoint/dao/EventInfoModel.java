package kr.co.gscaltex.gsnpoint.dao;

import android.graphics.Bitmap;

public class EventInfoModel {
	private String eventCode;
	private String eventName;
	private String siteCode;
	private String ofrSeqno;
	private String Date;
	private Bitmap img;
	private String imgUrl;
	
	public String getImgUrl() {
		return imgUrl;
	}
	public void setImgUrl(String imgUrl) {
		this.imgUrl = imgUrl;
	}
	
	
	public Bitmap getImg() {
		return img;
	}
	public void setImg(Bitmap img) {
		this.img = img;
	}
	
	public String getEventCode() {
		return eventCode;
	}
	public void setEventCode(String eventCode) {
		this.eventCode = eventCode;
	}
	public String getEventName() {
		return eventName;
	}
	public void setEventName(String eventName) {
		this.eventName = eventName;
	}
	//public String getSiteCode() {
	//	return siteCode;
	//}
	//public void setSiteCode(String siteCode) {
	//	this.siteCode = siteCode;
	//}
	//public String getOfrSeqno() {
	//	return ofrSeqno;
	//}
	//public void setOfrSeqno(String ofrSeqno) {
	//	this.ofrSeqno = ofrSeqno;
	//}
	
	public String getDate() {
		return Date;
	}
	public void setDate(String date) {
		Date = date;
	}
	
}
