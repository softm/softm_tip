package kr.co.gscaltex.gsnpoint;

import java.util.ArrayList;
import java.util.List;

import kr.co.gscaltex.gsnpoint.card.CardCouponListAdapter;
import kr.co.gscaltex.gsnpoint.card.CardEventListAdapter;
import kr.co.gscaltex.gsnpoint.card.CardNoticeListAdapter;
import kr.co.gscaltex.gsnpoint.card.CardShopListAdapter;
import android.app.Application;

public class DefaultApplication extends Application {
	
	String TAG = "GS" ;
	
	public int viewFlipperChild;
	public int selectedIndex;
	
	public List <String> loginInfo  ;
	public int orgLoginFlag ;
	public boolean card_refresh = false ;
	public boolean tabpage_refresh = true ;
	
	public boolean isTabpage_refresh() {
		return tabpage_refresh;
	}

	public void setTabpage_refresh(boolean tabpage_refresh) {
		this.tabpage_refresh = tabpage_refresh;
	}

	public CardNoticeListAdapter  NoticeAdapter = null;
	public CardEventListAdapter EventAdapter = null;
	public CardShopListAdapter ShopAdapter = null;
	public CardCouponListAdapter CouponAdapter = null;
	
	@Override
	public void onCreate() {
		super.onCreate();

		init();
	}

	public void onTerminate() {
		super.onTerminate();
	}

	public CardNoticeListAdapter getNoticeAdapter() {
		return NoticeAdapter;
	}

	public void setNoticeAdapter(CardNoticeListAdapter noticeAdapter) {
		NoticeAdapter = noticeAdapter;
	}

	public CardEventListAdapter getEventAdapter() {
		return EventAdapter;
	}

	public void setEventAdapter(CardEventListAdapter eventAdapter) {
		EventAdapter = eventAdapter;
	}

	public CardShopListAdapter getShopAdapter() {
		return ShopAdapter;
	}

	public void setShopAdapter(CardShopListAdapter shopAdapter) {
		ShopAdapter = shopAdapter;
	}

	public CardCouponListAdapter getCouponAdapter() {
		return CouponAdapter;
	}

	public void setCouponAdapter(CardCouponListAdapter couponAdapter) {
		CouponAdapter = couponAdapter;
	}

	public void init() {
		viewFlipperChild = 0;
		selectedIndex = 0;
		loginInfo = new ArrayList<String>() ;
		orgLoginFlag = 0 ;
		
		setTabpage_refresh(true);
		NoticeAdapter= new CardNoticeListAdapter(this);
		EventAdapter = new CardEventListAdapter(this);
		ShopAdapter = new CardShopListAdapter(this);
		CouponAdapter = new CardCouponListAdapter(this);
	}
	 
 
	//자동로그인 플래그 수집 
	public List <String> getLoginInfo() {
		return loginInfo ;
	}
	
	// 자동로그인해제
	public void setLoginInfo(String id, String passwd, String pointUrl, String openUrl, String key ) {
		loginInfo.add(0,id) ;
		loginInfo.add(1,passwd) ;
		loginInfo.add(2,pointUrl) ;
		loginInfo.add(3,openUrl) ;
		loginInfo.add(4,key) ; 
		
		setCardRefresh(true) ;
		setTabpage_refresh(true);
		//Debug.trace(TAG,"setLoginInfo:" + id + "/" + passwd + "/" + pointUrl + "/" + openUrl + "/" + key) ;
	}
	
	
	public void setCardRefresh(boolean flag) {
		card_refresh = flag ;
	}
	
	public boolean getCardRefresh() {
		return card_refresh  ;
	}
}
