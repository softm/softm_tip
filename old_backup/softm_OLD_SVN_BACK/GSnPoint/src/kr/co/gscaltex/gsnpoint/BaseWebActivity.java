package kr.co.gscaltex.gsnpoint;

import java.io.BufferedReader;
import java.io.ByteArrayInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.URLDecoder;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.GSActivityManager;
import kr.co.gscaltex.gsnpoint.util.SeedAndroidIF;
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

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.Toast;

public abstract class BaseWebActivity extends Activity {
	public static final String LOG_TAG = "GS";

	final Context mApp = this;	
	private String xml_string = "";
	private List<NameValuePair> nameValuePairs;	
	private final Handler handler = new Handler();

	private String p_cuskey_1 = "";
	private String p_cuskey_2 = "";
	private String p_error = "";
	private String m_userName = "";
	private String p_policy = "";
	private String m_openUrl = "";
	private String m_pointUrl = "";
	private String m_policyUrl = "";
	private FileInfo fi = new FileInfo();
	public String OverideUserAgent_IE = "Mozilla/5.0 (Windows; MSIE 6.0; Android 1.6; en-US) AppleWebKit/525.10+ (KHTML, like Gecko) Version/3.0.4 Safari/523.12.2 myKMB/1.0";
	public String popupUrl ="";
	protected void setParams(List<NameValuePair> params){
		this.nameValuePairs=params;
	}
	
	private String g_id="";
	private String g_pwd="";
	private String g_opt="";
	private boolean flg = true;
	
	private Boolean bPressHomekey = false;
	WebView webV ;
	
	protected abstract void webViewEvent(int what, boolean result, HashMap<String,Object> param);
	
	public BaseWebActivity() {

	}
	
	protected void AlertDialogMsg(int msg){
    	AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  

    	alt_bld.setMessage(msg)  

    	.setCancelable(false)  
    	//.setIcon(R.drawable.icon)
    	
    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {
			
			public void onClick(DialogInterface dialog, int which) {
				finish();
			}
    	});  

