package com.webview.hotdeal;

import java.io.File;
import java.io.IOException;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.drawable.Drawable;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.Browser;
import android.provider.MediaStore;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.webkit.ValueCallback;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings.PluginState;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.Toast;

import com.google.android.gcm.GCMRegistrar;


//implements GeolocationPermissions.Callback

public class Web_View extends Activity implements View.OnClickListener {
	
	String devno="";
	String regId="123";
	String sid="123";
	 
    /** Called when the activity is first created. */
	WebView _webview = null;
	private LinearLayout mSplash;	
	private ProgressDialog progressDialog;	
	private static String PHONE_NUMBER;
	
 	private String iconFile="";
 	private String appname="";
 	private String mainUrl  = "http://brickstory.cafe24.com/m/index.php"; 
 	private String closeUrl = "";
 	private String name="";
 	
	private static final String INSTALL_SHORTCUT = "com.android.launcher.action.INSTALL_SHORTCUT"; 
	
	private boolean mIsBackButtonTouched = false;
	
    private ValueCallback<Uri> mUploadMessage;
    private final static int FILECHOOSER_RESULTCODE = 1;
    
    Intent intent_man;
    
    @Override
    protected  void onActivityResult(int requestCode, int resultCode,
            Intent intent) {
        if (requestCode == FILECHOOSER_RESULTCODE) {
            // kris 12.Dec.13 - TEST CODE
            // After
            if (null == mUploadMessage) {
                return;
            }
            Uri result = intent == null || resultCode != RESULT_OK ? null
                    : intent.getData();
            mUploadMessage.onReceiveValue(getTempUri());
            mUploadMessage = null;
            // Before
            /*
            if (null == mUploadMessage)
                return;
            Uri result = intent == null || resultCode != RESULT_OK ? null
                    : intent.getData();
            mUploadMessage.onReceiveValue(result);
            mUploadMessage = null;
            */
        }
    }
    
    @SuppressLint("NewApi")
	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main1);
        
        //requestWindowFeature(Window.FEATURE_LEFT_ICON);
        setContentView(R.layout.main);
        //setFeatureDrawableResource(Window.FEATURE_LEFT_ICON,R.drawable.baby);

        registGCM();
        
      //타켓주소 확인 
  		String turl=this.getIntent().getStringExtra("target");
  		
  		if(turl!=null){
  			
  			name=turl;
  		}else{
  			name="http://brickstory.cafe24.com/m/index.php";
  		}
      		
        _webview = (WebView) findViewById(R.id.webview);
        //_webview.setWebViewClient(new MyWebViewClient());
        _webview.getSettings().setJavaScriptEnabled(true);
        _webview.getSettings().setPluginState(PluginState. ON);
        
        _webview.getSettings().setJavaScriptEnabled(true);
        _webview.getSettings().setGeolocationEnabled(true);
        _webview.getSettings().setJavaScriptCanOpenWindowsAutomatically(true);
        
        final Activity activity = this; 
        
        mSplash = (LinearLayout) findViewById(R.id.loading);
//	    Drawable alpha = mSplash.getBackground();
//	    alpha.setAlpha(80);    
        _webview.setWebChromeClient(new WebChromeClient()
        {
        	
        	public void onGeolocationPermissionsShowPrompt(String origin, android.webkit.GeolocationPermissions.Callback callback) {
        	     callback.invoke(origin, true, false);
        	}
        	
               @SuppressWarnings("unused")
             public void openFileChooser(ValueCallback<Uri> uploadMsg, String acceptType, String capture) {
                mUploadMessage = uploadMsg;

                Intent intent = new Intent(Intent.ACTION_GET_CONTENT,
                        android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                intent.setType("image/*");
                intent.putExtra("crop", "true");
                intent.putExtra(MediaStore.EXTRA_OUTPUT, getTempUri());
                intent.putExtra("outputFormat", Bitmap.CompressFormat.JPEG.toString());
                startActivityForResult(intent, FILECHOOSER_RESULTCODE);

               }
               
               
               @Override
            public void onProgressChanged(WebView view, int newProgress) {
            	// TODO Auto-generated method stub
            	super.onProgressChanged(view, newProgress);
            	
            	if(newProgress < 100) {
            		Log.d("Test","로딩중");
            		mSplash.setVisibility(View.VISIBLE);
//                    Drawable alpha = mSplash.getBackground();
//                    alpha.setAlpha(newProgress);            		
                } else {
            		Log.d("Test","로딩완료.");                	
            		mSplash.setVisibility(View.INVISIBLE);
//                    mProgressBar.setVisibility(View.INVISIBLE);
//                    mProgressBar.setLayoutParams(new LinearLayout.LayoutParams(0, 0));
                }            	
            }
         });
        
        _webview.setWebViewClient(new MyWebViewClient(){   
        	 	        	 
        	  
        	 @Override
             public void onLoadResource (WebView view, String url) {
                 //show progress bar
                 if (progressDialog == null) {
                     progressDialog = new ProgressDialog(Web_View.this);
                     progressDialog.setMessage("Loading please wait...");
                     progressDialog.show();
                     progressDialog.setCanceledOnTouchOutside(false);
                     progressDialog.setCancelable(false);
                 }   
             }

             @Override
             public void onPageFinished(WebView view, String url) {
                 if (progressDialog.isShowing()) {
                     progressDialog.dismiss();
                 }
             }
        	
        	   @Override            
        	   public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {                 
        	    Toast.makeText(activity, "Loading Error"+description, Toast.LENGTH_SHORT).show();            
        	    }          
        	   
        	  }); 
        
		TelephonyManager telManager = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
		PHONE_NUMBER = telManager.getLine1Number().toString().trim();
		PHONE_NUMBER = PHONE_NUMBER.replace("82", "0").replace("-", "").replace("+82","0").replace("+","");
		PHONE_NUMBER = PHONE_NUMBER.replace("82", "0").replace("+82","0");	
        
		//name="http://www.mrhotdeal.co.kr/m/index_app_new.php";
		closeUrl="";
		
        Log.d("==============", name);
        
        System.out.println("11111112");
        
        _webview.loadUrl(name);
        //(findViewById(R.id.menu_one)).setOnClickListener(this);
        
        //createShortcutIntent();        
    }
    
       
   
    
    
   
