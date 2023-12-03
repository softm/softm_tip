package com.entropykorea.gas.main.common;

import java.util.HashMap;
import java.util.Map.Entry;

import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.content.pm.PackageManager.NameNotFoundException;

public class RunActivity {
	
	public static boolean runActivity( Context context, PackageName packageName ) {
		if( isInstalledApplication( context, packageName.getPackageName() ) ) {
			Intent intent = new Intent();
			intent.setClassName( packageName.getPackageName(), packageName.getClassName() );
			context.startActivity( intent );
			return true;
		} 
		return false;
	}
	
	public static boolean runActivity( Context context, PackageName packageName, HashMap<String, String> putExtra ) {
		if( isInstalledApplication( context, packageName.getPackageName() ) ) {
			Intent intent = new Intent();
			intent.setClassName( packageName.getPackageName(), packageName.getClassName() );
			for( Entry<String, String> e : putExtra.entrySet() ) {
				intent.putExtra(e.getKey(), e.getValue());
			}
			context.startActivity( intent );
			return true;
		} 
		return false;
	}

	public static boolean isInstalledApplication(Context context, String packageName) {
		PackageManager pm = context.getPackageManager();

		try {
			pm.getApplicationInfo(packageName, PackageManager.GET_META_DATA);
		} catch (NameNotFoundException e) {
			e.printStackTrace();
			return false;
		}
		return true;
	}
	
}
