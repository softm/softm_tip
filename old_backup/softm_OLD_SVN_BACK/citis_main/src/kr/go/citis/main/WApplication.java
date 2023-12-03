package kr.go.citis.main;

import java.util.HashMap;

import kr.go.citis.lib.AppContext;
import kr.go.citis.lib.Constant;
import kr.go.citis.lib.DefaultApplication;
import kr.go.citis.lib.Util;
import kr.go.citis.lib.Var;
import android.os.Handler;
/**
 * WApplication
 * @author softm 
 */
public class WApplication extends DefaultApplication {

	public static final String TAG = Constant.LOG_TAG;

	public static WApplication mInstance = null;
	public Handler mHandler = new Handler();

	HashMap<String, Object> mStorage = new HashMap<String, Object>();
	
	@Override
	public void onCreate() {
		Util.i(TAG, "Application:Create ###############################");
		mInstance = this;
		super.onCreate();
	}

	@Override
	public void onTerminate() {
		Util.i(TAG, "Application:Terminate ############################");
		super.onTerminate();
	}

	protected void onInitDataBase() {
	}
	
	public String getUserId() {
		Var var = AppContext.getValue("VAR");
		return var.USER_ID;
	}
}



