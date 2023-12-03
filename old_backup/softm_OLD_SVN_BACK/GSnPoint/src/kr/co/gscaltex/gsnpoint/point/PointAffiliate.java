package kr.co.gscaltex.gsnpoint.point;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.SpinnerGS;
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

import android.os.Bundle;
import android.os.Handler;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.ScrollView;
import android.widget.TextView;
import android.widget.Toast;

public class PointAffiliate extends BaseActivity implements OnClickListener, OnTouchListener{
	String TAG = "PointPresentS";
	
	DefaultApplication mApp ;
	private FileInfo fi = new FileInfo();
	private Handler handler = new Handler();
	
	private String[] StarType={" 평점을 주세요", " ★★★★★", " ★★★★☆", " ★★★☆☆", " ★★☆☆☆", " ★☆☆☆☆"," ☆☆☆☆☆"};
	private String mOrderno, mFrchcd, mCcocd= null;
	private ListView evalListview;
	private EditText mComment;
	private TextView mFrchName, mTphnNum, mAddr, mService,mTotal;
	private SpinnerGS mSpnStarType = null;
	private ImageButton mEval, mMore10, mTop = null;
	
	private ScrollView mScroll = null;
	
	View footer ;
	
	private PointAffiliateListAdapter  mCurrentAdapter = null;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.pointaffiliate); 
		
		Bundle extras = getIntent().getExtras();
		if(extras!=null){
			mOrderno = extras.getString("orderNo");
			mFrchcd = extras.getString("frchCd");
			mCcocd = extras.getString("ccoCd");
		}
		new TitleView(this, true, true, R.string.TITLE_TYPE_POINT_PRESENT,true);	
		new NewMainMenu(this);
		
		mScroll = (ScrollView)findViewById(R.id.scroll_affil);
		
		evalListview = (ListView)findViewById(R.id.affilListview);
		evalListview.setOnTouchListener(this);
		
		mCurrentAdapter = new PointAffiliateListAdapter(this);
		evalListview.setAdapter(mCurrentAdapter);
		evalListview.invalidate();
		
		// Footer ��
		footer = getLayoutInflater().inflate(R.layout.point_footerview, null, false) ;
		mMore10 = (ImageButton)footer.findViewById(R.id.btn_more10) ;
		mMore10.setOnClickListener(this) ;
		
		mTop = (ImageButton)footer.findViewById(R.id.btn_top) ;
		mTop.setOnClickListener(this) ;
		
		evalListview.addFooterView(footer) ;			
		footer.setVisibility(View.INVISIBLE) ;
				
		mFrchName= (TextView)findViewById(R.id.txt_fch_name);
		mTphnNum= (TextView)findViewById(R.id.txt_tphn_num);
		mAddr= (TextView)findViewById(R.id.txt_zip_addr);
		mService= (TextView)findViewById(R.id.txt_service);
		mTotal= (TextView)findViewById(R.id.txt_total);
		
		mComment = (EditText)findViewById(R.id.edit_comment);
		
		mEval = (ImageButton)findViewById(R.id.btn_eval);
		mEval.setOnClickListener(this);
		
		mSpnStarType= (SpinnerGS)findViewById(R.id.spn_startype);
		mSpnStarType.addItems(StarType);
		  
		mSpnStarType.setOnItemSelectedListener(new OnItemSelectedListener() {
						public void onItemSelected(AdapterView<?> parent, View v, int position, long id) {
							if(position !=0){
								mComment.setFocusable(true);
								mComment.setCursorVisible(true);
							}		
						}
						public void onNothingSelected(AdapterView<?> parent) {			
						}
					});
		getStoreDetail();	
	}
	
	private void getStoreDetail() {	
		showCenterProgress();
		
			Thread r = new Thread(new Runnable() {
				public void run() {
	
					List<NameValuePair> params = new ArrayList<NameValuePair>(2);
					params.add(new BasicNameValuePair("process_code", "storeDetail"));
					params.add(new BasicNameValuePair("cco_cd", mCcocd));
					params.add(new BasicNameValuePair("frch_cd", mFrchcd));
				
					setParams(params);
					loadUrl(R.string.store_name, Util.DATA_CONNECT,"") ;
				}
			});
			r.start();
	}
	
	private void getStoreEvalList(){
		footer.setVisibility(View.INVISIBLE) ;
		showCenterProgress();
		
			Thread r = new Thread(new Runnable() {
				public void run() {
			
					List<NameValuePair> params = new ArrayList<NameValuePair>(2);
					params.add(new BasicNameValuePair("process_code", "storeEvalList"));
					params.add(new BasicNameValuePair("cco_cd", mCcocd));
					params.add(new BasicNameValuePair("frch_cd", mFrchcd));			
					setParams(params);
					loadUrl(R.string.storevaluelist_name, Util.DATA_CONNECT,"") ;
				}
			});
			r.start();
	}
	
	private void SendComment(){
		showCenterProgress();
		
		Thread r = new Thread(new Runnable() {
			public void run() {
		
				String userid = fi.getSettingInfo(getBaseContext(), FileInfo.ID);
				
				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				params.add(new BasicNameValuePair("process_code", "storeValue"));
				params.add(new BasicNameValuePair("userid", userid));
				params.add(new BasicNameValuePair("cco_cd", mCcocd));		
				params.add(new BasicNameValuePair("frch_cd", mFrchcd));		
				params.add(new BasicNameValuePair("line_eval", mComment.getText().toString()));
				params.add(new BasicNameValuePair("star_point", getStarPoint()));
				params.add(new BasicNameValuePair("order_no", mOrderno));
				setParams(params);
				loadUrl(R.string.evalue_name, Util.DATA_CONNECT,"") ;
			}
		});
		r.start();
	}
	private void SetStoreDetail(){
		
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
									
			}else if(result_tag.equals("1")){
				
				NodeList frch_nm_items = order.getElementsByTagName("frch_nm");
				NodeList tphn_items = order.getElementsByTagName("tphn_no");
				NodeList zip_addr_items = order.getElementsByTagName("zip_addr");	
				NodeList service_items = order.getElementsByTagName("bnfit");	
				
				Node frch_nm_item = frch_nm_items.item(0);
				Node tphn_item = tphn_items.item(0);
				Node zip_addr_item = zip_addr_items.item(0);
				Node service_item = service_items.item(0);
																
				if(frch_nm_item!=null && frch_nm_item.getFirstChild()!=null){
					mFrchName.setText(String.valueOf(frch_nm_item.getFirstChild().getNodeValue())); 
				}else
					mFrchName.setText(String.valueOf("")); 
				
				if(tphn_item!=null && tphn_item.getFirstChild()!=null){
					mTphnNum.setText(String.valueOf(tphn_item.getFirstChild().getNodeValue())); 
				}else
					mTphnNum.setText(String.valueOf("")); 
				
				if(zip_addr_item!=null && zip_addr_item.getFirstChild()!=null){
					mAddr.setText(String.valueOf(zip_addr_item.getFirstChild().getNodeValue())); 
				}else
					mAddr.setText(String.valueOf("")); 
				
				if(service_item!=null && service_item.getFirstChild()!=null){
					mService.setText(String.valueOf(service_item.getFirstChild().getNodeValue())); 
				}else
					mService.setText(String.valueOf("")); 																				
			}
		}
		catch (Exception e) {
			e.printStackTrace();
		}
		hideCenterProgress();
		handler.post(getStoreEval);
	}
	
	private void SetStoreEvalueList(){
		
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
				handler.post(viewToastRunnable);
				finish();
			}else if(result_tag.equals(Util.SERVER_GO_STATUS)){					
				goErrorUrl();						
				mCurrentAdapter.setReadAll(false);
				mCurrentAdapter.setPrevPage();
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
				mCurrentAdapter.setReadAll(true);						
			}else if(result_tag.equals("1")){
				NodeList userid_items = order.getElementsByTagName("user_id");
				NodeList date_items = order.getElementsByTagName("dis_reg_dtime");
				NodeList eval_items = order.getElementsByTagName("line_eval");		
				NodeList star_items = order.getElementsByTagName("star_point");		
			
				mTotal.setText(String.valueOf(userid_items.getLength()));
				if( userid_items.getLength() > 0)
				{
					for(int i = 0; i < userid_items.getLength();i++ )
					{						
						Node userid_item = userid_items.item(i);
						Node date_item = date_items.item(i);
						Node eval_item = eval_items.item(i);		
						Node star_item = star_items.item(i);	
						
						String userID = userid_item.getFirstChild().getNodeValue();
						String Date = date_item.getFirstChild().getNodeValue();
						String Eval="";
						if(eval_item!=null && eval_item.getFirstChild()!=null){
						 Eval = eval_item.getFirstChild().getNodeValue();	
						}
					
						String Star = star_item.getFirstChild().getNodeValue();	
				
						mCurrentAdapter.addItem(new PointAffiliateListTextItem(userID,
														Date ,Eval , Star));
					}						
					mCurrentAdapter.notifyDataSetChanged();	
					
					if(userid_items.getLength()<10){
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
	
	private void StoreEvalResult(){
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
				handler.post(viewToastRunnable);
				finish();
			}else if(result_tag.equals(Util.SERVER_GO_STATUS)){					
				goErrorUrl();						
				mCurrentAdapter.setReadAll(false);
				mCurrentAdapter.setPrevPage();
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
				mCurrentAdapter.setReadAll(true);						
			}else if(result_tag.equals("1")){
				//handler.post(getRefresh);
				finish();
			}
		}
		catch (Exception e) {
			e.printStackTrace();
		}				
		hideCenterProgress();
	}
	private Runnable getStoreEval = new Runnable(){
		
		public void run() {
			getStoreEvalList();
		}		
	};
	
	private Runnable getRefresh = new Runnable(){
		
		public void run() {
			mCurrentAdapter.clearItem();
			getStoreEvalList();
		}		
	};
	
	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch (v.getId()) {
		case R.id.btn_eval : 	// cancel button
			
			if(mSpnStarType.getSelectedItemPosition()==0){
				showAlert(R.string.mypoint_aff_select_startpoint);
			}else{
				SendComment();
			}
	         break;
		}
	}
	
	private String getStarPoint(){
		String point = "";
		int position = mSpnStarType.getSelectedItemPosition();
		
		if(position==1)
			point="5";
		else if(position==2)
			point="4";
		else if(position==3)
			point="3";
		else if(position==4)
			point="2";
		else if(position==5)
			point="1";
		else if(position==6)
			point="0";
		
		return point;
	}
	
	@Override
	protected void onDestroy() { 
		super.onDestroy(); 
	}
	
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		//Debug.trace(TAG, "httpResult" + "[" + what + "](" + result + ")") ;
		
		switch(what) {
		case R.string.store_name :
			SetStoreDetail();
			break ;
		case R.string.storevaluelist_name:
			SetStoreEvalueList();
			break ;
			
		case R.string.evalue_name:
			StoreEvalResult();
			break;
		}
	}

	public boolean onTouch(View arg0, MotionEvent arg1) {
		// TODO Auto-generated method stub
		mScroll.requestDisallowInterceptTouchEvent(true);
		return false;
	}
}

