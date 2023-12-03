package kr.co.gscaltex.gsnpoint.point;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.List;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.GSAppHelper;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.Util;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import android.app.AlertDialog;
import android.app.DatePickerDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.widget.AbsListView;
import android.widget.DatePicker;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.ScrollView;
import android.widget.TextView;
import android.widget.Toast;

public class Point extends BaseActivity implements OnClickListener, OnTouchListener{
	String TAG = "Point";
	
	DefaultApplication mApp ;
	private Handler handler = new Handler();
	
	private boolean m_bLogin = false;
	private FileInfo fi = null;
	private int nSelectTab, nSelectClickID = 0;
	
	public static final int TAB_BUTTON_COUNT = 2;
	public static final int POINT_GET_REFUEL_CHECKLIST = 200 ;
	public static final int POINT_GIVE_CHECK = 201;
	public static final int POINT_PRESENT_END = 202;
	
	private static final int FROM_DATE_DIALOG_ID=300;
	private static final int TO_DATE_DIALOG_ID=400;
	
	public static final int[] TAB_BUTTON_OFF_RESOURCE_IDS = {
		R.drawable.point_saving_tab01_off,
		R.drawable.point_saving_tab02_off,
	};
	public static final int[] TAB_BUTTON_ON_RESOURCE_IDS = {
		R.drawable.point_saving_tab01_on,
		R.drawable.point_saving_tab02_on,
	};
	private ImageButton[] mTabButtons = new ImageButton[TAB_BUTTON_COUNT];
	private ImageButton mPresent,mSearch, mMore10, mTop = null;
	private TextView usePoint, vanishPoint = null;
	private TextView fromDate, toDate = null;
	
	private ScrollView mScroll = null;
	
	private ListView PointListview;
	private MyPointListAdapter  mPointAdapter = null;
	private MyFuelListAdapter  mFuelAdapter = null;
	
	private long mMyPoint;
	private String  mCanUsePoint ="";
	private Boolean bFirstPointList= false;
	private Boolean bFirstFuelList= true;
	View footer ;
	private View helpBtnEval;
	
	private String from_date_str;
	private String to_date_str;
	private GregorianCalendar calFrom; 
	private GregorianCalendar calTo; 
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.point); 
		appHelper = new GSAppHelper(this, R.string.TITLE_TYPE_POINT, R.id.help_button);
		
		appHelper.add(findViewById(R.id.btn_point_present),R.drawable.guide_guide03_ex01,GSAppHelper.POSITION_LEFT_TOP);
		appHelper.add(findViewById(R.id.help_point_gigan ),R.drawable.guide_guide03_ex02,GSAppHelper.POSITION_LEFT_TOP,-10,0,-10);

		fi = new FileInfo();
		
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
		m_bLogin = extras.getBoolean("login");
		
