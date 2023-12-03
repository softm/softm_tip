package kr.co.gscaltex.gsnpoint.dao;

import android.graphics.Bitmap;

public class CouponInfoModel {
	private String couponName;
	private String comCode;
	private String usePrice;
	private Bitmap img;
	private String imgUrl;
	
	public String getImgUrl() {
		return imgUrl;
	}
	public void setImgUrl(String imgUrl) {
		this.imgUrl = imgUrl;
	}
	
	public String getCouponName() {
		return couponName;
	}
	public void setCouponName(String couponName) {
		this.couponName = couponName;
	}
	public String getComCode() {
		return comCode;
	}
	public void setComCode(String comCode) {
		this.comCode = comCode;
	}
	public String getUsePrice() {
		return usePrice;
	}
	public void setUsePrice(String usePrice) {
		this.usePrice = usePrice;
	}
	public Bitmap getImg() {
		return img;
	}
	public void setImg(Bitmap img) {
		this.img = img;
	}
	
	
}