    	AlertDialog alert = alt_bld.create();  
    	// Title for AlertDialog  
    	alert.setTitle(R.string.alert_str);
    	// Icon for AlertDialog  
    	//alert.setIcon(R.drawable.icon); 
    	alert.show(); 
    }
	
	protected boolean serverConnect(String URL) {
		//Debug.trace(LOG_TAG,"++++ serverConnect called:" + URL) ;
		
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
				httpclient.getConnectionManager().shutdown();
				return false;
			}else{
				HttpEntity entity = response.getEntity();			
				
				if (entity == null) {
					httpclient.getConnectionManager().shutdown();
					return false;
				}else{
					if(entity != null){
			        	InputStream inputStream = entity.getContent();
			        	//WebView webV = (WebView)findViewById(R.id.webview_browser);  			        	
			        	//String str = convertStreamToString(inputStream);
			        	//setString(str);
			        	xml_string = convertStreamToString(inputStream);
			        	
			        	//Debug.trace(LOG_TAG, "BEGIN xml_string===============") ;
						//Debug.trace(LOG_TAG, xml_string) ;
						//Debug.trace(LOG_TAG, "END xml_string===============") ;

			        	/*if(str.substring(2,5).equals("xml")){
			        		setString(str);
			        	}else{
			        		webV.loadDataWithBaseURL("",str,"text/html","UTF-8","");
			        	}*/
			        	httpclient.getConnectionManager().shutdown();
			        }
			        return true;
				}
			}			
		} catch (ClientProtocolException e) {			
			return false;
		} catch (IOException e) {			
			return false;
		} 
	}
	
	
	
	public void initWebView(String url ) {
		
		//Debug.trace(LOG_TAG,"+++ initWebView started" ) ;
		
		webV = (WebView)findViewById(R.id.webview_browser);  	
    	webV.getSettings().setJavaScriptEnabled(true);
    	webV.getSettings().setCacheMode(WebSettings.LOAD_NO_CACHE);
    	
    	
    	if(url.contains("point.jsp")|| url.contains("cardManage.jsp") ||url.contains("store_detail_eval.jsp") ) {
    		//Debug.trace(LOG_TAG, "++++ clearCache:" ) ;
    		webV.clearCache(false) ;    
    	}        
    	//CARD_REG_URL, POINT_URL store_detail_eval.jsp 
    	
    	webV.setScrollBarStyle(View.SCROLLBARS_INSIDE_OVERLAY);
        webV.addJavascriptInterface(new AndroidBridge(), "android");
     
    	webV.setWebChromeClient(new WebChromeClient() {
    	    
    	    public boolean onJsAlert(WebView view, String url, String message, final android.webkit.JsResult result)
    	    {
    	        new AlertDialog.Builder(mApp)
    	            .setTitle(R.string.alert_str)
    	            .setMessage(message)
    	            .setPositiveButton(android.R.string.ok,
    	                    new AlertDialog.OnClickListener()
    	                    {
    	                        public void onClick(DialogInterface dialog, int which)
    	                        {
    	                            result.confirm();
    	                        }
    	                    })
    	            .setCancelable(false)
    	            .create()
    	            .show();

    	        return true;
    	    }

			
			public void onProgressChanged(WebView view, int newProgress) {
				if( newProgress == 100 ) webViewEvent(0,true, null) ;
				/*
				if(newProgress==100){
					webViewEvent(0,true) ;
					hideCenterProgress();
					flg=true;
				}else{
					if(flg){
						showCenterProgress();
						flg=false;
					}				
				}				
				Debug.trace("test",""+newProgress);
				*/
				
			};  
    	});
    	
    	webV.getSettings().setUserAgentString("Client1");
    	webV.setWebViewClient(new GsViewClient());  // WebViewClient 지정
    	
    	//Debug.trace(LOG_TAG,"+++ initWebView ended" ) ;
	}
	

	
	protected boolean loadUrl(String URL){
		//Debug.trace(LOG_TAG,"+++ loadUrl :" + URL ) ;
		
		//deleteCookie() ; 
		
		initWebView(URL) ;
		 
		/*
		if( URL.indexOf("?") != -1) {
			String svrUrl = URL.substring(0,URL.indexOf("?")) ;
			String params = URL.substring(URL.indexOf("?"), URL.length()) ;
			Debug.trace(LOG_TAG, svrUrl + ":" + params ) ;
		}*/
		 
		
		webV.loadUrl(URL); 
    	
    	return true;
	}	
	
