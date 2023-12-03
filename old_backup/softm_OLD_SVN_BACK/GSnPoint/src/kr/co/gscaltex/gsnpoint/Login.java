package kr.co.gscaltex.gsnpoint;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.HashMap;

import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.SeedAndroidIF;
import kr.co.gscaltex.gsnpoint.util.Util;
import android.content.Intent;
import android.os.Bundle;
import android.widget.ImageView;

public class Login extends BaseWebActivity {
	private ImageView ivLoadingImage = null ;
	private FileInfo fi = new FileInfo();

	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.web_viewer);

		String URL = "";
		Intent intent = new Intent(getIntent());
		String m_policyUrl = intent.getStringExtra("m_policyUrl");
		
		if(m_policyUrl==null||m_policyUrl.equals("")){
			URL = fi.getSettingInfo(getBaseContext(), FileInfo.LOGIN_URL);
			//if(URL.equals("")) URL = Util.LOGIN_URL ;
			//Debug.trace(LOG_TAG, "Login URL:" + URL ) ; 
			
		}
		else {
			String id = intent.getStringExtra("id");
			String pwd = intent.getStringExtra("pwd");
			String key = fi.getSettingInfo(getBaseContext(), FileInfo.SEED);
			SeedAndroidIF si = new SeedAndroidIF();
			URL = m_policyUrl+"?id="+UrlEncode(si.encodeBase64(id,key))+"&pwd="+UrlEncode(si.encodeBase64(pwd,key));
		}

		new TitleView(this,true,true,R.string.TITLE_TYPE_LOG_IN, false); 
		new NewMainMenu(this);

		ivLoadingImage = (ImageView)findViewById(R.id.loading_image) ;
//		ivLoadingImage.setBackgroundResource(R.drawable.login_blank) ;
		
		if (URL.equals("")) {
			AlertDialogMsg(R.string.network_error);		
		}
		else {
			ivLoadingImage.setVisibility(ImageView.VISIBLE) ;
			loadUrl(URL);
		}
	} 

	private String UrlEncode(String word) {
		try {
			return URLEncoder.encode(word, "UTF-8");
		}
		catch (UnsupportedEncodingException e1) {
			return new String("");
		}		
	}

	protected void webViewEvent(int what, boolean result, HashMap<String, Object> param) {
		// TODO Auto-generated method stub
		switch(what) {
		case 0 : 
			ivLoadingImage.setVisibility(ImageView.GONE) ;
			break ;
			
		case 1 :
			//Toast.makeText(getBaseContext(), "��Ʈ��ũ ������ �������� �ʽ��ϴ�.", Toast.LENGTH_SHORT).show();
			break ;  
			
		case 900 : 
			/*
			 View view = getLayoutInflater().inflate(R.layout.custom_progress, null, true) ;
			 ProgressBar progressBar =(ProgressBar)view.findViewById(R.id.custom_progressbarInverse) ;
			 Debug.trace(LOG_TAG, "recv wevViewEvent : " + what + "/" + result + "/" + progressBar) ;
			 if(result) { 
				 progressBar.setVisibility(View.VISIBLE) ;
			 } else {
				 progressBar.setVisibility(View.GONE) ;
			 }*/
			 break ;
		}
		
	}
}