package kr.co.gscaltex.gsnpoint.setting;

import java.util.ArrayList;
import java.util.List;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.card.CardMainView;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import kr.co.gscaltex.gsnpoint.util.Util;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;
import android.widget.TextView;

public class SettingLogoutView extends BaseActivity implements OnClickListener {
	private FileInfo fi = new FileInfo();

	private ImageButton set_logout_button = null;
	private TextView useridLabel = null;
	
	private String URL = Util.DATA_CONNECT;
	private int USER_LOGOUT = 99;
	private boolean m_bLogin = false;
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.settinglogout);
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this,true,false,R.string.TITLE_TYPE_SETTING_AUTOLOGIN,m_bLogin); 
		new NewMainMenu(this);

		set_logout_button = (ImageButton)findViewById(R.id.set_logout_button);
		set_logout_button.setId(0);
		set_logout_button.setOnClickListener(this);
	
		String user_id = this.fi.getSettingInfo(this, FileInfo.ID);
		useridLabel = (TextView)findViewById(R.id.useridLabel);
		useridLabel.setText(user_id);
	}
	
	public void onClick(View v) {
		switch (v.getId()) {
		case 0 : 
			String cuskey1 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_1);
			String cuskey2 = fi.getSettingInfo(getBaseContext(), FileInfo.CUSKEY_2);
			String userid = fi.getSettingInfo(getBaseContext(), FileInfo.ID);
			
			List<NameValuePair> params = new ArrayList<NameValuePair>(2);
			params.add(new BasicNameValuePair("process_code", "cardList"));
			params.add(new BasicNameValuePair("cuskey1", cuskey1));
			params.add(new BasicNameValuePair("cuskey2", cuskey2));
			params.add(new BasicNameValuePair("userid", userid));
			setParams(params);
			loadUrl(USER_LOGOUT, URL, "") ;
			break;
		}
	}
	
	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
		if(result){
  			Intent intent = new Intent(this, CardMainView.class);
  			intent.putExtra("login", false) ;
  			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
  			fi.setSettingInfo(this, "",FileInfo.AUTO_SAVE);
  			startActivity(intent);			
  			finish();
		}
			
	}
}
