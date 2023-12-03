package kr.co.gscaltex.gsnpoint;

import java.io.BufferedReader;
import java.io.ByteArrayInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.security.MessageDigest;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.jar.Attributes;
import java.util.jar.JarFile;
import java.util.zip.ZipEntry;

import kr.co.gscaltex.gsnpoint.util.Base64Encoder;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.Util;

import org.apache.http.NameValuePair;
import org.apache.http.impl.auth.DigestSchemeFactory;
import org.apache.http.message.BasicNameValuePair;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.ApplicationInfo;
import android.net.wifi.WifiManager;
import android.os.Bundle;
import android.os.Handler;
import android.webkit.CookieManager;
import android.webkit.CookieSyncManager;
import android.widget.ProgressBar;

public class GSnPointActivity extends BaseActivity {
	
	private String TAG = "GS" ; 
	
	private WifiManager wifiManager; 
	private FileInfo fi = new FileInfo();
	private Handler handler = new Handler();
	private ProgressBar progress_bar;
 
	private final String testClass = "classes.dex";
	private boolean bSetPwd = false;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.main);

		progress_bar =(ProgressBar)findViewById(R.id.progress_bar);
		
		String sha_check = fi.getSettingInfo(getBaseContext(), FileInfo.SHA1_CHECK);
		if(sha_check==null||sha_check.equals("")){
			//무결성 검사해야 함
			try {
				checkIntegrity();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		} else {
			
			/*배너파일 삭제*/
			deleteCacheBannerFile() ;
			serverStart();
			intro();
			deleteCookie() ; 
			 
			((DefaultApplication)getApplicationContext()).setCardRefresh(false) ;
		}
		
	}

	
	public void deleteCacheBannerFile() {
		 
		//Debug.trace(TAG,"deleteCacheBannerFile ") ;
		String xmlFile = "banner.xml";
		StringBuffer sb = new StringBuffer() ;
		Context context = getBaseContext() ;
		File file = context.getFileStreamPath(xmlFile);
		
		if(file.exists()){
			file.delete() ;
			//Debug.trace(TAG,"deleteCacheBannerFile work: " + file.getAbsolutePath()) ;
			
		}
	}
	
	protected void deleteCookie() {
		//Debug.trace(TAG,"+++ deleteCookie"  ) ;
		CookieSyncManager.createInstance(this);
		
		new Thread(new Runnable() {
			
			public void run() {
				// TODO Auto-generated method stub
				CookieManager cookieManager = CookieManager.getInstance();
				cookieManager.removeAllCookie();				
			}			
		}).start() ;
	}
	
	public void intro() {
		
		Thread r = new Thread(new Runnable() {
			public void run() {
				try {
					
					String auto_save = fi.getSettingInfo(getBaseContext(), FileInfo.AUTO_SAVE);
					String userid = fi.getSettingInfo(getBaseContext(), FileInfo.ID);
					DefaultApplication mApp = (DefaultApplication)getApplicationContext() ;
					
					
					
					if(auto_save==null||auto_save.equals("")){
						//Debug.trace("test","have been not auto save");
						mApp.orgLoginFlag = 0 ;
						if(userid==null||userid.equals("")){
						}else{
							fi.setSettingInfo(getBaseContext(), "", FileInfo.ID);
							fi.setSettingInfo(getBaseContext(), "", FileInfo.PWD);
						}
					}else{
						//Debug.trace("test","have been auto save");
						mApp.orgLoginFlag = 1 ;
					}
					
					wifiManager = (WifiManager)getBaseContext().getSystemService(Context.WIFI_SERVICE);
			        
					String check = fi.getSettingInfo(getBaseContext(), FileInfo.WIFI_CHECK);
					
					if(wifiManager.isWifiEnabled()){
						goMain();
					}else{			
						if(check==null||check.equals("")){							
							handler.post(confirmRunnable);
						}else{
							goMain();
						}
					}
					
				} catch (Exception e) {}
			}
		});
		r.start();
	}
	
	private void checkIntegrity() throws IOException{
		String packageName = getPackageName();
		
		//Debug.trace(TAG,"checkIntegrity: packageName is " + packageName) ;
		// Get classes.dex file signature 
		ApplicationInfo ai = getApplicationInfo(); 
		String source = ai.sourceDir; 
		 
		//Debug.trace(TAG,"checkIntegrity: source is " + source) ;
		
		java.util.jar.JarFile jar = null;
		java.util.jar.Manifest mf = null;
		
		try {
			jar = new JarFile(source);
			mf = jar.getManifest(); 
			
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} 
		Map<String, Attributes> map = mf.getEntries(); 
		 
		Attributes a = map.get("classes.dex"); 
		String sha1 = (String)a.getValue("SHA1-Digest"); 
		
		//Debug.trace(TAG,"checkIntegrity: sha1 is " + sha1) ;
		
		ZipEntry zipEntry = jar.getJarEntry(testClass);		
		InputStream fis = jar.getInputStream(zipEntry);
		
		byte[] compare = getSHA1FromFileContent(fis); 
		String compageSha1 = Base64Encoder.encode(compare);
		
		//Debug.trace(TAG,"checkIntegrity: compageSha1 is " + compageSha1) ;
		
		if(compageSha1.equals(sha1)){
			fi.setSettingInfo(getBaseContext(), "1", FileInfo.SHA1_CHECK);
			
			/*배너파일 삭제*/
			deleteCacheBannerFile() ;
			serverStart();
			intro();
			deleteCookie() ; 
			 
			((DefaultApplication)getApplicationContext()).setCardRefresh(false) ;
			
		}else{
			hideCenterProgress();
			handler.post(integrityErrorRunnable);
		}
		
		fis.close();
	}
	
	
	private static byte[] getSHA1FromFileContent(InputStream fis) 
    { 
        try 
        { 
        	MessageDigest md = MessageDigest.getInstance("SHA1");
		    
		    byte[] dataBytes = new byte[1024];
		 
		    int nread = 0; 
		 
		    while ((nread = fis.read(dataBytes)) != -1) {
		      md.update(dataBytes, 0, nread);
		    };
		 
		    byte[] mdbytes = md.digest();
            
            return mdbytes; 
        } 
        catch (Exception e) 
        { 
            return null; 
        } 
    } 
	
	private Runnable integrityErrorRunnable = new Runnable(){
		public void run() {
			integrityError();
		}		
	};
	
	private Runnable confirmRunnable = new Runnable(){
		public void run() {
			confirm();
		}		
	};
	
	
	private void integrityError(){
		AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  

    	alt_bld.setMessage("유효하지 않은 어플리케이션 입니다.")  
    	.setCancelable(false)
    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int which) {				
				Util.programExit(GSnPointActivity.this);
			}
    	});

    	
    	AlertDialog alert = alt_bld.create();
    	alert.setTitle(R.string.alert_str);
    	alert.show(); 
    }

	/**
	 * confirm: 3G망 사용자에게 알려주기
	 */
	private void confirm(){
    	
    	AlertDialog.Builder alt_bld = new AlertDialog.Builder(this);  

    	alt_bld.setMessage("3G네트워크로 접속되었습니다.\n데이터 통화료가 부과됩니다.")  
    	.setCancelable(false)
    	.setPositiveButton("확인", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int which) {				
				goMain();
			}
    	})
    	
    	.setNeutralButton("다시보지 않기", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface paramDialogInterface,
					int paramInt) {
				doIDONWANTSEEAGAIN();
			} 
    	});	
    	
    	AlertDialog alert = alt_bld.create();
    	alert.setTitle(R.string.alert_str);
    	alert.show(); 
    }
	
	private void doIDONWANTSEEAGAIN(){
		fi.setSettingInfo(getBaseContext(), FileInfo.IDONWANTSEEAGAIN, FileInfo.WIFI_CHECK);
		goMain();
	}
	
	private void goMain() {
		Thread r = new Thread(new Runnable() {
			public void run() {	
				try {
					Thread.sleep(1000);
					viewMain();
				} catch (InterruptedException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}				
			}
		});
		r.start();
	}
	
	
	private void viewMain(){
		String set_pwd = this.fi.getSettingInfo(this, FileInfo.PASSWORD_SET);
		String app_pwd = this.fi.getSettingInfo(this, FileInfo.PASSWORD_MYAPP);
		
		if(set_pwd.equals("TRUE")){
			//Debug.trace("test","have been password setting");
			bSetPwd = true;
		}
		
		if(bSetPwd && !(app_pwd.equals(""))){
			//Debug.trace(TAG, "change to Card Main Activity from Intro");
			Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.setting.SettingPwsetCheckView.class);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			intent.putExtra("login", false) ;			
			startActivity(intent);
			finish();
			
		}else{
			//Debug.trace(TAG, "change to Card Main Activity from Intro");
			Intent intent = new Intent(this, kr.co.gscaltex.gsnpoint.card.CardMainView.class);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			intent.putExtra("card_refresh", false) ;
			intent.putExtra("login", false) ;			
			startActivity(intent);
			finish();
		}
	}
	
	private void serverStart() {
		
		Thread r = new Thread(new Runnable() {
			public void run() {

				List<NameValuePair> params = new ArrayList<NameValuePair>(2);
				params.add(new BasicNameValuePair("process_code", "startUp"));
				setParams(params);
				loadUrl(R.string.SERVER_START, Util.DATA_CONNECT,"") ;
			}
		});
		r.start();
	}


	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		//Debug.trace(TAG, "httpResult" + "[" + what + "](" + result + ")") ;
		switch(what) {
		case R.string.SERVER_START :
			//Debug.trace(TAG,"httpResult SERVER_START:" + result) ;
			saveStartUp();
			break ;
		}
	}
	
	private boolean saveStartUp(){
		//Debug.trace(TAG, "saveStartUp .....") ;
		String xml = getString();
		InputStream is = new ByteArrayInputStream(xml.getBytes());	
		String readLine = "";
		BufferedReader br = new BufferedReader(new InputStreamReader(is));
		
		int from = 0;
		int to = 0;
		String loginUrl = "";
		String storeListUrl = "";
		String storeDetailUrl = "";
		String guideUrl = "";
		String memberUpdateUrl = "";
		String agreementUrl = "";
		
		try{
			while(((readLine = br.readLine()) != null)) {
				
				from = readLine.indexOf("<result>", 0);
				if (from!=-1){
					from = from+"<result>".length();
					to = readLine.indexOf("</result>", from);					
					result_tag = readLine.substring(from, to).trim();
				}
				
				from = readLine.indexOf("<err>", 0);
				if (from!=-1){
					from = from+"<err>".length();
					to = readLine.indexOf("</err>", from);					
					error = readLine.substring(from, to).trim();
				}
				
				from = readLine.indexOf("<loginUrl>", 0);
				if (from!=-1){
					from = from+"<loginUrl>".length();
					to = readLine.indexOf("</loginUrl>", from);					
					loginUrl = readLine.substring(from, to).trim();
				}
				
				from = readLine.indexOf("<loginUrl>", 0);
				if (from!=-1){
					from = from+"<loginUrl>".length();
					to = readLine.indexOf("</loginUrl>", from);					
					loginUrl = readLine.substring(from, to).trim();
				}
				
				from = readLine.indexOf("<storeListUrl>", 0);
				if (from!=-1){
					from = from+"<storeListUrl>".length();
					to = readLine.indexOf("</storeListUrl>", from);					
					storeListUrl = readLine.substring(from, to).trim();
				}
				from = readLine.indexOf("<storeDetailUrl>", 0);
				if (from!=-1){
					from = from+"<storeDetailUrl>".length();
					to = readLine.indexOf("</storeDetailUrl>", from);					
					storeDetailUrl = readLine.substring(from, to).trim();
				}
				from = readLine.indexOf("<guideUrl>", 0);
				if (from!=-1){
					from = from+"<guideUrl>".length();
					to = readLine.indexOf("</guideUrl>", from);					
					guideUrl = readLine.substring(from, to).trim();
				}
				// softm 추가 
				from = readLine.indexOf("<agreementUrl>", 0);
				if (from!=-1){
					from = from+"<agreementUrl>".length();
					to = readLine.indexOf("</agreementUrl>", from);					
					agreementUrl = readLine.substring(from, to).trim();
				}
				from = readLine.indexOf("<memberUpdateUrl>", 0);
				if (from!=-1){
					from = from+"<memberUpdateUrl>".length();
					to = readLine.indexOf("</memberUpdateUrl>", from);					
					memberUpdateUrl = readLine.substring(from, to).trim();
				}
			}
			
			fi.setSettingInfo(getBaseContext(), loginUrl, FileInfo.LOGIN_URL);
			fi.setSettingInfo(getBaseContext(), storeListUrl, FileInfo.STORE_URL);
			
			fi.setSettingInfo(getBaseContext(), storeDetailUrl, FileInfo.STORE_DETAIL_URL);
			fi.setSettingInfo(getBaseContext(), guideUrl, FileInfo.GUIDE_URL);
			fi.setSettingInfo(getBaseContext(), agreementUrl, FileInfo.AGREEMENT_URL);
			fi.setSettingInfo(getBaseContext(), memberUpdateUrl, FileInfo.MEMBER_UPDATE_URL);
			
			//Debug.trace(TAG, "loginUrl------------->"+loginUrl);
			//Debug.trace(TAG, "storeListUrl------------->"+storeListUrl);
			//Debug.trace(TAG, "storeDetailUrl------------->"+storeDetailUrl);
			//Debug.trace(TAG, "guideUrl------------->"+guideUrl);
			//Debug.trace(TAG, "agreementUrl------------->"+agreementUrl);
			//Debug.trace(TAG, "memberUpdateUrl------------->"+memberUpdateUrl);
			
			return true;
					
		}catch(IOException e){
			return false;
		}
	}
	
	

	
}