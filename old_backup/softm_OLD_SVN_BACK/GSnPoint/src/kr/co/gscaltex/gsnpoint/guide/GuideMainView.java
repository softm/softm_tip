package kr.co.gscaltex.gsnpoint.guide;

import java.util.HashMap;

import kr.co.gscaltex.gsnpoint.BaseWebActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.qr.CaptureActivity;
import kr.co.gscaltex.gsnpoint.store.StoreMapView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import android.content.Intent;
import android.os.Bundle;

public class GuideMainView extends BaseWebActivity {
	
	String TAG = "GS";
	
	DefaultApplication mApp ;
	private FileInfo fi = new FileInfo();
	TitleView titleView = null;
	private boolean m_bLogin = false;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.web_viewer);

		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		titleView = new TitleView(this, true, true, R.string.TITLE_TYPE_GUIDE,m_bLogin);
		
		new NewMainMenu(this);
		
		String URL = fi.getSettingInfo(getBaseContext(),FileInfo.GUIDE_URL); // 이용안내 화면 URL
//		String URL = "http://192.168.10.51:8240/renewal/phone/guide/index.jsp"; // 이용안내 화면 URL
		loadUrl(URL);
		
	}

	@Override
	protected void onDestroy() { 
		super.onDestroy(); 
	}

	@Override
	protected void webViewEvent(int what, boolean result, HashMap<String,Object> param) {
		
		//Debug.trace(TAG,"GuideMainView : webViewEvent - "  + what) ;
		mApp = (DefaultApplication)getApplicationContext() ;
		Intent intent;
		switch(what) {
		case 2 : 
			String url = (String) param.get("url");
			
			// 호출 페이지 URL에 따라 타이틀을 변경한다.
			int titleType = getTitleType(url);
			
			if(titleType>0) {
				titleView.setLayout(true, true, titleType, m_bLogin);
			}
			
			break ;
			
		case R.string.TITLE_TYPE_GUIDE_POINT_CARD:
			 intent = new Intent(this, GuidePointCard.class);
			intent.putExtra("login", m_bLogin);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);
			break;
			
		case R.string.TITLE_TYPE_BARCORD:
			 intent = new Intent(this, CaptureActivity.class);
			intent.putExtra("login", m_bLogin);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);
			break;
			
		case R.string.TITLE_TYPE_STORE:
			
			intent = new Intent(this, StoreMapView.class);
			intent.putExtra("login", m_bLogin);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);
			mApp.selectedIndex= 3; //StoreMapView index
			
			finish();
			break;
			
		case R.string.TITLE_TYPE_STORE_REPRESENT:
			
			String lat = (String) param.get("Latitude");
			
			String longi = (String) param.get("Longitude");
			
			//Debug.trace(TAG,"GuideMainView : webViewEvent - lat is "  + lat) ;
			//Debug.trace(TAG,"GuideMainView : webViewEvent - longi is "  + longi) ;
			
			intent = new Intent(this, StoreMapView.class);
			intent.putExtra("login", m_bLogin);
			intent.putExtra("Latitude", lat);
			intent.putExtra("Longitude", longi);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);
			mApp.selectedIndex= 3; //StoreMapView index
			
			finish();
			
			
			break;
			
		}
	}

	private int getTitleType(String url) {
		
		int titleType = -1;
		
		if(url.indexOf("/guide/index.jsp")>0){ // 이용안내
			
			titleType = R.string.TITLE_TYPE_GUIDE;
			
		} else if(url.indexOf("/guide/guide_app.jsp")>0){ // App 사용 가이드
			
			titleType = R.string.TITLE_TYPE_GUIDE_APP;
			
		} else if (url.indexOf("/guide/benefit_list.jsp")>0){ // GS&POINT 혜택가이드
			
			titleType = R.string.TITLE_TYPE_GUIDE_BENEFIT;
			
		} else if (url.indexOf("/guide/faq.jsp")>0){ // FAQ
			
			titleType = R.string.TITLE_TYPE_GUIDE_FAQ;
			
		} else if (url.indexOf("/guide/giftcard01.jsp")>0){ // 상품권 소개
			
			titleType = R.string.TITLE_TYPE_GUIDE_GIFT_CARD01;
			
		} else if (url.indexOf("/guide/uselist01.jsp")>0){ // 상품권 사용처
			
			titleType = R.string.TITLE_TYPE_GUIDE_GIFT_CARD02;
			
		} else if (url.indexOf("/guide/buylist.jsp")>0){ // 상품권 판매처
			
			titleType = R.string.TITLE_TYPE_GUIDE_GIFT_CARD03;
			
		}else if (url.indexOf("/guide/alliance_card_main.jsp")>0){ // 제휴신용카드 소개
			
			titleType = R.string.TITLE_TYPE_GUIDE_ALLIANCE_CARD;
			
		}
		
		return titleType;
	}


}

