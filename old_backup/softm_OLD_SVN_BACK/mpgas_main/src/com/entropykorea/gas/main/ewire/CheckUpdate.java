package com.entropykorea.gas.main.ewire;

import java.util.ArrayList;

import android.content.Context;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.os.AsyncTask;

import com.entropykorea.ewire.Connectivity;
import com.entropykorea.ewire.InstallApk;
import com.entropykorea.ewire.util.Vers;
import com.entropykorea.gas.main.common.Constants;
import com.entropykorea.gas.main.common.PackageName;

public abstract class CheckUpdate {
	private Context mContext;
	private PackageName mPackageName;
	
	public CheckUpdate( Context context ) {
		this.mContext = context;
		this.mPackageName = null;
	}
	
	public CheckUpdate( Context context, PackageName packageName ) {
		this.mContext = context;
		this.mPackageName = packageName;
	}
	
	public abstract void onFinished(boolean result, PackageName packageName, String resultMessage);
	
	public void check() {
		if( !Connectivity.isConnected( mContext ) ) {
			onFinished( false, null, "Not connected" );
			return;
		}
		
		if( mThreadRunning ) {
			return;
		}
		
		new CheckUpdateTask().execute();
	}
	
	public String getVersion( String packageName ) {
		String versionName = null;
		
		try {
			PackageInfo info = mContext.getPackageManager().getPackageInfo(packageName, 0);
			versionName = info.versionName;
		} catch (PackageManager.NameNotFoundException ignored) {
		}
		
		return versionName;
	}
	
	private boolean compareVersion( String serverVersion, String localVersion ) {
		Vers version_server = new Vers(serverVersion);
		Vers version_local = new Vers(localVersion);
		
		if (version_local.compare(version_server) < 0) {
			return true;
		}
		
		return false;
	}
	
	private InstallApk.SetupInfo versionCheck( ArrayList<InstallApk.SetupInfo> setupInfoList, PackageName packageName ) {
		
		InstallApk.SetupInfo result_si = null;
		String packageVersion;
		
		for( InstallApk.SetupInfo si : setupInfoList ) {
			if( si.name.equals( packageName.getPackageCode() )) {
				
				packageVersion = getVersion( packageName.getPackageName() ); 
				
				if( packageVersion != null ) {
					if( compareVersion( si.version, packageVersion ) ) {
						result_si = si;
						return result_si;
					}
				}
			}
			
		}
	
		return result_si;
	}
	
	private PackageName mResultPackageName  = null;
	
	private boolean doCheck() {
		boolean rtn = false;
		InstallApk installApk = new InstallApk( mContext );
		PackageName[] packageNames;

		if( this.mPackageName != null ) {
			// package 하나만 확인
			packageNames = new PackageName[1];
			packageNames[0] = this.mPackageName;
		} else {
			packageNames = new PackageName[6];
			packageNames[0] = PackageName.MAIN;
			packageNames[1] = PackageName.GUM;
			packageNames[2] = PackageName.AS;
			packageNames[3] = PackageName.CHK;
			packageNames[4] = PackageName.CHG;
			packageNames[5] = PackageName.CHE;
		}
		
		
		// 서버 정보 가져옴
		ArrayList<InstallApk.SetupInfo> setupInfoList =  installApk.getSetupInfoFromUrl( Constants.getUpdateServerUrl());
		InstallApk.SetupInfo setupInfo;
		
		mResultPackageName = null;
		
		if( setupInfoList == null ) {
			return rtn;
		}
		
		
		// 설치된 버전 확인
		for( PackageName pn : packageNames ){
			setupInfo = versionCheck( setupInfoList, pn );
			if( setupInfo != null ) {
				mResultPackageName = pn;
				return true;
			}
		}

		return rtn;
	}
	
	private void doCheckEnd( boolean result ) {
		onFinished(result, mResultPackageName, mResultMessage);
	}
	
	boolean mThreadRunning = false;
	String mResultMessage = new String();
	
	class CheckUpdateTask extends AsyncTask<Void, Void, Boolean> {

		@Override
		protected Boolean doInBackground(Void... params) {
			mThreadRunning = true;
			return doCheck();
		}

		@Override
		protected void onPostExecute(Boolean result) {
			mThreadRunning = false;
			doCheckEnd(result);
			super.onPostExecute(result);
		}
	}
	

}
