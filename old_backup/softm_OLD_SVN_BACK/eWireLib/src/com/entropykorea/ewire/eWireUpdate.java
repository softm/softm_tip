package com.entropykorea.ewire;

import android.content.Context;
import android.os.AsyncTask;
import android.os.Handler;
import android.os.Message;

import com.entropykorea.ewire.dialog.eWireTransDialog;
import com.entropykorea.ewire.eWireData.ImportTask;
import com.entropykorea.ewire.eWireData.onFinished;
import com.entropykorea.ewire.eWireTrans.TransThread;

public abstract class eWireUpdate {

	public final static String DEFAULT_DISPLAYMESSAGE = "내려받기 중입니다.\n잠시만 기다리십시요"; // default message
	
	private Context mContext;
	private eWireTransDialog mProgressDialog;
	
	InstallApk mInstallApk = null;
	
	String updateUrl, packageName, versionNumber, downloadPath;
	private String displaymessage = DEFAULT_DISPLAYMESSAGE;
	
	public eWireUpdate(Context context) {
		this.mContext = context;
		mInstallApk = new InstallApk(context);
	}
	
	public abstract void onFinished(boolean result, String resultMessage);

	public interface onFinished {
		void onFinished(boolean result, String resultMessage);
	}

	// checkVersion
	
	public void checkVersion( String updateUrl, String packageName, String versionNumber ) {
		this.updateUrl = updateUrl;
		this.packageName = packageName;
		this.versionNumber = versionNumber;
		
		if (mThreadRunning == true)
			return;
		//showDialog( 1 );
		new CheckVersionTask().execute();
	}
	
	private boolean _checkVersion() {
		return mInstallApk.checkVersion( this.updateUrl, this.packageName, this.versionNumber );
	}
	
	private void _checkVersionEnd( Boolean result ) {
		String version = "";
		if( mInstallApk.mSetupInfo != null ) {
			version = mInstallApk.mSetupInfo.version;
		}
		//hideDialog();
		onFinished( result, version );
	}

	boolean mThreadRunning = false;
	String mResultMessage = new String();
	
	class CheckVersionTask extends AsyncTask<Void, Void, Boolean> {

		@Override
		protected Boolean doInBackground(Void... params) {
			mThreadRunning = true;
			return _checkVersion();
		}

		@Override
		protected void onPostExecute(Boolean result) {
			mThreadRunning = false;
			_checkVersionEnd(result);
			super.onPostExecute(result);
		}
	}
	
	// dialog (download apk)
	
	public void showDialog(int type) {
		if( mProgressDialog != null ) {
			hideDialog();
		}
		mProgressDialog = new eWireTransDialog(mContext, type, false, true ); 
		mProgressDialog.setMessage(displaymessage);
		mProgressDialog.show();
	}
	
	public void hideDialog() {
		if( mProgressDialog != null ) {
			mProgressDialog.hide();
			mProgressDialog.dismiss();
			mProgressDialog = null;
		}
	}
	
	// set dialog progress
	public void setProgress(Integer current, Integer total) {
		
		mProgressDialog.setProgressBar(current, total);
		//eWireLog.d("EWIRE", "PP:" + current + " / " + total );
	}
	
	// downloadApk
	DownloadApkThread mDownloadApkThread;

	public void downloadApk( String updateUrl, String packageName, String downloadPath ) {
		this.updateUrl = updateUrl;
		this.packageName = packageName;
		this.downloadPath = downloadPath;
		
		if (mThreadRunning == true)
			return;
		
		showDialog( 2 );
		mResultMessage = "";
		mDownloadApkThread = new DownloadApkThread();
		mDownloadApkThread.start();
		mThreadRunning = true;
	}
	
	private boolean _downloadApk() {
		mInstallApk.setOnPublishProgress(cb_publishprogress);
		return mInstallApk.downloadApk( this.updateUrl, this.packageName, this.downloadPath );
	}
	
	private void _downloadApkEnd( Boolean result ) {
		mThreadRunning = false;
		hideDialog();
		if( result ) {
			mResultMessage = mInstallApk.mDownloadFilename;
		}
		onFinished( result, mResultMessage );
	}
	
	class DownloadApkThread extends Thread {
		public void run() {
			Message msg = mDownloadApkHandler.obtainMessage();

			if( _downloadApk() ) {
				msg.what = 0; // 완료
			} else {
				msg.what = 1; // 에러
			}
			mDownloadApkHandler.sendMessage(msg);
		}
	}
	
	Handler mDownloadApkHandler = new Handler() {
		public void handleMessage(Message msg) {

			switch( msg.what )
			{
			case 0: // 완료
				_downloadApkEnd( true );
				break;
			case 1: // 에러
				_downloadApkEnd( false );
				break;
			case 9: // update progress
				setProgress( msg.arg1, msg.arg2 );
				break;
			}

		}
	};
		
	InstallApk.OnPublishProgress cb_publishprogress = new InstallApk.OnPublishProgress() {
		
		@Override
		public void OnPublichProgress(Integer value) {
			Message msg = mDownloadApkHandler.obtainMessage();
			msg.what = 9; 
			msg.arg1 = value;
			msg.arg2 = 100;
			mDownloadApkHandler.sendMessage(msg);
		}
	};
	
	
	public boolean installApk( String apkFilename ) {
		return mInstallApk.installApk( apkFilename );
	}

	// util
	
	public boolean getNonMarket() {
		return mInstallApk.getNonMarket();
	}
	
	public void setNonMarket() {
		mInstallApk.setNonMarket();
	}
}
