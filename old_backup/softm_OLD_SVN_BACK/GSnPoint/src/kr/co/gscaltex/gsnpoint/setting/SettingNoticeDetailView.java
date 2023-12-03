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
import kr.co.gscaltex.gsnpoint.card.CardMainView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.Util;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import android.content.Intent;
import android.os.Bundle;
import android.view.MotionEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.webkit.WebView;
import android.widget.ImageButton;
import android.widget.ScrollView;
import android.widget.TextView;
import android.widget.Toast;

public class SettingNoticeDetailView extends BaseActivity implements OnClickListener, OnTouchListener {
	private String TAG = "SettingNoticeDetailView";
	
	private boolean m_bLogin = false;
	
	private ImageButton mListBtn;
	private TextView date, title1, title2 = null;
	private String URL = Util.DATA_CONNECT;
	private String mPK = null;
	
	private ScrollView mScroll = null;
	
	private WebView content= null;
	final static int NOTICE_GET_NOTICE_DETAIL = 41 ;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.settingnoticedetail);
				
		Bundle extras = getIntent().getExtras();
		if(extras!=null){
			m_bLogin = extras.getBoolean("login");
			mPK = extras.getString("PK");
		}
		
		new TitleView(this,true,false,R.string.TITLE_TYPE_SETTING_NOTICE,m_bLogin); 
		new NewMainMenu(this);
		
		mScroll = (ScrollView)findViewById(R.id.scroll_noticedetail);
		
		mListBtn=(ImageButton)findViewById(R.id.notice_list);
		mListBtn.setId(0);
		mListBtn.setOnClickListener(this);
		
		date=(TextView)findViewById(R.id.text1);
		title1=(TextView)findViewById(R.id.text2);
		title2=(TextView)findViewById(R.id.text3);
	
		content=(WebView)findViewById(R.id.text4);
		content.setOnTouchListener(this);
		getNoiceDetail();	
	}
	
	private void getNoiceDetail() {
		
		showCenterProgress();
		
		Thread r = new Thread(new Runnable() {
			public void run() {
				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				params.add(new BasicNameValuePair("process_code", "noticeDetail"));
				params.add(new BasicNameValuePair("pk", mPK));
				setParams(params);
				
				loadUrl(NOTICE_GET_NOTICE_DETAIL, URL, "" ) ;
			}
		});
		r.start();
	}
	
	public void onClick(View v) {
		switch (v.getId()) {
		case 0 : 
			if(getCallingActivity()!=null){
				setResult(RESULT_OK);
				Intent intent = new Intent(SettingNoticeDetailView.this, SettingNotice.class);
				intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				intent.putExtra("login", m_bLogin);
				startActivity(intent);
				this.finish();
			}else{
				
				this.finish();
			}
			break;	
		}
	}
	
	
	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		//Debug.trace(TAG, "httpResult" + "[" + what + "](" + result + ")") ;
		
		switch(what) {
		case NOTICE_GET_NOTICE_DETAIL :
			//Debug.trace(LOG_TAG, "httpResult NOTICE_GET_NOTICE_LIST:" + result) ;
			
			if(result){			
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
						String pkitem =null;
						Node pk_item = order.getElementsByTagName("pk").item(0);
						Node date_item = order.getElementsByTagName("date").item(0);
						Node title_item = order.getElementsByTagName("title").item(0);	
						Node content_item = order.getElementsByTagName("content").item(0);	
					
						pkitem = String.valueOf(pk_item.getFirstChild().getNodeValue());
						
						if(pkitem.equals(mPK)){
							date.setText(date_item.getFirstChild().getNodeValue());
							title1.setText(title_item.getFirstChild().getNodeValue());
							title2.setText(title_item.getFirstChild().getNodeValue());
							
							content.loadDataWithBaseURL(null, content_item.getFirstChild().getNodeValue(), 
												"text/html", "utf-8", null);
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
			
			break ;
		}
		
	}

	@Override
	public boolean onTouch(View v, MotionEvent event) {
		// TODO Auto-generated method stub
		mScroll.requestDisallowInterceptTouchEvent(true);
		return false;
	}
}
