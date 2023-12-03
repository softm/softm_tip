package kr.go.citis.main.activity;

import kr.go.citis.main.R;
import kr.go.citis.main.common.WUtil;
import android.os.Bundle;
import android.preference.PreferenceActivity;
public final class SetupActivity extends PreferenceActivity {
		@SuppressWarnings("deprecation")
		@Override
	    public void onCreate(Bundle savedInstanceState) {
	        super.onCreate(savedInstanceState);
	 
	        addPreferencesFromResource(R.xml.settings);
	 
	    }

		@Override
		protected void onDestroy() {
			super.onDestroy();
			WUtil.setEnvironMent(this);
		}
		
}
