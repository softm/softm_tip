package kr.co.gscaltex.gsnpoint.util;

import java.util.ArrayList;


import android.app.Activity;
import android.util.Log;


public class GSActivityManager {
	private final String TAG = "GSActivityManager";
	private Object mLockObject = new Object();
	private GSActivityManager(){
		
	}
	private static GSActivityManager ACTIVTY_MGR = null;
	
	public static GSActivityManager getActivityManager(){
		if( GSActivityManager.ACTIVTY_MGR == null ){
			ACTIVTY_MGR = new GSActivityManager();
		}
		
		return ACTIVTY_MGR;
	}
	
	private ArrayList<Activity> mActivityList = new ArrayList<Activity>();
	
	public void addCreateActivity(Activity activity){
		synchronized (mLockObject) {
			mActivityList.add(activity);
			//Debug.trace(TAG, "mActivityList : %d" + String.valueOf(mActivityList.size()));
		}
	}
	
	public void deleteCreateActivity(Activity activity){
		synchronized (mLockObject) {
			mActivityList.remove(activity);
			//Debug.trace(TAG, "deleteCreateActivity : %d" + String.valueOf(mActivityList.size()));
		}
	}
	
	public void finishAllActivity(Activity activity){
		synchronized (mLockObject) {
			try{
				final int size = mActivityList.size();
				//Debug.trace(TAG, "finishAllActivity : %d" + String.valueOf(size));
				for( int i = size-1; i >= 0; i--){
					Activity a = mActivityList.get(i);
					if( a instanceof Activity ){
						//Debug.trace(TAG, "finishAllActivity : deleted");
						a.finish();
					}
				}
				
				//Debug.trace(TAG, "complete finishAllActivity : %d" + String.valueOf(mActivityList.size()));
				mActivityList.clear();
			}catch(Exception ex){
				//Debug.trace(TAG, "Exception : " + ex.getMessage());
			}finally{
				
			}
		}
	}
}
