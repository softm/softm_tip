package kr.co.gscaltex.gsnpoint.setting;

import java.util.HashMap;

import kr.co.gscaltex.gsnpoint.BaseWebActivity;
import kr.co.gscaltex.gsnpoint.NewMainMenu;
import kr.co.gscaltex.gsnpoint.R;
import kr.co.gscaltex.gsnpoint.TitleView;
import kr.co.gscaltex.gsnpoint.util.FileInfo;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ImageButton;
import android.widget.ImageView;

public class AgreementTermView extends BaseWebActivity implements OnClickListener{
	private boolean m_bLogin = false;
	
	private ImageView ivLoadingImage = null ;
	private ImageButton mBtnOk =null;
	private FileInfo fi = new FileInfo();

	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		//setContentView(R.layout.web_viewer);
		setContentView(R.layout.agreementdetailview);
		
		String URL = fi.getSettingInfo(getBaseContext(),FileInfo.AGREEMENT_URL); // 약관동의 jsp url

		Bundle extras = getIntent().getExtras();
		if(extras!=null)
			m_bLogin = extras.getBoolean("login");
		
		new TitleView(this,false,false,R.string.TITLE_TYPE_SETTING_JOIN, m_bLogin); 
		new NewMainMenu(this);

		ivLoadingImage = (ImageView)findViewById(R.id.loading_image) ;
		//ivLoadingImage.setBackgroundResource(R.drawable.login_blank) ;
		//ivLoadingImage.setVisibility(ImageView.VISIBLE) ;
		
		mBtnOk = (ImageButton)findViewById(R.id.btn_ok);
		mBtnOk.setOnClickListener(this);
		loadUrl(URL);
	} 

	protected void webViewEvent(int what, boolean result, HashMap<String,Object> param) {
		// TODO Auto-generated method stub
		switch(what) {
		case 0 : 
			ivLoadingImage.setVisibility(ImageView.GONE) ;
			break ;
			
		case 1 :
			break ;  
			
		case 900 : 
			 break ;
		}
		
	}

	@Override
	public void onClick(View v) {
		switch (v.getId()) {
		
		case R.id.btn_ok:  // 약관동의 취소 - 버튼
			finish();
			break;
		default:
			break;
		}
		
	}
}