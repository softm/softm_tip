package kr.co.gscaltex.gsnpoint.point;

import java.io.ByteArrayInputStream;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.SpinnerGS;
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
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.WindowManager;
import android.view.View.OnClickListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.AdapterView.OnItemSelectedListener;

public class PointPresentPopup extends BaseActivity implements OnClickListener{
	String TAG = "PointPresentPopup";
	
	DefaultApplication mApp ;
	private FileInfo fi = new FileInfo();
	
	private String[] EmailType={" 직접입력", " chol.com", " dreamwiz.com", " empal.com", " hanafos.com"," hanmir.com"
							," hotmail.com"," gmail.com"," korea.com"," nate.com"," naver.com", " netian.com",
							" paran.com"," sayclub.com", " yahoo.com", " yahoo.co.kr"};
	private String friendCuskey = null;
	private Boolean isPhone = true;
	private ImageButton btnClose, btnSearch,chkBoxPhone, chkBoxEmail = null;
	private SpinnerGS mSpnEmailType = null;
	private EditText mName, mPhone, mEmail1, mEmail2 = null;
	private ImageView mNodata = null;
	private TextView txtName, txtPhone, txtEmail = null;
	
	private LinearLayout mlinear = null;
	
	private InputMethodManager imm;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		
		WindowManager.LayoutParams IpWindow = new WindowManager.LayoutParams();
		IpWindow.flags = WindowManager.LayoutParams.FLAG_DIM_BEHIND;
		IpWindow.dimAmount= 0.75f;
		getWindow().setAttributes(IpWindow);
		
		imm = (InputMethodManager)getSystemService(Context.INPUT_METHOD_SERVICE);
		setContentView(R.layout.pointpresentpopup); 
					
		mName = (EditText)findViewById(R.id.edit_popup_name);
		mPhone = (EditText)findViewById(R.id.edit_phone);
		mEmail1 = (EditText)findViewById(R.id.edit_email1);
		mEmail2 = (EditText)findViewById(R.id.edit_email2);
		
		txtName = (TextView)findViewById(R.id.txt_name);
		txtPhone = (TextView)findViewById(R.id.txt_phone);
		txtEmail = (TextView)findViewById(R.id.txt_email);
		
		//Linkify.addLinks(txtName, null, "linkName");
		txtName.setOnClickListener(this);
		
		Bundle extras = getIntent().getExtras();
		if(extras!=null)	
			mName.setText(extras.getString("FreindName"));
		
		chkBoxPhone = (ImageButton)findViewById(R.id.chb_phone);	
		chkBoxEmail = (ImageButton)findViewById(R.id.chb_email);		
		chkBoxPhone.setOnClickListener(this);
		chkBoxEmail.setOnClickListener(this);
		
		btnClose= (ImageButton)findViewById(R.id.btn_close);
		btnClose.setId(0);
		btnClose.setOnClickListener(this);
		
		btnSearch= (ImageButton)findViewById(R.id.btn_search);
		btnSearch.setId(1);
		btnSearch.setOnClickListener(this);
		
		mSpnEmailType= (SpinnerGS)findViewById(R.id.spn_emailtype);
		mSpnEmailType.addItems(EmailType);
		  
		ArrayAdapter <CharSequence> adapter = new ArrayAdapter<CharSequence>(
				this,
				android.R.layout.simple_spinner_item,
				EmailType
		);	    		
	    adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
	    mSpnEmailType.setAdapter(adapter);
		
	    mSpnEmailType.setOnItemSelectedListener(new OnItemSelectedListener() {
			public void onItemSelected(AdapterView<?> parent, View v, int position, long id) {
				if(position !=0){
					mEmail2.setVisibility(View.INVISIBLE);
				}else
					mEmail2.setVisibility(View.VISIBLE);
			}
			public void onNothingSelected(AdapterView<?> parent) {			
			}
		});
	    
	    mlinear= (LinearLayout)findViewById(R.id.layout_display);
	    mlinear.setVisibility(View.VISIBLE);
	    
	    mNodata = (ImageView)findViewById(R.id.img_popup_nodata);
	    mNodata.setVisibility(View.GONE);
	    		
