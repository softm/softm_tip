package kr.co.gscaltex.gsnpoint.setting;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.DefaultApplication;
import kr.co.gscaltex.gsnpoint.Login;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;

public class SettingMainView extends BaseActivity implements OnClickListener {

	String TAG = "GS";
	private FileInfo fi = new FileInfo();
	DefaultApplication mApp ;
	
	public static final int TAB_BUTTON_COUNT = 6;
	private ImageButton[] mButtons = new ImageButton[TAB_BUTTON_COUNT];
	private boolean bAutoLogin;
	private boolean m_bLogin = false;
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.settingmain);
		
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
		m_bLogin = extras.getBoolean("login");
		
		mApp = (DefaultApplication)this.getApplicationContext();
		mApp.selectedIndex =99;
		
		new TitleView(this,true,false,R.string.TITLE_TYPE_SETTING,m_bLogin); 
		new NewMainMenu(this);
		
		int i = 0;
		mButtons[i] = (ImageButton)findViewById(R.id.set_btn01_button);i++;
		mButtons[i] = (ImageButton)findViewById(R.id.set_btn02_button);i++;
		mButtons[i] = (ImageButton)findViewById(R.id.set_btn03_button);i++;
		mButtons[i] = (ImageButton)findViewById(R.id.set_btn04_button);i++;
		mButtons[i] = (ImageButton)findViewById(R.id.set_btn05_button);i++;
		mButtons[i] = (ImageButton)findViewById(R.id.set_btn07_button);i++;
		
		for ( i = 0; i < TAB_BUTTON_COUNT; i++) {
			mButtons[i].setId(i);
			mButtons[i].setOnClickListener(this);
		}
		
		String auto_save = this.fi.getSettingInfo(this, FileInfo.AUTO_SAVE);
		if(auto_save==null||auto_save.equals("")){		
			 bAutoLogin = false;
		}else{
			 bAutoLogin = true;
		}
		setSwitchButton();
	}
	
	private void setSwitchButton() {
		if(bAutoLogin){
			 mButtons[1].setBackgroundResource(R.drawable.btn_switch_on);
			 if(m_bLogin)
				 fi.setSettingInfo(getBaseContext(), "TRUE", FileInfo.AUTO_SAVE);
		}else{
			 mButtons[1].setBackgroundResource(R.drawable.btn_switch_off);
			 if(m_bLogin)
				 fi.setSettingInfo(getBaseContext(), "", FileInfo.AUTO_SAVE);
		}
	}

	public void onClick(View v) {
		Intent intent;
		
		switch (v.getId()) {
			case 0 : 
	        	if(!m_bLogin){
		  			 intent = new Intent(this, Login.class);
		  			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		  			startActivity(intent);
		  		} else { 		
		  			 intent = new Intent(this, SettingLogoutView.class);
		  			intent.putExtra("login", m_bLogin) ;
		  			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		  			startActivity(intent);
		  		}
		         break;
			case 1 : 
				if(m_bLogin){
					setSwitchButton();
					bAutoLogin=!bAutoLogin;
				}else{
					
				}		
				break;
			case 2 : 
				if(m_bLogin){
					intent = new Intent(this, SettingPwsetView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		  			startActivity(intent);
				}
				
				break;
			case 3 : 
				if(m_bLogin){
					intent = new Intent(this, SettingMainImageView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		  			startActivity(intent);
				}
				break;
			case 4 :
				if(m_bLogin){
					intent = new Intent(this, SettingMemberUpdateView.class);
					intent.putExtra("login", m_bLogin) ;
					intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
		  			startActivity(intent);
				}
				break;				
			case 5 : 
//				intent = new Intent(this, SettingNotice.class);
				intent = new Intent(this, kr.co.gscaltex.gsnpoint.setting.AgreementTermView.class);	
				intent.putExtra("login", m_bLogin) ;
				intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
	  			startActivity(intent);
				break;
			case 6 : 
				
				break;
		
		}
	}
	
	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		
	}
}
