package kr.co.gscaltex.gsnpoint;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.SocketTimeoutException;
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
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.CoreProtocolPNames;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Environment;
import android.os.SystemClock;
import android.util.Log;
import android.view.GestureDetector;
import android.view.MotionEvent;
import android.view.View;
import android.view.GestureDetector.SimpleOnGestureListener;
import android.view.View.OnClickListener;
import android.view.View.OnTouchListener;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageButton;
import android.widget.ProgressBar;
import android.widget.ViewFlipper;

import com.google.android.maps.MapActivity;

public class BaseMapActivity extends MapActivity {
	public static final String LOG_TAG = "GS";

	public static final int TAB_BUTTON_COUNT = 8;
//	public static final int[] TAB_BUTTON_RESOURCE_IDS = {
//		R.drawable.m_event_on,
//		R.drawable.m_mobilecard_on,
//		R.drawable.m_point_on,
//		R.drawable.m_shopsearch_on,
//		R.drawable.m_partner_on,
//		R.drawable.m_faq_on,
//		R.drawable.m_shopsearch_on,
//		R.drawable.m_point_on,
//		R.drawable.m_config_on
//	};

	private DefaultApplication mApplication;
	private GestureDetector mGestureDetector;

	private Animation mSlideLeftIn;
	private Animation mSlideLeftOut;
	private Animation mSlideRightIn;
	private Animation mSlideRightOut;

	private ViewFlipper mViewFlipper;
	private ImageButton[] mButtons = new ImageButton[TAB_BUTTON_COUNT];
	
	private String xml_string = "";
	private List<NameValuePair> nameValuePairs;
	
	private String URL = Util.DATA_CONNECT;
	
	private FileInfo fi = new FileInfo();
	private Boolean bPressHomekey = false;
	
