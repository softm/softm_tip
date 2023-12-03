package kr.co.gscaltex.gsnpoint.card;

import kr.co.gscaltex.gsnpoint.BaseActivity;
import kr.co.gscaltex.gsnpoint.GSAppHelper;
import kr.co.gscaltex.gsnpoint.Login;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.setting.SettingMainView;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;

public class CardFirstResisterView extends BaseActivity implements OnClickListener {
	private boolean m_bLogin = false;
	
	private ImageButton imgBtnNewCard, btnLogin, btnSet, btnReset, btnHelp= null;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.newcard);
		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new CardTitleView(this,true,true,false,true,m_bLogin);
		new CardTabpageView(this, m_bLogin);
		new NewMainMenu(this);

		imgBtnNewCard = (ImageButton)findViewById(R.id.newcard_button);
		imgBtnNewCard.setOnClickListener(this); 	
		
		btnLogin = (ImageButton)findViewById(R.id.btn_login);
		btnLogin.setOnClickListener(this); 
		
		btnSet = (ImageButton)findViewById(R.id.set_button);
		btnSet.setOnClickListener(this); 
		
		btnReset = (ImageButton)findViewById(R.id.reset_button);
		btnReset.setOnClickListener(this);
		
		btnHelp = (ImageButton)findViewById(R.id.help_button);
		btnHelp.setOnClickListener(this);
		appHelper = new GSAppHelper(this, R.string.TITLE_TYPE_CARD, R.id.help_button);
		appHelper.add(findViewById(R.id.set_button           ),R.drawable.guide_guide01_ex01,GSAppHelper.POSITION_RIGHT_BOTTOM,-4,-4,1,1);
		appHelper.add(findViewById(R.id.reset_button         ),R.drawable.guide_guide01_ex02,GSAppHelper.POSITION_RIGHT_BOTTOM,-4,-4,1,1);
		appHelper.add(findViewById(R.id.newcard_button       ),R.drawable.guide_guide02_ex03,GSAppHelper.POSITION_RIGHT_TOP,-3,-3);			
	}
	
	public void onClick(View v) {
		switch (v.getId()) {
		case R.id.btn_login:
		case R.id.newcard_button: 
			Intent intent = new Intent(this, Login.class);
			intent.putExtra("login", m_bLogin);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);
			break;
			
		case R.id.set_button:
			intent = new Intent(this, SettingMainView.class);
			intent.putExtra("login", m_bLogin);
			intent.setFlags(intent.FLAG_ACTIVITY_NO_USER_ACTION);
			startActivity(intent);	
			break;
			
		case R.id.reset_button:
			
			break;
			
		case R.id.help_button:
			this.getAppHelper().showHelp();
			break;
			
		}
	}
	
	@Override
	protected void httpResult(int what, boolean result, String kind) {
		// TODO Auto-generated method stub
			
	}
}
