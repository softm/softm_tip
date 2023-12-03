package kr.co.gscaltex.gsnpoint;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.List;

import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.GSActivityManager;
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
import org.apache.http.params.CoreProtocolPNames;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Rect;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.util.DisplayMetrics;
import android.view.Gravity;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.FrameLayout.LayoutParams;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.Toast;

public abstract class BaseActivity extends Activity {
	public static final String LOG_TAG = "GS";

	private final Context mApp = this;	
	
	private String xml_string = "";
	private List<NameValuePair> nameValuePairs;	
	protected String result_tag="";
	protected String error="";
	private FileInfo fi = new FileInfo();
	private Boolean bPressHomekey = false;
	private Boolean bStartPW = false;
	private DefaultApplication mApplication;
	/**
	 * @var  App 사용가이드 GSAppHelper
	 * @see GSAppHelper
	 */
	protected GSAppHelper appHelper;
	public GSAppHelper getAppHelper() {
		return appHelper;
	}

	protected abstract void httpResult(int what, boolean result, String kind);

	protected void setParams(List<NameValuePair> params){
		this.nameValuePairs=params;
	}
	
	protected void goErrorUrl(){
		Intent i = new Intent(Intent.ACTION_VIEW);
		Uri u = Uri.parse(error);
		i.setData(u);
		i.setFlags(i.FLAG_ACTIVITY_NO_USER_ACTION);
		startActivity(i);
		finish();
	}

	protected void loadUrl(final int arg1, final String URL, final String kind ){
		//Debug.trace(LOG_TAG, "loadUrl start.." + "[" + arg1 + "] " + URL ) ;
		 
		new Thread(new Runnable() {
		
			
			public void run() {
				boolean result = false;
				//Debug.trace(LOG_TAG, "loadUrl start..") ;
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
					
					//Debug.trace(LOG_TAG, "loadUrl step-..") ;
					response = httpclient.execute(httppost);
					//Debug.trace(LOG_TAG, "loadUrl step0..") ;
					if (response.getStatusLine().getStatusCode() != HttpStatus.SC_OK) {
					}else{
						HttpEntity entity = response.getEntity();			
						//Debug.trace(LOG_TAG, "loadUrl step1..") ;
						if (entity == null) {
						}else{
							if(entity != null){
								//Debug.trace(LOG_TAG, "loadUrl step2..") ;
								InputStream inputStream = entity.getContent();		
								//Debug.trace(LOG_TAG, "loadUrl step3..") ;
								
								xml_string = convertStreamToString(inputStream);
								//Debug.trace(LOG_TAG, "BEGIN xml_string===============") ;
								//Debug.trace(LOG_TAG, xml_string) ;
								//Debug.trace(LOG_TAG, "END xml_string===============") ;
								
								//Debug.trace(LOG_TAG, "loadUrl step4..") ;
								httpclient.getConnectionManager().shutdown();
								//Debug.trace(LOG_TAG, "loadUrl step5..") ;
							}
							//Debug.trace(LOG_TAG, "loadUrl end..") ;
							result = true;
						}
					}			
				} catch (ClientProtocolException e) {			
				} catch (IOException e) {			
				} finally {
					httpclient.getConnectionManager().shutdown();
					sendMessage(0,  arg1, Boolean.valueOf(result), kind);
				}
			}
		}).start();
	}

	private void sendMessage(int what, int arg1, Boolean obj, String kind) {
		//Debug.trace(LOG_TAG, "sendMessage : " + what + "," + arg1 + "," + obj) ;
		Message msg = handler.obtainMessage(what, obj);
		Bundle bundle = new Bundle() ;
		bundle.putInt("event_code", arg1) ;
		bundle.putString("kind", kind) ;
		msg.setData(bundle);
		handler.sendMessage(msg);
	}

	final Handler handler = new Handler() {
		public void handleMessage(Message msg) {
			// TODO Auto-generated method stub
		 
			int event_code = msg.getData().getInt("event_code") ;
			Boolean result = (Boolean)msg.obj;
			String kind = (String)msg.getData().getString("kind") ;
			//Debug.trace(LOG_TAG,"BaseActivity handler message" + "[" + event_code + "] result:" + result) ;
			httpResult(event_code, result.booleanValue(), kind); 
			
		}
	} ;

	protected String getString() {
		return xml_string;
	}
	
	protected Runnable viewToastRunnable = new Runnable(){
		public void run() {
			viewToast();
		}		
	};
	
	private void viewToast(){
		//Debug.trace("error",error);
		Toast t = Toast.makeText(this, error, Toast.LENGTH_SHORT); 
		t.show();
	}
	
	private String convertStreamToString(InputStream is) {
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

	private ProgressDialog mCustomProgressDlg = null;
	
	protected void showCenterProgress(){
		
		ProgressBar progressBar = (ProgressBar)findViewById(R.id.progress_bar) ;
		//Debug.trace(LOG_TAG,"BaseActivity showCenterProgress:" + progressBar) ;
		progressBar.setVisibility(View.VISIBLE) ; 

	}
	 
	protected void hideCenterProgress(){
		ProgressBar progressBar = (ProgressBar)findViewById(R.id.progress_bar) ;
		progressBar.setVisibility(View.GONE) ;

	}

	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		GSActivityManager.getActivityManager().addCreateActivity(this);
		mApplication = (DefaultApplication)getApplicationContext();
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
				Util.programExit(BaseActivity.this);
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
		
		Debug.trace("test", "this.getLocalClassName()is.."+ this.getLocalClassName());
		
		if(this.getLocalClassName().equals("setting.SettingPwsetCheckView"))
			bPressHomekey=false;
		else
			bPressHomekey=true;
		
	}
}