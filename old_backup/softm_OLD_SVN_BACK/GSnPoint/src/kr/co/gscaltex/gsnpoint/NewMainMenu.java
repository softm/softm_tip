package kr.co.gscaltex.gsnpoint;

import kr.co.gscaltex.gsnpoint.util.Debug;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.GestureDetector;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.GestureDetector.SimpleOnGestureListener;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageButton;
import android.widget.ViewFlipper;

public class NewMainMenu implements OnClickListener {
	String TAG = "GS" ;
	public static final int TAB_BUTTON_COUNT = 5;
	public static final int[] TAB_BUTTON_RESOURCE_IDS = {
		R.drawable.menu01_on,
		R.drawable.menu02_on,
		R.drawable.menu_point_on,
		R.drawable.menu03_on,
		R.drawable.menu04_on
	};

	private DefaultApplication mApplication;
	private Activity mActivity;
	//private GestureDetector mGestureDetector;

	private ImageButton[] mButtons = new ImageButton[TAB_BUTTON_COUNT];
	
	private boolean m_bLogin = false;
	
	public NewMainMenu(Activity activity) {
		initLayout(activity);
	}

	public NewMainMenu(Activity activity, ViewGroup group) {
		initLayout(activity);
	}

//	public boolean onTouch(View view, MotionEvent event) {
//		return mGestureDetector.onTouchEvent(event);
//	}

	public void onClick(View v) {
		clickEvent(v);
	}
	
	private void clickEvent(View v) {
		if (v.getId() == mApplication.selectedIndex)
			return;

		//Debug.trace(TAG, "clickEvent id:" + v.getId() ) ; 
		Intent intent = null;
		switch (v.getId()) {
			case 0 : {
				intent = new Intent(mActivity, kr.co.gscaltex.gsnpoint.card.CardMainView.class);
				intent.putExtra("card_refresh", true) ;
				break;
			}
			case 1 : {
				intent = new Intent(mActivity, kr.co.gscaltex.gsnpoint.point.Point.class);	
				
				break;
			}
			case 2:{
				intent = new Intent(mActivity, kr.co.gscaltex.gsnpoint.plusapp.PlusAppPopupView.class);	
				intent.putExtra("login", m_bLogin) ;
				intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				mActivity.startActivity(intent);
			
				mApplication.selectedIndex = v.getId();
				return;
				
			}
			case 3 : {				
				intent = new Intent(mActivity, kr.co.gscaltex.gsnpoint.store.StoreMapView.class);
				break;
			}	
			case 4 : {				
				intent = new Intent(mActivity, kr.co.gscaltex.gsnpoint.guide.GuideMainView.class);
				break;
			}	
			default:
				mApplication.selectedIndex=0;
				return;
				//break;
		}
		intent.putExtra("login", m_bLogin) ;
		intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		mActivity.startActivity(intent);
		mActivity.finish() ;
		mApplication.selectedIndex = v.getId();
	}
		
		//mActivity.finish() ;
		//mApplication.selectedIndex = v.getId();
		
/*
		Intent intent = null;
		switch (v.getId()) {
			case 0 : {
				intent = new Intent(mActivity, kr.co.gscaltex.gsnpoint.news.Event.class);
				break;
			}
			case 1 : {
				intent = new Intent(mActivity, kr.co.gscaltex.gsnpoint.card.GSCardMain.class);
				break;
			}
			case 2 : {
				intent = new Intent(mActivity, kr.co.gscaltex.gsnpoint.point.Point.class);
				break;
			}
			case 3 : {
				intent = new Intent(mActivity, kr.co.gscaltex.gsnpoint.map.FranchisesMap.class);
				break;
			}
			case 4 : {
				intent = new Intent(mActivity, kr.co.gscaltex.gsnpoint.card.PartnerCardCategory.class);
				break;
			}
		}
		mActivity.startActivity(intent);
		mActivity.finish() ;
		mApplication.selectedIndex = v.getId();
*/
	
	
	private void initLayout(Activity activity) {
		mApplication = (DefaultApplication)activity.getApplicationContext();
		mActivity = activity;
		//mGestureDetector = new GestureDetector(mGestureListener);
		
		Bundle extras = activity.getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
/*
		mViewFlipper = (ViewFlipper)activity.findViewById(R.id.mainmenu_flipper);
		mViewFlipper.setOnTouchListener(this);
		mViewFlipper.setDisplayedChild(mApplication.viewFlipperChild);
*/
		for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
			mButtons[i] = (ImageButton)activity.findViewById(R.id.tabmenu_button_1+i);
			mButtons[i].setId(i);
			mButtons[i].setOnClickListener(this);
			//mButtons[i].setOnTouchListener(this);
			if (i == mApplication.selectedIndex)
				mButtons[i].setBackgroundResource(TAB_BUTTON_RESOURCE_IDS[i]);
		}
	}
	
	/*
	private SimpleOnGestureListener mGestureListener = new SimpleOnGestureListener() {
		private static final int SWIPE_MIN_DISTANCE = 120;
		private static final int SWIPE_MAX_OFF_PATH = 250;
		private static final int SWIPE_THRESHOLD_VELOCITY = 200;

		@Override
		public boolean onFling(MotionEvent e1, MotionEvent e2, float velocityX, float velocityY) {
			if (Math.abs(e1.getY() - e2.getY()) > SWIPE_MAX_OFF_PATH)
                return false;
			
			mApplication.viewFlipperChild = mViewFlipper.getDisplayedChild();

			return true;
		}
	};
	*/
}
