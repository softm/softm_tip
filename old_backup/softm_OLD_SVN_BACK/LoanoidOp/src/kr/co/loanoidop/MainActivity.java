package kr.co.loanoidop;

import com.google.gson.Gson;
import com.softforum.xas.XecureAppShield;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.ApplicationInfo;
import android.graphics.drawable.Drawable;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.Message;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.webkit.ConsoleMessage;
import android.webkit.JavascriptInterface;
import android.webkit.JsResult;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.LinearLayout.LayoutParams;
import android.widget.ProgressBar;
import android.widget.Toast;

/**
 * MainActivity
 * @author softm
 *
 */
@SuppressLint("SetJavaScriptEnabled")
public class MainActivity extends Activity {
	final String TAG = "Loanoid";
	final Activity activity = this;
	private WebView mWebView = null;
	private Dialog mProgress;

	private DoProgress doProgress;
	private ProgressDialog dialog;
	String mErrorMessage = new String();

	@SuppressLint("NewApi")
	public Drawable getDrawable(Context context, int id) {
	    final int version = Build.VERSION.SDK_INT;
	    if (version >= Build.VERSION_CODES.LOLLIPOP) {
	        return context.getDrawable(id);
	    } else {
	        return context.getResources().getDrawable(id);
	    }
	}

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		// FIXME:  XecureAppShield의 서버URL / APPID / 버전 / 라이브업데이트 사용유무를 입력합니다.
//		Constants.XAS_DOMAIN = "http://192.168.70.171:18080/xasService/";
//		Constants.XAS_APPID = "test_android";
//		Constants.XAS_APPVER = "1";
//		Constants.XAS_LIVE_UPDATE = false;
//    	/** XAS의 context를 설정한다.
//		 *
//		 *  @param string 		도메인
//		 *  @param string 		App 아이디
//		 *  @param String 		App 버전
//		 *  @param boolean 	라이브업데이트 사용여부
//		 */
		XecureAppShield.getInstance().setXASContext(
			  "http://auth.charmloan.co.kr/xasService/",
//				"http://1.237.174.154:8888/xasService/",
				"loanoid",
				"1.0",
				false
		);
//
    	doProgress = new DoProgress();
		doProgress.execute();
// ----------------- ---------------------------------------------- ----------------------------------------------

		setContentView(R.layout.activity_main);

		mProgress = new Dialog(this, R.style.MyDialog);
		mProgress.setCancelable(true);
		ProgressBar pbar = new ProgressBar(this);
		            pbar.setIndeterminateDrawable(getDrawable(this,R.drawable.progress_bar_custom));

		mProgress.addContentView(pbar, new LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT));
		mProgress.setCanceledOnTouchOutside(false);

		mWebView = (WebView) findViewById(R.id.webview);
		mWebView.addJavascriptInterface(new WebAppInterface(this), "Android");
		WebSettings webSettings = mWebView.getSettings();
		webSettings.setJavaScriptEnabled(true);
		webSettings.setCacheMode(WebSettings.LOAD_NO_CACHE);

		webSettings.setJavaScriptCanOpenWindowsAutomatically(true); // javascript가 window.open()을 사용할 수 있도록 설정
		webSettings.setSupportMultipleWindows(false); // 여러개의 윈도우를 사용할 수 있도록 설정
		webSettings.setDomStorageEnabled(true);

		//webSettings.setJavaScriptCanOpenWindowsAutomatically(true); // javascript가 window.open()을 사용할 수 있도록 설정
/*
*/
		//mWebView.loadUrl("http://127.0.0.1/loan/index.jsp");
//		mWebView.loadUrl("http://www.naver.com");
		//mWebView.loadUrl("http://192.168.219.135:8080/index.jsp");
//		mWebView.loadUrl(getResources().getString(R.string.start_url_bak));