	    setRadioButton();
	}
	
	public void onClick(View v) {
		// TODO Auto-generated method stub
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  
		
		switch (v.getId()) {
		case 0 : 	// cancel button
			finish();
	         break;	
		case 1 :	// search button
			if(mName.getText().toString().equals("")){
				alt_bld.setMessage(R.string.mypoint_present_popup_name_check)  
		    	.setCancelable(false)  
		    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
					public void onClick(DialogInterface dialog, int which) {
					}
		    	});
				showAlertDialog(alt_bld);
				
			}else if(isPhone&(mPhone.getText().toString().equals(""))){
				alt_bld.setMessage(R.string.mypoint_present_popup_phone_check)  
		    	.setCancelable(false)  
		    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
					public void onClick(DialogInterface dialog, int which) {
					}
		    	});
				showAlertDialog(alt_bld);
				
			}else if(!isPhone&(mEmail1.getText().toString().equals(""))){
				alt_bld.setMessage(R.string.mypoint_present_popup_email_check)  
		    	.setCancelable(false)  
		    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
					public void onClick(DialogInterface dialog, int which) {
					}
		    	});
				showAlertDialog(alt_bld);
				
			}else{
				searchFriend();
			}
			break;
		case R.id.chb_email:
			isPhone=false;
			setRadioButton();
			break;
		case R.id.chb_phone:
			isPhone=true;
			
			setRadioButton();
			break;
			
		case R.id.txt_name:
			  Intent resultIntent = getIntent();
			  resultIntent.putExtra("FriendName", txtName.getText().toString());
			  resultIntent.putExtra("FriendCukey2", friendCuskey);
  
			setResult(RESULT_OK, resultIntent);
			
			finish();
			break;
			
		}
	}
	
	private void searchFriend(){	
		//showCenterProgress();		
			Thread r = new Thread(new Runnable() {
				public void run() {
	
					String cuskey2 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_2);
					List<NameValuePair> params = new ArrayList<NameValuePair>(2);
					String type;
					
					params.add(new BasicNameValuePair("process_code", "searchUserList"));
					
					if(isPhone){				
						params.add(new BasicNameValuePair("reg_gbn", "1"));
						params.add(new BasicNameValuePair("mem_name", mName.getText().toString()));
						params.add(new BasicNameValuePair("cuskey2", cuskey2));
						params.add(new BasicNameValuePair("in_req_gbn_txt", mPhone.getText().toString()));
					}else{
						params.add(new BasicNameValuePair("reg_gbn", "2"));
						params.add(new BasicNameValuePair("mem_name", mName.getText().toString()));
						params.add(new BasicNameValuePair("cuskey2", cuskey2));
										
						int position = mSpnEmailType.getSelectedItemPosition();
						if(position==0)
							 type= mEmail2.getText().toString().trim();
						else
							 type= mSpnEmailType.getItemAtPosition(position).toString().trim();
						String email = mEmail1.getText().toString()+"@"+type;
						params.add(new BasicNameValuePair("in_req_gbn_txt", email));
					}
					setParams(params);
					loadUrl(R.string.mypointchecklist_name, Util.DATA_CONNECT,"") ;
				}
			});
			r.start();
	}
	private void setRadioButton(){		
		if(isPhone){
			chkBoxPhone.setBackgroundResource(R.drawable.radio_phone_on);
			chkBoxEmail.setBackgroundResource(R.drawable.radio_email_off);
			mEmail1.setVisibility(View.INVISIBLE);
			mEmail2.setVisibility(View.INVISIBLE);
			mSpnEmailType.setVisibility(View.INVISIBLE);
			mPhone.setVisibility(View.VISIBLE);
		}else{
			chkBoxEmail.setBackgroundResource(R.drawable.radio_email_on);
			chkBoxPhone.setBackgroundResource(R.drawable.radio_phone_off);
			mPhone.setVisibility(View.INVISIBLE);
			mEmail1.setVisibility(View.VISIBLE);
			mEmail2.setVisibility(View.VISIBLE);
			mSpnEmailType.setVisibility(View.VISIBLE);
		}
	}
	
	
	@Override
	protected void onDestroy() { 
		super.onDestroy(); 
	}
	
	private void showAlertDialog(AlertDialog.Builder bld ){
    	AlertDialog alert = bld.create();  
    	alert.setTitle(R.string.alert_str);
    	alert.show(); 
    }
	
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		//Debug.trace(TAG, "httpResult" + "[" + what + "](" + result + ")") ;
		
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
				
				mlinear.setVisibility(View.GONE);
				mNodata.setVisibility(View.VISIBLE);
				
				if( error_text.getNodeValue() == null ){
					msg = Util.NOT_FOUND_RESULT;
					Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
				}else{
					msg = error_text.getNodeValue();
					Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
				}										
			}else if(result_tag.equals("1")){				
				NodeList email_items = order.getElementsByTagName("email");
				NodeList tel_items = order.getElementsByTagName("tel");
				NodeList name_items = order.getElementsByTagName("cname");	
				NodeList other_items = order.getElementsByTagName("oth");
					
				Node email_item = email_items.item(0);
				Node tel_item = tel_items.item(0);
				Node name_item = name_items.item(0);
				Node other_item = other_items.item(0);
																	
				txtName.setText(name_item.getFirstChild().getNodeValue());
				txtEmail.setText(email_item.getFirstChild().getNodeValue());
				txtPhone.setText(tel_item.getFirstChild().getNodeValue());	
				friendCuskey = other_item.getFirstChild().getNodeValue();
				mlinear.setVisibility(View.VISIBLE);
				mNodata.setVisibility(View.GONE);
				
				if(isPhone)
					imm.hideSoftInputFromWindow(mPhone.getWindowToken(), 0);
				else
					imm.hideSoftInputFromWindow(mEmail1.getWindowToken(), 0);
			}
		}
		catch (Exception e) {
			e.printStackTrace();
		}
		//hideCenterProgress();
	}
}

