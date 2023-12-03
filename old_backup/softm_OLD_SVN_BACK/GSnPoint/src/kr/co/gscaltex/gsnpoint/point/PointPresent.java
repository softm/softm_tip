package kr.co.gscaltex.gsnpoint.point;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.SeedAndroidIF;
import kr.co.gscaltex.gsnpoint.util.Util;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

public class PointPresent extends BaseActivity implements OnClickListener{
	String TAG = "PointPresentS";
	
	DefaultApplication mApp ;
	private Handler handler = new Handler();
	
	private FileInfo fi = new FileInfo();
	private boolean m_bLogin = false;
		
	private String[] FriendsType={"  친구", "  부모", "  형제", "  자녀", "  배우자","  친척"
							,"  직장동료","  기타"};
	private long usePoint;
	private String recCuskey = "";
	private TextView mUsePoint, mName;
	private ImageButton mPresent, mSearch, mCancel = null;
	private EditText mGivePoint, mPassword, mContent;
	private Spinner FriendsSpiner = null;
	private CheckBox chkBoxAgreement = null;
	
	private final int SEARCH_FRIEND = 300;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.pointpresent); 
		
		Bundle extras = getIntent().getExtras();
		if(extras!=null){
		m_bLogin = extras.getBoolean("login");
		usePoint= extras.getLong("canGivePoint");
		}
		
		new TitleView(this, true, true, R.string.TITLE_TYPE_POINT_PRESENT,m_bLogin);	
		new NewMainMenu(this);
		
		mUsePoint = (TextView)findViewById(R.id.txt_canUsePoint);
		String temp= makeStringComma(String.valueOf(usePoint)); 
		mUsePoint.setText(temp);
		
		mCancel = (ImageButton)findViewById(R.id.btn_cancel);
		mCancel.setId(0);
		mCancel.setOnClickListener(this);
		
		mPresent = (ImageButton)findViewById(R.id.btn_present);
		mPresent.setId(1);
		mPresent.setOnClickListener(this);	
		
		mSearch = (ImageButton)findViewById(R.id.btn_search);
		mSearch.setId(2);
		mSearch.setOnClickListener(this);	
	
		FriendsSpiner= (Spinner)findViewById(R.id.spinner_friends);
		ArrayAdapter <CharSequence> adapter = new ArrayAdapter<CharSequence>(
							this,
							R.layout.spinner_item,
							FriendsType
					);
				
		adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);	
		FriendsSpiner.setAdapter(adapter);
		
		mGivePoint = (EditText)findViewById(R.id.edit_give);
		mPassword = (EditText)findViewById(R.id.edit_password);
		//mName = (EditText)findViewById(R.id.edit_name);
		mName = (TextView)findViewById(R.id.edit_name);
		mContent = (EditText)findViewById(R.id.edit_email_content);
		
		chkBoxAgreement = (CheckBox)findViewById(R.id.chk_email_agreement);	
	}
	
	
	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch (v.getId()) {
		case 0 : 	// cancel button
			finish();
	         break;
		case 1 : 	//present button
			if(checkValue())
				pointPresent();
			break;
		case 2 : 	//search  button (검색)
			Intent intent = new Intent(this, PointPresentPopup.class);
			intent.putExtra("FreindName", "") ;
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivityForResult(intent,SEARCH_FRIEND);
			break;
		}
	}
	
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		
		if(resultCode != RESULT_OK){
			if(data !=null){
			}
			return;
		}
		
		switch(requestCode){
		case SEARCH_FRIEND:
			
			if(data!=null){
				mName.setText(data.getExtras().getString("FriendName"));
				recCuskey= data.getExtras().getString("FriendCukey2");
			}	
			break;			
		}
	}
	private void pointPresent(){
		
		Thread r = new Thread(new Runnable() {
			public void run() {

				String userid = fi.getSettingInfo(getBaseContext(), FileInfo.ID);
				String userpw = fi.getSettingInfo(getBaseContext(), FileInfo.PWD);
				String key = fi.getSettingInfo(getBaseContext(), FileInfo.SEED);
				
				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				
				params.add(new BasicNameValuePair("process_code", "pointGive"));		
				params.add(new BasicNameValuePair("userid", userid));
				
				SeedAndroidIF si = new SeedAndroidIF();
				//params.add(new BasicNameValuePair("userpw", si.encodeBase64(userpw,key)));
				params.add(new BasicNameValuePair("userpw", userpw));
				params.add(new BasicNameValuePair("recv_cuskey2", recCuskey));
				params.add(new BasicNameValuePair("point", mGivePoint.getText().toString()));
				
				if(chkBoxAgreement.isChecked())
					params.add(new BasicNameValuePair("chkEmail", "Y"));
				else
					params.add(new BasicNameValuePair("chkEmail", "N"));
				
				params.add(new BasicNameValuePair("rel_code", getFriendTypeValue()));
				params.add(new BasicNameValuePair("in_msg", mContent.getText().toString()));
				
				setParams(params);
				loadUrl(R.string.present_name, Util.DATA_CONNECT,"") ;
			}
		});
		r.start();
	}
	
	private Boolean checkValue(){
		long Point= 0;
		String Password = fi.getSettingInfo(getBaseContext(), FileInfo.PWD);
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  
		
		String key = fi.getSettingInfo(getBaseContext(), FileInfo.SEED);
		SeedAndroidIF si = new SeedAndroidIF();
		
		if(!(mGivePoint.getText().toString().equals("")))
			Point = Long.valueOf(mGivePoint.getText().toString());
		
		if((Point >usePoint) || (Point<=0)){
			
			alt_bld.setMessage(R.string.mypoint_value_check)  
	    	.setCancelable(false)  
	    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
				public void onClick(DialogInterface dialog, int which) {
				}
	    	});
			showAlertDialog(alt_bld);
			
			return false;
			
		}else if(!(Password.equals(si.encodeBase64(mPassword.getText().toString(),key)))){
			alt_bld.setMessage(R.string.alert_str_password_error)  
	    	.setCancelable(false)  
	    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
				public void onClick(DialogInterface dialog, int which) {
				}
	    	});
			showAlertDialog(alt_bld);
			
			return false;
		}else if(mName.getText().toString().equals("")){
			alt_bld.setMessage(R.string.alert_str_friendname_error)  
	    	.setCancelable(false)  
	    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
				public void onClick(DialogInterface dialog, int which) {
				}
	    	});
			showAlertDialog(alt_bld);
			
			return false;
		}else{
			
		}
		return true;
	}
	
	private String getFriendTypeValue(){
		String value="";
		
		if(FriendsSpiner.getFirstVisiblePosition()==0)
			value="01";
		else if(FriendsSpiner.getFirstVisiblePosition()==1)
			value="02";
		else if(FriendsSpiner.getFirstVisiblePosition()==2)
			value="03";
		else if(FriendsSpiner.getFirstVisiblePosition()==3)
			value="04";
		else if(FriendsSpiner.getFirstVisiblePosition()==4)
			value="05";
		else if(FriendsSpiner.getFirstVisiblePosition()==5)
			value="06";
		else if(FriendsSpiner.getFirstVisiblePosition()==6)
			value="07";
		else if(FriendsSpiner.getFirstVisiblePosition()==7)
			value="08";
		
		return value;
	}
	private void showAlertDialog(AlertDialog.Builder bld ){
    	AlertDialog alert = bld.create();  
    	alert.setTitle(R.string.alert_str);
    	alert.show(); 
    }
	@Override
	protected void onDestroy() { 
		super.onDestroy(); 
	}
	
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		//Debug.trace(TAG, "httpResult" + "[" + what + "](" + result + ")") ;
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
				finish();
			}else if(result_tag.equals(Util.SERVER_GO_STATUS)){					
				goErrorUrl();						
			}else if(result_tag.equals("0")){
				error_item = error_items.item(0);
				error_text = error_item.getFirstChild();
				String msg;
				
				if((error_text==null)){
					msg = Util.NOT_FOUND_RESULT;
					
					alt_bld.setMessage(msg)  
			    	.setCancelable(false)  
			    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
						public void onClick(DialogInterface dialog, int which) {
						}
			    	});
					showAlertDialog(alt_bld);
					
				}else{
					msg = error_text.getNodeValue();
					
					alt_bld.setMessage(msg)  
			    	.setCancelable(false)  
			    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
						public void onClick(DialogInterface dialog, int which) {
						}
			    	});
					showAlertDialog(alt_bld);
				}										
			}else if(result_tag.equals("1")){		
				
				alt_bld.setMessage(R.string.mypoint_present_send_OK)  
		    	.setCancelable(false)  
		    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
					public void onClick(DialogInterface dialog, int which) {
						handler.post(goPointActivity);
					}
		    	});
				showAlertDialog(alt_bld);
				
			}
		}
		catch (Exception e) {
			e.printStackTrace();
		}
		//hideCenterProgress();
		
	}

	


	private Runnable goPointActivity = new Runnable(){	
		public void run() {
			setResult(RESULT_OK);
			mApp.setCardRefresh(true) ;
			finish();
		}		
	};
	
	private String makeStringComma(String str){
		if(str.length()==0)
			return "";
		long value = Long.parseLong(str);
		DecimalFormat format = new DecimalFormat("###,###");
		
		return format.format(value);
	}
	
	private String UrlEncode(String word) {
		try {
			return URLEncoder.encode(word, "UTF-8");
		}
		catch (UnsupportedEncodingException e1) {
			return new String("");
		}		
	}
}

