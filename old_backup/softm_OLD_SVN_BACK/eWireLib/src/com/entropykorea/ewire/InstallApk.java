package com.entropykorea.ewire;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.StringWriter;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.util.ArrayList;
import java.util.Properties;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.transform.OutputKeys;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;

import org.w3c.dom.Document;
import org.w3c.dom.NodeList;

import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.Build;
import android.provider.Settings;
import android.util.Log;

import com.entropykorea.ewire.util.Vers;

public class InstallApk {

	//public static final String TAG = "EWIRE";
	public String APP_NAME = "main";

	Context mContext;
	
	ArrayList<SetupInfo> mSetupInfoList = null;
	SetupInfo mSetupInfo = null;
	
	String mCurrentVersion = "";
	public String mDownloadFilename = "";

	public interface OnPublishProgress {
		void OnPublichProgress(Integer value);
	}

	private OnPublishProgress callbackOnPublishProgress;

	public void setOnPublishProgress(OnPublishProgress callback) {
		callbackOnPublishProgress = callback;
	}

	public class SetupInfo {
		public String name = "";
		public String version = "";
		public String url = "";
	}

	public InstallApk(Context ctx) {
		this.mContext = ctx;
		mSetupInfo = new SetupInfo();
	}

	public InstallApk(Context ctx, String name) {
		this.mContext = ctx;
		mSetupInfo = new SetupInfo();
		setAppName(name);
	}

	private void setAppName(String name) {
		this.APP_NAME = name;
	}

	private void showLog( String str ) {
		eWireLog.d(str);
	}
	
	public boolean checkVersion(String url, String name, String ver) {
		boolean rtn = false;
		this.mCurrentVersion = ver;
		this.APP_NAME = name;
		

		// download setup.xml & parse
		mSetupInfoList = getSetupInfoFromUrl(url);
		if ( mSetupInfoList == null ) {
			showLog("getSetupInfoFromUrl : FAIL");
			return rtn;
		}
		
		mSetupInfo = findName( mSetupInfoList, name );
		if( mSetupInfo == null ) {
			showLog("can't find name : FAIL");
			return rtn;
		}

		// String ver = mContext.getResources().getString(R.string.app_version);
		Vers version_this = new Vers(mCurrentVersion);
		Vers version_down = new Vers(mSetupInfo.version);

		// compare version
		if (version_this.compare(version_down) < 0) {
			showLog("version high");
			rtn = true;
		}

		return rtn;
	}

	public boolean getNonMarket() {
		int result = Settings.Secure.getInt(mContext.getContentResolver(),
				Settings.Secure.INSTALL_NON_MARKET_APPS, 0);
		if (result == 0) {
			return false;
		}
		return true;
	}

	public void setNonMarket() {
		Intent intent = new Intent();
		intent.setAction(Settings.ACTION_APPLICATION_SETTINGS);
		mContext.startActivity(intent);
	}

	public boolean installApk(String fn) {
		// install apk
		File apkFile = new File(fn);
		Intent intent = new Intent(Intent.ACTION_VIEW);
		intent.setDataAndType(Uri.fromFile(apkFile),
				"application/vnd.android.package-archive");
		mContext.startActivity(intent);

		return true;
	}
	
	public boolean downloadApk(String url, String name, String downloadPath ) {
		boolean rtn = false;
		this.APP_NAME = name;
		mDownloadFilename = "";

		// download setup.xml & parse
		mSetupInfoList = getSetupInfoFromUrl(url);
		if ( mSetupInfoList == null ) {
			showLog("getSetupInfoFromUrl : FAIL");
			return rtn;
		}
		
		mSetupInfo = findName( mSetupInfoList, name );
		if( mSetupInfo == null ) {
			showLog("can't find name : FAIL");
			return rtn;
		}
		
		mDownloadFilename = downloadPath + File.separator + name + "." + mSetupInfo.version + ".apk";
		
		return downloadApk( mSetupInfo.url, mDownloadFilename );
	}

	public boolean downloadApk(String url, String fn) {
		boolean rtn = false;

		try {
			URL urlurl = new URL(url);
			URLConnection urlc = urlurl.openConnection();

			InputStream is = new URL(url).openStream();

			int lenghtOfFile = urlc.getContentLength();
			showLog("Lenght of file: " + lenghtOfFile);

			File file = new File(fn);
			if (file.isFile())
				file.delete();
			OutputStream os = new FileOutputStream(file);

			long total = 0;

			byte[] buffer = new byte[4096];
			int c = 0;
			while ((c = is.read(buffer)) != -1) {
				total += c;
				// publishing the progress....
				if (callbackOnPublishProgress != null) {
					callbackOnPublishProgress
							.OnPublichProgress((int) (total * 100 / lenghtOfFile));
				}
				os.write(buffer, 0, c);
			}
			os.flush();
			os.close();
			is.close();

			rtn = true;
		} catch (MalformedURLException e) {
			e.printStackTrace();
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}

		return rtn;
	}

	public String getApkUrl() {
		return mSetupInfo.url;
	}

	public SetupInfo findName( ArrayList<SetupInfo> setupInfoList, String name) {
		SetupInfo setupInfoResult = null;
		for( SetupInfo setupInfo : setupInfoList ) {
			if( setupInfo.name.equals(name) ) {
				setupInfoResult = setupInfo;
			}
		}
		return setupInfoResult;
	}
	
	public ArrayList<SetupInfo> getSetupInfoFromUrl(String url) {
		ArrayList<SetupInfo> setupInfoList =  null;

		try {
			setupInfoList = new ArrayList<SetupInfo>();
			InputStream is = new URL(url).openStream();

			DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
			DocumentBuilder db = dbf.newDocumentBuilder();
			Document document = db.parse(is);

			// froyo 이상의 경우만 동작함
			if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.FROYO) {
				//showLog(documentToString(document));
			}

			NodeList nl_info = document.getElementsByTagName("info");
			NodeList nl_name = document.getElementsByTagName("name");
			NodeList nl_version = document.getElementsByTagName("version");
			NodeList nl_url = document.getElementsByTagName("url");
			

			for (int i = 0; i < nl_info.getLength(); i++) {
				String s_name = nl_name.item(i).getFirstChild().getNodeValue();
				String s_version = nl_version.item(i).getFirstChild()
						.getNodeValue();
				String s_url = nl_url.item(i).getFirstChild().getNodeValue();
				
				SetupInfo setupInfo = new SetupInfo();
				setupInfo.name = s_name;
				setupInfo.version = s_version;
				setupInfo.url = s_url;
				
				setupInfoList.add( setupInfo );
			}

			is.close();

		} catch (Exception e) {
			e.printStackTrace();
			setupInfoList = null;
		}

		return setupInfoList;
	}

	/**
	 * 2.1 에서는 정상작동하지 않음 Since: API Level 8
	 * 
	 * @param doc
	 * @return
	 */
	public String documentToString(Document doc) {

		TransformerFactory trf = TransformerFactory.newInstance();
		String xmlStr = "";

		try {
			StringWriter sw = new StringWriter();
			Properties output = new Properties();

			output.setProperty(OutputKeys.INDENT, "yes");
			output.setProperty(OutputKeys.ENCODING, "UTF-8");

			Transformer transformer = trf.newTransformer();
			transformer.setOutputProperties(output);
			transformer.transform(new DOMSource(doc), new StreamResult(sw));
			xmlStr = sw.getBuffer().toString();
		} catch (Exception e) {
		}
		return xmlStr;
	}

}