private void registGCM() {
		// TODO Auto-generated method stub
		
	GCMRegistrar.checkDevice(this);
	GCMRegistrar.checkManifest(this);

	regId = GCMRegistrar.getRegistrationId(this);


	if("".equals(regId))   //구글 가이드에는 regId.equals("")로 되어 있는데 Exception을 피하기 위해 수정
		GCMRegistrar.register(this, GCMIntentService.SEND_ID);
	else
		GCMRegistrar.register(this, GCMIntentService.SEND_ID);
		Log.d("==============", regId);
		
	}






private class MyWebViewClient extends WebViewClient {

    	 private ValueCallback<Uri> mUploadMessage;
    	 
    	 private final static int FILECHOOSER_RESULTCODE = 1;
    	 protected  void onActivityResult(int requestCode, int resultCode,
    	         Intent intent) {
    	     if (requestCode == FILECHOOSER_RESULTCODE) {
    	         if (null == mUploadMessage)
    	             return;
    	         Uri result = intent == null || resultCode != RESULT_OK ? null
    	                 : intent.getData();
    	         mUploadMessage.onReceiveValue(result);
    	         mUploadMessage = null;
    	     }
    	 }
    	 
    	 
    	@SuppressWarnings("unused")
        public void openFileChooser(ValueCallback<Uri> uploadMsg, String acceptType, String capture) {
              mUploadMessage = uploadMsg;
              Intent i = new Intent(Intent.ACTION_GET_CONTENT);
              i.addCategory(Intent.CATEGORY_OPENABLE);
              i.setType("*/*");
              Web_View.this.startActivityForResult(
                      Intent.createChooser(i, "선택"),
                      FILECHOOSER_RESULTCODE);
          }
    	
	    
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
        	
        	Log.d("url",url);
        	
        	if(url.startsWith("http://file_down")) {
        		
    	        Intent call_phone = new Intent(Intent.ACTION_VIEW , Uri.parse("http://brickstory.cafe24.com/m/data/file/photo/2039442237_qLsVFtMc_1397867303233.jpg")) ;
    	        startActivity(call_phone) ;   
    	        return true;
    	        
    	    }
        	 
        	if(("kakaolink").equals(url.substring(0,9))){
    			loadkakao(url);
    		}
        	
        	if(("extern").equals(url.substring(0,9))){
    			loadkakao(url);
    		}
        	
        	else if(("storylink").equals(url.substring(0,9))){
    			loadkakao(url);
    		}
        	
        	else if(("story").equals(url.substring(0,9))){
    			loadkakao(url);
    		}
        	else if(url.startsWith("http://youtu")){
    			loadkakao(url);
    		}
    		else{
    			view.loadUrl(url);
    		}
    		
    		 return true;
        }

        

        
      //for Enabling kakaotalk link
        public void loadkakao(String url){
        	Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(url));
        	intent.addCategory(Intent.CATEGORY_BROWSABLE);
        	intent.putExtra(Browser.EXTRA_APPLICATION_ID,getPackageName());
        	startActivity(intent);
        }
    }    
    


	public boolean onKeyDown(int keyCode, KeyEvent event) {

	if ((keyCode == KeyEvent.KEYCODE_BACK)) {
		
		Log.d("tag",_webview.getUrl());
		
		if(_webview.getUrl().equals("http://brickstory.cafe24.com/m/index.php"))
		{
			Log.w("BK", "finish");
			
			new AlertDialog.Builder(this)
			.setIcon(R.drawable.block1)
			.setTitle("벽돌이야기")
			.setMessage("종료하시겠습니까?")
			.setPositiveButton("확인",
					new DialogInterface.OnClickListener() {

						public void onClick(DialogInterface dialog,
								int which) {
							// TODO Auto-generated method stub
							
							moveTaskToBack(true);
							finish();
							android.os.Process.killProcess(android.os.Process.myPid());
							System.exit(0);
							
							
						}
					}).setNegativeButton("아니오", null).show();
		}else{
			_webview.goBack();
		}
		return true;
		
	}
		return false;
	
}
	
	private static final String TEMP_PHOTO_FILE = "temp.jpg";

    private boolean isMountedSdCard() {
        String status = Environment.getExternalStorageState();
        if (status.equals(Environment.MEDIA_MOUNTED))
            return true;
        return false;
    }

    private File getTempFile() {
        if (isMountedSdCard()) {
            File file = new File(Environment.getExternalStorageDirectory(),
                    TEMP_PHOTO_FILE);
            try {
                file.createNewFile();
            } catch (IOException e) {

            }
            return file;
        } else
            return null;
    }
    
    private Uri getTempUri() {
        return Uri.fromFile(getTempFile());
    }
	//

	public void onClick(View v) {
		// TODO Auto-generated method stub
		
	}

}