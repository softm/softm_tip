package kr.co.gscaltex.gsnpoint.card;

import java.io.BufferedReader;
import java.io.ByteArrayInputStream;
import java.io.FilterInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URL;
import java.net.URLEncoder;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.dao.CouponInfoModel;
import kr.co.gscaltex.gsnpoint.dao.EventInfoModel;
import kr.co.gscaltex.gsnpoint.dao.ShopInfoModel;
import kr.co.gscaltex.gsnpoint.plusapp.PlusAppPopupView;
import kr.co.gscaltex.gsnpoint.setting.SettingNoticeDetailView;
import kr.co.gscaltex.gsnpoint.setting.SettingNoticeTextItem;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.Util;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.CoreProtocolPNames;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.GestureDetector;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AbsListView;
import android.widget.AdapterView;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.Toast;

public class CardTabpageView implements OnClickListener {
	
	private String LOG_TAG = "CardTabpageView";
	DefaultApplication mApp ;
	private Activity activity;
	
	private String URL_NOTICE = Util.DATA_CONNECT;
	private String URL = Util.DATA_CONNECT_CARDTAB;
	private int nSelectTab = 0;
	private String xml_string = "";
	
	private List<NameValuePair> nameValuePairs;	
	protected String result_tag="";
	protected String error="";
	
	public static final int TAB_BUTTON_COUNT = 4;
	public static final int[] TAB_BUTTON_OFF_RESOURCE_IDS = {
		R.drawable.tab_card01_off,
		R.drawable.tab_card02_off,
		R.drawable.tab_card03_off,
		R.drawable.tab_card04_off
	};
	public static final int[] TAB_BUTTON_ON_RESOURCE_IDS = {
		R.drawable.tab_card01_on,
		R.drawable.tab_card02_on,
		R.drawable.tab_card03_on,
		R.drawable.tab_card04_on
	};

	private ImageButton[] mButtons = new ImageButton[TAB_BUTTON_COUNT];
	private ListView mListview= null;
	private CardNoticeListAdapter  mNoticeAdapter = null;
	private CardEventListAdapter mEventAdapter = null;
	private CardShopListAdapter mShopAdapter = null;
	private CardCouponListAdapter mCouponAdapter = null;
	
	private EventInfoModel event_info = new EventInfoModel();
	ArrayList<EventInfoModel> event_list = new ArrayList<EventInfoModel>();
	
	private CouponInfoModel coupon_info = new CouponInfoModel();
	ArrayList<CouponInfoModel> coupon_list = new ArrayList<CouponInfoModel>();
	
	private ShopInfoModel shop_info = new ShopInfoModel();
	ArrayList<ShopInfoModel> shop_list = new ArrayList<ShopInfoModel>();
	
	private DefaultApplication mApplication;
	private Activity mActivity;
	private GestureDetector mGestureDetector;
		
	private Boolean bFirst=true;
	
	private FileInfo fi = new FileInfo();
	private boolean bEnd;
	private boolean mlogin;
	
	
	public CardTabpageView(Activity activity, Boolean login) {
		this.activity = activity;
		this.mlogin= login;
		initLayout(activity);
	}
	
	
	private void initLayout(Activity activity) {
		
		mApp = ((DefaultApplication)activity.getApplicationContext()) ;
		
		LayoutInflater layout = activity.getLayoutInflater();
		View view = layout.inflate(R.layout.cardtabpage, null);

		mApplication = (DefaultApplication)activity.getApplicationContext();
		mActivity = activity;

		for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
			mButtons[i] = (ImageButton)activity.findViewById(R.id.cardTab01+i);
			mButtons[i].setId(i);
			mButtons[i].setOnClickListener(this);
		}

		nSelectTab= 3;
		setTabpageIndex();
		
		mListview = (ListView)activity.findViewById(R.id.cardlist);		
		mNoticeAdapter= new CardNoticeListAdapter(mActivity);
		mEventAdapter = new CardEventListAdapter(mActivity);
		mShopAdapter = new CardShopListAdapter(mActivity);
		mCouponAdapter = new CardCouponListAdapter(mActivity);
				
		mListview.setAdapter(mNoticeAdapter);
		mListview.setOnItemClickListener(mItemClickListener);
		mListview.setOnScrollListener(mScrollListener);
		mListview.invalidate();
		
