package kr.co.gscaltex.gsnpoint.setting;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.Debug;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;

public class SettingPwsetView extends BaseActivity implements OnClickListener {
	private String TAG = "SettingPwsetView";
	private FileInfo fi = new FileInfo();
		
	private boolean bSetPwd=true;
	private boolean m_bLogin = false;
	private ImageButton mSwitchButton = null;
	private ImageButton mSettingPwd= null;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.settingpwset);
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this,true,false,R.string.TITLE_TYPE_SETTING_PASSWORD,m_bLogin); 
		new NewMainMenu(this);

		mSettingPwd = (ImageButton)findViewById(R.id.pwset_btn02_button);
		mSettingPwd.setId(0);
		mSettingPwd.setOnClickListener(this);
		
		mSwitchButton = (ImageButton)findViewById(R.id.switch_btn02_button);	
		mSwitchButton.setId(1);
		mSwitchButton.setOnClickListener(this);
		
		String set_pwd = this.fi.getSettingInfo(this, FileInfo.PASSWORD_SET);
		if(set_pwd==null||set_pwd.equals("")){
			bSetPwd = false;
		}else if(set_pwd.equals("TRUE")){
			bSetPwd = true;
		}
		
		setSwitchButton();
	}
	
	private void setSwitchButton() {
		if(bSetPwd){
			mSwitchButton.setBackgroundResource(R.drawable.btn_switch_on);
			 //if(m_bLogin)
				 fi.setSettingInfo(getBaseContext(), "TRUE", FileInfo.PASSWORD_SET);
		}else{
			mSwitchButton.setBackgroundResource(R.drawable.btn_switch_off);
			// if(m_bLogin)
				 fi.setSettingInfo(getBaseContext(), "", FileInfo.PASSWORD_SET);
		}
	}
	public void onClick(View v) {
		switch (v.getId()) {
		case 0 : 
			Intent intent = new Intent(this, SettingPwsetDetailView.class);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
  			startActivity(intent);
			break;
		case 1 : 
			setSwitchButton();
			bSetPwd=!bSetPwd;
			break;
		}
	}
	
	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		//Debug.trace(TAG, "httpResult" + "[" + what + "](" + result + ")") ;
		
	}
}