//		String host = getResources().getString(R.string.host);
//		String startUrl = getResources().getString(R.string.start_url);
//		Toast.makeText(activity, host + startUrl, 1000).show();
//		mWebView.setWebViewClient(new WebViewClientClass());
//		mWebView.setWebChromeClient(new WebChromeClientClass());
//		mWebView.loadUrl(host + startUrl);

	}

// WebView Class --------------------------------------------------------------------------- end //
	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent intent){

		super.onActivityResult(requestCode, resultCode, intent);

		switch(requestCode){

		case WUtil.REQUEST_OZVIEW_OPEN:
			if(resultCode == RESULT_OK) {
				String json = WUtil.toDefault(intent.getExtras().getString("data"));
				WUtil.webScript(mWebView, json);
			}
			break;
		}
	}

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		String curUrl = WUtil.toDefault(mWebView.getUrl());
		if (
			curUrl.indexOf("loginView") > -1
		 || curUrl.indexOf("mainView") > -1
		) {
			new AlertDialog.Builder(this)
			// .setIcon(R.drawable.block1)
			// .setTitle(R.string.app_name)
			.setMessage(R.string.msg_finish_confirm).setPositiveButton(R.string.alert_yes_str, new DialogInterface.OnClickListener() {
				@Override
				public void onClick(DialogInterface dialog, int which) {
					moveTaskToBack(true);
					finish();
					android.os.Process.killProcess(android.os.Process.myPid());
					System.exit(0);
				}
			}).setNegativeButton(R.string.alert_no_str, null).show();
			return true;
		} else {
			if ((keyCode == KeyEvent.KEYCODE_BACK) && mWebView.canGoBack()) {
				mWebView.goBack();
				return true;
			} else {
				new AlertDialog.Builder(this)
						// .setIcon(R.drawable.block1)
						// .setTitle(R.string.app_name)
						.setMessage(R.string.msg_finish_confirm).setPositiveButton(R.string.alert_yes_str, new DialogInterface.OnClickListener() {
							@Override
							public void onClick(DialogInterface dialog, int which) {
								moveTaskToBack(true);
								finish();
								android.os.Process.killProcess(android.os.Process.myPid());
								System.exit(0);
							}
						}).setNegativeButton(R.string.alert_no_str, null).show();
			}
			return super.onKeyDown(keyCode, event);
		}
	}

	// WebView Class --------------------------------------------------------------------------- start //
	private class WebViewClientClass extends WebViewClient {
		@Override
		public boolean shouldOverrideUrlLoading(WebView view, String url) {
			view.loadUrl(url);
			return true;
		}

		@Override
		public void onLoadResource(WebView view, String url) {
			// show progress bar
//			mProgress.show();
		}

		@Override
		public void onPageFinished(WebView view, String url) {
/*			if (mProgress.isShowing()) {
				mProgress.dismiss();
			}*/
	        super.onPageFinished(view, url);
            //mWebView.clearHistory(); // remove history
		}

		@Override
		public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {
			Toast.makeText(activity, "Loading Error" + description, Toast.LENGTH_SHORT).show();
		}

	}

	private class WebChromeClientClass extends WebChromeClient {
		@Override
		public void onGeolocationPermissionsShowPrompt(String origin,
				android.webkit.GeolocationPermissions.Callback callback) {
			callback.invoke(origin, true, false);
		}

		@Override
		public void onProgressChanged(WebView view, int newProgress) {
			super.onProgressChanged(view, newProgress);
			if (newProgress < 100) {
				Log.d("Test", "로딩중");
				///// >mSplash.setVisibility(View.VISIBLE);
				// Drawable alpha = mSplash.getBackground();
				// alpha.setAlpha(newProgress);
				if (!mProgress.isShowing()) {
					mProgress.show();
				}
			} else {
				Log.d("Test", "로딩완료.");
				////// >mSplash.setVisibility(View.INVISIBLE);
				// mProgressBar.setVisibility(View.INVISIBLE);
				// mProgressBar.setLayoutParams(new LinearLayout.LayoutParams(0,
				// 0));
				if (mProgress.isShowing()) {
					mProgress.dismiss();
				}
			}
		}

		 @Override
		  public boolean onJsAlert(WebView view, String url, String message, final JsResult result) {

		   //return super.onJsAlert(view, url, message, result);
		    new AlertDialog.Builder(view.getContext())
//		        .setTitle(R.string.alert_str)
		        .setMessage(message)
		        .setPositiveButton(android.R.string.ok,
		              new AlertDialog.OnClickListener(){
		                 @Override
						public void onClick(DialogInterface dialog, int which) {
		                  result.confirm();
		                 }
		              })
		        .setCancelable(false)
		        .create()
		        .show();
		   return true;
		  }
		  @Override
		  public boolean onJsConfirm(WebView view, String url, String message,
		    final JsResult result) {
		   //return super.onJsConfirm(view, url, message, result);
		   new AlertDialog.Builder(view.getContext())
//		        .setTitle(R.string.alert_confirm_str)
		        .setMessage(message)
		        .setPositiveButton(R.string.alert_yes_str,
		              new AlertDialog.OnClickListener(){
		                 @Override
						public void onClick(DialogInterface dialog, int which) {
		                  result.confirm();
		                 }
		              })
		        .setNegativeButton(R.string.alert_no_str,
		          new AlertDialog.OnClickListener(){
		                @Override
						public void onClick(DialogInterface dialog, int which) {
		                 result.cancel();
		                }
		             })
		        .setCancelable(false)
		        .create()
		        .show();
		   return true;
		  }

		@Override
		public boolean onConsoleMessage(ConsoleMessage consoleMessage) {
		        String line = consoleMessage.message() + " " + consoleMessage.sourceId() + ":" + consoleMessage.lineNumber();
		        ConsoleMessage.MessageLevel level = consoleMessage.messageLevel();
		        if (level == ConsoleMessage.MessageLevel.TIP)
		          Log.v(TAG, line);
		        else if (level == ConsoleMessage.MessageLevel.DEBUG)
		          Log.d(TAG, line);
		        else if (level == ConsoleMessage.MessageLevel.LOG)
		          Log.i(TAG, line);
		        else if (level == ConsoleMessage.MessageLevel.WARNING)
		          Log.w(TAG, line);
		        else if (level == ConsoleMessage.MessageLevel.ERROR)
		          Log.e(TAG, line);
		        return true;
		}

			@Override
		    public boolean onCreateWindow(WebView view, boolean dialog, boolean userGesture, Message resultMsg) {
		        Log.d(TAG, "onCreateWindow ");
		 /*       WebView newWebView = new WebView(activity);

		        WebView.WebViewTransport transport = (WebView.WebViewTransport)resultMsg.obj;
		        transport.setWebView(newWebView);
		        resultMsg.sendToTarget();
		         */

		        WebView newWebView = new WebView(MainActivity.this);
		        newWebView.setWebChromeClient(new WebChromeClient() {
		         @Override
		          public void onCloseWindow(WebView window) {
		                window.setVisibility(View.GONE);
		               mWebView.removeView(window);
		          }
		        });
		        mWebView.addView(newWebView);
		        WebView.WebViewTransport transport = (WebView.WebViewTransport) resultMsg.obj;
		        transport.setWebView(newWebView);
		        resultMsg.sendToTarget();

		        return true;
		    }
	}

	private class WebBasicInformation{

	    private String macAddress;

		public String getMacAddress() {
	        return macAddress;
		}

		public void setMacAddress(String macAddress) {
			this.macAddress = macAddress;
		}
	}

	/**
	 * javascript interface
	 */
	private class WebAppInterface {
		Context mContext;

		/** Instantiate the interface and set the context */
		WebAppInterface(Context c) {
			mContext = c;
		}
		@JavascriptInterface
		public String testValue(String v) {
			return v;
		}

		@JavascriptInterface
		public String getBasicInformation() {
			Gson gson = new Gson();
			WebBasicInformation data = new WebBasicInformation();
			data.setMacAddress(WUtil.getMacAddress("wlan0"));
			return gson.toJson(data);
		}

		/** Show a toast from the web page */
		@JavascriptInterface
		public void showToast(String toast) {
			Toast.makeText(mContext, toast, Toast.LENGTH_SHORT).show();
		}

		@JavascriptInterface
		public void showLoading() {
			hideLoading();
			if (!mProgress.isShowing()) {
		        runOnUiThread(new Runnable() {
		            @Override
					public void run() {
		              mProgress.show();
		            }
		        });
			}
		}

		@JavascriptInterface
		public void hideLoading() {
			if (mProgress.isShowing()) {
		        runOnUiThread(new Runnable() {
		            @Override
					public void run() {
		              mProgress.dismiss();
		            }
		        });
			}
		}
		@JavascriptInterface
		public void openOZ(String ozr,String params) {
		    Toast.makeText (mContext, "ozr : " + ozr, Toast.LENGTH_SHORT).show();
		    Log.d("openOZ", ozr);
			//WUtil.openOZ(mCoXntext,ozr);
			WUtil.openOZ(MainActivity.this,ozr,params);
		}

		@JavascriptInterface
		public String getXASToken()
		{
			Log.d("XecureAppShield", "------------------------------ webview called");
			return XecureAppShield.getInstance().getSID() + ","+ XecureAppShield.getInstance().getToken();
		}
	}