		mNoticeAdapter.setPage(0);
		/*
		mNoticeAdapter= mApp.getNoticeAdapter();
		mEventAdapter = mApp.getEventAdapter();
		mCouponAdapter = mApp.getCouponAdapter();
		mShopAdapter = mApp.getShopAdapter();
		mListview.setAdapter(mNoticeAdapter);
		*/
		if(mApp.getCardRefresh()) {
			getNoiceList();
		}else{
			if(mApp.isTabpage_refresh()){
				getNoiceList();
				mApp.setTabpage_refresh(false);
			}else{
				
				bFirst=false;
				
				mNoticeAdapter= mApp.getNoticeAdapter();
				mEventAdapter = mApp.getEventAdapter();
				mCouponAdapter = mApp.getCouponAdapter();
				mShopAdapter = mApp.getShopAdapter();
				
				mListview.setAdapter(mNoticeAdapter);
				mListview.invalidate();
			}
		}
	}
	
	private AdapterView.OnItemClickListener mItemClickListener = new AdapterView.OnItemClickListener(){
		SettingNoticeTextItem mNoticeTemp= null;	
		CardProductTextItem mProductTemp = null;
		
		
		
		Intent intent;
		public void onItemClick(android.widget.AdapterView<?> arg0, View arg1, int arg2, long arg3) {	
				
			//Debug.trace("test", "bEnd is .."+ bEnd);
			//Debug.trace("test", "nSelectTab is .."+ nSelectTab);
			
			if(nSelectTab==3){
				intent = new Intent(mActivity, SettingNoticeDetailView.class);	
				mNoticeTemp= (SettingNoticeTextItem)mNoticeAdapter.getItem(arg2);			
				intent.putExtra("PK", mNoticeTemp.getmData()[3]);
				intent.putExtra("login", mlogin);
				intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				mActivity.startActivity(intent);
			}else{	
				String complete = fi.getSettingInfo(mActivity, FileInfo.TABPAGE_COMPLETE);
				if(complete==null||complete.equals("")){		
					bEnd = false;
				}else{
					bEnd = true;
				}
				//Debug.trace("test", "bEnd is .."+ bEnd);
				if(bEnd){
					
					intent = new Intent(mActivity, PlusAppPopupView.class);	
					if(nSelectTab==0){
						if(mEventAdapter.getCount()==0)
							return;
						
						mProductTemp= (CardProductTextItem)mEventAdapter.getItem(arg2);
						intent.putExtra("cate", "1");				
					}else if(nSelectTab==1){
						if(mShopAdapter.getCount()==0)
							return;	
						
						mProductTemp= (CardProductTextItem)mShopAdapter.getItem(arg2);
						intent.putExtra("cate", "2");					
					}else if(nSelectTab==2){
						if(mCouponAdapter.getCount()==0)
							return;
						
						mProductTemp= (CardProductTextItem)mCouponAdapter.getItem(arg2);
						intent.putExtra("cate", "3");
					}
					intent.putExtra("code", mProductTemp.getmCode());
					intent.putExtra("login", mlogin);
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
					mActivity.startActivity(intent);
				}
			}
		};
	};
	
	private AbsListView.OnScrollListener mScrollListener = new AbsListView.OnScrollListener() {
		
		public void onScrollStateChanged(AbsListView view, int scrollState) {
			// TODO Auto-generated method stub
			
		}
		public void onScroll(AbsListView view, int firstVisibleItem,
				int visibleItemCount, int totalItemCount) {
			if(nSelectTab==3){
				if( totalItemCount > 0 && mNoticeAdapter.isProcessing() == false){
					if((firstVisibleItem+visibleItemCount)==totalItemCount && mNoticeAdapter.isReadAll() == false) {
						getNoiceList();		
					}
			    }
			}
		}
	};
	private void setTabpageIndex() {
		for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
			mButtons[i].setBackgroundResource(TAB_BUTTON_OFF_RESOURCE_IDS[i]);
		}
		
		mButtons[nSelectTab].setBackgroundResource(TAB_BUTTON_ON_RESOURCE_IDS[nSelectTab]);
	}
	
	public void onClick(View v) {
		clickEvent(v);
	}
	
	private void clickEvent(View v) {

		nSelectTab = v.getId();
		setTabpageIndex();

		String complete = fi.getSettingInfo(mActivity, FileInfo.TABPAGE_COMPLETE);
		if(complete==null||complete.equals("")){		
			bEnd = false;
		}else{
			bEnd = true;
		}
		
		//Debug.trace("test", "nSelectTab is.."+nSelectTab +"bEnd is.. "+bEnd);
		switch (nSelectTab) {
		
			case 0 : {	
				//if(!mEventAdapter.isProcessing()){			
					//if(mCouponAdapter.isReadAll()){
				
					if(bEnd){
						mEventAdapter = mApp.getEventAdapter();
						mListview.setAdapter(mApp.getEventAdapter());		
						mListview.invalidate();	
					}
				break;
			}
			case 1 : {
				//if(!mShopAdapter.isProcessing()){
					//if(mCouponAdapter.isReadAll()){
				if(bEnd){
				mShopAdapter = mApp.getShopAdapter();
						mListview.setAdapter(mApp.getShopAdapter());
				//	}else{
				//		mListview.setAdapter(mShopAdapter);
				//	}
					
					mListview.invalidate();		
				}
				break;
			}
			case 2 : {
				//if(!mCouponAdapter.isProcessing()){
					//mCouponAdapter = mApp.getCouponAdapter();
					//if(mCouponAdapter.isReadAll()){
				if(bEnd){
				mCouponAdapter = mApp.getCouponAdapter();
						mListview.setAdapter(mApp.getCouponAdapter());
				//	}else{
				//		mListview.setAdapter(mCouponAdapter);
				//	}
					
					mListview.invalidate();		
				}
				break;
			}
			
			case 3 : {
				mNoticeAdapter= mApp.getNoticeAdapter();
				mListview.setAdapter(mNoticeAdapter);
				mListview.invalidate();		
				break;
			}
		}
	}
	
	private void getProductInfo(){
			
		fi.setSettingInfo(mActivity, "", FileInfo.TABPAGE_COMPLETE);
		mCouponAdapter.startProcessing();
		mShopAdapter.startProcessing();
		mEventAdapter.startProcessing();
		
		showCenterProgress();
		Thread r = new Thread(new Runnable() {
			public void run() {
				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				params.add(new BasicNameValuePair("process_code", "mainProductInfo"));
				String inputXML = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>"
						         + "<GetMainProductGSC xmlns=\"http://sposa.ibm.com/gsn\">"
						         + "<sitecode>GSNAPP</sitecode>"
						         + "<muid></muid>"
						         + "</GetMainProductGSC>";
				params.add(new BasicNameValuePair("inputXML", inputXML));
					
				setParams(params);
				
				loadUrl(R.string.tmp_menu4, URL, "" ) ;
			}
		});
		r.start();
		
	}
	
	
	private void getNoiceList() {
		//if( mCurrentAdapter.isReadAll() || mCurrentAdapter.isProcessing() )
		//	return;
		
		//mNoticeAdapter.clearItem();
		showCenterProgress();
		
		mNoticeAdapter.startProcessing();
		mNoticeAdapter.setNextPage();
				
		Thread r = new Thread(new Runnable() {
			public void run() {
				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				params.add(new BasicNameValuePair("process_code", "noticeList"));
				params.add(new BasicNameValuePair("page", String.valueOf(mNoticeAdapter.getPage())));
								
				setParams(params);
				
				loadUrl(R.string.notice_name, URL_NOTICE, "" ) ;
			}
		});
		r.start();
	}
	
	protected void httpResult(int what, boolean result, String kind){
		switch(what) {
		case R.string.notice_name :
			setNoticeList( what,  result,  kind);
			break;
			
		case R.string.tmp_menu4:
			setProductList(what,  result,  kind);
			//new ProductListLoader().execute(result);
			break;
		}
	}
	
	private void setProductList(int what, boolean result, String kind){
		
		final boolean NewResult = result ;
		Thread r = new Thread(new Runnable() {
			public void run() {
		//final boolean NewResult = result ;
		
		if(NewResult){			
			String str = getString();
			str = str.trim();

			try {
				DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
				DocumentBuilder builder = factory.newDocumentBuilder();
				InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
				Document doc = builder.parse(istream);

				Element order = doc.getDocumentElement();
							
						/*이벤트 item 작업*/
							
						//mEventAdapter.clearItem();
						
						NodeList event_gsnevtcds = order.getElementsByTagName("GSNevtCd");
						NodeList event_evtcds = order.getElementsByTagName("evtCd");
						NodeList event_evtNms = order.getElementsByTagName("evtNm");
						NodeList event_imgurls = order.getElementsByTagName("img_bans");
						NodeList event_dates = order.getElementsByTagName("entryDate");
						
						if( event_gsnevtcds.getLength() > 0)
						{
							for(int i = 0; i < event_gsnevtcds.getLength();i++ )
							{			
								Node event_gsnevtcd = event_gsnevtcds.item(i);
								Node event_evtNm = event_evtNms.item(i);
								Node event_imgurl = event_imgurls.item(i);	
								Node event_date = event_dates.item(i);	
								
								if(event_gsnevtcd!=null && event_gsnevtcd.getFirstChild()!=null)
									event_info.setEventCode(event_gsnevtcd.getFirstChild().getNodeValue());								
								if(event_evtNm!=null && event_evtNm.getFirstChild()!=null)
									event_info.setEventName(event_evtNm.getFirstChild().getNodeValue());
								if(event_imgurl!=null && event_imgurl.getFirstChild()!=null)
									//event_info.setImg(getBitmapFromUrl(event_imgurl.getFirstChild().getNodeValue()));	
									event_info.setImgUrl(event_imgurl.getFirstChild().getNodeValue());	
								if(event_date!=null && event_date.getFirstChild()!=null)
									event_info.setDate(event_date.getFirstChild().getNodeValue());	
								
								//event_list.add(event_info);
								//mEventAdapter.addItem(new CardProductTextItem(event_info.getImg(),event_info.getEventName(),
								mEventAdapter.addItem(new CardProductTextItem(event_info.getImgUrl(),event_info.getEventName(),
										event_info.getDate(),"", event_info.getEventCode()));
							}						
						}
						
						if( event_evtcds.getLength() > 0)
						{
							for(int i = event_gsnevtcds.getLength(); i < (event_gsnevtcds.getLength()+event_evtcds.getLength());i++ )
							{			
								Node event_nevtcd = event_evtcds.item(i-event_gsnevtcds.getLength());
								Node event_evtNm = event_evtNms.item(i);	
								Node event_imgurl = event_imgurls.item(i);	
								Node event_date = event_dates.item(i);	
								
								if(event_nevtcd!=null && event_nevtcd.getFirstChild()!=null)
									event_info.setEventCode(event_nevtcd.getFirstChild().getNodeValue());								
								if(event_evtNm!=null && event_evtNm.getFirstChild()!=null)
									event_info.setEventName(event_evtNm.getFirstChild().getNodeValue());
								if(event_imgurl!=null && event_imgurl.getFirstChild()!=null)
									//event_info.setImg(getBitmapFromUrl(event_imgurl.getFirstChild().getNodeValue()));	
									event_info.setImgUrl(event_imgurl.getFirstChild().getNodeValue());	
								if(event_date!=null && event_date.getFirstChild()!=null)
									event_info.setDate(event_date.getFirstChild().getNodeValue());	
								
								//event_list.add(event_info);
								//mEventAdapter.addItem(new CardProductTextItem(event_info.getImg(),event_info.getEventName(),
								mEventAdapter.addItem(new CardProductTextItem(event_info.getImgUrl(),event_info.getEventName(),
										event_info.getDate(),"", event_info.getEventCode()));
							}						
						}
						
						//mEventAdapter.notifyDataSetChanged();
						mEventAdapter.endProcessing();
						mApp.setEventAdapter(mEventAdapter);
						
	/* 쇼핑 item 작업*/
						
						NodeList shop_names = order.getElementsByTagName("Mname");
						NodeList shop_codes = order.getElementsByTagName("num");	
						NodeList shop_fieldprices = order.getElementsByTagName("Fieldprice");	
						NodeList shop_mprices = order.getElementsByTagName("Mprice");	
						NodeList shop_imgurls = order.getElementsByTagName("IMG_LIST");
						
						
						if( shop_codes.getLength() > 0)
						{
							//mShopAdapter.clearItem();
							for(int i=0 ; i < shop_codes.getLength();i++ )
							{			
								Node shop_name = shop_names.item(i);
								Node shop_code = shop_codes.item(i);			
								Node shop_fieldprice = shop_fieldprices.item(i);
								Node shop_mprice = shop_mprices.item(i);
								Node shop_imgurl = shop_imgurls.item(i);		
															
								if(shop_name!=null && shop_name.getFirstChild()!=null)
									shop_info.setShopName(shop_name.getFirstChild().getNodeValue());	
								if(shop_code!=null && shop_code.getFirstChild()!=null)
									shop_info.setShopNum(shop_code.getFirstChild().getNodeValue());
								if(shop_fieldprice!=null && shop_fieldprice.getFirstChild()!=null)
									shop_info.setFieldPrice(shop_fieldprice.getFirstChild().getNodeValue());
								if(shop_mprice!=null && shop_mprice.getFirstChild()!=null)
									shop_info.setmPrice(shop_mprice.getFirstChild().getNodeValue());
								if(shop_imgurl!=null && shop_imgurl.getFirstChild()!=null)
									//shop_info.setImg(getBitmapFromUrl(shop_imgurl.getFirstChild().getNodeValue()));	
									shop_info.setImgUrl(shop_imgurl.getFirstChild().getNodeValue());	
															
								//shop_list.add(shop_info);
								//mShopAdapter.addItem(new CardProductTextItem(shop_info.getImg(),shop_info.getShopName(),
								mShopAdapter.addItem(new CardProductTextItem(shop_info.getImgUrl(),shop_info.getShopName(),
										makeStringComma(shop_info.getFieldPrice()),makeStringComma(shop_info.getmPrice()), shop_info.getShopNum()));
							}						
							//mShopAdapter.notifyDataSetChanged();
							mShopAdapter.endProcessing();
							mApp.setShopAdapter(mShopAdapter);
						}	
						
						/*쿠폰 item 작업*/				
						NodeList cp_names = order.getElementsByTagName("CouponName");
						NodeList cp_codes = order.getElementsByTagName("MenuCode");	
						NodeList cp_prices = order.getElementsByTagName("UsePrice");	
						NodeList cp_imgurls = order.getElementsByTagName("CouponDetImg");
									
						if( cp_names.getLength() > 0)
						{
							//mCouponAdapter.clearItem();
							for(int i=0 ; i < cp_names.getLength();i++ )
							{			
								Node cp_name = cp_names.item(i);
								Node cp_code = cp_codes.item(i);			
								Node cp_price = cp_prices.item(i);
								Node cp_imgurl = cp_imgurls.item(i);		
															
								if(cp_name!=null && cp_name.getFirstChild()!=null)
									coupon_info.setCouponName(cp_name.getFirstChild().getNodeValue());	
								if(cp_code!=null && cp_code.getFirstChild()!=null)
									coupon_info.setComCode(cp_code.getFirstChild().getNodeValue());
								if(cp_price!=null && cp_price.getFirstChild()!=null)
									coupon_info.setUsePrice(cp_price.getFirstChild().getNodeValue());	
								if(cp_imgurl!=null && cp_imgurl.getFirstChild()!=null)
									//coupon_info.setImg(getBitmapFromUrl(cp_imgurl.getFirstChild().getNodeValue()));	
									coupon_info.setImgUrl(cp_imgurl.getFirstChild().getNodeValue());
								
								
								//coupon_list.add(coupon_info);
								//mCouponAdapter.addItem(new CardProductTextItem(coupon_info.getImg(),coupon_info.getCouponName(),
								mCouponAdapter.addItem(new CardProductTextItem(coupon_info.getImgUrl(),coupon_info.getCouponName(),
										makeStringComma(coupon_info.getUsePrice()),"",coupon_info.getComCode()));
							}						
							//mCouponAdapter.notifyDataSetChanged();
							mCouponAdapter.endProcessing();
							mApp.setCouponAdapter(mCouponAdapter);
						}
						
					
			}
			catch (Exception e) {
				e.printStackTrace();
			}
			fi.setSettingInfo(mActivity, "1", FileInfo.TABPAGE_COMPLETE);
			handler.post(SetProductList);
		}
		else{
			//Toast.makeText(mActivity, "에러", Toast.LENGTH_SHORT).show();
	    }			
			}
		});
		r.start();
	}
	
	
	private void setNoticeList(int what, boolean result, String kind){
		//boolean NewResult = result ;
		if(result){			
			String str = getString();
			str = str.trim();

			try {
				DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
				DocumentBuilder builder = factory.newDocumentBuilder();
				InputStream istream = new ByteArrayInputStream(str.getBytes("UTF-8"));
				Document doc = builder.parse(istream);
				
				Element order = doc.getDocumentElement();

				NodeList result_items = order.getElementsByTagName("result");
				Node result_item = result_items.item(0);
				Node result_text = result_item.getFirstChild();
								
				NodeList error_items = order.getElementsByTagName("err");
				Node error_item;
				Node error_text=null;
				
				result_tag = result_text.getNodeValue();
				if(result_tag.equals(Util.SERVER_ALERT_STATUS)){
					handler.post(viewToastRunnable);
				//	finish();
				}else if(result_tag.equals(Util.SERVER_GO_STATUS)){					
					//goErrorUrl();						
					mNoticeAdapter.setReadAll(false);
					mNoticeAdapter.setPrevPage();
				}else if(result_tag.equals("0")){
					error_item = error_items.item(0);
					error_text = error_item.getFirstChild();
					String msg;
					
					if( error_text.getNodeValue() == null ){
						msg = Util.NOT_FOUND_RESULT;		
					}else{
						msg = error_text.getNodeValue();
					}								
					mNoticeAdapter.setReadAll(true);						
				}else if(result_tag.equals("1")){
					
					NodeList pk_items = order.getElementsByTagName("pk");
					NodeList date_items = order.getElementsByTagName("date");
					NodeList title_items = order.getElementsByTagName("title");										
					
					if( pk_items.getLength() > 0)
					{
						for(int i = 0; i < pk_items.getLength();i++ )
						{						
							Node pk_item = pk_items.item(i);
							Node date_item = date_items.item(i);
							Node title_item = title_items.item(i);														
							String PK = pk_item.getFirstChild().getNodeValue();
							String Date = date_item.getFirstChild().getNodeValue();
							String Title = title_item.getFirstChild().getNodeValue();						
					
							mNoticeAdapter.addItem(new SettingNoticeTextItem(String.valueOf((i+1)+(mNoticeAdapter.getPage()-1)*5),
															Date ,Title , PK));
						}						
						mNoticeAdapter.notifyDataSetChanged();	
						mApp.setNoticeAdapter(mNoticeAdapter);
					}
					
				}
			}
			catch (Exception e) {
				e.printStackTrace();
			}			
		}
		else{
			//Toast.makeText(mActivity, "에러", Toast.LENGTH_SHORT).show();
	    }		
		hideCenterProgress();
		if(bFirst){
			handler.post(getProductList);
			bFirst = false;
		}
		
		mNoticeAdapter.endProcessing();
	}
	
	
	private Runnable getProductList = new Runnable(){
		
		public void run() {
			getProductInfo();
		}		
	};
	
	private Runnable SetProductList = new Runnable(){
		
		public void run() {
			
			if(nSelectTab==0){
				mEventAdapter = mApp.getEventAdapter();
				mListview.setAdapter(mEventAdapter);
				//mListview.invalidate();				
			}else if(nSelectTab==1){
				mShopAdapter= mApp.getShopAdapter();
				mListview.setAdapter(mShopAdapter);
				//mListview.invalidate();				
			}else if(nSelectTab==2){
				mCouponAdapter = mApp.getCouponAdapter();
				mListview.setAdapter(mCouponAdapter);
				//mListview.invalidate();				
			}else if(nSelectTab==3){
				mNoticeAdapter = mApp.getNoticeAdapter();
				mListview.setAdapter(mNoticeAdapter);
			}
			mCouponAdapter.setReadAll(true);
			hideCenterProgress();
		}		
	};
	
	protected Bitmap getBitmapFromUrl(String url){
		Bitmap bt=null;
			
		try{
			InputStream is = new URL(url).openStream();	
			//imgs.add(BitmapFactory.decodeStream(new FlushedInputStream(is)));	
			bt= BitmapFactory.decodeStream(new FlushedInputStream(is));
			is.close();			
		}catch (IOException e){
			;
		}	
		
		if(bt==null){	
			//Debug.trace("yksong", "bt image is null");
		}else{
			//Debug.trace("yksong", "bt image is OK");
		}
		return bt;
	}
	
	static class FlushedInputStream extends FilterInputStream{

		protected FlushedInputStream(InputStream in) {
			super(in);
			// TODO Auto-generated constructor stub
		}
		
		public long skip(long n) throws IOException {
			long totalByteSkipped = 0L;
			while (totalByteSkipped<n){
				long bytesSkipped = in.skip(n-totalByteSkipped);
				if(bytesSkipped == 0L){
					int b = read();
					if (b<0){
						break;
					}else {
						bytesSkipped = 1;
					}
				}
				totalByteSkipped += bytesSkipped;
			}
			return totalByteSkipped;
		}
	}
	
	protected void setParams(List<NameValuePair> params){
		this.nameValuePairs=params;
	}
	protected String getString() {
		return xml_string;
	}
	protected Runnable viewToastRunnable = new Runnable(){
		public void run() {
			viewToast();
		}		
	};
	private void viewToast(){
		Toast t = Toast.makeText(mActivity, error, Toast.LENGTH_SHORT); 
		t.show();
	}
	protected void loadUrl(final int arg1, final String URL, final String kind ){
		 
		new Thread(new Runnable() {
		
			
			public void run() {
				boolean result = false;
				HttpClient httpclient = new DefaultHttpClient();
				httpclient.getParams().setParameter("http.socket.timeout", new Integer(10000));
				 
				HttpPost httppost = new HttpPost(URL);
				HttpResponse response;
				
				try {
					if(nameValuePairs==null||nameValuePairs.equals("")){				
					}else{
						httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs,"UTF-8"));
					}
					httpclient.getParams().setParameter(CoreProtocolPNames.USER_AGENT, "Client1");
					
					response = httpclient.execute(httppost);
					if (response.getStatusLine().getStatusCode() != HttpStatus.SC_OK) {
					}else{
						HttpEntity entity = response.getEntity();			
						
						if (entity == null) {
						}else{
							if(entity != null){
								
								InputStream inputStream = entity.getContent();		
								xml_string = convertStreamToString(inputStream);
								
								httpclient.getConnectionManager().shutdown();
								
							}
							result = true;
						}
					}			
				} catch (ClientProtocolException e) {			
				} catch (IOException e) {			
				} finally {
					httpclient.getConnectionManager().shutdown();
					sendMessage(0,  arg1, Boolean.valueOf(result), kind);
				}
			}
		}).start();
	}
	
	private String convertStreamToString(InputStream is) {
		StringBuilder stringBuilder = new StringBuilder();
		
		try {			 
			 BufferedReader reader = new BufferedReader(new InputStreamReader(is,"UTF-8"));			 
			 String line = null;
		  
			 while ((line = reader.readLine()) != null) {
				 stringBuilder.append(line+"\n");
			 }
			 is.close();
			 return stringBuilder.toString();
		 }catch (IOException e) {
			 e.printStackTrace();
			 return "";
		 }
	}
	
	private String makeStringComma(String str){
		if(str.length()==0)
			return "";
		long value = Long.parseLong(str);
		DecimalFormat format = new DecimalFormat("###,###");
		
		return format.format(value);
	}
	
	private void showCenterProgress(){
		
		ProgressBar progressBar = (ProgressBar)mActivity.findViewById(R.id.progress_bar) ;	
		progressBar.setVisibility(View.VISIBLE) ; 

	}
	 
	private void hideCenterProgress(){
		ProgressBar progressBar = (ProgressBar)mActivity.findViewById(R.id.progress_bar) ;
		progressBar.setVisibility(View.GONE) ;

	}
	
	private void sendMessage(int what, int arg1, Boolean obj, String kind) {
		Message msg = handler.obtainMessage(what, obj);
		Bundle bundle = new Bundle() ;
		bundle.putInt("event_code", arg1) ;
		bundle.putString("kind", kind) ;
		msg.setData(bundle);
		handler.sendMessage(msg);
	}
	
	final Handler handler = new Handler() {
		public void handleMessage(Message msg) {
			// TODO Auto-generated method stub
		 
			int event_code = msg.getData().getInt("event_code") ;
			Boolean result = (Boolean)msg.obj;
			String kind = (String)msg.getData().getString("kind") ;
			
			httpResult(event_code, result.booleanValue(), kind); 
			
		}
	} ;
	
}