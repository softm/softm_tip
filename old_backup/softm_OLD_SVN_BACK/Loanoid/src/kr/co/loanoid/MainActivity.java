package kr.co.loanoid;

import com.google.gson.Gson;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.drawable.Drawable;
import android.os.Build;
import android.os.Bundle;
import android.os.Message;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.webkit.ConsoleMessage;
import android.webkit.JavascriptInterface;
import android.webkit.JsResult;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.LinearLayout.LayoutParams;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
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

		webSettings.setJavaScriptCanOpenWindowsAutomatically(true); // javascript�� window.open()�� ����� �� �ֵ��� ����
		webSettings.setSupportMultipleWindows(false); // �������� �����츦 ����� �� �ֵ��� ����
		webSettings.setDomStorageEnabled(true);

		//webSettings.setJavaScriptCanOpenWindowsAutomatically(true); // javascript�� window.open()�� ����� �� �ֵ��� ����
/*
*/
		//mWebView.loadUrl("http://127.0.0.1/loan/index.jsp");
//		mWebView.loadUrl("http://www.naver.com");
		//mWebView.loadUrl("http://192.168.219.135:8080/index.jsp");

		String host = getResources().getString(R.string.host);
		String startUrl = getResources().getString(R.string.start_url);
		Toast.makeText(activity, host + startUrl, 1000).show();
		mWebView.setWebViewClient(new WebViewClientClass());
		mWebView.setWebChromeClient(new WebChromeClientClass());
		mWebView.loadUrl(host + startUrl);
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
				Log.d("Test", "�ε���");
				///// >mSplash.setVisibility(View.VISIBLE);
				// Drawable alpha = mSplash.getBackground();
				// alpha.setAlpha(newProgress);
				if (!mProgress.isShowing()) {
					mProgress.show();
				}
			} else {
				Log.d("Test", "�ε��Ϸ�.");
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
		public void hideKeyboard() {
			InputMethodManager im = (InputMethodManager)getSystemService(INPUT_METHOD_SERVICE);
			im.hideSoftInputFromWindow(getCurrentFocus().getWindowToken(), InputMethodManager.HIDE_NOT_ALWAYS);
		}

		@JavascriptInterface
		public void setKeyboard(final boolean b) {
	        runOnUiThread(new Runnable() {
	            @Override
				public void run() {
//	            	getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN
//	        				);
//	                ((InputMethodManager) getSystemService(Activity.INPUT_METHOD_SERVICE))
//	                .toggleSoftInput(0, InputMethodManager.HIDE_IMPLICIT_ONLY);

	                // Check if no view has focus:
//	                View view = activity.getCurrentFocus();
//	                if (view != null) {
//	                    InputMethodManager inputManager = (InputMethodManager) activity.getSystemService(Context.INPUT_METHOD_SERVICE);
//	                    inputManager.hideSoftInputFromWindow(view.getWindowToken(), InputMethodManager.HIDE_NOT_ALWAYS);
//	                }
	            	if ( b == false ) {

	            		((RelativeLayout)mWebView.getParent()).setDescendantFocusability(ViewGroup.FOCUS_BLOCK_DESCENDANTS);

	            		//(ViewGroup)mWebView.getParent().setDescendantFocusability
	            		mWebView.setFocusable(false);
	            		mWebView.setFocusableInTouchMode(true);
	            	} else {
		                ((RelativeLayout)mWebView.getParent()).setDescendantFocusability(ViewGroup.FOCUS_AFTER_DESCENDANTS);
		                mWebView.setFocusable(true);
		                mWebView.setFocusableInTouchMode(true);
	            	}

	            }
	        });
		}

	}
// WebView Class --------------------------------------------------------------------------- end //
}