// WebView Class --------------------------------------------------------------------------- end //

    private class DoProgress extends AsyncTask<Integer, Void, Integer> {
    	@Override
		protected void onPreExecute() {
			dialog = new ProgressDialog(MainActivity.this);
			dialog.setMessage("무결성 검증을 진행중입니다.");

			dialog.setIndeterminate(true);
			dialog.setCancelable(true);
			dialog.setOnCancelListener(new DialogInterface.OnCancelListener() {

				@Override
				public void onCancel(DialogInterface dialog) {
					doProgress.cancel(true);
				}
			});
			dialog.show();

			super.onPreExecute();
		}

		@Override
		protected Integer doInBackground(Integer... params) {
			/*
			 *  App무결성 검증을 수행한다.
			 */
			boolean isDebuggable = ( 0 != (getApplicationInfo().flags & ApplicationInfo.FLAG_DEBUGGABLE));
			Log.d("XecureAppShield", "is Debuggable? " + isDebuggable);
			Log.d("XecureAppShield", "------------  checkApp execute  ------------");

			/*
			 *  사용자 식별정보 :
			 *  - 무결성 검증 결과에 대한 사용자 식별정보가 있다면 전달한다.
			 *  - null일 경우 default 식별정보가 전달되며
			 *  - 1차 사용자 폰번호 수집
			 *  - 실패시 2차 IMEI수집
			 *  - 모두 실패시 식별정보는 수집되지 않는다.
			 */

			String aIdentifier = null;

			Log.d("XecureAppShield", "lib path = " + getApplicationContext().getApplicationInfo().nativeLibraryDir);

//			int result = XecureAppShield.getInstance().checkApp(getApplicationContext(), aIdentifier);
			int result = XecureAppShield.getInstance().checkApp(getApplicationContext());

//			if( result == XecureAppShield.getInstance().UPDATE_CODE)
//			{
//				 Log.d("XecureAppShield", "------------  XAS_SO_UPDATE  ------------");
//				 this.publishProgress();
//
//				 /*
//				  *  so 모듈 다운로드 url 로그 및 라이브업데이트 수행
//				  */
//				 Log.d("XecureAppShield", "URL : " + XecureAppShield.getInstance().getUpdateURL());
//				 result  = XecureAppShield.getInstance().SOUpdate(XecureAppShield.getInstance().getUpdateURL());
//				 mErrorMessage = XecureAppShield.getInstance().GetErrorMsg(result);
//
//				 /*
//				  * 라이브업데이트 결과 로그 및 UPDATE_RESULT Instance 변수에 결과를 알려준다.
//				  */
//				 Log.d("XecureAppShield", "XAS_SO_UPDATE_RESULT : " + result);
//				 Log.d("XecureAppShield", "XAS_SO_UPDATE_MESSAGE : " + mErrorMessage);
//
//				if(result== XecureAppShield.getInstance().SUCCESS_CODE)
//					XecureAppShield.getInstance().UPDATE_RESULT = true;
//			}

			return	result;
		}

		@Override
		protected void onProgressUpdate(Void... values) {
			super.onProgressUpdate(values);

			dialog.setMessage("보안모듈 업데이트를 진행중입니다");
		}

		@Override
		protected void onPostExecute(Integer result) {

			/*
			 * UPDATE_RESULT Instance 변수값이 성공이면
			 * 반드시 앱을 완전히 종료후 리스타트 해줘야한다.
			 */
			if(XecureAppShield.getInstance().UPDATE_RESULT)
    		{
//    			Intent mainIntent = new Intent(MainActivity.this, StartScreen.class);
//    			   mainIntent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP  );
//    			   startActivity(mainIntent);
    			   destroy();
    		}

			/*
			 * 앱 무결성 검증 결과 출력 및 성공일 경우
			 * 토큰 검증을 위한 인터페이스를 노출한다.
			 * 본 데모에서는 로그인버튼을 출력한다.
			 */
			mErrorMessage = XecureAppShield.getInstance().GetErrorMsg(result);

			Log.d("XecureAppShield", "XAS_RESULT : " + result);
			Log.d("XecureAppShield", "XAS_MESSAGE : " + mErrorMessage);

			dialog.dismiss();
			doProgress.cancel(true);

//			TextView Text = (TextView)findViewById(R.id.integrity_check_textview);
//    		Text.setText(result+ "\n" + mErrorMessage);

    		/*
    		 * 무결성 검증이 성공이면 token 검증수행을 위한 버튼출력
    		 */
//    		if(result == XecureAppShield.getInstance().SUCCESS_CODE)
//			{
//				Button btn = (Button)findViewById(R.id.token_button);
//    			btn.setVisibility(View.VISIBLE);
//    			Button btn2 = (Button)findViewById(R.id.token_button_webview);
//    			btn2.setVisibility(View.VISIBLE);
//			}

    		if(result == XecureAppShield.getInstance().SUCCESS_CODE)
// 			if(result != XecureAppShield.getInstance().SUCCESS_CODE)
			{
    			Log.d ("XecureAppShield", "SessionID = " + XecureAppShield.getInstance().getSID());
    			Log.d ("XecureAppShield", "Token = "     + XecureAppShield.getInstance().getToken());

    			String host = getResources().getString(R.string.host);
    			String startUrl = getResources().getString(R.string.start_url);
    			Toast.makeText(activity, host + startUrl, 1000).show();
    			mWebView.setWebViewClient(new WebViewClientClass());
    			mWebView.setWebChromeClient(new WebChromeClientClass());
    			mWebView.loadUrl(host + startUrl);
			} else {
				new AlertDialog.Builder(MainActivity.this)
				// .setIcon(R.drawable.block1)
				// .setTitle(R.string.app_name)
				.setMessage("무결성 검증중 에러가 발생하였습니다.\n" + mErrorMessage + " / ["+result+"]").setPositiveButton(R.string.alert_yes_str, new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						moveTaskToBack(true);
						finish();
						android.os.Process.killProcess(android.os.Process.myPid());
						System.exit(0);
					}
				}).show();
			}
		}

		@Override
		protected void onCancelled() {
			super.onCancelled();
		}

    }

    private void destroy() {

    	android.util.Log.d("XecureAppShield", " Destroy ___________________________");
		android.os.Process.killProcess(android.os.Process.myPid());
    }


}


