package kr.co.gscaltex.gsnpoint.setting;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.Util;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

public class SettingNotice extends BaseActivity implements OnClickListener {
	private String TAG = "SettingNotice";
	
	private Handler handler = new Handler();
	private String URL = Util.DATA_CONNECT;
	private boolean NewResult = false;
		
	private boolean m_bLogin = false;
	
	private ListView noticeListview;
	private ImageButton  mPrevBtn, mNextBtn = null;
	private TextView mCurPage, mTotalPage = null;
	private SettingNoticeListAdapter  mCurrentAdapter = null;
	//ArrayList<SettingNoticeTextItem> list;
	
	private static int iTotalPage=0;
	
	private final int NOTICE_END= 100;	
	final static int NOTICE_GET_NOTICE_LIST = 41 ;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.settingnotice);
				
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this,true,false,R.string.TITLE_TYPE_SETTING_NOTICE,m_bLogin); 
		new NewMainMenu(this);
		
		noticeListview = (ListView)findViewById(R.id.noticeListview);
		
		mCurrentAdapter = new SettingNoticeListAdapter(this);
		noticeListview.setAdapter(mCurrentAdapter);
		noticeListview.invalidate();
	
		noticeListview.setOnItemClickListener(mItemClickListener);
		mPrevBtn = (ImageButton)findViewById(R.id.prev_btn);
		mNextBtn = (ImageButton)findViewById(R.id.next_btn);
		mCurPage = (TextView)findViewById(R.id.cur_page);
		mTotalPage = (TextView)findViewById(R.id.total_page);
		
		mPrevBtn.setId(0);
		mPrevBtn.setOnClickListener(this);
		
		mNextBtn.setId(1);
		mNextBtn.setOnClickListener(this);
		
		getNoiceList();			
	}
	
	private void getNoiceList() {
		//if( mCurrentAdapter.isReadAll() || mCurrentAdapter.isProcessing() )
		//	return;
		
		mCurrentAdapter.clearItem();
		showCenterProgress();
		
		mCurrentAdapter.startProcessing();
		mCurrentAdapter.setNextPage();
		mCurPage.setText(String.valueOf(mCurrentAdapter.getPage()));
		
		Thread r = new Thread(new Runnable() {
			public void run() {
				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				params.add(new BasicNameValuePair("process_code", "noticeList"));
				params.add(new BasicNameValuePair("page", String.valueOf(mCurrentAdapter.getPage())));
				setParams(params);
				
				loadUrl(NOTICE_GET_NOTICE_LIST, URL, "" ) ;
			}
		});
		r.start();
	}
	
	
	private AdapterView.OnItemClickListener mItemClickListener = new AdapterView.OnItemClickListener(){
		SettingNoticeTextItem mtemp= null;
		public void onItemClick(android.widget.AdapterView<?> arg0, View arg1, int arg2, long arg3) {								
			Intent intent = new Intent(SettingNotice.this, SettingNoticeDetailView.class);	
			mtemp= (SettingNoticeTextItem)mCurrentAdapter.getItem(arg2);			
			intent.putExtra("PK", mtemp.getmData()[3]);
			intent.putExtra("login", m_bLogin);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivityForResult(intent,NOTICE_END);
		};
	};
	
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {		
		if(resultCode != RESULT_OK){
			if(data !=null){
			}
			return;
		}
		
		switch(requestCode){
		case NOTICE_END:
			this.finish();
			break;	
		}	   
	}
	
	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch (v.getId()) {
		case 0 : 	//prev page button
			if(mCurrentAdapter.getPage()>1){
				int temp = mCurrentAdapter.getPage()-2;
				mCurrentAdapter.setPage(temp);
				getNoiceList();
			}
	         break;
		case 1 : 	//next page button
			if(mCurrentAdapter.getPage()!=iTotalPage){
				getNoiceList();
			}
			break;		
		}
	}
	
	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub		
		switch(what) {
		case NOTICE_GET_NOTICE_LIST :
			
			NewResult = result ;
			if(NewResult){			
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
					
					NodeList total_items = order.getElementsByTagName("total");
					Node total_item = total_items.item(0);
					//Node total_text=null;
					
						 //total_text = total_item.getFirstChild();
					
					NodeList error_items = order.getElementsByTagName("err");
					Node error_item;
					Node error_text=null;
					
					
					if(total_item!=null && total_item.getFirstChild()!=null){
						if((Integer.valueOf(total_item.getFirstChild().getNodeValue()))%5==0){
							iTotalPage = (Integer.valueOf(total_item.getFirstChild().getNodeValue()))/5;
						}else
							iTotalPage = (Integer.valueOf(total_item.getFirstChild().getNodeValue()))/5+1;
						
						mTotalPage.setText(String.valueOf(iTotalPage));
					}else
						mTotalPage.setText("0");
					
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
						//mCurrentAdapter.setReadAll(true);						
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
						
								mCurrentAdapter.addItem(new SettingNoticeTextItem(String.valueOf((i+1)+(mCurrentAdapter.getPage()-1)*5),
																Date ,Title , PK));
							}						
							mCurrentAdapter.notifyDataSetChanged();						
						}
					}
				}
				catch (Exception e) {
					e.printStackTrace();
				}			
			}
			else{
				Toast.makeText(this, "에러", Toast.LENGTH_SHORT).show();
		    }		
			hideCenterProgress();
			
			mCurrentAdapter.endProcessing();
			break ;
		}		
	}
}