	protected void setParams(List<NameValuePair> params){
		this.nameValuePairs=params;
	}
	/**
	 * @var  App 사용가이드 GSAppHelper
	 * @see GSAppHelper
	 */
	protected GSAppHelper appHelper;
	public GSAppHelper getAppHelper() {
		return appHelper;
	}
	protected void termiate(){
    	AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  

    	alt_bld.setMessage(R.string.program_terminate)  

    	.setCancelable(false)  
    	//.setIcon(R.drawable.icon)
    	
    	.setPositiveButton("Ȯ��", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int which) {
				finish();
			}
    	})
    	
    	.setNeutralButton("���", new DialogInterface.OnClickListener() {
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
	
	protected void loadUrl(String URL){
		
		HttpClient httpclient = new DefaultHttpClient();   
        HttpPost httppost = new HttpPost(URL);
		HttpResponse response;
		
		try {
			if(nameValuePairs==null||nameValuePairs.equals("")){				
			}else{
				httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs,"UTF-8"));
			}
			httpclient.getParams().setParameter(CoreProtocolPNames.USER_AGENT, "Client1");
			response = httpclient.execute(httppost);
			HttpEntity entity = response.getEntity();			
			
	        if(entity != null){
	        	InputStream inputStream = entity.getContent();	        	
	        	xml_string = convertStreamToString(inputStream);
	        }
		} catch (ClientProtocolException e) {			
			e.printStackTrace();
		} catch (IOException e) {			
			e.printStackTrace();
		} 
		
		httpclient.getConnectionManager().shutdown();
	}
	
	protected String getString(){
		return xml_string;
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
	
	protected boolean download(String ver){
		/*isj add*/
		List<NameValuePair> para = new ArrayList<NameValuePair>(2);
		para.add(new BasicNameValuePair("process_code", "storeInfo"));
		para.add(new BasicNameValuePair("ver",ver));
		nameValuePairs = para;	
		/*isj add*/
		/*lhr modify*/
		int httpResult = 0;
		
		int start = URL.indexOf('h', 0);
		String url = URL.substring(start, URL.trim().length());
		
		HttpClient client = new DefaultHttpClient();
		HttpParams params = client.getParams();
		HttpConnectionParams.setConnectionTimeout(params, 10000);
		HttpConnectionParams.setSoTimeout(params, 30000);
		HttpPost httPost = new HttpPost(url);
		
		try {
			if(nameValuePairs==null||nameValuePairs.equals("")){	
				Log.e("error","nameValuePairs==null||nameValuePairs.equals");
				return false;
			}else{
				httPost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
				
				HttpResponse response = client.execute(httPost);
				httpResult = response.getStatusLine().getStatusCode();

				if (httpResult == HttpStatus.SC_OK) {
					HttpEntity resEntity = response.getEntity();
					if (resEntity == null) {
						Log.e("error","httpResult = 0xff000004");
						return false;
					}
					else {
						File file = null;
						FileOutputStream output = null;
						InputStream is = null;
						try {
							is = resEntity.getContent();
							byte[] buffer = new byte[1024*16];
							
							if( createDirectory(Environment.getExternalStorageDirectory().getAbsolutePath() + "/" + Util.DIR) == false ){
								Log.e("error","create directory fail!!");
								return false;
							}
							
							file = new File(Environment.getExternalStorageDirectory().getAbsolutePath() + "/" + Util.DIR, Util.MAP_FILE);
							if( file.exists() == false )
								file.createNewFile();
							else{
								file.delete();
								file.createNewFile();
							}
							output = new FileOutputStream(file);
							int rcv_byte = 0;

							while ((rcv_byte = is.read(buffer)) > 0) {
								output.write(buffer, 0, rcv_byte);
								//Debug.trace("lhr", String.format("Received : %d bytes", rcv_byte));
								SystemClock.sleep(10L);
							}
						}
						catch (Exception e) {
							Log.e("error","httpResult = 0xff000003");
							return false;
						}finally{
							if( is != null )
								is.close();
							
							if( client != null && client.getConnectionManager() != null)
								client.getConnectionManager().shutdown();
							
							if( output != null )
								output.close();
						}
						return true;
					}
				}
				else {
					Log.e("error","httpResult = 0xff000002");
					return false;
				}
			}
		}
		catch (SocketTimeoutException ste) {
			Log.e("error","httpResult = 0xff00000f");
			return false;
		}
		catch (Exception e) {
			Log.e("error","httpResult = 0xff000001");
			return false;
		}
		/*lhr end*/
	}
	
	/*lhr add*/
	private static boolean createDirectory(String path){
		 File file = new File(path);

		 try{
			 if( file.exists() == false){
				 file.mkdir();
			 }
		 }catch(Exception ex){
			 ex.printStackTrace();
			 return false;
		 }
		 
		 return true;
	}
	/*lhr end*/
	
	/**
     * SD CARD����
     * 
     */
    private void copyToSD(byte[] buffer, String FileName){
    	File dir = new File(Environment.getExternalStorageDirectory().getAbsolutePath() , Util.DIR) ;
    	dir.mkdirs() ;
    	File file = new File(dir, FileName);
    	
    	if(file.exists()){
    		file.delete();
    	}
    	
    	if (dir.canWrite()){
    		
    	}else{
    		
    	}
    	
    	try {
    		OutputStream out = new FileOutputStream(file);
    		out.write(buffer);
    		out.close();
    	}catch (IOException e) {
			e.printStackTrace();
		}
    }

	@Override
	protected boolean isRouteDisplayed() {		
		return false;
	}
	
	private ProgressDialog mCustomProgressDlg;
	 protected void showCenterProgress(){

		ProgressBar progressBar = (ProgressBar)findViewById(R.id.progress_bar) ;
		progressBar.setVisibility(View.VISIBLE) ; 
		 /*
	  mCustomProgressDlg = new ProgressDialog(this, android.R.style.Theme_Translucent);
	  mCustomProgressDlg.show();
	  mCustomProgressDlg.setContentView(R.layout.custom_progress_dialog);
	  mCustomProgressDlg.setOnKeyListener(new DialogInterface.OnKeyListener() {
	   public boolean onKey(DialogInterface dialog, int keyCode, KeyEvent event) {
	    if( keyCode == KeyEvent.KEYCODE_BACK ){
	    	BaseMapActivity.this.onBackPressed();
	     return true;
	    }
	    return false;
	   }
	  });
	  */
	 }
	 
	 protected void hideCenterProgress(){
		ProgressBar progressBar = (ProgressBar)findViewById(R.id.progress_bar) ;
		progressBar.setVisibility(View.VISIBLE) ; 
		 /*
	  if( mCustomProgressDlg != null )
	   mCustomProgressDlg.dismiss();
	   */
	 }
	
	/*lhr add*/
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		GSActivityManager.getActivityManager().addCreateActivity(this);
	}
	
	@Override
	protected void onDestroy() {
		GSActivityManager.getActivityManager().deleteCreateActivity(this);
		super.onDestroy();
	}
	
	@Override
	public void onBackPressed() {
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  

    	alt_bld.setMessage(R.string.program_terminate)  

    	.setCancelable(false)  
    	//.setIcon(R.drawable.icon)
    	
    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int which) {
				Util.programExit(BaseMapActivity.this);
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

	private OnTouchListener mTouchListener = new OnTouchListener() {
		public boolean onTouch(View view, MotionEvent event) {
			return mGestureDetector.onTouchEvent(event);
		}
	};

	protected void setDefaultLayout() {
		mApplication = (DefaultApplication)getApplicationContext();
		mGestureDetector = new GestureDetector(mGestureListener);

//		mSlideLeftIn = AnimationUtils.loadAnimation(this, R.anim.push_left_in);
//		mSlideLeftOut = AnimationUtils.loadAnimation(this, R.anim.push_left_out);
//		mSlideRightIn = AnimationUtils.loadAnimation(this, R.anim.push_right_in);
//		mSlideRightOut = AnimationUtils.loadAnimation(this, R.anim.push_right_out);
//		mSlideLeftIn.setDuration(200);
//		mSlideLeftOut.setDuration(200);
//		mSlideRightIn.setDuration(200);
//		mSlideRightOut.setDuration(200);
//
//		mViewFlipper = (ViewFlipper)findViewById(R.id.tabmenu_flipper);
//		mViewFlipper.setOnTouchListener(mTouchListener);
//		mViewFlipper.setDisplayedChild(mApplication.viewFlipperChild);
//
//		for (int i = 0; i < TAB_BUTTON_COUNT; i++) {
//			mButtons[i] = (ImageButton)findViewById(R.id.tabmenu_button_1+i);
//			mButtons[i].setId(i);
//			mButtons[i].setOnClickListener(mClickListener);
//			mButtons[i].setOnTouchListener(mTouchListener);
//			if (i == mApplication.selectedIndex)
//				mButtons[i].setBackgroundResource(TAB_BUTTON_RESOURCE_IDS[i]);
//		}
//
//		ImageButton blankButton = (ImageButton)findViewById(R.id.tabmenu_blank);
//		blankButton.setOnTouchListener(mTouchListener);
	}

	private SimpleOnGestureListener mGestureListener = new SimpleOnGestureListener() {
		private static final int SWIPE_MIN_DISTANCE = 120;
		private static final int SWIPE_MAX_OFF_PATH = 250;
		private static final int SWIPE_THRESHOLD_VELOCITY = 200;

		@Override
		public boolean onFling(MotionEvent e1, MotionEvent e2, float velocityX, float velocityY) {
			if (Math.abs(e1.getY() - e2.getY()) > SWIPE_MAX_OFF_PATH)
                return false;

			if (e1.getX() - e2.getX() > SWIPE_MIN_DISTANCE &&
				Math.abs(velocityX) > SWIPE_THRESHOLD_VELOCITY) {
				if (mViewFlipper.getDisplayedChild() == 1)
					return false;

				mViewFlipper.setInAnimation(mSlideRightIn);
				mViewFlipper.setOutAnimation(mSlideRightOut);
				mViewFlipper.showPrevious();
			}
			else if (e2.getX() - e1.getX() > SWIPE_MIN_DISTANCE &&
					Math.abs(velocityX) > SWIPE_THRESHOLD_VELOCITY) {
				if (mViewFlipper.getDisplayedChild() == 0)
					return false;

				mViewFlipper.setInAnimation(mSlideLeftIn);
				mViewFlipper.setOutAnimation(mSlideLeftOut);
				mViewFlipper.showNext();
			}
			mApplication.viewFlipperChild = mViewFlipper.getDisplayedChild();

			return false;
		}
	};

	private OnClickListener mClickListener = new OnClickListener() {
		public void onClick(View v) {
			if (v.getId() == mApplication.selectedIndex)
				return;

			Intent intent = null;

		}
	};
	
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
