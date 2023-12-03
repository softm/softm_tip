package kr.co.gscaltex.gsnpoint.setting;

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
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.SeedAndroidIF;
import kr.co.gscaltex.gsnpoint.util.Util;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.CheckBox;
import android.widget.ImageButton;
import android.widget.ImageView;

public class AgreementView extends BaseActivity implements OnClickListener {
	String TAG = "GS";

	DefaultApplication mApp ;
	private boolean m_bLogin = false;
	
	private ImageView ivLoadingImage = null ;

	private String URL  = Util.DATA_CONNECT;
	private String KIND = "MYPOINT";	
	private String userID, userPwd = "";
	final static int AGREEMENT_CHECK = 01 ;
	private Handler handler = new Handler();
	private CheckBox chkBoxAgreement = null;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.agreementview); 
	
		Bundle extras = getIntent().getExtras();
		if(extras!=null){
			m_bLogin = extras.getBoolean("login");
			userID = extras.getString("id");
			userPwd = extras.getString("pwd");
		}
		new TitleView(this, true, true, R.string.TITLE_TYPE_SETTING_JOIN,m_bLogin);
		new NewMainMenu(this);
		
		ImageButton imgBtnAllView = (ImageButton)findViewById(R.id.img_btn_allview); // 전체내용확인 - 버튼
		ImageButton imgBtnOk      = (ImageButton)findViewById(R.id.img_btn_ok     ); // 약관동의 확인 - 버튼
		ImageButton imgBtnCancel  = (ImageButton)findViewById(R.id.img_btn_cancel ); // 약관동의 취소 - 버튼

		imgBtnAllView.setOnClickListener(this);
		imgBtnOk.setOnClickListener(this);
		imgBtnCancel.setOnClickListener(this);
		chkBoxAgreement = (CheckBox)findViewById(R.id.chk_agreement);	
	}


	public void onClick(View v) {
		// TODO Auto-generated method stub
		clickEvent(v);
	}
	
	private void clickEvent(View v) {
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  

		//Debug.trace(TAG, "id :  "+ v.getId());
		switch (v.getId()) {
		case R.id.img_btn_allview: // 전체내용확인 - 버튼
			Intent intent = new Intent(this, AgreementTermView.class);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);			
			break;
		case R.id.img_btn_ok:      // 약관동의 확인 - 버튼
	 		// 이용약관 동의 CheckBox
			if ( chkBoxAgreement.isChecked() ) {
				//AgreementView.this.activity.finish();
				callAgreement();
			} else {
				alt_bld.setMessage(R.string.alert_str_mobile_agreement)  
				.setCancelable(false) 
				.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
					public void onClick(DialogInterface dialog, int which) {
					}
				});  				
				showAlertDialog(alt_bld);				 
			}
			break;
		case R.id.img_btn_cancel:  // 약관동의 취소 - 버튼
			finish();
			break;
		default:
			break;
		}
	}
	
	@Override
	protected void onDestroy() { 
		super.onDestroy(); 
	}
	
	
	
	/**
	 * 메인 화면으로 이동한다.
	 */
	public void goMain() {
		Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.card.CardMainView.class);
		intent.putExtra("card_refresh", true) ;
		intent.putExtra("login", true) ;
		intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		startActivity(intent);
		finish();		
	}
	
	/**
	 * 약관동의 처리를 실행합니다.
	 */
	public void callAgreement() { 
		showCenterProgress();
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);

		FileInfo fi = new FileInfo();
			
		if ( !userID.equals("") && !userPwd.equals("") ) {
			SeedAndroidIF si = new SeedAndroidIF(); 
			List<NameValuePair> params = new ArrayList<NameValuePair>(3);
			params.add(new BasicNameValuePair("process_code", "agreement"));
			params.add(new BasicNameValuePair("userid", userID));
			params.add(new BasicNameValuePair("userpw", userPwd));
			//params.add(new BasicNameValuePair("userpw", si.encodeBase64(userpw, fi.getSettingInfo(getBaseContext(), FileInfo.SEED))));
			String seed = fi.getSettingInfo(getBaseContext(), FileInfo.SEED);
			if(seed.equals("")) return ;
			setParams(params);
		} else {
			alt_bld.setMessage(R.string.alert_str_mobile_agreement_error)  
			.setCancelable(false) 
			.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
				public void onClick(DialogInterface dialog, int which) {
				}
			}); 	
			showAlertDialog(alt_bld);					
		}
		
		Thread r = new Thread(new Runnable() {
			public void run() {
				loadUrl(AGREEMENT_CHECK, URL, KIND) ;
			}
		});
		r.start();		

	}

	/*
	 * @see kr.co.gscaltex.gsnpoint.BaseActivity#httpResult(int, boolean, java.lang.String)
	 */
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		//Debug.trace(TAG, "httpResult" + "[" + what + "](" + result + ")") ;
		switch(what) {
		case AGREEMENT_CHECK :	
			String str = getString();

			hideCenterProgress();
			AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  

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
				if( result_tag.equals("0")){
					error_item = error_items.item(0);
					error_text = error_item.getFirstChild();

					String err = error_text.getNodeValue();

					if( err != null ) {
						err = error_text.getNodeValue();
						alt_bld.setMessage(err)  
						.setCancelable(false) 
						.setPositiveButton("확인", new DialogInterface.OnClickListener() {					
							public void onClick(DialogInterface dialog, int which) {
							}
						});  										
						showAlertDialog(alt_bld);
					}
				} else if(result_tag.equals("1")){
					goMain();
				}
			} catch (Exception e) {
				e.printStackTrace();
				/*
				 * Toast t =Toast.makeText(this,Util.COMMON_MSG_4, Toast.LENGTH_SHORT); 
				 */
				/*
				 * t.show();
				 */
			}	
			break ;
		}
	}

	private void showAlertDialog(AlertDialog.Builder bld ){
		AlertDialog alert = bld.create();  
		alert.setTitle(R.string.alert_str);
		alert.show(); 
	}


}

