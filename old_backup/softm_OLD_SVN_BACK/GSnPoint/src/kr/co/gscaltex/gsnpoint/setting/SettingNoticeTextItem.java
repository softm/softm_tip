package kr.co.gscaltex.gsnpoint.setting;

public class SettingNoticeTextItem {
	
	private String[] mData;
	private boolean mSelectable = true;
	
	public SettingNoticeTextItem(String obj01, String obj02,String obj03,String pk) {
		mData = new String[4];
		mData[0] = obj01;  
		mData[1] = obj02;
		mData[2] = obj03;
		mData[3] = pk;	
	}
	
	public String[] getmData() {
		return mData;
	}
	public void setmData(String[] mData) {
		this.mData = mData;
	}
	public boolean ismSelectable() {
		return mSelectable;
	}
	public void setmSelectable(boolean mSelectable) {
		this.mSelectable = mSelectable;
	}	
}
