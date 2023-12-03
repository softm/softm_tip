package kr.co.gscaltex.gsnpoint.card;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.GSAppHelper;
import kr.co.gscaltex.gsnpoint.Login;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.setting.SettingMainView;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.Util;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.os.Handler;
import android.util.DisplayMetrics;
import android.view.GestureDetector;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.view.ViewGroup;
import android.view.animation.AlphaAnimation;
import android.view.animation.Animation;
import android.view.animation.AnimationSet;
import android.view.animation.AnimationUtils;
import android.view.animation.TranslateAnimation;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.ViewFlipper;

public class CardMainView extends BaseActivity implements OnTouchListener,OnClickListener { //,Runnable,OnLongClickListener {
	private String TAG = "CardMainView";
	
	DefaultApplication mApp ;
 
	private boolean card_refresh = false;
	private boolean login = false;
	private FileInfo fi = null;
	private Handler handler = new Handler();
	private GestureDetector mGestureDetector;
	
	private RelativeLayout barcode_view = null;
	private ProgressBar progress_bar = null;
	private ViewFlipper viewFlipper = null;
	//private HorizontalScrollView HorizontalScrollView01 = null;
	private LinearLayout LinearPage = null;
	
	private ViewGroup mBasicCont, mInfoCont, mLogin, mLogout = null;
	private ImageButton imgBtnPiOpen, imgBtnPiClose, btnlogin, btnSet, btnReset, btnHelp = null;
	private ImageView mLastUseSign= null;
	//private ImageView my_picture,my_picture2 = null; 
	private TextView mUsePoint, mCanUsePoint, mCanGivePoint, mLastUsePoint, 
				mLastFranchse, mInterestCategory, mInterestArea, mCardNumber=null;
	private TextView mUsePoint2,mCanGivePoint2, mLastFranchse2=null;
	private ArrayList<String> g_resources = new ArrayList<String>();
	private ArrayList<String> g_cardNumbers = new ArrayList<String>();
	private ArrayList<String> g_cvs = new ArrayList<String>();
	
	private float xAtDown = 0;
	private int BAR_CODE_VIEW_WITH = 0;
	private boolean bAutoLogin;
	private boolean useUpEvent= true;
	//private static String outFilePath = Environment.getExternalStorageDirectory().getAbsolutePath() + "/" + Util.DIR + "/"+ "myphoto.jpg"; 
	private static String outFilePath = "/data/data/kr.co.gscaltex.gsnpoint/files" + "/"+ "myphoto.jpg"; 
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
	
		mApp = ((DefaultApplication)getApplicationContext()) ;
		fi = new FileInfo();
		String patterns = fi.getSettingInfo(this, FileInfo.CARD_PATTERN_LIST);
		String cards = fi.getSettingInfo(this, FileInfo.CARD_NO_LIST);
		
		Bundle extras = getIntent().getExtras();
		login = extras.getBoolean("login");

		String auto_save = this.fi.getSettingInfo(this, FileInfo.AUTO_SAVE);
		if(auto_save==null||auto_save.equals("")){
			 bAutoLogin = false;
		}else{
			 bAutoLogin = true;
		}
		
		
		if(login){
			setContentView(R.layout.cardmain); 
			appHelper = new GSAppHelper(this, R.string.TITLE_TYPE_CARD, R.id.help_button);	
			initLayout();
				
	    	if(mApp.getCardRefresh()) {
	    		//Debug.trace(TAG, "++++ mApp.getCardRefresh() is true" );
	    		updateCard();
	    		mApp.setCardRefresh(false) ;
	    	}else{
	    		getCardList();
	    	}
	    	
			mLogin.setVisibility(View.VISIBLE );
			mLogout.setVisibility(View.GONE );
			barcode_view.setVisibility(RelativeLayout.VISIBLE);
			
		}else{		
			if(bAutoLogin ==true){
				setContentView(R.layout.cardmain); 
				appHelper = new GSAppHelper(this, R.string.TITLE_TYPE_CARD, R.id.help_button);	
				initLayout();
				login= true;
				getIntent().putExtra("login", login);
				
			
			//	if(patterns.equals("")||cards.equals("")){
					//만약 등록된 카드가 로컬에 없으면 
		    //		updateCard();	
			//	}else{
			//		getCardList();
			//		getPointInfo();
			//	}
				
				if(mApp.getCardRefresh()) {
		    		updateCard();
		    		mApp.setCardRefresh(false) ;
		    	}else{
		    		getCardList();
		    	}
				
				mLogin.setVisibility(View.VISIBLE );
				mLogout.setVisibility(View.GONE );
				barcode_view.setVisibility(RelativeLayout.VISIBLE);
			}else{
								
				if(patterns.equals("")||cards.equals("")){
					Intent i = new Intent(this, CardFirstResisterView.class);
					i.putExtra("login", false);
					i.setFlags(i.FLAG_ACTIVITY_NO_USER_ACTION);
					startActivity(i);		
					return;	
				} else {
					setContentView(R.layout.cardmain); 
					appHelper = new GSAppHelper(this, R.string.TITLE_TYPE_CARD, R.id.help_button);		
					initLayout();
					
					mLogout.setVisibility(View.VISIBLE );
					mLogin.setVisibility(View.GONE );
					
					barcode_view.setVisibility(RelativeLayout.VISIBLE);
					getCardList();
				}
			}
		}		
		//new CardTitleView(this,true,true,false,true,login);
		new CardTabpageView(this, login);
		new NewMainMenu(this);
		
