package kr.co.gscaltex.gsnpoint.point;

public class MyPointListTextItem {
	
	private String[] mData;
	private boolean mSelectable = true;
	
	public MyPointListTextItem(String obj01, String obj02,String obj03,String obj04, String obj05,
			String obj06,String obj07,String obj08) {
		
		mData = new String[8];
		mData[0] = obj01;  
		mData[1] = obj02;
		mData[2] = obj03;
		mData[3] = obj04;
		mData[4] = obj05;
		mData[5] = obj06;
		mData[6] = obj07;
		mData[7] = obj08;
			
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
