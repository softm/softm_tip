package kr.co.gscaltex.gsnpoint.card;

import android.graphics.Bitmap;

public class CardProductTextItem {
	
	private String[] mData;
	private Bitmap bt=null;
	private boolean mSelectable = true;
	private String mCode="";
	private String imgUrl="";
	
	//public CardProductTextItem(Bitmap img, String obj00, String obj01, String obj02, String obj03) {
	public CardProductTextItem(String url, String obj00, String obj01, String obj02, String obj03) {
		mData = new String[3];
		
		//bt= img;
		imgUrl=url;
		
		mData[0] = obj00;
		mData[1] = obj01;
		mData[2]=  obj02;
		mCode = obj03;
	}
	
	public String getImgUrl() {
		return imgUrl;
	}

	public void setImgUrl(String imgUrl) {
		this.imgUrl = imgUrl;
	}

	public String getmCode() {
		return mCode;
	}

	public void setmCode(String mCode) {
		this.mCode = mCode;
	}

	public String[] getmData() {
		return mData;
	}
	public void setmData(String[] mData) {
		this.mData = mData;
	}
	
	
	public Bitmap getBt() {
		return bt;
	}

	public void setBt(Bitmap bt) {
		this.bt = bt;
	}

	public boolean ismSelectable() {
		return mSelectable;
	}
	public void setmSelectable(boolean mSelectable) {
		this.mSelectable = mSelectable;
	}	
}