		reloadView(true);	
		appHelper.add(findViewById(R.id.set_button           ),R.drawable.guide_guide01_ex01,GSAppHelper.POSITION_RIGHT_BOTTOM,-4,-4,1,2);
		appHelper.add(findViewById(R.id.reset_button         ),R.drawable.guide_guide01_ex02,GSAppHelper.POSITION_RIGHT_BOTTOM,-4,-4,1,2);
		if(login){
			appHelper.add(findViewById(R.id.my_picture           ),R.drawable.guide_guide01_ex03,GSAppHelper.POSITION_RIGHT_TOP);
			appHelper.add(findViewById(R.id.btn_open             ),R.drawable.guide_guide01_ex04,GSAppHelper.POSITION_LEFT_TOP,0,0,0,-3);
		} else {
		}
 		//appHelper.add(findViewById(R.id.barcode_view         ),R.drawable.guide_guide01_ex05,GSAppHelper.POSITION_LEFT_TOP,-39,0,20,-10);
		appHelper.add(findViewById(R.id.page_linear          ),R.drawable.guide_guide01_ex06,GSAppHelper.POSITION_RIGHT_BOTTOM,-43,0,20);
		//appHelper.add(findViewById(R.id.newcard_button       ),R.drawable.guide_guide02_ex03,GSAppHelper.POSITION_RIGHT_TOP,-3,-3);		
	}

	@SuppressWarnings("static-access")
	private void initLayout(){
		progress_bar = (ProgressBar)findViewById(R.id.progress_bar);
		
		barcode_view = (RelativeLayout)findViewById(R.id.barcode_view);
		viewFlipper = (ViewFlipper)findViewById(R.id.viewFlipper);
		viewFlipper.setOnTouchListener(this);
		LinearPage = (LinearLayout)findViewById(R.id.page_linear);

		mLogin = (ViewGroup) findViewById(R.id.login_container); 
		mLogout = (ViewGroup) findViewById(R.id.logout_container); 
		mBasicCont = (ViewGroup) findViewById(R.id.cardmain_basic_container);
		mInfoCont = (ViewGroup)findViewById(R.id.cardmain_info_container);
		
		Paint paint1 = new Paint(); 
		paint1.setColor(Color.BLACK);
		paint1.setAlpha(50);        
		findViewById(R.id.map_preventer).setBackgroundColor(paint1.getColor());
		
		ViewGroup LnMapPreventer = (ViewGroup) findViewById(R.id.map_preventer); 		
		LnMapPreventer.setOnClickListener(this);
		
		// 상단 파이 모양 이미지 - 검색 열기 
		imgBtnPiOpen = (ImageButton)findViewById(R.id.btn_open);
		imgBtnPiOpen.setOnClickListener(this);

		// 상단 파이 모양 이미지 - 검색 닫기 
		imgBtnPiClose = (ImageButton)findViewById(R.id.btn_pi_close );
		imgBtnPiClose.setOnClickListener(this);
		
		btnlogin = (ImageButton)findViewById(R.id.btn_login);
		btnlogin.setOnClickListener(this);
		
		btnSet = (ImageButton)findViewById(R.id.set_button);
		btnSet.setOnClickListener(this);
		
		btnReset = (ImageButton)findViewById(R.id.reset_button);
		btnReset.setOnClickListener(this);
		
		btnHelp = (ImageButton)findViewById(R.id.help_button);
		btnHelp.setOnClickListener(this);
	
		mLastUseSign = (ImageView)findViewById(R.id.lastuse_sign);
		
		mUsePoint = (TextView)findViewById(R.id.point_txt);
		mUsePoint2 = (TextView)findViewById(R.id.point_txt2);
		mCanGivePoint = (TextView)findViewById(R.id.gift_point);
		mCanGivePoint2 = (TextView)findViewById(R.id.gift_point2);
		mLastFranchse = (TextView)findViewById(R.id.branch_name_txt);
		mLastFranchse2 = (TextView)findViewById(R.id.branch_name_txt2);
		
		mCanUsePoint =(TextView)findViewById(R.id.canuse_value);
		mLastUsePoint = (TextView)findViewById(R.id.lastuse_value);
		mCardNumber = (TextView)findViewById(R.id.txt_card_number);
		mInterestArea = (TextView)findViewById(R.id.txt_interest_area);
		mInterestCategory = (TextView)findViewById(R.id.txt_interest_category);
		
		TextView login_name = (TextView)findViewById(R.id.login_name);
		TextView login_name2 = (TextView)findViewById(R.id.login_name2);
		ImageView my_picture = (ImageView)findViewById(R.id.my_picture);
		ImageView my_picture2 = (ImageView)findViewById(R.id.my_picture2);
		my_picture.setOnClickListener(this);
		
        String userName = fi.getSettingInfo(this, FileInfo.USER_NAME);     
        String myphoto_set = fi.getSettingInfo(this, FileInfo.MYPHOTO_SET);
		
		if(myphoto_set==null||myphoto_set.equals("")){
		}else if(myphoto_set.equals("TRUE")){
			my_picture.setImageDrawable(null);
			my_picture2.setImageDrawable(null);
			Bitmap bm = BitmapFactory.decodeFile(outFilePath);
			
			my_picture.setImageBitmap((bm.createScaledBitmap(bm, 60, 60, false)));
			my_picture2.setImageBitmap((bm.createScaledBitmap(bm, 60, 60, false)));
		}	
        login_name.setText(userName);
        login_name2.setText(userName);
       
        mUsePoint.setText(fi.getSettingInfo(this, FileInfo.CAN_USE_POINT));
        mUsePoint2.setText(fi.getSettingInfo(this, FileInfo.CAN_USE_POINT));
        mCanUsePoint.setText(fi.getSettingInfo(this, FileInfo.CAN_USE_POINT));
        mCanGivePoint.setText(fi.getSettingInfo(this, FileInfo.CAN_GIVE_POINT));
        mCanGivePoint2.setText(fi.getSettingInfo(this, FileInfo.CAN_GIVE_POINT));
        mLastFranchse.setText(fi.getSettingInfo(this, FileInfo.LAST_FRANCHSE));
        mLastFranchse2.setText(fi.getSettingInfo(this, FileInfo.LAST_FRANCHSE));
        mLastUsePoint.setText(fi.getSettingInfo(this, FileInfo.LAST_USE_POINT));
        mInterestArea.setText(fi.getSettingInfo(this, FileInfo.INTEREST_AREA));
        mInterestCategory.setText(fi.getSettingInfo(this, FileInfo.INTEREST_CATEGORY));
        
        mCardNumber.setText(fi.getSettingInfo(this, FileInfo.CARD_NUMBERS)+"개");
        
        if(fi.getSettingInfo(this, FileInfo.LAST_USE_POINT_ISPLUS).equals("FALSE")){
        	mLastUseSign.setBackgroundResource(R.drawable.bullet_minus);
			mLastUsePoint.setTextColor(Color.rgb(255, 114, 0));
        }else{
        	mLastUseSign.setBackgroundResource(R.drawable.bullet_plus);
			mLastUsePoint.setTextColor(Color.rgb(81, 156, 221));
        }
        	
		progress_bar.setVisibility(View.INVISIBLE) ;
	}
	@Override
	protected void onDestroy() { 
		super.onDestroy(); 
			
		if(viewFlipper != null) {		
			//Debug.trace(TAG, "++++ onDestroy mCoverflow.getSelectedItemPosition():" + viewFlipper.getDisplayedChild() );
			String position = String.valueOf(viewFlipper.getDisplayedChild()) ;
			fi.setSettingInfo(getBaseContext(), position, FileInfo.COVERFLOW_LAST_POSITION) ;
		}
	}

	public void getCardList() {

		String patterns = fi.getSettingInfo(this, FileInfo.CARD_PATTERN_LIST);
		String cards = fi.getSettingInfo(this, FileInfo.CARD_NO_LIST);
		String cvcs = fi.getSettingInfo(this, FileInfo.CARD_CVC_LIST);

		//단말에 저장한ArrayList에 저장된 값을 집어 놓고, 첫번째 값 바코드 값과 CVC값을 화면에 뿌려준다 //
		g_resources = new ArrayList<String>();
		g_cardNumbers = new ArrayList<String>();
		g_cvs = new ArrayList<String>();
		
		int from = 0;
		int to = 0;
		to = patterns.indexOf(',', from);
		if(to==-1){
			//레코드가 하나인 경우
			g_resources.add(patterns.trim());
		}else{
			while(to>-1){				
				g_resources.add(patterns.substring(from, to).trim());
				from=to+1;
				to = patterns.indexOf(',', from);
				if(to==-1){
					g_resources.add(patterns.substring(from, patterns.length()).trim());
				}
			}
		}

		from = 0;
		to = 0;
		to = cards.indexOf(',', from);
		if(to==-1){
			//레코드가 하나인 경우
			g_cardNumbers.add(cards.trim());
		}else{
			while(to>-1){
				to = cards.indexOf(',', from);
				g_cardNumbers.add(cards.substring(from, to).trim());
				from=to+1;
				to = cards.indexOf(',', from);
				if(to==-1){
					g_cardNumbers.add(cards.substring(from, cards.length()).trim());
				}
			}
		}

		from = 0;
		to = 0;
		to = cvcs.indexOf(',', from);
		if(to==-1){
			//레코드가 하나인 경우
			g_cvs.add(cvcs.trim());
		}else{
			while(to>-1){
				to = cvcs.indexOf(',', from);
				g_cvs.add(cvcs.substring(from, to).trim());
				from=to+1;
				to = cvcs.indexOf(',', from);
				if(to==-1){
					g_cvs.add(cvcs.substring(from, cvcs.length()).trim());
				}
			}
		}	
		drawBarCodeImage();		
		
		int nCoverflowLastPosition = 0 ;
		if(!fi.getSettingInfo(getBaseContext(), FileInfo.COVERFLOW_LAST_POSITION).equals("")) {
			nCoverflowLastPosition = Integer.valueOf(fi.getSettingInfo(getBaseContext(), FileInfo.COVERFLOW_LAST_POSITION) )  ;
	 	}
		
		fi.setSettingInfo(getBaseContext(), String.valueOf(g_cardNumbers.size()), FileInfo.CARD_NUMBERS) ;
		
		if(g_cardNumbers.size() == 0 || nCoverflowLastPosition >= g_cardNumbers.size()) {
			nCoverflowLastPosition = 0 ;
			fi.setSettingInfo(getBaseContext(), "", FileInfo.COVERFLOW_LAST_POSITION) ;
		}
		
		viewFlipper.setDisplayedChild(nCoverflowLastPosition);		
		for (int i = 0; i < g_resources.size()+1; i++) {
			ImageView pageImg = new ImageView(this);
			pageImg.setImageResource(R.drawable.paging_dot_off);
			LinearPage.addView(pageImg,i);
		}
		((ImageView)LinearPage.getChildAt(nCoverflowLastPosition)).setImageResource(R.drawable.paging_dot_on);
	}
	
	private void getPointInfo(){
			Thread r = new Thread(new Runnable() {
				public void run() {
	
					String cuskey2 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_2);
	
					List<NameValuePair> params = new ArrayList<NameValuePair>(2);
					params.add(new BasicNameValuePair("process_code", "mainPointInfo"));	
					params.add(new BasicNameValuePair("cuskey2", cuskey2));													
					setParams(params);
					loadUrl(R.string.point_name, Util.DATA_CONNECT,"") ;
				}
			});
			r.start();
	}
	
	private void updateCard() {
		
		Thread r = new Thread(new Runnable() {
			public void run() {

				String cuskey1 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_1);
				String cuskey2 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_2);
				String userid = fi.getSettingInfo(getBaseContext(), FileInfo.ID);
				
				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				params.add(new BasicNameValuePair("process_code", "cardList"));
				params.add(new BasicNameValuePair("cuskey2", cuskey2));
				params.add(new BasicNameValuePair("cuskey1", cuskey1));	
				params.add(new BasicNameValuePair("userid", userid));
				
				setParams(params);
				loadUrl(R.string.CARD_LIST, Util.DATA_CONNECT,"") ;
			}
		});
		r.start();
	}
	
	protected void httpResult(int what, boolean result, String kind) {
		switch(what) {
		case R.string.CARD_LIST :
			saveCardList();
			handler.post(reflashRunnable);
			break ;
			
		case R.string.point_name :
			setUserPointInformation();
			break;
		}
	}
	
	private void setUserPointInformation(){
		try {
			String str = getString();
			
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();
			InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
			Document doc = builder.parse(istream);

			Element order = doc.getDocumentElement();
			NodeList result_items = order.getElementsByTagName("result");
			Node result_item = result_items.item(0);
			Node result_text = result_item.getFirstChild();

			result_tag = result_text.getNodeValue();
			if(result_tag.equals(Util.SERVER_ALERT_STATUS)){
				//서비스 점검중 등등	
				//Log.i("error",error);
				handler.post(viewToastRunnable);
				if(progress_bar.isShown()){
					progress_bar.setVisibility(ProgressBar.GONE);
				}
				finish();
			}else if(result_tag.equals(Util.SERVER_GO_STATUS)){
				//URL이동
				goErrorUrl();
			}else if(result_tag.equals("0")){
				//error_item = error_items.item(0);
				//error_text = error_item.getFirstChild();
				//Toast t = Toast.makeText(this, Util.COMMON_MSG_3+error_text.getNodeValue(), Toast.LENGTH_SHORT); 
				//t.show();
				//handler.post(comm_3Runnable);
			}else if(result_tag.equals("1")){
					
				Node usePoint_item = order.getElementsByTagName("canUsePoint").item(0);
				Node vanishPoint_item = order.getElementsByTagName("vanishPoint").item(0);								
				Node canGivePoint_item = order.getElementsByTagName("canGivePoint").item(0);
				Node lastUsePoint_item = order.getElementsByTagName("lastUsePoint").item(0);
				Node lastFranchse_item = order.getElementsByTagName("lastFranchseName").item(0);
								
				Node interestCategory_item = order.getElementsByTagName("interestCategory").item(0);
				Node interestArea_item = order.getElementsByTagName("interestArea").item(0);
				
				String CanUse="";
				String CanGive="";
				String LastStore="";
				String VanishPoint="";
				
				if(usePoint_item!=null && usePoint_item.getFirstChild()!=null)
					CanUse= makeStringComma(usePoint_item.getFirstChild().getNodeValue());
				if(canGivePoint_item!=null && canGivePoint_item.getFirstChild()!=null)
					CanGive = makeStringComma(canGivePoint_item.getFirstChild().getNodeValue());
				if(lastFranchse_item!=null && lastFranchse_item.getFirstChild()!=null)
					LastStore = lastFranchse_item.getFirstChild().getNodeValue();			
				if(vanishPoint_item!=null && vanishPoint_item.getFirstChild()!=null)
					VanishPoint = vanishPoint_item.getFirstChild().getNodeValue();
				
				mUsePoint.setText(CanUse);
				mUsePoint2.setText(CanUse);
				mCanUsePoint.setText(CanUse);
				mCanGivePoint.setText(CanGive);
				mCanGivePoint2.setText(CanGive);
				mLastFranchse.setText(LastStore);
				mLastFranchse2.setText(LastStore);
				
				mCardNumber.setText(String.valueOf(g_cardNumbers.size())+"개");
				
				if(interestCategory_item!=null && interestCategory_item.getFirstChild()!=null){
					mInterestCategory.setText(interestCategory_item.getFirstChild().getNodeValue());
					fi.setSettingInfo(this, interestCategory_item.getFirstChild().getNodeValue(),FileInfo.INTEREST_CATEGORY);
				}
				if(interestArea_item!=null && interestArea_item.getFirstChild()!=null){
					mInterestArea.setText(interestArea_item.getFirstChild().getNodeValue());
					fi.setSettingInfo(this, interestArea_item.getFirstChild().getNodeValue(),FileInfo.INTEREST_AREA);
				}
				
				long last =0;
				if(lastUsePoint_item!=null && lastUsePoint_item.getFirstChild()!=null)
					last = Long.valueOf(lastUsePoint_item.getFirstChild().getNodeValue());
				
				if(last<0){
					mLastUseSign.setBackgroundResource(R.drawable.bullet_minus);
					String temp = lastUsePoint_item.getFirstChild().getNodeValue();
					mLastUsePoint.setText(makeStringComma(temp.substring(1)));
					mLastUsePoint.setTextColor(Color.rgb(255, 114, 0));
					fi.setSettingInfo(this, makeStringComma(temp.substring(1)),FileInfo.LAST_USE_POINT);
					fi.setSettingInfo(this, "FALSE",FileInfo.LAST_USE_POINT_ISPLUS);
				}
				else{
					mLastUseSign.setBackgroundResource(R.drawable.bullet_plus);
					mLastUsePoint.setText(makeStringComma(lastUsePoint_item.getFirstChild().getNodeValue()));
					mLastUsePoint.setTextColor(Color.rgb(81, 156, 221));
					fi.setSettingInfo(this, makeStringComma(lastUsePoint_item.getFirstChild().getNodeValue()),FileInfo.LAST_USE_POINT);
					fi.setSettingInfo(this, "TRUE",FileInfo.LAST_USE_POINT_ISPLUS);
				}
				
				fi.setSettingInfo(this, CanUse,FileInfo.CAN_USE_POINT);
				fi.setSettingInfo(this, CanGive,FileInfo.CAN_GIVE_POINT);
				fi.setSettingInfo(this, VanishPoint,FileInfo.VANISH_POINT);		
				fi.setSettingInfo(this, LastStore,FileInfo.LAST_FRANCHSE);				
			}
		}
		catch (Exception e) {
			e.printStackTrace();
		}
	}
	/**
	 * User card data save to SQLight 
	 * */
	private void saveCardList(){
		try {

			String str = getString();
			
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();
			InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
			Document doc = builder.parse(istream);

			Element order = doc.getDocumentElement();
			NodeList result_items = order.getElementsByTagName("result");
			Node result_item = result_items.item(0);
			Node result_text = result_item.getFirstChild();

			result_tag = result_text.getNodeValue();
			if(result_tag.equals(Util.SERVER_ALERT_STATUS)){
				//서비스 점검중 등등	
				handler.post(viewToastRunnable);
				if(progress_bar.isShown()){
					progress_bar.setVisibility(ProgressBar.GONE);
				}
				finish();
			}else if(result_tag.equals(Util.SERVER_GO_STATUS)){
				//URL이동
				goErrorUrl();
			}else if(result_tag.equals("0")){
				//error_item = error_items.item(0);
				//error_text = error_item.getFirstChild();
				//Toast t = Toast.makeText(this, Util.COMMON_MSG_3+error_text.getNodeValue(), Toast.LENGTH_SHORT); 
				//t.show();
				//handler.post(comm_3Runnable);
			}else if(result_tag.equals("1")){
				NodeList pk_items = order.getElementsByTagName("pk");
				NodeList cardNos = order.getElementsByTagName("cardNo");
				NodeList cvcs = order.getElementsByTagName("cvc");
				
				String card_pattern = "";
				String card_numbers = "";
				String cvc_numbers = "";
				String tmp_cvc = "";
				
				if(cardNos.getLength()==0){
					FirstCardView firstcard = new FirstCardView(this, login);
					viewFlipper.addView(firstcard, new ViewGroup.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT,
							ViewGroup.LayoutParams.WRAP_CONTENT));
					
					for (int i = 0; i < g_resources.size()+1; i++) {
						ImageView pageImg = new ImageView(this);
						pageImg.setImageResource(R.drawable.paging_dot_off);
						LinearPage.addView(pageImg,i);
					}
					((ImageView)LinearPage.getChildAt(0)).setImageResource(R.drawable.paging_dot_on);
					
				}else{
					for(int i = 0; i < cardNos.getLength();i++ )
					{					
						Node pk_item = pk_items.item(i);
						Node cardNo = cardNos.item(i);
						Node cvc = cvcs.item(i);
					
						// 기존 카드와 다른 경우: 즉, 다른사용자 로그인										
						if(cvc.getFirstChild()==null){
							tmp_cvc="";
						}else{
							tmp_cvc = cvc.getFirstChild().getNodeValue();
						}
						
						if(i==0){
							card_pattern = pk_item.getFirstChild().getNodeValue();
							card_numbers = cardNo.getFirstChild().getNodeValue();
							cvc_numbers = tmp_cvc;
						}else{
							card_pattern = card_pattern+","+pk_item.getFirstChild().getNodeValue();
							card_numbers = card_numbers+","+cardNo.getFirstChild().getNodeValue();
							cvc_numbers = cvc_numbers+","+tmp_cvc;
						}
					}
					
					if(card_pattern==null||card_pattern.equals("")){
						fi.setSettingInfo(this, "2800",FileInfo.CARD_PATTERN_LIST);
						fi.setSettingInfo(this, "1234567890123456",FileInfo.CARD_NO_LIST);
						fi.setSettingInfo(this, "",FileInfo.CARD_CVC_LIST);
					}else{
						String oldNumberList = fi.getSettingInfo(this,FileInfo.CARD_NO_LIST) ;
						if(!oldNumberList.equals(card_numbers)) {
							
							fi.setSettingInfo(this, "", FileInfo.COVERFLOW_LAST_POSITION) ;
						}				
						fi.setSettingInfo(this, card_pattern,FileInfo.CARD_PATTERN_LIST);
						fi.setSettingInfo(this, card_numbers,FileInfo.CARD_NO_LIST);
						fi.setSettingInfo(this, cvc_numbers,FileInfo.CARD_CVC_LIST);
					}			
					handler.post(getCardlistRunnable);
				}
			}
		}
		catch (Exception e) {
			e.printStackTrace();
		}
	}
	
	/**
	 * Runnables
	 */
	private Runnable reflashRunnable= new Runnable(){
		public void run() {
			reloadView(true);
			
		}		
	};
	
	private Runnable getCardlistRunnable= new Runnable(){
		public void run() {
			getCardList();
			getPointInfo();
		}		
	};
	/**
	 * OnClickListener
	 */
	public boolean onTouch(View view, MotionEvent event) {
		if(event.getAction() == MotionEvent.ACTION_DOWN) {
			xAtDown = event.getX(); // 터치 시작지점 x좌표 저장		
			useUpEvent= true;
			
		}
		else if(event.getAction() == MotionEvent.ACTION_UP){
			if(useUpEvent){
				if(viewFlipper.getDisplayedChild()!=viewFlipper.getChildCount()){
					if(g_cardNumbers.size()>viewFlipper.getDisplayedChild()){
						BarcodeView barcode = new BarcodeView(this, login);
						barcode.requestBigBarcode(g_cardNumbers.get(viewFlipper.getDisplayedChild()), g_cvs.get(viewFlipper.getDisplayedChild()));
					}
				}
			}else{
				float nTouchPosX = event.getX();
				if( (nTouchPosX + 30) < xAtDown ) {
					// 왼쪽 방향 에니메이션 지정
					if((viewFlipper.getDisplayedChild()+1)==viewFlipper.getChildCount())
						return false;
					
					viewFlipper.setInAnimation(AnimationUtils.loadAnimation(this, R.anim.push_left_in));
					viewFlipper.setOutAnimation(AnimationUtils.loadAnimation(this, R.anim.push_left_out));
					viewFlipper.showNext();
					
					//viewFlipper.setDisplayedChild(0);
					((ImageView)LinearPage.getChildAt(viewFlipper.getDisplayedChild()-1)).setImageResource(R.drawable.paging_dot_off);
					((ImageView)LinearPage.getChildAt(viewFlipper.getDisplayedChild())).setImageResource(R.drawable.paging_dot_on);
					
				} else if( (nTouchPosX - 30) > xAtDown ) {
					// 오른쪽 방향 에니메이션 지정
					viewFlipper.setInAnimation(AnimationUtils.loadAnimation(this, R.anim.push_right_in));
					viewFlipper.setOutAnimation(AnimationUtils.loadAnimation(this, R.anim.push_right_out));
					
					if(viewFlipper.getDisplayedChild()==0)
						return false;
					
					viewFlipper.showPrevious();
					((ImageView)LinearPage.getChildAt(viewFlipper.getDisplayedChild()+1)).setImageResource(R.drawable.paging_dot_off);
					((ImageView)LinearPage.getChildAt(viewFlipper.getDisplayedChild())).setImageResource(R.drawable.paging_dot_on);
					
				}
			}
		}
		else if(event.getAction() == MotionEvent.ACTION_MOVE){
			useUpEvent= false;
		}
		
		// TODO 
		if ( viewFlipper.getChildCount() == viewFlipper.getDisplayedChild()+1 ) { // 플리퍼 내의 마지막 ViewGroup의 경우.
			appHelper.remove(findViewById(R.id.barcode_view));
			appHelper.add(findViewById(R.id.newcard_button       ),R.drawable.guide_guide02_ex03,GSAppHelper.POSITION_RIGHT_TOP,-3,-3);			
			findViewById(R.id.newcard_button).setVisibility(View.VISIBLE);
		} else {
			appHelper.remove(findViewById(R.id.newcard_button));
	 		appHelper.add(findViewById(R.id.barcode_view         ),R.drawable.guide_guide01_ex05,GSAppHelper.POSITION_LEFT_TOP,-39,0,20,-10);
			findViewById(R.id.newcard_button).setVisibility(View.GONE   );			
		}		
		return true;
	}


	public void onClick(View v) {
		Intent intent;
		
		switch (v.getId()) {

		case R.id.map_preventer:
			break;
		case R.id.btn_open: // 닫기 : 상단 pi 클릭시 도시조회 창이 보여지게
			mInfoCont.setVisibility(View.VISIBLE );
			setLayoutAnim_slidedown(mInfoCont, this);
			barcode_view.setVisibility(RelativeLayout.GONE);
			findViewById(R.id.help_button).setVisibility(View.INVISIBLE);
			break;

		case R.id.btn_pi_close: // 열기 : 상단 pi 클릭시 도시조회 창이 보여지게
			mInfoCont.setVisibility(View.GONE );
			setLayoutAnim_slideup(mInfoCont, this);	
			barcode_view.setVisibility(RelativeLayout.VISIBLE);
			findViewById(R.id.help_button).setVisibility(View.VISIBLE);
			break;
			
		case R.id.btn_login:
			intent = new Intent(this, Login.class);
			intent.putExtra("login", login);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);	
			finish();
			break;
			
		case R.id.set_button:
			intent = new Intent(this, SettingMainView.class);
			intent.putExtra("login", login);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);	
			finish();
			break;
			
		case R.id.reset_button:
			if(login){
				mApp.setCardRefresh(true) ;
			}else{
				//mApp.setTabpage_refresh(true);
			}
			intent = new Intent(this, CardMainView.class);
			intent.putExtra("login", login);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);	
			finish();
			break;
		case R.id.help_button:
			this.getAppHelper().showHelp();
			break;
			
		case R.id.my_picture : 	// present button
			intent = new Intent(this, SettingMainView.class);
			intent.putExtra("login", login);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);
			finish();
	         break;	
	         
		default:
			break;
		}
		
	}

	/**
	 * reloaded card view
	 * @param isRefresh
	 */
	private void reloadView(boolean isRefresh){		
		DisplayMetrics metrics = new DisplayMetrics(); 
		getWindowManager().getDefaultDisplay().getMetrics(metrics); 
		
		int height = metrics.heightPixels;
		BAR_CODE_VIEW_WITH = metrics.widthPixels;
	}
	
	private void drawBarCodeImage() {
		for(int nCount=0;nCount<g_cardNumbers.size();nCount++) {
			BarcodeView barcode = new BarcodeView(this, login);
			barcode.setCardNumber(g_cardNumbers.get(nCount), g_cvs.get(nCount),g_resources.get(nCount));
			viewFlipper.addView(barcode, new ViewGroup.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT,
					ViewGroup.LayoutParams.WRAP_CONTENT));
		}
		// TODO
		FirstCardView firstcard = new FirstCardView(this, login);
		viewFlipper.addView(firstcard, new ViewGroup.LayoutParams(ViewGroup.LayoutParams.WRAP_CONTENT,
				ViewGroup.LayoutParams.WRAP_CONTENT));
		// TODO
		if ( viewFlipper.getChildCount() > 1 ) {
			appHelper.add(findViewById(R.id.barcode_view         ),R.drawable.guide_guide01_ex05,GSAppHelper.POSITION_LEFT_TOP,-39,0,20,-10);
		} else {
			appHelper.add(findViewById(R.id.newcard_button       ),R.drawable.guide_guide02_ex03,GSAppHelper.POSITION_RIGHT_TOP,-3,-3);			
		}	
	}
	
	public static void setLayoutAnim_slidedown(ViewGroup panel, Context ctx){
		AnimationSet set = new AnimationSet(true);
		Animation animation	= new AlphaAnimation(0.0f, 1.0f);
		animation.setDuration(1000);
		animation = new TranslateAnimation(
				Animation.RELATIVE_TO_SELF, 0.0f, Animation.RELATIVE_TO_SELF, 0.0f,
				Animation.RELATIVE_TO_SELF, -1.0f, Animation.RELATIVE_TO_SELF, 0.0f
				);
		animation.setDuration(500);
		set.addAnimation(animation);
		panel.startAnimation(set);
	}

	public static void setLayoutAnim_slideup(ViewGroup panel, Context ctx){
		AnimationSet set = new AnimationSet(true);
		Animation animation	= new AlphaAnimation(0.0f, 1.0f);
		animation.setDuration(1000);
		animation = new TranslateAnimation(
				Animation.RELATIVE_TO_SELF, 0.0f, Animation.RELATIVE_TO_SELF, 0.0f,
				Animation.RELATIVE_TO_SELF, 0.0f, Animation.RELATIVE_TO_SELF, -1.0f
				);
		animation.setDuration(500);
		set.addAnimation(animation);
		panel.startAnimation(set);
	}  

	private String makeStringComma(String str){
		if(str.length()==0)
			return "";
		long value = Long.parseLong(str);
		DecimalFormat format = new DecimalFormat("###,###");
		
		return format.format(value);
	}
}