//	protected void deleteCookie() {
//		Debug.trace(LOG_TAG,"+++ deleteCookie"  ) ;
//		CookieSyncManager.createInstance(this);
//		
//		new Thread(new Runnable() {
//			@Override
//			public void run() {
//				// TODO Auto-generated method stub
//				CookieManager cookieManager = CookieManager.getInstance();
//				cookieManager.removeAllCookie();				
//			}			
//		}).start() ;
//	}
	
	protected boolean loadUrl2(String URL, ImageView customView){
		//Debug.trace(LOG_TAG,"+++ loadUrl2 :" + URL ) ;

		WebView webV = (WebView)findViewById(R.id.webview_browser);  	
    	webV.getSettings().setJavaScriptEnabled(true);
    	//webV.clearCache(true);
    	webV.setScrollBarStyle(View.SCROLLBARS_INSIDE_OVERLAY);
        webV.addJavascriptInterface(new AndroidBridge(), "android");
        //webV.setHorizontalScrollBarEnabled(false);
        //webV.setVerticalScrollBarEnabled(false);
    	webV.setWebChromeClient(new WebChromeClient() {
    	    
    	    public boolean onJsAlert(WebView view, String url, String message, final android.webkit.JsResult result)
    	    {
    	        new AlertDialog.Builder(mApp)
    	            .setTitle(R.string.alert_str)
    	            .setMessage(message)
    	            .setPositiveButton(android.R.string.ok,
    	                    new AlertDialog.OnClickListener()
    	                    {
    	                        public void onClick(DialogInterface dialog, int which)
    	                        {
    	                            result.confirm();
    	                        }
    	                    })
    	            .setCancelable(false)
    	            .create()
    	            .show();

    	        return true;
    	    }

			
			public void onProgressChanged(WebView view, int newProgress) {
							
				if(newProgress==100){
					hideCenterProgress();
					flg=true;
				}else{
					if(flg){
						showCenterProgress();
						flg=false;
					}				
				}				
				//Debug.trace("test",""+newProgress);
				
			}
 
    	});
    	
    	webV.getSettings().setUserAgentString("Client1"); 
    	//Debug.trace("------//////-->",URL);

		webV.setWebViewClient(new GsViewClient());  // WebViewClient 지정
		webV.loadUrl(URL);
		
    	return true;
	}	
	
 
	
	protected void popUp_URL(String URL){
		Intent i = new Intent(Intent.ACTION_VIEW);
		
		Uri u = Uri.parse(URLDecoder.decode(URL));
		i.setData(u);
		i.setFlags(i.FLAG_ACTIVITY_NO_USER_ACTION);
		startActivity(i);
		//finish();
	}
	
	protected void Back(){
		//Debug.trace("test","back called");
		finish();
	}
	
	protected void goPointCardView(){
		//Intent intent = new Intent(this, GuidePointCard.class);
		//startActivity(intent);
		//Debug.trace(LOG_TAG,"+++ goPointCardView" ) ;
		HashMap<String, Object> param = new HashMap<String,Object>();
		webViewEvent(R.string.TITLE_TYPE_GUIDE_POINT_CARD,true, param);
	}
	
	protected void goBarcodeView(){
		//Debug.trace(LOG_TAG,"+++ goPointCardView" ) ;
		HashMap<String, Object> param = new HashMap<String,Object>();
		webViewEvent(R.string.TITLE_TYPE_BARCORD,true, param);
		
	}
	
	protected void goStoreMapView(){
		//Debug.trace(LOG_TAG,"+++ goPointCardView" ) ;
		HashMap<String, Object> param = new HashMap<String,Object>();
		webViewEvent(R.string.TITLE_TYPE_STORE,true, param);
		
	}
	
	protected void goStoreMapDetailView(String lati, String longi){
		//Debug.trace(LOG_TAG,"+++ goPointCardView" ) ;
		HashMap<String, Object> param = new HashMap<String,Object>();
		param.put("Latitude", lati);
		param.put("Longitude", longi);
		
		webViewEvent(R.string.TITLE_TYPE_STORE_REPRESENT,true, param);
		
	}
	
	protected void goHomeCall(){
		//Debug.trace(LOG_TAG,"+++ goHome" ) ;
		HashMap<String, Object> param = new HashMap<String,Object>();
		webViewEvent(R.string.TITLE_TYPE_CARD,true, param);
	}
	
	private class GsViewClient extends WebViewClient{
         
        public boolean shouldOverrideUrlLoading(WebView view, String url) { 
        	//Debug.trace(LOG_TAG,"+++ GsViewClient shouldOverrideUrlLoading:" + url) ;
        	//view.setVisibility(View.VISIBLE) ;
        	showCenterProgress() ;
            //view.loadUrl(url);             
            return false; 
        } 
        
		public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {
			//Debug.trace(LOG_TAG,"+++ GsViewClient onReceivedError:" + errorCode) ;
			view.setVisibility(View.INVISIBLE) ;
			Toast.makeText(view.getContext(), "네트워크 접속이 원활하지 않습니다..\n잠시 후에 다시 시도해 주십시오.", Toast.LENGTH_SHORT).show();
			//webViewEvent(1,false) ;
			hideCenterProgress() ;
		}
		
		public void onPageStarted(WebView view, String url, Bitmap favicon ) {
			//Debug.trace(LOG_TAG,"+++ GsViewClient onPageStarted:" + url) ;
			
			// 페이지 시작 시 이벤트 컨텍스트 정보를 생성합니다.
			HashMap<String, Object> param = new HashMap<String,Object>();
			param.put("event", "onPageStarted");
			param.put("url", url);
			webViewEvent(2,true, param);
			
			showCenterProgress() ;
		}
		
		public void onPageFinished(WebView view, String url) {
			//Debug.trace(LOG_TAG,"+++ GsViewClient onPageFinished:" + url) ;
			hideCenterProgress() ;
		}

    }
	
	protected String getString(){
		return xml_string;
	}
	
	private String convertStreamToString(InputStream is) {
		//Debug.trace(LOG_TAG,"+++ convertStreamToString :" ) ;
		StringBuilder stringBuilder = new StringBuilder();
	    
		try {	    	 
	    	 BufferedReader reader = new BufferedReader(new InputStreamReader(is,"UTF-8"));		     
		     String line = null;
	      
		     while ((line = reader.readLine()) != null) {
		    	 stringBuilder.append(line+"\n");
		    	 //Debug.trace("log-->",line);
		     }
		     is.close();
		     return stringBuilder.toString();
	     }catch (IOException e) {
	    	 e.printStackTrace();
	    	 return "";
	     }
	}
	
	private class AndroidBridge{
		public void callAndroid(final String arg){
			handler.post(new Runnable(){

				
				public void run() {
					//Debug.trace("DEBUG",arg);
					loadUrl(arg);
				}
			});		
			
		}
		
		public void callAndroid(final String arg, final String param){
			handler.post(new Runnable(){

				
				public void run() {
					//Debug.trace("DEBUG",arg);
					parsingParam(param);
					loadUrl(arg);
				}
			});		
			
		}		
		
		public void connectLogin(final String userid, final String userpw, final String autoLogin){
			handler.post(new Runnable(){
				public void run() {
					showCenterProgress() ;
					//SEED문자열 받아온다
					try {
						if(getSEED()){
							try {
								g_id=userid;
								g_pwd= URLDecoder.decode(userpw, "UTF-8");
								g_opt=autoLogin;
							} catch (UnsupportedEncodingException e) {
								e.printStackTrace();
							}
							handler.post(ConnectRunnable);
						}
					} catch (UnsupportedEncodingException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
				}
			});
		}
		
		/**
		 * goStoreRating : 가맹점 평가
		 */
		public void goStoreRating(){
			handler.post(new Runnable(){
				
				public void run() {
					goStoreValueList();
				}
			});	
		}
		
		/**
		 * 사용내역
		 */
		public void goPointHistory(){
			handler.post(new Runnable(){
				
				public void run() {
					goMyPointCheckList();
				}
			});	
		}
		
		public void goLogin(){			
			handler.post(new Runnable(){
				
				public void run() {
					goLoginPage();
				}
			});			
		}
		
		public void popUp(String url){
			
			
			/*
			 * alert("url");
			 * 
			if (key1 != ""){
				popupUrl = eventSsoUrl+"?key1="+key1+"&key2="+key2+"&url="+url;				
			}
			else{
				popupUrl = url;
			}
			*/
			//popupUrl = url.substring(0,url.indexOf("?")+5)+URLEncoder.encode(url.substring(url.indexOf("?")+5,url.length()));
			popupUrl = url;
			handler.post(new Runnable(){
				public void run() {
					popUp_URL(popupUrl);
				}
			});	
		}
		
		public void popUpClose(){
			handler.post(new Runnable(){
				
				public void run() {
					Back();
				}
			});	
		}
		
		public void goHome(){
			handler.post(new Runnable(){
				
				public void run() {
					goHomeCall();
				}
			});	
		}
		
		public void guide_index_pointcard(){
			handler.post(new Runnable(){
							
				public void run() {
					goPointCardView();
				}
			});	
		}
		
		public void guide_index_qrscan(){
			handler.post(new Runnable(){
							
				public void run() {
					goBarcodeView();
				}
			});	
		}
		
		public void guide_benefit_detail01(){
			handler.post(new Runnable(){
							
				public void run() {
					goStoreMapView();
				}
			});	
		}
		
		public void guide_benefit_detail02(){
			handler.post(new Runnable(){
							
				public void run() {
					goStoreMapView();
				}
			});	
		}
		
		public void guide_buylist(final String Lati, final String longi){
			handler.post(new Runnable(){
							
				public void run() {
					goStoreMapDetailView(Lati, longi);
				}
			});	
		}
		
	}
	
	private Runnable ConnectRunnable= new Runnable(){
		
		public void run() {
			connect();
		}		
	};
	
	private void connect(){
		SeedAndroidIF si = new SeedAndroidIF(); 
		List<NameValuePair> params = new ArrayList<NameValuePair>(2);
		params.add(new BasicNameValuePair("process_code", "login"));
		params.add(new BasicNameValuePair("userid", g_id));
		String seed = fi.getSettingInfo(getBaseContext(), FileInfo.SEED);
		if(seed.equals("")) return ;
		
//		params.add(new BasicNameValuePair("userpw", si.encodeBase64(g_pwd, fi.getSettingInfo(getBaseContext(), FileInfo.SEED))));
		params.add(new BasicNameValuePair("userpw", g_pwd));
		
		
		setParams(params);
		serverConnect(Util.DATA_CONNECT);
		goNextStep(g_id,g_pwd,g_opt);
	}
	
	private boolean getSEED() throws UnsupportedEncodingException,IllegalArgumentException {
		showCenterProgress() ;
		
		List<NameValuePair> params = new ArrayList<NameValuePair>(2);
		params.add(new BasicNameValuePair("process_code", "sslkey"));
		
		setParams(params);
		//serverConnect(Util.DATA_CONNECT);
		serverConnect(Util.DATA_CONNECT_HTTPS);
		String keyString ="";
		keyString = getKeyString(getString());
		
		if(keyString==null||keyString.equals("")){
			return false;
		}else{
			
			SeedAndroidIF si = new SeedAndroidIF();
			//si.decodeBase64(keyString);
		
			fi.setSettingInfo(getBaseContext(), si.decodeBase64(keyString), FileInfo.SEED);
			//fi.setSettingInfo(getBaseContext(), keyString,  FileInfo.SEED);	
			return true;
		}
	}
	
	private String getKeyString(String xml){
		String result = Util.SUCCESS;
		String key_result = "";
		InputStream is = new ByteArrayInputStream(xml.getBytes());	
		String readLine = "";
		BufferedReader br = new BufferedReader(new InputStreamReader(is));
		
		int from = 0;
		int to = 0;
		
		key_result = getResult(xml);
		if(key_result.equals(Util.SUCCESS)){
			try{
				while(((readLine = br.readLine()) != null)) {
					from = readLine.indexOf("<key>", 0);
					if (from!=-1){
						from = from+"<key>".length();
						to = readLine.indexOf("</key>", from);					
						result = readLine.substring(from, to).trim();					
					}
				}		
			}catch(IOException e){
				e.printStackTrace();
			}
		}else{			
			showAlert(p_error, new DialogInterface.OnClickListener() {
				public void onClick(DialogInterface dialog, int which) {
					hideCenterProgress();
				}
	    	});
		}
		return result;
	}
	
	private String getResult(String xml){
		String result = Util.SUCCESS;
		
		InputStream is = new ByteArrayInputStream(xml.getBytes());	
		String readLine = "";
		BufferedReader br = new BufferedReader(new InputStreamReader(is));
		
		int from = 0;
		int to = 0;
		
		try{
			while(((readLine = br.readLine()) != null)) {
				from = readLine.indexOf("<result>", 0);
				if (from!=-1){
					from = from+"<result>".length();
					to = readLine.indexOf("</result>", from);					
					result = readLine.substring(from, to).trim();					
				}
				from = readLine.indexOf("<err>", 0);
				if (from!=-1){
					from = from+"<err>".length();
					to = readLine.indexOf("</err>", from);					
					p_error = readLine.substring(from, to).trim();
				}
				from = readLine.indexOf("<cuskey1>", 0);
				if (from!=-1){
					from = from+"<cuskey1>".length();
					to = readLine.indexOf("</cuskey1>", from);					
					p_cuskey_1 = readLine.substring(from, to).trim();
				}
				from = readLine.indexOf("<cuskey2>", 0);
				if (from!=-1){
					from = from+"<cuskey1>".length();
					to = readLine.indexOf("</cuskey2>", from);					
					p_cuskey_2 = readLine.substring(from, to).trim();
				}
				from = readLine.indexOf("<name>", 0);
				if (from!=-1){
					from = from+"<name>".length();
					to = readLine.indexOf("</name>", from);					
					m_userName = readLine.substring(from, to).trim();
				}
				from = readLine.indexOf("<policy>", 0);
				if (from!=-1){
					from = from+"<policy>".length();
					to = readLine.indexOf("</policy>", from);					
					p_policy = readLine.substring(from, to).trim();
				}
				from = readLine.indexOf("<openUrl>", 0);
				if (from!=-1){
					from = from+"<openUrl>".length();
					to = readLine.indexOf("</openUrl>", from);					
					m_openUrl = readLine.substring(from, to).trim();
				}
				from = readLine.indexOf("<pointUrl>", 0);
				if (from!=-1){
					from = from+"<pointUrl>".length();
					to = readLine.indexOf("</pointUrl>", from);					
					m_pointUrl = readLine.substring(from, to).trim();
				}
				from = readLine.indexOf("<policyUrl>", 0);
				if (from!=-1){
					from = from+"<policyUrl>".length();
					to = readLine.indexOf("</policyUrl>", from);					
					m_policyUrl = readLine.substring(from, to).trim();
				}
					
				//Debug.trace("login---------->",readLine);
				
			}		
		}catch(IOException e){
			e.printStackTrace();
		}
		
		return result;
	}
	
	private void goNextStep(final String userid, final String userpw, final String autoLogin){
		String LOGIN_URL = "";
		FileInfo fi = new FileInfo();
		//CARD_URL = fi.getSettingInfo(getBaseContext(), FileInfo.CARD_REG_URL);
		LOGIN_URL=fi.getSettingInfo(getBaseContext(), FileInfo.LOGIN_URL);
		
		//if(LOGIN_URL.equals("")) LOGIN_URL = Util.LOGIN_URL ;
		
		if(LOGIN_URL.equals("")){
			AlertDialogMsg(R.string.network_error);
		}else{
			String result = getResult(getString());
			
			if(result.equals(Util.SUCCESS)){	
				/*
				String beforeCustKey1 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_1) ;
						
				Debug.trace(LOG_TAG, "#### deferent user custkey1:" + beforeCustKey1 + "!=" + p_cuskey_1) ;
			
				if(!beforeCustKey1.equals("")) {
					if(!beforeCustKey1.equals(p_cuskey_1) ) {
						Debug.trace(LOG_TAG, "++++ deferent user custkey1:" + beforeCustKey1 + "!=" + p_cuskey_1) ;
						fi.setSettingInfo(getBaseContext(), "", FileInfo.COVERFLOW_LAST_POSITION);
					}
				}*/
				
				fi.setSettingInfo(getBaseContext(), p_cuskey_1, FileInfo.CUSKEY_1);
				fi.setSettingInfo(getBaseContext(), p_cuskey_2, FileInfo.CUSKEY_2);
				fi.setSettingInfo(getBaseContext(), m_userName, FileInfo.USER_NAME);
				fi.setSettingInfo(getBaseContext(), m_openUrl,FileInfo.OPEN_URL);
				fi.setSettingInfo(getBaseContext(), m_pointUrl,FileInfo.POINT_URL);
				
				
				DefaultApplication mApp = (DefaultApplication)getApplicationContext() ;
				mApp.setLoginInfo(userid, userpw, m_pointUrl, m_openUrl, fi.getSettingInfo(getBaseContext(), FileInfo.SEED)) ;
				//fi.setSettingInfo(getBaseContext(), "",FileInfo.COVERFLOW_LAST_POSITION);
								
				if(p_policy==null||p_policy.equals("")){
					List<NameValuePair> params = new ArrayList<NameValuePair>(1);
					params.add(new BasicNameValuePair("result", p_error));
					setParams(params);
					loadUrl(LOGIN_URL);
				}else{
					if(p_policy.equals(Util.MOBILE_CONTRACT_AGREE)){
						//로그인 정보를 저장한다.
						if(autoLogin.equals("Y")){
							fi.setSettingInfo(getBaseContext(), "1", FileInfo.AUTO_SAVE);
						} else {
							fi.setSettingInfo(getBaseContext(), "", FileInfo.AUTO_SAVE);
						}
						
						fi.setSettingInfo(getBaseContext(), userid, FileInfo.ID);
						fi.setSettingInfo(getBaseContext(), userpw, FileInfo.PWD);
						
						Intent intent = new Intent(this.getIntent());
						String target = intent.getStringExtra("point");
						if(target==null||target.equals("")){
							cardMain();
						}else{
							goPoint();
						}						
					} else {
						Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.setting.AgreementView.class);
						intent.putExtra("m_policyUrl",m_policyUrl);
						intent.putExtra("id",userid);
						intent.putExtra("pwd",userpw);
						intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
						startActivity(intent);
						finish();
					}
				}
			}else{
				//List<NameValuePair> params = new ArrayList<NameValuePair>(1);
				//params.add(new BasicNameValuePair("result", p_error));
				//setParams(params);sf
//				AlertDialogMsgString(p_error);
				//AlertDialogMsg(R.string.network_error);
				//loadUrl(LOGIN_URL+"?result="+p_error);
				showAlert(p_error, new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int which) {
//						finish();
						hideCenterProgress();
					}
		    	});
			}
		}
	}
	
	private void cardMain(){
		Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.card.CardMainView.class);
		intent.putExtra("card_refresh", true) ;
		intent.putExtra("login", true) ;
		intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		startActivity(intent);
		finish();
	}
	
	private void goPoint(){
		Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.point.Point.class);
		intent.putExtra("login", true) ;
		intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		startActivity(intent);
		finish();
	}
	
	private void goMyPointCheckList(){
	}
	
	private void goStoreValueList(){
	}
	
	private void goLoginPage(){
	}
	
	public void goBack(){
		if(webV!=null && webV.canGoBack()){
			webV.goBack();
		} else {
			this.finish();
		}
	}
	
	private void parsingParam(String param){
		//param = "param1=hello&param2=hello2&param3=hello3";
		int from = 0;
		int to = 0;
		
		String param_name = "";
		String param_value = "";
		
		List<String> list_param_name = new ArrayList<String>();
		List<String> list_param_value = new ArrayList<String>();
		
		to = param.indexOf("=", from);
		//Debug.trace("DEBUG-->param",param);
		while(to!=-1){
			
			list_param_name.add(param.substring(from, to).trim());		
			from = to+1;
			
			to = param.indexOf("&", from);
			if(to==-1){
				list_param_value.add(param.substring(from, param.length()).trim());
			}else{				
				list_param_value.add(param.substring(from, to).trim());
				from = to+1;
				to = param.indexOf("=", from);
			}
		}
		
		List<NameValuePair> params = new ArrayList<NameValuePair>(list_param_name.size());
	
		for(int i =0;i<list_param_name.size();i++){
			
			param_name = (String)list_param_name.get(i);
			param_value = (String)list_param_value.get(i);		
			
			//Debug.trace("param_name",param_name);
			//Debug.trace("param_value",param_value);
			
			params.add(new BasicNameValuePair(param_name, param_value));
		}
		setParams(params);
	}
	
	private ProgressDialog mCustomProgressDlg;
  
	private void showCenterProgress(){
		ProgressBar progressBar = (ProgressBar)findViewById(R.id.progress_bar) ;
		progressBar.setVisibility(View.VISIBLE) ;
	}
	 
	private void hideCenterProgress(){
		ProgressBar progressBar = (ProgressBar)findViewById(R.id.progress_bar) ;
		progressBar.setVisibility(View.GONE) ;
	}
	
	/*lhr add*/
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		GSActivityManager.getActivityManager().addCreateActivity(this);
	}
	
	
	protected void onDestroy() {
		GSActivityManager.getActivityManager().deleteCreateActivity(this);
		super.onDestroy();
	}
	
	
	public void onBackPressed() {
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  

    	alt_bld.setMessage(R.string.program_terminate)  

    	.setCancelable(false)  
    	//.setIcon(R.drawable.icon)
    	
    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {
			
			public void onClick(DialogInterface dialog, int which) {
				Util.programExit(BaseWebActivity.this);
			}
    	})
    	
    	.setNeutralButton("취소", new DialogInterface.OnClickListener() {
			
			public void onClick(DialogInterface paramDialogInterface,
					int paramInt) {
			} 
    	});  

    	AlertDialog alert = alt_bld.create();  
    	// Title for AlertDialog  
    	alert.setTitle(R.string.alert_str);
    	// Icon for AlertDialog  
    	//alert.setIcon(R.drawable.icon); 
    	alert.show(); 
	}
	/*lhr end*/

	public void showAlert(int msg) {
		showAlert(msg, -1, null );
	}

	public void showAlert(String msg) {
		showAlert(msg, null, null );
	}
	public void showAlert(int msg, int buttonText) {
		showAlert(msg, buttonText, null );
	}

	public void showAlert(int msg, String buttonText) {
		showAlert(msg, buttonText, null );
	}

	public void showAlert(String msg, String buttonText) {
		showAlert(msg, buttonText, null );
	}

	public void showAlert(String msg, int buttonText) {
		showAlert(msg, buttonText, null );
	}
	public void showAlert(int msg, DialogInterface.OnClickListener onClick ){
		showAlert(msg, -1, onClick );
	}

	public void showAlert(String msg, DialogInterface.OnClickListener onClick ){
		showAlert(msg, -1, onClick );
	}

	public void showAlert(int msg, String buttonText, DialogInterface.OnClickListener onClick ){
		String strMsg    = getString(msg);
		showAlert(strMsg, buttonText, onClick );
	}

	public void showAlert(String msg, int buttonText, DialogInterface.OnClickListener onClick ){
		String strBtnTxt = buttonText!=-1?getString(buttonText):null;
		showAlert(msg, strBtnTxt, onClick );
	}

	public void showAlert(int msg, int buttonText, DialogInterface.OnClickListener onClick ){
		String strMsg    = getString(msg);
		String strBtnTxt = buttonText!=-1?getString(buttonText):null;
		showAlert(strMsg, strBtnTxt, onClick );
	}

	public void showAlert(String msg, String btnText, DialogInterface.OnClickListener onClick ) {
		String strBtnTxt = btnText != null?btnText:"확인";
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);
		alt_bld.setTitle(R.string.alert_str);
		alt_bld.setMessage(msg);
		alt_bld.setCancelable(false).setPositiveButton(
				strBtnTxt,
				onClick != null ? onClick
						: new DialogInterface.OnClickListener() {
							public void onClick(DialogInterface dialog,
									int which) {
							}
						});
        alt_bld.show();
    }	
	
	@Override
	protected void onPause() {
		// TODO Auto-generated method stub
		super.onPause();
		
		Boolean blogin=false;
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			blogin = extras.getBoolean("login");
		
		if(bPressHomekey){
			bPressHomekey=false;
			String set_pwd = this.fi.getSettingInfo(this, FileInfo.PASSWORD_SET);
			String app_pwd = this.fi.getSettingInfo(this, FileInfo.PASSWORD_MYAPP);
			
			boolean bSetPwd = false;
			if(set_pwd.equals("TRUE")){
				bSetPwd = true;
			}
			
			if(bSetPwd && !(app_pwd.equals(""))){
				Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.setting.SettingPwsetCheckView.class);
				intent.putExtra("login", blogin) ;
				intent.putExtra("homekey", true) ;
				intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
				startActivity(intent);
							
			}else{
				
			}
		}		
	}

	@Override
	protected void onUserLeaveHint() {
		// TODO Auto-generated method stub
		super.onUserLeaveHint();
		
		if(this.getLocalClassName().equals("setting.SettingPwsetCheckView"))
			bPressHomekey=false;
		else
			bPressHomekey=true;
	}
}