//		new TitleView(this, true, true, R.string.TITLE_TYPE_POINT,m_bLogin);	
		new TitleView(this, true, true, true, R.string.TITLE_TYPE_POINT,m_bLogin);	
		new NewMainMenu(this);
		
		PointListview = (ListView)findViewById(R.id.PointListview);
		PointListview.setOnTouchListener(this);
		changeAdapters(true);
		
		mPointAdapter= new MyPointListAdapter(this);
		mFuelAdapter= new MyFuelListAdapter(this);
		
		// Footer ��
		footer = getLayoutInflater().inflate(R.layout.point_footerview, null, false) ;
		mMore10 = (ImageButton)footer.findViewById(R.id.btn_more10) ;
		mMore10.setOnClickListener(this) ;
		
		mTop = (ImageButton)footer.findViewById(R.id.btn_top) ;
		mTop.setOnClickListener(this) ;
		
		PointListview.addFooterView(footer) ;			
		footer.setVisibility(View.INVISIBLE) ;
				
		mPresent = (ImageButton)findViewById(R.id.btn_point_present);
		mPresent.setId(0);
		mPresent.setOnClickListener(this);
			
		mTabButtons[0] = (ImageButton)findViewById(R.id.tab_01);
		mTabButtons[0].setId(1);
		mTabButtons[0].setOnClickListener(this);
		
		mTabButtons[1] = (ImageButton)findViewById(R.id.tab_02);
		mTabButtons[1].setId(2);
		mTabButtons[1].setOnClickListener(this);
		
		usePoint=(TextView)findViewById(R.id.txt_canUsePoint);
		vanishPoint=(TextView)findViewById(R.id.txt_vanishPoint);
			
		fromDate=(TextView)findViewById(R.id.txt_frm_date);
		fromDate.setOnClickListener(this);
		fromDate.setId(3);
		
		toDate=(TextView)findViewById(R.id.txt_to_date);
		toDate.setOnClickListener(this);
		toDate.setId(4);
		
		mSearch= (ImageButton)findViewById(R.id.btn_search);
		mSearch.setOnClickListener(this);
		
		mScroll = (ScrollView)findViewById(R.id.scroll_point);
		
		SimpleDateFormat dateFormat = new SimpleDateFormat("yyyyMMdd");
		
		calFrom= new GregorianCalendar(); 
		calTo = new GregorianCalendar(); 
		calFrom.add(GregorianCalendar.MONTH,-3);
		calFrom.add(GregorianCalendar.DAY_OF_MONTH,1);
		calTo.add(GregorianCalendar.MONTH, 0);
		
		from_date_str=dateFormat.format(calFrom.getTime());
		to_date_str=dateFormat.format(calTo.getTime());
		
		fromDate.setText("  "+from_date_str);
		toDate.setText("  "+to_date_str);
		
		bFirstPointList= true;
		setTabpageIndex();
		getMyPoint();	
		findViewById(R.id.help_button).setOnClickListener(null);
		findViewById(R.id.help_button).setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View v) {
				mScroll.post(new Runnable() {
				      public void run() {
				    	//mScroll.scrollTo(0, 0);
						View itemView=(View)PointListview.getChildAt(0);
						if ( helpBtnEval != null ) appHelper.remove(helpBtnEval);
						if ( itemView != null ) {
							helpBtnEval = itemView.findViewById(0);
							if ( helpBtnEval != null ) appHelper.add(helpBtnEval,R.drawable.guide_guide03_ex03,GSAppHelper.POSITION_LEFT_TOP);
						}				    	  
						Point.this.getAppHelper().showHelp();				    	  
				      }
				  });
			}
		});
	}
	
	protected Dialog onCreateDialog(int id){
		switch(id){
		case FROM_DATE_DIALOG_ID:
			return new DatePickerDialog(this,mDateSetListener,calFrom.get(Calendar.YEAR),
							calFrom.get(Calendar.MONTH),calFrom.get(Calendar.DAY_OF_MONTH));
		case TO_DATE_DIALOG_ID:
			return new DatePickerDialog(this,mDateSetListener,calTo.get(Calendar.YEAR),
					calTo.get(Calendar.MONTH),calTo.get(Calendar.DAY_OF_MONTH));
		}
		return null;
	}
	private void setTabpageIndex() {
		for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
			mTabButtons[i].setBackgroundResource(TAB_BUTTON_OFF_RESOURCE_IDS[i]);
		}	
		mTabButtons[nSelectTab].setBackgroundResource(TAB_BUTTON_ON_RESOURCE_IDS[nSelectTab]);
	}
	
	private void changeAdapters(boolean key){
		if(key){		
			PointListview.setAdapter(mPointAdapter);
		}
		else{	
			PointListview.setAdapter(mFuelAdapter);
		}
		PointListview.invalidate();
	}
		
	private void getMyPoint() {
			
		String id ="" , pwd = "", point_url = "", open_url = "", key = "";
		mApp = (DefaultApplication)getApplicationContext() ;
		
		List <String> loginInfo = mApp.getLoginInfo() ;
		if(loginInfo.size() > 0) {
			try {
				 
				id = loginInfo.get(0) ;
				pwd = loginInfo.get(1) ;
				point_url = loginInfo.get(2) ;
				open_url = loginInfo.get(3) ;
				key = loginInfo.get(4) ;
				 
			} catch(Exception e) { 
			}
		}
		
		if(m_bLogin==false){
			
			Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.Login.class);		
			intent.putExtra("point", "point");
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			mApp.selectedIndex=1;
			startActivity(intent);
			finish();
		}
		else {
			if(mApp.getCardRefresh()) {
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
			}else{
				usePoint.setText(fi.getSettingInfo(this, FileInfo.CAN_USE_POINT));
				vanishPoint.setText(fi.getSettingInfo(this, FileInfo.VANISH_POINT));
				handler.post(getPointList);
			}
		}
	}
	
	private void getPointList() {
		
		if(bFirstPointList)
			bFirstPointList= false;
		
		footer.setVisibility(View.INVISIBLE) ;
		showCenterProgress();
		changeAdapters(true);
		mPointAdapter.setNextPage();
		
			Thread r = new Thread(new Runnable() {
				public void run() {
	
					String cuskey2 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_2);
	
					List<NameValuePair> params = new ArrayList<NameValuePair>(2);
					params.add(new BasicNameValuePair("process_code", "pointCheckList"));
					params.add(new BasicNameValuePair("page", String.valueOf(mPointAdapter.getPage())));
					params.add(new BasicNameValuePair("cuskey2", cuskey2));
					params.add(new BasicNameValuePair("from_date", from_date_str));
					params.add(new BasicNameValuePair("to_date", to_date_str));
								
					setParams(params);
					loadUrl(R.string.mypointchecklist_name, Util.DATA_CONNECT,"") ;
				}
			});
			r.start();
	}
	
	private void getRefuelList() {
		
		if(bFirstFuelList)
			bFirstFuelList= false;
		
		footer.setVisibility(View.INVISIBLE) ;
		showCenterProgress();
		changeAdapters(false);
		mFuelAdapter.setNextPage();
		Thread r = new Thread(new Runnable() {
			public void run() {

				String cuskey2 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_2);
				
				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				params.add(new BasicNameValuePair("process_code", "refuelCheckList"));
				params.add(new BasicNameValuePair("page", String.valueOf(mFuelAdapter.getPage())));
				params.add(new BasicNameValuePair("cuskey2", cuskey2));
				params.add(new BasicNameValuePair("from_date", from_date_str));
				params.add(new BasicNameValuePair("to_date", to_date_str));
							
				setParams(params);
				loadUrl(POINT_GET_REFUEL_CHECKLIST, Util.DATA_CONNECT,"") ;
			}
		});
		r.start();
	}
	
	private void getPointGiveCheck(){
		showCenterProgress();
		Thread r = new Thread(new Runnable() {
			public void run() {

				String userID = fi.getSettingInfo(getBaseContext(), FileInfo.ID);
				String userPW = fi.getSettingInfo(getBaseContext(), FileInfo.PWD);
				
				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				params.add(new BasicNameValuePair("process_code", "pointGiveCheck"));
				params.add(new BasicNameValuePair("userid", userID));
				params.add(new BasicNameValuePair("userpw", userPW));
				
				setParams(params);
				loadUrl(POINT_GIVE_CHECK, Util.DATA_CONNECT,"") ;
			}
		});
		r.start();
	}
	public void onClick(View v) {
		// TODO Auto-generated method stub
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  
		
		switch (v.getId()) {
		case 0 : 	// present button		
			getPointGiveCheck();
			/*
			Intent intent = new Intent(this, PointPresent.class);
			intent.putExtra("login", m_bLogin);
			intent.putExtra("canUsePoint", mMyPoint) ;
  			//startActivity(intent);
			startActivityForResult(intent,POINT_PRESENT_END);
  			*/
  			
	         break;
		case 1 : 
			footer.setVisibility(View.INVISIBLE) ;
			if(!bFirstPointList){
				nSelectTab=0;
				setTabpageIndex();
				changeAdapters(true);
			}else{
				nSelectTab=0;
				setTabpageIndex();
				mPointAdapter.setPage(0);
				mPointAdapter.clearItem();
				changeAdapters(true);
				getPointList();
			}
			
			break;	
		case 2 : 
			footer.setVisibility(View.INVISIBLE) ;
			if(!bFirstFuelList){
				nSelectTab=1;
				setTabpageIndex();
				changeAdapters(false);
			}else{
				nSelectTab=1;
				setTabpageIndex();
				mFuelAdapter.setPage(0);
				mFuelAdapter.clearItem();
				changeAdapters(false);
				getRefuelList();
			}
			break;	
			
		case 3 : 
			showDialog(FROM_DATE_DIALOG_ID);
			break;
		case 4 : 				
			showDialog(TO_DATE_DIALOG_ID);
			break;	
		
		case R.id.btn_search :
			String tmp_from = fromDate.getText().toString();
			String tmp_to = toDate.getText().toString();
			
			tmp_from = tmp_from.trim();
			tmp_to = tmp_to.trim();
			
			if(tmp_from==null||tmp_from.equals("")||tmp_from.length()<8||tmp_to==null||tmp_to.equals("")||tmp_to.length()<8){
				//alert(R.string.alert_str_date);
				alt_bld.setMessage(R.string.alert_str_date)  
		    	.setCancelable(false)  
		    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
					public void onClick(DialogInterface dialog, int which) {
					}
		    	});
				showAlertDialog(alt_bld);
			}else{			
				if(checkBetween(tmp_from, tmp_to)){
					
					GregorianCalendar cal = new GregorianCalendar();
					GregorianCalendar tocal = new GregorianCalendar();
					cal.add(GregorianCalendar.MONTH,-3);
					tocal.add(GregorianCalendar.MONTH,0);
					
					SimpleDateFormat dateFormat = new SimpleDateFormat("yyyyMMdd");
					
					long diff1= calFrom.getTimeInMillis()-cal.getTimeInMillis();
					long diffDays1 = diff1 / (24 * 60 * 60 * 1000);		
					    
					long diff2= calTo.getTimeInMillis()-tocal.getTimeInMillis();
					long diffDays2 = diff2 / (24 * 60 * 60 * 1000);	
										
					if(diffDays1<0){
						alt_bld.setMessage(R.string.alert_str_searchrange_error3)  
				    	.setCancelable(false)  
				    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
							public void onClick(DialogInterface dialog, int which) {
							}
				    	});
						showAlertDialog(alt_bld);
						
						calFrom.set(Calendar.YEAR, cal.get(Calendar.YEAR));
						calFrom.set(Calendar.MONTH, cal.get(Calendar.MONTH));
						calFrom.set(Calendar.DAY_OF_MONTH, cal.get(Calendar.DAY_OF_MONTH));
						
						from_date_str=dateFormat.format(calFrom.getTime());
						fromDate.setText("  "+from_date_str);
						
					}else if(diffDays2>0){
						alt_bld.setMessage(R.string.alert_str_searchrange_error3)  
				    	.setCancelable(false)  
				    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
							public void onClick(DialogInterface dialog, int which) {
							}
				    	});
						showAlertDialog(alt_bld);
						
						calTo.set(Calendar.YEAR, tocal.get(Calendar.YEAR));
						calTo.set(Calendar.MONTH, tocal.get(Calendar.MONTH));
						calTo.set(Calendar.DAY_OF_MONTH, tocal.get(Calendar.DAY_OF_MONTH));
						
						to_date_str=dateFormat.format(calTo.getTime());
						toDate.setText("  "+to_date_str);
						
					}else{
						bFirstPointList= true;
						bFirstFuelList= true;
						// TODO
						if(nSelectTab==0){
							mPointAdapter.setPage(0);
							mPointAdapter.clearItem();
							getPointList();
						}
						else{
							mFuelAdapter.setPage(0);
							mFuelAdapter.clearItem();
							getRefuelList();
						}					
						from_date_str=tmp_from;
						to_date_str=tmp_to;							
					}
				}else{
					//alert(R.string.alert_str_month);
					alt_bld.setMessage(R.string.alert_str_searchrange_error3)  
			    	.setCancelable(false)  
			    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
						public void onClick(DialogInterface dialog, int which) {
						}
			    	});
					showAlertDialog(alt_bld);
				}
			}
			break;
			
		case R.id.btn_more10:
			if(nSelectTab==0){
				getPointList();
				PointListview.setSelectionFromTop(0+10*(mPointAdapter.getPage()-1), 0);
			}
			else{
				getRefuelList();
				PointListview.setSelectionFromTop(0+10*(mFuelAdapter.getPage()-1), 0);
			}	
			break;
			
		case R.id.btn_top:	
			PointListview.setSelectionFromTop(0, 0);
			break;
			
			
		}
		nSelectClickID= v.getId();
	}
	
	@Override
	protected void onDestroy() { 
		super.onDestroy(); 
		
	}
	
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		//Debug.trace(TAG, "httpResult" + "[" + what + "](" + result + ")") ;
		
		switch(what) {
		case R.string.point_name :
			SetMyPoint();
			break ;
		
		case R.string.mypointchecklist_name :
			SetMyPointChecklist();
			break;
			
		case POINT_GET_REFUEL_CHECKLIST :
			SetMyRefuelChecklist();
			break;
			
		case POINT_GIVE_CHECK:
			SetMyPointGiveCheck();
			break;
			
		}
	}
	
	private void SetMyPoint(){
		String str = getString();
		//Debug.trace("TEXT",str);
		str = str.trim();

		try {
				DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
				DocumentBuilder builder = factory.newDocumentBuilder();
				InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
				Document doc = builder.parse(istream);
	
				Element order = doc.getDocumentElement();
				NodeList result_items = order.getElementsByTagName("result");
				Node result_item = result_items.item(0);
				Node result_text = result_item.getFirstChild();
				
				NodeList error_items = order.getElementsByTagName("err");
				Node error_item;
				Node error_text=null;
		
				result_tag = result_text.getNodeValue();
				if(result_tag.equals("0")){
					error_item = error_items.item(0);
					error_text = error_item.getFirstChild();
					String msg;
				
					if( error_text.getNodeValue() == null ){
						msg = Util.NOT_FOUND_RESULT;
						Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
					}else{
						msg = error_text.getNodeValue();
						Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
					}															
				}else if(result_tag.equals("1")){				
					Node use_item = order.getElementsByTagName("canUsePoint").item(0);
					Node vanish_item = order.getElementsByTagName("vanishPoint").item(0);								
					Node give_item = order.getElementsByTagName("canGivePoint").item(0);
					
					String temp_vanish="";
					
					if(give_item!=null && give_item.getFirstChild()!=null)
						mMyPoint = Long.valueOf(give_item.getFirstChild().getNodeValue());
					else
						mMyPoint=0;
					
					if(use_item!=null && use_item.getFirstChild()!=null)
						mCanUsePoint = makeStringComma(use_item.getFirstChild().getNodeValue());
					else
						mCanUsePoint="";
					
					if(vanish_item!=null && vanish_item.getFirstChild()!=null)
						temp_vanish = makeStringComma(vanish_item.getFirstChild().getNodeValue());
										
					usePoint.setText(mCanUsePoint);
					vanishPoint.setText(temp_vanish);									
				}
		}
		catch (Exception e) {
			e.printStackTrace();
		}			
	
		handler.post(getPointList);
	}
	
	private Runnable getPointList = new Runnable(){
		
		public void run() {
			getPointList();
		}		
	};

	private Runnable getRefuelList = new Runnable(){
		
		public void run() {
			getRefuelList();
		}		
	};
	
	private void SetMyPointChecklist(){
		
		String str = getString();
		//Debug.trace("TEXT",str);
		str = str.trim();

		try {
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();
			InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
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
				//finish();
			}else if(result_tag.equals(Util.SERVER_GO_STATUS)){					
				//goErrorUrl();						
				mPointAdapter.setReadAll(false);
				mPointAdapter.setPrevPage();
			}else if(result_tag.equals("0")){
				error_item = error_items.item(0);
				error_text = error_item.getFirstChild();
				String msg;
				
				if( error_text.getNodeValue() == null ){
					msg = Util.NOT_FOUND_RESULT;
				}else{
					msg = error_text.getNodeValue();
				}								
				mPointAdapter.setReadAll(true);						
			}else if(result_tag.equals("1")){
				
				NodeList date_items = order.getElementsByTagName("date");
				NodeList amount_items = order.getElementsByTagName("amount");
				NodeList point_items = order.getElementsByTagName("point");	
				NodeList store_items = order.getElementsByTagName("store");	
				//NodeList content_items = order.getElementsByTagName("content");	
				
				NodeList orderno_items = order.getElementsByTagName("orderNo");	
				NodeList frchcd_items = order.getElementsByTagName("storeCd");	
				NodeList ccocd_items = order.getElementsByTagName("ccoCd");	
				
				//Debug.trace("TEXT","date_items.getLength()is "+date_items.getLength());
				for(int i = 0; i < date_items.getLength();i++ )
				{		
					Node date_item = date_items.item(i);
					Node amount_item = amount_items.item(i);
					Node point_item = point_items.item(i);
					Node store_item = store_items.item(i);
					//Node content_item = content_items.item(i);
					
					Node orderno_item = orderno_items.item(i);
					Node frchcd_item = frchcd_items.item(i);
					Node ccocd_item = ccocd_items.item(i);
					
																	
					String Date = date_item.getFirstChild().getNodeValue();
					String Amount = amount_item.getFirstChild().getNodeValue();	
					//String Point = point_item.getFirstChild().getNodeValue();
					String Store = store_item.getFirstChild().getNodeValue();
					//String content = content_item.getFirstChild().getNodeValue();
					
					String content="";
					String Point ="";
					
					long point = Long.valueOf(point_item.getFirstChild().getNodeValue());
					if(point<0){	
						String temp = point_item.getFirstChild().getNodeValue();
						Point= makeStringComma(temp.substring(1));
						content="02";
					}
					else{
						Point= makeStringComma(point_item.getFirstChild().getNodeValue());
						content="01";
					}
					
					mPointAdapter.addItem(new MyPointListTextItem(Date,
							Amount ,Point , Store, content,
							orderno_item.getFirstChild().getNodeValue(),
							frchcd_item.getFirstChild().getNodeValue(),
							ccocd_item.getFirstChild().getNodeValue()));
				}						
				mPointAdapter.notifyDataSetChanged();	
				
				if(date_items.getLength()<=10){
					footer.setVisibility(View.INVISIBLE) ;
				}else
					footer.setVisibility(View.VISIBLE) ;
			}
		}
		catch (Exception e) {
			e.printStackTrace();
		}
		//handler.post(getRefuelList);
		hideCenterProgress();
		
	}
	
	private void SetMyRefuelChecklist(){
		
		String str = getString();
		//Debug.trace("TEXT",str);
		str = str.trim();

		try {
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();
			InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
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
				
			}else if(result_tag.equals(Util.SERVER_GO_STATUS)){					
							
				mFuelAdapter.setReadAll(false);
				mFuelAdapter.setPrevPage();
			}else if(result_tag.equals("0")){
				error_item = error_items.item(0);
				error_text = error_item.getFirstChild();
				String msg;
				
				if( error_text.getNodeValue() == null ){
					msg = Util.NOT_FOUND_RESULT;
				}else{
					msg = error_text.getNodeValue();
				}								
				//mCurrentAdapter.setReadAll(true);						
			}else if(result_tag.equals("1")){
				NodeList date_items = order.getElementsByTagName("saleDateTime");
				NodeList product_items = order.getElementsByTagName("productGroupName");
				NodeList quantity_items = order.getElementsByTagName("quantity");
				NodeList amount_items = order.getElementsByTagName("amount");
				NodeList store_items = order.getElementsByTagName("frchName");	
				
				if( date_items.getLength() > 0)
				{
					for(int i = 0; i < date_items.getLength();i++ )
					{						
						Node date_item = date_items.item(i);
						Node product_item = product_items.item(i);
						Node quantity_item = quantity_items.item(i);
						Node amount_item = amount_items.item(i);
						Node store_item = store_items.item(i);
				
						String Date = date_item.getFirstChild().getNodeValue();
						String Product = product_item.getFirstChild().getNodeValue();	
						String Quantity = quantity_item.getFirstChild().getNodeValue();
						//String Amount = amount_item.getFirstChild().getNodeValue();
						String Store = store_item.getFirstChild().getNodeValue();
						
						String Amount = makeStringComma(amount_item.getFirstChild().getNodeValue());
						
						String Info = "유종:"+Product+" 주유량:"+Quantity+"L"+" 금액:"+Amount+"원";
						mFuelAdapter.addItem(new MyPointListTextItem(Date,
								Info ,Store , "", "","","",""));
					}						
					mFuelAdapter.notifyDataSetChanged();	
					
					if(date_items.getLength()<10){
						footer.setVisibility(View.INVISIBLE) ;
					}else
						footer.setVisibility(View.VISIBLE) ;
				}
			}
		} 
		catch (Exception e) {
			e.printStackTrace();
		}		
		hideCenterProgress();	
	}
	
	private void SetMyPointGiveCheck(){
		
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  
		
		String str = getString();
		//Debug.trace("TEXT",str);
		str = str.trim();

		try {
			DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
			DocumentBuilder builder = factory.newDocumentBuilder();
			InputStream istream = new ByteArrayInputStream(str.getBytes("utf-8"));
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
				//handler.post(viewToastRunnable);
				finish();
			}else if(result_tag.equals(Util.SERVER_GO_STATUS)){					
				goErrorUrl();						
			}else if(result_tag.equals("0")){
				error_item = error_items.item(0);
				error_text = error_item.getFirstChild();
				String msg;
				
				if( error_text.getNodeValue() == null ){
					msg = Util.NOT_FOUND_RESULT;
					Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
				}else{
					msg = error_text.getNodeValue();
					Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
				}								
				//mCurrentAdapter.setReadAll(true);						
			}else if(result_tag.equals("1")){
				NodeList give_items = order.getElementsByTagName("giveYn");
								
				if( give_items.getLength() > 0)
				{
										
						Node give_item = give_items.item(0);
									
						String bGive = give_item.getFirstChild().getNodeValue();
						
						if(bGive.equals("Y")){
							Intent intent = new Intent(this, PointPresent.class);
							intent.putExtra("login", m_bLogin);
							intent.putExtra("canGivePoint", mMyPoint) ;
							intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
							startActivityForResult(intent,POINT_PRESENT_END);
				  			
						}else{
							alt_bld.setMessage(R.string.alert_str_point_give_error)  
					    	.setCancelable(false)  
					    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
								public void onClick(DialogInterface dialog, int which) {
								}
					    	});
							showAlertDialog(alt_bld);	
						}
							
				}
			}
		} 
		catch (Exception e) {
			e.printStackTrace();
		}		
		hideCenterProgress();	
	}
	
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {		
		if(resultCode != RESULT_OK){
			if(data !=null){
			}
			return;
		}
		
		switch(requestCode){
		case POINT_PRESENT_END:
			Intent intent = new Intent(this, Point.class);
			intent.putExtra("login", m_bLogin);	
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);
			
			this.finish();
			break;	
		}	   
	}
	
	private DatePickerDialog.OnDateSetListener mDateSetListener =
			new DatePickerDialog.OnDateSetListener() {
				
		SimpleDateFormat dateFormat = new SimpleDateFormat("yyyyMMdd");
				public void onDateSet(DatePicker view, int year, int monthOfYear,
						int dayOfMonth) {
					if(nSelectClickID==3){
						calFrom.set(Calendar.YEAR, year);
						calFrom.set(Calendar.MONTH, monthOfYear);
						calFrom.set(Calendar.DAY_OF_MONTH, dayOfMonth);
						
						from_date_str=dateFormat.format(calFrom.getTime());
						fromDate.setText("  "+from_date_str);					
					}else if(nSelectClickID==4){
						calTo.set(Calendar.YEAR, year);
						calTo.set(Calendar.MONTH, monthOfYear);
						calTo.set(Calendar.DAY_OF_MONTH, dayOfMonth);
						
						to_date_str=dateFormat.format(calTo.getTime());
						toDate.setText("  "+to_date_str);
					}
				}
			};
				
	private boolean checkBetween(String from, String to){
		try{
			SimpleDateFormat formatter = new SimpleDateFormat("yyyyMMdd");
		    
		    long diff= calTo.getTimeInMillis()-calFrom.getTimeInMillis();
		    long diffDays = diff / (24 * 60 * 60 * 1000);		
			
		    if((diffDays<=92)&&(diffDays>=0)){
		    	return true;
		    }else{
		    	return false;
		    }
		}catch(Exception e){
			return false;
		}
	}
	private String makeStringComma(String str){
		if(str.length()==0)
			return "";
		long value = Long.parseLong(str);
		DecimalFormat format = new DecimalFormat("###,###");
		
		return format.format(value);
	}

	private void showAlertDialog(AlertDialog.Builder bld ){
    	AlertDialog alert = bld.create();  
    	alert.setTitle(R.string.alert_str);
    	alert.show(); 
    }
	
	public boolean onTouch(View v, MotionEvent event) {
		// TODO Auto-generated method stub
		mScroll.requestDisallowInterceptTouchEvent(true);
		return false;
	}
}

